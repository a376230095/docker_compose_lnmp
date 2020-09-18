<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$action=$_GET["action"];
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

if($action=="pay"){
    $money=round($_POST["fee"],2);
    if($_GET["from"]=="app"){
        $return_url=urlencode(gethttp().$D_domain."/pay/7pay/return.php?type=app");
    }else{
        $return_url=urlencode(gethttp().$D_domain."/pay/7pay/return.php?type=pay");
    }
    $M_id=$_POST["M_id"];
    $no=date("YmdHis").gen_key(10,2);
    $notify_url=gethttp().$D_domain."/pay/7pay/callback.php";

    if($money>0){
        $sign=strtolower(md5("body=账户充值".$money."元&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$M_id."&return_url=".$return_url."&key=".$C_7pay_pkey));
        if(isMobile()){
              Header("Location: https://7-pay.cn/pay.php?body=账户充值".$money."元&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$M_id."&return_url=".$return_url."&sign=".$sign);
            die();
        }else{
            die("<html><head><title>收银台 - ".$C_title."</title></head><body><iframe src=\"https://7-pay.cn/pay.php?body=账户充值".$money."元&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$M_id."&return_url=".$return_url."&sign=".$sign."\" style=\"width:100%;height:100%;border:none\"></body></html>");
        }
    }else{
        box("金额需大于0元","back","error");
    }
}

if($action=="cartpay"){
    $O_ids=$_POST["O_ids"];
    $money=0;
    $ids=explode(",",$O_ids);
    for ($i=0 ;$i<count($ids);$i++) {
        $sql="select * from sl_orders where O_del=0 and O_state=0 and O_id=".intval($ids[$i]);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $money=$money+($row["O_price"]*$row["O_num"]);
            $genkey=$row["O_genkey"];
        }
    }

    $no=date("YmdHis").gen_key(10,2);
    $subject="购物车订单";
    $body = "cart@".$O_ids;
    $notify_url=gethttp().$D_domain."/pay/7pay/callback2.php";
    $return_url=urlencode(gethttp().$D_domain."/pay/7pay/return.php?type=cart&genkey=$genkey");

    if($money>0){
        $sign=strtolower(md5("body=".$subject."&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$body."&return_url=".$return_url."&key=".$C_7pay_pkey));
        if(isMobile()){
              Header("Location: https://7-pay.cn/pay.php?body=".$subject."&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$body."&return_url=".$return_url."&sign=".$sign);
            die();
        }else{
            die("<html><head><title>收银台 - ".$C_title."</title></head><body><iframe src=\"https://7-pay.cn/pay.php?body=".$subject."&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$body."&return_url=".$return_url."&sign=".$sign."\" style=\"width:100%;height:100%;border:none\"></body></html>");
        }
    }else{
        box("订单金额需大于0元","back","error");
    }

}

if($action=="unlogin"){
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
    $no = date("YmdHis");
    $genkey=$_POST["genkey"];
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

    $notify_url=gethttp().$D_domain."/pay/7pay/callback2.php";

    if($type=="news"){
        $sql="select * from sl_news where N_id=".$id;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $subject=mb_substr($row["N_title"],0,10,"utf-8")."...-付费阅读";
        $money=p($row["N_price"]*$N_discount);
        $N_title=$row["N_title"];
        $N_pic=$row["N_pic"];
        $N_mid=$row["N_mid"];
        $return_url=urlencode(gethttp().$D_domain."/pay/7pay/return.php?type=news&id=$id&genkey=$genkey");
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
            $money=p($row["P_price"]*$P_discount)*$num;
        }else{
            $money=p($row["P_price"])*$num;
        }
        $return_url=urlencode(gethttp().$D_domain."/pay/7pay/return.php?type=product&genkey=$genkey&id=$id");
    }

    if($money>0){
	    if(getrs("select O_id from sl_orders where O_genkey='$genkey'","O_id")==""){
	    	if($type=="news"){
	    		mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,$money,1,'$N_title','$N_pic',0,'$email','$genkey','$genkey',$N_mid)");
	    	}
	    	if($type=="product"){
	    		mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".($money/$num).",$num,'','$P_title','$P_pic','$email',0,'$genkey',$P_mid)");
	    	}
	    }
        $sign=strtolower(md5("body=".$subject."&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$body."&return_url=".$return_url."&key=".$C_7pay_pkey));
        if(isMobile()){
              Header("Location: https://7-pay.cn/pay.php?body=".$subject."&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$body."&return_url=".$return_url."&sign=".$sign);
            die();
        }else{
            die("<html><head><title>收银台 - ".$C_title."</title></head><body><iframe src=\"https://7-pay.cn/pay.php?body=".$subject."&fee=".$money."&no=".$no."&notify_url=".$notify_url."&pid=".$C_7pay_pid."&remark=".$body."&return_url=".$return_url."&sign=".$sign."\" style=\"width:100%;height:100%;border:none\"></body></html>");
        }
    }else{
        box("订单金额需大于0元","back","error");
    }
}
?>