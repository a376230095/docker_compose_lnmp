<?php
$first=json_decode(file_get_contents("conn/config.json"))->first;

if($first=="1"){
    Header("Location: install");
    die();
}

require 'conn/conn.php';
require 'conn/function.php';

$type=$_GET["type"];
$id=intval($_GET["id"]);
$s=$_GET["s"];

if($s!=""){
  if(substr($s,0,1)=="p"){
    $type="productinfo";
  }
  if(substr($s,0,1)=="n"){
    $type="newsinfo";
  }
  $id=intval(substr($s,1));
}

if($type==""){
	$type="index";
}

if(isMobile()){
  $t=$C_wap;
}else{
  $t=$C_template;
}

switch($type){
  case "index":
  $html=tpl("template/".$t."/index.tpl");
  break;

  case "text":
  if(getrs("select * from sl_text where T_id=$id and T_del=0","T_id")==""){
    box("该单页已删除！","back","error");
  }else{
    $html=text(tpl("template/".$t."/text.tpl"));
  }
  break;

  case "news":
  if(getrs("select * from sl_nsort where S_id=$id and S_del=0","S_id")=="" && $id!=0){
    box("该新闻分类已删除！","back","error");
  }else{
    $html=news(tpl("template/".$t."/news.tpl"));
  }
  break;

  case "newsinfo":
  if(getrs("select * from sl_news where N_id=$id and N_del=0","N_id")==""){
    box("该新闻已删除！","back","error");
  }else{
    if(getrs("select * from sl_news where N_id=$id and N_sh=1","N_id")==""){
      box("该新闻尚未通过审核，请稍候再试","back","error");
    }else{
      $html=newsinfo(tpl("template/".$t."/newsinfo.tpl"));
    }
  }
  break;

  case "product":

  if(getrs("select * from sl_psort where S_id=$id and S_del=0","S_id")=="" && $id!=0){
    box("该产品分类已删除！","back","error");
  }else{
    $html=product(tpl("template/".$t."/product.tpl"));
  }
  break;

  case "productinfo":
  if(getrs("select * from sl_product where P_id=$id and P_del=0","P_id")==""){
    box("该商品已删除！","back","error");
  }else{
    if(getrs("select * from sl_product where P_id=$id and P_sh=1","P_id")==""){
      box("该商品尚未通过审核，请稍候再试","back","error");
    }else{
      $html=productinfo(tpl("template/".$t."/productinfo.tpl"));
    }
  }
  break;

  case "query":
  Header("Location: ./member/query.php");
  die();
  break;

  case "member":
  Header("Location: ./member");
  die();
  break;

  case "seller":
  Header("Location: ./member/seller.php");
  die();
  break;

  case "login":
  Header("Location: ./member/login.php");
  die();
  break;

  case "reg":
  Header("Location: ./member/reg.php");
  die();
  break;

  case "search":
  $html=tpl("template/".$t."/search.tpl");
  break;

  case "contact":
  Header("Location: ./?type=text&id=".getrs("select * from sl_text where T_type=1 and T_del=0","T_id"));
  die();
  break;

  case "guestbook":
  Header("Location: ./?type=text&id=".getrs("select * from sl_text where T_type=2 and T_del=0","T_id"));
  die();
  break;

  default:
  die("type参数传入有误，请检查");
}

$html=d($html);

if($C_html==1){
	$html=html($html);
}
$html=str_replace("?type=index&id=1","./",$html);
$html=str_replace("?type=index&id=0","./",$html);
die($html);
?>