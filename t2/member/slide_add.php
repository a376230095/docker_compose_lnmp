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

if($S_id!=""){
	$aa="edit&S_id=".$S_id;
	$title="编辑";

	$sql="select * from sl_slide where S_id=$S_id and S_mid=$M_id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$S_pic=$row["S_pic"];
		$S_title=$row["S_title"];
		$S_content=$row["S_content"];
		$S_link=$row["S_link"];
		$S_order=$row["S_order"];
	}
}else{
	$aa="add";
	$title="新增";
	$S_pic="nopic.png";
	$S_order=0;
}

if($action=="add"){

	$S_pic=htmlspecialchars($_POST["S_pic"]);
	$S_title=htmlspecialchars($_POST["S_title"]);
	$S_content=htmlspecialchars($_POST["S_content"]);
	$S_link=htmlspecialchars($_POST["S_link"]);
	$S_order=intval($_POST["S_order"]);

	if($S_title!=""){
		mysqli_query($conn,"insert into sl_slide(S_pic,S_title,S_content,S_link,S_order,S_mid) values('$S_pic','$S_title','$S_content','$S_link',$S_order,$M_id)");
		$S_id=getrs("select * from sl_slide where S_title='$S_title' and S_pic='$S_pic' order by S_id desc","S_id");
		die("{\"msg\":\"success\",\"S_id\":$S_id}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

if($action=="edit"){
	$S_pic=htmlspecialchars($_POST["S_pic"]);
	$S_title=htmlspecialchars($_POST["S_title"]);
	$S_content=htmlspecialchars($_POST["S_content"]);
	$S_link=htmlspecialchars($_POST["S_link"]);
	$S_order=intval($_POST["S_order"]);

	if($S_title!=""){
		mysqli_query($conn, "update sl_slide set
			S_pic='$S_pic',
			S_title='$S_title',
			S_content='$S_content',
			S_link='$S_link',
			S_order=$S_order
		where S_id=$S_id and S_mid=$M_id");
		die("{\"msg\":\"success\",\"S_id\":0}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
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
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;max-width: 100%}
		.showpicx{width: 100%;max-width: 500px}
</style>
  
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
	        <li><a href="contact.php">基本设置</a></li>
	        <li class="active"><a href="slide.php">焦点图设置</a></li>
	        <li><a href="template.php">模板设置</a></li>
	     </ul>
	 </div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $title?>焦点图</div>
							<div class="panel-body">
								<form id="form">

									<div class="form-group row">
								<label class="col-md-2 control-label" >焦点图</label>
								<div class="col-md-10">
									<p><img src="../media/<?php echo $S_pic?>" id="S_picx" class="showpic" onClick="showUpload('S_pic','S_pic','../media',1,null,'','');" alt="<img src='../media/<?php echo $S_pic?>' class='showpicx'>"></p>
									<div class="input-group">
	                                        <input type="text" id="S_pic" name="S_pic" class="form-control" value="<?php echo $S_pic?>">
	                                        <span class="input-group-btn">
	                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('S_pic','S_pic','../media',1,null,'','');">上传</button>
	                                        </span>
	                                </div>
									
								</div>
							</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >焦点图标题</label>
													<div class="col-md-10">
														<input type="text" name="S_title" class="form-control" value="<?php echo $S_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >焦点图描述</label>
													<div class="col-md-10">
														<textarea class="form-control" name="S_content"><?php echo $S_content?></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >焦点图排序</label>
													<div class="col-md-10">
														<input type="text"  name="S_order" class="form-control" value="<?php echo $S_order?>" placeholder="数字越小越靠前">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >焦点图链接</label>
													<div class="col-md-10">
														<input type="text"  name="S_link" class="form-control" value="<?php echo $S_link?>" >
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" ></label>
													<div class="col-md-10">
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
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>

	<script type="text/javascript">

		function save(id){
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		if(id==1){
	            		if(data.S_id==0){
	            			alert("保存成功");
	            		}else{
	            			window.location.href="slide_add.php?S_id="+data.S_id;
	            		}
            		}else{
            			window.location.href="slide.php";
            		}
            	}else{
            		alert(data.msg);
            	}
            	}
            });
			}
			
		</script>
</body>
</html>