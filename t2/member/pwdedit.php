<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action = $_GET["action"];
$sql = "Select * from sl_member Where M_id=" . $M_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_pwd = $row["M_pwd"];

if ($action == "edit") {
	if($_POST["M_newpwd"] != $_POST["M_newpwd2"]){
		box("两次新密码不一致!" , "back", "error");
	}else{
	    if (md5($_POST["M_pwd"]) == $M_pwd) {
	        $sql = "select * from sl_member where M_id=" . $M_id;
	        $result = mysqli_query($conn, $sql);
	        if (mysqli_num_rows($result) > 0) {
	            mysqli_query($conn, "update sl_member set M_pwd='" . md5($_POST["M_newpwd"]) . "' where M_id=" . $M_id);
	        }
			$_SESSION["M_id"]="";
			$_SESSION["M_login"]="";
			$_SESSION["M_pwd"]="";

	        box("修改成功", "login.php", "success");
	    } else {

	        box("旧密码输入错误!" , "back", "error");
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

		<div class="page">
<div class="container m_top_10">
			<ol class="breadcrumb">
				<li><i class="icon fa-home" aria-hidden="true"></i><a href="../">首页</a></li>
				<li>用户信息</li>
				<li class="active">密码修改</li>
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
	        <li ><a href="edit.php">基本信息</a></li>
	        <li><a href="address.php">收货地址</a></li>
            <li class="active"><a href="pwdedit.php">密码修改</a></li>
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
                           
							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">昵称</label>
								<div class="col-sm-4">
								   <input name="M_login" value="<?php echo $M_login?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">原密码</label>
								<div class="col-sm-4">
								   <input type="password" name="M_pwd" value="" class="form-control" placeholder="原密码">
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">新密码</label>
								<div class="col-sm-4">
								   <input type="password" name="M_newpwd"  value="" class="form-control" placeholder="新密码">
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">确认密码</label>
								<div class="col-sm-4">
								   <input type="password" name="M_newpwd2"  value="" class="form-control" placeholder="确认密码">
								</div>
							</div>
														
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="确认修改" class="btn btn-primary btn-block m_top_20" >
								</div>
							</div>
</form>
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
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	
</body>
</html>