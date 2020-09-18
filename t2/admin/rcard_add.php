<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];

if($action=="creat"){

	$R_money=intval($_POST["R_money"]);
	$R_num=intval($_POST["R_num"]);

	if($R_money==0 || $R_num==0){
		die("{\"msg\":\"请按照要求正确填写\"}");
	}

	for($i=0;$i<$R_num;$i++){
		mysqli_query($conn, "insert into sl_rcard(R_money,R_time,R_content) values(".$R_money.",'".date('Y-m-d H:i:s')."','".gen_key(64)."')");
	}

	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增充值卡')");
	die("{\"msg\":\"success\"}");
	
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>新增充值卡 - 后台管理</title>

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
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;}
		.list-group a{text-decoration:none}
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="rcard_list.php">新增充值卡</a></li>
                        </ol>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-8">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>新增充值卡</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >充值卡面额</label>
													<div class="col-md-9">
														<input type="text"  name="R_money" class="form-control" value="" placeholder="填写正整数">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >生成数量</label>
													<div class="col-md-9">
														<input type="text"  name="R_num" class="form-control" value="" placeholder="填写正整数">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*会员可输入充值卡号为账户余额充值，充值卡号由64位字母数字随机生成</div>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														
														<button class="btn btn-primary" type="button" onClick="save(2)">开始生成</button>
														
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

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/help.js"></script>
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>

		<script type="text/javascript">
		function save(id){
			
				$.ajax({
            	url:'?action=creat',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		if(id==1){
	            		toastr.success("生成成功", "成功");
            		}else{
            			window.location.href="rcard_list.php";
            		}
            	}else{
            		toastr.error(data.msg, '错误');
            	}
            	}
            });

			}

		</script>
		
	</body>
</html>
