<?php
require '../conn/conn.php';
require '../conn/function.php';

if($C_memberon==0){
    box("会员中心未开放","../","error");
}

$from = $_GET["from"];
$action=$_GET["action"];

if($C_regon==0){
      Header("Location: mobile_login.php?from=".urlencode($from));
}

if($action=="reg"){
    $M_login=$_POST["M_login"];
    $M_pwd=$_POST["M_pwd"];
    $M_pwd2=$_POST["M_pwd2"];
    $M_email=removexss($_POST["M_email"]);
    if ($M_pwd!=$M_pwd2){
        box("两次输入密码不一致!","back","error");
    }
    if(xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0)!=$_SESSION["CmsCode"] || $_POST["M_code"]=="" || $_SESSION["CmsCode"]==""){
            box("验证码错误!".$_SESSION["CmsCode"]."|".xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0), "back", "error");
        } else {
        if ($M_login!="" && $M_pwd!="" && $M_email!=""){
            if (strpos($M_email,"@")===false){
                box("请输入一个正确格式的邮箱!","back","error");
            }else{
                $sql="select * from sl_member where M_login='".$M_login."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if (mysqli_num_rows($result) > 0) {
                    box("用户名已被占用!","back","error");
                }else{
                    $sql="Select * from sl_member Where M_email='".$M_email."'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if (mysqli_num_rows($result) > 0) {
                        box("邮箱已被占用!","back","error");
                    }else{
                        mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_pwdcode,M_openid,M_from) values('".$M_login."','".md5($M_pwd)."','".$M_email."','head.jpg','".date('Y-m-d H:i:s')."','','',".intval($_SESSION["uid"]).")");
                        box("注册成功!您可以登录了！","login.php?from=".urlencode($from),"success");
                    }
                }
            }
        }else{
            box("请填全信息!","back","error");
        }
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>注册 - <?php echo $C_title?></title>
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
	<h2 class="brand-text font-size-20 margin-top-20">会员注册</h2>
</div>

                <form method="post" class="met-form-validation" action="?action=reg&from=<?php echo urlencode($from)?>">
                <div class="form-group form-material floating">
                        <input type="text" class="form-control" name="M_login"  />
                        <label class="floating-label">登录账号</label>
                    </div>

                    <div class="form-group form-material floating">
                        <input type="email" class="form-control"  name="M_email" data-fv-notempty="true" data-fv-field="email" />
                        <label class="floating-label">电子邮箱</label>
                    </div>
                    
                    <div class="form-group form-material floating">
                        <input
                        type="password" class="form-control" name="M_pwd"
                        data-fv-notempty="true"
                        maxlength="16"
                        minlength="6"
                        />
                        <label class="floating-label">设置密码</label>
                    </div>
                    <div class="form-group form-material floating">
                        <input
                        type="password" class="form-control" name="M_pwd2"
                        data-fv-identical="true"
                        data-fv-identical-field="password"
                        />
                        <label class="floating-label">密码确认</label>
                    </div>

                    <div class="form-group form-material floating" style="position: relative;">
                        <iframe src="../conn/code_1.php?name=M_code" scrolling="no" frameborder="0" width="100%" height="40"></iframe>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg margin-top-10">注册</button>
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
                    if($C_dxon==1){
                        echo " <a href=\"mobile_login.php?from=".urlencode($from)."\" style=\"width:40px;height:40px;border-radius:100%;text-align:center;background:#ff9900;color:#ffffff;display:inline-block;font-size:25px;padding-top:-10px;vertical-align:top;margin-left:10px;\"><i class=\"fa fa-mobile\"></i></a>";
                    }
                    ?>
                </p>
                <div id="billImage" style="display: inline-block;margin-bottom: 10px;"></div>
                <p>已经有账号了? 去 <a href="login.php">登录</a></p>
            </div>
        </div>

<footer class="page-copyright page-copyright-inverse">
    <p class="txt">
        <span class="beian"> <?php echo $C_beian?></a>
        </span>
    </p>
    <div class="powered_by_metinfo"><?php echo $C_copyright?>
    </div>
</footer>

    </div>
</div>
<script src="js/account.js"></script>
<script src="../js/qrcode.min.js"></script>
<script type="text/javascript">
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
//document.getElementById('slide').contentWindow.location.reload(true);
</script>
</body>
</html>
