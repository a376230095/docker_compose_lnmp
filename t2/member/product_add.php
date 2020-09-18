<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	Header("Location:seller.php");
	die();
}

$action=$_GET["action"];
$P_id=intval($_GET["P_id"]);

if($P_id!=""){
	$aa="edit&P_id=".$P_id;
	$title="编辑";
	$sql="select * from sl_product,sl_psort where P_sort=S_id and P_id=$P_id and P_mid=$M_id";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$P_pic=$row["P_pic"];
		$P_title=$row["P_title"];
		$S_title=$row["S_title"];
		$P_content=$row["P_content"];
		$P_price=$row["P_price"];
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
		if($P_time==""){
			$P_time=date('Y-m-d H:i:s');
		}
	}
}else{
	$aa="add";
	$title="新增";
	$P_pic="nopic.png";
	$P_selltype=0;
	$P_rest=100;
	$P_sh=1;
	$P_unlogin=1;
	$P_fx=1;
	$P_time=date('Y-m-d H:i:s');
	$P_sold=0;
	$P_vip=1;
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
	$P_sort=intval($_POST["P_sort"]);
	$P_order=intval($_POST["P_order"]);
	$P_selltype=intval($_POST["P_selltype"]);
	$P_rest=intval($_POST["P_rest"]);
	$P_sh=intval($_POST["P_sh"]);
	$P_unlogin=intval($_POST["P_unlogin"]);
	$P_fx=intval($_POST["P_fx"]);
	$P_sold=intval($_POST["P_sold"]);
	$P_vip=intval($_POST["P_vip"]);
	$P_tag=$_POST["P_tag"];
	$P_video=$_POST["P_video"];
	$P_shuxing=$_POST["P_shuxing"];
	$P_time=$_POST["P_time"];
	$P_taobao=$_POST["P_taobao"];
	$P_sell=$_POST["P_sell"][$P_selltype];

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
		mysqli_query($conn,"insert into sl_product(P_pic,P_title,P_content,P_price,P_sort,P_order,P_selltype,P_sell,P_rest,P_sh,P_unlogin,P_fx,P_tag,P_shuxing,P_video,P_time,P_taobao,P_vip,P_mid) values('$P_pic','$P_title','$P_content',$P_price,$P_sort,$P_order,$P_selltype,'$P_sell',$P_rest,".intval($C_punsh).",$P_unlogin,$P_fx,'$P_tag','$P_shuxing','$P_video','$P_time','$P_taobao',$P_vip,$M_id)");

		$P_id=getrs("select * from sl_product where P_title='$P_title' and P_pic='$P_pic' and P_sort=$P_sort","P_id");
		if($C_punsh==0 && $C_dx4==1){
			sendsms("【".$C_smssign."】有商户发布商品等待审核，请登录后台处理",$C_mobile);
		}
		
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
	$P_sort=intval($_POST["P_sort"]);
	$P_order=intval($_POST["P_order"]);
	$P_selltype=intval($_POST["P_selltype"]);
	$P_rest=intval($_POST["P_rest"]);
	$P_sh=intval($_POST["P_sh"]);
	$P_unlogin=intval($_POST["P_unlogin"]);
	$P_fx=intval($_POST["P_fx"]);
	$P_sold=intval($_POST["P_sold"]);
	$P_vip=intval($_POST["P_vip"]);
	$P_tag=$_POST["P_tag"];
	$P_video=$_POST["P_video"];
	$P_shuxing=$_POST["P_shuxing"];
	$P_time=$_POST["P_time"];
	$P_sell=$_POST["P_sell"][$P_selltype];
	$P_taobao=$_POST["P_taobao"];

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
		mysqli_query($conn, "update sl_product set
		P_pic='$P_pic',
		P_title='$P_title',
		P_content='$P_content',
		P_price=$P_price,
		P_sort=$P_sort,
		P_order=$P_order,
		P_selltype=$P_selltype,
		P_rest=$P_rest,
		P_sh=".intval($C_punsh).",
		P_unlogin=$P_unlogin,
		P_fx=$P_fx,
		P_sell='$P_sell',
		P_tag='$P_tag',
		P_shuxing='$P_shuxing',
		P_time='$P_time',
		P_video='$P_video',
		P_vip=$P_vip,
		P_taobao='$P_taobao'
		where P_id=$P_id and P_mid=$M_id");

		if($C_punsh==0 && $C_dx4==1){
			sendsms("【".$C_smssign."】有商户发布商品等待审核，请登录后台处理",$C_mobile);
		}
		die("{\"msg\":\"success\",\"P_id\":0}");
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
		.list-group a{text-decoration:none}
		.btn-danger{margin-top: 10px;}

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

<body class="body-index">
<?php require 'top.php';?>
		<div class="container m_top_30">
			<div class="yto-box">
				<div class="row">
					<div class="col-sm-2 hidden-xs">
			<h5 class="p_bottom_10">商品管理</h5>
		<ul class="nav nav-pills nav-stacked">
	        <li ><a href="product_sell.php">商品列表</a></li>
	        <li class="active"><a href="product_add.php">新增商品</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $title?>商品</div>
							<div class="panel-body">
								<form id="form">

												<div class="form-group row" style="display: none" id="cj">
													<label class="col-md-2 col-form-label">采集文章<br><button type="button" class="btn btn-info btn-sm" onClick="$('#cj').hide()">隐藏</button></label>
													<div class="col-md-10 buy">
														<textarea  id="url" class="form-control" rows="3" placeholder="输入网页地址"></textarea>
														<p style="font-size: 12px;margin-top: 10px;"><button class="btn btn-sm btn-primary" type="button" onClick="caiji()">采集</button> *会自动采集文章标题/配图/内容；目前仅支持输入微信公众号文章地址</p>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品标题</label>
													<div class="col-md-10">
														<input type="text" id="P_title" name="P_title" class="form-control" value="<?php echo htmlspecialchars($P_title)?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品价格</label>
													<div class="col-md-4">

														<div class="input-group">
														<input type="text"  name="P_price" class="form-control" value="<?php echo $P_price?>">
														<span class="input-group-addon">元</span>
													</div>
													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA"><input type="checkbox" name="P_vip" value="1" <?php if($P_vip==1){echo "checked='checked'";}?>>参与VIP打折活动 </div>
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
													<div class="col-md-4" style="padding-top: 2px">
														<?php echo $P_sold;?>件
													</div>
													
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" >商品图片</label>
													<div class="col-md-10">
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
													<label class="col-md-2 col-form-label" >商品排序</label>
													<div class="col-md-10">
														<input type="text"  name="P_order" class="form-control" value="<?php echo $P_order?>" placeholder="数字越小越靠前">
													</div>
													
												</div>


												<div class="form-group row">
													<label class="col-md-2 col-form-label" >发货内容</label>
													<div class="col-md-10 buy">
														<label aa="P_selltype" <?php if($P_selltype==0){echo "class='checked'";}?>><input type="radio" name="P_selltype" value="0" onclick="change(0)" <?php if($P_selltype==0){echo "checked='checked'";}?>> [自动发货]固定内容</label>
														<label aa="P_selltype" <?php if($P_selltype==1){echo "class='checked'";}?>><input type="radio" name="P_selltype" value="1" onclick="change(1)" <?php if($P_selltype==1){echo "checked='checked'";}?>> [自动发货]卡密</label>
														<label aa="P_selltype" <?php if($P_selltype==2){echo "class='checked'";}?>><input type="radio" name="P_selltype" value="2" onclick="change(2)" <?php if($P_selltype==2){echo "checked='checked'";}?>> [手动发货]实物</label>
														<div style="font-size: 12px;color: #AAAAAA;display: inline-block;margin-left: 20px;">*不会设置？点击 <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal">查看帮助</button></div>

														<textarea name="P_sell[]" class="form-control" rows="3" placeholder="输入固定发货内容" id="P_sell1"><?php echo $P_sell?></textarea>
														<div id="P_sell2">
														<select class="form-control" name="P_sell[]">
															<option value="0">请选择一个卡密分类</option>
															<?php
																$sql="select * from sl_csort where S_del=0 and S_mid=".$M_id." order by S_id desc";
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
														<a href="card_sell.php" target="_blank" class="btn btn-info btn-sm" style="margin-top: 10px;">管理卡密</a>
														</div>

														<div id="P_sell3">
															<div class="input-group">
													            <span class="input-group-addon">商品余量</span>
													            <input type="text" class="form-control" name="P_rest" value="<?php echo $P_rest?>">
													        </div>
														<p style="font-size: 12px;margin-top: 10px;">*实物商品，请手动给用户发货</p>
													</div>
													</div>
												</div>

<div class="panel-group" id="accordion">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" style="display: block;text-align: center;background: #f7f7f7;margin-bottom: 10px;font-weight: bold;padding: 5px;">＋展开高级功能</a>
            
        <div id="collapseThree" class="panel-collapse collapse" style="background: #f7f7f7;padding: 10px;margin-bottom: 10px;border-radius: 10px;">
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
													<div class="col-md-10 buy">
														<textarea name="P_taobao" class="form-control" rows="2" placeholder=""><?php echo $P_taobao?></textarea>
														<p style="font-size: 12px;margin-top: 10px;"> *可以填写淘宝/京东等外部购买链接，点击购买时自动跳转</p>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-2 col-form-label">插入视频</label>
													<div class="col-md-10 buy">
														<textarea name="P_video" id="P_video" class="form-control" rows="3" placeholder="上传mp4视频或者粘贴视频代码"><?php echo $P_video?></textarea>
														<p style="font-size: 12px;margin-top: 10px;"><button class="btn btn-sm btn-primary" type="button" onClick="showUpload('P_video','P_video','../media',1,null,'','');">上传视频</button> *如果您不知道如何使用视频功能，请点击 <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#myModal2">查看帮助</button></p>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-2 col-form-label">商品Tag</label>
													<div class="col-md-10">
														<textarea name="P_tag" class="form-control" rows="3" placeholder="多个标签用空格隔开"><?php echo $P_tag?></textarea>
														
														<p style="font-size: 12px;margin-top: 10px;">*使用Tag功能，方便用户快速定位具有相同标签的商品，多个标签用空格隔开</p>
													</div>

												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label">商品参数</label>
													<div class="col-md-10">
														<textarea name="P_shuxing" class="form-control" rows="3" placeholder="格式：每行一个"><?php echo $P_shuxing?></textarea>
														
														<p style="font-size: 12px;margin-top: 10px;">*格式：每行一个</p>
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
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-2 col-form-label" ></label>
													<div class="col-md-10">
														<button class="btn btn-info" type="button" onClick="save(1)">保存</button>
														<button class="btn btn-primary" type="button" onClick="save(2)">保存并返回</button>
														<!--<div class="pull-right">无商品可卖？<a href="" target="_balnk" class="btn btn-sm btn-success"><i class="fa fa-shopping-cart"></i> 货源批发</a></div>-->
													</div>
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
					如何设置自动发货内容？
				</h4>
			</div>
			<div class="modal-body">
				<p>发货100-虚拟商品自动发货系统主打的功能为自动发货和付费阅读</p>
            <img src="https://fahuo100.cn/images/6.1.png">
            <div class="description">
                <p>1.进入网站后台，点击左侧的内容管理-商品管理-新增商品，可以看到有3种发货方式</p>
            </div>
            <img src="https://fahuo100.cn/images/6.2.png">
            <div class="description">
                <p>（1）固定内容：即不同用户购买，发货相同的内容，可以设置下载链接、解压密码等可以重复使用的商品；
                由于每次都是发货固定内容，因此无需设置库存（前台库存会显示为充足），且购买时只可购买一件</p>
            </div>
            <img src="https://fahuo100.cn/images/6.3.png">
            <div class="description">
                <p>（2）卡密：即不同用户购买，发货不同的内容，可以设置激活码、CDK、优惠码等一次性商品；
                需要配合卡密模块进行使用，选择相应的卡密分类即可，缺货时会有缺货提醒</p>
            </div>
            <img src="https://fahuo100.cn/images/6.4.png">
            <div class="description">
                <p>（3）实物商品：比如衣服、手机、食品等实物商品，用户付款后，需要手动使用快递发货，可以设置库存（商品余量）</p>
            </div>
        </div>

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



<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 100%;max-width: 1000px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					商品/文章模块如何插入视频？
				</h4>
			</div>
			<div class="modal-body">
				<p>发货100目前支持3种插入视频的方式</p>
<p>（1）自行上传mp4视频</p>
<p>（2）外链播放器代码，如优酷，爱奇艺等</p>
<p>（3）外链视频URL</p>
<p>下面详细介绍如何使用：</p>
<p><b>（1）自行上传mp4视频</b></p>
<p>如果视频小于2M，可以使用上传视频的按钮进行上传，如果视频大于2M，可以通过FTP将视频上传到media文件夹，然后填写视频名称即可。</p>
<img src="https://fahuo100.cn/images/18.1.png">
<p><b>（2）外链播放器代码</b></p>
<p>举例：访问优酷，找到视频播放页面，点击分享-复制通用代码，然后粘贴代码即可</p>
<img src="https://fahuo100.cn/images/18.2.png">
<img src="https://fahuo100.cn/images/18.3.png">
<p><b>（3）外链视频URL</b></p>
<p>如果视频文件在其他服务器上，可以直接填写完整的视频URL，举例：http://www.aaa.com/1.mp4，也可以播放视频</p>
<img src="https://fahuo100.cn/images/18.4.png">
<p>注意事项：小程序和APP内仅支持第1种和第3种视频播放</p>
            </div>

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
	<script>
$(function() { $('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});
	</script>
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
	            			alert("保存成功");
	            		}else{
	            			window.location.href="product_add.php?P_id="+data.P_id;
	            		}
            		}else{
            			window.location.href="product_sell.php";
            		}
            	}else{
            		alert(data.msg);
            	}
            	}
            });

			}
			function getdate(){
			var day1 = new Date();
			day1.setDate(day1.getDate() - 1);
			var s1 = day1.format("yyyy-MM-dd hh:mm:ss");
			$("#P_time").val(s1);
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
		</script>
</body>
</html>