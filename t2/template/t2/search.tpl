<fh-function>
$keyword=t($_REQUEST["keyword"]);
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
<title>搜索<fh-function> $api=$api.$keyword;</fh-function> -[fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="keywords" content="[fh_keyword]" />
<meta name="description" content="[fh_description]">

<style>
.search_pic{padding:5px;border:#CCCCCC solid 1px;width:100%;max-width:150px;min-width:100px;}
table{width: 100%;}
.search_area{}
.search_area .list{padding: 10px;}
.search_area td{padding: 10px;font-size: 13px;line-height: 20px;}
</style>

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



<span style='color:#ccc;padding:0 5px;'>/</span><a href=''>搜索“<fh-function> $api=$api.$keyword;</fh-function>”</a>
     

    </div>
    <div class="m-lg text-center">
     <div class="p-sm">
      <h3 class="bold text-black" style="">搜索“<fh-function> $api=$api.$keyword;</fh-function>”</h3>
     </div>
     
    </div>
    <!-- 正文 -->
    <div class="m-lg" style="color: #111111; text-align: left; font-size: 16px; line-height: 2em; overflow: hidden;">

<div class="news_content search_area" >
<fh-function>
if($keyword==""){
  $api=$api."请输入要查询的关键词！";
}else{
//搜索单页
$sql="select * from sl_text where T_del=0 and (T_title like '%".$keyword."%' or T_content like '%".$keyword."%' ) order by T_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='?type=text&id=".$row["T_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",$row["T_title"])."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><a href='?type=text&id=".$row["T_id"]."' target='_blank'><img src='".pic($row["T_pic"])."' class='search_pic'></a></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags($row["T_content"]),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"]."?type=text&id=".$row["T_id"]."</font><br> <font color='#777777'>位置：<a href='./'>".$C_title."</a> - <a href='?type=text&id=".$row["T_id"]."'>".$row["T_title"]."</a></font></td></tr></table></div>";

        }
$search1=1;
}else{
$search1=0;
    }


//搜索新闻分类
$sql="select * from sl_nsort where S_del=0 and (S_title like '%".$keyword."%' or S_content like '%".$keyword."%' ) order by S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='?type=news&id=".$row["S_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",$row["S_title"])."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><a href='?type=news&id=".$row["S_id"]."' target='_blank'><img src='".pic($row["S_pic"])."' class='search_pic'></a></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags($row["S_content"]),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"]."?type=news&id=".$row["S_id"]."</font><br> <font color='#777777'>位置：<a href='./'>".$C_title."</a> - <a href='?type=news&id=".$row["S_id"]."'>".$row["S_title"]."</a></font></td></tr></table></div>";

        }
$search2=1;
}else{
$search2=0;
    }


//搜索新闻
$sql="select * from sl_news,sl_nsort where N_sort=S_id and N_del=0 ".$M_ninfo."  and (N_title like '%".$keyword."%' or N_content like '%".$keyword."%' ) order by N_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='?type=newsinfo&id=".$row["N_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",$row["N_title"])."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><a href='?type=newsinfo&id=".$row["N_id"]."' target='_blank'><img src='".pic($row["N_pic"])."' class='search_pic'></a></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(splitx($row["N_content"],"[fh_free]",0)),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"]."?type=newsinfo&id=".$row["N_id"]."</font><br> <font color='#777777'>位置：<a href='./'>".$C_title."</a> - <a href='?type=news&id=".$row["S_id"]."'>".$row["S_title"]."</a> - <a href='?type=newsinfo&id=".$row["N_id"]."'>".$row["N_title"]."</a></font></td></tr></table></div>";

        }
$search3=1;
}else{
$search3=0;
    }


//搜索产品分类
$sql="select * from sl_psort where S_del=0 and (S_title like '%".$keyword."%' or S_content like '%".$keyword."%' ) order by S_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='?type=product&id=".$row["S_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",$row["S_title"])."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><a href='?type=product&id=".$row["S_id"]."' target='_blank'><img src='".pic($row["S_pic"])."' class='search_pic'></a></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags($row["S_content"]),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"]."?type=product&id=".$row["S_id"]."</font><br> <font color='#777777'>位置：<a href='./'>".$C_title."</a> - <a href='?type=product&id=".$row["S_id"]."'>".$row["S_title"]."</a></font></td></tr></table></div>";

        }
$search4=1;
}else{
$search4=0;
    }

//搜索产品
$sql="select * from sl_product,sl_psort where P_sort=S_id and P_del=0 ".$M_pinfo."  and (P_title like '%".$keyword."%' or P_content like '%".$keyword."%' ) order by P_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='?type=productinfo&id=".$row["P_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",$row["P_title"])."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><a href='?type=productinfo&id=".$row["P_id"]."' target='_blank'><img src='".pic(splitx($row["P_pic"],"|",0))."' class='search_pic'></a></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags($row["P_content"]),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"]."?type=productinfo&id=".$row["P_id"]."</font><br> <font color='#777777'>位置：<a href='./'>".$C_title."</a> - <a href='?type=product&id=".$row["S_id"]."'>".$row["S_title"]."</a> - <a href='?type=productinfo&id=".$row["P_id"]."'>".$row["P_title"]."</a></font></td></tr></table></div>";

        }
$search5=1;
}else{
$search5=0;
    }

$api=$api.$search_info;

if($search1+$search2+$search3+$search4+$search5==0){
  $api=$api."未找到“".$keyword."”的相关内容，请尝试其他关键词";
}
}

      </fh-function>
</div>


</div>
    <!-- 分页条 -->
    



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