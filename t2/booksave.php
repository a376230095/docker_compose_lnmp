<?php
require 'conn/conn.php';
require 'conn/function.php';

$action=$_GET["action"];
if($action=="save"){
	$G_title = t($_POST["G_title"]);
	$G_name = t($_POST["G_name"]);
	$G_mail = t($_POST["G_mail"]);
	$G_phone = t($_POST["G_phone"]);
	$G_msg = t($_POST["G_msg"]);

	if(strpos($G_mail,"@")===false || strpos($G_mail,".")===false){
		box("请填写一个正确的邮箱！","back","error");
	}

	if(strlen($G_phone)!=11 || !is_numeric($G_phone)){
		box("请填写一个正确的手机号码！","back","error");
	}

    if(xcode($_POST["G_code"],'DECODE',$_SESSION["CmsCode"],0)!=$_SESSION["CmsCode"] || $_POST["G_code"]=="" || $_SESSION["CmsCode"]==""){
        box("验证码错误!".$_SESSION["CmsCode"]."|".xcode($_POST["G_code"],'DECODE',$_SESSION["CmsCode"],0), "back", "error");
    } else {
        mysqli_query($conn, "insert into sl_guestbook(G_title,G_name,G_mail,G_phone,G_msg,G_time,G_reply) values('$G_title','$G_name','$G_mail','$G_phone','$G_msg','".date('Y-m-d H:i:s')."','')");
        box("留言成功，请等待管理员回复！","index.php","success");
    }
}

?>