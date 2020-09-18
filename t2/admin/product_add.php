<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$P_id=intval($_GET["P_id"]);
$dirx=splitx($_SERVER["PHP_SELF"],$C_admin,0);
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/$C_admin",0);

if($P_id!=""){
	$aa="edit&P_id=".$P_id;
	$sql="select * from sl_product,sl_psort where P_sort=S_id and P_id=".$P_id;

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$P_pic=$row["P_pic"];
		$P_title=$row["P_title"];
		$S_title=$row["S_title"];
		$P_content=$row["P_content"];
		$P_price=$row["P_price"];
		$P_price2=$row["P_price2"];
		$P_sort=$row["P_sort"];
		$P_order=$row["P_order"];
		$P_sell=$row["P_sell"];
		$P_selltype=$row["P_selltype"];
		$P_rest=$row["P_rest"];
		$P_sh=$row["P_sh"];
		$P_unlogin=$row["P_unlogin"];
		$P_tag=$row["P_tag"];
		$P_fx=$row["P_fx"];
		$P_shuxing=$row["P_shuxing"];
		$P_video=$row["P_video"];
		$P_time=$row["P_time"];
		$P_sold=$row["P_sold"];
		$P_taobao=$row["P_taobao"];
		$P_vip=$row["P_vip"];
		$P_top=$row["P_top"];
		$P_tpl=$row["P_tpl"];
		$P_keywords=$row["P_keywords"];
		$P_description=$row["P_description"];
		$P_vshow=$row["P_vshow"];
		$P_mid=$row["P_mid"];
		$P_address=$row["P_address"];
		if($P_time==""){
			$P_time=date('Y-m-d H:i:s');
		}
	}
}else{
	$aa="add";
	$P_pic="nopic.png";
	$P_selltype=0;
	$P_rest=100;
	$P_sh=1;
	$P_unlogin=1;
	$P_fx=1;
	$P_time=date('Y-m-d H:i:s');
	$P_sold=0;
	$P_vip=1;
	$P_top=0;
	$P_tpl=0;
	$P_vshow=0;
	$P_address="name,mobile,address";
}

