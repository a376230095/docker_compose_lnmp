<?php 
require_once("../../conn/conn.php");
require_once("../../conn/function.php");
$APPID = $C_wx_appid;
$MCHID = $C_wx_mchid;
$KEY = $C_wx_key;
$APPSECRET = $C_wx_appsecret;

if($MCHID=="" || $KEY=="") {
	die();
}

$postArr = file_get_contents("php://input");
libxml_disable_entity_loader(true);
$postObj = simplexml_load_string( $postArr );

$appid=$postObj->appid;
$attach=$postObj->attach;
$bank_type=$postObj->bank_type;
$cash_fee=$postObj->cash_fee;
$device_info=$postObj->device_info;
$fee_type=$postObj->fee_type;
$is_subscribe=$postObj->is_subscribe;
$mch_id=$postObj->mch_id;
$nonce_str=$postObj->nonce_str;
$openid=$postObj->openid;
$out_trade_no=$postObj->out_trade_no;
$result_code=$postObj->result_code;
$return_code=$postObj->return_code;
$time_end=$postObj->time_end;
$total_fee=$postObj->total_fee;
$trade_type=$postObj->trade_type;
$transaction_id=$postObj->transaction_id;
$sign=$postObj->sign;
$sign_type=$postObj->sign_type;
$err_code=$postObj->err_code;
$err_code_des=$postObj->err_code_des;
$settlement_total_fee=$postObj->settlement_total_fee;
$cash_fee_type=$postObj->cash_fee_type;
$coupon_fee=$postObj->coupon_fee;
$coupon_count=$postObj->coupon_count;
$coupon_type_0=$postObj->coupon_type_0;
$coupon_id_0=$postObj->coupon_id_0;
$coupon_fee_0=$postObj->coupon_fee_0;

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/api",0);

if (strtolower(MD5("appid=".$appid."&attach=".$attach."&bank_type=".$bank_type."&cash_fee=".$cash_fee."&fee_type=".$fee_type."&is_subscribe=".$is_subscribe."&mch_id=".$mch_id."&nonce_str=".$nonce_str."&openid=".$openid."&out_trade_no=".$out_trade_no."&result_code=".$result_code."&return_code=".$return_code."&time_end=".$time_end."&total_fee=".$total_fee."&trade_type=".$trade_type."&transaction_id=".$transaction_id."&key=".$KEY))==strtolower($sign) || strtolower(MD5("appid=".$appid."&attach=".$attach."&bank_type=".$bank_type."&cash_fee=".$cash_fee."&coupon_count=".$coupon_count."&coupon_fee=".$coupon_fee."&coupon_fee_0=".$coupon_fee_0."&coupon_id_0=".$coupon_id_0."&device_info=".$device_info."&fee_type=".$fee_type."&is_subscribe=".$is_subscribe."&mch_id=".$mch_id."&nonce_str=".$nonce_str."&openid=".$openid."&out_trade_no=".$out_trade_no."&result_code=".$result_code."&return_code=".$return_code."&time_end=".$time_end."&total_fee=".$total_fee."&trade_type=".$trade_type."&transaction_id=".$transaction_id."&key=".$KEY))==strtolower($sign)){
	if($result_code=="SUCCESS") {

		if(substr_count($attach,"|")==6){

			$body = explode("|",$attach);
			$type = $body[0];
			$id = intval($body[1]);
			$genkey = $body[2];
			$email = $body[3];
			$num = intval($body[4]);
			$M_id = intval($body[5]);
			$_SESSION["uid"]=intval($body[6]);
			if($M_id==0){
				$M_id=1;
			}
		    notify(t($transaction_id),$type,$id,$genkey,$email,$num,$M_id,($total_fee/100),$D_domain,"微信小程序支付");

		}else{
			$M_id=intval($attach);
			$sql="Select * from sl_list where L_no='".t($transaction_id)."'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if (mysqli_num_rows($result) <= 0) {
				mysqli_query($conn,"update sl_member set M_money=M_money+".($total_fee/100)." where M_id=".intval($M_id));

				mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$transaction_id','帐号充值','".date('Y-m-d H:i:s')."',".($total_fee/100).",'')");
				//sendmail("有用户通过微信充值","用户ID：".$M_id."<br>充值金额：".($total_fee/100)."元<br>交易单号：".$transaction_id,$C_email);
			}
		}
	}
} else {
	echo 0;
}
?>