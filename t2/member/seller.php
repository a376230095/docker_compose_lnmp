<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];

if($action=="up"){
	if($C_rzfeetype==1){
		$sellerlong=1;
	}else{
		$sellerlong=999;
	}
	if($M_money-$C_rzfee>=0){
		mysqli_query($conn, "update sl_member set M_type=1,M_sellertime='".date('Y-m-d H:i:s')."',M_sellerlong=".($sellerlong*31*12)." where M_id=".$M_id);
		mysqli_query($conn, "update sl_member set M_money=M_money-".$C_rzfee." where M_id=".$M_id);
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','升级到商家".$longtitle."','".date('Y-m-d H:i:s')."',-$C_rzfee,'')");
		box("您已升级到商家用户！" , "product_sell.php", "success");
	}else{
		box("账户余额不足，请先充值！" , "pay.php?money=".($C_rzfee-$M_money), "error");
	}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="会员中心">
  <title>会员中心 - <?php echo $C_title?></title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 
  <!--[if lt IE 9]>
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->

</head>

<body class="body-index">
<?php require 'top.php';?>

		<div class="container m_top_30">
					<div class="yto-box">
						<div class="panel panel-default">
							<div class="panel-heading">商家入驻</div>
							<div class="panel-body">
								<p>说明：升级到商家用户后，您可以发布自己的商品/文章并赚取收益。</p>
								<p>入驻费用：<?php echo $C_rzfee?>元（<?php
if($C_rzfeetype==0){
	echo "一次性";
}else{
	echo "每年";
}

								?>）</p>
								<p>提现费率：<?php echo $C_fee?>%</p>

<?php

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	echo "<p><a href=\"?action=up\" class=\"btn btn-info\">升级到商户</a></p>";
}else{

	if($M_sellerlong>30000){
		echo "<p style=\"color:#ff0000;font-weight:bold;\">您已升级为商家用户 [永久]</p>";
	}else{
		echo "<p style=\"color:#ff0000;font-weight:bold;\">您已升级为商家用户 [".date('Y-m-d', strtotime ("+".$M_sellerlong." day", strtotime($M_sellertime)))."到期]</p>";
	}
	echo "<p><a href=\"product_sell.php\" class=\"btn btn-info\">商品管理</a> <a href=\"news_sell.php\" class=\"btn btn-info\">文章管理</a> <a href=\"card_sell.php\" class=\"btn btn-info\">卡密管理</a> <a href=\"order_sell.php\" class=\"btn btn-info\">订单管理</a></p>";
}

?>

								
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php 
require 'foot.php';
?>
	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>

</body>
</html>