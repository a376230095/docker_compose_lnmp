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
		   if($p[1]!="" && intval($p[6])!=0){
				if(getrs("select S_id from sl_nsort where S_del=0 and not S_sub=0 and S_id=".intval($p[6]),"S_id")!=""){
					$n=$n+1;
					mysqli_query($conn, "insert into sl_news(N_title,N_content,N_pic,N_order,N_price,N_price2,N_sort,N_author,N_view,N_tag,N_date,N_sh) values('".$p[1]."','".$p[2]."','".$p[3]."',".intval($p[4]).",".round($p[5],2).",".round($p[5],2).",".intval($p[6]).",'".$p[7]."',".intval($p[8]).",'".$p[9]."','".date('Y-m-d H:i:s')."',1)");
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
                            <li class="breadcrumb-item"><a href="news_list.php">文章管理</a></li>
                            <li class="breadcrumb-item"><a href="nsort_add.php">文章分类</a></li>
                            <li class="breadcrumb-item active"><a href="excel_news.php">导入EXCEL</a></li>
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
														<p>1.点击下载<a href="https://fahuo100.cn/down/news.xls" target="_balnk"><u>示例表格</u></a>，按照里面的格式填写文章数据</p>
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
	
									<p><b>注意事项：</b>（1）文章图片需提前上传到media文件夹内（2）文章不能直接归属到主分类，需归属到子分类</p>
									<p><b>条目介绍：</b><br>
										1.文章分类：可以从右侧参考<br>
										2.文章排序：填整数，数字越小，排序越靠前<br>
										3.文章图片：文章图需提前上传到media文件夹内<br>
										4.文章TAG：多个标签用空格隔开
									</p>
									</form>
								</div>
								<div class="col-lg-6">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>文章分类ID</h4>
										</div>
										
											<ul class="list-group">
											<?php 
													$sql="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {

															echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row["S_id"]."\"><a href=\"#\" class=\"list-group-item ".$active."\"><b>└ ".$row["S_title"]."</b></a> </div>";

															$sql2="select * from sl_nsort where S_del=0 and S_sub=".$row["S_id"]." order by S_order,S_id desc";
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
            		setTimeout("window.location.href='news_list.php'", 2000 )
            	}else{
            		toastr.error(data.msg, '错误');
            	}
            	}
            });

			}

		</script>
		
	</body>
</html>
