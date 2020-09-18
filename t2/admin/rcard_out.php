<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
if($action=="out"){

$R_content=intval($_POST["R_content"]);
$R_use=intval($_POST["R_use"]);
$R_money=intval($_POST["R_money"]);
$R_time=intval($_POST["R_time"]);
$R_usetime=intval($_POST["R_usetime"]);
$R_mid=intval($_POST["R_mid"]);


switch($_POST["order"]){
	case 1:
	$order="R_time";
	break;

	case 2:
	$order="R_usetime";
	break;

	case 3:
	$order="R_money";
	break;

	case 4:
	$order="R_use";
	break;
}
	$sql="select * from sl_rcard where R_del=0 order by $order";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($R_content==1){
				$content=$row["R_content"];
			}else{
				$content="";
			}

			if($R_money==1){
				$money=" ".$row["R_money"];
			}else{
				$money="";
			}

			if($R_time==1){
				$time=" ".$row["R_time"];
			}else{
				$time="";
			}

			if($R_usetime==1){
				$usetime=" ".$row["R_usetime"];
			}else{
				$usetime="";
			}

			if($R_mid==1){
				$mid=" ".getrs("select * from sl_member where M_del=0 and M_id=".intval($row["R_mid"]),"M_login");
			}else{
				$mid="";
			}

			if($R_use==1){
				if($row["R_use"]==1){
					$use=" 已使用";
				}else{
					$use=" 未使用";
				}
			}else{
				$use="";
			}

		    $out=$out.$content.$money.$use.$time.$mid.$usetime."\n";
		}
	} 
	die($out);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>导出充值卡 - 后台管理</title>

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
                            <li class="breadcrumb-item active" aria-current="page"><a href="rcard_list.php">会员充值卡</a></li>
                        </ol>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-12">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>导出充值卡</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >选择导出字段</label>
													<div class="col-md-9">
														<label><input value="1" type="checkbox" name="R_content" checked="checked">充值卡号 </label>
														<label><input value="1" type="checkbox" name="R_money">金额 </label>
														<label><input value="1" type="checkbox" name="R_use">使用状态</label>
														<label><input value="1" type="checkbox" name="R_time">生成时间</label>
														<label><input value="1" type="checkbox" name="R_mid">使用者ID</label>
														<label><input value="1" type="checkbox" name="R_usetime">使用时间</label>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">排序方式</label>
													<div class="col-md-9">
														<label><input value="1" type="radio" name="order" checked="checked">生成时间</label>
														<label><input value="2" type="radio" name="order">使用时间</label>
														<label><input value="3" type="radio" name="order">金额</label>
														<label><input value="4" type="radio" name="order">使用状态</label>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-primary" type="button" onclick="save()">导出</button>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >导出结果</label>
													<div class="col-md-9">
														<textarea class="form-control" rows="30" id="out" style="line-height: 17px;"></textarea>
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
		function save(){
				$.ajax({
            	url:'?action=out',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            		$("#out").val(data);
            	}
            	});
			}

		</script>
		
	</body>
</html>
