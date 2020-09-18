<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);
$action=$_GET["action"];

if($action=="edit"){
	$pic=gen_key(20);
	$pic_code=base64_decode(splitx($_POST["headFile"],",",1));
	file_put_contents("../media/".$pic.".jpg", $pic_code);
	$M_email=htmlspecialchars($_POST["M_email"]);
	$M_shop=htmlspecialchars($_POST["M_shop"]);
	$M_qq=htmlspecialchars($_POST["M_qq"]);
	$M_notice=htmlspecialchars($_POST["M_notice"]);
	if($M_email!=""){
		mysqli_query($conn,"update sl_member set M_email='".$M_email."',M_shop='".$M_shop."',M_qq='".$M_qq."',M_notice='".$M_notice."' where M_id=".$M_id);
		if($_POST["headFile"]!=""){
			mysqli_query($conn,"update sl_member set M_head='".$pic.".jpg' where M_id=".$M_id);
		}
		box("修改成功！","edit.php","success");
	}else{
		box("请填全资料!","back","error");
	}
}

if($action=="sendcode"){
    if($C_dx1==1){
    	$mobile=$_GET["mobile"];
    	if(preg_match("/^1[345678]{1}\d{9}$/",$mobile)){
    		$pwd_code=rand(10000, 99999);

    		if(getrs("select * from sl_member where M_mobile='".$mobile."'","M_login")==""){
    			mysqli_query($conn,"update sl_member set M_pwdcode='".$pwd_code."' where M_id=".$_SESSION["M_id"]);
				$info=sendsms("【".$C_smssign."】您的验证码为".$pwd_code."；1分钟内有效,请尽快验证！",$mobile) ;
				if($info=="success"){
	                die("{\"code\":\"success\",\"msg\":\"发送成功！\"}");
	            }else{
	                die("{\"code\":\"error\",\"msg\":\"请".$info."秒后再试！\"}");
	            }
    		}else{
    			die("{\"code\":\"error\",\"msg\":\"该手机号已被占用！\"}");
    		}
            
    	}else{
    		die("{\"code\":\"error\",\"msg\":\"请填写正确的手机号！\"}");
    	}
    }else{
        die("{\"code\":\"error\",\"msg\":\"管理员未开启短信功能！\"}");
    }
}

