<?php 
require '../conn/conn.php';
require '../conn/function.php';

if($C_memberon==0){
    box("会员中心未开放","../","error");
}

$from = $_GET["from"];
$action = $_GET["action"];
$genkey=gen_key(20);

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);

if($from==""){
	$from="index.php";
}

if($action=="sendcode"){
    if($C_dx1==1){
    	$mobile=$_GET["mobile"];
    	if(preg_match("/^1[345678]{1}\d{9}$/",$mobile)){
    		$pwd_code=rand(10000, 99999);
    		if(getrs("select * from sl_member where M_mobile='".$mobile."'","M_login")==""){
    			mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_openid,M_from,M_mobile,M_pwdcode) values('".$mobile."','".md5($mobile)."','','head.jpg','".date('Y-m-d H:i:s')."','',".intval($_SESSION["uid"]).",'".$mobile."','".$pwd_code."')");
    		}else{
    			mysqli_query($conn,"update sl_member set M_pwdcode='".$pwd_code."' where M_mobile='".$mobile."'");
    		}
            $info=sendsms("【".$C_smssign."】您的验证码为".$pwd_code."；10分钟内有效,请尽快验证！",$mobile);
            if($info=="success"){
                die("{\"code\":\"success\",\"msg\":\"发送成功！\"}");
            }else{
                die("{\"code\":\"error\",\"msg\":\"请".$info."秒后再试！\"}");
            }
    	}else{
    		die("{\"code\":\"error\",\"msg\":\"请填写正确的手机号！\"}");
    	}
    }else{
        die("{\"code\":\"error\",\"msg\":\"管理员未开启短信功能！\"}");
    }
}

if ($action == "login") {
    $M_mobile = t($_POST["M_mobile"]);
    $M_pwd = $_POST["M_pwd"];
    $M_code = $_POST["M_code"];
    
    if((xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0)!=$_SESSION["CmsCode"] || $_POST["M_code"]=="" || $_SESSION["CmsCode"]=="") && $C_slide==1){
        box("验证码错误!".$_SESSION["CmsCode"]."|".xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0), "back", "error");
    } else {
        $sql = "Select * from sl_member where M_mobile='" . $M_mobile . "' and M_pwdcode='" . $M_pwd . "' and M_del=0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["M_login"] = $row["M_login"];
            $_SESSION["M_id"] = $row["M_id"];
            $_SESSION["M_pwd"] = $row["M_pwd"];
            $genkey=gen_key(20);
            mysqli_query($conn,"update sl_member set M_pwdcode='".$genkey."' where M_id=".$row["M_id"]);
            $_SESSION["M_pwdcode"] = $genkey;
            Header("Location:".$from);
        } else {
            box("短信验证码错误!", "back", "error");
        }
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>会员登录 - <?php echo $C_title?></title>
<meta name="renderer" content="webkit">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="generator" data-variable="" />
<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" type="image/x-icon" />
<link rel='stylesheet' type='text/css' href="css/account.css">
<link rel='stylesheet' type='text/css' href="../css/css/font-awesome.min.css">
</head>
<!--[if lte IE 8]>
<div class="text-center margin-bottom-0 bg-blue-grey-100 alert">
    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
        <span aria-hidden="true">×</span>
    </button>
    你正在使用一个 <strong>过时</strong> 的浏览器。请 <a href="http://browsehappy.com/" target="_blank">升级您的浏览器</a>，以提高您的体验。
</div>
<![endif]-->

<body class="page-register-v3 layout-full">
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle">
        <div class="panel">
            <div class="panel-body">

<div class="brand">
	<a href="../"><img class="brand-img" src="../media/<?php echo $C_logo?>"></a>
	<h2 class="brand-text font-size-20 margin-top-20">手机验证码登录</h2>
