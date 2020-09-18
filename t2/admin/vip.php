<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];

if($action=="save"){
	$C_vip1=round($_POST["C_vip1"],2);
    $C_vip2=round($_POST["C_vip2"],2);
    $C_vip3=round($_POST["C_vip3"],2);
    $C_vip6=round($_POST["C_vip6"],2);
    $C_vip12=round($_POST["C_vip12"],2);
    $C_vip0=round($_POST["C_vip0"],2);
    $C_p_discount=round($_POST["C_p_discount"],2);
    $C_n_discount=round($_POST["C_n_discount"],2);
    $C_p_discount2=round($_POST["C_p_discount2"],2);
    $C_n_discount2=round($_POST["C_n_discount2"],2);

	if($C_title==""){
		die("请填全信息");
	}else{
		mysqli_query($conn,"update sl_config set
		C_vip1=$C_vip1,
	    C_vip2=$C_vip2,
	    C_vip3=$C_vip3,
	    C_vip6=$C_vip6,
	    C_vip12=$C_vip12,
	    C_vip0=$C_vip0,
	    C_p_discount=$C_p_discount,
	    C_n_discount=$C_n_discount,
	    C_p_discount2=$C_p_discount2,
	    C_n_discount2=$C_n_discount2");
	    mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','设置VIP')");
		die("success");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>VIP会员设置 - 后台管理</title>

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
                            <li class="breadcrumb-item active" aria-current="page">VIP会员设置</li>
                        </ol>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-6">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>VIP价格设置</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >1个月</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_vip1" class="form-control" value="<?php echo $C_vip1?>">
														<span class="input-group-addon">元</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >2个月</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_vip2" class="form-control" value="<?php echo $C_vip2?>">
														<span class="input-group-addon">元</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >3个月</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_vip3" class="form-control" value="<?php echo $C_vip3?>">
														<span class="input-group-addon">元</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >6个月</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_vip6" class="form-control" value="<?php echo $C_vip6?>">
														<span class="input-group-addon">元</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >12个月</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_vip12" class="form-control" value="<?php echo $C_vip12?>">
														<span class="input-group-addon">元</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >永久</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_vip0" class="form-control" value="<?php echo $C_vip0?>">
														<span class="input-group-addon">元</span>
													</div>
												</div>
											</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >说明</label>
													<div class="col-md-9">
														设置0元则不开启该时长的VIP会员
													</div>
												</div>
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>VIP特权设置</h4>
										</div>
										<div class="card-body">
											
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >虚拟商品折扣</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="text"  name="C_p_discount" class="form-control" value="<?php echo $C_p_discount?>">
															<span class="input-group-addon">折</span>
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >阅读文章折扣</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="text"  name="C_n_discount" class="form-control" value="<?php echo $C_n_discount?>">
															<span class="input-group-addon">折</span>
														</div>
													</div>
												</div>
										</div>
									</div>

									<div class="card card-primary">
										<div class="card-header ">
											<h4>永久VIP特权设置</h4>
										</div>
										<div class="card-body">
											
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >虚拟商品折扣</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="text"  name="C_p_discount2" class="form-control" value="<?php echo $C_p_discount2?>">
															<span class="input-group-addon">折</span>
														</div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >阅读文章折扣</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="text"  name="C_n_discount2" class="form-control" value="<?php echo $C_n_discount2?>">
															<span class="input-group-addon">折</span>
														</div>
														
													</div>
												</div>

										</div>
									</div>

									说明：可以填0到10之间的数字，可精确到小数点后2位；0折->免费；10折->无折扣
								</div>

								<div class="col-lg-6">
									<button class="btn btn-primary" type="button" onClick="save()">保存</button>
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
            	url:'?action=save',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            		if(data=="success"){
            		toastr.success("保存成功", "成功");
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });

			}

		</script>
		
	</body>
</html>
