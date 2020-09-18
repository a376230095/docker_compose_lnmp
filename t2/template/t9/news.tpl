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
  $taginfo=" and CONCAT(\" \",N_tag,\" \") like '% ".$tag." %'";
}

$M_id=$_GET["M_id"];
if($page==""){
  $page=1;
}

if($M_id!=""){
  $M_info=" and N_mid=$M_id".$taginfo;
}else{
  $M_info=" and N_sh=1".$taginfo;
}

$sql="select * from sl_nsort where S_id=".$id;
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
    $S_sub=$row["S_sub"];
  }

if($id==0){
  $sql="select count(N_id) as N_count from sl_news where N_del=0 ".$M_ninfo."  $M_info order by N_order,N_id desc";
}else{
  if($S_sub==0){
    $sql="select count(N_id) as N_count from sl_news,sl_nsort where S_del=0 $M_info and N_del=0 ".$M_ninfo."  and N_sort=S_id and S_sub=".$id." order by N_order,N_id desc";
  }else{
    $sql="select count(N_id) as N_count from sl_news,sl_nsort where S_del=0 $M_info and N_del=0 ".$M_ninfo."  and N_sort=S_id and S_id=".$id." order by N_order,N_id desc";
  }
}

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$N_count=$row["N_count"];

$page_num=intval($N_count/12)+1;
if($N_count%12 ==0){
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
    <link rel="stylesheet" href="template/t9/css/find.css">
    <link rel="stylesheet" href="template/t9/css/order.css">
    <link rel="stylesheet" href="template/t9/css/theme-color.css">
    <link href="css/Pager.css" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="zyw-header">
    <div class="zyw-container white-color">
        <div class="head-l"><a href="javascript:window.history.back(-1)" target="_self"><img src="template/t9/img/svg/head-return.svg" alt=""></a></div>
        <h1>[S_title]</h1>
        <div class="head-r"></div>
    </div>
</header>
<footer class="zyw-footer">
    <div class="zyw-container white-bgcolor clearfix">
        <div class="weui-tabbar">
            <a href="./" class="weui-tabbar__item ">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab1.png" alt="">
                </div>
                <p class="weui-tabbar__label">首页</p>
            </a>
            <a href="?type=product&id=0" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab2.png" alt="">
                </div>
                <p class="weui-tabbar__label">商品</p>
            </a>
            <a href="?type=news&id=0" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab3_2.png" alt="">
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
    <div class="weui-tab">
        <div class="find-cart">
        <div class="swiper-wrapper">
<div class="swiper-slide"><a class="cart-tab <fh-function>
if($id==0){
    $api=$api."active";
}else{
    $api=$api."";
}
</fh-function>" href="?type=news&id=0">全部</a></div>
            <fh-function>
$sql="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
                s[[
if($id==$row["S_id"]){
    $active="active";
}else{
    $active="";
}

                  $api=$api."<div class=\"swiper-slide\"><a class=\"cart-tab ".$active."\" href=\"?type=news&id=".$row["S_id"]."\">".$row["S_title"]."</a></div>";

                ]]
            </fh-function>

        </div>
    </div>


        <div class="weui-tab__bd">
<div id="order_all" class="weui-tab__bd-item weui-tab__bd-item--active">
                <div class="order-group">
<fh-function>

if($id==0){
  $sql="select * from sl_news where N_del=0 ".$M_ninfo."  $M_info order by N_top desc,N_order,N_id desc limit ".(($page-1)*12).",12";
}else{
  if($S_sub==0){
    $sql="select * from sl_news,sl_nsort where S_del=0 $M_info and N_del=0 ".$M_ninfo."  and N_sort=S_id and S_sub=".$id." order by N_top desc,N_order,N_id desc limit ".(($page-1)*12).",12";
  }else{
    $sql="select * from sl_news,sl_nsort where S_del=0 $M_info and N_del=0 ".$M_ninfo."  and N_sort=S_id and S_id=".$id." order by N_top desc,N_order,N_id desc limit ".(($page-1)*12).",12";
  }
}
                s[[

$api=$api."<div class=\"order-group-item clearfix\">
                        <div class=\"order-item-box\">
                            <a href=\"?type=newsinfo&id=".$row["N_id"]."\" class=\"pull-left\">
                            <div class=\"media\">
                                <div  class=\"pull-left\">
                                    <img src=\"".pic($row["N_pic"])."\" style=\"width:100px;\">
                                </div>

                                <div class=\"media-body\">
                                    <div class=\"order-item-info\">
                                        <h5 class=\"order-item-title\">".$row["N_title"]."</h5>
                                        <p class=\"order-item-fare\" style=\"color:#956bff\">售价：".p($row["N_price"])."元</p>
                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>";

                ]]

            </fh-function>
</div>
    </div>


    <div id="pager"></div>

        </div>
    </div>
</section>
<script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.min.js"></script>
<script src="template/t9/js/bootstrap.min.js"></script>
<script src="template/t9/js/swiper.min.js"></script>
<script>
    $(document).ready(function () {
        // 顶部分类滑动
        var swiper = new Swiper('.find-cart', {
            slidesPerView: 'auto',
            // centeredSlides: true,
            spaceBetween: 0,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
        // 顶部轮播图
        var mySwiper = new Swiper('.find-slider', {
            // 如果需要分页器
            autoplay: true,
            pagination: {
                el: '.swiper-pagination'
            }
        });
    })
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