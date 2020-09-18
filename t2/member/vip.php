<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];

if($action=="vip"){
	$viplong=$_POST["viplong"];
	switch ($viplong) {
		case 1:
		$fee=$C_vip1;
		$longtitle="1个月";
		break;

		case 2:
		$fee=$C_vip2;
		$longtitle="2个月";
		break;

		case 3:
		$fee=$C_vip3;
		$longtitle="3个月";
		break;

		case 6:
		$fee=$C_vip6;
		$longtitle="6个月";
		break;

		case 12:
		$fee=$C_vip12;
		$longtitle="12个月";
		break;

		case 999:
		$fee=$C_vip0;
		$longtitle="永久";
		break;

		default:
		box("时长有误，请重新提交！" , "back", "error");
		break;
		
	}

	if($M_money-$fee>=0 && $fee>0){
		if($M_vip==1){//原本是VIP会员
			mysqli_query($conn, "update sl_member set M_viplong=M_viplong+".(31*$viplong)." where M_id=".$M_id);
		}else{//原本是普通会员
			mysqli_query($conn, "update sl_member set M_viplong=".($viplong*31).",M_viptime='".date('Y-m-d H:i:s')."' where M_id=".$M_id);
		}
		mysqli_query($conn, "update sl_member set M_money=M_money-".$fee." where M_id=".$M_id);
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','开通VIP会员".$longtitle."','".date('Y-m-d H:i:s')."',-$fee,'')");
		//分站开通VIP提成
		if($fmid>0 && $C_fzvip>0){
			mysqli_query($conn, "update sl_member set M_money=M_money+".(($fee*$C_fzvip)/100)." where M_id=".$fmid);
			mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'".date('YmdHis').rand(10000000,99999999)."','分站开通VIP会员提成','".date('Y-m-d H:i:s')."',".(($fee*$C_fzvip)/100).",'')");
		}
		//分销提成
		fx_vip($fee,$M_id,0);
		box("开通成功！" , "vip.php", "success");
	}else{
		box("账户余额不足，请先充值！" , "pay.php?money=".($fee-$M_money), "error");
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
<style>
#buy label {
	padding: 1px 5px;
	cursor: pointer;
	border: #CCCCCC solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

#buy .checked {
	border: #ff0000 solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	color: #ff0000;
}

#buy input[type="radio"] {
	display: none;
}
</style>
</head>

<body class="body-index">
<?php require 'top.php';?>

		<div class="container m_top_30">
					<div class="yto-box">
						<div class="panel panel-default">
							<div class="panel-heading">VIP会员特权</div>
							<div class="table-responsive">
								<table class="table table-condensed">
								 <thead>
									<tr>
										<th>特权</th>
										<th>普通会员</th>
										<th class="vip">VIP会员</th>
										<th class="vip2">永久VIP会员</th>
									</tr>
									</thead>
									<tbody>
									<tr><td>红名显示</td><td>无</td><td class="vip">有</td><td class="vip2">有</td></tr>
									<tr><td>VIP尊贵图标</td><td>无</td><td class="vip">有</td><td class="vip2">有</td></tr>
									<tr><td>购买商品</td><td>无折扣</td><td class="vip"><?php echo $C_p_discount?>折</td><td class="vip2"><?php echo $C_p_discount2?>折</td></tr>
									<tr><td>付费阅读</td><td>无折扣</td><td class="vip"><?php echo $C_n_discount?>折</td><td class="vip2"><?php echo $C_n_discount2?>折</td></tr>

									</tbody>
								</table>
					</div>

				</div>
			</div>
<div class="yto-box">
<div class="panel panel-default">
							<div class="panel-heading">开通VIP</div>
							<div class="panel-body">
								<form action="?action=vip" method="post">
								<div class="col-xs-12 col-md-3">当前状态：</div>
								<div class="col-xs-12 col-md-9">
									<div class="col-xs-12 col-md-4" style="margin-bottom: 20px;"><b><?php

										if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
											if($M_viplong>30000){
												echo "VIP会员 [永久]";
												$button="<button type=\"submit\" class=\"btn btn-info\" style=\"margin-top: 20px;\" disabled=\"false\">已是永久会员</button>";
											}else{
												echo "VIP会员 [".date('Y-m-d', strtotime ("+".$M_viplong." day", strtotime($M_viptime)))."到期]";
												$button="<button type=\"submit\" class=\"btn btn-info\" style=\"margin-top: 20px;\">续费会员</button>";
											}
											
										}else{
											echo "普通会员";
											$button="<button type=\"submit\" class=\"btn btn-info\" style=\"margin-top: 20px;\">开通会员</button>";
										}

									?></b></div>
								</div>
								<div class="col-xs-12 col-md-3">开通时长：</div>
								<div class="col-xs-12 col-md-9" id="buy"><?php 
								if($C_vip1!=0){
									echo "<div class=\"col-xs-12 col-md-4\"><label aa=\"viplong\"><input type=\"radio\" name=\"viplong\" value=\"1\"> 1个月 [".$C_vip1."元]</label></div>";
								}
								if($C_vip2!=0){
									echo "<div class=\"col-xs-12 col-md-4\"><label aa=\"viplong\"><input type=\"radio\" name=\"viplong\" value=\"2\"> 2个月 [".$C_vip2."元]</label></div>";
								}
								if($C_vip3!=0){
									echo "<div class=\"col-xs-12 col-md-4\"><label aa=\"viplong\"><input type=\"radio\" name=\"viplong\" value=\"3\"> 3个月 [".$C_vip3."元]</label></div>";
								}
								if($C_vip6!=0){
									echo "<div class=\"col-xs-12 col-md-4\"><label aa=\"viplong\"><input type=\"radio\" name=\"viplong\" value=\"6\"> 6个月 [".$C_vip6."元]</label></div>";
								}
								if($C_vip12!=0){
									echo "<div class=\"col-xs-12 col-md-4\"><label aa=\"viplong\"><input type=\"radio\" name=\"viplong\" value=\"12\"> 12个月 [".$C_vip12."元]</label></div>";
								}
								if($C_vip0!=0){
									echo "<div class=\"col-xs-12 col-md-4\"><label aa=\"viplong\"><input type=\"radio\" name=\"viplong\" value=\"999\"> 永久 [".$C_vip0."元]</label></div>";
								}
								?>
								
								<div class="col-xs-12 col-md-12"><?php echo $button;?></div>
							</div>
						</form>
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
	<script>
$(function() { $('label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});

$("#buy").find("div:first label").attr("class","checked");
$("#buy").find("div:first label input").attr("checked","checked");

	</script>
</body>
</html>