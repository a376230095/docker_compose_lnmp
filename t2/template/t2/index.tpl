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

<script src="template/t2/js/frontend.js" ></script>
<script src="template/t2/js/common.min.js"></script>
<script>
  if (isIE && ieVersion < 9 || isIE8) {
    importJS('/template/t2/v3/js/ie/html5shiv.js')
    if (!isIE6 && !isIE7) {
      importJS('/template/t2/v3/js/ie/respond.min.js')
    }
    importJS('/template/t2/v3/js/ie/excanvas.js')
  }
  if (/MSIE (6|7)\.0/.test(navigator.userAgent)) {
    importCSS('/template/t2/v3/css/bootstrap-ie6.css')
    importJS('/template/t2/v3/js/ie/bootstrap-ie6.js')
  }
  if (isIE && ieVersion < 9 || isIE8) {
    importCSS('/template/t2/v3/css/v3-site-ie.css')
  }
  if (inTouch) {
    importJS('/template/t2/v3/js/hammer.min.js')
  }
  importJS('/template/t2/v3/js/responsiveslides.js')
</script>
<style>
.wc1200{margin:0 auto;width:100%;padding-top: 20px;}
.fr{float:right;}
.mt20{/*margin-top:20px;*/}
.wc1200 .icon{background:url(template/t2/images/icon.png) no-repeat 0 0;}
.warp-pic-list li{float:left;display:inline;}
.warp-pic-list .img_wrap{display:block;font-size:0;overflow:hidden;}
.warp-pic-list .text-area{background-color:#f2f2f2;line-height:24px;}
/*全局板块*/
.row .hd{background:url(../images/hd-line_01.jpg) no-repeat 0 50px;height:55px;}
.row .hd .title{font:26px/40px "微软雅黑","Microsoft YaHei","黑体","SimHei";}
/*全局页签*/
.tab-T-3{width:66px;}
.tab-T-3 li{width:12px;height:12px;font-size:0;background-color:#dfdfdf;float:left;
margin-left:10px;cursor:pointer;display:inline;}
.tab-T-3 li.cur{background-color:#d81c1b;}
/**/
.rowE .warp-pic-list{position:relative;overflow:hidden;}
.rowE .count li{margin-right:20px;width:220px;}
.rowE .count .img_wrap{width:220px;}
.rowE .count .img_wrap img{width:220px;}
.rowE .btn{display:block;height:55px;position:absolute;top:60px;width:35px;z-index:200;cursor:pointer;}
.rowE .prev{ background-position:0 -88px;left:0;}
.rowE .prev:hover{background-position:0 -144px;}
.rowE .next{ background-position:0 -200px;right:0;}
.rowE .next:hover{background-position:0 -256px;}
.qh_title{line-height: 28px;text-align: center;display: block;font-size: 16px;}
</style>
<link rel="stylesheet" type="text/css" href="template/t2/v3/css/responsiveslides.css">
<script src="template/t2/v3/js/responsiveslides.js"></script>
<title>[fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="keywords" content="[fh_keyword]" />
<meta name="description" content="[fh_description]">
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
 <form  name="formsearch" action="?type=search" method="post">
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
s[[

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
s2[[

  if($row2["U_type"]=="link"){
    $link2=$row2["U_link"];
    $target2="_blank";
  }else{
    $link2="?type=".$row2["U_type"]."&id=".$row2["U_typeid"];
    $target2="_self";
  }

    $api=$api."<li><a href=\"".$link2."\" target=\"".$target2."\">".$row2["U_title"]."</a></li>";
  ]]
      $api=$api."
   </ul>
  </div>";
    ]]

</fh-function>

 </div>
</div>

<script type="text/javascript" src="template/t2/js/scroll.1.3.js"></script>
<script>
$(function(){
  $("#count1").dayuwscroll({
    parent_ele: '#wrapBox1',
    list_btn: '#tabT04',
    pre_btn: '#left1',
    next_btn: '#right1',
    path: 'left',
    auto: true,
    time: 3000,
    num: 5,
    gd_num: 5,
    waite_time: 1000
})
  })
</script>
<div class="container" style="margin-top: 10px;margin-bottom: 10px">
网站公告：
<marquee direction="left" style="width: calc(100% - 80px);background: #f7f7f7;vertical-align:top; " onMouseOver="this.stop()" onMouseOut="this.start()">[fh_notice]</marquee>
</div>

 <div class="container m-t-sm m-b-sm b-a b-light">
  <div class="row">
   <div class="col-md-7">
    
    <div class="rslides rslides-11 bg-light lt" id="slider1">
     <ul class="rslides-inner">

<fh-function>
if(getrs("select count(S_id) as S_count from sl_slide where S_del=0 and S_mid=$fmid","S_count")>0 && $fmid>0){
  $sql="select * from sl_slide where S_del=0 and S_mid=$fmid order by S_order,S_id desc";
}else{
  $sql="select * from sl_slide where S_del=0 and S_mid=0 order by S_order,S_id desc";
}
          s[[$api=$api."<li class=\"rslides-item\">
  <a target=\"_blank\" href=\"".$row["S_link"]."\" title=\"".$row["S_title"]."\"><img style=\"width: 100%\" src=\"".pic($row["S_pic"])."\" alt=\"".$row["S_title"]."\" title=\"".$row["S_title"]."\"> </a>
 
 <div style=\"position: absolute;z-index:999;left:0px;top:0px;width:100%;height:50px;display:block;text-align:center;background:rgba(0,0,0,0.5);color:#ffffff;padding:2px;\">
<div style=\"font-size: 17px;\">".$row["S_title"]."</div>
<div style=\"font-size: 13px;margin-top:2px;\">".$row["S_content"]."</div>
</div>
</li>";]]
</fh-function>

</ul>
    </div>
    
   </div>
   <div class="col-md-5 lh18 hidden-xs hidden-sm">
    <div>

    <ul class="list-unstyled" id="normal">

<fh-function>
 $sql="select * from sl_news,sl_nsort where N_sh=1 and S_id=N_sort and S_show=1 and S_del=0 and N_del=0 ".$M_ninfo."  order by N_date desc limit 6";
          s[[$api=$api."<li><span class=\"sort\">[<a href=\"?type=news&id=".$row["S_id"]."\">".$row["S_title"]."</a>]</span> <a title=\"".$row["N_title"]."\" target=\"_blank\" href=\"?type=newsinfo&id=".$row["N_id"]."\" style=\"\" >".$row["N_title"]."</a></li>";]]
</fh-function>
     </ul>
     <ul class="list-unstyled" id="hot">
      <fh-function>
 $sql="select * from sl_news,sl_nsort where N_sh=1 and S_id=N_sort and S_show=1 and S_del=0 and N_del=0 ".$M_ninfo."  order by N_view desc limit 5";
          s[[$api=$api."<li><span class=\"sort\">[<a href=\"?type=news&id=".$row["S_id"]."\">".$row["S_title"]."</a>]</span> <a title=\"".$row["N_title"]."\" target=\"_blank\" href=\"?type=newsinfo&id=".$row["N_id"]."\" style=\"\" >".$row["N_title"]."</a></li>";]]
</fh-function>
     </ul>
    </div>
   </div>
  </div>
 </div>
 <script>
$("#normal li:eq(0)").attr("style","font-size:20px;font-weight:bold;margin-bottom:5px;")
$("#normal li:eq(0) .sort").html("[最新]");
$("#hot li:eq(0)").attr("style","font-size:20px;font-weight:bold;margin-bottom:5px;")
$("#hot li:eq(0) .sort").html("[最热]");

 </script>


<fh-function>
$sql="select * from sl_nsort where S_sub=0 and S_show=1 and S_del=0 order by S_order,S_id desc";

s[[
        $api=$api."<div class=\"container\">
<h3>".$row["S_title"]."</h3>
<a href=\"?type=news&id=".$row["S_id"]."\" style=\"float: right;margin-top: -30px;\">查看更多</a>

  <div style=\"width: 100%;\" class=\"m-t-sm\">
   <div style=\"width: 20%; float: left; border: 2px solid #c01410\"></div>
   <div style=\"width: 80%; float: left; border: 2px solid #374b5e\"></div>
  </div>
 </div>



 <div class=\"container\">
  <div class=\"row\">
   <div class=\"col-md-4\">
      


    <div>";
$sql2="select * from sl_nsort where S_sub=".$row["S_id"]." and S_show=1 and S_del=0 order by S_order,S_id desc limit 0,1";
s2[[
  $api=$api."<h4 class=\"m-l-xs\">
       <a class=\"bold\" href=\"?type=news&id=".$row2["S_id"]."\">".$row2["S_title"]."</a>
     </h4><div class=\"row\">";


$sql3="select * from sl_news where N_sh=1 and N_sort=".$row2["S_id"]." and N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 4";
s3[[


  $api=$api." <div class=\"col-xs-6\" align=\"center\">
         <a href=\"?type=newsinfo&id=".$row3["N_id"]."\" title=\"".$row3["N_title"]."\">

         <div style=\"background-image:url(".pic($row3["N_pic"]).");background-repeat: no-repeat;background-position:center center;width:100%;height:100px;background-size: cover;\"></div>

          <p class=\"recotitle\">".$row3["N_title"]."</p> </a>
        </div>";
]]


]]

$api=$api."</div>";

$sql2="select * from sl_nsort where S_sub=".$row["S_id"]." and S_show=1 and S_del=0 order by S_order,S_id desc limit 1,1";
$result2 = mysqli_query($conn,  $sql2);
if (mysqli_num_rows($result2) > 0) {
while($row2 = mysqli_fetch_assoc($result2)) {
  $api=$api."<h4 class=\"m-l-xs\">
       <a class=\"bold\" href=\"?type=news&id=".$row2["S_id"]."\">".$row2["S_title"]."</a>
     </h4><div class=\"m-l-sm\">";


$sql3="select * from sl_news where N_sh=1 and N_sort=".$row2["S_id"]." and N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 4";
$result3 = mysqli_query($conn,  $sql3);
if (mysqli_num_rows($result3) > 0) {
while($row3 = mysqli_fetch_assoc($result3)) {


if(strpos($row3["N_content"],"[fh_free]")!==false || p($row3["N_price"])==0){
    $intro=mb_substr(strip_tags(splitx($row3["N_content"],"[fh_free]",0)),0,200,"utf-8");
  }else{
    $intro="内容加密";
  }


  $api=$api."<div class=\"m-t-md\">
         <div class=\"media-left\">
          <a href=\"?type=newsinfo&id=".$row3["N_id"]."\" title=\"".$row3["N_title"]."\">



<div style=\"background-image:url(".pic($row3["N_pic"]).");background-repeat: no-repeat;background-position:center center;      width:100px;height:75px;background-size: cover;\"></div>

           </a>
         </div>
         <div class=\"media-body\">
          <a href=\"?type=newsinfo&id=".$row3["N_id"]."\" title=\"".$row3["N_title"]."\" ><p style=\"height: 15px;overflow: hidden\"><b>".$row3["N_title"]."</b></p></a><p style=\"height: 55px;overflow: hidden\">".$intro."</p>
         </div>
        </div>";
]]

]]

      $api=$api."
     </div>
    </div>
   </div>
   <div class=\"col-md-8\">
    <div class=\"row\">
     


     <div class=\"col-md-7\">
      <div class=\"z-col-center\">";


$sql2="select * from sl_nsort where S_sub=".$row["S_id"]." and S_show=1 and S_del=0 order by S_order,S_id desc limit 2,1";
s2[[
  $api=$api."<h4 class=\"b-b b-light\">
         <a class=\"bold\" href=\"?type=news&id=".$row2["S_id"]."\">".$row2["S_title"]."</a>
       </h4>



       <ul class=\"list-unstyled\">";

$sql3="select * from sl_news where N_sh=1 and N_sort=".$row2["S_id"]." and N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 6";
$result3 = mysqli_query($conn,  $sql3);
if (mysqli_num_rows($result3) > 0) {
while($row3 = mysqli_fetch_assoc($result3)) {
$api=$api."<li><a href=\"?type=newsinfo&id=".$row3["N_id"]."\" title=\"".$row3["N_title"]."\">".$row3["N_title"]."</a>
          </li>";
]]
       
       $api=$api."</ul>
        
    <div align=\"right\">
         <a href=\"?type=news&id=".$row2["S_id"]."\" class=\"float:right\">更多>></a>
       </div>";
]]

      
$sql2="select * from sl_nsort where S_sub=".$row["S_id"]." and S_show=1 and S_del=0 order by S_order,S_id desc limit 3,1";
s2[[
  $api=$api."<h4 class=\"b-b b-light\">
         <a class=\"bold\" href=\"?type=news&id=".$row2["S_id"]."\">".$row2["S_title"]."</a>
       </h4>



       <ul class=\"list-unstyled\">";

$sql3="select * from sl_news where N_sh=1 and N_sort=".$row2["S_id"]." and N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 6";
$result3 = mysqli_query($conn,  $sql3);
if (mysqli_num_rows($result3) > 0) {
while($row3 = mysqli_fetch_assoc($result3)) {
$api=$api."<li><a href=\"?type=newsinfo&id=".$row3["N_id"]."\" title=\"".$row3["N_title"]."\">".$row3["N_title"]."</a>
          </li>";
]]
       
       $api=$api."</ul>
        
    <div align=\"right\">
         <a href=\"?type=news&id=".$row2["S_id"]."\" class=\"float:right\">更多>></a>
       </div>";
]]

$sql2="select * from sl_nsort where S_sub=".$row["S_id"]." and S_show=1 and S_del=0 order by S_order,S_id desc limit 4,1";
s2[[
  $api=$api."<h4 class=\"b-b b-light\">
         <a class=\"bold\" href=\"?type=news&id=".$row2["S_id"]."\">".$row2["S_title"]."</a>
       </h4>



       <ul class=\"list-unstyled\">";
$sql3="select * from sl_news where N_sh=1 and N_sort=".$row2["S_id"]." and N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 6";
$result3 = mysqli_query($conn,  $sql3);
if (mysqli_num_rows($result3) > 0) {
while($row3 = mysqli_fetch_assoc($result3)) {
$api=$api."<li><a href=\"?type=newsinfo&id=".$row3["N_id"]."\" title=\"".$row3["N_title"]."\">".$row3["N_title"]."</a>
          </li>";
]]
       
       $api=$api."</ul>
        
    <div align=\"right\">
         <a href=\"?type=news&id=".$row2["S_id"]."\" class=\"float:right\">更多>></a>
       </div>";
]]

       
      $api=$api."</div>
     </div>
     
     <div class=\"col-md-5\">
      <div>";


       


$sql2="select * from sl_nsort where S_sub=".$row["S_id"]." and S_show=1 and S_del=0 order by S_order,S_id desc limit 5,1";
s2[[
  $api=$api."<h4>
        
         <a class=\"bold\" href=\"?type=news&id=".$row2["S_id"]."\">".$row2["S_title"]."</a>
        
       </h4>


       <div align=\"center\">";

$sql3="select * from sl_news where N_sh=1 and N_sort=".$row2["S_id"]." and N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 3";
s3[[
$api=$api."<div class=\"thumbnail\">
           <a href=\"//?type=newsinfo&id=".$row3["N_id"]."\">


<div style=\"background-image:url(".pic($row3["N_pic"]).");background-repeat: no-repeat;background-position:center center;  width:100%;height:120px;background-size: cover;\"></div>

            </a>
           <div class=\"m-t-xs m-b-xs\">
            <a href=\"?type=newsinfo&id=".$row3["N_id"]."\">".$row3["N_title"]."</a>
           </div>
          </div>";
]]
       
       
]]

         
    

       $api=$api."</div>


       <div class=\"m-t-xs hidden-xs\" id=\"sm_tab\">

        <ul class=\"nav nav-tabs\" role=\"tablist\">
         <li role=\"presentation\" class=\"active\"><a href=\"#sm_xj_99\" aria-controls=\"sm_xj_99\" role=\"tab\" data-toggle=\"tab\">热门文章</a></li>
         <li role=\"presentation\"><a href=\"#sm_sj_99\" aria-controls=\"sm_sj_99\" role=\"tab\" data-toggle=\"tab\">最新文章</a></li>
         <li role=\"presentation\"><a href=\"#sm_bjb_99\" aria-controls=\"sm_bjb_99\" role=\"tab\" data-toggle=\"tab\">随便看看</a></li>
        </ul>


        <div class=\"tab-content m-t-sm m-l-xs\">
         <div role=\"tabpanel\" class=\"tab-pane fade in active lh18\" id=\"sm_xj_99\">
          <ul class=\"list-unstyled\">";
           
$i=1;        
$sql2="select * from sl_news,sl_nsort where N_sh=1 and S_del=0  and S_show=1 and N_del=0 ".$M_ninfo."  and S_id=N_sort and S_sub=".$row["S_id"]." order by N_view desc,N_id desc limit 5";
s2[[
  $api=$api."<li><i>".$i."</i> &nbsp;<a href=\"?type=newsinfo&id=".$row2["N_id"]."\">".$row2["N_title"]."</a></li>";
  $i=$i+1;
]]

          $api=$api."</ul>
         </div>
         <div role=\"tabpanel\" class=\"tab-pane fade lh18\" id=\"sm_sj_99\">
          <ul class=\"list-unstyled\">";
           


$i=1;        
$sql2="select * from sl_news,sl_nsort where N_sh=1 and S_del=0 and S_show=1 and N_del=0 ".$M_ninfo."  and S_id=N_sort and S_sub=".$row["S_id"]." order by N_id desc limit 5";
s2[[
  $api=$api."<li><i>".$i."</i> &nbsp;<a href=\"?type=newsinfo&id=".$row2["N_id"]."\">".$row2["N_title"]."</a></li>";
  $i=$i+1;
]]



           
          $api=$api."</ul>
         </div>
         <div role=\"tabpanel\" class=\"tab-pane fade lh18\" id=\"sm_bjb_99\">
          <ul class=\"list-unstyled\">";
           
$i=1;        
$sql2="select * from sl_news,sl_nsort where N_sh=1 and S_del=0 and S_show=1 and N_del=0 ".$M_ninfo."  and S_id=N_sort and S_sub=".$row["S_id"]." order by rand() limit 5";
s2[[
  $api=$api."<li><i>".$i."</i> &nbsp;<a href=\"?type=newsinfo&id=".$row2["N_id"]."\">".$row2["N_title"]."</a></li>";
  $i=$i+1;
]]


           $api=$api."
          </ul>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>";
]]

</fh-function>

<div class="container">
<h3>商城</h3>
<a href="?type=product" style="float: right;margin-top: -30px;">查看更多</a>

  <div style="width: 100%;" class="m-t-sm">
   <div style="width: 20%; float: left; border: 2px solid #c01410"></div>
   <div style="width: 80%; float: left; border: 2px solid #374b5e"></div>
  </div>


  <div class="wc1200 row rowE met-index-news">
      
      <div class="bd mt20" style="margin: 10px;">
        <div id="sca1" class="warp-pic-list">
          <div id="wrapBox1" class="wrapBox">
            <ul id="count1" class="count clearfix">
 <fh-function>
        $sql="select * from sl_product where P_sh=1 and P_del=0 ".$M_pinfo."  order by P_top desc,P_order,P_id desc limit 10";
        s[[$api=$api."<li>
                <a href=\"?type=productinfo&id=".$row["P_id"]."\" class=\"img_wrap\" title=\"".$row["P_title"]."\">
                  <img src=\"".pic(splitx($row["P_pic"],"|",0))."\" border=\"0\" alt=\"".$row["P_title"]."\" title=\"".$row["P_title"]."\" height=\"200\"></a>
                <span class=\"qh_title\">".$row["P_title"]."</span>
              </li>";]]
        </fh-function>
</ul>
          </div>
          <a id="right1" class="prev icon btn"></a>
          <a id="left1" class="next icon btn"></a>
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

<script>
if(window._zcms_stat)_zcms_stat("SiteID=14&Dest=http://demo.zving.com/demo/stat/dealer");
</script>

<script>$(".scms-pic").attr("style","float: none;display:inline-block;vertical-align:top;");</script></body>

</html>