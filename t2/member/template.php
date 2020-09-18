<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if(time()-strtotime($M_sellertime)>$M_sellerlong*86400 && $C_fzk==1){//商家到期
	Header("Location:seller.php");
	die();
}

$template=json_decode(file_get_contents("http://106.12.118.146:83/template/template.json"),true);
$template=$template["list"];

$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);

if($action=="change"){
	$C_template=$_POST["C_template"];
	$C_wap=$_POST["C_wap"];

	mysqli_query($conn,"update sl_member set M_template='$C_template',M_wap='$C_wap' where M_id=$M_id");
	die("success");
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
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="会员中心">
  <title>会员中心 - <?php echo $C_title?></title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 
  <!--[if lt IE 9]>
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
  
</head>

<body class="body-index">
<?php require 'top.php';?>
		<div class="container m_top_10">
			<ol class="breadcrumb">
				<li><i class="icon fa-home" aria-hidden="true"></i><a href="../">首页</a></li>
				<li>用户信息</li>
				<li class="active">焦点图设置</li>
			</ol>
			<div class="yto-box">
				<div class="row">
					<div class="col-sm-2 hidden-xs">
	 <div class="my-avatar center-block p_bottom_10">
		<span class="avatar"> 
		      <img alt="..." src="../media/<?php echo $M_head?>"> 
		</span>
	</div>
	<h5 class="text-center p_bottom_10">您好！<?php echo $M_login?></h5>
	     <ul class="nav nav-pills nav-stacked">
	        <li><a href="config.php">基本设置</a></li>
	        <li><a href="contact.php">联系方式</a></li>
	        <li><a href="slide.php">焦点图设置</a></li>
	        <li class="active"><a href="template.php">模板设置</a></li>
	     </ul>
	 </div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">
							模板设置
						</div>
							<div class="table-responsive">
<form id="form">
								<table class="table table-striped">
<tr><td>编号</td><td>名称</td><td>模板图片</td><td>电脑端</td><td>手机端</td></tr>
<?php
$handler = opendir('../template');
while( ($filename = readdir($handler)) !== false ){
 if(is_dir("../template/".$filename) && $filename != "." && $filename != ".."){  
 	if($filename==$M_template){
 		$checked="checked='checked'";
 		$class="checked";
 	}else{
 		$checked="";
 		$class="";
 	}

 	if($filename==$M_wap){
 		$checked2="checked='checked'";
 		$class2="checked";
 	}else{
 		$checked2="";
 		$class2="";
 	}

 	echo "<tr><td>".$filename."</td><td>模板名称：".getValueByKey(json_encode($template),array('T_id',$filename),'T_title')."<br>展示类型：".getValueByKey(json_encode($template),array('T_id',$filename),'T_type')."</td><td><img src=\"http://www.fahuo100.cn/images/".$filename.".jpg\" height=\"80\" style=\"margin-right:10px;margin-bottom:5px;box-shadow: 0 2px 17px 2px rgb(222, 223, 241);\" alt=\"<img src='http://www.fahuo100.cn/images/".$filename.".jpg' width='500'>\"></td><td class=\"buy\"><input type=\"radio\" value=\"".$filename."\" name=\"C_template\" ".$checked." onclick=\"change()\"></td><td class=\"buy\"><input type=\"radio\" value=\"".$filename."\" name=\"C_wap\" ".$checked2." onclick=\"change()\"></td></tr>";
  }
}
											?>
												</table>
											</form>
					</div>
				</div>
				
			</div>
			</div>
			</div>
			
		</div>

	</div>
	
<?php 
require 'foot.php';
?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	<script>
function change(){
				$.ajax({
            	url:'?action=change',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		alert("切换成功");
            	}else{
            		alert("错误："+data);
            	}
            	}
            });

			}
	</script>
	
</body>
</html>