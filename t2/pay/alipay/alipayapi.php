<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝即时到账交易接口接口</title>
</head>
<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");
require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

$genkey=$_POST["genkey"];
$O_ids=$_POST["O_ids"];

if($O_ids!=""){
    $total_fee=0;
    $ids=explode(",",$O_ids);
    for ($i=0 ;$i<count($ids);$i++) {
        $sql="select * from sl_orders where O_del=0 and O_state=0 and O_id=".intval($ids[$i]);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $total_fee=$total_fee+($row["O_price"]*$row["O_num"]);
        }
    }

    $out_trade_no = date("YmdHis");
    $subject="购物车订单";
    $body = "cart@".$O_ids;
}else{
    if($genkey==""){
        $out_trade_no = date("YmdHis");
        if($_GET["from"]=="app"){
            $subject = "[app]用户充值" . $_REQUEST["fee"] . "元";
        }else{
            $subject = "用户充值" . $_REQUEST["fee"] . "元";
        }
        $total_fee = $_REQUEST["fee"];
        $body = $_REQUEST["M_id"];
    }else{
        $type=$_POST["type"];
        if(is_array($_POST["email"])){
            for ($i=0 ;$i<count($_POST["email"]);$i++ ) {
                $email=$email.$_POST["email"][$i]."__";
            }
            $email= substr($email,0,strlen($email)-2);
        }else{
            $email=$_POST["email"];
        }
        $id=intval($_POST["id"]);
        $M_id=intval($_POST["M_id"]);
        $num=intval($_POST["num"]);
        if($num<1){
            $num=1;
        }
        $out_trade_no = date("YmdHis");
        $body=$type."|".$id."|".$genkey."||".$num."|".$M_id."|".intval($_SESSION["uid"]);

        $sql="Select * from sl_member where M_id=".intval($M_id);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $M_id=$row["M_id"];
        $M_email=$row["M_email"];
        $M_money=$row["M_money"];
        $M_viptime=$row["M_viptime"];
        $M_viplong=$row["M_viplong"];

        if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
            $M_vip=1;
            if($M_viplong>30000){
                $N_discount=$C_n_discount2/10;
                $P_discount=$C_p_discount2/10;
            }else{
                $N_discount=$C_n_discount/10;
                $P_discount=$C_p_discount/10;
            }
        }else{
            $M_vip=0;
            $N_discount=1;
            $P_discount=1;
        }

        if($type=="news"){
            $sql="select * from sl_news where N_id=".$id;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $subject=mb_substr($row["N_title"],0,10,"utf-8")."...-付费阅读";
            $total_fee=p($row["N_price"]*$N_discount);
            $N_title=$row["N_title"];
            $N_pic=$row["N_pic"];
            $N_mid=$row["N_mid"];
        }
        if($type=="product"){
            $sql="select * from sl_product where P_id=".$id;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $subject=mb_substr($row["P_title"],0,10,"utf-8")."...-购买";
            $P_title=$row["P_title"];
            $P_pic=splitx($row["P_pic"],"|",0);
            $P_mid=$row["P_mid"];
            if($row["P_vip"]==1){
                $total_fee=p($row["P_price"]*$P_discount)*$num;
            }else{
                $total_fee=p($row["P_price"])*$num;
            }
        }
        if($total_fee>0){
            if(getrs("select O_id from sl_orders where O_genkey='$genkey'","O_id")==""){
                if($type=="news"){
                    mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,$total_fee,1,'$N_title','$N_pic',0,'$email','$genkey','$genkey',$N_mid)");
                }
                if($type=="product"){
                    mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".($total_fee/$num).",$num,'','$P_title','$P_pic','$email',0,'$genkey',$P_mid)");
                }
            }
        }
    }   
}

if(isMobile()){
    $parameter = array(
        "service"       => "alipay.wap.create.direct.pay.by.user",
        "partner"       => $alipay_config['partner'],
        "seller_id"  => $alipay_config['seller_id'],
        "payment_type"  => $alipay_config['payment_type'],
        "notify_url"    => $alipay_config['notify_url'],
        "return_url"    => $alipay_config['return_url'],
        
        "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
        "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
        "out_trade_no"  => $out_trade_no,
        "subject"   => $subject,
        "total_fee" => $total_fee,
        "body"  => $body,
        "it_b_pay" => "1440m",
        "app_pay" => "Y",
        "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
    );
}else{
    $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"  => $alipay_config['payment_type'],
            "notify_url"    => $alipay_config['notify_url'],
            "return_url"    => $alipay_config['return_url'],
            
            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"  => $out_trade_no,
            "subject"   => $subject,
            "total_fee" => $total_fee,
            "body"  => $body,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
    );
}


$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;
?>
</body>
</html>