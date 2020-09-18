<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$page=$_GET["page"];
if($page==""){
	$page=1;
}


$sql="select count(L_id) as L_count from sl_list where L_del=0 and L_mid=$M_id order by L_id desc";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$L_counts=$row["L_count"];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="资金明细">
  <title>资金明细 - <?php echo $C_title?></title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />

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
						<h5>资金明细</h5>
						
						<div class="panel panel-default">
							<div class="panel-heading">资金明细</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>

														<th>名称</th>
														<th>金额</th>
														<th>编号</th>
														<th>时间</th>
														<th>审核</th>
									</tr>
									</thead>
									<tbody>
									<?php

		$sql="select * from sl_list where L_del=0 and L_mid=$M_id order by L_id desc limit ".(($page-1)*10).",10";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($row["L_money"]>0){
				$f="+";
			}else{
				$f="";
			}

			switch($row["L_sh"]){
				case 0:
				$sh="<span style=\"color:#ff9900\">未审核</span>";
				break;
				case 1:
				$sh="<span style=\"color:#009900\">已通过</span>";
				break;
				case 2:
				$sh="<span style=\"color:#ff0000\">未通过</span>";
				break;
			}

		echo "<tr id='".$row["L_id"]."'><td>".$row["L_title"]."</td><td>".$f.$row["L_money"]."</td><td>".$row["L_no"]."</td><td>".$row["L_time"]."</td><td>$sh</td></tr>";
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
            $("#PageCount").val("<?php echo $L_counts?>");
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