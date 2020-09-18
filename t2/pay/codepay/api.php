<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$action=$_GET["action"];
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

if($action=="pay"){
    $money=round($_POST["fee"],2);

    if($_GET["from"]=="app"){
        $return_url=gethttp().$D_domain."/pay/7pay/return.php?typex=app";
    }else{
        $return_url=gethttp().$D_domain."/pay/7pay/return.php?typex=pay";
    }

    $M_id=$_POST["M_id"];
    $paytype=intval($_POST["paytype"]);
    $no=date("YmdHis").gen_key(10,2);
    $notify_url=gethttp().$D_domain."/pay/codepay/callback2.php";

    if($money>0){

        $data = array(
            "id" => $C_codepay_id,//你的码支付ID
            "pay_id" => $M_id.gen_key(10,2), //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "type" => $paytype,//1支付宝支付 3微信支付 2QQ钱包
            "price" => $money,//金额100元
            "param" => $M_id,//自定义参数
            "notify_url"=>$notify_url,//通知地址
            "return_url"=>$return_url,//跳转地址
        ); //构造需要传递的参数

        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素

        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign .$C_codepay_key); //创建订单所需的参数
        $url = "http://api2.xiuxiu888.com/creat_order/?{$query}"; //支付页面

        header("Location:{$url}"); //跳转到支付页面
        die();

    }else{
        box("金额需大于0元","back","error");
    }
}

if($action=="cartpay"){
    $paytype=intval($_POST["paytype"]);
    $O_ids=$_POST["O_ids"];
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

    $no = date("YmdHis");
    $subject="购物车订单";
    $body = "cart@".$O_ids;
    $notify_url=gethttp().$D_domain."/pay/codepay/callback.php";
    $return_url=gethttp().$D_domain."/pay/codepay/return.php";

    if($money>0){
        $data = array(
            "id" => $C_codepay_id,//你的码支付ID
            "pay_id" => $no, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "type" => $paytype,//1支付宝支付 3微信支付 2QQ钱包
            "price" => $money,//金额100元
            "param" => $body,//自定义参数
            "notify_url"=>$notify_url,//通知地址
            "return_url"=>$return_url,//跳转地址
        ); //构造需要传递的参数

        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素

        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign .$C_codepay_key); //创建订单所需的参数
        $url = "http://api2.xiuxiu888.com/creat_order/?{$query}"; //支付页面

        header("Location:{$url}"); //跳转到支付页面
        die();
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
    $paytype=intval($_POST["paytype"]);
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

    $notify_url=gethttp().$D_domain."/pay/codepay/callback.php";

    if($type=="news"){
        $sql="select * from sl_news where N_id=".$id;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $subject=mb_substr($row["N_title"],0,10,"utf-8")."...-付费阅读";
        $money=p($row["N_price"]*$N_discount);
        $return_url=gethttp().$D_domain."/pay/codepay/return.php";
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
            $money=p($row["P_price"]*$P_discount)*$num;
        }else{
            $money=p($row["P_price"])*$num;
        }
        
        $return_url=gethttp().$D_domain."/pay/codepay/return.php";
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

		$data = array(
		    "id" => $C_codepay_id,//你的码支付ID
		    "pay_id" => $genkey, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
		    "type" => $paytype,//1支付宝支付 3微信支付 2QQ钱包
		    "price" => $money,//金额100元
		    "param" => $body,//自定义参数
		    "notify_url"=>$notify_url,//通知地址
		    "return_url"=>$return_url,//跳转地址
		); //构造需要传递的参数

		ksort($data); //重新排序$data数组
		reset($data); //内部指针指向数组中的第一个元素

		$sign = ''; //初始化需要签名的字符为空
		$urls = ''; //初始化URL参数为空

		foreach ($data AS $key => $val) { //遍历需要传递的参数
		    if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
		    if ($sign != '') { //后面追加&拼接URL
		        $sign .= "&";
		        $urls .= "&";
		    }
		    $sign .= "$key=$val"; //拼接为url参数形式
		    $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

		}
		$query = $urls . '&sign=' . md5($sign .$C_codepay_key); //创建订单所需的参数
		$url = "http://api2.xiuxiu888.com/creat_order/?{$query}"; //支付页面

		header("Location:{$url}"); //跳转到支付页面
		die();
    }else{
        box("订单金额需大于0元","back","error");
    }
}
?>