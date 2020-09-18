<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if(time()-strtotime($M_sellertime)>$M_sellerlong*86400 && $C_fzk==1){//商家到期
	Header("Location:seller.php");
	die();
}

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);
$action=$_GET["action"];

if($action=="edit"){
	$M_qrcode=htmlspecialchars($_POST["M_qrcode"]);
	$M_contact=htmlspecialchars($_POST["M_contact"]);

	foreach ($_POST as $x=>$value) {
	    if(splitx($x,"_",0)=="picpic1"){
	        $C_kf=$C_kf.$_POST[$x]."_".$_POST["picpic2_".splitx($x,"_",1)]."_".$_POST["picpic3_".splitx($x,"_",1)]."|";
	    }
	}
	$C_kf=substr($C_kf,0,strlen($C_kf)-1);
	$M_kefu=$C_kf;

	if($M_qrcode!=""){
		mysqli_query($conn,"update sl_member set M_qrcode='$M_qrcode',M_contact='$M_contact',M_kefu='$M_kefu' where M_id=".$M_id);
		box("修改成功！","contact.php","success");
	}else{
		box("请填全信息!","back","error");
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
  <title>分站设置 -会员中心</title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 <style>
		.showpic{height: 50px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 300px}
</style>

	<script type="text/javascript">

function AddPic(){
 var i =pic1.rows.length;
 var newTr = pic1.insertRow();
 var _id='pp'+i;
 var newTd0 = newTr.insertCell();
 newTr.id=_id;
 newTd0.innerHTML ='<div class="input-group"><input type="text" style="width:30%" name="picpic3_'+i+'" class="form-control" value="" placeholder="职务"><input style="width:30%" type="text" name="picpic1_'+i+'" class="form-control" value="" placeholder="号码"><select style="width:30%" class="form-control" name="picpic2_'+i+'"><option value="qq">QQ客服</option><option value="ww">旺旺客服</option><option value="wx">微信客服</option><option value="phone">电话号码</option><option value="email">电子邮箱</option></select><span class="input-group-btn"><button class="btn btn-primary m-b-5  m-t-5" type="button" onclick="DelPic('+i+')">－ 删除</button></span></div>'
 
}
function DelPic(i){
  var Container = document.getElementById("pic1");    
    var _tr=document.getElementById("pp"+i);  
    row=_tr.rowIndex;
    Container.deleteRow(row); 
}

	</script>

  <!--[if lt IE 9]>
    <script src="http://ec.yto.net.cn/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="http://ec.yto.net.cn/assets/css/ie8.min.css">
    <script src="http://ec.yto.net.cn/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
	<script>
		var _ctxPath='';
	</script>    
</head>

<link rel="stylesheet" href="css/cropper.min.css">
<body id="crop-avatar" class="body-index">
  

<?php

require 'top.php';
?>
<div class="page">
<div class="container m_top_10">
			<ol class="breadcrumb">
				<li><i class="icon fa-home" aria-hidden="true"></i><a href="../">首页</a></li>
				<li>用户信息</li>
				<li class="active">基本设置</li>
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
	        <li class="active"><a href="contact.php">联系方式</a></li>
	        <li><a href="slide.php">焦点图设置</a></li>
	        <li><a href="template.php">模板设置</a></li>
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">

							<div class="form-group">
								<label class="col-md-2 control-label" >微信二维码</label>
								<div class="col-md-4">
									<p><img src="../media/<?php echo $M_qrcode?>" id="M_qrcodex" class="showpic" onClick="showUpload('M_qrcode','M_qrcode','../media',1,null,'','');" alt="<img src='../media/<?php echo $M_qrcode?>' class='showpicx'>"></p>
									<div class="input-group">
	                                        <input type="text" id="M_qrcode" name="M_qrcode" class="form-control" value="<?php echo $M_qrcode?>">
	                                        <span class="input-group-btn">
	                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('M_qrcode','M_qrcode','../media',1,null,'','');">上传</button>
	                                        </span>
	                                </div>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">联系方式</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="5" name="M_contact"><?php echo $M_contact?></textarea>
								</div>
							</div>

												<div class="form-group">
													<label class="col-md-2 control-label" >客服设置</label>
													<div class="col-md-10">
														<table class="table" id="pic1">

														<?php
															$kf=explode("|",$M_kefu);
															for($i=0;$i<count($kf);$i++){
																if(splitx($kf[$i],"_",1)=="qq"){
																	$qq="selected='selected'";
																}else{
																	$qq="";
																}

																if(splitx($kf[$i],"_",1)=="ww"){
																	$ww="selected='selected'";
																}else{
																	$ww="";
																}

																if(splitx($kf[$i],"_",1)=="wx"){
																	$wx="selected='selected'";
																}else{
																	$wx="";
																}

																if(splitx($kf[$i],"_",1)=="phone"){
																	$phone="selected='selected'";
																}else{
																	$phone="";
																}

																if(splitx($kf[$i],"_",1)=="email"){
																	$email="selected='selected'";
																}else{
																	$email="";
																}
																echo '<tr id="pp'.$i.'"><td><div class="input-group">
															            <input type="text" style="width:30%" placeholder="职务" name="picpic3_'.$i.'" class="form-control" value="'.splitx($kf[$i],"_",2).'">
															            <input type="text" style="width:30%" placeholder="号码" name="picpic1_'.$i.'" class="form-control" value="'.splitx($kf[$i],"_",0).'">
															            <select class="form-control" style="width:30%" name="picpic2_'.$i.'">
															            	<option value="qq" '.$qq.'>QQ客服</option>
															            	<option value="ww" '.$ww.'>旺旺客服</option>
															            	<option value="wx" '.$wx.'>微信客服</option>
															            	<option value="phone" '.$phone.'>电话号码</option>
															            	<option value="email" '.$email.'>电子邮箱</option>
															            </select>
															            <span class="input-group-btn">
															                    <button class="btn btn-primary m-b-5  m-t-5" type="button" onclick="DelPic('.$i.')">－ 删除</button>
															            </span>
															    </div></td></tr>';
															}
														?>

</table>
														<button type="button" class="btn btn-primary btn-sm" onclick="AddPic()">＋ 新增一个客服</button>
														<span class="pull-right">说明：显示在网站右侧</span>
													</div>
												</div>


							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="保存" class="btn btn-primary btn-block m_top_20" >
								</div>
							</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php require 'foot.php';?>
<script type="text/javascript" src="../upload/upload.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/page.js"></script>
</body>
</html>