if($action=="unbind_qq"){
	mysqli_query($conn,"update sl_member set M_openid='' where M_id=".$M_id);
	$M_openid="";
}
if($action=="unbind_wx"){
	mysqli_query($conn,"update sl_member set M_wxid='' where M_id=".$M_id);
	$M_wxid="";
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
  <title>编辑资料 -会员中心</title>
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
				<li class="active">信息修改</li>
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
	        <li class="active"><a href="edit.php">基本信息</a></li>
	        <li><a href="address.php">收货地址</a></li>
            <li><a href="pwdedit.php">密码修改</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
                           <div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">头像</label>
								<div class="col-sm-4">								
								<div class="avatar-edit"  title="点击上传头像">
								<img id="headUrlImg" src="../media/<?php echo $M_head?>"> 
                                <input type="hidden"  name="headFile"  class="headimg">
                                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                                </div>
								</div>
							</div>
							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">帐号</label>
								<div class="col-sm-4">
								   <input name="M_login" value="<?php echo $M_login?>"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">邮箱</label>
								<div class="col-sm-4">
								   <input name="M_email"  value="<?php echo $M_email?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">QQ</label>
								<div class="col-sm-4">
								   <input name="M_qq"  value="<?php echo $M_qq?>"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">店铺名称</label>
								<div class="col-sm-4">
								   <input name="M_shop"  value="<?php echo $M_shop?>"  class="form-control" >
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">店铺公告</label>
								<div class="col-sm-4">
								   <textarea class="form-control" name="M_notice" rows="5"><?php echo $M_notice;?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label">快捷登录</label>
								<div class="col-sm-10">
								<?php 
								if($C_qqon==1){
									if($M_openid==""){
										echo "<a class=\"btn btn-info\" href=\"../qq/qqlogin.php?from=".urlencode("../member/edit.php")."&M_id=".$M_id."\"><i class=\"fa fa-qq\"></i> 绑定QQ</a> ";
									}else{
										echo "<a class=\"btn btn-info\" href=\"?action=unbind_qq\"><i class=\"fa fa-qq\"></i> 解绑QQ</a> ";
									}
								}
								if($C_wxon==1){
									if($M_wxid==""){
										if(isMobile()){
											echo "<a class=\"btn btn-success\" href=\"".gethttp().$D_domain."/pay/wxpay/login.php?M_id=".$M_id."\"><i class=\"fa fa-weixin\"></i> 绑定微信</a> ";
										}else{
											echo "<button class=\"btn btn-success\" type=\"button\" data-toggle=\"modal\" data-target=\"#myModalx\"><i class=\"fa fa-weixin\"></i> 绑定微信</button> ";
										}
									}else{
										echo "<a class=\"btn btn-success\" href=\"?action=unbind_wx\"><i class=\"fa fa-weixin\"></i> 解绑微信</a> ";
									}
								}
								/*if($C_dxon==1){
									if($M_mobile==""){
										echo "<button class=\"btn btn-warning\" type=\"button\" data-toggle=\"modal\" data-target=\"#myModal2\"><i class=\"fa fa-mobile\"></i> 绑定手机</button> ";
									}else{
										echo "<a class=\"btn btn-warning\" href=\"#\"><i class=\"fa fa-mobile\"></i> ".$M_mobile."</a> ";
									}
								}*/
								?>
								   
								</div>
							</div>
														
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="修改" class="btn btn-primary btn-block m_top_20" >
								</div>
							</div>
</form>
</div>
</div>
</div>
</div>
</div>

	  <div class="modal fade" id="avatar-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title">修改头像</h4>
        </div>
      
         <div class="modal-body  avatar-form">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar-src">
                  <input type="hidden" class="avatar-data" name="avatar-data">
                  
                  <div class="input-group input-group-file">

		            <span class="btn btn-default btn-file">
		               <i aria-hidden="true" class="icon fa-upload"></i>
		               <span>浏览本地照片</span>
		               <input type="file" class="avatar-input" id="avatarInput" name="avatar-input">
		      </span>
		    </div>                 
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>
                <div class="row avatar-btns">
                  <div class="col-md-4 col-md-offset-4">
                      <button type="botton" class="btn btn-primary btn-block avatar-save">完成</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- </form> -->
    </div>
  </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
            aria-hidden="true">×
        </button>
        <h4 class="modal-title" id="myModalLabel">
          绑定手机
        </h4>
      </div>
      <div class="modal-body">
      	<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form2">
                           
              <div class="form-group">
                <label for="oldpass" class="col-sm-2 control-label">手机号</label>
                <div class="col-sm-10">
          <div class="input-group">
                    <input name="M_mobile" maxlength="11" id="mobile" value="<?php echo $M_mobile?>" class="form-control" >
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="send_btn" onclick="sendmobile($('#mobile').val())">获取验证码</button>
                    </span>
                </div>
                </div>
              </div>
                            
              <div class="form-group">
                <label for="oldpass" class="col-sm-2 control-label">验证码</label>
                <div class="col-sm-10">
                   <input name="code" maxlength="50" value=""  class="form-control" >
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-sm-offset-2  col-sm-2">
                   <input type="submit" value="确定" class="btn btn-primary btn-block m_top_20" >
                </div>
              </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" 
            data-dismiss="modal">关闭
        </button>
        
      </div>
    </div><!-- /.modal-content -->
  </div>

</div>


<div class="modal fade" id="myModalx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
            aria-hidden="true">×
        </button>
        <h4 class="modal-title" id="myModalLabel">
          绑定微信
        </h4>
      </div>
      <div class="modal-body">
      	<div style="text-align: center;">
<img src="https://static.websiteonline.cn/website/qr/index.php?url=<?php echo urlencode(gethttp().$D_domain."/member/login.php?action=quick&from=".urlencode("../pay/wxpay/login.php?M_id=".$M_id)."&M_id=$M_id&M_pwd=".urlencode(xcode($M_pwd,"ENCODE",$M_id)))?>" width='300'>
<p>请使用微信扫描二维码</p>
<p style="font-size: 12px;color: #AAAAAA;">绑定成功后请刷新页面</p>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" 
            data-dismiss="modal">关闭
        </button>
        
      </div>
    </div><!-- /.modal-content -->
  </div>

</div>

<?php require 'foot.php';?>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/page.js"></script>
  <script src="js/yto_cityselect.js"></script>
  <script src="js/cropper.min.js"></script>
  <script src="js/cropper-set.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>
 <script type="text/javascript">
	  $(function() {
		  'use strict';
		  setTimeout(function(){
	          $("#error:parent").removeClass("hidden");
	          },200);

		  $("#address").citySelect();
		  
		  $('#birthday').datetimepicker({
			    format: 'yyyy-mm-dd',
			    startDate: '1950-01-01',
			    endDate: '2020-12-30',
			    weekStart : 1,
				todayBtn : 1,
				autoclose : 1,
				initialDate:'1985-01-01',
				todayHighlight : 1,
				startView : 4,
				minView : 2,
				fontAwesome:true,
				forceParse : 0,
				linkFormat: 'yyyy-mm-dd',
		        linkField:'birthday_hidden'
			});

	  });


function sendmobile(mailto){
	if(mailto.length==11){
		$.ajax({
    	url:"?action=sendcode&mobile="+mailto,
    	type:"get",
    	success:function (data) {
    		data=JSON.parse(data);
	    	if(data.code=="success"){
	    		$("#send_btn").attr("disabled","disabled");
	    		$("#send_btn").html("请60秒后再试");
	    		alert(data.msg);
	    	}else{
	    		alert(data.msg);
	    	}
    	}
    });
	}else{
		alert("请输入正确的手机号！")
	}
}
	</script>
	
	

</body>
</html>