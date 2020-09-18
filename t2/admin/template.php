<?php
ini_set("max_execution_time",600);
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$template=json_decode(file_get_contents("http://106.12.118.146:83/template/template.json"),true);
$template=$template["list"];

$action=$_GET["action"];
$id="t".intval(substr($_GET["id"],1));

if($action=="change"){
	$C_template=$_POST["C_template"];
	$C_wap=$_POST["C_wap"];

	if($C_template=="" || $C_wap==""){
		die("请填全信息");
	}else{
		mysqli_query($conn,"update sl_config set C_template='$C_template',C_wap='$C_wap'");
		mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','切换模板')");
		die("success");
	}
}
if($action=="del"){
	removeDir("../template/".$id);
	die("success");
}

if($action=="download"){
	download("template",$id);
	die("success");
}

Function download($T_type,$T_id){

$strLocalPath="../".$T_type."/".$T_id."/";
flush();
ob_flush();
$url="http://106.12.118.146:83/template/fahuo_".$T_id.".xml";

$GLOBALS['xml']=file_get_contents($url);
	if ($GLOBALS['xml']) {
		$xml = simplexml_load_string($GLOBALS['xml'],'SimpleXMLElement');
		$old = umask(0);
		foreach ($xml->file as $f) {
			$filename=$strLocalPath.$f->path;
			$filename=str_replace('\\','/',$filename);
			$dirname= dirname($filename);
			if(!is_dir($dirname)){
				mkdir($dirname,0755,true);
			}
			$fn=$filename;
			file_put_contents($fn,base64_decode($f->stream));
		}
		umask($old);
	} else {
		exit('release.xml不存在!');
	}
}

