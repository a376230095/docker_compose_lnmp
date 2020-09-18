<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];

if ($_GET["action"] == "tx") {
    $money = round($_POST["money"],2);
    $name = removexss($_POST["name"]);
    $alipay = removexss($_POST["alipay"]);
    if ($money-$C_zd>=0) {
        if ($money - $M_money <= 0) {
            mysqli_query($conn, "update sl_member set M_money=M_money-$money where M_id=$M_id");
            mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey,L_sh) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','余额提现（".$alipay."/".$name."/实际到账：".($money*(1-$C_fee/100))."元/手续费：".($money*$C_fee/100)."元）','".date('Y-m-d H:i:s')."',-$money,'',0)");
            sendmail("用户提交提现申请","<p>用户提现申请</p><p>用户ID：$M_id</p><p>用户帐号：$M_login</p><p>提现账户：$alipay</p><p>真实姓名：$name</p><p>提现金额：".$money."元</p><p>请到后台-交易管理-资金明细，进行提现审核</p>",$C_email);
            if($C_dx3==1){
            	sendsms("【".$C_smssign."】用户提现申请，用户ID：$M_id，用户帐号：$M_login，提现账户：$alipay，真实姓名：$name，提现金额：".$money."元，请到后台-交易管理-资金明细，进行提现审核",$C_mobile);
            }
            box("提交成功！请等待管理员审核", "list.php", "success");
        } else {
            box("余额不足！请重新输入", "back", "error");
        }
    } else {
        box("最低提现金额为".$C_zd."元！", "back", "error");
    }
}

if($action=="tomoney"){
	if($M_fen==0){
		box("积分不足！","back","error");
	}else{
		mysqli_query($conn,"update sl_member set M_fen=0,M_money=M_money+".($M_fen/100)." where M_id=$M_id");
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','积分转余额','".date('Y-m-d H:i:s')."',".($M_fen/100).",'".gen_key(20)."')");
		box("转换成功！","list.php","success");
	}
}

if($action=="check_login"){
	die("success");
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

  <!-- css plugins -->

 
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
						<h5>已购商品</h5>
						
						<div class="panel panel-default">
							<div class="panel-heading">商品记录</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="10%">图片</th>
										<th width="40%">商品</th>
										<th width="10%">总价</th>
										<th width="20%">提货</th>
										<th width="10%">状态</th>
										<th width="10%">操作</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_orders where O_del=0 and O_mid=".$M_id." and O_type=0 order by O_id desc limit 5";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								$O_id=$row["O_id"];

								if($row["O_state"]==0){
									$O_state="未付款";
								}
								if($row["O_state"]==1){
									$O_state="已发货";
								}
								if($row["O_state"]==2){
									$O_state="等待发货";
								}

								if($row["O_state"]>0){
									if(getrs("select * from sl_evaluate where E_mid=$M_id and E_oid=$O_id","E_id")==""){
										$b="<a href=\"evaluate.php?id=".$row["O_id"]."\" class=\"btn btn-xs btn-primary\">评价</a>";
									}else{
										$b="已评价";
									}
								}else{
									$b="<a href=\"unlogin.php?type=product&id=".$row["O_pid"]."&genkey=".$row["O_genkey"]."\" class=\"btn btn-xs btn-danger\">付款</a>";
								}

								if($row["O_wl"]!=""){
									$wl="<p>物流信息：".$row["O_wl"]."</p>";
								}else{
									$wl="";
								}
								
							        echo "<tr>
							        <td><img src=\"".pic2($row["O_pic"])."\" height=\"50\" width=\"50\"></td>
							        <td>
							        <p><b><a href=\"../?type=productinfo&id=".$row["O_pid"]."\" target=\"_blank\">".$row["O_title"]."</a></b></p>
							        <p>".$row["O_price"]."元 × ".$row["O_num"]."件</p>
							        </td>
							        
							        <td><span style=\"font-weight:bold;color:#ff0000\">".round($row["O_num"]*$row["O_price"],2)."元</span></td>
							        <td><p>".str_replace("||", "<br>", $row["O_content"])."</p>".$wl."</td>
							        <td>".$O_state."</td>
							        <td>".$b."</td>
							        </tr>";
							    }
							} 
									?>

									</tbody>
								</table>


					</div>
				</div>

				

			</div>


			<div class="yto-box">
						<h5>已付费文章</h5>
						
						<div class="panel panel-default">
							<div class="panel-heading">文章记录</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="10%">图片</th>
										<th width="40%">文章</th>
										<th width="10%">总价</th>
										<th width="10%">状态</th>
										<th width="10%">阅读</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_orders where O_del=0 and O_mid=".$M_id." and O_type=1 order by O_id desc limit 5";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {

									if($row["O_state"]==0){
										$O_state="未付款";
										$read="<a href=\"unlogin.php?type=news&id=".$row["O_nid"]."&genkey=".$row["O_genkey"]."\" class=\"btn btn-xs btn-danger\">付款</a>";
									}
									if($row["O_state"]==1){
										$O_state="已付款";
										$read="<a href=\"../?type=newsinfo&id=".$row["O_nid"]."\" class=\"btn btn-xs btn-primary\">阅读</a>";
									}

							        echo "<tr>
							        <td><img src=\"".pic2($row["O_pic"])."\" height=\"50\" width=\"50\"></td>
							        <td>
							        <p><b><a href=\"../?type=newsinfo&id=".$row["O_nid"]."\" target=\"_blank\">".$row["O_title"]."</a></b></p>
							        <p>".$row["O_price"]."元 × ".$row["O_num"]."</p>
							        </td>
							        
							        <td><span style=\"font-weight:bold;color:#ff0000\">".round($row["O_num"]*$row["O_price"],2)."元</span></td>
							        <td>".$O_state."</td>
							        <td>".$read."</td>
							        </tr>";
							    }
							} 
									?>

									</tbody>
								</table>
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
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	
</body>
</html>