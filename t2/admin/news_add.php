<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/".$C_admin,0);
$dirx=splitx($_SERVER["PHP_SELF"],$C_admin,0);

$N_id=intval($_GET["N_id"]);

if($N_id!=""){
	$aa="edit&N_id=".$N_id;
	$sql="select * from sl_news,sl_nsort where N_sort=S_id and N_id=".$N_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$S_title=$row["S_title"];
		$N_pic=$row["N_pic"];
		$N_title=$row["N_title"];
		$N_content=$row["N_content"];
		$N_price=$row["N_price"];
		$N_price2=$row["N_price2"];
		$N_sort=$row["N_sort"];
		$N_order=$row["N_order"];
		$N_date=$row["N_date"];
		$N_author=$row["N_author"];
		$N_view=$row["N_view"];
		$N_preview=$row["N_preview"];
		$N_long=$row["N_long"];
		$N_sh=$row["N_sh"];
		$N_tag=$row["N_tag"];
		$N_fx=$row["N_fx"];
		$N_video=$row["N_video"];
		$N_top=$row["N_top"];
		$N_tpl=$row["N_tpl"];
		$N_vshow=$row["N_vshow"];
		$N_shuxing=$row["N_shuxing"];
		$N_keywords=$row["N_keywords"];
		$N_description=$row["N_description"];
	}
}else{
	$aa="add";
	$N_pic="nopic.png";
	$N_date=date('Y-m-d H:i:s');
	$N_author=$_SESSION["A_login"];
	$N_view=0;
	$N_order=0;
	$N_price=1;
	$N_price2=1;
	$N_preview=1;
	$N_long=0;
	$N_sh=1;
	$N_fx=1;
	$N_top=0;
	$N_tpl=0;
	$N_vshow=0;
}

