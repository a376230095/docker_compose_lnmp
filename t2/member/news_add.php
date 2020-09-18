<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	Header("Location:seller.php");
	die();
}

$action=$_GET["action"];
$N_id=intval($_GET["N_id"]);

if($N_id!=""){
	$aa="edit&N_id=".$N_id;
	$sql="select * from sl_news,sl_nsort where N_sort=S_id and N_id=$N_id and N_mid=$M_id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$S_title=$row["S_title"];
		$N_pic=$row["N_pic"];
		$N_title=$row["N_title"];
		$N_content=$row["N_content"];
		$N_price=$row["N_price"];
		$N_sort=$row["N_sort"];
		$N_order=$row["N_order"];
		$N_date=$row["N_date"];
		$N_author=$row["N_author"];
		$N_preview=$row["N_preview"];
		$N_long=$row["N_long"];
		$N_fx=$row["N_fx"];
	}
}else{
	$aa="add";
	$N_pic="nopic.png";
	$N_date=date('Y-m-d H:i:s');
	$N_author=$_SESSION["A_login"];
	$N_order=0;
	$N_price=1;
	$N_preview=1;
	$N_long=0;
	$N_fx=1;
}

if($action=="add"){
$N_pic=$_POST["N_pic"];
$N_title=removexss($_POST["N_title"]);
$N_content=removexss($_POST["N_content"]);
$N_price=round($_POST["N_price"],2);
$N_sort=intval($_POST["N_sort"]);
$N_order=intval($_POST["N_order"]);
$N_fx=intval($_POST["N_fx"]);
$N_date=$_POST["N_date"];
$N_preview=intval($_POST["N_preview"]);
$N_long=intval($_POST["N_long"]);

if($N_title!="" && $N_sort!=0){
	mysqli_query($conn,"insert into sl_news(N_pic,N_title,N_content,N_price,N_sort,N_order,N_date,N_author,N_view,N_preview,N_long,N_mid,N_fx,N_sh) values('$N_pic','$N_title','$N_content',$N_price,$N_sort,$N_order,'$N_date','$M_login',0,$N_preview,$N_long,$M_id,$N_fx,$C_nunsh)");

	$N_id=getrs("select * from sl_news where N_title='$N_title' and N_pic='$N_pic' and N_sort=$N_sort","N_id");
	if($C_nunsh==0 && $C_dx4==1){
		sendsms("【".$C_smssign."】有商户发布文章等待审核，请登录后台处理",$C_mobile);
	}
	die("{\"msg\":\"success\",\"N_id\":$N_id}");
}else{
	die("{\"msg\":\"请填全内容\"}");
}
}

