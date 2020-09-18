<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';
$type=$_GET["type"];
$id=intval($_GET["id"]);

if($type=="product"){
	$t="p";
	$sql="select * from sl_product where P_id=$id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$pic=splitx($row["P_pic"],"|",0);
	$title=$row["P_title"];
	$price=$row["P_price"];
}

if($type=="news"){
	$t="n";
	$sql="select * from sl_news where N_id=$id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$pic=$row["N_pic"];
	$title=$row["N_title"];
	$price=$row["N_price"];
}

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/".$C_admin,0);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>生成海报</title>
	<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdn.bootcss.com/html2canvas/0.5.0-beta4/html2canvas.js"></script>
	<script src="../js/qrcode.min.js"></script>
</head>
<body style="background: #EEEEEE;">
<div style="margin: 0px auto;width: 500px;border: solid 1px #DDDDDD" id="content">
	<img src="<?php echo pic2($pic)?>" width="500">
	<div style="background: #ffffff;padding: 20px;">
		<div style="font-weight: bold;font-size: 20px;width: 350px;display: inline-block;vertical-align: top;">
			<?php echo $title?>
			<div style="color: #ff0000;font-size: 20px;margin-top:10px; ">
				￥<?php echo $price?>
			</div>
		</div>
		
		<div style="width:90px;text-align: center;font-size: 12px;display: inline-block;">
			<div style="" id="billImage"></div>
			长按识别二维码
		</div>
	</div>
</div>

<div style="margin-top: 30px;text-align: center;">
	<div style="font-size: 12px;margin-bottom: 10px;">海报图片可以发布到朋友圈/分享给好友，方便推广</div>
	<button class="btn btn-sm btn-primary" id="btnSave">下载海报</button>
</div>
<script>

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
    	html2canvas(
                    $('#content'),
                    {
                        onrendered: function (canvas) {                         
                            var pageData = canvas.toDataURL('image/png', 1.0);
							console.log(pageData)
							saveFile(pageData.replace("image/png", "image/octet-stream"),new Date().getTime()+".png");
						}
                            
                    })
        
    });

    function convertCanvasToImage(canvas) {
        var image = new Image();
        image.src = canvas.toDataURL("image/png");
        document.body.appendChild(image);
        return image;
    }

var qrcode = new QRCode('billImage', {width: 90,height: 90,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
qrcode.makeCode("<?php echo gethttp().$D_domain."?s=$t$id";?>");

})
</script>
</body>
</html>