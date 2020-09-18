<?php
require '../conn/conn.php';
require '../conn/function.php';

if(checkauth()){
	plug("x5","../conn/plug/");
	require "../conn/plug/x5.php";
}else{
	die("{\"msg\":\"免费版暂不支持QQ快捷登录功能\"}");
}
?>