if($action=="edit"){
$N_pic=$_POST["N_pic"];
$N_title=removexss($_POST["N_title"]);
$N_content=removexss($_POST["N_content"]);
$N_price=round($_POST["N_price"],2);
$N_sort=intval($_POST["N_sort"]);
$N_order=intval($_POST["N_order"]);
$N_fx=intval($_POST["N_fx"]);
$N_date=$_POST["N_date"];
$N_preview=intval($_POST["N_preview"]);
$N_long=intval($_POST["N_long"]);

if($N_title!="" && $N_sort!=0){
	mysqli_query($conn, "update sl_news set
	N_pic='$N_pic',
	N_title='$N_title',
	N_content='$N_content',
	N_price=$N_price,
	N_sort=$N_sort,
	N_order=$N_order,
	N_date='$N_date',
	N_author='$M_login',
	N_preview=$N_preview,
	N_sh=$C_nunsh,
	N_fx=$N_fx,
	N_long=$N_long
	where N_id=$N_id and N_mid=$M_id");
	if($C_nunsh==0 && $C_dx4==1){
		sendsms("【".$C_smssign."】有商户发布文章等待审核，请登录后台处理",$C_mobile);
	}
	die("{\"msg\":\"success\",\"N_id\":0}");
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

  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 <script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 500px}
		.list-group a{text-decoration:none}

		.buy label {
	padding: 1px 5px;
	cursor: pointer;
	border: #CCCCCC solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

.buy .checked {
	border: #ff0000 solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	color: #ff0000;
}

.buy input[type="radio"] {
	display: none;
}
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
	        <li><a href="news_sell.php">文章列表</a></li>
	        <li class="active"><a href="news_add.php">新增文章</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">新增/编辑文章</div>
							<div class="panel-body">
								<form id="form">
												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章标题</label>
													<div class="col-md-10">
														<input type="text"  name="N_title" class="form-control" value="<?php echo $N_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >发表日期</label>
													<div class="col-md-10">
														<input type="text"  name="N_date" class="form-control" value="<?php echo $N_date?>">
													</div>
												
													
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章排序</label>
													<div class="col-md-4">
														<input type="text"  name="N_order" class="form-control" value="<?php echo $N_order?>" placeholder="数字越小，排序越靠前">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*数字越小，排序越靠前</div>
													</div>
												
													<label class="col-md-2 col-form-label" >文章分类</label>
													<div class="col-md-4">
														<select name="N_sort" class="form-control">
															<?php
													$sql2="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
														$result2 = mysqli_query($conn, $sql2);
														if (mysqli_num_rows($result2) > 0) {
														while($row2 = mysqli_fetch_assoc($result2)) {
															echo "<optgroup label=\"".$row2["S_title"]."\">";
															$sql="select * from sl_nsort where S_del=0 and S_sub=".$row2["S_id"]." order by S_order,S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($N_sort==$row["S_id"]){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"".$row["S_id"]."\" ".$selected.">".$row["S_title"]."</option>";
																}
															}
															echo "</optgroup>";
														}
													}

															?>
															
														</select>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章价格</label>
													<div class="col-md-10">
														<div class="input-group">
														<input type="text"  name="N_price" class="form-control" value="<?php echo $N_price?>">
														<span class="input-group-addon">元</span>
													</div>
													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*即付费多少元后可阅读文章（请填写正数，填0则代表免费阅读）</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >免费预览</label>
													<div class="col-md-4">
													
													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">在文章内容任意位置插入[fh_free]标签<br>
该标签之前的内容即可免费预览<br>
如果您不知道如何使用，请点击 <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">查看帮助</button></div>
													</div>
												
													<label class="col-md-2 col-form-label" >限时收费</label>
													<div class="col-md-4">
														<div class="input-group">
														<input type="text"  name="N_long" class="form-control" value="<?php echo $N_long?>">
														<span class="input-group-addon">小时</span>
													</div>
													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*即多少小时内收费（请填写正数，填0则不启用该功能）</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章图片</label>
													<div class="col-md-10">
														<p><img src="<?php echo pic2($N_pic)?>" id="N_picx" class="showpic" onClick="showUpload('N_pic','N_pic','../media',1,null,'','');" alt="<img src='<?php echo pic2($N_pic)?>' class='showpicx'>"></p>
														<div class="input-group">
						                                        <input type="text" id="N_pic" name="N_pic" class="form-control" value="<?php echo $N_pic?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('N_pic','N_pic','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >开启分销</label>
													<div class="col-md-10 buy">
														<label aa="N_fx" <?php if($N_fx==0){echo "class='checked'";}?>><input type="radio" name="N_fx" value="0" <?php if($N_fx==0){echo "checked='checked'";}?>> 关闭</label>

														<label aa="N_fx" <?php if($N_fx==1){echo "class='checked'";}?>><input type="radio" name="N_fx" value="1" <?php if($N_fx==1){echo "checked='checked'";}?>> 开启</label>
														<span style="font-size: 12px">*开启分销功能后，您的文章会被其他用户推广，您需要支付相应的佣金（一级佣金<?php echo $C_fx1?>%/二级佣金<?php echo $C_fx2?>%/三级佣金<?php echo $C_fx3?>%）</span>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章内容</label>
													<div class="col-md-10">
														<script charset='utf-8' src='../kindeditor/kindeditor-all-min.js'></script>
		                                                <script charset='utf-8' src='../kindeditor/lang/zh-CN.js'></script>
		                                                <script>KindEditor.ready(function(K) {window.editor = K.create('#content', {uploadJson : '../kindeditor/php/upload_json.php', fileManagerJson : '../kindeditor/php/file_manager_json.php',allowFileManager : true,items:['source', '|', 'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', '|', 'selectall', '-','title', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold','italic', 'underline', 'strikethrough', 'removeformat', '|', 'image','multiimage','flash', 'media', 'advtable', 'hr', 'emoticons', 'link', 'unlink', '|', 'about'] });});</script>
		                                                <textarea name='N_content' style='width:100%;height:350px;' id='content'><?php echo $N_content?></textarea>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" ></label>
													<div class="col-md-10">
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
	<style> 
.modal-body img{border:solid 1px #CCCCCC;margin-bottom: 20px;border-radius: 10px;box-shadow:0px 0px 10px #aaaaaa;max-width: 100%}
</style>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 100%;max-width: 1000px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					文章模块如何使用免费预览功能？
				</h4>
			</div>
			<div class="modal-body">
				<p>在文章内容任意位置插入[fh_free]标签，该标签之前的内容即可免费预览，具体请查看以下图文</p>
            <img src="https://fahuo100.cn/images/9.1.png">
            <div class="description">
                <p>1.在文章内容的任意位置插入[fh_free]标签，根据自己的需求来确定位置</p>
            </div>
            <img src="https://fahuo100.cn/images/9.2.png">
            <div class="description">
                <p>2.[fh_free]标签之前的内容可免费预览，[fh_free]标签之后的内容需要付费阅读</p>
            </div>        </div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
				</button>
				<button type="button" class="btn btn-primary">
					提交更改
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
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
		$(function() { $('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});
		function save(id){
			editor.sync();
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		if(id==1){
	            		if(data.N_id==0){
	            			alert("保存成功");
	            		}else{
	            			window.location.href="news_add.php?N_id="+data.N_id;
	            		}
            		}else{
            			window.location.href="news_sell.php";
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