<?php
require '../conn/conn.php';
require '../conn/function.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);

$action=$_GET["action"];
if($action=="found"){
    $M_email=$_POST["M_email"];
    $M_code=$_POST["M_code"];
    if(xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0)!=$_SESSION["CmsCode"] || $_POST["M_code"]=="" || $_SESSION["CmsCode"]==""){
        box("验证码错误!","back","error");
    }else{
        $sql="select * from sl_member where M_email='".t($M_email)."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
            $M_pwdcode=gen_key(20);
            mysqli_query($conn,"update sl_member set M_pwdcode='".$M_pwdcode."' where M_email='".$M_email."'");
            sendmail("找回密码邮件","请点击链接重新设置密码<br><a href='http://".$D_domain."/member/setpwd.php?M_pwdcode=".$M_pwdcode."'>http://".$D_domain."/member/setpwd.php?M_pwdcode=".$M_pwdcode."</a><br>说明：重置密码后链接失效",$M_email);
            box("请查收密码找回邮件!","login.php","success");
        }else{
            box("邮箱输入错误，请重新输入!","back","error");
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>找回密码 - <?php echo $C_title?></title>
<meta name="renderer" content="webkit">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="generator" data-variable="" />
<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" type="image/x-icon" />
<link rel='stylesheet' type='text/css' href="css/account.css">
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
                	<h2 class="brand-text font-size-20 margin-top-20">找回密码</h2>
                </div>

                <form method="post" class="met-form-validation" action="?action=found">
                    <div class="form-group form-material floating">
                        <input type="text" class="form-control"  name="M_email" />
                        <label class="floating-label">邮箱/帐号</label>
                    </div>
                    
                    <div class="form-group form-material floating" style="position: relative;">
                        <iframe src="../conn/code_1.php?name=M_code" scrolling="no" frameborder="0" width="100%" height="40"></iframe>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-lg margin-top-40">找回密码</button>
                </form>

                <p>还没有账号? 去 <a href="reg.php">注册</a> </p>
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
</body>
</html>
