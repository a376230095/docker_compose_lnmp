<fh-function>
$page=$_GET["page"];
$tag=t($_GET["tag"]);

$url=gethttp().$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
function url($url,$key,$value){
  $url=str_replace("&".$key."=".str_replace("%3A",":",urlencode($value)),"",$url);
  return $url;
}

if($tag==""){
  $taginfo="";
}else{
  $taginfo=" and CONCAT(\" \",P_tag,\" \") like '% ".$tag." %'";
}

$M_id=$_GET["M_id"];
if($page==""){
  $page=1;
}
if($M_id!=""){
  $M_info=" and P_mid=$M_id ".$taginfo;
}else{
  $M_info=" and P_sh=1".$taginfo;
}

$sql="select * from sl_psort where S_id=".$id;
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
    $S_sub=$row["S_sub"];
  }

if($id==0){
  $sql="select count(P_id) as P_count from sl_product where P_del=0 ".$M_pinfo."  $M_info order by P_order,P_id desc";
}else{
  if($S_sub==0){
    $sql="select count(P_id) as P_count from sl_product,sl_psort where S_del=0 $M_info and P_del=0 ".$M_pinfo."  and P_sort=S_id and S_sub=".$id." order by P_order,P_id desc";
  }else{
    $sql="select count(P_id) as P_count from sl_product,sl_psort where S_del=0 $M_info and P_del=0 ".$M_pinfo."  and P_sort=S_id and S_id=".$id." order by P_order,P_id desc";
  }
}

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$P_count=$row["P_count"];

$page_num=intval($P_count/10)+1;
if($P_count%10 ==0){
  $page_num=$page_num-1;
}

</fh-function>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="template/t2/v3/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="template/t2/v3/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="template/t2/v3/css/v3-framework.css" type="text/css">
<link rel="stylesheet" href="template/t2/v3/css/v3-common.css" type="text/css">
<link rel="stylesheet" href="template/t2/v3/css/v3-site.css" type="text/css">
<meta name="author" content="powered by fahuo100.cn" />
<link href="css/Pager.css" rel="stylesheet" type="text/css" />
<script src="template/t2/js/frontend.js"></script>
<script src="template/t2/js/common.min.js"></script>
<script>
  if (isIE && ieVersion < 9 || isIE8) {
    importJS('template/t2/v3/js/ie/html5shiv.js')
    if (!isIE6 && !isIE7) {
      importJS('template/t2/v3/js/ie/respond.min.js')
    }
    importJS('template/t2/v3/js/ie/excanvas.js')
  }
  if (/MSIE (6|7)\.0/.test(navigator.userAgent)) {
    importCSS('template/t2/v3/css/bootstrap-ie6.css')
    importJS('template/t2/v3/js/ie/bootstrap-ie6.js')
  }
  if (isIE && ieVersion < 9 || isIE8) {
    importCSS('template/t2/v3/css/v3-site-ie.css')
  }
  if (inTouch) {
    importJS('template/t2/v3/js/hammer.min.js')
  }
  importJS('template/t2/v3/js/responsiveslides.js')
