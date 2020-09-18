<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

if($M_type==0 || time()-strtotime($M_sellertime)>$M_sellerlong*86400){//商家到期
	Header("Location:seller.php");
	die();
}

$action=$_GET["action"];
$C_id=intval($_GET["C_id"]);
$page=$_GET["page"];
if($page==""){
	$page=1;
}


if($action=="del"){
	mysqli_query($conn,"update sl_card set C_del=1 where C_id=$C_id and C_mid=$M_id");
	die("success");
}


$sql="select count(C_id) as C_count from sl_card,sl_csort where C_del=0 and S_del=0 and C_sort=S_id and C_mid=$M_id order by C_id desc";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$C_counts=$row["C_count"];

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
			<h5 class="p_bottom_10">卡密管理</h5>
		<ul class="nav nav-pills nav-stacked">
	        <li class="active"><a href="card_sell.php">卡密列表</a></li>
	        <li><a href="card_add.php">新增卡密</a></li>
	        <li><a href="csort_list.php">卡密分类</a></li>
	        <li><a href="csort_add.php">新增分类</a></li>
	     </ul>
					</div>
					<div class="col-sm-10 b-left">
						
						
						<div class="panel panel-default">
							<div class="panel-heading">我的卡密
							<a href="card_add.php"  class="btn btn-info btn-xs">新增卡密</a>
							<a href="csort_add.php"  class="btn btn-primary btn-xs">新增分类</a>
						</div>
							<div class="table-responsive">

								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										
										<th>卡密内容</th>
										<th>分类</th>
										<th>已发放</th>
										<th>编辑</th>
										<th>删除</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_card,sl_csort where C_del=0 and S_del=0 and C_sort=S_id and C_mid=$M_id order by C_id desc limit ".(($page-1)*10).",10";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {

									if($row["C_use"]==1){
										$C_use="<span style=\"color:#ff0000;font-weight:bold;\">已发放</span>";
									}else{
										$C_use="未发放";
									}
								
							        echo "<tr id='".$row["C_id"]."'>
							        <td>".$row["C_content"]."</td>
							        <td>".$row["S_title"]."</td>
							        <td>".$C_use."</td>
							        <td><a href='card_add.php?C_id=".$row["C_id"]."' class='btn btn-xs btn-info'><i class=\"fa fa-edit\"></i> 编辑</a></td>
							        <td><button class='btn btn-xs btn-danger' type='button' onClick='del(".$row["C_id"].")'><i class=\"fa fa-times-circle\"></i> 删除</button></td>
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
	
<?php 
require 'foot.php';
?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	

			<script>
function del(id){
			if (confirm("确定删除分类吗？")==true){
                $.ajax({
            	url:'?action=del&C_id='+id,
            	type:'post',
            	success:function (data) {
            	if(data=="success"){
            		$("#"+id).hide();
            	}else{
            		alert(data);
            	}
            	}
            });
                return true;
            }else{
                return false;
            }
}
	</script>

	<script src="js/jqPaginator.min.js" type="text/javascript"></script>
	<script>
		function loadData(num) {
            $("#PageCount").val("<?php echo $C_counts?>");
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