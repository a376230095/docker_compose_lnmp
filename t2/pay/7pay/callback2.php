<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);
$json_string=file_get_contents("php://input");
$obj=json_decode($json_string);

$title = $obj->title;
$money = $obj->money;
$no = t($obj->no);
$tradeno = t($obj->tradeno);
$paytype = $obj->paytype;
$remark = $obj->remark;
$time = $obj->time;
$sign = $obj->sign;

if($C_7pay_pkey==""){
	die();
}

if(strtolower(md5("money=".$money."&no=".$no."&paytype=".$paytype."&remark=".$remark."&time=".$time."&title=".$title."&tradeno=".$tradeno."&key=".$C_7pay_pkey))==strtolower($sign)){ 
	if(strpos($remark,"cart@")===false){
		$body = explode("|",$remark);
		$type = $body[0];
		$id = intval($body[1]);
		$genkey = $body[2];
		$email = $body[3];
		$num = intval($body[4]);
		$M_id = intval($body[5]);
		$_SESSION["uid"]=intval($body[6]);
	    notify($no,$type,$id,$genkey,$email,$num,$M_id,$money,$D_domain,"7支付",$tradeno);
		echo "success";
	}else{
		cart(splitx($remark,"cart@",1),$money,$tradeno,"7支付");
		echo "success";
	}
}else{
	echo "fail";
}

?>