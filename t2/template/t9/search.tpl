<fh-function>
$keyword=t($_REQUEST["keyword"]);
</fh-function>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<title>搜索<fh-function> $api=$api.$keyword;</fh-function> -[fh_title]</title>
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
<style>
.search_pic{padding:5px;border:#CCCCCC solid 1px;width:100%;max-width:150px;min-width:100px;}
table{width: 100%;}
.search_area{}
.search_area .list{padding: 10px;}
.search_area td{padding: 10px;}
</style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="zyw-header">
    <div class="zyw-container white-color">
        <div class="head-l"><a href="./"><i class="head-l-svg" aria-hidden="true"></i></a></div>
        <form  name="formsearch" action="?type=search" method="post" class="head-search">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" placeholder="输入您当前要搜索的商品" name="keyword" class="white-color">
        </form>
        <div class="head-r"><a href="member/cart.php"><i class="head-r-svg" aria-hidden="true"></i></a></div>
    </div>
</header>

<section class="zyw-container search_area">
    <fh-function>
if($keyword==""){
  $api=$api."请输入要查询的关键词！";
}else{
//搜索单页
$sql="select * from sl_text where T_del=0 and (T_title like '%".$keyword."%' or T_content like '%".$keyword."%' ) order by T_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {

$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='?type=text&id=".$row["T_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",$row["T_title"])."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><a href='?type=text&id=".$row["T_id"]."' target='_blank'><img src='".pic($row["T_pic"])."' class='search_pic'></a></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags($row["T_content"]),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"]."/?type=text&id=".$row["T_id"]."</font><br> <font color='#777777'>位置：<a href='./'>".$C_title."</a> - <a href='?type=text&id=".$row["T_id"]."'>".$row["T_title"]."</a></font></td></tr></table></div>";

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

</body>
</html>