</script>
<link rel="stylesheet" type="text/css" href="template/t2/v3/css/responsiveslides.css">
<script src="template/t2/v3/js/responsiveslides.js"></script>
<title>[S_title]_[fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[S_content]" />
<meta name="keywords" content="[S_keywords]" />
</head>
<body class="bg-white">
<div class="container-fluid bg-light lt b-b b-light">
 <div class="container">
  <div class="row m-t-sm m-b-sm">
   <div class="col-sm-4 hidden-xs">
    <a href="./">[fh_title]</a>
   </div>
   <div class="col-sm-8 text-right">
<fh-function>
      if($_SESSION["M_login"]==""){
        $api="<a class=\"login\" href=\"member/login.php\">登录</a> | <a class=\"login\" href=\"member/reg.php\">注册</a>";
      }else{
        $api="<a class=\"login\" href=\"member\">".$_SESSION["M_login"]."</a> | <a class=\"login\" href=\"member/login.php?action=unlogin\">退出</a>";
      }
      </fh-function>
  
   </div>
  </div>
 </div>
</div>

<div class="container">
 <div class="row m-t-sm m-b-xs">
  <div class="col-md-4 col-sm-5">
   <a href="./"><img src="media/[fh_logo]" height="90"> </a> <a class="m-t-sm btn btn-default pull-right visible-xs" onclick="$('#catalogNav').toggleClass('hidden-xs')" href="#;"><span class="fa fa-bars font14"></span></a>
  </div>
  <div class="col-md-4 col-sm-7 m-t-sm">
 <form  name="formsearch" action="./?type=search" method="post">
   <div class="search input-group">

    <input type="text" class="form-control search-query" name="keyword" placeholder="全站搜索">
    <span class="input-group-btn"> 
    <button class="btn btn-primary search-submit" type="submit"> 
    <i class="fa fa-search"></i>&nbsp;搜索
    </button>
    </span>
   </div>

</form>
  </div>
  <div class="col-md-4 m-t-md text-center hidden-xs hidden-sm">
   
    <ul class="list-inline h5 searchwords">
     <li>热词：</li>

    <fh-function>
    $key=explode(",",$H_data["C_hotwords"]);
    for($i=0;$i<count($key);$i++){
      $api=$api."<li><a href=\"./?type=search&keyword=".$key[$i]."\">".$key[$i]."</a></li>";
    }
    </fh-function>
      
    </ul>
   
  </div>
 </div>
</div>

<div id="catalogNav" class="m-t-sm container bg-light lt z-nav hidden-xs">
 <div class="row m-t-sm" id="nav">
<fh-function>
$sql="select * from sl_menu where U_del=0 and U_sub=0 and not U_type='index' order by U_order,U_id desc";
$result = mysqli_query($conn,  $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

  if($row["U_type"]=="link"){
    $link=$row["U_link"];
    $target="_blank";
  }else{
    $link="?type=".$row["U_type"]."&id=".$row["U_typeid"];
    $target="_self";
  }
    $api=$api."<div class=\"col-sm-6 col-md-3 b-r b-light z-nav-col\">
   <ul class=\"list-inline\">
     <li class=\"bold font14\"><a href=\"".$link."\" target=\"".$target."\">".$row["U_title"]." </a></li>";

$sql2="select * from sl_menu where U_del=0 and U_sub=".$row["U_id"]." order by U_order,U_id desc";
$result2 = mysqli_query($conn,  $sql2);
  if (mysqli_num_rows($result2) > 0) {
  while($row2 = mysqli_fetch_assoc($result2)) {

  if($row2["U_type"]=="link"){
    $link2=$row2["U_link"];
    $target2="_blank";
  }else{
    $link2="?type=".$row2["U_type"]."&id=".$row2["U_typeid"];
    $target2="_self";
  }

    $api=$api."<li><a href=\"".$link2."\" target=\"".$target2."\">".$row2["U_title"]."</a></li>";
  }
}
      $api=$api."
   </ul>
  </div>";
    }
} 

</fh-function>

 </div>
</div>



 <div class="container z-container">
  <div class="row">
   <!-- 导航及标题 -->
   <div class="col-md-8">
    <div class="p-sm m-t-xs text-left b-b b-light">
     <a href='./'>首页</a>
     <span style='color:#ccc;padding:0 5px;'>/</span><a href=''>[S_title]</a>
    </div>
    <!-- 列表 -->
    <div class="m-md">
     <div class="font14">
      <ul class="list-unstyled lh20">

<fh-function>
if($id==0){
  $sql="select * from sl_product where P_del=0 ".$M_pinfo."  $M_info order by P_top desc,P_order,P_id desc limit ".(($page-1)*12).",12";
}else{
  if($S_sub==0){
    $sql="select * from sl_product,sl_psort where S_del=0 $M_info and P_del=0 ".$M_pinfo."  and P_sort=S_id and S_sub=".$id." order by P_top desc,P_order,P_id desc limit ".(($page-1)*12).",12";
  }else{
    $sql="select * from sl_product,sl_psort where S_del=0 $M_info and P_del=0 ".$M_pinfo."  and P_sort=S_id and S_id=".$id." order by P_top desc,P_order,P_id desc limit ".(($page-1)*12).",12";
  }
}

    s[[
      $api=$api."<li class=\"shown scms-pic col-md-4\"> 
        <a href=\"?type=productinfo&id=".$row["P_id"]."\" title=\"".$row["P_title"]."\"> 
          <img src=\"".pic(splitx($row["P_pic"],"|",0))."\" alt=\"".$row["P_title"]."\"> 
          <p> <b>".$row["P_title"]."</b> <i>&nbsp;</i></p>
<p class=\"price\">￥".p($row["P_price"])."</p>
 </a> </li>";
                ]]
