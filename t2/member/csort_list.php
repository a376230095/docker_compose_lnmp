<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	Header("Location:seller.php");
	die();
}

$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);

if($action=="del"){
	mysqli_query($conn,"update sl_csort set S_del=1 where S_id=$S_id and S_mid=$M_id");
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
		<div class="container m_top_30">
			<div class="yto-box">
				<div class="row">
					<div class="col-sm-2 hidden-xs">
			<h5 class="p_bottom_10">卡密管理</h5>
		<ul class="nav nav-pills nav-stacked">
	        <li><a href="card_sell.php">卡密列表</a></li>
	        <li><a href="card_add.php">新增卡密</a></li>
	        <li class="active"><a href="csort_list.php">卡密分类</a></li>
	        <li><a href="csort_add.php">新增分类</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">我的卡密</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th>ID</th>
										<th>卡密分类</th>
										<th>库存（剩/总）</th>
										<th>编辑</th>
										<th>删除</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_csort where S_del=0 and S_mid=$M_id order by S_id desc";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								$rest=getrs("select count(C_id) as C_count from sl_card where C_sort=".$row["S_id"]." and C_use=0","C_count");
								$all=getrs("select count(C_id) as C_count from sl_card where C_sort=".$row["S_id"]."","C_count");
								
							        echo "<tr id='".$row["S_id"]."'>
							        <td>".$row["S_id"]."</td>
							        <td>".$row["S_title"]."</td>
							        <td>".$rest."/".$all." <a href=\"card_add.php?id=".$row["S_id"]."\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-plus-square\"></i> 补货</a></td>

							        <td><a href='csort_add.php?S_id=".$row["S_id"]."' class='btn btn-xs btn-success'><i class=\"fa fa-edit\"></i> 编辑</a></td>
							        <td><button class='btn btn-xs btn-danger' type='button' onClick='del(".$row["S_id"].")'><i class=\"fa fa-times-circle\"></i> 删除</button></td>
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
			if (confirm("确定删除分类吗？")==true){
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