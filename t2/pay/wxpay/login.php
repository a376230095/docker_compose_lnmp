<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

if($C_memberon==0){
    box("会员中心未开放","../../","error");
}

$M_id = intval($_GET["M_id"]);
$from = $_GET["from"];
$genkey = $_GET["genkey"];

$_SESSION["uid"]=intval(splitx($genkey,"_",1));
$Code = $_GET["code"];
if ($Code == "") {
    Header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $C_wx_appid . "&redirect_uri=" . URLEncode(gethttp() . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . "?genkey=" . $genkey."&from=".urlencode($from)."&uid=".$uid."&M_id=".$M_id) . "&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
} else {
    $C_config = getbody("https://api.weixin.qq.com/sns/oauth2/access_token", "appid=" . $C_wx_appid . "&secret=" . $C_wx_appsecret . "&code=" . $_GET["code"] . "&grant_type=authorization_code");

    $openid = json_decode($C_config)->openid;
    $access_token = json_decode($C_config)->access_token;
}
$C_config = getbody("https://api.weixin.qq.com/sns/userinfo", "access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN");
$nickname = json_decode($C_config)->nickname;
$headimgurl = json_decode($C_config)->headimgurl;
$country = json_decode($C_config)->country;
$province = json_decode($C_config)->province;
$city = json_decode($C_config)->city;
if ($nickname == "") {
    box("授权失败，请重新登录！", "../../member/login.php", "error");
} else {
    if($M_id==0){
        $sql = "select * from sl_member where M_wxid='" . $openid . "' and M_del=0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $M_login = $row["M_login"];

            $_SESSION["M_login"] = $M_login;
            $_SESSION["M_id"] = $row["M_id"];
            $_SESSION["M_pwd"] = $row["M_pwd"];

            //$genkey=gen_key(20);
            //mysqli_query($conn,"update sl_member set M_pwdcode='".$genkey."' where M_id=".$row["M_id"]);
            $_SESSION["M_pwdcode"] = $genkey;

            mysqli_query($conn, "update sl_member set M_pwdcode='" . $genkey . "' where M_wxid='" . $openid . "'");
            box("欢迎回来！$M_login", "../../member/login.php?from=".urlencode($from) , "success");
        } else {
            $pic=downpic("../../media/",$headimgurl);
            mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_wxid,M_openid,M_pwdcode,M_from) values('W_$nickname','".md5($openid)."','未设置邮箱@qq.com','$pic','".date('Y-m-d H:i:s')."','$openid','','$genkey',".intval($_SESSION["uid"]).")");

            $_SESSION["M_login"] = "W_".$nickname;
            $_SESSION["M_pwd"] = md5($openid);

            $sql = "select * from sl_member where M_wxid='$openid' order by M_id desc limit 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                $_SESSION["M_id"] = $row["M_id"];
                //$genkey=gen_key(20);
                //mysqli_query($conn,"update sl_member set M_pwdcode='".$genkey."' where M_id=".$row["M_id"]);
                $_SESSION["M_pwdcode"] = $genkey;
            }
            
            box("登录成功！W_$nickname", "../../member/login.php?from=".urlencode($from) , "success");
        }
    }else{
        if(getrs("select * from sl_member where M_wxid='$openid'","M_login")!=""){
            die("<script>alert(\"该微信号已绑定帐号：".getrs("select * from sl_member where M_wxid='$openid'","M_login")."，请先解绑！\");window.location.href=\"../../member/login.php?from=edit.php\"</script>");
        }else{
            mysqli_query($conn, "update sl_member set M_wxid='$openid' where M_id=".$_SESSION["M_id"]);
            die("<script>alert(\"绑定成功！\");window.location.href=\"../../member/login.php?from=edit.php\"</script>");
        }
    }
}
?>