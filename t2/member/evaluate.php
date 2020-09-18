<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];
$O_id=intval($_GET["id"]);

$sql="select * from sl_orders where O_mid=".$M_id." and O_id=".$O_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
	$O_pic=$row["O_pic"];
	$O_title=$row["O_title"];
}else{
	box("您未购买过此商品","back","error");
}

if(getrs("select * from sl_evaluate where E_mid=$M_id and E_oid=$O_id","E_id")!=""){
	box("您已做过评价","back","error");
}

if($action=="evaluate"){
	$E_star=intval($_POST["E_star"]);
	$E_content=t($_POST["E_content"]);

	if($E_content!=""){
		mysqli_query($conn,"insert into sl_evaluate(E_mid,E_oid,E_star,E_content,E_time,E_reply) values($M_id,$O_id,$E_star,'$E_content','".date('Y-m-d H:i:s')."','')");
		box("提交成功！","product.php","success");
	}else{
		box("请填全资料!","back","error");
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
  <title>商品评价 - 会员中心</title>
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
				<li class="active">商品评价</li>
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
	        <li><a href="edit.php">基本信息</a></li>
	        <li><a href="address.php">收货地址</a></li>
            <li><a href="pwdedit.php">密码修改</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=evaluate&id=<?php echo $O_id?>" class="form-horizontal" id="form">
                           
							
							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">商品名</label>
								<div class="col-sm-6">
								   <?php echo $O_title?>
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">商品图</label>
								<div class="col-sm-6">
								   <img src="../media/<?php echo $O_pic?>" width="100">
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">星级评价</label>
								<div class="col-sm-6">
								   <select class="form-control" name="E_star">
								   	<option value="1">1星</option>
								   	<option value="2">2星</option>
								   	<option value="3">3星</option>
								   	<option value="4">4星</option>
								   	<option value="5">5星</option>
								   </select>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">文字评价</label>
								<div class="col-sm-6">
								   <textarea class="form-control" rows="5" name="E_content"><?php echo $E_content?></textarea>
								</div>
							</div>

							
														
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="确定" class="btn btn-primary btn-block m_top_20" >
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

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/page.js"></script>
  <script src="js/yto_cityselect.js"></script>
  <script src="js/cropper.min.js"></script>
  <script src="js/cropper-set.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>
 <script type="text/javascript">
	  $(function() {
		  'use strict';
		  setTimeout(function(){
	          $("#error:parent").removeClass("hidden");
	          },200);

		  $("#address").citySelect();
		  
		  $('#birthday').datetimepicker({
			    format: 'yyyy-mm-dd',
			    startDate: '1950-01-01',
			    endDate: '2020-12-30',
			    weekStart : 1,
				todayBtn : 1,
				autoclose : 1,
				initialDate:'1985-01-01',
				todayHighlight : 1,
				startView : 4,
				minView : 2,
				fontAwesome:true,
				forceParse : 0,
				linkFormat: 'yyyy-mm-dd',
		        linkField:'birthday_hidden'
			});

	  });
	</script>
	
	

</body>
</html>