<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$page=$_GET["page"];
if($page==""){
	$page=1;
}


$sql="select count(O_id) as O_count from sl_orders where O_del=0 and O_mid=".$M_id." and O_type=0 order by O_id desc";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$O_counts=$row["O_count"];

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
						<h5>已购商品</h5>
						
						<div class="panel panel-default">
							<div class="panel-heading">商品记录</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="10%">图片</th>
										<th width="40%">商品</th>
										<th width="10%">总价</th>
										<th width="20%">提货</th>
										<th width="10%">状态</th>
										<th width="10%">操作</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_orders where O_del=0 and O_mid=".$M_id." and O_type=0 order by O_id desc limit ".(($page-1)*10).",10";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								$O_id=$row["O_id"];

								if($row["O_state"]==0){
									$O_state="未付款";
								}
								if($row["O_state"]==1){
									$O_state="已发货";
								}
								if($row["O_state"]==2){
									$O_state="等待发货";
								}
								if($row["O_state"]>0){
									if(getrs("select * from sl_evaluate where E_mid=$M_id and E_oid=$O_id","E_id")==""){
										$b="<a href=\"evaluate.php?id=".$row["O_id"]."\" class=\"btn btn-xs btn-primary\">评价</a>";
									}else{
										$b="已评价";
									}
								}else{
									$b="<a href=\"unlogin.php?type=product&id=".$row["O_pid"]."&genkey=".$row["O_genkey"]."\" class=\"btn btn-xs btn-danger\">付款</a>";
								}

								if($row["O_wl"]!=""){
									$wl="<p>物流信息：".$row["O_wl"]."</p>";
								}else{
									$wl="";
								}
								
							        echo "<tr>
							        <td><img src=\"".pic2($row["O_pic"])."\" height=\"50\" width=\"50\"></td>
							        <td>
							        <p><b><a href=\"../?type=productinfo&id=".$row["O_pid"]."\" target=\"_blank\">".$row["O_title"]."</a></b></p>
							        <p>".$row["O_price"]."元 × ".$row["O_num"]."件</p>
							        </td>
							        
							        <td><span style=\"font-weight:bold;color:#ff0000\">".round($row["O_num"]*$row["O_price"],2)."元</span></td>
							        <td><p>".str_replace("||", "<br>", $row["O_content"])."</p>".$wl."</td>
							        <td>".$O_state."</td>
							        <td>".$b."</td>
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
	
<?php 
require 'foot.php';
?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	<script src="js/jqPaginator.min.js" type="text/javascript"></script>
	<script>
		function loadData(num) {
            $("#PageCount").val("<?php echo $O_counts?>");
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