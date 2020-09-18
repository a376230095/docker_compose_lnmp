<?php 
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

$NOTIFY_URL = gethttp().$D_domain."/pay/payjs/notify_url.php";
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

    $body="购物车订单";
    $attach = "cart@".$O_ids;
    $total_fee=$total_fee*100;
}else{
    if($genkey==""){
    	$total_fee=$_POST["total_fee"]*100;
    	$body=$_POST["body"];
    	$attach=$_POST["attach"];
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
        $attach=$type."|".$id."|".$genkey."||".$num."|".$M_id."|".intval($_SESSION["uid"]);

        $sql="select * from sl_member where M_id=".intval($M_id);
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
            $body=mb_substr($row["N_title"],0,10,"utf-8")."...-付费阅读";
            $total_fee=p($row["N_price"]*$N_discount)*100;
            $N_title=$row["N_title"];
            $N_pic=$row["N_pic"];
            $N_mid=$row["N_mid"];
        }
        if($type=="product"){
            $sql="select * from sl_product where P_id=".$id;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $body=mb_substr($row["P_title"],0,10,"utf-8")."...-购买";
            if($row["P_vip"]==1){
                $total_fee=p($row["P_price"]*$P_discount)*100*$num;
            }else{
                $total_fee=p($row["P_price"])*100*$num;
            }
            $P_title=$row["P_title"];
            $P_pic=splitx($row["P_pic"],"|",0);
            $P_mid=$row["P_mid"];
        }
        if($total_fee>0){
            if(getrs("select O_id from sl_orders where O_genkey='$genkey'","O_id")==""){
                if($type=="news"){
                    mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,".($total_fee/100).",1,'$N_title','$N_pic',0,'$email','$genkey','$genkey',$N_mid)");
                }
                if($type=="product"){
                    mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".($total_fee/100/$num).",$num,'','$P_title','$P_pic','$email',0,'$genkey',$P_mid)");
                }
            }
        }
    }
}

$product_id=1;
$out_trade_no = date("YmdHis");

$sign=strtoupper(md5("attach=".$attach."&body=".$body."&mchid=".$C_payjs_id."&notify_url=".$NOTIFY_URL."&out_trade_no=".$out_trade_no."&total_fee=".$total_fee."&key=".$C_payjs_key));
$info=getbody("https://payjs.cn/api/native","mchid=$C_payjs_id&total_fee=$total_fee&out_trade_no=$out_trade_no&body=$body&attach=$attach&notify_url=$NOTIFY_URL&sign=$sign");

if(strpos($info,"SUCCESS")!==false){
    die(json_decode($info)->code_url);
}else{
    die($info);
}

?>