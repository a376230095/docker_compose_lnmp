<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
if($action=="save"){
	$evaluate=$_POST["evaluate"];
	file_put_contents("evaluate.txt",$evaluate);
	die("{\"code\":\"success\",\"msg\":\"保存成功\"}");
}
if($action=="creat"){
	$E_pid=intval($_POST["E_pid"]);
	$E_star=intval($_POST["E_star"]);
	$E_long=intval($_POST["E_long"]);
	$E_num=intval($_POST["E_num"]);
	$E_time=$_POST["E_time"];
	$E_mid=$_POST["E_mid"];
	if(count($E_mid)==0){
		die("{\"code\":\"error\",\"msg\":\"至少选择一个会员进行评价\"}");
	}

	$sql="select * from sl_product where P_id=$E_pid";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$P_title=$row["P_title"];
	$P_price=$row["P_price"];
	$P_pic=$row["P_pic"];
	$P_mid=$row["P_mid"];
	$P_sell=$row["P_sell"];
	$genkey=gen_key(20);

	mysqli_query($conn,"update sl_product set P_sold=P_sold+".$E_num." where P_id=".$E_pid);
	for($i==0;$i<$E_num;$i++){
		$mid=rand(0,count($E_mid)-1);
		$M_id=$E_mid[$mid];
		$time=date('Y-m-d H:i:s', strtotime ("+".($i*$E_long)." minutes +".rand(0,60)." seconds", strtotime($E_time)));
		mysqli_query($conn,"insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($E_pid,".$M_id.",'".$time."',0,$P_price,1,'$P_title','$P_pic',1,'','$P_sell','$genkey',$P_mid)");
		$O_id=getrs("select O_id from sl_orders where O_pid=$E_pid and O_mid=".$M_id." order by O_id desc limit 1","O_id");
		$j=rand(0,count(explode("\n",file_get_contents("evaluate.txt")))-1);
		$E_content=splitx(file_get_contents("evaluate.txt"),"\n",$j);

		mysqli_query($conn,"insert into sl_evaluate(E_mid,E_oid,E_star,E_content,E_time,E_reply) values(".$M_id.",$O_id,$E_star,'$E_content','".$time."','')");
	}
	die("{\"code\":\"success\",\"msg\":\"成功生成".$E_num."条评价\"}");
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>虚拟评价 - 后台管理</title>

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
		html{height: 100%}
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="evaluate.php?action=menu">评价管理</a></li>
                        </ol>
						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-6">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>生成虚拟评价</h4>
										</div>
										<div class="card-body">
											<div class="form-group row">
											<label class="col-md-3 col-form-label" >要评价的商品</label>
													<div class="col-md-9">
														<select name="E_pid" class="form-control">
															<?php
																$sql2="select * from sl_psort where S_del=0 and not S_sub=0 order by S_order,S_id desc";
																	$result2 = mysqli_query($conn, $sql2);
																	if (mysqli_num_rows($result2) > 0) {
																	while($row2 = mysqli_fetch_assoc($result2)) {
																		echo "<optgroup label=\"".$row2["S_title"]."\">";
																		$sql="select * from sl_product where P_del=0 and P_sort=".$row2["S_id"]." order by P_order,P_id desc";
																			$result = mysqli_query($conn, $sql);
																			if (mysqli_num_rows($result) > 0) {
																			while($row = mysqli_fetch_assoc($result)) {
																				$E_count=getrs("select count(*) as E_count from sl_evaluate,sl_member,sl_orders where E_del=0 and E_mid=M_id and E_oid=O_id and O_pid=".$row["P_id"],"E_count");
																				echo "<option value=\"".$row["P_id"]."\" ".$selected.">".$row["P_title"]."[".$E_count."条评价]</option>";
																			}
																		}
																		echo "</optgroup>";
																	}
																}
															?>
														</select>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >生成评价条数</label>
													<div class="col-md-9">
						                                <input type="text" name="E_num" class="form-control" value="10" placeholder="填写整数">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >评价星级</label>
													<div class="col-md-9">

						                                <select name="E_star" class="form-control">
						                                	<option value="1">1星</option>
						                                	<option value="2">2星</option>
						                                	<option value="3">3星</option>
						                                	<option value="4">4星</option>
						                                	<option value="5">5星</option>
						                                </select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >评价时间</label>
													<div class="col-md-9">
						                                <input type="text" name="E_time" class="form-control" value="<?php echo date('Y-m-d H:i:s')?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >评价间隔时间</label>
													<div class="col-md-9">
						                                <div class="input-group">
														<input type="text"  name="E_long" class="form-control" value="100">
														<span class="input-group-addon">分钟</span>
													</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >选取评价会员</label>
													<div class="col-md-9" style="max-height: 210px;overflow: auto;">
						                                <?php
						                                $sql="select * from sl_member where M_del=0 and not M_id=1 order by M_id desc";
															$result = mysqli_query($conn, $sql);
															if (mysqli_num_rows($result) > 0) {
															while($row = mysqli_fetch_assoc($result)) {
																echo "<label><input type=\"checkbox\" name=\"E_mid[]\" value=\"".$row["M_id"]."\">".htmlspecialchars($row["M_login"])."</label> ";
															}
														}
						                                ?>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-primary" type="button" onClick="creat()">生成评价</button>

													</div>
												</div>

										</div>
									</div>
	
									<p style="font-weight: bold;">功能介绍：</p>
									<p>该功能可以生成虚拟评价，为商品增加人气，评价内容会从右侧随机选取</p>
									<p>生成虚拟评价的同时会生成相应的订单记录</p>
									</form>
								</div>
						

								<div class="col-lg-6">
									<form id="form2">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>常用评价</h4>
										</div>
										<div class="card-body">
											<div class="form-group row">
													<label class="col-md-3 col-form-label" >常用评价</label>
													<div class="col-md-9">
						                                <textarea class="form-control" name="evaluate" rows="20" style="line-height: 23px;"><?php echo file_get_contents("evaluate.txt")?></textarea>
													</div>
												</div>
											

											<div class="form-group row">
												<label class="col-md-3 col-form-label" ></label>
												<div class="col-md-9">
													<button class="btn btn-primary" type="button" onClick="save()">保存</button>
													*设置评价模板，每行一个
												</div>
											</div>

										</div>
									</div>
	
									
									</form>
								</div>
							</div>
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
			$("#loading").show();
			toastr.warning('请稍等...','');
				$.ajax({
            	url:'?action=save',
            	type:'post',
            	data:$("#form2").serialize(),
            	success:function (data) {
            	$("#loading").hide();
	            	data=JSON.parse(data);
	            	if(data.code=="success"){
	            		toastr.clear();
	            		toastr.success(data.msg, "成功");
	            	}else{
	            		toastr.clear();
	            		toastr.error(data.msg, '错误');
	            	}
            	}
            });

		}

		function creat(){
			$("#loading").show();
			toastr.warning('请稍等...','');
				$.ajax({
            	url:'?action=creat',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	$("#loading").hide();
	            	data=JSON.parse(data);
	            	if(data.code=="success"){
	            		toastr.clear();
	            		toastr.success(data.msg, "成功");
	            	}else{
	            		toastr.clear();
	            		toastr.error(data.msg, '错误');
	            	}
            	}
            });

		}

		</script>
		
	</body>
</html>
