<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$dirx=splitx($_SERVER["PHP_SELF"],$C_admin,0);

if($action=="count"){
	$genkey=trim($_POST["genkey"]);
	$info=getbody("http://hy.fahuo100.cn/api.php","action=count&genkey=".$genkey."&domain=".$_SERVER['HTTP_HOST']);
	if($info=="error"){
		die("{\"code\":\"error\",\"msg\":\"未发现该采购码，请检查！\"}");
	}else{
		if($info=="error2"){
			die("{\"code\":\"error\",\"msg\":\"该采购码已使用\"}");
		}else{
			die("{\"code\":\"success\",\"msg\":\"$info\"}");
		}
	}
}

if($action=="import"){
	$id=intval($_GET["id"]);
	$genkey=trim($_POST["genkey"]);
	$price=$_POST["price"];
	$sort=$_POST["sort"];
	$info=getbody("http://hy.fahuo100.cn/api.php","action=item&P_id=".$id."&genkey=".$genkey."&domain=".$_SERVER['HTTP_HOST']);
	if($info=="error"){
		die("{\"code\":\"error\",\"msg\":\"未发现该采购码，请检查！\"}");
	}else{
		if($info=="error2"){
			die("{\"code\":\"error\",\"msg\":\"该采购码已使用\"}");
		}else{
			if($info=="error3"){
				die("{\"code\":\"error\",\"msg\":\"未找到该商品\"}");
			}else{
				$info=json_decode($info,true);
				if(getrs("select P_id from sl_product where P_title='".$info["P_title"]."' and P_del=0","P_id")==""){
					mysqli_query($conn, "insert into sl_product(P_title,P_price,P_price2,P_sort,P_pic,P_order,P_selltype,P_rest,P_sell,P_unlogin,P_fx,P_tag,P_content,P_sh,P_vip) values('".$info["P_title"]."',".round($price).",".round($price).",".intval($sort).",'".downpic("../media/",$info["P_pic"])."',0,0,0,'".$info["P_sell"]."',1,1,'','".savepic($info["P_content"],$dirx)."',1,1)");
					die("{\"code\":\"success\",\"msg\":\"".$info["P_title"]."\"}");
				}else{
					mysqli_query($conn, "update sl_product set P_sell='".$info["P_sell"]."' where P_title='".$info["P_title"]."'");
					die("{\"code\":\"error\",\"msg\":\"《".$info["P_title"]."》已更新\"}");
				}
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>货源采购 - 后台管理</title>

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

						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-5">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>导入数据</h4>
										</div>
										<div class="card-body">
											<div class="form-group row">
											<label class="col-md-3 col-form-label" >导入分类</label>
													<div class="col-md-9">
														<select name="sort" class="form-control">
															<?php
																$sql2="select * from sl_psort where S_del=0 and S_sub=0 order by S_order,S_id desc";
																	$result2 = mysqli_query($conn, $sql2);
																	if (mysqli_num_rows($result2) > 0) {
																	while($row2 = mysqli_fetch_assoc($result2)) {
																		echo "<optgroup label=\"".$row2["S_title"]."\">";
																		$sql="select * from sl_psort where S_del=0 and S_sub=".$row2["S_id"]." order by S_order,S_id desc";
																			$result = mysqli_query($conn, $sql);
																			if (mysqli_num_rows($result) > 0) {
																			while($row = mysqli_fetch_assoc($result)) {
																				if($P_sort==$row["S_id"]){
																					$selected="selected";
																				}else{
																					$selected="";
																				}
																				echo "<option value=\"".$row["S_id"]."\" ".$selected.">".$row["S_title"]."</option>";
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
													<label class="col-md-3 col-form-label" >设置售价</label>
													<div class="col-md-9">
						                                <div class="input-group">
														<input type="text"  name="price" class="form-control" value="10">
														<span class="input-group-addon">元</span>
													</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >采购码</label>
													<div class="col-md-9">
						                                <input type="text" name="genkey" class="form-control" value="">
													</div>
												</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >使用步骤</label>
													<div class="col-md-9">
														<p>1.从右侧采购商品，得到一个20位采购码</p>
														<p>2.填入采购码，点击导入数据</p>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-primary" type="button" onClick="count()">导入数据</button>
														<span id="loading" style="display: none"><img src="https://hy.fahuo100.cn/images/loading.gif"> 数据导入中，请勿关闭该页面...</span>
														<div class="progress progress-striped active" style="display: none;margin-top: 10px" id="progressx">
														    <div class="progress-bar progress-bar-success" role="progressbar"
														         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
														         style="width: 0%;" id="progress">
														    </div>
														</div>
													</div>
												</div>

										</div>
									</div>
	
									<p style="font-weight: bold;">功能介绍：</p>
									<p>新网站往往缺少素材，本页面提供海量的商品，可供导入到您自己的网站；</p>
									<p>全部为真实的商品，可以自己定价及出售给用户。</p>
									<p>商品均为可重复发货内容，一次进货，可无限次发货</p>
									</form>
								</div>

								<div class="col-lg-7">
									<div class="card card-primary">
										<a href="https://hy.fahuo100.cn?from=<?php echo $_SERVER["HTTP_HOST"]?>" target="_blank" class="btn btn-info" style="position: absolute;top: 15px;right: 130px;">全屏显示</a>
										<iframe src='https://hy.fahuo100.cn?from=<?php echo $_SERVER["HTTP_HOST"]?>' id="hy" name='mapif' type='1' frameborder='0' width='100%'></iframe>
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
		function count(){
			$("#loading").show();
			$("#progressx").show();
			$.ajax({
		    	url:'?action=count',
		    	type:'post',
		    	data:$("#form").serialize(),
		    	success:function (data) {
			    	data=JSON.parse(data);
			    	if(data.code=="success"){
			    		$count=data.msg.split(",");
						for(var i = 0; i < $count.length; i++) {
						    imports($count[i],i,$count.length);
						}
			    	}else{
			    		toastr.error(data.msg, '错误');
			    	}
		    	}
		    });
		}

		function imports(id,i,count){
			$.ajax({
		    	url:'?action=import&id='+id,
		    	type:'post',
		    	data:$("#form").serialize(),
		    	success:function (data) {
			    	data=JSON.parse(data);
			    	$("#progress").attr("style","width: "+(((i+1)/count)*100)+"%");
                	$("#progress").html((((i+1)/count)*100).toFixed(2)+"%");

			    	if(data.code=="success"){
			    		toastr.success("《"+data.msg+"》导入成功", "成功");
			    	}else{
			    		toastr.error(data.msg, '错误');
			    	}

					console.log(i);
				    console.log(count);
				    if(i==count-1){
						$("#loading").hide();
					}

		    	}
		    });
		    
		}

		$("#hy").height($(window).height()-122);
		</script>
		
	</body>
</html>
