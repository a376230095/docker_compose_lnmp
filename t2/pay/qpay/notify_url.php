<?php 
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

if($C_qpay_mchid=="" || $C_qpay_key=="") {
	die();
}

$postArr = file_get_contents("php://input");
libxml_disable_entity_loader(true);
$postObj = simplexml_load_string( $postArr );

$attach=$postObj->attach;
$bank_type=$postObj->bank_type;
$cash_fee=$postObj->cash_fee;
$fee_type=$postObj->fee_type;

$mch_id=$postObj->mch_id;
$nonce_str=$postObj->nonce_str;
$out_trade_no=$postObj->out_trade_no;

$time_end=$postObj->time_end;
$total_fee=$postObj->total_fee;
$trade_state=$postObj->trade_state;
$trade_type=$postObj->trade_type;
$transaction_id=$postObj->transaction_id;
$sign=$postObj->sign;

$O_ids=$attach;
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

if (strtolower(MD5("attach=".$attach."&bank_type=".$bank_type."&cash_fee=".$cash_fee."&fee_type=".$fee_type."&mch_id=".$mch_id."&nonce_str=".$nonce_str."&out_trade_no=".$out_trade_no."&time_end=".$time_end."&total_fee=".$total_fee."&trade_state=".$trade_state."&trade_type=".$trade_type."&transaction_id=".$transaction_id."&key=".$C_qpay_key))==strtolower($sign)) {

	if($trade_state=="SUCCESS") {
		if(strpos($attach,"cart@")===false){
			if(substr_count($attach,"|")==6){
				$body = explode("|",$attach);
				$type = $body[0];
				$id = intval($body[1]);
				$genkey = $body[2];
				$email = $body[3];
				$num = intval($body[4]);
				$M_id = intval($body[5]);
				$_SESSION["uid"]=intval($body[6]);
			    notify(t($transaction_id),$type,$id,$genkey,$email,$num,$M_id,($total_fee/100),$D_domain,"QQ钱包");
			}else{
				$M_id=intval(splitx($O_ids,"|",0));
				$L_genkey=splitx($O_ids,"|",1);
				$sql="Select * from sl_list where L_no='".t($transaction_id)."'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				if (mysqli_num_rows($result) <= 0) {
					mysqli_query($conn,"update sl_member set M_money=M_money+".($total_fee/100)." where M_id=".intval($M_id));

					mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$transaction_id','帐号充值','".date('Y-m-d H:i:s')."',".($total_fee/100).",'$L_genkey')");
					//sendmail("有用户通过微信充值","用户ID：".$M_id."<br>充值金额：".($total_fee/100)."元<br>交易单号：".$transaction_id,$C_email);
				}
			}
		}else{
			cart(splitx($attach,"cart@",1),($total_fee/100),t($transaction_id),"QQ钱包");
		}
	}
} else {
	echo 0;
}
?>