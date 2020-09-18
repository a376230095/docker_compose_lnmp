<fh-function>
mysqli_query($conn, "update sl_product set P_view=P_view+1 where P_id=".$id);
$sql="select * from sl_product,sl_psort where P_sort=S_id and P_id=".$id;
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
    $S_id=$row["S_id"];
    $P_id=$row["P_id"];
    $P_pic=$row["P_pic"];
    $P_tag=$row["P_tag"];
    $P_shuxing=$row["P_shuxing"];

    switch ($row["P_selltype"]) {
        case 0:
        $P_rest=1;
        break;

        case 1:

        $P_rest=getrs("select count(C_id) as C_count from sl_card where C_sort=".intval($row["P_sell"])." and C_use=0","C_count");
        break;

        case 2:
        $P_rest=$row["P_rest"];
        break;
    }
  }
</fh-function>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>[P_title] - [fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[P_description]" />
<meta name="keywords" content="[P_keywords]" />
<meta name="author" content="powered by fahuo100.cn" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.2/style/weui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.0/css/jquery-weui.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/t9/css/font-awesome.min.css">
    <link rel="stylesheet" href="template/t9/css/swiper.min.css">
    <link rel="stylesheet" href="template/t9/css/main.css">
    <link rel="stylesheet" href="template/t9/css/item.css">
    <link rel="stylesheet" href="template/t9/css/theme-color.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="zyw-header">
    <div class="zyw-container white-color">
        <div class="head-l"><a href="javascript:window.history.back(-1)" target="_self"><img src="template/t9/img/svg/head-return.svg" alt=""></a></div>
        <h1>
            <a href="#" class="active">商品</a>
            <a href="#item-precent">详情</a>

        </h1>
        <div class="head-r"><a href="?type=product&id=[S_id]"><img src="template/t9/img/svg/head-more.svg" alt=""></a></div>
    </div>
</header>
<footer class="zyw-footer">
    <div class="zyw-container white-bgcolor clearfix">
        <div class="col-sm-2 col-xs-2">
            <a href="./" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/svg/item-1.svg" alt="">
                </div>
                <p class="weui-tabbar__label">首页</p>
            </a>
        </div>
        <div class="col-sm-2 col-xs-2">
            <a href="member/cart.php" class="weui-tabbar__item">
                
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/svg/item-2.svg" alt="">
                </div>
                <p class="weui-tabbar__label">购物车</p>
            </a>
        </div>
        <div class="col-sm-2 col-xs-2">
            <a href="./?type=contact" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="template/t9/img/svg/item-3.svg" alt="">
                </div>
                <p class="weui-tabbar__label">客服</p>
            </a>
        </div>
        <style type="text/css">
        .footer-btn{border:none;}
    </style>
<form id="buy" method="post" action="buy.php?type=productinfo&id=[P_id]">
        <input type='hidden' name='no' value='1' id='amount'>

        <div class="col-sm-3 col-xs-3">
            <fh-function>
              if($P_rest==0){
                $api=$api."<button type=\"submit\" name=\"button\" class=\"footer-btn footer-warning\" disabled=\"disabled\">暂时缺货</button>";
              }else{
                $api=$api."<button type=\"submit\" name=\"button\" class=\"footer-btn footer-warning\" >立即购买</button>";
              }
              </fh-function>
        </div>

        <div class="col-sm-3 col-xs-3">

            <fh-function>
              if($P_rest==0){
                $api=$api."<button type=\"button\" name=\"button\" class=\"footer-btn footer-danger\"  disabled=\"disabled\">暂时缺货</button>";
              }else{

                $api=$api.unlogin_product("footer-btn footer-danger",$id);
              }
              </fh-function>

        </div>
    </form>
    </div>
</footer>
<section class="zyw-container">
    <!-- Swiper -->
    <div class="item-img">
        <div class="swiper-wrapper">

            <fh-function>
            $pic=explode("|",$P_pic);
            for($i=0;$i<count($pic);$i++){
              $api=$api."<div class=\"swiper-slide\"><img src=\"".pic($pic[$i])."\" alt=\"\"></div>";
            }
            </fh-function>

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <div class="item-details white-bgcolor clearfix">
        <h3 class="details-title">[P_zy][P_title]</h3>
        <strong class="details-prince theme-color pull-left">￥[P_price]</strong> <span id="collection_product" pid="[P_id]"></span>
        <span class="details-volume pull-right">已售：[B_count]件</span>
    </div>
    <div class="item-choose weui-cells mt-625">
        
        <fh-function>
            if($P_shuxing!=""){
            $api=$api."<a class=\"weui-cell weui-cell_access open-popup\" href=\"javascript:;\" data-target=\"#item_parameter\">
            <div class=\"weui-cell__bd\">
                <p class=\"choose-text\">产品参数</p>
            </div>
            <div class=\"weui-cell__ft choose-des\">
            </div>
        </a>";
        }
        
</fh-function>



        <div id="item_parameter" class="weui-popup__container popup-bottom">
            <div class="weui-popup__overlay"></div>
            <div class="weui-popup__modal">
                <div class="item-parameter-layer white-bgcolor">
                    <h3 class="parameter-title">产品参数</h3>
                    <table class="table table-condensed parameter-table">

                        <fh-function>
            if($P_shuxing!=""){
            $s=explode("\r",$P_shuxing);
            for($i=0;$i<count($s);$i++){
                $api=$api."<tr><th>".splitx($s[$i],":",0)."</th><td>".splitx($s[$i],":",1)."</td></tr>";
            }
                        }
            
                        </fh-function>
                        
                    </table>
                    <button class="item-layer-button theme-bgcolor white-color close-popup" type="submit">完成</button>
                </div>
            </div>
        </div>
    </div>
    <div class="item-serve">
        <span><i class="fa fa-check-circle-o theme-color"></i> 品质承诺</span>
        <span><i class="fa fa-check-circle-o theme-color"></i> 七天包退换</span>
        <span><i class="fa fa-check-circle-o theme-color"></i> 如实描述</span>
    </div>
    <div class="item-assess weui-cells mb-625">
        <a class="weui-cell weui-cell_access open-popup" href="javascript:;" data-target="#item_spec">
            <div class="weui-cell__bd">
                <p class="choose-text">用户评价（<em class="theme-color">[E_count]</em>条）</p>
            </div>
            <div class="weui-cell__ft choose-des">
                100%好评
            </div>
        </a>


    </div>


<div id="item_spec" class="weui-popup__container popup-bottom">
            <div class="weui-popup__overlay"></div>
            <div class="weui-popup__modal">
                <div class="item-parameter-layer white-bgcolor">
                    <h3 class="parameter-title">商品评价</h3>
                    <table class="table table-condensed parameter-table">
<fh-function>
                $sql="select * from sl_evaluate,sl_member,sl_orders where E_mid=M_id and E_oid=O_id and O_pid=$P_id order by E_id desc";
                $result = mysqli_query($conn,  $sql);
                if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $api=$api."<tr><td>
                      <img src=\"media/".$row["M_head"]."\" style=\"height:50px;\">
                    </td><td>
                      <div style=\"font-weight: bold;\">".enname($row["M_login"])."</div>
                      <div>[".$row["E_star"]."星] ".$row["E_content"]."</div>
                      <div style=\"font-size: 12px;color: #AAAAAA\">".$row["E_time"]."</div>";
                      if($row["E_reply"]!=""){
                      $api=$api."<div style=\"font-size: 12px;color: #AF874D\">商家回复：".$row["E_reply"]."</div>";
                    }
                    $api=$api."</td></tr>";
                }
              }else{
              $api=$api."<div><tr><td>暂无商品评价</td></div>";
            }
                    </fh-function>
                    </table>
                    <button class="item-layer-button theme-bgcolor white-color close-popup" type="submit">完成</button>
                </div>
            </div>
        </div>


    <div id="item_spec" class="weui-popup__container popup-bottom">
            <div class="weui-popup__overlay"></div>
            <div class="weui-popup__modal">
                <div class="item-spec-layer white-bgcolor">
                    
                    
                    <div class="spec-info clearfix">
                        <fh-function>
                $sql="select * from sl_evaluate,sl_member,sl_orders where E_mid=M_id and E_oid=O_id and O_pid=$P_id order by E_id desc";
                $result = mysqli_query($conn,  $sql);
                if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $api=$api."<li>
                    <div class=\"left\">
                      <img src=\"media/".$row["M_head"]."\">
                    </div>
                    <div class=\"right\">
                      <div style=\"font-weight: bold;\">".enname($row["M_login"])."</div>
                      <div>[".$row["E_star"]."星] ".$row["E_content"]."</div>
                      <div style=\"font-size: 12px;color: #AAAAAA\">".$row["E_time"]."</div>";
                      if($row["E_reply"]!=""){
                      $api=$api."<div style=\"font-size: 12px;color: #AF874D\">商家回复：".$row["E_reply"]."</div>";
                    }
                    $api=$api."</div>
                  </li>";
                }
              }else{
              $api=$api."<div>暂无商品评价</div>";
            }
                    </fh-function>
                    </div>
                    
                    <button class="item-layer-button theme-bgcolor white-color" type="submit">确定</button>
                    <a href="javascript:;" class="close-popup spec-close"><i class="fa fa-close"></i></a>
                </div>
            </div>
        </div>

    <div class="item-precent white-bgcolor" id="item-precent">
        <h4>图文详情</h4>
        <div style="padding: 0 10px">
            [P_content]
        </div>
    </div>
</section>
<script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.min.js"></script>
<script src="template/t9/js/bootstrap.min.js"></script>
<script src="template/t9/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.item-img', {
        autoplay:true,
        delay: 7000,
        slidesPerView: 1,
        spaceBetween: 0,
        keyboard: {
            enabled: true,
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
        },
    });
    var MAX = 10, MIN = 1;
    $('.weui-count__decrease').click(function (e) {
        var $input = $(e.currentTarget).parent().find('.weui-count__number');
        var number = parseInt($input.val() || "0") - 1
        if (number < MIN) number = MIN;
        $input.val(number)
    });
    $('.weui-count__increase').click(function (e) {
        var $input = $(e.currentTarget).parent().find('.weui-count__number');
        var number = parseInt($input.val() || "0") + 1
        if (number > MAX) number = MAX;
        $input.val(number)
    });
</script>
</body>
</html>