function getValueByKey($json_str,$limit=array(),$key){ 
    $arr=json_decode($json_str,true);
    foreach($arr as $v){
        if($v[$limit[0]]==$limit[1]){
            return $v[$key];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>模板设置 - 后台管理</title>

		<!--favicon -->
		<link rel="icon" href="../media/<?php echo $C_ico?>" type="image/x-icon"/>
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

		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">
		<link rel="stylesheet" href="assets/plugins/toaster/garessi-notif.css">

		<script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 50px;border: solid 1px #DDDDDD;padding: 5px;}
.buy label {
	width: 20px;
	height: 20px;
	text-align: center;
	line-height: 16px;
	cursor: pointer;
	border: #CCCCCC solid 2px;
	border-radius: 100%;
	color: #CCCCCC;
	font-weight: bold;
}

.buy .checked {
	border: #ff0000 solid 2px;
	border-radius: 100%;
	color: #ff0000;
}

.buy input[type="radio"] {
	display: none;
}
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
                            <li class="breadcrumb-item active" aria-current="page">模板设置</li>
                        </ol>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-6">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>本地模板</h4>
										</div>
										
												<table class="table table-striped">
<tr><td>编号</td><td>名称</td><td>模板图片</td><td>电脑端</td><td>手机端</td><td>删除</td></tr>

<?php
$handler = opendir('../template');
while( ($filename = readdir($handler)) !== false ){
 if(is_dir("../template/".$filename) && $filename != "." && $filename != ".."){  
 	if($filename==$C_template){
 		$checked="checked='checked'";
 		$class="checked";
 	}else{
 		$checked="";
 		$class="";
 	}

 	if($filename==$C_wap){
 		$checked2="checked='checked'";
 		$class2="checked";
 	}else{
 		$checked2="";
 		$class2="";
 	}

 	echo "<tr><td>".$filename."</td><td>模板名称：".getValueByKey(json_encode($template),array('T_id',$filename),'T_title')."<br>展示类型：".getValueByKey(json_encode($template),array('T_id',$filename),'T_type')."</td><td><img src=\"http://www.fahuo100.cn/images/".$filename.".jpg\" height=\"80\" style=\"margin-right:10px;margin-bottom:5px;box-shadow: 0 2px 17px 2px rgb(222, 223, 241);\" alt=\"<img src='http://www.fahuo100.cn/images/".$filename.".jpg' width='500'>\"></td><td class=\"buy\"><label aa=\"C_template\" class=\"".$class."\"><input type=\"radio\" value=\"".$filename."\" name=\"C_template\" ".$checked." onclick=\"change()\">●</label></td><td class=\"buy\"><label aa=\"C_wap\" class=\"".$class2."\"><input type=\"radio\" value=\"".$filename."\" name=\"C_wap\" ".$checked2." onclick=\"change()\">●</label></td>";



 	echo "<td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"del('".$filename."')\">删除</button></td></tr>";
  }
}
											?>
												</table>
										
									</div>
								</div>
<style>
.tbox{display: inline-block;border:solid 1px #EEEEEE;text-align: center;padding: 10px;border-radius: 10px;box-sizing: border-box;margin-bottom: 10px;box-shadow: 0 2px 17px 2px rgb(222, 223, 241);}
.tbox img{width: 100%;margin-bottom: 20px;}
</style>
								<div class="col-lg-6">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>在线模板库</h4>
										</div>
										<div class="card-body">
											<ul class="nav nav-tabs" id="myTab2" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" id="home-tab2" data-toggle="tab" href="#t1" role="tab" aria-controls="home" aria-selected="true">电脑端模板</a>
												</li>
												
												<li class="nav-item">
													<a class="nav-link" id="profile-tab2" data-toggle="tab" href="#t2" role="tab" aria-controls="profile" aria-selected="false">手机端模板</a>
												</li>
											</ul>
											<div class="tab-content tab-bordered" id="myTab2Content">
												<div class="tab-pane fade show active" id="t1" role="tabpanel" aria-labelledby="home-tab2">
											<div class="row">
											<?php


foreach($template as $v) {
	if(strpos($v["T_type"],"PC")!==false){
		if(is_dir("../template/".$v["T_id"])){
			$T_info="<button type=\"button\" class=\"btn btn-sm btn-warning\">已安装</button>";
		}else{
			$T_info="<button type=\"button\" class=\"btn btn-sm btn-info\" onClick=\"download('".$v["T_id"]."')\">下载</button>";
		}
		echo "<div class=\"col-md-4\">
		<div class=\"tbox \">
		<a href=\"http://www.fahuo100.cn/template_show.html?T_id=".$v["T_id"]."\" target=\"_blank\"><img src=\"http://www.fahuo100.cn/images/".$v["T_id"].".jpg\" alt=\"<img src='http://www.fahuo100.cn/images/".$v["T_id"].".jpg' width='500'>\"></a>
		<b>".$v["T_id"]."</b>-".$v["T_title"]."
		".$T_info."
		</div>
		</div>";
	}
}

											?>
</div>
</div>
<div class="tab-pane fade show" id="t2" role="tabpanel" aria-labelledby="home-tab2">
	<div class="row">
											<?php

foreach($template as $v) {
	if(strpos($v["T_type"],"WAP")!==false){
		if(is_dir("../template/".$v["T_id"])){
			$T_info="<button type=\"button\" class=\"btn btn-sm btn-warning\">已安装</button>";
		}else{
			$T_info="<button type=\"button\" class=\"btn btn-sm btn-info\" onClick=\"download('".$v["T_id"]."')\">下载</button>";
		}
		echo "<div class=\"col-md-4\">
		<div class=\"tbox \">
		<a href=\"http://www.fahuo100.cn/template_show.html?T_id=".$v["T_id"]."\" target=\"_blank\"><img src=\"http://www.fahuo100.cn/images/".$v["T_id"]."_wap.jpg\"></a>
		<b>".$v["T_id"]."</b>-".$v["T_title"]."
		".$T_info."
		</div>
		</div>";
	}
}

											?>
</div>
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
		function change(){
				$.ajax({
            	url:'?action=change',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		toastr.success("切换成功", "成功");
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });

			}

			function download(id){
				toastr.warning('模板下载中，请稍等...','');
				$.ajax({
            	url:'?action=download&id='+id,
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		toastr.success("下载成功", '成功');
            		window.location="template.php";
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });

			}

function del(id){
	if (confirm("确定删除模板吗？")==true){
				$.ajax({
            	url:'?action=del&id='+id,
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		location.reload();
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });
		return true;
	}else{
		return false;
	}
}
$(function() { $('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});
		</script>
		
	</body>
</html>
