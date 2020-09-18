<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$json_string=file_get_contents("php://input");
$obj=json_decode($json_string);

$title = $obj->title;
$money = $obj->money;
$no = t($obj->no);
$tradeno = $obj->tradeno;
$paytype = $obj->paytype;
$remark = intval($obj->remark);
$time = $obj->time;
$sign = $obj->sign;

if($C_7pay_pkey==""){
	die();
}

if(strtolower(md5("money=".$money."&no=".$no."&paytype=".$paytype."&remark=".$remark."&time=".$time."&title=".$title."&tradeno=".$tradeno."&key=".$C_7pay_pkey))==strtolower($sign)){ 
	$sql="select * from sl_list where L_mid=".$remark." and L_no='".$no."'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result) > 0) {

	}else{
		mysqli_query($conn,"update sl_member set M_money=M_money+".$money." where M_id=".$remark);
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(".$remark.",'$no','帐号充值','".date('Y-m-d H:i:s')."',".$money.",'')");
	}
	echo "success";
}else{
	echo "fail";
}

?>