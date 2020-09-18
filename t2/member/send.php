<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	Header("Location:seller.php");
	die();
}
$action=$_GET["action"];
$O_id=intval($_REQUEST["O_id"]);

$sql="select * from sl_orders,sl_member where O_mid=M_id and O_del=0 and O_id=".$O_id." and O_sellmid=".$M_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
	$O_title=$row["O_title"];
	$O_pic=$row["O_pic"];
	$O_address=$row["O_address"];
	$O_price=$row["O_price"];
	$O_num=$row["O_num"];
	$M_login=$row["M_login"];
	$M_id=$row["M_id"];
	$M_email=$row["M_email"];
}

if($action=="send"){
	$wl=$_POST["wl"];
	mysqli_query($conn, "update sl_orders set O_state=1,O_wl='$wl' where O_id=".$O_id." and O_sellmid=".intval($_SESSION["M_id"]));
	sendmail("您购买的商品已发货","<p>您购买的商品[".$O_title."]已发货</p><p>总价：".$O_price."×".$O_num."=".($O_price*$O_num)."元</p><p>收件信息：".$O_address."</p>",$M_email);
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
 <script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 500px}
		.list-group a{text-decoration:none}
	</style>
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
				<div class="row">
					<div class="col-sm-2 hidden-xs">
			<h5 class="p_bottom_10">订单管理</h5>
		<ul class="nav nav-pills nav-stacked">
			<li ><a href="csort_list.php">订单管理</a></li>
	        <li class="active"><a href="">订单发货</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">发货</div>
							<div class="panel-body">
											<form id="form">
												<input type="hidden" value="<?php echo $O_id?>" name="O_id">
												<div class="form-group row">
												<label class="col-md-3 col-form-label" >商品信息</label>
												<div class="col-md-9">
													<p><img src="<?php echo pic2($O_pic)?>" height="200"></p>
													<p><?php echo $O_title?></p>
													<p>总价：<?php echo $O_price?>×<?php echo $O_num?>=<?php echo $O_num*$O_price?>元</p>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >快递单号</label>
													<div class="col-md-9">
														<input type="text"  name="wl" class="form-control" value="" placeholder="快递公司/快递单号">
													</div>
												</div>

											<div class="form-group row">
												<label class="col-md-3 col-form-label" >收件信息</label>
												<div class="col-md-9">
													

													<p>会员：<a href="member.php?M_id=<?php echo $M_id?>"><i class="fa fa-user"></i> <?php echo $M_login?></a></p>
													<p><?php echo str_replace("__","<br>",$O_address)?></p>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-md-3 col-form-label" ></label>
												<div class="col-md-9">
													<button class="btn btn-primary" type="button" onClick="save()">发货</button>
												</div>
											</div>
											</form>
										</div>
				</div>
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
	<script type="text/javascript">
		function save(id){
				$.ajax({
            	url:'?action=send',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		if(id==1){
            			alert("保存成功");
            		}else{
            			window.location.href="order_sell.php";
            		}
            	}else{
            		alert(data);
            	}
            	}
            });

			}

		</script>
</body>
</html>