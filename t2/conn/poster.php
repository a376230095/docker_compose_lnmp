<?php
require '../conn/conn.php';
require '../conn/function.php';

$type=$_GET["type"];
$id=intval($_GET["id"]);
$from=intval($_GET["from"]);

if($type=="product"){
	$t="p";
	$sql="select * from sl_product where P_id=$id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$pic=splitx($row["P_pic"],"|",0);
	$title=$row["P_title"];
	$price=$row["P_price"];
	$zan="觉得这件商品很赞，推荐购买！";
}

if($type=="news"){
	$t="n";
	$sql="select * from sl_news where N_id=$id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$pic=$row["N_pic"];
	$title=$row["N_title"];
	$price=$row["N_price"];
	$zan="觉得这篇文章很赞，推荐阅读！";
}

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/conn",0);
if($_SESSION["M_id"]==""){
	$M_id=1;
	$login="<a href=\"../member/login.php\">[登录]</a> <a href=\"../member/reg.php\">[注册]</a>";
}else{
	$M_id=intval($_SESSION["M_id"]);
	$login="<a href=\"../member/\">[会员中心]</a> <a href=\"../member/login.php?action=unlogin\">[退出]</a>";
}

$sql="select * from sl_member where M_id=$M_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_id=$row["M_id"];
$M_head=$row["M_head"];
$M_login=$row["M_login"];
$M_email=$row["M_email"];
if($M_id==1){
	$M_email="";
}
$M_money=$row["M_money"];
$M_viptime=$row["M_viptime"];
$M_viplong=$row["M_viplong"];

if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
	$M_vip=1;
	$vip_pic="<img src=\"../member/img/vip.png\" style=\"margin-left:5px;height:17px;\">";
}else{
	$M_vip=0;
	$vip_pic="";
}

$M_info="
<img src=\"../media/$M_head\" style=\"width:30px;height:30px;border-radius:10px\">
<div style=\"display:inline-block;vertical-align:top;font-size:12px;margin-left:10px;\"> <b>$M_login</b>$vip_pic<br>$login</div>";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>赚取佣金</title>
	<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
	<link rel="stylesheet" href="../member/css/bootstrap.css">
	<script src="../member/js/jquery.min.js"></script>
	<script src="../member/js/bootstrap.min.js"></script>
	<script src="https://cdn.bootcss.com/html2canvas/0.5.0-beta4/html2canvas.js"></script>
	<script src="../js/qrcode.min.js"></script>
</head>
<body style="background: #EEEEEE;padding: 0px;">

<div style="margin: 10px auto;width: 100%;max-width: 500px;padding: 20px;background: #ffffff;">
<div style="font-size: 18px"><a href="../"><img src="../media/<?php echo $C_logo?>" style="height: 40px;margin-right: 10px;padding-right: 10px;border-right: solid 1px #DDDDDD;"></a>赚佣金</div>
<div style="float: right;margin-top: -35px;">
<?php echo $M_info;?>
</div>
</div>

<div style="margin: 0px auto;width: 100%;max-width: 500px;border: solid 1px #DDDDDD;" id="content">


	<div style="background-image:url(<?php echo pic2($pic)?>);background-repeat: no-repeat;background-position:center center;width:100%;height:500px;background-size: cover;" class="sss"></div>

	<div style="background: #ffffff;padding: 20px;">
		<div style="font-weight: bold;font-size: 20px;width: calc(100% - 110px);display: inline-block;vertical-align: top;">
			<?php echo $title?>
			<div style="color: #ff0000;font-size: 20px;margin-top:10px; ">
				￥<?php echo $price?>
			</div>
			<div style="font-size: 12px;margin-top: 10px;color: #666666"><img src="../media/<?php echo $M_head?>" style="width:20px;height:20px;border-radius:5px;"> <?php echo $M_login?>：<?php echo $zan?></div>
		</div>
		
		<div style="width:100px;text-align: center;font-size: 12px;display: inline-block;">
			<div style="" id="billImage"></div>
			<div style="margin-top: 10px;">长按识别二维码</div>
		</div>
	</div>
</div>

<div style="text-align: center;margin: 20px auto;width: 100%;max-width: 500px;">
	<div style="font-size: 12px;margin-bottom: 10px;">
<form>
		<div class="input-group">
            <span class="input-group-addon">推广链接</span>
            <input type="text" id="content_copy" class="form-control" value="<?php
            if($from==0){
            	echo "登录后显示推广链接";
            }else{
            	echo gethttp().$D_domain."?s=$t$id&uid=$from";
            }
             
             ?>">
        </div>
</form>
<p style="margin-top: 10px;">
<button class="btn btn-sm btn-primary" id="btnSave">下载海报</button> <button class="btn btn-sm btn-info" onclick="copy()">复制链接</button></p>
		<p style="margin-top: 10px;">用户通过您的推广链接/二维码购买商品，您将获得<?php echo $C_fx1?>%佣金</p>
		<?php if($from==0){?>
		<p style="margin-top: 10px;color: #ff0000">[<a href="../member/login.php?from=<?php echo urlencode("../?type=".$type."info&id=".$id)?>">登录会员</a>后可获取专属推广链接]</p>
		<?php }?>
	</div>
	
</div>
<script>
function copy(){
		var e=document.getElementById("content_copy");//对象是content 
        e.select(); //选择对象 
        document.execCommand("Copy"); //执行浏览器复制命令
       alert("复制成功")
	}

	 function saveFile(data, filename){
                var save_link = document.createElementNS('http://www.w3.org/1999/xhtml', 'a');
                save_link.href = data;
                save_link.download = filename;
 
                var event = document.createEvent('MouseEvents');
                event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                save_link.dispatchEvent(event);
            };
$(function(){
$('#btnSave').click(function(event) {
var copyDom = $("#content"); //要保存的dom
var width = copyDom.offsetWidth; //dom宽
var height = copyDom.offsetHeight; //dom高
var scale = 2; //放大倍数

    	html2canvas(
                    copyDom[0],
                    {
                    	dpi: window.devicePixelRatio * 2,
					    scale: scale,
					    width: width,
					    heigth: height,
					    useCORS: true,
                        onrendered: function (canvas) {                         
                            var pageData = canvas.toDataURL('image/png', 1.0);
							console.log(pageData)
							<?php if(isMobile()){
								echo '$("body").html("<div style=\'padding:20px;text-align:center\'><img src=\'"+pageData+"\' style=\'width:calc(100% - 10px);box-shadow: 0px 0px 5px #888888;\'><p style=\'margin-top:20px;font-weight:bold;\'>—— 长按保存图片 ——</p></div>");';
							}else{
								echo 'saveFile(pageData.replace("image/png", "image/octet-stream"),new Date().getTime()+".png");';
							}?>
						}
                    })
    });

    function convertCanvasToImage(canvas) {
        var image = new Image();
        image.src = canvas.toDataURL("image/png");
        document.body.appendChild(image);
        return image;
    }

var qrcode = new QRCode('billImage', {width: 100,height: 100,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
qrcode.makeCode("<?php echo gethttp().$D_domain."?s=$t$id&uid=$from";?>");

})

$(".sss").height($(".sss").width());
</script>
</body>
</html>