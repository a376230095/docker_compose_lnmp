<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];
if($action=="del"){
	$A_id=intval($_GET["A_id"]);
	mysqli_query($conn,"update sl_address set A_del=1 where A_id=".$A_id." and A_mid=".$_SESSION["M_id"]);
	box("删除成功","address.php","success");
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

		<div class="container m_top_30">
					<div class="yto-box">
						<h5>收货信息</h5>
						<a href="address_add.php" class="btn btn-sm btn-primary pull-right" style="margin-top: -40px">新增收货地址</a>
						<div class="panel panel-default">
							<div class="panel-heading">收货信息</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="50%">收件地址</th>
										<th width="15%">收件人</th>
										<th width="15%">手机号</th>
										<th width="10%">编辑</th>
										<th width="10%">删除</th>

									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_address where A_del=0 and A_mid=".$M_id." order by A_id desc";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								if($row["A_default"]==1){
									$d="[默认]";
								}else{
									$d="";
								}
							        echo "<tr>
							        <td>".$d.$row["A_address"]."</td>
							        <td>".$row["A_name"]."</td>
							        <td>".$row["A_phone"]."</td>
							        <td><a href=\"address_add.php?A_id=".$row["A_id"]."\" class=\"btn btn-xs btn-primary\">编辑</a></td>
							        <td><a href=\"?action=del&A_id=".$row["A_id"]."\" class=\"btn btn-xs btn-danger\">删除</a></td>
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