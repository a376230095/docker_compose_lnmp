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

if($S_id!=""){
	$aa="edit&S_id=".$S_id;
	$title="编辑";

	$sql="select * from sl_csort where S_id=".$S_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {

		$S_title=$row["S_title"];
		$S_content=$row["S_content"];

	}
}else{
	$aa="add";
	$title="新增";
	$S_pic="nopic.png";
}

if($action=="add"){

$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];

if($S_title!=""){
	mysqli_query($conn,"insert into sl_csort(S_title,S_content,S_mid) values('$S_title','$S_content',$M_id)");
	
	die("success");
}else{
	die("error");
}
}

if($action=="edit"){


$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];

if($S_title!=""){

	mysqli_query($conn, "update sl_csort set S_title='$S_title',S_content='$S_content',S_mid=$M_id where S_id=".$S_id);
	
	die("success");
}else{
	die("error");
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
 <script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 500px}
		.list-group a{text-decoration:none}
	</style>
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
			<h5 class="p_bottom_10">文章管理</h5>
		<ul class="nav nav-pills nav-stacked">
	        <li><a href="card_sell.php">卡密列表</a></li>
	        <li><a href="card_add.php">新增卡密</a></li>
	        <li ><a href="csort_list.php">卡密分类</a></li>
	        <li class="active"><a href="csort_add.php">新增分类</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $title?>卡密分类</div>
							<div class="panel-body">
											<form id="form">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >分类标题</label>
													<div class="col-md-9">
														<input type="text"  name="S_title" class="form-control" value="<?php echo $S_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >分类介绍</label>
													<div class="col-md-9">
														<textarea name="S_content" class="form-control"><?php echo $S_content?></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-info" type="button" onClick="save(1)">保存</button>
														<button class="btn btn-primary" type="button" onClick="save(2)">保存并返回</button>
														
													</div>
												</div>
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
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	<script type="text/javascript">
		function save(id){
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		if(id==1){
            			alert("保存成功");
            		}else{
            			window.location.href="csort_list.php";
            		}
            	}else{
            		alert(data);
            	}
            	}
            });

			}

		</script>
</body>
</html>