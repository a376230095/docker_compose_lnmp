<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);

if($S_id!=""){
	$aa="edit&S_id=".$S_id;
	$sql="select * from sl_psort where S_id=".$S_id;

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$S_pic=$row["S_pic"];
		$S_order=$row["S_order"];
		$S_sub=$row["S_sub"];
		$S_title=$row["S_title"];
		$S_keywords=$row["S_keywords"];
		$S_content=$row["S_content"];
		$S_show=$row["S_show"];
	}
}else{
	$aa="add";
	$S_pic="nopic.png";
	$S_show=1;
	$S_order=0;
}

if($action=="add"){
$S_pic=$_POST["S_pic"];
$S_order=intval($_POST["S_order"]);
$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];
$S_keywords=$_POST["S_keywords"];
$S_sub=intval($_POST["S_sub"]);
$S_show=intval($_POST["S_show"]);

if($S_title!=""){
	mysqli_query($conn,"insert into sl_psort(S_pic,S_title,S_content,S_order,S_sub,S_show,S_keywords) values('$S_pic','$S_title','$S_content',$S_order,$S_sub,$S_show,'$S_keywords')");
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增商品分类')");
	die("success");
}else{
	die("error");
}
}

if($action=="edit"){
$S_order=intval($_POST["S_order"]);
$S_pic=$_POST["S_pic"];
$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];
$S_keywords=$_POST["S_keywords"];
$S_sub=intval($_POST["S_sub"]);
$S_show=intval($_POST["S_show"]);

if($S_title!=""){
	mysqli_query($conn, "update sl_psort set
	S_pic='$S_pic',
	S_order=$S_order,
	S_sub=$S_sub,
	S_show=$S_show,
	S_title='$S_title',
	S_keywords='$S_keywords',
	S_content='$S_content'
	where S_id=".$S_id);
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑商品分类')");
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
		<title>商品分类设置</title>

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
                            <li class="breadcrumb-item"><a href="product_list.php">商品管理</a></li>
                            <li class="breadcrumb-item active"><a href="psort_add.php">商品分类</a></li>
                            <li class="breadcrumb-item"><a href="excel.php">导入EXCEL</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-3">

									<div class="card card-primary">

										<div class="card-header">
											<h4>商品分类列表</h4>

										</div>
										
											
												<ul class="list-group">
													<li class="list-group-item">分类标题
														<span class="pull-right">首页展示/图片</span>
													</li>
											
											<?php 
													$sql="select * from sl_psort where S_del=0 and S_sub=0 order by S_order asc,S_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {
															if($row["S_id"]==$S_id){
																$active="active";
															}else{
																$active="";
															}

															if($row["S_show"]==1){
																$show="<i class='fa fa-check-circle pull-right' style='margin-right:10px'></i>";
															}else{
																$show="";
															}
															
															echo "<a href=\"?S_id=".$row["S_id"]."\" class=\"list-group-item ".$active."\"><b>└ ".$row["S_order"].".".$row["S_title"]."</b><img src=\"".pic2($row["S_pic"])."\" alt=\"<img src='".pic2($row["S_pic"])."' width='300'>\" style=\"height:25px;width:25px;border-radius:10px;\" class=\"pull-right\"> ".$show."</a>";


															$sql2="select * from sl_psort where S_del=0 and S_sub=".$row["S_id"]." order by S_order asc,S_id desc";
																$result2 = mysqli_query($conn, $sql2);
																if (mysqli_num_rows($result2) > 0) {
																while($row2 = mysqli_fetch_assoc($result2)) {
																	if($row2["S_id"]==$S_id){
																		$active2="active";
																	}else{
																		$active2="";
																	}
																	if($row2["S_show"]==1){
																		$show="<i class='fa fa-check-circle pull-right' style='margin-right:10px'></i>";
																	}else{
																		$show="";
																	}
																	
																	echo "<a href=\"?S_id=".$row2["S_id"]."\" class=\"list-group-item ".$active2."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ ".$row2["S_order"].".".$row2["S_title"]."<img src=\"".pic2($row2["S_pic"])."\" alt=\"<img src='".pic2($row2["S_pic"])."' width='300'>\" style=\"height:25px;width:25px;border-radius:10px;\" class=\"pull-right\">".$show."</a>

																	

																	";


																}
															}


														}
													}
											?>
											
										</ul>
											
										
									</div>
									<a href="psort_add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增商品分类</a>
								</div>

								<div class="col-lg-9">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>商品分类管理</h4>
										</div>
										<div class="card-body">
											<form id="form">

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >上级分类</label>
													<div class="col-md-9">
														<select name="S_sub" class="form-control">
															<option value="0">根分类</option>
															<?php
															$sql="select * from sl_psort where S_del=0 and S_sub=0 and not S_id=$S_id order by S_order,S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($S_sub==$row["S_id"]){
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
													<label class="col-md-3 col-form-label" >分类标题</label>
													<div class="col-md-9">
														<input type="text"  name="S_title" class="form-control" value="<?php echo $S_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >分类排序</label>
													<div class="col-md-9" style="position: relative;">
														<input type="text"  name="S_order" class="form-control" value="<?php echo $S_order?>">
														<label style="position: absolute;right: 25px;top: 10px;"><input type="checkbox" name="S_show" value="1" <?php if($S_show==1){echo "checked='checked'";}?> >首页展示</label>

													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >分类图片</label>
													<div class="col-md-9">
														<p><img src="<?php echo pic2($S_pic)?>" id="S_picx" class="showpic" onClick="showUpload('S_pic','S_pic','../media',1,null,'','');"></p>
														<div class="input-group">
															
						                                        <input type="text" id="S_pic" name="S_pic" class="form-control" value="<?php echo $S_pic?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('S_pic','S_pic','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >SEO关键词</label>
													<div class="col-md-9">
														<input type="text"  name="S_keywords" class="form-control" value="<?php echo $S_keywords?>" placeholder="多个词用,隔开">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >SEO描述</label>
													<div class="col-md-9">
														<textarea name="S_content" class="form-control"><?php echo $S_content?></textarea>
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
		<script src="assets/js/help.js"></script>

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
            			window.location.href="product_list.php";
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
