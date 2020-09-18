<?php
require '../../conn/conn.php';
require '../../conn/function.php';
include('../../api/alipay/aop/AopClient.php');

$aop = new AopClient;
$aop->alipayrsaPublicKey = $C_dmf_key2;
$flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");

$trade_no=$_POST["trade_no"];
$total_fee=$_POST["total_amount"];

if($flag==1){
	if(strpos($_POST["body"],"cart@")===false){
		if(substr_count($_POST["body"],"|")==6){
			$body = explode("|",$_POST["body"]);
			$type = $body[0];
			$id = intval($body[1]);
			$genkey = $body[2];
			$email = $body[3];
			$no=intval($body[4]);
			$M_id=intval($body[5]);
			$_SESSION["uid"]=intval($body[6]);
		    notify($trade_no,$type,$id,$genkey,$email,$no,$M_id,$total_fee,$D_domain,"当面付");
		}else{
			$M_id=intval(splitx($_POST["body"],"|",0));
			$L_genkey=splitx($_POST["body"],"|",1);
			$sql = "Select * from sl_list where L_no='" . t($trade_no) . "'";//用户充值
		    $result = mysqli_query($conn, $sql);
		    $row = mysqli_fetch_assoc($result);
		    if (mysqli_num_rows($result) <= 0) {
		        mysqli_query($conn, "update sl_member set M_money=M_money+" . $total_fee . " where M_id=" . intval($M_id));
		        mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(".intval($M_id).",'$trade_no','帐号充值','".date('Y-m-d H:i:s')."',".$total_fee.",'$L_genkey')");
		    }
		}	
	}else{
		cart(splitx($_POST["body"],"cart@",1),$total_fee,$trade_no,"当面付");
	}
}
?>