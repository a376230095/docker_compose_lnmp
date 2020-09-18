<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$C_id=intval($_GET["C_id"]);
$S_id=intval($_GET["S_id"]);

if($C_id!=""){
	$aa="edit&C_id=".$C_id;
	$sql="select * from sl_card where C_id=".$C_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$C_content=$row["C_content"];
		$C_sort=$row["C_sort"];
		$C_use=$row["C_use"];
	}
}else{
	$aa="add";
	$C_use=0;
	$C_sort=$S_id;
}

if($action=="add"){
	$C_content=$_POST["C_content"];
	$C_sort=intval($_POST["C_sort"]);
	$C_use=intval($_POST["C_use"]);

	if($C_sort==0){
		die("{\"msg\":\"请选择一个卡密分类\"}");
	}

	if($C_content!=""){
		$card=explode("\r\n",$C_content);
		for($i=0;$i<count($card);$i++){
			if(getrs("select * from sl_card where C_content='$C_content' and C_sort='$C_sort'","C_id")==""){
				mysqli_query($conn,"insert into sl_card(C_content,C_sort,C_use) values('".trim($card[$i])."',$C_sort,$C_use)");
			}
		}
		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增卡密')");
		die("{\"msg\":\"success\"}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

if($action=="edit"){
	$C_content=$_POST["C_content"];
	$C_sort=intval($_POST["C_sort"]);
	$C_use=intval($_POST["C_use"]);

	if($C_sort==0){
		die("{\"msg\":\"请选择一个卡密分类\"}");
	}

	if(getrs("select * from sl_card where C_content='$C_content' and C_sort='$C_sort' and not C_id=$C_id","C_id")==""){
		if($C_content!=""){
			if(strpos($C_content,"\r\n")===false){
				mysqli_query($conn, "update sl_card set C_content='$C_content',C_sort=$C_sort,C_use=$C_use where C_id=".$C_id);
				mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑卡密')");
				die("{\"msg\":\"success\"}");
			}else{
				die("{\"msg\":\"不支持编辑多个\"}");
			}
		}else{
			die("{\"msg\":\"请填全内容\"}");
		}
	}else{
		die("{\"msg\":\"卡密内容重复\"}");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>卡密设置 - 后台管理</title>

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
                            <li class="breadcrumb-item active"><a href="card_list.php">卡密管理</a></li>
                            <li class="breadcrumb-item"><a href="csort_add.php">卡密分类</a></li>
                            <li class="breadcrumb-item"><a href="card_out.php">导出卡密</a></li>
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
											<h4>卡密管理</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >卡密内容</label>
													<div class="col-md-9">
														<textarea name="C_content" class="form-control" rows="20"><?php echo $C_content?></textarea>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*可以批量新增卡密，每行一个，可以智能去重复</div>
													</div>
												</div>



												<div class="form-group row">
													<label class="col-md-3 col-form-label" >卡密分类</label>
													<div class="col-md-9">
														<select name="C_sort" class="form-control">
															<?php
															$sql="select * from sl_csort where S_del=0 order by S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($C_sort==$row["S_id"]){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"".$row["S_id"]."\" ".$selected.">".$row["S_title"]."</option>";
																}
															}

															?>
															
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >已发放</label>
													<div class="col-md-9">
														<select name="C_use" class="form-control">
															<option value="0" <?php if($C_use==0){echo "selected=\"selected\"";}?>>否</option>
															<option value="1" <?php if($C_use==1){echo "selected=\"selected\"";}?>>是</option>
														</select>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*已发放的卡密不会再次发放给其他会员</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														
														<button class="btn btn-primary" type="button" onClick="save(2)">保存并返回</button>
														
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
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		if(id==1){
	            		toastr.success("保存成功", "成功");
            		}else{
            			window.location.href="card_list.php";
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
