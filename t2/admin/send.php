<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$O_id=intval($_REQUEST["O_id"]);

$sql="select * from sl_orders,sl_member where O_mid=M_id and O_del=0 and O_id=".$O_id;
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
	$wlno=$_POST["wlno"];
	mysqli_query($conn, "update sl_orders set O_state=1,O_wl='$wl',O_wlno='$wlno' where O_id=".$O_id);
	sendmail("您购买的商品已发货","<p>您购买的商品[".$O_title."]已发货</p><p>总价：".$O_price."×".$O_num."=".($O_price*$O_num)."元</p><p>收件信息：".$O_address."</p>",$M_email);
	die("success");
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>手动发货 - 后台管理</title>

		<!--favicon -->
		<link rel="icon" href="../media/<?php echo $C_ico?>" type="image/x-icon"/>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

		<!--Icons css-->
		<link rel="stylesheet" href="assets/css/icons.css">

		<!--Style css-->
		<link rel="stylesheet" href="assets/css/style.css">

		<!--mCustomScrollbar css-->
		<link rel="stylesheet" href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css">

		<!--Sidemenu css-->
		<link rel="stylesheet" href="assets/plugins/toggle-menu/sidemenu.css">

		<!--Morris css-->
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">

		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">
		<link rel="stylesheet" href="assets/plugins/toaster/garessi-notif.css">

		<script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 50px;border: solid 1px #DDDDDD;padding: 5px;}
	</style>
	</head>

	<body class="app ">

		<div id="spinner"></div>

		<div id="app">
			<div class="main-wrapper" >
				
					<?php
					require 'nav.php';
					?>

				<div class="app-content">
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">手动发货</li>
                        </ol>

						<div class="section-body ">
							<form id="form">
								<input type="hidden" value="<?php echo $O_id?>" name="O_id">
							<div class="row">
								
								<div class="col-lg-6">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>手动发货</h4>
										</div>
										<div class="card-body">
											

											<div class="form-group row">
												<label class="col-md-3 col-form-label" >商品信息</label>
												<div class="col-md-9">
													<p><img src="<?php echo pic2($O_pic)?>" height="200"></p>
													<p><?php echo $O_title?></p>
													<p>总价：<?php echo $O_price?>×<?php echo $O_num?>=<?php echo $O_num*$O_price?>元</p>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >快递公司</label>
													<div class="col-md-9">
														<input type="text"  name="wl" class="form-control" value="" >
													</div>
												</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >快递单号</label>
													<div class="col-md-9">
														<input type="text"  name="wlno" class="form-control" value="" >
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

										</div>
									</div>
								</div>

							</div>
							</form>
						</div>
					</section>
				</div>

			</div>
		</div>

		<!--Jquery.min js-->
		<script src="assets/js/jquery.min.js"></script>

		<!--Bootstrap.min js-->
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--Sidemenu js-->
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>

		<!--mCustomScrollbar js-->
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!--Scripts js-->
		<script src="assets/js/scripts.js"></script>

		<script src="assets/plugins/toastr/build/toastr.min.js"></script>


		<script type="text/javascript">
		function save(){
				$.ajax({
            	url:'?action=send',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		toastr.success("发货成功，2秒后刷新", "成功");
            		setTimeout("window.location.href='orders_list.php'", 2000 )
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });

			}

		</script>
		
	</body>
</html>
