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
<html>
<head>
    <meta charset="utf-8">
    <title>[S_title] - [fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[S_content]" />
<meta name="keywords" content="[S_keywords]" />
<meta name="author" content="powered by fahuo100.cn" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.2/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.0/css/jquery-weui.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/t9/css/font-awesome.min.css">
    <link rel="stylesheet" href="template/t9/css/main.css">
    <link rel="stylesheet" href="template/t9/css/class.css">
    <link rel="stylesheet" href="template/t9/css/theme-color.css">
    <link href="css/Pager.css" rel="stylesheet" type="text/css" />
    <style>
    .ware-des {
    margin: 0;
    line-height: 20px;
    font-size: 1rem;
    color: #bbbbbb;
    word-break: break-all;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="zyw-header">
    <div class="zyw-container white-color">
        <div class="head-l"><a href="javascript:window.history.back(-1)" target="_self"><img src="template/t9/img/svg/head-return.svg" alt=""></a></div>
        <div class="head-search">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" placeholder="输入您当前要搜索的商品" class="white-color">
        </div>
        <div class="head-r"><a href="">取消</a></div>
    </div>
</header>


<footer class="zyw-footer">
    <div class="zyw-container white-bgcolor">
        <div class="weui-tabbar">
            <a href="./" class="weui-tabbar__item ">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab1.png" alt="">
                </div>
                <p class="weui-tabbar__label">首页</p>
            </a>
            <a href="?type=product&id=0" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab2_2.png" alt="">
                </div>
                <p class="weui-tabbar__label">商品</p>
            </a>
            <a href="?type=news&id=0" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab3.png" alt="">
                </div>
                <p class="weui-tabbar__label">文章</p>
            </a>
            <a href="member" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab4.png" alt="">
                </div>
                <p class="weui-tabbar__label">我的</p>
            </a>
        </div>
    </div>
</footer>


<section class="zyw-container">
    <div class="class-cont clearfix">
        <ul id="myTab" class="nav nav-tabs nav-stacked class-hd">
<li class="
<fh-function>
if($id==0){
    $api=$api."active";
}else{
    $api=$api."";
}
</fh-function>"><a href="?type=product&id=0" >全部商品</a></li>

            <fh-function>
$sql="select * from sl_psort where S_del=0 and S_sub=0 order by S_order,S_id desc";
                s[[
if($id==$row["S_id"]){
    $active="active";
}else{
    $active="";
}

                  $api=$api."<li class=\"".$active."\"><a href=\"?type=product&id=".$row["S_id"]."\">".$row["S_title"]."</a></li>";

                ]]
            </fh-function>

        </ul>
        <div id="myTabContent" class="tab-content class-bd white-bgcolor">
<div class="tab-pane fade in active" id="nznz">
                <div class="class-bd-cont">
                    <div class="bd-box">
                        <h4 class="bd-box-title">[S_title]</h4>
                        <div class="bd-box-info">
                            <div class="row">
            <fh-function>

if($id==0){
  $sql="select * from sl_product where P_del=0 ".$M_pinfo."  $M_info order by P_top desc,P_order,P_id desc limit ".(($page-1)*10).",10";
}else{
  if($S_sub==0){
    $sql="select * from sl_product,sl_psort where S_del=0 and P_del=0 ".$M_pinfo."  $M_info and P_sort=S_id and S_sub=".$id." order by P_top desc,P_order,P_id desc limit ".(($page-1)*10).",10";
  }else{
    $sql="select * from sl_product,sl_psort where S_del=0 and P_del=0 ".$M_pinfo."  $M_info and P_sort=S_id and S_id=".$id." order by P_top desc,P_order,P_id desc limit ".(($page-1)*10).",10";
  }
}

                s[[
$api=$api."<div class=\"col-xs-6 info-item scms-pic\">
                                    <a href=\"?type=productinfo&id=".$row["P_id"]."\"><img src=\"".pic(splitx($row["P_pic"],"|",0))."\" alt=\"\"></a>
                                    <p class=\"ware-des\" >".mb_substr($row["P_title"],0,20,"utf-8")."</p>
                                    <div style=\"color:#ff0000\">￥".p($row["P_price"])."</div>
                                </div>";
                ]]
            </fh-function>

            </div>
            </div>
            </div>
            </div>
        </div>
        <div id="pager"></div>
    </div>

    

</section>
<script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.min.js"></script>
<script src="template/t9/js/bootstrap.min.js"></script>
<script>
$(".scms-pic").attr("style","float: none;display:inline-block;vertical-align:top;padding:0 10px;");
</script>
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