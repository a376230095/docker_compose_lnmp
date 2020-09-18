<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
if($action=="save"){

$xmls=file_get_contents("../template/".$C_template."/config.xml");
$xml =simplexml_load_string($xmls);

$config_data="<?xml version='1.0' encoding='utf-8'?><xml>".PHP_EOL;
for($i=0;$i<count($xml->page);$i++){

	$config_data=$config_data."<page title='".$xml->page[$i]["title"]."'>".PHP_EOL;
    for($j=0;$j<count($xml->page[$i]->tag);$j++){

        $config_data=$config_data."<tag><title>".$xml->page[$i]->tag[$j]->title."</title><content><![CDATA[".stripslashes($_POST["C_".$i.$j])."]]></content><en><![CDATA[".stripslashes($_POST["E_".$i.$j])."]]></en><type>".$xml->page[$i]->tag[$j]->type."</type><url><![CDATA[".stripslashes($_POST["U_".$i.$j])."]]></url></tag>".PHP_EOL;

    }
    $config_data=$config_data."</page>".PHP_EOL;
}
$config_data=$config_data."</xml>";

file_put_contents("../template/".$C_template."/config.xml",$config_data);
die("{\"code\":\"success\",\"msg\":\"保存成功！\"}");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>自定义设置 - 后台管理</title>

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
								
								<div class="col-lg-12">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>自定设置</h4>
										</div>

									<?php
									if(is_file("../template/$C_template/config.xml")){


$xmls=file_get_contents("../template/".$C_template."/config.xml");

$xml =simplexml_load_string($xmls);
for($i=0;$i<count($xml->page);$i++){

	$config2=$config2. "<tr><td rowspan='".count($xml->page[$i])."' scope='col' bgcolor='#F7F7F7' align='center'><b>".$xml->page[$i]["title"]."</b></td>";

	for($j=0;$j<count($xml->page[$i]->tag);$j++){

switch($xml->page[$i]->tag[$j]->type){

case "text":

if($j==0){
$config2=$config2. "<td scope='col' align='center'>".$xml->page[$i]->tag[$j]->title."</td><td scope='col'><textarea class='form-control' name='C_".$i.$j."' cols='40' rows='3'>".$xml->page[$i]->tag[$j]->content."</textarea></td><td scope='col'><textarea class='form-control' name='E_".$i.$j."' cols='40' rows='3'>".$xml->page[$i]->tag[$j]->en."</textarea></td><td>".$xml->page[$i]->tag[$j]->type."</td><td scope='col'><input type='text' value='".$xml->page[$i]->tag[$j]->url."' name='U_".$i.$j."' id='U_".$i.$j."' class='form-control'></td></tr>";
}else{
$config2=$config2. "<tr><td align='center'>".$xml->page[$i]->tag[$j]->title."</td><td><textarea class='form-control' name='C_".$i.$j."' cols='40' rows='3'>".$xml->page[$i]->tag[$j]->content."</textarea></td><td><textarea class='form-control' name='E_".$i.$j."' cols='40' rows='3'>".$xml->page[$i]->tag[$j]->en."</textarea></td><td>".$xml->page[$i]->tag[$j]->type."</td><td><input type='text' class='form-control' value='".$xml->page[$i]->tag[$j]->url."' name='U_".$i.$j."' id='U_".$i.$j."' class='form-control'></td></tr>";
}
break;
case "img":

if($j==0){
$config2=$config2. "<td scope='col' align='center'>".$xml->page[$i]->tag[$j]->title."</td><td scope='col'><img class='L_pic' src='../template/".$C_template."/images/".$xml->page[$i]->tag[$j]->content."' width='100' id='C_".$i.$j."x' alt='<img src=../template/".$C_template."/images/".$xml->page[$i]->tag[$j]->content." width=400>'><div class='input-group'><input type='text' value='".$xml->page[$i]->tag[$j]->content."' name='C_".$i.$j."' id='C_".$i.$j."' class='form-control'> <span class='input-group-btn'><button class='btn btn-info' type='button' onclick=\"showUpload('C_".$i.$j."','C_".$i.$j."','../template/".$C_template."/images');\">上传文件</button></span></div></td><td scope='col'><input type='text' value='".$xml->page[$i]->tag[$j]->en."' name='E_".$i.$j."' id='E_".$i.$j."' class='form-control'></td><td scope='col'>".$xml->page[$i]->tag[$j]->type."</td><td scope='col'><input type='text' value='".$xml->page[$i]->tag[$j]->url."' name='U_".$i.$j."' id='U_".$i.$j."' class='form-control'></td></tr>";
}else{
$config2=$config2. "<tr><td align='center'>".$xml->page[$i]->tag[$j]->title."</td><td><img class='L_pic' src='../template/".$C_template."/images/".$xml->page[$i]->tag[$j]->content."' width='100' id='C_".$i.$j."x' alt='<img src=../template/".$C_template."/images/".$xml->page[$i]->tag[$j]->content." width=400>'><div class='input-group'><input type='text' value='".$xml->page[$i]->tag[$j]->content."' name='C_".$i.$j."' id='C_".$i.$j."' class='form-control'> <span class='input-group-btn'><button class='btn btn-info' type='button' onclick=\"showUpload('C_".$i.$j."','C_".$i.$j."','../template/".$C_template."/images');\">上传文件</button></span></div></td><td><input type='text' value='".$xml->page[$i]->tag[$j]->en."' name='E_".$i.$j."' id='E_".$i.$j."' class='form-control'></td><td>".$xml->page[$i]->tag[$j]->type."</td><td><input type='text' value='".$xml->page[$i]->tag[$j]->url."' name='U_".$i.$j."' id='U_".$i.$j."' class='form-control'></td></tr>";
}

break;
}

	}
}

if($config2!=""){
$config2="<table class='table table-striped' style='min-width:1000px;'><tr><td width='10%'>页面</td><td width='10%'>标签名称</td><td width='30%'>内容</td><td width='25%'>内容（第二语言）</td><td width='5%'>类型</td><td width='20%'>链接</td></tr>".$config2."<tr><td></td><td></td><td><button type='button' class='btn btn-info' onclick='save()'>保存</button></td><td></td><td></td><td></td></tr></table>";
}else{
$config2="<div style='margin:20px;'>本模板不需要自定义设置！</div>";
}
echo $config2;
									}else{
										echo "本模板不需要自定义设置！";
									}
									?>

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
