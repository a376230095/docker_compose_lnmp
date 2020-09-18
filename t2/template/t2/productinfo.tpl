<fh-function>
mysqli_query($conn, "update sl_product set P_view=P_view+1 where P_id=".$id);
$sql="select * from sl_product,sl_psort where P_sort=S_id and P_id=".$id;
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {
    $S_id=$row["S_id"];
    $P_id=$row["P_id"];

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
<title>[P_title]_[S_title]_[fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[P_description]" />
<meta name="keywords" content="[P_keywords]" />

<style>
#buy .add{
  height:25px; width:25px; margin:0 5px 0 5px;line-height:100%;
  border: hidden;
  background-color: #65bd77;
  color: #FFFFFF;
  font-size: 15px;
  line-height: 100%;
  cursor: pointer;
  border-radius:3px;
}

#buy .add:hover {
  border: #65bd77 solid 1px;
  background-color: #FFFFFF;
  color: #65bd77;
}

#amount{
  border-top:1px solid #ABADB3;
  border-left:1px solid #ABADB3;
  border-right:1px solid #ddd;
  border-bottom:1px solid #ddd;
  height:24px;
  width:50px;
  padding:0 5px;
  line-height:100%;
}
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


<span style='color:#ccc;padding:0 5px;'>/</span><a href='?type=product&id=[S_id]'>[S_title]</a>
<span style='color:#ccc;padding:0 5px;'>/</span><a href=''>[P_title]</a>
     

    </div>
    <div class="m-lg">
     
     <div class="row">

        <div class="col-md-5">
          <div class='met-showproduct-list fngallery text-center slick-dotted' id="met-imgs-carousel">
            <div class='slick-slide lg-item-box' data-src="[P_pic]" data-exthumbimage='[P_pic]'> 
              <span> <img src='[P_pic]' data-src='[P_pic]' class="img-responsive" alt="[P_title]" style="width:100%;max-width: 350px;"/> </span>

            </div>
          </div>
        </div>


        <div class="col-md-7 product-intro">
          <h3>[P_title]</h3>
          <div>[P_tag]</div>
          <div class="shop-product-intro grey-500">
            <div class="padding-20 bg-grey-100 price" style="margin-bottom: 20px;"> <span id="price" class="red-600" style="font-weight: bold;font-size: 25px;color: #ff6600;">价格：￥[P_price]</span></div>
            
            <div class="form-group inline-block margin-top-30">
              <form id="buy" method="post" action="buy.php?type=productinfo&id=[P_id]">
                <p style="margin-bottom: 10px"><b>购买数量：</b>
              <input type='button' class='add' value='-' onClick='javascript:if(this.form.amount.value>=2){this.form.amount.value--;}'>
              <input type='text' name='no' value='1' id='amount'>
              <input type='button' class='add' value='+' id='plus' onClick='javascript:if(this.form.amount.value<[P_rest]){this.form.amount.value++;}'>
              （库存：[P_resttitle]）</p>
              [fh_address]
              <fh-function>
              if($P_rest==0){
                $api=$api."<input type=\"submit\" name=\"button\" class=\"btn btn-lg btn-squared btn-primary margin-right-20\" value=\"暂时缺货\"  disabled=\"disabled\"/>";
              }else{
                $api=$api."<input type=\"submit\" name=\"button\" class=\"btn btn-lg btn-squared btn-primary margin-right-20\" value=\"立即购买\" /> ";
                $api=$api.unlogin_product("btn btn-lg btn-squared btn-primary margin-right-20",$id);
              }
              </fh-function>
              </form>
              <div id="collection_product" pid="[P_id]"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- 正文 -->
    <div class="m-lg" style="color: #111111; text-align: left; font-size: 16px; line-height: 2em; overflow: hidden;">



<ul id="myTab" class="nav nav-tabs">
  <li class="active"><a href="#intro" data-toggle="tab">商品介绍</a></li>
  <li><a href="#evaluate" data-toggle="tab">用户评价</a></li>
</ul>


<div id="myTabContent" class="tab-content" style="padding-top: 30px;">
  <div class="tab-pane fade in active" id="intro">
    <div class="news_content">
[P_shuxing]    
[P_content]
</div>
  </div>
  <div class="tab-pane fade" id="evaluate" >
    

<style>
.evaluate li{border-bottom:solid 1px #EEEEEE;padding:10px 0;list-style:none;}
.evaluate li div{line-height: 150%}
.evaluate li .left{width: 100px;vertical-align: top;display: inline-block;text-align:center}
.evaluate li .left img{width:50px;height:50px;border-radius:10px;}
.evaluate li .right{vertical-align: top;display: inline-block;width:calc(100% - 120px)}

</style>
<ul class="evaluate">
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
                  </ul>

  </div>

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
  <li><strong>上一个</strong>：
    <a href="[P_Purl]">[P_Ptitle]</a>
    </li>
  <li><strong>下一个</strong>：
    <a href="[P_Nurl]">[P_Ntitle]</a>
    </li>
 </ul>
</div>
<!-- 相关内容 -->


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