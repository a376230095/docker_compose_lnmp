<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$action=$_GET["action"];
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

if($action=="cartpay"){
    $O_ids=$_POST["O_ids"];
    $M_id=$_SESSION["M_id"];
    $no = date("YmdHis").gen_key(10);

    $money=0;
    $ids=explode(",",$O_ids);

    for ($i=0 ;$i<count($ids);$i++) {
        $sql="select * from sl_orders where O_del=0 and O_state=0 and O_id=".intval($ids[$i]);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $money=$money+($row["O_price"]*$row["O_num"]);
        }
    }

    $sql="select * from sl_member where M_id=".intval($M_id);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $M_money=$row["M_money"];

    if($M_money-$money>=0){
        if(cart($O_ids,$money,$no,"余额支付")){
            Header("Location: ../../member/query.php?action=query&no=$no");
        }
    }else{
        box("账户余额不足，请先充值","../../member/pay.php?money=".($money-$M_money),"error");
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
    $no = date("YmdHis").gen_key(10);
    $genkey=$_POST["genkey"];
    
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
        $money=p($row["N_price"]*$N_discount);
        $return_url=gethttp().$D_domain."/pay/7pay/return.php?type=news&id=$id&genkey=$genkey";
        $N_title=$row["N_title"];
        $N_pic=$row["N_pic"];
        $N_mid=$row["N_mid"];
    }
    
    if($type=="product"){
        $sql="select * from sl_product where P_id=".$id;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row["P_vip"]==1){
            $money=p($row["P_price"]*$P_discount)*$num;
        }else{
            $money=p($row["P_price"])*$num;
        }
        $return_url=gethttp().$D_domain."/pay/7pay/return.php?type=product&genkey=$genkey&id=$id";
        $P_title=$row["P_title"];
        $P_pic=splitx($row["P_pic"],"|",0);
        $P_mid=$row["P_mid"];
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
        if($M_money-$money>=0){
            if(notify($no,$type,$id,$genkey,$email,$num,$M_id,$money,$D_domain,"余额支付")){
                Header("Location: ".$return_url);
            }
        }else{
            box("账户余额不足，请先充值","../../member/pay.php?money=".($money-$M_money),"error");
        }
    }else{
        box("订单金额需大于0元","back","error");
    }
}

?>