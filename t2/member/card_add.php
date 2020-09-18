<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	Header("Location:seller.php");
	die();
}

$action=$_GET["action"];
$C_id=intval($_GET["C_id"]);
$id=intval($_GET["id"]);

if($C_id!=""){
	$aa="edit&C_id=".$C_id;
	$title="编辑";
	$sql="select * from sl_card where C_id=$C_id and C_mid=$M_id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$C_content=$row["C_content"];
		$C_sort=$row["C_sort"];
		$C_use=$row["C_use"];
	}
}else{
	$aa="add";
	$title="新增";
	$C_use=0;
	$C_sort=$id;
}

if($action=="add"){
	$C_content=$_POST["C_content"];
	$C_sort=intval($_POST["C_sort"]);
	$C_use=intval($_POST["C_use"]);

	if($C_content!="" && $C_sort!=0){
		$card=explode("\r\n",$C_content);
		for($i=0;$i<count($card);$i++){
			if(getrs("select * from sl_card where C_content='$C_content' and C_sort='$C_sort'","C_id")==""){
				mysqli_query($conn,"insert into sl_card(C_content,C_sort,C_use,C_mid) values('".trim($card[$i])."',$C_sort,$C_use,$M_id)");
			}
		}
		
		die("{\"msg\":\"success\"}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

if($action=="edit"){
	$C_content=$_POST["C_content"];
	$C_sort=intval($_POST["C_sort"]);
	$C_use=intval($_POST["C_use"]);
	if(getrs("select * from sl_card where C_content='$C_content' and C_sort='$C_sort' and not C_id=$C_id","C_id")==""){
		if($C_content!="" && $C_sort!=0){
			if(strpos($C_content,"\r\n")===false){
				mysqli_query($conn, "update sl_card set C_content='$C_content',C_sort=$C_sort,C_use=$C_use where C_id=$C_id and C_mid=$M_id");
				
				die("{\"msg\":\"success\"}");
			}else{
				die("{\"msg\":\"不支持编辑多个\"}");
			}
		}else{
			die("{\"msg\":\"请填全内容\"}");
		}
	}else{
		die("{\"msg\":\"卡密内容重复\"}");
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
	        <li ><a href="card_sell.php">卡密列表</a></li>
	        <li class="active"><a href="card_add.php">新增卡密</a></li>
	        <li><a href="csort_list.php">卡密分类</a></li>
	        <li><a href="csort_add.php">新增分类</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $title?>卡密</div>
							<div class="panel-body">
								<form id="form">
												<div class="form-group row">
													<label class="col-md-2 col-form-label" >卡密内容</label>
													<div class="col-md-10">
														<textarea name="C_content" class="form-control" rows="20"><?php echo $C_content?></textarea>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*可以批量新增卡密，每行一个，可以智能去重复</div>
													</div>
												</div>



												<div class="form-group row">
													<label class="col-md-2 col-form-label" >卡密分类</label>
													<div class="col-md-10">
														<select name="C_sort" class="form-control">
															<?php
															$sql="select * from sl_csort where S_del=0 and S_mid=$M_id order by S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($C_sort==$row["S_id"]){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"".$row["S_id"]."\" ".$selected.">".$row["S_title"]."</option>";
																}
															}

															?>
															
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >已发放</label>
													<div class="col-md-10">
														<select name="C_use" class="form-control">
															<option value="0" <?php if($C_use==0){echo "selected=\"selected\"";}?>>否</option>
															<option value="1" <?php if($C_use==1){echo "selected=\"selected\"";}?>>是</option>
														</select>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*已发放的卡密不会再次发放给其他会员</div>
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
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		if(id==1){
	            		alert("保存成功", "成功");
            		}else{
            			window.location.href="card_sell.php";
            		}
            	}else{
            		alert(data.msg, '错误');
            	}
            	}
            });

			}

		</script>
</body>
</html>