</fh-function>
<style>
.shown img{width: 100%}
.shown .price{font-weight: bold;color: #ff0000;font-size: 20px;}
</style>

         
       
      </ul>
      <div class="m-t-lg m-g-lg text-center">
       <div>
       <div id="pager"></div>
       
       </div>
      </div>
      </div>
    </div>
   </div>
   <!-- 右侧 -->
   <div class="col-md-4">
    
<div class="m-t-md p-l-md b-l b-light hidden-xs hidden-sm">
 <div class="m-t-md b-b b-light">
  <h4 class="bold">最新新闻</h4>
 </div>
 <div class="m-t-sm lh20" align="center">
  <div class="text-left" style="max-width: 300px;">
   


    <fh-function>
      $i=1;
 $sql="select * from sl_news,sl_nsort where S_id=N_sort and S_del=0 and N_del=0 ".$M_ninfo."  and N_sh=1 order by N_date desc limit 10";
          s[[$api=$api."<i>".$i."&nbsp;</i>
     <a href=\"?type=newsinfo&id=".$row["N_id"]."\" title=\"".$row["N_title"]."\">".$row["N_title"]."</a>
     <br />";
     $i=$i+1;
     ]]
</fh-function>

  </div>
 </div>
 <div class="m-t-md b-b b-light bold">
  <h4 class="bold">推荐商品</h4>
 </div>
 <div class="m-t-sm">
  <div class="row text-center m-none">
     <fh-function>
        $sql="select * from sl_product where P_del=0 ".$M_pinfo."  and P_sh=1 order by P_id desc limit 4";
        s[[$api=$api."<div class=\"col-xs-6 text-right\">
      <a href=\"?type=productinfo&id=".$row["P_id"]."\" title=\"".$row["P_title"]."\"><div style=\"background-image:url(".pic($row["P_pic"]).");background-repeat: no-repeat;background-position:center center;width:100%;height:100px;background-size: cover;\"></div><p class=\"recotitle\">".$row["P_title"]."</p> </a>
     </div>";]]
        </fh-function>

  </div>
 </div>
 <div class="m-t-md b-b b-light bold">
  <h4 class="bold">热门排行</h4>
 </div>
 <div class="m-t-sm lh20" align="center">
  <div class="text-left" style="max-width: 300px;">
   
    <fh-function>
      $i=1;
 $sql="select * from sl_news,sl_nsort where S_id=N_sort and S_del=0 and N_del=0 ".$M_ninfo."  and N_sh=1 order by N_view desc limit 10";
          s[[$api=$api."<i>".$i."&nbsp;</i>
     <a href=\"?type=newsinfo&id=".$row["N_id"]."\" title=\"".$row["N_title"]."\">".$row["N_title"]."</a>
     <br />";
     $i=$i+1;
     ]]
</fh-function>
  </div>
 </div>
</div>

   </div>
  </div>
 </div>
 <!-- 包含页尾 -->

<div class="container-fluid bg-light lt m-t-sm hidden-xs" style="border-top: 1px solid #ddd">
 <div class="container">
  <div class="row m-sm">
   <div class="col-md-3">
    <a href="./"><img src="media/[fh_logo]" height="80"> </a>
   </div>
   <div class="col-md-9 b-l b-light">
    <h4 class="darkred">友情链接</h4>
    <ul class="list-inline">
     
 <fh-function>
        $sql="select * from sl_link where L_del=0 order by L_id desc";
        s[[$api=$api."<li><a href=\"".$row["L_link"]."\" target=\"_blank\">".$row["L_title"]."</a></li>";]]
        </fh-function>
     
    </ul>
   </div>
  </div>
 </div>
</div>
<div class="container-fluid bg-light dker">
 <div class="container">
  <div class="row m-md">
   <div class="col-sm-6">[fh_copyright][fh_code]</div>
   <div class="col-sm-6 text-right hidden-xs">
   [fh_beian]
   </div>
  </div>
 </div>
</div>
<script src="template/t2/v3/js/bootstrap.min.js"></script>


<script src="template/t2/v3/js/hammer.min.js"></script>
<script src="template/t2/v3/js/scroll/smoothscroll.js"></script>
<script src="template/t2/v3/js/v3_common.js"></script>
<script src="template/t2/v3/js/v3_site.js"></script>
 <script>
		$(function() {
			$('#sp_tab a[data-toggle="tab"]').mouseenter(function(e) {
				$(e.target).click();
			});
			$('#sh_tab a[data-toggle="tab"]').mouseenter(function(e) {
				$(e.target).click();
			})
		});
	</script>

<script>
if(window._zcms_stat)_zcms_stat("SiteID=14&Dest=http://demo.zving.com/demo/stat/dealer");
</script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.pager.js" type="text/javascript"></script>
<script>
$(".scms-pic").attr("style","float: none;display:inline-block;vertical-align:top;");
$(document).ready(function() {
    $("#pager").pager({ pagenumber: <fh-function> $api=$api.$page;</fh-function>, pagecount: <fh-function> $api=$api.$page_num;</fh-function>, buttonClickCallback: PageClick });
});

PageClick = function(pageclickednumber) {
  window.location="<fh-function>$api=$api.url($url,"page",$_GET["page"]);</fh-function>&page="+pageclickednumber;
}
</script>

</body>
</html>