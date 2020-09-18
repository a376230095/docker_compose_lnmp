<?php
require 'conn/conn.php';
require 'conn/function.php';
$type=$_GET["type"];
$id=intval($_GET["id"]);
$genkey=t($_POST["genkey"]);

$no=intval($_POST["no"]);
if($no==0 && $type=="productinfo"){
	box("购买数量不可为空！","./?type=productinfo&id=$id","error");
}

$address=intval($_POST["A_address"]);

if($type=="productinfo"){
	$P_taobao=getrs("select * from sl_product where P_id=".$id,"P_taobao");
	if(splitx($P_taobao,"|",0)!=""){
		die("<script>window.location.href='".splitx($P_taobao,"|",0)."';</script>");
	}
}

if($type=="newsinfo"){
	if($_SESSION["M_id"]!=""){
		die("<script>window.location.href='member/unlogin.php?type=news&id=$id&genkey=$genkey';</script>");
	}else{
		box("请先登录会员帐号！","member/login.php?from=".urlencode("../?type=".$type."&id=".$id),"error");
	}
}

if($type=="productinfo"){
	$P_unlogin=getrs("select P_unlogin from sl_product where P_id=$id","P_unlogin");
	if($P_unlogin==1 || $_SESSION["M_id"]!=""){
		die("<script>window.location.href='member/unlogin.php?type=product&id=$id&genkey=$genkey&no=$no&address=$address';</script>");
	}else{
		box("请先登录会员帐号！","member/login.php?from=".urlencode("../?type=".$type."&id=".$id),"error");
	}
}
?>