</div>

                <form method="post" class="met-form-validation" action="?action=login&from=<?php echo urlencode($from)?>">
                    <input type="hidden" name="add">
                    <div class="form-group form-material floating">
                        <input type="text" class="form-control"  name="M_mobile" id="M_mobile" />
                        <label class="floating-label">手机号码</label>
                        <button type="button" class="btn btn-primary" id="send_btn" style="float: right;background: #0099ff;color: #ffffff;border-radius: 5px;padding: 2px 5px;margin-top: -30px;border:none;" onclick="sendcode()">发送验证码</button>
                    </div>
                    
                    <div class="form-group form-material floating">
                        <input
                        type="password" class="form-control" name="M_pwd"
                        data-fv-notempty="true"
                        maxlength="100"
                        minlength="1"
                        />
                        <label class="floating-label">验证码</label>
                    </div>
                    <?php if($C_slide==1){
                        echo "<div class=\"form-group form-material floating\" style=\"position: relative;\">
                        <iframe id=\"slide\" src=\"../conn/code_1.php?name=M_code\" scrolling=\"no\" frameborder=\"0\" width=\"100%\" height=\"40\"></iframe>
                    </div>";
                    }?>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-lg margin-top-10">登录</button>
                </form>
                <p id="buttons">
                    <?php 
                    if($C_qqon==1){
                        echo "<a href=\"../qq/qqlogin.php?from=".urlencode($from)."\" style=\"width:40px;height:40px;border-radius:100%;text-align:center;background:#0099ff;color:#ffffff;display:inline-block;font-size:20px;padding-top:3px;\"><i class=\"fa fa-qq\"></i></a>";
                    }
                    if($C_wxon==1){
                        if(isMobile()){
                            echo " <a href=\"".gethttp().$D_domain."/pay/wxpay/login.php?from=".urlencode($from)."&genkey=".$genkey."_".intval($_SESSION["uid"])."\" style=\"width:40px;height:40px;border-radius:100%;text-align:center;background:#009900;color:#ffffff;display:inline-block;font-size:20px;padding-top:3px;vertical-align:top;margin-left:10px;\"><i class=\"fa fa-weixin\"></i></a>";

                        }else{
                            echo " <a href=\"javascript:qrcode();\" style=\"width:40px;height:40px;border-radius:100%;text-align:center;background:#009900;color:#ffffff;display:inline-block;font-size:20px;padding-top:3px;vertical-align:top;margin-left:10px;\"><i class=\"fa fa-weixin\"></i></a>";
                        }
                    }
                    
                    ?>
                </p>
                <div id="billImage" style="display: inline-block;margin-bottom: 10px;"></div>
                <p>已有账号? 去 <a href="login.php?from=<?php echo urlencode($from)?>">登录</a> <a href="forget.php">忘记密码？</a></p>
            </div>
        </div>

<footer class="page-copyright page-copyright-inverse">
	<p class="txt">
		<span class="beian"> <?php echo $C_beian?></a>
        </span>
	</p>
	<div class=""><?php echo $C_copyright?>
	</div>
</footer>

    </div>
</div>
<script src="js/account.js"></script>
<script src="../js/qrcode.min.js"></script>
<script type="text/javascript">

function sendcode(){

	$.ajax({
    	url:"?action=sendcode&mobile="+$("#M_mobile").val(),
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
}


function qrcode(){
    $("#buttons").hide();
    var qrcode = new QRCode('billImage', {width: 100,height: 100,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
    qrcode.makeCode("<?php echo gethttp().$D_domain."/pay/wxpay/login.php?genkey=".$genkey."_".intval($_SESSION["uid"])?>");
}
function test(){
$.post("post.php",
    {
      genkey:"<?php echo $genkey."_".intval($_SESSION["uid"])?>",
    },
    function(data){
  if(data==1){
  document.location.href='login.php?from=<?php echo urlencode($from)?>'
  }
    });
}
setInterval("test()",3000); //每3秒钟执行一次test()
document.getElementById('slide').contentWindow.location.reload(true);
</script>
</body>
</html>