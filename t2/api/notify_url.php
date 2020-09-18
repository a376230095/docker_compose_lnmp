<?php 
require_once("../conn/conn.php");
require_once("../conn/function.php");
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

		if(substr_count($attach,"|")==4){
			$M_id=1;
			$body = explode("|",$attach);
			$type = $body[0];
			$id = intval($body[1]);
			$genkey = $body[2];
			$email = $body[3];
			$num = intval($body[4]);

			$sql = "Select * from sl_list where L_no='" . t($transaction_id) . "'";//用户充值
		    $result = mysqli_query($conn, $sql);
		    $row = mysqli_fetch_assoc($result);
		    if (mysqli_num_rows($result) <= 0) {
		        
		        if($type=="news"){
					$sql2="select * from sl_news where N_del=0 and N_id=".$id;
					$result2 = mysqli_query($conn, $sql2);
					$row2 = mysqli_fetch_assoc($result2);
					if (mysqli_num_rows($result2) > 0) {
						$N_title=$row2["N_title"];
						$N_pic=$row2["N_pic"];
						$N_price=$row2["N_price"];
						$N_mid=$row2["N_mid"];
					}
					if($N_price==($total_fee/100)){
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(1,'$transaction_id','帐号充值','".date('Y-m-d H:i:s')."',".($total_fee/100).",'')");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(1,'$transaction_id','免登录支付','".date('Y-m-d H:i:s')."',-".$N_price.",'".$genkey."')");
						mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content) values($id,1,'".date('Y-m-d H:i:s')."',1,".$N_price.",1,'$N_title','$N_pic',1,'$email','".$genkey."')");

						if($N_mid>0){
							mysqli_query($conn, "update sl_member set M_money=M_money+".($total_fee/100)." where M_id=$N_mid");
							mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($N_mid,'".date('YmdHis').rand(10000000,99999999)."','售出文章-".$N_title."','".date('Y-m-d H:i:s')."',".($total_fee/100).",'')");
						}

						sendmail("查收您的付费阅读文章", "<p>感谢您购买文章《".$N_title."》阅读</p><p>阅读链接：http://".$D_domain."/?type=newsinfo&id=".$id."&genkey=".$genkey."</p>", $email);
					}

		        }else{
					$sql2="select * from sl_product where P_del=0 and P_id=".$id;
					$result2 = mysqli_query($conn, $sql2);
					$row2 = mysqli_fetch_assoc($result2);
					if (mysqli_num_rows($result2) > 0) {
						$P_title=$row2["P_title"];
						$P_pic=$row2["P_pic"];
						$P_sell=$row2["P_sell"];
						$P_selltype=$row2["P_selltype"];
						$P_price=$row2["P_price"];
						$P_mid=$row2["P_mid"];
					}

					switch($P_selltype){
					  	case 0:
					  		$O_content=$P_sell;
					  		$O_address=$email;
					  		$O_state=1;
					  	break;
					  	case 1:
					  		for($i=0;$i<$num;$i++){
								$C_id=getrs("select * from sl_card where C_del=0 and C_use=0 and C_sort=".intval($P_sell),"C_id");
								$C_content=getrs("select * from sl_card where C_id=".intval($C_id),"C_content");
								if($C_content==""){
									$O_content=$O_content."商品缺货，请联系客服||";
								}else{
									$O_content=$O_content.$C_content."||";
								}
								mysqli_query($conn,"update sl_card set C_use=1 where C_id=".intval($C_id));
							}
							$O_content=substr($O_content,0,strlen($O_content)-2);
							$O_address=$email;
							$O_state=1;
					  	break;
					  	case 2:
					  		mysqli_query($conn,"update sl_product set P_rest=P_rest-1 where P_id=".$id);
					  		$O_content="实物商品，由商家手动发货";
					  		$O_address=$email;
					  		$O_state=0;
					  	break;
					}

					if($P_price*$num==($total_fee/100)){
						mysqli_query($conn, "update sl_product set P_sold=P_sold+1 where P_id=".$id);
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(1,'$transaction_id','帐号充值','".date('Y-m-d H:i:s')."',".($total_fee/100).",'')");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(1,'$transaction_id','免登录支付','".date('Y-m-d H:i:s')."',-$P_price,'$genkey')");
						mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey) values($id,1,'".date('Y-m-d H:i:s')."',0,$P_price,$num,'$O_content','$P_title','$P_pic','$O_address',$O_state,'$genkey')");

						if($P_mid>0){
							mysqli_query($conn, "update sl_member set M_money=M_money+".($total_fee/100)." where M_id=$P_mid");
							mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($P_mid,'".date('YmdHis').rand(10000000,99999999)."','售出商品-".$P_title."','".date('Y-m-d H:i:s')."',".($total_fee/100).",'')");
						}

					}
					sendmail("您的购买的商品已发货","<p>商品名称：".$P_title."</p><p>发货内容：".str_replace("||","<br>",$O_content)."</p>",$email);
		        }
		        
		    	sendmail("有用户通过微信购物","用户ID：".$M_id."<br>商品名称：".$P_title."<br>购物金额：".($total_fee/100)."元<br>交易单号：".$transaction_id,$C_email);
		    }
		}else{
			$M_id=intval(splitx($O_ids,"|",0));
			$L_genkey=splitx($O_ids,"|",1);
			$sql="Select * from sl_list where L_no='".t($transaction_id)."'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if (mysqli_num_rows($result) <= 0) {
				mysqli_query($conn,"update sl_member set M_money=M_money+".($total_fee/100).",M_fen=M_fen+".intval($total_fee/100)." where M_id=".intval($M_id));

				mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$transaction_id','帐号充值','".date('Y-m-d H:i:s')."',".($total_fee/100).",'$L_genkey')");
				sendmail("有用户通过微信充值","用户ID：".$M_id."<br>充值金额：".($total_fee/100)."元<br>交易单号：".$transaction_id,$C_email);
			}
		}
	}
} else {
	echo 0;
}
?>