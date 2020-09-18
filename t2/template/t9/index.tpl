
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<title>[fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[fh_description]" />
<meta name="keywords" content="[fh_keyword]" />
<meta name="author" content="powered by fahuo100.cn" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.2/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.0/css/jquery-weui.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/t9/css/font-awesome.min.css">
    <link rel="stylesheet" href="template/t9/css/swiper.min.css">
    <link rel="stylesheet" href="template/t9/css/main.css">
    <link rel="stylesheet" href="template/t9/css/index.css">
    <link rel="stylesheet" href="template/t9/css/theme-color.css">

    <link rel="stylesheet" href="template/t9/css/find.css">
    <link rel="stylesheet" href="template/t9/css/order.css">


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="zyw-header">
    <div class="zyw-container white-color">
        <div class="head-l"><i class="head-l-svg" aria-hidden="true"></i></div>
        <form  name="formsearch" action="?type=search" method="post" class="head-search">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" placeholder="输入您当前要搜索的商品" name="keyword" class="white-color">
        </form>
        <div class="head-r"><a href="member/cart.php"><i class="head-r-svg" aria-hidden="true"></i></a></div>
    </div>
</header>
<footer class="zyw-footer">
    <div class="zyw-container white-bgcolor clearfix">
        <div class="weui-tabbar">
            <a href="./" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab1_2.png" alt="">
                </div>
                <p class="weui-tabbar__label">首页</p>
            </a>
            <a href="?type=product&id=0" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/tab2.png" alt="">
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

    <div class="swiper-container">
        <div class="swiper-wrapper">

            <fh-function>
if(getrs("select count(S_id) as S_count from sl_slide where S_del=0 and S_mid=$fmid","S_count")>0 && $fmid>0){
    $sql="select * from sl_slide where S_del=0 and S_mid=$fmid order by S_order,S_id desc";
}else{
    $sql="select * from sl_slide where S_del=0 and S_mid=0 order by S_order,S_id desc";
}
                s[[
                
$api=$api."<div class=\"swiper-slide\"><a href=\"".$row["S_link"]."\"><img src=\"".pic($row["S_pic"])."\" alt=\"\"></a></div>";
                    ]]

        </fh-function>

        </div>
        <!-- 如果需要分页器 -->
        <div class="swiper-pagination"></div>
    </div>

    <div class="weui-tab">
        <div class="find-cart">
        <div class="swiper-wrapper">
<div class="swiper-slide"><a class="cart-tab active" href="?type=news&id=0">全部</a></div>
            <fh-function>
$sql="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
                s[[

                  $api=$api."<div class=\"swiper-slide\"><a class=\"cart-tab\" href=\"?type=news&id=".$row["S_id"]."\">".$row["S_title"]."</a></div>";

                ]]
            </fh-function>

        </div>
    </div>


        <div class="weui-tab__bd">
<div id="order_all" class="weui-tab__bd-item weui-tab__bd-item--active">
                <div class="order-group">
<fh-function>
  $sql="select * from sl_news where N_del=0 ".$M_ninfo."  order by N_top desc,N_order,N_id desc limit 12";
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
<script src="template/t9/js/swiper.min.js"></script>
<script src="template/t9/js/bootstrap.min.js"></script>
<script type="text/javascript">
    // 轮播
    $(document).ready(function () {
        // 顶部轮播图
        var mySwiper = new Swiper ('.swiper-container', {
            // 如果需要分页器
            autoplay:true,
            pagination: {
                el: '.swiper-pagination'
            }
        });
        // 秒杀商品滑动
        var swiper = new Swiper('.seckill-wares', {
            slidesPerView: 3.5,
            spaceBetween: 5,
            freeMode: true
        });
        // 新闻资讯
        var swiper2 = new Swiper('.infoBox', {
            autoplay:true,
            delay: 5000,
            direction: 'vertical'
        });
    })
    $(".scms-pic").attr("style","float: none;display:inline-block;vertical-align:top;");
</script>

</body>
</html>