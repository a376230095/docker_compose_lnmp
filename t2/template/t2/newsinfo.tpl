<fh-function>
mysqli_query($conn, "update sl_news set N_view=N_view+1 where N_id=".$id);
$sql="select * from sl_news,sl_nsort where N_sort=S_id and N_id=".$id;
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
    $S_id=$row["S_id"];
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
<script src="template/t2/js/frontend.js"></script>
<script src="template/t2/js/common.min.js"></script>
<style>
.news_content img{max-width: 100% !important}
</style>
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
<title>[N_title]_[S_title]_[fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[N_description]" />
<meta name="keywords" content="[N_keywords]" />
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
 <div class="container">
  <div class="row">
   <!-- 导航及标题 -->
   <div class="col-md-8">
    <div align="left" class="p-sm m-t-xs b-b b-light">
     <a href='./'>首页</a>


<span style='color:#ccc;padding:0 5px;'>/</span><a href='?type=news&id=[S_id]'>[S_title]</a>
<span style='color:#ccc;padding:0 5px;'>/</span><a href=''>[N_title]</a>
     

    </div>
    <div class="m-lg text-center">
     <div class="p-sm">
      <h3 class="bold text-black" style="">[N_title]</h3>
      <div>[N_tag]</div>
     </div>
     <div class="m-b-sm">
      [N_date]&nbsp;&nbsp; &nbsp;&nbsp; <span class="badge">[N_view] 浏览</span>
      &nbsp;&nbsp; 作者：[N_author] <span id="collection_news" nid="[N_id]"></span>
     </div>
    </div>
    <!-- 正文 -->
    <div class="m-lg" style="color: #111111; text-align: left; font-size: 16px; line-height: 2em; overflow: hidden;">

<div class="news_content">
[N_content]
</div>


</div>
    <!-- 分页条 -->
    
    
<!-- 二维码 -->

<!-- 分享按钮 -->
<div class="m-md m-t-lg">
 <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&uuid=&pophcol=2&lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
</div>
<!-- 上一篇下一篇 -->
<div class="m-md b-t b-light text-left">
 <ul class="list-unstyled m-sm lh20 font14">
  <li><strong>上一篇</strong>：
    <a href="[N_Purl]">[N_Ptitle]</a>
    </li>
  <li><strong>下一篇</strong>：
    <a href="[N_Nurl]">[N_Ntitle]</a>
    </li>
 </ul>
</div>
<!-- 相关内容 -->

 
  <div class="m-md text-left">
   <h5 class="bold m-sm">相关内容：</h5>
   <ul class="m-md lh20 font14">
    

    <fh-function>

 $sql="select * from sl_news,sl_nsort where S_id=N_sort and S_del=0 and N_del=0 ".$M_ninfo."  and N_sh=1 and S_id=".$S_id." order by N_date desc limit 5";
          s[[$api=$api."<li><a target=\"_blank\" href=\"?type=newsinfo&id=".$row["N_id"]."\">".$row["N_title"]."</a></li>";

     ]]
</fh-function>

   </ul>
  </div>
 

<!-- 评论 -->

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
 $sql="select * from sl_news,sl_nsort where S_id=N_sort and S_del=0 and N_del=0 ".$M_ninfo."  order by N_date desc limit 10";
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
        $sql="select * from sl_product where P_del=0 ".$M_pinfo."  order by P_id desc limit 4";
        s[[$api=$api."<div class=\"col-xs-6 text-right\">
      <a href=\"?type=productinfo&id=".$row["P_id"]."\" title=\"".$row["P_title"]."\"><div style=\"background-image:url(".pic(splitx($row["P_pic"],"|",0)).");background-repeat: no-repeat;background-position:center center;width:100%;height:100px;background-size: cover;\"></div><p class=\"recotitle\">".$row["P_title"]."</p> </a>
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



</body>
</html>