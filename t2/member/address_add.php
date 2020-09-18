<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];
$A_id=intval($_GET["A_id"]);

if($A_id!=""){
	$aa="edit&A_id=".$A_id;
	$sql="select * from sl_address where A_id=".$A_id." and A_mid=".$_SESSION["M_id"];
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$A_address=$row["A_address"];
		$A_name=$row["A_name"];
		$A_phone=$row["A_phone"];
	}
}else{
	$aa="add";
}

if($action=="edit"){
	$A_address=removexss($_POST["A_address"]);
	$A_name=removexss($_POST["A_name"]);
	$A_phone=removexss($_POST["A_phone"]);
	$A_default=intval($_POST["A_default"]);
	if($A_default==1){
		mysqli_query($conn,"update sl_address set A_default=0 where A_mid=".$_SESSION["M_id"]);
	}
	if($A_name!=""){
		mysqli_query($conn,"update sl_address set A_address='$A_address',A_name='$A_name',A_phone='$A_phone',A_default=$A_default where A_id=".$A_id." and A_mid=".$_SESSION["M_id"]);
		box("修改成功！","address.php","success");
	}else{
		box("请填全资料!","back","error");
	}
}

if($action=="add"){
	$A_address=removexss($_POST["A_address"]);
	$A_name=removexss($_POST["A_name"]);
	$A_phone=removexss($_POST["A_phone"]);
	$A_default=intval($_POST["A_default"]);

	if($A_default==1){
		mysqli_query($conn,"update sl_address set A_default=0 where A_mid=".$_SESSION["M_id"]);
	}

	if($A_name!=""){
		mysqli_query($conn,"insert into sl_address(A_name,A_address,A_phone,A_mid,A_default) values('$A_name','$A_address','$A_phone',".$_SESSION["M_id"].",$A_default)");
		box("新增成功！","address.php","success");
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
  <title>编辑收货地址 - 会员中心</title>
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
				<li class="active">收货地址修改</li>
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
	        <li class="active"><a href="address.php">收货地址</a></li>
            <li><a href="pwdedit.php">密码修改</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=<?php echo $aa?>" class="form-horizontal" id="form">
                           
							
							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">收件人</label>
								<div class="col-sm-6">
								   <input name="A_name" value="<?php echo $A_name?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">手机号</label>
								<div class="col-sm-6">
								   <input name="A_phone" value="<?php echo $A_phone?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">收件地址</label>
								<div class="col-sm-6">
								   <textarea class="form-control" rows="5" name="A_address"><?php echo $A_address?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">设为默认</label>
								<div class="col-sm-6">
								   <select class="form-control" name="A_default">
								   	<option value="1">是</option>
								   	<option value="0">否</option>
								   </select>
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