if($action=="add"){
	$N_pic=$_POST["N_pic"];
	$N_title=$_POST["N_title"];
	$N_content=$_POST["N_content"];
	$N_price=round($_POST["N_price"],2);
	$N_price2=round($_POST["N_price2"],2);
	if($N_price2==0){
		$N_price2=$N_price;
	}
	if($N_price2>$N_price){
		die("{\"msg\":\"成本价不得高于售价\"}");
	}
	$N_sort=intval($_POST["N_sort"]);
	$N_order=intval($_POST["N_order"]);
	$N_date=$_POST["N_date"];
	$N_author=$_POST["N_author"];
	$N_view=intval($_POST["N_view"]);
	$N_preview=intval($_POST["N_preview"]);
	$N_long=intval($_POST["N_long"]);
	$N_sh=intval($_POST["N_sh"]);
	$N_tag=$_POST["N_tag"];
	$N_video=$_POST["N_video"];
	$N_fx=intval($_POST["N_fx"]);
	$N_top=intval($_POST["N_top"]);
	$N_tpl=intval($_POST["N_tpl"]);
	$N_vshow=intval($_POST["N_vshow"]);
	$N_keywords=$_POST["N_keywords"];
	$N_description=$_POST["N_description"];
	$N_shuxing=$_POST["N_shuxing"];
	$N_shuxing=str_replace("：", ":", $N_shuxing);
	if($N_shuxing!="" && strpos($N_shuxing, ":")===false){
		die("{\"msg\":\"文章参数的格式错误\"}");
	}
	$savepic=intval($_POST["savepic"]);

	if($savepic==1){
		$N_content=savepic($N_content,$dirx);
	}
	if($C_osson==1){
		editor2oss($N_content);
	}

	if($N_sort==0){
		die("{\"msg\":\"请选择一个文章分类\"}");
	}

	if($N_price<0){
		die("{\"msg\":\"文章价格不可为负\"}");
	}

	if($N_title!=""){
		mysqli_query($conn,"insert into sl_news(N_pic,N_title,N_content,N_price,N_price2,N_sort,N_order,N_date,N_author,N_view,N_preview,N_long,N_sh,N_tag,N_fx,N_video,N_top,N_tpl,N_shuxing,N_keywords,N_description,N_vshow) values('$N_pic','$N_title','$N_content',$N_price,$N_price2,$N_sort,$N_order,'$N_date','$N_author',$N_view,0,$N_long,$N_sh,'$N_tag',$N_fx,'$N_video',$N_top,$N_tpl,'$N_shuxing','$N_keywords','$N_description',$N_vshow)");

		$N_id=getrs("select * from sl_news where N_title='$N_title' and N_pic='$N_pic' and N_sort=$N_sort","N_id");
		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增文章')");
		die("{\"msg\":\"success\",\"N_id\":$N_id}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

if($action=="edit"){
	$N_pic=$_POST["N_pic"];
	$N_title=$_POST["N_title"];
	$N_content=$_POST["N_content"];
	$N_price=round($_POST["N_price"],2);
	$N_price2=round($_POST["N_price2"],2);
	if($N_price2==0){
		$N_price2=$N_price;
	}
	if($N_price2>$N_price){
		die("{\"msg\":\"成本价不得高于售价\"}");
	}
	$N_sort=intval($_POST["N_sort"]);
	$N_order=intval($_POST["N_order"]);
	$N_date=$_POST["N_date"];
	$N_author=$_POST["N_author"];
	$N_view=intval($_POST["N_view"]);
	$N_preview=intval($_POST["N_preview"]);
	$N_long=intval($_POST["N_long"]);
	$N_sh=intval($_POST["N_sh"]);
	$N_tag=$_POST["N_tag"];
	$N_video=$_POST["N_video"];
	$N_fx=intval($_POST["N_fx"]);
	$N_top=intval($_POST["N_top"]);
	$N_tpl=intval($_POST["N_tpl"]);
	$N_vshow=intval($_POST["N_vshow"]);
	$N_keywords=$_POST["N_keywords"];
	$N_description=$_POST["N_description"];
	$N_shuxing=$_POST["N_shuxing"];
	$N_shuxing=str_replace("：", ":", $N_shuxing);
	if($N_shuxing!="" && strpos($N_shuxing, ":")===false){
		die("{\"msg\":\"文章参数的格式错误\"}");
	}

	$savepic=intval($_POST["savepic"]);
	if($savepic==1){
		$N_content=savepic($N_content,$dirx);
	}
	if($C_osson==1){
		editor2oss($N_content);
	}

	if($N_sort==0){
		die("{\"msg\":\"请选择一个文章分类\"}");
	}

	if($N_price<0){
		die("{\"msg\":\"文章价格不可为负\"}");
	}

	if($N_title!=""){
		mysqli_query($conn, "update sl_news set
		N_pic='$N_pic',
		N_title='$N_title',
		N_content='$N_content',
		N_price=$N_price,
		N_price2=$N_price2,
		N_sort=$N_sort,
		N_order=$N_order,
		N_date='$N_date',
		N_author='$N_author',
		N_view=$N_view,
		N_preview=0,
		N_long=$N_long,
		N_sh=$N_sh,
		N_fx=$N_fx,
		N_tag='$N_tag',
		N_top=$N_top,
		N_tpl=$N_tpl,
		N_vshow=$N_vshow,
		N_keywords='$N_keywords',
		N_description='$N_description',
		N_shuxing='$N_shuxing',
		N_video='$N_video'
		where N_id=".$N_id);
		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑文章')");
		die("{\"msg\":\"success\",\"N_id\":0}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

if($action=="caiji"){
	$url=$_POST["url"];
	$info=get_article($url);
	if($info["title"]==""){
		die("{\"msg\":\"未获取到内容，请检查网址\"}");
	}else{
		$info["msg"]="success";
		$info["img"]=downpic("../media/",$info["img"]);
		die(json_encode($info));
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>文章设置 - 后台管理</title>

		<!--favicon -->
		<link rel="icon" href="../media/<?php echo $C_ico?>" type="image/x-icon"/>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

		<!--Icons css-->
		<link rel="stylesheet" href="assets/css/icons.css">

		<!--Style css-->
		<link rel="stylesheet" href="assets/css/style.css">

		<!--mCustomScrollbar css-->
		<link rel="stylesheet" href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css">

		<!--Sidemenu css-->
		<link rel="stylesheet" href="assets/plugins/toggle-menu/sidemenu.css">

		<!--Morris css-->
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">

		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">


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
	</head>

	<body class="app ">

		<div id="spinner"></div>

		<div id="app">
			<div class="main-wrapper" >
				
					<?php
					require 'nav.php';
					?>

				<div class="app-content">
					<button class="btn btn-info pull-right btn-sm" style="z-index: 2;position: relative;" onClick="$('#cj').show()"><i class="fa fa-paste"></i> 采集文章</button>
					<a class="btn btn-primary pull-right btn-sm" href="nsort_add.php" style="z-index: 2;position: relative;margin-right: 10px;"><i class="fa fa-plus-circle"></i> 新增文章分类</a>
					<a class="btn btn-primary pull-right btn-sm" href="news_add.php" style="z-index: 2;position: relative;margin-right: 10px;"><i class="fa fa-plus-circle"></i> 新增文章</a>

					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="news_list.php">文章管理</a></li>
                            <li class="breadcrumb-item"><a href="nsort_add.php">文章分类</a></li>
                            <li class="breadcrumb-item"><a href="excel_news.php">导入EXCEL</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-3">

									<div class="card card-primary">

										<div class="card-header">
											<h4><?php echo $S_title?> - 文章列表</h4>
										</div>
											
												<ul class="list-group">
													<?php 
													if($N_id==0){
														$sql="select * from sl_news,sl_nsort where N_sort=S_id and S_del=0 and N_del=0 order by N_id desc limit 20";
													}else{
														$sql="select * from sl_news,sl_nsort where N_sort=S_id and S_del=0 and N_del=0 and N_sort=$N_sort order by N_id desc limit 20";
													}
														
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["N_id"]==$N_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	echo "<a href=\"?N_id=".$row["N_id"]."\" class=\"list-group-item ".$active."\"><b>[".$row["S_title"]."]</b> ".htmlspecialchars($row["N_title"])."</a>";
																}
															}
													?>
													
												</ul>
											
										
									</div>
									<a href="news_add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增文章</a>
								</div>

								<div class="col-lg-9">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>文章管理</h4>
										</div>
										<div class="card-body">

												<div class="form-group row" style="display: none" id="cj">
													<label class="col-md-2 col-form-label">采集文章<br><button type="button" class="btn btn-info btn-sm" onClick="$('#cj').hide()">隐藏</button></label>
													<div class="col-md-10 buy">
														<textarea  id="url" class="form-control" rows="3" placeholder="输入网页地址"></textarea>
														<p style="font-size: 12px;margin-top: 10px;"><button class="btn btn-sm btn-primary" type="button" onClick="caiji()">采集</button> *会自动采集文章标题/配图/内容；目前支持采集微信公众号/百家号/新浪新闻</p>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章标题</label>
													<div class="col-md-10">
														<input type="text" id="N_title" name="N_title" class="form-control" value="<?php echo htmlspecialchars($N_title)?>">
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
													<label class="col-md-2 col-form-label" >文章作者</label>
													<div class="col-md-4">
														<input type="text"  name="N_author" class="form-control" value="<?php echo $N_author?>">
													</div>

													<label class="col-md-2 col-form-label" >文章价格</label>
													<div class="col-md-4">
														<div class="input-group">
														<span class="input-group-addon">出售价</span>
														<input type="text"  name="N_price" class="form-control" value="<?php echo $N_price?>">
														<span class="input-group-addon">元</span>
													</div>
													<?php if($C_fzon==1){?>
													<div class="input-group">
														<span class="input-group-addon">成本价</span>
														<input type="text"  name="N_price2" class="form-control" value="<?php echo $N_price2?>">
														<span class="input-group-addon">元</span>
													</div>
													<?php }?>
													
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >发表日期</label>
													<div class="col-md-4">
														<div class="input-group">
										                    <input type="text"  name="N_date" id="N_date" class="form-control" value="<?php echo $N_date?>">
										                    <span class="input-group-btn">
										                        <button class="btn btn-info" type="button" onclick="getdate()">获取</button>
										                    </span>
										                </div>
													</div>
												
													<label class="col-md-2 col-form-label" >阅读次数</label>
													<div class="col-md-4">
														<div class="input-group">
														<input type="text"  name="N_view" class="form-control" value="<?php echo $N_view?>">
														<span class="input-group-addon">次</span>
													</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章排序</label>
													<div class="col-md-4" style="position: relative;">
														<input type="text"  name="N_order" class="form-control" value="<?php echo $N_order?>" placeholder="数字越小，排序越靠前">

														<label style="position: absolute;right: 25px;top: 10px;"><input type="checkbox" name="N_top" value="1" <?php if($N_top==1){echo "checked='checked'";}?> >置顶</label>

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
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*文章无法直接归到主分类，如果无法选择请先新建子分类</div>
													</div>
												</div>

<div class="panel-group" id="accordion">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" style="display: block;text-align: center;background: #f7f7f7;margin-bottom: 10px;font-weight: bold;padding: 5px;">＋展开高级功能</a>
            
        <div id="collapseThree" class="panel-collapse collapse" style="background: #f7f7f7;padding: 10px;margin-bottom: 10px;border-radius: 10px;">
        	<div class="form-group row">
													<label class="col-md-2 col-form-label" >SEO关键词</label>
													<div class="col-md-10">
														<input type="text" id="N_keywords"  name="N_keywords" class="form-control" value="<?php echo $N_keywords?>" placeholder="多个词用,隔开">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >SEO描述</label>
													<div class="col-md-10">
														<textarea name="N_description" id="N_description" class="form-control"><?php echo $N_description?></textarea>
													</div>
												</div>
        	<hr>
                									<div class="form-group row" >
													<label class="col-md-2 col-form-label" >分销推广</label>
													<div class="col-md-4 buy">
														<label aa="P_fx" <?php if($N_fx==1){echo "class='checked'";}?>><input type="radio" name="N_fx" value="1"  <?php if($N_fx==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="P_fx" <?php if($N_fx==0){echo "class='checked'";}?>><input type="radio" name="N_fx" value="0"  <?php if($N_fx==0){echo "checked='checked'";}?>> 关闭</label>
													</div>
													

													<label class="col-md-2 col-form-label" >文章审核</label>
													<div class="col-md-4">
														<select class="form-control" name="N_sh">
															<option value="0" <?php if($N_sh==0){echo "selected=\"selected\"";}?>>未审核</option>
															<option value="1" <?php if($N_sh==1){echo "selected=\"selected\"";}?>>已通过</option>
															<option value="2" <?php if($N_sh==2){echo "selected=\"selected\"";}?>>未通过</option>
														</select>
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >免费预览</label>
													<div class="col-md-4">
													
													<div style="margin-top: 5px;font-size: 12px;color: #AAAAAA">在文章内容任意位置插入<b style="color: #838ab6">[fh_free]</b>标签<br>该标签之前的内容即可免费预览<br>如果您不知道如何使用，请点击<a href="https://fahuo100.cn/h9.html" target="_blank">查看帮助</a></div>
													</div>
												
													<label class="col-md-2 col-form-label" >限时收费</label>
													<div class="col-md-4">
														<div class="input-group">
														<input type="text"  name="N_long" class="form-control" value="<?php echo $N_long?>">
														<span class="input-group-addon">小时</span>
													</div>
													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*即文章发布多少小时后免费阅读（请填写正数，填0则不启用该功能）</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label">插入视频</label>
													<div class="col-md-10">
														<textarea name="N_video" id="N_video" class="form-control" rows="3" placeholder="上传mp4视频或者粘贴视频代码"><?php echo $N_video?></textarea>
														<label style="position: absolute;right: 100px;bottom: 50px;"><input type="radio" name="N_vshow" value="0" <?php if($N_vshow==0){echo "checked='checked'";}?> >顶部显示</label>
														<label style="position: absolute;right: 25px;bottom: 50px;"><input type="radio" name="N_vshow" value="1" <?php if($N_vshow==1){echo "checked='checked'";}?> >底部显示</label>
														<p style="font-size: 12px;margin-top: 10px;"><button class="btn btn-sm btn-primary" type="button" onClick="showUpload('N_video','N_video','../media',1,null,'','');">上传视频</button> *如果您不知道如何使用视频功能，请点击<a href="https://fahuo100.cn/h18.html" target="_blank">查看帮助</a></p>
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label">文章Tag</label>
													<div class="col-md-10 buy">
														<textarea name="N_tag" class="form-control" rows="3" placeholder="多个标签用空格隔开"><?php echo $N_tag?></textarea>
														<p style="font-size: 12px;margin-top: 10px;">*使用Tag功能，方便用户快速定位具有相同标签的文章，多个标签用空格隔开</p>
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label">文章参数</label>
													<div class="col-md-10">
														
														<textarea id="N_shuxing" name="N_shuxing" class="form-control" rows="3" placeholder="格式：参数名:参数值（每行一个）"><?php echo $N_shuxing?></textarea>
														
														<p style="font-size: 12px;margin-top: 10px;">*格式：参数名:参数值（每行一个），举例：颜色:黑色 </p>
														<div style="float: right;margin-top: -35px"><label><input type="checkbox" name="N_tpl" value="1" <?php if($N_tpl==1){echo "checked='checked'";}?>>设为模板</label> <button class="btn btn-sm btn-info" type="button" onclick="$('#tpl').show()">调用模板</button></div>

														<div style="max-height: 100px;overflow: auto;background: #ffffff;padding:10px; font-size: 12px;display: none;" id="tpl">
															<?php
$i=1;
$sql="select * from sl_news where N_tpl=1 and N_del=0";
$result = mysqli_query($conn,  $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
        echo "<div>".$i.".".$row["N_shuxing"]." <button class=\"btn btn-sm btn-info\" type=\"button\" onclick=\"$('#N_shuxing').val('".str_replace("\r\n"," ",$row["N_shuxing"])."')\">调用</button></div>";
        $i=$i+1;
    }
} 
															?>
														</div>
													</div>
												</div>

												
            </div>
        </div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" >文章内容</label>
													<div class="col-md-10">
														<script charset='utf-8' src='../kindeditor/kindeditor-all-min.js'></script>
		                                                <script charset='utf-8' src='../kindeditor/lang/zh-CN.js'></script>
		                                                <script>KindEditor.ready(function(K) {window.editor = K.create('#content', {uploadJson : '../kindeditor/php/upload_json.php', fileManagerJson : '../kindeditor/php/file_manager_json.php',allowFileManager : true,items:[
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
         'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
] });});</script>
		                                                <textarea name='N_content' style='width:100%;height:350px;' id='content'><?php echo $N_content?></textarea>
														<label style="font-size: 12px;margin-top: 5px;text-align: right;"><input type="checkbox" id="savepic" value="1" name="savepic">保存编辑器内的远程图片到本地</label>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" ></label>
													<div class="col-md-10">
														<button class="btn btn-info" type="button" onClick="save(1)">保存</button>
														<button class="btn btn-primary" type="button" onClick="save(2)">保存并返回</button>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>
							</form>
						</div>
					</section>
				</div>

			</div>
		</div>

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/help.js"></script>
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>

		<script type="text/javascript">
		function save(id){
			toastr.warning('请稍等...','');
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
	            			toastr.success("保存成功", "成功");
	            		}else{
	            			window.location.href="news_add.php?N_id="+data.N_id;
	            		}
            		}else{
            			window.location.href="news_list.php";
            		}
            	}else{
            		toastr.error(data.msg, '错误');
            	}
            	}
            });

			}

			function caiji(){
				toastr.warning('请稍等...','');
					$.ajax({
	            	url:'?action=caiji',
	            	type:'post',
	            	data:{url:$("#url").val()},
	            	success:function (data) {
		            	data=JSON.parse(data);
		            	if(data.msg=="success"){
		            		toastr.success("采集成功", "成功");
		            		$("#N_title").val(data.title);
		            		$("#N_pic").val(data.img);
		            		$("#N_keywords").val(data.keyword);
		            		$("#N_description").val(data.description);
		            		$("#N_picx").attr("src","../media/"+data.img);
		            		$("#savepic").attr("checked","checked");
		            		editor.html(data.content);
		            	}else{
		            		toastr.error(data.msg, '错误');
		            	}
	            	}
	            });
			}

			function getdate(){
				var day1 = new Date();
				day1.setDate(day1.getDate());
				var s1 = day1.format("yyyy-MM-dd hh:mm:ss");
				$("#N_date").val(s1);
			}

			Date.prototype.format = function (fmt) {
			    var o = {
			        "M+": this.getMonth() + 1, //月份
			        "d+": this.getDate(), //日
			        "h+": this.getHours(), //小时
			        "m+": this.getMinutes(), //分
			        "s+": this.getSeconds(), //秒
			        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
			        "S": this.getMilliseconds() //毫秒
			    };
			    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
			    for (var k in o)
			        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
			    return fmt;
			}

			$(function() { $('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});
		</script>
		
	</body>
</html>
