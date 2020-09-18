<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);

if($S_id!=""){
	$aa="edit&S_id=".$S_id;
	$sql="select * from sl_csort where S_id=".$S_id;

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {

		$S_title=$row["S_title"];
		$S_content=$row["S_content"];

	}
}else{
	$aa="add";
	$S_pic="nopic.png";
}

if($action=="add"){

$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];

if($S_title!=""){
	mysqli_query($conn,"insert into sl_csort(S_title,S_content) values('$S_title','$S_content')");
	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增卡密分类')");
	die("success");
}else{
	die("error");
}
}

if($action=="edit"){


$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];

if($S_title!=""){

	mysqli_query($conn, "update sl_csort set

	S_title='$S_title',
	S_content='$S_content'
	where S_id=".$S_id);
	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑卡密分类')");
	die("success");
}else{
	die("error");
}
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>卡密分类设置 - 后台管理</title>

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
                            <li class="breadcrumb-item active"><a href="csort_add.php">卡密分类</a></li>
                            <li class="breadcrumb-item"><a href="card_out.php">导出卡密</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-3">

									<div class="card card-primary">

										<div class="card-header">
											<h4>卡密分类列表</h4>

										</div>
										
											
												<ul class="list-group">
													<?php 
														$sql="select * from sl_csort where S_del=0 order by S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["S_id"]==$S_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	echo "<a href=\"?S_id=".$row["S_id"]."\" class=\"list-group-item ".$active."\">".htmlspecialchars($row["S_title"])."</a>";
																}
															}
													?>
													
												</ul>
											
										
									</div>
									<a href="csort_add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增卡密分类</a>
								</div>

								<div class="col-lg-9">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>卡密分类管理</h4>
										</div>
										<div class="card-body">
											<form id="form">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >分类标题</label>
													<div class="col-md-9">
														<input type="text"  name="S_title" class="form-control" value="<?php echo htmlspecialchars($S_title)?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >分类介绍</label>
													<div class="col-md-9">
														<textarea name="S_content" class="form-control"><?php echo htmlspecialchars($S_content)?></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-info" type="button" onClick="save(1)">保存</button>
														<button class="btn btn-primary" type="button" onClick="save(2)">保存并返回</button>
														
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>

								

							
							</div>
							
						</div>
					</section>
				</div>


			</div>
		</div>

		<!--Jquery.min js-->
		<script src="assets/js/jquery.min.js"></script>

		<!--popper js-->
		<script src="assets/js/popper.js"></script>

		<!--Tooltip js-->
		<script src="assets/js/tooltip.js"></script>

		<!--Bootstrap.min js-->
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--Jquery.nicescroll.min js-->
		<script src="assets/plugins/nicescroll/jquery.nicescroll.min.js"></script>

		<!--mCustomScrollbar js-->
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!--Scroll-up-bar.min js-->
		<script src="assets/plugins/scroll-up-bar/dist/scroll-up-bar.min.js"></script>

		<!--Sidemenu js-->
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>

		<!--Scripts js-->
		<script src="assets/js/scripts.js"></script>

		<script src="assets/plugins/toastr/build/toastr.min.js"></script>
		<script src="assets/plugins/toaster/garessi-notif.js"></script>

		<script type="text/javascript">
		function save(id){
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		if(id==1){
            			toastr.success("保存成功", "成功");
            		}else{
            			window.location.href="card_list.php";
            		}
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });

			}

		</script>
		
	</body>
</html>
