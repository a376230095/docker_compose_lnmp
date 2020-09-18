<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$type=$_GET["type"];

$action=$_GET["action"];
if($action=="del"){
	$C_id=intval($_GET["C_id"]);
	mysqli_query($conn,"delete from sl_colletion where C_mid=".$_SESSION["M_id"]." and C_id=$C_id");
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
				<div class="row">
					<div class="col-sm-2 hidden-xs">
			<h5 class="p_bottom_10">我的收藏</h5>
		<ul class="nav nav-pills nav-stacked">
	        <li class="<?php if($type==0){echo "active";}?>"><a href="?type=0">商品收藏</a></li>
	        <li class="<?php if($type==1){echo "active";}?>"><a href="?type=1">文章收藏</a></li>
	        <li class="<?php if($type==2){echo "active";}?>"><a href="?type=2">店铺收藏</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">
							<?php
							switch($type){
								case 0:
								echo "商品收藏";
								break;
								case 1:
								echo "文章收藏";
								break;
								case 2:
								echo "店铺收藏";
								break;
							}

							?>
							
						</div>
							<div class="table-responsive" style="padding-top: 20px">

								<?php

	$sql="select * from sl_colletion where C_mid=$M_id and C_type=".intval($type);
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($type==0){
				$sql2="select * from sl_product where P_id=".$row["C_cid"];
				$result2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result2);
				if (mysqli_num_rows($result2) > 0) {
					$C_pic=splitx($row2["P_pic"],"|",0);
					$C_title=$row2["P_title"];
					$url="../?type=productinfo&id=".$row2["P_id"];
				}
			}
			if($type==1){
				$sql2="select * from sl_news where N_id=".$row["C_cid"];
				$result2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result2);
				if (mysqli_num_rows($result2) > 0) {
					$C_pic=$row2["N_pic"];
					$C_title=$row2["N_title"];
					$url="../?type=newsinfo&id=".$row2["N_id"];
				}
			}

			if($type==2){
				$sql2="select * from sl_member where M_id=".$row["C_cid"];
				$result2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result2);
				if (mysqli_num_rows($result2) > 0) {
					$C_pic=$row2["M_head"];
					$C_title=$row2["M_shop"];
					$url="../?type=product&M_id=".$row2["M_id"];
				}
			}
			echo "<div class=\"col-md-3 col-xs-6 scms-pic\"><div class=\"panel panel-default\" ><a href=\"".$url."\" target=\"_blank\"><img src=\"".pic2($C_pic)."\" style=\"width:100%\"></a><div style=\"padding:10px;text-align:center\"><p>".$C_title."</p><p><a href=\"".$url."\" target=\"_blank\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-send\"></i> 浏览</a> <a href=\"?action=del&type=".$type."&C_id=".$row["C_id"]."\"  class=\"btn btn-danger btn-sm\"><i class=\"fa fa-times-circle\"></i> 取消收藏</a></p></div></div></div>";
		}
	} 

					?>
					</div>
				</div>
				
			</div>
			</div>
			</div>
			
		</div>



		<div class="container m_top_30">
					
			
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
	<script type="text/javascript">$(".scms-pic").attr("style","float: none;display:inline-block;vertical-align:top;");</script>
</body>
</html>