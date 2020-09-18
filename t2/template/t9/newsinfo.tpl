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
<html>
<head>
    <meta charset="utf-8">
<title>[N_title] - [fh_title]</title>
<link href="media/[fh_ico]" rel="shortcut icon" />
<meta name="description" content="[N_description]" />
<meta name="keywords" content="[N_keywords]" />
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
    <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.min.js"></script>
<script src="template/t9/js/bootstrap.min.js"></script>
<script src="template/t9/js/swiper.min.js"></script>
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
            文章详情
        </h1>
        <div class="head-r"><a href="?type=news&id=[S_id]"><img src="template/t9/img/svg/head-more.svg" alt=""></a></div>
    </div>
</header>

<section class="zyw-container">
    <!-- Swiper -->
    <div class="item-img">
        <div class="swiper-wrapper">

            <div class="swiper-slide"><img src="[N_pic]" ></div>

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <div class="item-details white-bgcolor clearfix">
        <h3>[N_title]</h3>
        <div class="info"> 日期：<span>[N_date]</span> 作者：<span>[N_author]</span> <span>浏览：[N_view]</span> <span id="collection_news" nid="[N_id]"></span></div>
    </div>
    
    <div class="item-precent white-bgcolor" id="item-precent" style="padding: 10px">
        
            [N_content]
        
    </div>
</section>


</body>
</html>