<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';
require_once 'excel_reader.php';

$action=$_GET["action"];

if($action=="save"){
	$excel = $_POST["excel"];
	if($excel==""){
		die("{\"code\":\"error\",\"msg\":\"请上传excel文件\"}");
	}else{
		$n=0;
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('UTF-8');
		$data->read("../media/$excel");
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		   $p=$data->sheets[0]['cells'][$i];
		   if($p[1]!="" && intval($p[3])!=0){
				if(getrs("select S_id from sl_psort where S_del=0 and not S_sub=0 and S_id=".intval($p[3]),"S_id")!=""){
					$n=$n+1;
					mysqli_query($conn, "insert into sl_product(P_title,P_price,P_price2,P_sort,P_pic,P_order,P_selltype,P_rest,P_sell,P_unlogin,P_fx,P_tag,P_content,P_sh,P_vip,P_shuxing) values('".$p[1]."',".round($p[2],2).",".round($p[2],2).",".intval($p[3]).",'".$p[4]."',".intval($p[5]).",".intval($p[6]).",".intval($p[7]).",'".$p[8]."',".intval($p[9]).",".intval($p[10]).",'".$p[11]."','".$p[12]."',1,".$p[13].",'".str_replace("\n","\r\n",str_replace("：",":",$p[14]))."')");
				}
		   }
		}
		if($n==0){
			die("{\"code\":\"error\",\"msg\":\"导入失败，检查商品分类是否设置正确\"}");
		}else{
			die("{\"code\":\"success\",\"msg\":\"成功导入".$n."条数据\"}");
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>导入表格 - 后台管理</title>

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



		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">


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
                            <li class="breadcrumb-item"><a href="product_list.php">商品管理</a></li>
                            <li class="breadcrumb-item"><a href="psort_add.php">商品分类</a></li>
                            <li class="breadcrumb-item active"><a href="excel.php">导入EXCEL</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-6">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>导入Excel</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >上传表格</label>
													<div class="col-md-9">
														<div class="input-group">
										                    <input type="text" id="excel" class="form-control" name="excel" value="">
										                    <span class="input-group-btn">
										                        <button class="btn btn-primary" type="button" onClick="showUpload('excel','excel','../media',1,null,'','');">上传</button>
										                    </span>
										                </div>
													</div>
												</div>

											<div class="form-group row">
													<label class="col-md-3 col-form-label" >使用步骤</label>
													<div class="col-md-9">
														<p>1.点击下载<a href="https://fahuo100.cn/down/product.xls" target="_balnk"><u>示例表格</u></a>，按照里面的格式填写商品数据</p>
														<p>2.上传表格，点击导入按钮即可</p>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-primary" type="button" onClick="save()">导入</button>
													</div>
												</div>
										</div>
									</div>
	
									<p><b>注意事项：</b>（1）商品图片需提前上传到media文件夹内（2）商品不能直接归属到主分类，需归属到子分类</p>
									<p><b>条目介绍：</b><br>
										1.商品分类ID/卡密分类ID：可以从右侧参考<br>
										2.商品排序：填整数，数字越小，排序越靠前<br>
										3.发货类型：请填写整数，0：固定内容[自动发货] 1：卡密[自动发货] 2：实物[手动发货]<br>
										4.发货内容：当发货类型为0时，直接填写发货内容；当发货类型为1时，填写对应的卡密分类ID；当发货类型为2时，无需填写<br>
										5.库存：仅对发货类型为2时有效，其他发货类型填0即可<br>
										6.商品图片：如果有多张图用“|”隔开，示例：111.jpg|222.jpg|333.jpg，产品图需提前上传到media文件夹内<br>
										7.免登录购买/分销推广：0为不开启，1为开启<br>
										8.商品TAG：多个标签用空格隔开
									</p>
									</form>
								</div>
								<div class="col-lg-3">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>商品分类ID</h4>
										</div>
										
											<ul class="list-group">
											<?php 
													$sql="select * from sl_psort where S_del=0 and S_sub=0 order by S_order,S_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {

															echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row["S_id"]."\"><a href=\"#\" class=\"list-group-item ".$active."\"><b>└ ".$row["S_title"]."</b></a> </div>";

															$sql2="select * from sl_psort where S_del=0 and S_sub=".$row["S_id"]." order by S_order,S_id desc";
																$result2 = mysqli_query($conn, $sql2);
																if (mysqli_num_rows($result2) > 0) {
																while($row2 = mysqli_fetch_assoc($result2)) {

																	echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row2["S_id"]."\"><a href=\"#\" class=\"list-group-item ".$active2."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ ".$row2["S_title"]."（ID:".$row2["S_id"]."）</a></div>";

																}
															}
														}
													}
											?>
										</ul>
										
									</div>
								</div>

								<div class="col-lg-3">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>卡密分类ID</h4>
										</div>
										
											<ul class="list-group">
											<?php 
													$sql="select * from sl_csort where S_del=0 order by S_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {

															echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row["S_id"]."\"><a href=\"#\" class=\"list-group-item ".$active."\"><b>└ ".$row["S_title"]."（ID:".$row["S_id"]."）</b></a> </div>";

														}
													}
											?>
										</ul>
										
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
		function save(){
				$.ajax({
            	url:'?action=save',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            		data=JSON.parse(data);
            		if(data.code=="success"){
            		toastr.success(data.msg, "成功");
            		setTimeout("window.location.href='product_list.php'", 2000 )
            	}else{
            		toastr.error(data.msg, '错误');
            	}
            	}
            });

			}

		</script>
		
	</body>
</html>
