<?php 
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

if($C_payjs_id=="" || $C_payjs_key=="") {
	die();
}

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

$return_code=$_POST["return_code"];
$total_fee=$_POST["total_fee"];
$out_trade_no=$_POST["out_trade_no"];
$payjs_order_id=$_POST["payjs_order_id"];
$transaction_id=$_POST["transaction_id"];
$time_end=$_POST["time_end"];
$openid=$_POST["openid"];
$attach=$_POST["attach"];
$mchid=$_POST["mchid"];
$type=$_POST["type"];
$sign=$_POST["sign"];

$O_ids=$attach;

$data = [
    'return_code' => $return_code,
    'total_fee' => $total_fee,
    'out_trade_no' => $out_trade_no,
    'payjs_order_id' => $payjs_order_id,
    'transaction_id' => $transaction_id,
    'time_end' => $time_end,
    'openid' => $openid,
    'attach' => $attach,
    'mchid' => $mchid,
    'type' => $type
];

$signx = sign($data, $C_payjs_key);

file_put_contents("../log/".$transaction_id.".txt", $signx."|".$sign);

if($_POST['return_code'] == 1){
	if($signx==$sign){
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
			    notify(t($transaction_id),$type,$id,$genkey,$email,$num,$M_id,($total_fee/100),$D_domain,"PAYJS");
			}else{
				$M_id=intval(splitx($O_ids,"|",0));
				$L_genkey=splitx($O_ids,"|",1);
				$sql="Select * from sl_list where L_no='".t($transaction_id)."'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				if (mysqli_num_rows($result) <= 0) {
					mysqli_query($conn,"update sl_member set M_money=M_money+".($total_fee/100)." where M_id=".intval($M_id));

					mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$transaction_id','帐号充值','".date('Y-m-d H:i:s')."',".($total_fee/100).",'$L_genkey')");
					sendmail("有用户通过PAYJS充值","用户ID：".$M_id."<br>充值金额：".($total_fee/100)."元<br>交易单号：".$transaction_id,$C_email);
				}
			}
		}else{
			cart(splitx($attach,"cart@",1),($total_fee/100),t($transaction_id),"PAYJS");
		}
	}
}

function sign(array $data, $key) {
    ksort($data);
    $sign = strtoupper(md5(urldecode(http_build_query($data)).'&key='.$key));
    return $sign;
}
?>