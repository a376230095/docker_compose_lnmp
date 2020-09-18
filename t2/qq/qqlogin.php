<?php 
require '../conn/conn.php';
require '../conn/function.php';

if($C_memberon==0){
    box("会员中心未开放","../","error");
}

$M_id=intval($_GET["M_id"]);
$from=$_GET["from"];
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/qq",0);
$url="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$C_qqid."&redirect_uri=".gethttp().$D_domain."/qq/reg.php?from=".urlencode(urlencode($from)."|".$M_id)."&scope=add_topic,add_pic_t,get_user_info";

Header("Location: ".$url); 
?>