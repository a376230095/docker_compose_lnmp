<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$page=$_GET["page"];
if($page==""){
	$page=1;
}

if($_GET["uid"]==""){
	$uid=intval($M_id);
	$ulogin="我";
}else{
	$uid=intval($_GET["uid"]);
	$ulogin=getrs("select * from sl_member where M_id=".$uid,"M_login");
}

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);

$sql="select count(M_id) as M_count from sl_member where M_del=0 and M_from=".$uid;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_counts=$row["M_count"];

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
	        <li class="active"><a href="fx.php">我的邀请</a></li>
	        <li><a href="role.php">分销规则</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">


						<h5>我的邀请</h5>
						<div class="visible-xs">我的邀请链接：<a href="javascript:;" data-toggle="modal" data-target="#myModal5" class="btn btn-info btn-xs">二维码</a><br><?php echo gethttp().$D_domain."?uid=".$M_id?> </div>
						<div style="float: right;margin-top: -30px;" class="hidden-xs">我的邀请链接：<?php echo gethttp().$D_domain."?uid=".$M_id?> <a href="javascript:;" data-toggle="modal" data-target="#myModal5" class="btn btn-info btn-xs">二维码</a></div>
						
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo $ulogin?>的下级
								<div style="float: right;">我的上级：<?php
								if($M_from==0){
									echo "无（最顶级）";
								}else{
									echo getrs("select * from sl_member where M_id=".$M_from,"M_login");
								}
								?></div>
							</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="10%">头像</th>
										<th width="40%">名称</th>
										<th width="10%">邮箱</th>
										<th width="20%">VIP</th>
										<th width="10%">余额</th>
										<th width="10%">查看下级</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_member where M_del=0 and M_from=$uid order by M_id desc limit ".(($page-1)*10).",10";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								
								if($row["M_viplong"]-(time()-strtotime($row["M_viptime"]))/86400>0){
									$vip="VIP会员";
									
								}else{
									$vip="普通会员";
								}


							        echo "<tr>
							        <td><img src=\"../media/".$row["M_head"]."\" height=\"50\" width=\"50\"></td>
							        <td>".$row["M_login"]."</td>
							        <td>".$row["M_email"]."</td>
							        <td>".$vip."</td>
							        <td>".$row["M_money"]."元</td>
							        <td><a href=\"?uid=".$row["M_id"]."\" class=\"btn btn-xs btn-primary\">查看下级</a></td>
							        </tr>";
							    }
							} 
									?>

									</tbody>
								</table>


					</div>
				</div>

				<ul class="pagination" id="pagination" style="display: block;"></ul>
		<input type="hidden" id="PageCount" runat="server" />
        <input type="hidden" id="PageSize" runat="server" value="10" />
        <input type="hidden" id="countindex" runat="server" value="10"/>
        <!--设置最多显示的页码数 可以手动设置 默认为7-->
        <input type="hidden" id="visiblePages" runat="server" value="7" />

			</div>
		</div>
		</div>
			
		</div>

	</div>
	

<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
            aria-hidden="true">×
        </button>
        <h4 class="modal-title" id="myModalLabel">
          邀请二维码
        </h4>
      </div>
      <div class="modal-body" style="text-align: center;">
<img src="https://static.websiteonline.cn/website/qr/index.php?url=<?php echo gethttp().$D_domain."?uid=".$M_id?>"><br>
<?php echo gethttp().$D_domain."?uid=".$M_id?>
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