if($action=="add"){
	foreach ($_POST as $x=>$value) {
	    if(splitx($x,"_",0)=="picpic1"){
	        $pic=$pic.$_POST[$x]."|";
	    }
	}
	$P_pic=substr($pic,0,strlen($pic)-1);
	$P_title=$_POST["P_title"];
	$P_content=$_POST["P_content"];
	$P_price=round($_POST["P_price"],2);
	$P_price2=round($_POST["P_price2"],2);
	if($P_price2==0){
		$P_price2=$P_price;
	}
	if($P_price2>$P_price){
		die("{\"msg\":\"成本价不得高于售价\"}");
	}
	$P_sort=intval($_POST["P_sort"]);
	$P_order=intval($_POST["P_order"]);
	$P_selltype=intval($_POST["P_selltype"]);
	$P_rest=intval($_POST["P_rest"]);
	$P_sh=intval($_POST["P_sh"]);
	$P_unlogin=intval($_POST["P_unlogin"]);
	$P_fx=intval($_POST["P_fx"]);
	$P_sold=intval($_POST["P_sold"]);
	$P_vip=intval($_POST["P_vip"]);
	$P_top=intval($_POST["P_top"]);
	$P_tpl=intval($_POST["P_tpl"]);
	$P_vshow=intval($_POST["P_vshow"]);
	$P_tag=$_POST["P_tag"];
	$P_video=$_POST["P_video"];
	$P_shuxing=$_POST["P_shuxing"];
	$P_shuxing=str_replace("：", ":", $P_shuxing);
	if($P_shuxing!="" && strpos($P_shuxing, ":")===false){
		die("{\"msg\":\"商品参数的格式错误\"}");
	}
	$P_time=$_POST["P_time"];
	$P_taobao=$_POST["P_taobao"];
	$P_sell=$_POST["P_sell"][$P_selltype];
	$P_keywords=$_POST["P_keywords"];
	$P_description=$_POST["P_description"];
	$P_address=$_POST["name"].",".$_POST["mobile"].",".$_POST["address"];
	$savepic=intval($_POST["savepic"]);
	if($savepic==1){
		$P_content=savepic($P_content,$dirx);
	}
	if($C_osson==1){
		editor2oss($P_content);
	}

	if($P_sort==0){
		die("{\"msg\":\"请选择一个商品分类\"}");
	}
	if($P_price<0){
		die("{\"msg\":\"商品价格不可为负\"}");
	}
	if($P_selltype==1 && $P_sell==0){
		die("{\"msg\":\"请选择一个卡密分类\"}");
	}

	if($P_title!=""){
		mysqli_query($conn,"insert into sl_product(P_pic,P_title,P_content,P_price,P_price2,P_sort,P_order,P_selltype,P_sell,P_rest,P_sh,P_unlogin,P_fx,P_tag,P_shuxing,P_video,P_time,P_sold,P_taobao,P_vip,P_top,P_tpl,P_keywords,P_description,P_address,P_vshow) values('$P_pic','$P_title','$P_content',$P_price,$P_price2,$P_sort,$P_order,$P_selltype,'$P_sell',$P_rest,$P_sh,$P_unlogin,$P_fx,'$P_tag','$P_shuxing','$P_video','$P_time',$P_sold,'$P_taobao',$P_vip,$P_top,$P_tpl,'$P_keywords','$P_description','$P_address',$P_vshow)");

		$P_id=getrs("select * from sl_product where P_title='$P_title' and P_pic='$P_pic' and P_sort=$P_sort","P_id");
		mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增商品')");
		die("{\"msg\":\"success\",\"P_id\":$P_id}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

if($action=="edit"){
	foreach ($_POST as $x=>$value) {
	    if(splitx($x,"_",0)=="picpic1"){
	        $pic=$pic.$_POST[$x]."|";
	    }
	}
	$P_pic=substr($pic,0,strlen($pic)-1);
	$P_title=$_POST["P_title"];
	$P_content=$_POST["P_content"];
	$P_price=round($_POST["P_price"],2);
	$P_price2=round($_POST["P_price2"],2);
	if($P_price2==0){
		$P_price2=$P_price;
	}
	if($P_price2>$P_price){
		die("{\"msg\":\"成本价不得高于售价\"}");
	}
	$P_sort=intval($_POST["P_sort"]);
	$P_order=intval($_POST["P_order"]);
	$P_selltype=intval($_POST["P_selltype"]);
	$P_rest=intval($_POST["P_rest"]);
	$P_sh=intval($_POST["P_sh"]);
	$P_unlogin=intval($_POST["P_unlogin"]);
	$P_fx=intval($_POST["P_fx"]);
	$P_sold=intval($_POST["P_sold"]);
	$P_vip=intval($_POST["P_vip"]);
	$P_top=intval($_POST["P_top"]);
	$P_tpl=intval($_POST["P_tpl"]);
	$P_vshow=intval($_POST["P_vshow"]);
	$P_tag=$_POST["P_tag"];
	$P_video=$_POST["P_video"];
	$P_shuxing=$_POST["P_shuxing"];
	$P_shuxing=str_replace("：", ":", $P_shuxing);
	if($P_shuxing!="" && strpos($P_shuxing, ":")===false){
		die("{\"msg\":\"商品参数的格式错误\"}");
	}
	$P_time=$_POST["P_time"];
	$P_sell=$_POST["P_sell"][$P_selltype];
	$P_keywords=$_POST["P_keywords"];
	$P_description=$_POST["P_description"];
	$P_address=$_POST["name"].",".$_POST["mobile"].",".$_POST["address"];
	$P_taobao=$_POST["P_taobao"];
	$savepic=intval($_POST["savepic"]);
	if($savepic==1){
		$P_content=savepic($P_content,$dirx);
	}
	if($C_osson==1){
		editor2oss($P_content);
	}

	if($P_sort==0){
		die("{\"msg\":\"请选择一个商品分类\"}");
	}

	if($P_price<0){
		die("{\"msg\":\"商品价格不可为负\"}");
	}
	if($P_price2<0){
		die("{\"msg\":\"商品价格不可为负\"}");
	}

	if($P_selltype==1 && $P_sell==0){
		die("{\"msg\":\"请选择一个卡密分类\"}");
	}

	if($P_title!=""){
		mysqli_query($conn, "update sl_product set
		P_pic='$P_pic',
		P_title='$P_title',
		P_content='$P_content',
		P_price=$P_price,
		P_price2=$P_price2,
		P_sort=$P_sort,
		P_order=$P_order,
		P_selltype=$P_selltype,
		P_rest=$P_rest,
		P_sh=$P_sh,
		P_unlogin=$P_unlogin,
		P_fx=$P_fx,
		P_sold=$P_sold,
		P_sell='$P_sell',
		P_tag='$P_tag',
		P_shuxing='$P_shuxing',
		P_time='$P_time',
		P_video='$P_video',
		P_keywords='$P_keywords',
		P_description='$P_description',
		P_address='$P_address',
		P_vip=$P_vip,
		P_top=$P_top,
		P_tpl=$P_tpl,
		P_vshow=$P_vshow,
		P_taobao='$P_taobao'
		where P_id=".$P_id);
		mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑商品')");
		die("{\"msg\":\"success\",\"P_id\":0}");
	}else{
		die("{\"msg\":\"请填全内容\"}");
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>商品设置 - 后台管理</title>

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
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;max-width: 100%;}
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

		<script type="text/javascript">

function AddPic()
{
 var i =pic1.rows.length;
 var newTr = pic1.insertRow();
 var _id='pp'+i;
 var newTd0 = newTr.insertCell();
 newTr.id=_id;
 newTd0.innerHTML ='<div class="row"><div class="col-md-3"><img src="../media/nopic.png" id="picpic1_'+i+'x" class="showpic" onClick="showUpload(\'picpic1_'+i+'\',\'picpic1_'+i+'\',\'../media\',1,null,\'\',\'\');" alt="<img src=\'../media/nopic.png\' class=\'showpicx\'>"></div><div class="col-md-9"><div class="input-group"><input type="text" id="picpic1_'+i+'" name="picpic1_'+i+'" class="form-control" value="nopic.png"><span class="input-group-btn"><button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload(\'picpic1_'+i+'\',\'picpic1_'+i+'\',\'../media\',1,null,\'\',\'\');">上传</button></span></div><button class="btn btn-danger btn-sm" type="button" onclick="DelPic('+i+')">- 删除该图</button></div></div>';
}

function DelPic(i){
  var Container = document.getElementById("pic1");    
    var _tr=document.getElementById("pp"+i);  
    row=_tr.rowIndex;
    Container.deleteRow(row); 
}

	</script>

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
					<a class="btn btn-primary pull-right btn-sm" href="psort_add.php" style="z-index: 2;position: relative;margin-right: 10px;"><i class="fa fa-plus-circle"></i> 新增商品分类</a>
					<a class="btn btn-primary pull-right btn-sm" href="product_add.php" style="z-index: 2;position: relative;margin-right: 10px;"><i class="fa fa-plus-circle"></i> 新增商品</a>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="product_list.php">商品管理</a></li>
                            <li class="breadcrumb-item"><a href="psort_add.php">商品分类</a></li>
                            <li class="breadcrumb-item"><a href="excel.php">导入EXCEL</a></li>
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
											<h4><?php echo $S_title?> -商品列表</h4>
										</div>
												<ul class="list-group">
													<?php 
													if($P_id==0){
														$sql="select * from sl_product,sl_psort where P_sort=S_id and P_del=0 order by S_order,P_order,P_id desc limit 20";
													}else{
														$sql="select * from sl_product,sl_psort where P_sort=S_id and P_del=0 and P_sort=$P_sort order by S_order,P_order,P_id desc limit 20";
													}
														
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["P_id"]==$P_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	echo "<a href=\"?P_id=".$row["P_id"]."\" class=\"list-group-item ".$active."\"><b>[".$row["S_title"]."]</b> ".htmlspecialchars($row["P_title"])."</a>";
																}
															}
													?>
													
												</ul>
											
										
									</div>
									<a href="product_add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增商品</a>
									<div class="pull-right"><a href="wholesale.php" class="btn btn-sm btn-info"><i class="fa fa-shopping-cart"></i> 货源采购</a></div>
								</div>

								<div class="col-lg-9">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>商品管理</h4>
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
													<label class="col-md-2 col-form-label" >商品标题</label>
													<div class="col-md-10">
														<input type="text" id="P_title" name="P_title" class="form-control" value="<?php echo htmlspecialchars($P_title)?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品图片</label>
													<div class="col-md-10" style="border: solid 1px #EEEEEE;padding-bottom: 10px;border-radius: 5px;background: #f9f9f9">
<table class="table" id="pic1">
															<?php
															$pic=explode("|",$P_pic);
															for($i=0;$i<count($pic);$i++){
																echo "<tr id=\"pp".$i."\"><td><div class=\"row\">
																<div class=\"col-md-3\">
																<img src=\"".pic2($pic[$i])."\" id=\"picpic1_".$i."x\" class=\"showpic\" onClick=\"showUpload('picpic1_".$i."','picpic1_".$i."','../media',1,null,'','');\" alt=\"<img src='".pic2($pic[$i])."' class='showpicx'>
																\"></div>

																<div class=\"col-md-9\">
																<div class=\"input-group\">
						                                        <input type=\"text\" id=\"picpic1_".$i."\" name=\"picpic1_".$i."\" class=\"form-control\" value=\"".$pic[$i]."\">
						                                        <span class=\"input-group-btn\">
						                                                <button class=\"btn btn-primary m-b-5 m-t-5\" type=\"button\" onClick=\"showUpload('picpic1_".$i."','picpic1_".$i."','../media',1,null,'','');\">上传</button>
						                                        </span>
						                                </div>
						                                <button class=\"btn btn-danger btn-sm\" type=\"button\" onclick=\"DelPic(".$i.")\">- 删除该图</button>
						                                </div>
						                                </div></td></tr>";
															}

															?>
</table>
<button class="btn btn-info btn-sm" type="button" onclick="AddPic()">+ 新增一个商品图</button>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品价格</label>
													<div class="col-md-4">

														<div class="input-group">
															<span class="input-group-addon">出售价</span>
														<input type="text"  name="P_price" class="form-control" value="<?php echo $P_price?>">
														<span class="input-group-addon">元</span>
													</div>

													<?php if($C_fzon==1){?>
													<div class="input-group">
														<span class="input-group-addon">成本价</span>
														<input type="text"  name="P_price2" class="form-control" value="<?php echo $P_price2?>">
														<span class="input-group-addon">元</span>
													</div>
													<?php }?>

													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA"><input type="checkbox" name="P_vip" value="1" <?php if($P_vip==1){echo "checked='checked'";}?>>参与VIP打折活动 <a href="vip.php">[设置折扣]</a></div>
													</div>

													<label class="col-md-2 col-form-label" >商品分类</label>
													<div class="col-md-4">
														<select name="P_sort" class="form-control">
															<?php
																$sql2="select * from sl_psort where S_del=0 and S_sub=0 order by S_order,S_id desc";
																	$result2 = mysqli_query($conn, $sql2);
																	if (mysqli_num_rows($result2) > 0) {
																	while($row2 = mysqli_fetch_assoc($result2)) {
																		echo "<optgroup label=\"".$row2["S_title"]."\">";
																		$sql="select * from sl_psort where S_del=0 and S_sub=".$row2["S_id"]." order by S_order,S_id desc";
																			$result = mysqli_query($conn, $sql);
																			if (mysqli_num_rows($result) > 0) {
																			while($row = mysqli_fetch_assoc($result)) {
																				if($P_sort==$row["S_id"]){
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
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*商品无法直接归到主分类，如果无法选择请先新建子分类</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >发布时间</label>
													<div class="col-md-4">
														<div class="input-group">
										                    <input type="text"  name="P_time" id="P_time" class="form-control" value="<?php echo $P_time?>">
										                    <span class="input-group-btn">
										                        <button class="btn btn-info" type="button" onclick="getdate()">获取</button>
										                    </span>
										                </div>
													</div>
													<label class="col-md-2 col-form-label" >商品销量</label>
													<div class="col-md-4">
														<div class="input-group">
														<input type="text"  name="P_sold" class="form-control" value="<?php echo $P_sold?>">
														<span class="input-group-addon">件</span>
													</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品排序</label>
													<div class="col-md-4" style="position: relative;">
														<input type="text"  name="P_order" class="form-control" value="<?php echo $P_order?>" placeholder="数字越小越靠前">
														<label style="position: absolute;right: 25px;top: 10px;"><input type="checkbox" name="P_top" value="1" <?php if($P_top==1){echo "checked='checked'";}?> >置顶</label>
													</div>
													<label class="col-md-2 col-form-label" >
														<?php
														if($P_mid==0){
															echo "商品审核";
														}else{
															echo "<span style=\"color:#ff0000\">商品审核<span>";
														}

														?>
													</label>
													<div class="col-md-4">
														
														<select class="form-control" name="P_sh">
															<option value="0" <?php if($P_sh==0){echo "selected=\"selected\"";}?>>未审核</option>
															<option value="1" <?php if($P_sh==1){echo "selected=\"selected\"";}?>>已通过</option>
															<option value="2" <?php if($P_sh==2){echo "selected=\"selected\"";}?>>未通过</option>
														</select>
													
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-2 col-form-label" >发货内容</label>
													<div class="col-md-10">
														<div class="buy">
															<label aa="P_selltype" <?php if($P_selltype==0){echo "class='checked'";}?>><input type="radio" name="P_selltype" value="0" onclick="change(0)" <?php if($P_selltype==0){echo "checked='checked'";}?>> [自动发货]固定内容</label>
															<label aa="P_selltype" <?php if($P_selltype==1){echo "class='checked'";}?>><input type="radio" name="P_selltype" value="1" onclick="change(1)" <?php if($P_selltype==1){echo "checked='checked'";}?>> [自动发货]卡密</label>
															<label aa="P_selltype" <?php if($P_selltype==2){echo "class='checked'";}?>><input type="radio" name="P_selltype" value="2" onclick="change(2)" <?php if($P_selltype==2){echo "checked='checked'";}?>> [手动发货]实物</label>
															<div style="font-size: 12px;color: #AAAAAA;display: inline-block;margin-left: 20px;">*不会设置？点击<a href="https://fahuo100.cn/h6.html" target="_blank">查看帮助</a></div>
														</div>
														<div id="P_sell1" style="position: relative;">
															<textarea id="P_file" name="P_sell[]" class="form-control" rows="3" placeholder="输入固定发货内容或上传附件" ><?php echo $P_sell?></textarea>
															<button type="button" class="btn btn-sm btn-info" style="position: absolute;right: 10px;bottom: 10px;" onClick="showUpload('P_file','<?php echo gethttp().$D_domain?>','../media');"><i class="fa fa-paperclip"></i> 上传附件</button>
														</div>
														<div id="P_sell2">
														<select class="form-control" name="P_sell[]">
															<option value="0">请选择一个卡密分类</option>
															<?php
																$sql="select * from sl_csort where S_del=0 order by S_id desc";
																	$result = mysqli_query($conn, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	while($row = mysqli_fetch_assoc($result)) {
																		if($P_sell==$row["S_id"]){
																			$selected="selected";
																		}else{
																			$selected="";
																		}
																		echo "<option value=\"".$row["S_id"]."\" ".$selected.">".$row["S_title"]."</option>";
																	}
																}
															?>
														</select>
														<a href="card_list.php" target="_blank" class="btn btn-info btn-sm" style="margin-top: 10px;">管理卡密</a>
														</div>

														<div id="P_sell3">
															<div class="input-group">
													            <span class="input-group-addon">商品余量</span>
													            <input type="text" class="form-control" name="P_rest" value="<?php echo $P_rest?>">
													        </div>
													        <div style="margin-top: 10px;border: solid 1px #ced4da;padding: 10px 10px 0 10px ;border-radius: 5px;">收件信息开关：
													        	<label><input type="checkbox" name="name" value="name" <?php if(strpos($P_address,"name")!==false){echo "checked='checked'";}?>> 收件人</label>
													        	<label><input type="checkbox" name="mobile" value="mobile" <?php if(strpos($P_address,"mobile")!==false){echo "checked='checked'";}?>> 手机号码</label>
													        	<label><input type="checkbox" name="address" value="address" <?php if(strpos($P_address,"address")!==false){echo "checked='checked'";}?>> 收件地址</label>
													        </div>
														<div style="font-size: 12px;margin-top: 10px;">*实物商品，请手动给用户发货</div>
													</div>
													</div>
												</div>


<div class="panel-group" id="accordion">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" style="display: block;text-align: center;background: #f7f7f7;margin-bottom: 10px;font-weight: bold;padding: 5px;">＋展开高级功能</a>
            
        <div id="collapseThree" class="panel-collapse collapse" style="background: #f7f7f7;padding: 10px;margin-bottom: 10px;border-radius: 10px;">
<div class="form-group row">
													<label class="col-md-2 col-form-label" >SEO关键词</label>
													<div class="col-md-10">
														<input type="text" id="P_keywords" name="P_keywords" class="form-control" value="<?php echo $P_keywords?>" placeholder="多个词用,隔开">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >SEO描述</label>
													<div class="col-md-10">
														<textarea name="P_description" id="P_description" class="form-control"><?php echo $P_description?></textarea>
													</div>
												</div>
        	<hr>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" >免登录购买</label>
													<div class="col-md-4 buy">
														<label aa="P_unlogin" <?php if($P_unlogin==1){echo "class='checked'";}?>><input type="radio" name="P_unlogin" value="1"  <?php if($P_unlogin==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="P_unlogin" <?php if($P_unlogin==0){echo "class='checked'";}?>><input type="radio" name="P_unlogin" value="0"  <?php if($P_unlogin==0){echo "checked='checked'";}?>> 关闭</label>
													</div>

													<label class="col-md-2 col-form-label" >分销推广</label>
													<div class="col-md-4 buy">
														<label aa="P_fx" <?php if($P_fx==1){echo "class='checked'";}?>><input type="radio" name="P_fx" value="1"  <?php if($P_fx==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="P_fx" <?php if($P_fx==0){echo "class='checked'";}?>><input type="radio" name="P_fx" value="0"  <?php if($P_fx==0){echo "checked='checked'";}?>> 关闭</label>
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label">外部链接</label>
													<div class="col-md-4 buy">
														<textarea name="P_taobao" class="form-control" rows="2" placeholder=""><?php echo $P_taobao?></textarea>
														<p style="font-size: 12px;margin-top: 10px;"> *可以填写淘宝/京东等外部购买链接，点击购买时自动跳转</p>
													</div>
												
													<label class="col-md-2 col-form-label">插入视频</label>
													<div class="col-md-4">
														<textarea name="P_video" id="P_video" class="form-control" rows="3" placeholder="上传mp4视频或者粘贴视频代码"><?php echo $P_video?></textarea>
														<label style="position: absolute;right: 100px;bottom: 50px;"><input type="radio" name="P_vshow" value="0" <?php if($P_vshow==0){echo "checked='checked'";}?> >顶部显示</label>
														<label style="position: absolute;right: 25px;bottom: 50px;"><input type="radio" name="P_vshow" value="1" <?php if($P_vshow==1){echo "checked='checked'";}?> >底部显示</label>
														<p style="font-size: 12px;margin-top: 10px;"><button class="btn btn-sm btn-primary" type="button" onClick="showUpload('P_video','P_video','../media',1,null,'','');">上传视频</button> *如果您不知道如何使用视频功能，请点击<a href="https://fahuo100.cn/h18.html" target="_blank">查看帮助</a></p>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-2 col-form-label">商品Tag</label>
													<div class="col-md-4">
														<textarea name="P_tag" class="form-control" rows="3" placeholder="多个标签用空格隔开"><?php echo $P_tag?></textarea>
														
														<p style="font-size: 12px;margin-top: 10px;">*使用Tag功能，方便用户快速定位具有相同标签的商品，多个标签用空格隔开</p>
													</div>

												
													<label class="col-md-2 col-form-label">商品参数</label>
													<div class="col-md-4">
														
														<textarea id="P_shuxing" name="P_shuxing" class="form-control" rows="3" placeholder="格式：参数名:参数值（每行一个）"><?php echo $P_shuxing?></textarea>
														
														<p style="font-size: 12px;margin-top: 10px;">*举例：颜色:黑色 </p>
														<div style="float: right;margin-top: -35px"><label><input type="checkbox" name="P_tpl" value="1" <?php if($P_tpl==1){echo "checked='checked'";}?>>设为模板</label> <button class="btn btn-sm btn-info" type="button" onclick="$('#tpl').show()">调用模板</button></div>

														<div style="max-height: 100px;overflow: auto;background: #ffffff;padding:10px; font-size: 12px;display: none;" id="tpl">
															<?php

															$sql="select * from sl_product where P_tpl=1 and P_del=0";
															$result = mysqli_query($conn,  $sql);
															if (mysqli_num_rows($result) > 0) {
															while($row = mysqli_fetch_assoc($result)) {
															        echo "<div>".$row["P_shuxing"]." <button class=\"btn btn-sm btn-info\" type=\"button\" onclick=\"$('#tpl').hide();$('#P_shuxing').val('".str_replace("\r\n","\\r\\n",$row["P_shuxing"])."')\">调用</button></div>";
															    }
															} 
															?>
														</div>
													</div>
												</div>
												
</div>
												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品介绍</label>
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
		                                                <textarea name='P_content' style='width:100%;height:350px;' id='content'><?php echo $P_content?></textarea>
		                                                <label style="font-size: 12px;margin-top: 5px;text-align: right;"><input id="savepic" type="checkbox" value="1" name="savepic">保存编辑器内的远程图片到本地</label>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" ></label>
													<div class="col-md-10">
														<button class="btn btn-info" type="button" onClick="save(1)">保存</button>
														<button class="btn btn-primary" type="button" onClick="save(2)">保存并返回</button>
														<div class="pull-right">无商品可卖？<a href="wholesale.php" target="_balnk" class="btn btn-sm btn-success"><i class="fa fa-shopping-cart"></i> 货源采购</a></div>
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
		var $P_selltype=<?php echo $P_selltype?>;
		$("#P_sell1").hide();
		$("#P_sell2").hide();
		$("#P_sell3").hide();
		switch($P_selltype){
			case 0:
			$("#P_sell1").show();
			break;

			case 1:
			$("#P_sell2").show();
			break;

			case 2:
			$("#P_sell3").show();
			break;
		}
		function getdate(){
			var day1 = new Date();
			day1.setDate(day1.getDate());
			var s1 = day1.format("yyyy-MM-dd hh:mm:ss");
			$("#P_time").val(s1);
		}
		
		function change(id){
			$("#P_sell1").hide();
			$("#P_sell2").hide();
			$("#P_sell3").hide();

			switch(id){
				case 0:
				$("#P_sell1").show();
				break;

				case 1:
				$("#P_sell2").show();
				break;

				case 2:
				$("#P_sell3").show();
				break;
			}
		}

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
	            		if(data.P_id==0){
	            			toastr.success("保存成功", "成功");
	            		}else{
	            			window.location.href="product_add.php?P_id="+data.P_id;
	            		}
            		}else{
            			window.location.href="product_list.php";
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
	            	url:'news_add.php?action=caiji',
	            	type:'post',
	            	data:{url:$("#url").val()},
	            	success:function (data) {
		            	data=JSON.parse(data);
		            	if(data.msg=="success"){
		            		toastr.success("采集成功", "成功");
		            		$("#P_title").val(data.title);
		            		$("#picpic1_0").val(data.img);
		            		$("#picpic1_0x").attr("src","../media/"+data.img);
		            		$("#P_keywords").val(data.keyword);
		            		$("#P_description").val(data.description);
		            		$("#savepic").attr("checked","checked");
		            		editor.html(data.content);
		            	}else{
		            		toastr.error(data.msg, '错误');
		            	}
	            	}
	            });

			}

			$(function() { $('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});

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
		</script>
	</body>
</html>
