<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="会员中心">
  <title>会员中心 - <?php echo $C_title?></title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />

  <!-- Stylesheets -->
  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 
  <!--[if lt IE 9]>
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
  
</head>

<body class="body-index">
<?php require 'top.php';?>

		<div class="container m_top_30">
					<div class="yto-box">

						<div class="row">
					<div class="col-sm-2 hidden-xs">
			<h5 class="p_bottom_10">三级分销</h5>
		<ul class="nav nav-pills nav-stacked">
	        <li><a href="fx.php">我的邀请</a></li>
	        <li class="active"><a href="role.php">分销规则</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">

<h5>分销规则</h5>

<hr>
<p>什么是三级分销？</p>

<p>举例说明：A邀请了B，B邀请了C，C邀请了D，D购买了一件商品，则C是第一级分销，B是第二级分销，A是第三级分销。 C直接邀请了D，因此C拿最多的佣金，再往上的佣金依次递减。</p>

<p>佣金规则：第一级拿<?php echo $C_fx1?>%佣金，第二级拿<?php echo $C_fx2?>%佣金，第三级拿<?php echo $C_fx3?>%佣金。</p>

<p>由于法律法规限制，分销最多可设置3级，因此如果A还有上级，则不参与佣金分成。</p>



			</div>
		</div>
		</div>
			
		</div>

	</div>
	
<?php 
require 'foot.php';
?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	<script src="../admin/assets/js/jqPaginator.min.js" type="text/javascript"></script>
	<script>
		function loadData(num) {
            $("#PageCount").val("<?php echo $M_counts?>");
        }
function loadpage(id) {
    var myPageCount = parseInt($("#PageCount").val());
    var myPageSize = parseInt($("#PageSize").val());
    var countindex = myPageCount % myPageSize > 0 ? (myPageCount / myPageSize) + 1 : (myPageCount / myPageSize);
    $("#countindex").val(countindex);

    $.jqPaginator('#pagination', {
        totalPages: parseInt($("#countindex").val()),
        visiblePages: parseInt($("#visiblePages").val()),
        currentPage: id,
        first: '<li class="first page-item"><a href="javascript:;" class="page-link">首页</a></li>',
        prev: '<li class="prev page-item"><a href="javascript:;" class="page-link"><i class="arrow arrow2"></i>上一页</a></li>',
        next: '<li class="next page-item"><a href="javascript:;" class="page-link">下一页<i class="arrow arrow3"></i></a></li>',
        last: '<li class="last page-item"><a href="javascript:;" class="page-link">末页</a></li>',
        page: '<li class="page page-item"><a href="javascript:;" class="page-link">{{page}}</a></li>',
        onPageChange: function (num, type) {
            if (type == "change") {
                window.location="?page="+num;
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

	</script>
</body>
</html>