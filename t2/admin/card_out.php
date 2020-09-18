<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
if($action=="out"){

$C_content=$_POST["C_content"];
$C_sort=intval($_POST["C_sort"]);
$C_use=$_POST["C_use"];

switch($_POST["order"]){
	case 1:
	$order="C_id";
	break;

	case 2:
	$order="C_sort";
	break;

	case 3:
	$order="C_use";
	break;
}
	$sql="select * from sl_card,sl_csort where C_sort=S_id and C_del=0 order by $order";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($C_content==1){
				$content=$row["C_content"];
			}else{
				$content="";
			}

			if($C_sort==1){
				$sort=" ".$row["S_title"];
			}else{
				$sort="";
			}

			if($C_use==1){
				if($row["C_use"]==1){
					$use=" 已发放";
				}else{
					$use=" 未发放";
				}
			}else{
				$use="";
			}

		    $out=$out.$content.$sort.$use."\n";
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
		<title>导出卡密 - 后台管理</title>

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
                            <li class="breadcrumb-item"><a href="card_list.php">卡密管理</a></li>
                            <li class="breadcrumb-item"><a href="csort_add.php">卡密分类</a></li>
                            <li class="breadcrumb-item active"><a href="card_out.php">导出卡密</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-8">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>导出卡密</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >选择导出字段</label>
													<div class="col-md-9">
														<label><input value="1" type="checkbox" name="C_content" checked="checked">卡密内容 </label>
														<label><input value="1" type="checkbox" name="C_sort">卡密分类名称 </label>
														<label><input value="1" type="checkbox" name="C_use">是否已发放</label>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">排序方式</label>
													<div class="col-md-9">
														<label><input value="1" type="radio" name="order" checked="checked">时间顺序</label>
														<label><input value="2" type="radio" name="order">卡密分类</label>
														<label><input value="3" type="radio" name="order">是否已发放</label>
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
