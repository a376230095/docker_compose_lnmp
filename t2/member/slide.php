<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if(time()-strtotime($M_sellertime)>$M_sellerlong*86400 && $C_fzk==1){//商家到期
	Header("Location:seller.php");
	die();
}

$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);

if($action=="del"){
	mysqli_query($conn,"update sl_slide set S_del=1 where S_id=$S_id and S_mid=$M_id");
	die("success");
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
	        <li class="active"><a href="slide.php">焦点图设置</a></li>
	        <li><a href="template.php">模板设置</a></li>
	     </ul>
	 </div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">
							焦点图管理
							<a href="slide_add.php" class="pull-right btn btn-primary btn-xs">新增焦点图</a>
						</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="40%">图片</th>
										<th width="20%">标题</th>
										<th width="20%">链接</th>
										<th width="10%">编辑</th>
										<th width="10%">删除</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_slide where S_mid=".$M_id." and S_del=0";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								
							        echo "<tr id=\"".$row["S_id"]."\">
							        <td><img src=\"".pic2($row["S_pic"])."\" height=\"50\"></td>
							        <td>".$row["S_title"]."</td>
							        <td>".$row["S_link"]."</td>
							        <td><a href=\"slide_add.php?S_id=".$row["S_id"]."\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\"></i> 编辑</a></td>
							        <td><a href=\"javascript:;\" onClick=\"del(".$row["S_id"].")\" class=\"btn btn-xs btn-danger\"><i class=\"fa fa-times\"></i> 删除</a></td>
							        </tr>";
							    }
							} 
									?>

									</tbody>
								</table>
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
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	<script>
function del(id){
			if (confirm("确定删除吗？")==true){
                $.ajax({
            	url:'?action=del&S_id='+id,
            	type:'post',
            	success:function (data) {
            	if(data=="success"){
            		$("#"+id).hide();
            	}else{
            		alert(data);
            	}
            	}
            });
                return true;
            }else{
                return false;
            }
}
	</script>
	
</body>
</html>