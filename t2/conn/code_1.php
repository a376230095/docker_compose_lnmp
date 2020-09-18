<?php
error_reporting(E_ALL ^ E_NOTICE); 
session_start();
$name=htmlspecialchars($_GET["name"]);
$genkey=rand(1111111, 9999999);
$action=$_GET["action"];

if($action=="codex"){
	$str=$_GET["str"];
	$_SESSION["CmsCode"]=$str;
	die(xcode($str,'ENCODE',$str,0));
}
function xcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {   
    $ckey_length = 4;   
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);   
    $keya = md5(substr($key, 0, 16));   
    $keyb = md5(substr($key, 16, 16));   
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):substr(md5(microtime()), -$ckey_length)) : '';    
    $cryptkey = $keya.md5($keya.$keyc);   
    $key_length = strlen($cryptkey);   
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
    $string_length = strlen($string);   
    $result = '';   
    $box = range(0, 255);   
    $rndkey = array();     
    for($i = 0; $i <= 255; $i++) {   
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
    }    
    for($j = $i = 0; $i < 256; $i++) {   
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;   
        $tmp = $box[$i];   
        $box[$i] = $box[$j];   
        $box[$j] = $tmp;   
    }   
    for($a = $j = $i = 0; $i < $string_length; $i++) {   
        $a = ($a + 1) % 256;   
        $j = ($j + $box[$a]) % 256;   
        $tmp = $box[$a];   
        $box[$a] = $box[$j];   
        $box[$j] = $tmp;   
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
    }   
    if($operation == 'DECODE') {   
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
            return substr($result, 26);   
        } else {   
            return '';   
        }   
    } else { 
        return $keyc.str_replace('=', '', base64_encode($result));   
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../js/jquery.min.js"></script>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        #box{
            position: relative;
            width: 100%;
            height: 40px;
            margin: 0 auto;
            background-color: #e8e8e8;
            box-shadow: 1px 1px 5px rgba(0,0,0,0.2);
        }
        .bgColor{
            position: absolute;
            left:0;
            top:0;
            width:40px;
            height: 40px;
            background-color: lightblue;
        }
        .txt{
            position: absolute;
            width: 100%;
            height: 40px;
            line-height: 40px;
            font-size: 14px;
            color: #000;
            text-align: center;
        }
        .slider{
            position: absolute;
            left:0;
            top:0;
            width: 50px;
            height: 38px;
            border: 1px solid #ccc;
            background: #fff;
            text-align: center;
            cursor: move;
        }
        .slider>i{
            position: absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
        }
        .slider.active>i{
            color:green;
        }

        .btn {
                position: absolute;
                width: 40px;
                height: 32px;
                background: #fff url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAAKCAYAAABv7tTEAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAKNJREFUeNpimDNnziMgTvz//z8DOsYlx8TAwBANxP1z584tYcAEWOUYQTqBgnpA9k4gXgrEpcnJyf9hCrDJgTVBJZWA1C4gPgLEQLnkv0gaUeSYYBJARfeAlBUQ6wPxOmTnoMsxMZABmNCccAyILwJxELIidDkmJM8eBeINQJyI5h8MORagoC2QsxmIW4ACPWg2YJVjgQZlIVBwPhbnY5UDCDAAT89wzIWvBqwAAAAASUVORK5CYII=) center no-repeat;
                background-size: 13px;
                cursor: move;
        }

        .yes {
                position: absolute;
                width: 40px;
                height: 32px;
                background: #fff url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAM1BMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACjBUbJAAAAEXRSTlMABYCSUQ9KGaGbNoR7XiJhLdI/qFAAAABuSURBVBjTZY9LEsAwCEIRozXp9/6nberYVdjB+FAxJa7Re6gLUhs5TMQGuaXXhlLTmQjTV0KBE6WrAXToKC+7A0MR9o8fACzQBXhsAl8hpGfQdksgg0RO3hNIpErP+IAsrbVVTV8OW05fnlvefwFsjwKvgJRlGwAAAABJRU5ErkJggg==) center no-repeat;
                background-size: 16px;
                cursor: move;
        }
        * { touch-action: pan-y; } 
    </style>
</head>
<body>
    <div id="box" onselectstart="return false;">
        <div class="bgColor"></div>
        <div class="txt" >拖动滑块验证</div>
        <div class="slider"><i class="btn"></i></div>
    </div>  
    <script>
        
        var box = getEle("#box"),
            bgColor = getEle(".bgColor"),
            txt = getEle(".txt"),
            slider = getEle(".slider"),
            icon = getEle(".slider>i"),
            successMoveDistance = box.offsetWidth- slider.offsetWidth,
            downX,
            isSuccess = false;

		$(function(){

		    $("[src$='conn/code_1.php?name=<?php echo $name?>']", window.parent.document).parent().append("<input type='hidden' name='<?php echo $name?>' id='code_<?php echo $genkey?>'>");
		    $("[src$='code_1.php?name=<?php echo $name?>']", window.parent.document).closest("form").find("[type='submit']").attr('disabled',true);
			slider.onmousedown = slider.ontouchstart = mousedownHandler;

		})
		function getEle(selector){
            return document.querySelector(selector);
        }
        function mousedownHandler(e){
            bgColor.style.transition = "";
            slider.style.transition = "";
            var e = e || window.event || e.which;
            if(!e.touches) {
                downX = e.clientX;
            } else {
                downX = e.touches[0].pageX;
            }

            document.onmousemove  = document.ontouchmove = mousemoveHandler;
            document.onmouseup  = document.ontouchend = mouseupHandler;
            window.codex=Math.random().toString(36).substr(2);
            
        }
        function getOffsetX(offset,min,max){
            if(offset < min){
                offset = min;
            }else if(offset > max){
                offset = max;
            }
            return offset;
        }
        function mousemoveHandler(e){
        	var e = e || window.event || e.which;

            if(!e.touches) {
                var moveX = e.clientX;
            } else {
                var moveX = e.touches[0].pageX;
            }

            var offsetX = getOffsetX(moveX - downX,0,successMoveDistance);
            bgColor.style.width = offsetX + "px";
            slider.style.left = offsetX + "px";

            if(offsetX == successMoveDistance){
                success();
            }
            e.preventDefault();
        }
        function mouseupHandler(e){
            if(!isSuccess){
                bgColor.style.width = 0 + "px";
                slider.style.left = 0 + "px";
                bgColor.style.transition = "width 0.8s linear";
                slider.style.transition = "left 0.8s linear";
            }
            document.onmousemove = document.ontouchmove = null;
            document.onmouseup = document.ontouchend = null;
        }
        function success(){
            isSuccess = true;
            txt.innerHTML = "验证成功";
            bgColor.style.backgroundColor ="lightgreen";
            slider.className = "slider active";
            icon.className = "yes";
            slider.onmousedown =  slider.ontouchstart = null;
            document.onmousemove = document.ontouchmove  = null;
            $.get("?action=codex&str="+codex, function(data) {
                $("#code_<?php echo $genkey?>", window.parent.document).val(data);
                $("[src$='conn/code_1.php?name=<?php echo $name?>']", window.parent.document).closest("form").find("[type='submit']").attr('disabled',false);
            });
        }
    </script>
</body>
</html>