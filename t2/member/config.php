<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if(time()-strtotime($M_sellertime)>$M_sellerlong*86400 && $C_fzk==1){//商家到期
	Header("Location:seller.php");
	die();
}

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);
$action=$_GET["action"];

if($action=="edit"){
	$M_webtitle=htmlspecialchars($_POST["M_webtitle"]);
	$M_keyword=htmlspecialchars($_POST["M_keyword"]);
	$M_description=htmlspecialchars($_POST["M_description"]);
	$M_logo=htmlspecialchars($_POST["M_logo"]);
	$M_ico=htmlspecialchars($_POST["M_ico"]);
	$M_priceup=intval($_POST["M_priceup"]);
	$M_show=intval($_POST["M_show"]);
	$M_domain=htmlspecialchars($_POST["M_domain"]);
	$M_beian=htmlspecialchars($_POST["M_beian"]);
	$M_copyright=htmlspecialchars($_POST["M_copyright"]);
	$M_notice=htmlspecialchars($_POST["M_notice"]);
	//$M_code=$_POST["M_code"];

	if(strpos($M_domain,".")===false){
		box("域名格式错误！","back","error");
	}

	$sql="select * from sl_product";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($row["P_price2"]==0 && $row["P_price"]>0){
				mysqli_query($conn,"update sl_product set P_price2=P_price where P_id=".$row["P_id"]);
			}
	        if($row["P_price"]*(1+$M_priceup/100)<$row["P_price2"] && $row["P_price2"]>0){
	        	box("【".$row["P_title"]."】售价[".$row["P_price"]*(1+$M_priceup/100)."元]低于主站成本价[".$row["P_price2"]."元]，设置无效！","back","error");
	        }
	    }
	} 

	$sql="select * from sl_news";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($row["N_price2"]==0 && $row["N_price"]>0){
				mysqli_query($conn,"update sl_news set N_price2=N_price where N_id=".$row["N_id"]);
			}
	        if($row["N_price"]*(1+$M_priceup/100)<$row["N_price2"] && $row["N_price2"]>0){
	        	box("【".$row["N_title"]."】售价[".$row["N_price"]*(1+$M_priceup/100)."元]低于主站成本价[".$row["N_price2"]."元]，设置无效！","back","error");
	        }
	    }
	} 

	if($M_webtitle!=""){
		mysqli_query($conn,"update sl_member set M_webtitle='".$M_webtitle."',M_keyword='".$M_keyword."',M_description='".$M_description."',M_logo='".$M_logo."',M_ico='".$M_ico."',M_priceup=".$M_priceup.",M_show=".$M_show.",M_domain='".$M_domain."',M_beian='".$M_beian."',M_copyright='".$M_copyright."',M_notice='".$M_notice."' where M_id=".$M_id);
		box("修改成功！","config.php","success");
	}else{
		box("请填全信息!","back","error");
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
  <title>分站设置 -会员中心</title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 <style>
		.showpic{height: 50px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 300px}
</style>
  <!--[if lt IE 9]>
    <script src="http://ec.yto.net.cn/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="http://ec.yto.net.cn/assets/css/ie8.min.css">
    <script src="http://ec.yto.net.cn/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
	<script>
		var _ctxPath='';
	</script>    
</head>

<link rel="stylesheet" href="css/cropper.min.css">
<body id="crop-avatar" class="body-index">
  

<?php

require 'top.php';
?>
<div class="page">
<div class="container m_top_10">
			<ol class="breadcrumb">
				<li><i class="icon fa-home" aria-hidden="true"></i><a href="../">首页</a></li>
				<li>用户信息</li>
				<li class="active">基本设置</li>
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
	        <li class="active"><a href="config.php">基本设置</a></li>
	        <li><a href="contact.php">联系方式</a></li>
	        <li><a href="slide.php">焦点图设置</a></li>
	        <li><a href="template.php">模板设置</a></li>
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">

							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">分站标题</label>
								<div class="col-sm-6">
								    <input name="M_webtitle"  value="<?php echo $M_webtitle?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">分站关键词</label>
								<div class="col-sm-6">
								    <input name="M_keyword"  value="<?php echo $M_keyword?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">分站描述</label>
								<div class="col-sm-6">
									<textarea class="form-control" name="M_description"><?php echo $M_description?></textarea>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label class="col-md-2 control-label" >分站LOGO</label>
								<div class="col-md-6">
									<p><img src="../media/<?php echo $M_logo?>" id="M_logox" class="showpic" onClick="showUpload('M_logo','M_logo','../media',1,null,'','');" alt="<img src='../media/<?php echo $M_logo?>' class='showpicx'>"></p>
									<div class="input-group">
	                                        <input type="text" id="M_logo" name="M_logo" class="form-control" value="<?php echo $M_logo?>">
	                                        <span class="input-group-btn">
	                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('M_logo','M_logo','../media',1,null,'','');">上传</button>
	                                        </span>
	                                </div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" >分站ICON图标</label>
								<div class="col-md-6">
									<p><img src="../media/<?php echo $M_ico?>" id="M_icox" class="showpic" onClick="showUpload('M_ico','M_ico','../media',1,null,'','');" alt="<img src='../media/<?php echo $M_ico?>' class='showpicx'>"></p>
									<div class="input-group">
	                                        <input type="text" id="M_ico" name="M_ico" class="form-control" value="<?php echo $M_ico?>">
	                                        <span class="input-group-btn">
	                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('M_ico','M_ico','../media',1,null,'','');">上传</button>
	                                        </span>
	                                </div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">备案号</label>
								<div class="col-sm-6">
								    <input name="M_beian"  value="<?php echo $M_beian?>"  class="form-control" placeholder="可留空">
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">版权文字</label>
								<div class="col-sm-6">
									<textarea class="form-control" name="M_copyright"><?php echo $M_copyright?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">分站公告</label>
								<div class="col-sm-6">
									<textarea class="form-control" name="M_notice"><?php echo $M_notice?></textarea>
								</div>
							</div>

							<hr>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">分站模式</label>
								<div class="col-sm-6">
								   <label><input type="radio" name="M_show" value="0" <?php if($M_show==0){echo "checked='checked'";}?>> 展示主站内容</label>
								   <label><input type="radio" name="M_show" value="1" <?php if($M_show==1){echo "checked='checked'";}?>> 展示本店内容</label>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">绑定域名</label>
								<div class="col-sm-6">
								   <input name="M_domain"  value="<?php echo $M_domain?>"  class="form-control" >
								   <div style="font-size: 12px;margin-top: 10px;">请解析CNAME指向<b><?php echo $C_fdomain?></b>，如果不会解析域名请咨询客服</div>
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">分配子域名</label>
								<div class="col-sm-6" style="padding-top: 7px;">
								   <?php echo $M_id.".".str_replace("www.","",$C_fdomain)?>
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">价格浮动</label>
								<div class="col-sm-6">
									<div class="input-group">
							            <input name="M_priceup"  value="<?php echo $M_priceup?>"  class="form-control" >
							            <span class="input-group-addon">%</span>
							        </div>
							        <div style="font-size: 12px;margin-top: 10px;">*说明：在主站售价基础上浮动百分比（支持负数），<a href="price.php" target="_blank">点击查看</a>主站成本价<br>如果浮动后的价格低于主站成本价，则设置无效。</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="保存" class="btn btn-primary btn-block m_top_20" >
								</div>
							</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php require 'foot.php';?>
<script type="text/javascript" src="../upload/upload.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/page.js"></script>
</body>
</html>