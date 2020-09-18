<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$param=explode("|",$_GET["param"]);
$pay_no = $_GET['pay_no'];
$type=$param[0];
$id=$param[1];
$genkey=$param[2];

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>即时到账交易接口</title>
</head>
<body>
	<script type="text/javascript" src="https://js.cdn.aliyun.dcloud.net.cn/dev/uni-app/uni.webview.1.5.2.js"></script>
	<?php

if(strpos($_GET["param"],"cart@")===false){
	if($type=="news"){
		if(strpos($genkey,"_app")===false){
			echo "<script>window.location='../../?type=newsinfo&id=$id&genkey=$genkey';</script>";
		}else{
			echo "<script>
			document.addEventListener('UniAppJSBridgeReady', function(){
			uni.reLaunch({
				url: '../webview/webview?id=$id&genkey=$genkey'
			});
		});
		</script>";
		}
	}
	if($type=="product"){
		echo "<script>window.location='../../member/unlogin.php?type=fahuo&genkey=$genkey&id=$id';</script>";
	}
}else{
	echo "<script>window.location='../../member/query.php?action=query&no=$pay_no';</script>";
}
	?>
</body>
</html>