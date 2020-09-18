<?php 
if($C_memberon==0){
	box("会员中心未开放","../","error");
}

if ($_SESSION["M_login"]=="" || $_SESSION["M_pwd"]=="" || $_SESSION["M_id"]=="" || $_SESSION["M_pwdcode"]==""){
	$_SESSION["M_login"] = "";
	$_SESSION["M_id"] = "";
	$_SESSION["M_pwd"] = "";
	$_SESSION["M_pwdcode"] = "";
	die("<script>window.location.href='login.php'</script>");
}else{
	$M_login=htmlspecialchars($_SESSION["M_login"]);
	$M_id=$_SESSION["M_id"];
	$sql="Select * from sl_member where M_id=$M_id and M_login='".$_SESSION["M_login"]."' and M_pwd='".$_SESSION["M_pwd"]."' and M_del=0 and M_stop=0";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$M_email=htmlspecialchars($row["M_email"]);
		$M_shop=$row["M_shop"];
		$M_head=$row["M_head"];
		$M_money=$row["M_money"];
		$M_fen=$row["M_fen"];
		$M_from=$row["M_from"];
		$M_pwd=$row["M_pwd"];
		$M_qq=$row["M_qq"];
		$M_mobile=$row["M_mobile"];
		$M_notice=$row["M_notice"];

		$M_openid=$row["M_openid"];
		$M_wxid=$row["M_wxid"];

		$M_viptime=$row["M_viptime"];
		$M_viplong=$row["M_viplong"];
		$M_type=$row["M_type"];
		$M_sellertime=$row["M_sellertime"];
		$M_sellerlong=$row["M_sellerlong"];

		$M_webtitle=$row["M_webtitle"];
		$M_keyword=$row["M_keyword"];
		$M_description=$row["M_description"];
		$M_logo=$row["M_logo"];
		$M_ico=$row["M_ico"];
		$M_domain=$row["M_domain"];
		$M_priceup=$row["M_priceup"];

		$M_beian=$row["M_beian"];
		$M_copyright=$row["M_copyright"];
		$M_qrcode=$row["M_qrcode"];
		$M_contact=$row["M_contact"];
		$M_kefu=$row["M_kefu"];
		$M_mobile=$row["M_mobile"];
		$M_code=$row["M_code"];
		$M_template=$row["M_template"];
		$M_wap=$row["M_wap"];
		$M_show=$row["M_show"];


		if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
			$M_vip=1;
			$M_viptitle="VIP会员";
		}else{
			$M_vip=0;
			$M_viptitle="普通会员";
		}
		$M_pwdcode=$row["M_pwdcode"];

		if($M_pwdcode!=$_SESSION["M_pwdcode"]){
			$_SESSION["M_login"] = "";
    		$_SESSION["M_id"] = "";
    		$_SESSION["M_pwd"] = "";
    		$_SESSION["M_pwdcode"] = "";
			die("<script>alert('帐号在别处登录，您被迫下线！');window.location.href='login.php'</script>");
		}

	}else{
		$_SESSION["M_login"] = "";
    	$_SESSION["M_id"] = "";
    	$_SESSION["M_pwd"] = "";
    	$_SESSION["M_pwdcode"] = "";
		die("<script>window.location.href='login.php'</script>");
	}
}
?>