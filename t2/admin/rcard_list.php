<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];

$R_id=intval($_GET["R_id"]);

if($page==""){
	$page=1;
}

if($action=="del"){
	mysqli_query($conn,"update sl_rcard set R_del=1 where R_id=".$R_id);
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','删除充值卡')");
	die("success");
}

if($action=="save"){
	foreach ($_POST as $x=>$value) {
		if(splitx($x,"_",0)=="content"){
			mysqli_query($conn,"update sl_rcard set R_content='".$_POST[$x]."' where R_id=".intval(splitx($x,"_",1)));
		}
	}
	die("success");
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_rcard set R_del=1 where R_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除充值卡')");
			die("success");
		} else {
			die("删除失败");
		}

	} else {
		die("未选择要删除的内容");
	}
}


$sql="select count(R_id) as R_count from sl_rcard where R_del=0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$R_counts=$row["R_count"];

?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>充值卡列表 - 后台管理</title>

		<!--favicon -->
		<link rel="icon" href="../media/<?php echo $C_ico?>" type="image/x-icon"/>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

		<!--Icons css-->
		<link rel="stylesheet" href="assets/css/icons.css">

		<!--Style css-->
		<link rel="stylesheet" href="assets/css/style.css">

		<!--mCustomScrollbar css-->
		<link rel="stylesheet" href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css">

		<!--Sidemenu css-->
		<link rel="stylesheet" href="assets/plugins/toggle-menu/sidemenu.css">

		<!--Morris css-->
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">
		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">
		<link rel="stylesheet" href="assets/plugins/toaster/garessi-notif.css">

		<style type="text/css">
			.list-group a{text-decoration:none}
		</style>

		
	</head>

	<body class="app ">

		<div id="spinner"></div>

		<div id="app">
			<div class="main-wrapper" >
				
					<?php
					require 'nav.php';
					?>

				<div class="app-content">
					<div style="z-index: 2;position: relative;" class="pull-right">

					<a href="rcard_add.php" class="btn btn-primary " ><i class="fa fa-plus-circle"></i> 新增充值卡</a>
					<a href="rcard_out.php" class="btn btn-warning " ><i class="fa fa-plus-circle"></i> 导出充值卡</a>
					<a href="recycle.php" class="btn btn-info" ><i class="fa fa-recycle"></i> 回收站</a>
				</div>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">充值卡管理</li>
                        </ol>

						<div class="section-body ">

							<div class="row">

								
								
								<div class="col-lg-12">
									<form id="form">

									<div class="card card-primary">

										<div class="card-header">
											<h4>充值卡列表</h4>

										</div>
										<div class="card-body p-0">
											<div class="table-responsive">

												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>选择</th>
														<th>充值卡号</th>
														<th>金额</th>
														<th>使用状态</th>
														<th>生成时间</th>
														<th>使用者</th>
														<th>使用时间</th>
														
														<th>删除</th>

													</tr>

										<?php
										
											$sql="select * from sl_rcard where R_del=0 order by R_id desc limit ".(($page-1)*20).",20";

												$result = mysqli_query($conn, $sql);
												if (mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {

													if($row["R_use"]==1){
														$C_use="<span style=\"color:#ff0000;font-weight:bold;\">已使用</span>";
													}else{
														$C_use="未使用";
													}

													echo "<tr id='".$row["R_id"]."'>
													<td><input type=\"checkbox\" name=\"id[]\" value=\"".$row["R_id"]."\"></td>
													<td><textarea style=\"width:100%;min-width:180px;\" rows=\"3\" class=\"form-control\" name=\"content_".$row["R_id"]."\"/>".htmlspecialchars($row["R_content"])."</textarea></td>
													<td>".$row["R_money"]."元</td>
													<td>".$C_use."</td>
													<td>".$row["R_time"]."</td>
													<td>".getrs("select * from sl_member where M_id=".$row["R_mid"],"M_login")."</td>
													<td>".$row["R_usetime"]."</td>
													
													<td><button class='btn btn-sm btn-danger' type='button' onClick='del(".$row["R_id"].")'><i class=\"fa fa-times-circle\"></i> 删除</button></td></tr>";

												}
											}
										?>

												</table>
											</div>
										</div>
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()">删除所选</button>
									<button class="btn btn-sm btn-primary" type="button" onclick="save()">保存修改</button>
									<a href="rcard_add.php" class="btn btn-sm btn-info">新增充值卡</a>
									<a href="rcard_out.php" class="btn btn-sm btn-warning">导出充值卡</a>
									<ul class="pagination" id="pagination" style="float: right;"></ul>
									</form>
								</div>
							
								
							</div>
						</div>
						
        <input type="hidden" id="PageCount" runat="server" />
        <input type="hidden" id="PageSize" runat="server" value="20" />
        <input type="hidden" id="countindex" runat="server" value="20"/>
        <!--设置最多显示的页码数 可以手动设置 默认为7-->
        <input type="hidden" id="visiblePages" runat="server" value="7" />

					</section>
				</div>

			</div>
		</div>

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/help.js"></script>
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>
		<script src="assets/js/jqPaginator.min.js" type="text/javascript"></script>

		<script>
function loadData(num) {
            $("#PageCount").val("<?php echo $R_counts?>");
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
                window.location="rcard_list.php?page="+num;
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

function del(id){
			if (confirm("确定删除充值卡吗？")==true){
                $.ajax({
            	url:'?action=del&R_id='+id,
            	type:'post',
            	success:function (data) {
            	if(data=="success"){
            		$("#"+id).hide();
            		toastr.success('删除成功', '错误');
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });
                return true;
            }else{
                return false;
            }
}


function save(){
	$.ajax({
		url:'?action=save',
		type:'post',
		data:$("#form").serialize(),
		success:function (data) {
			if(data=="success"){
            		toastr.success('保存成功', '成功');
            	}else{
            		toastr.error(data, '错误');
            	}
		}
	});
}

function delall(){
	if (confirm("确定删除充值卡吗？")==true){
				$.ajax({
            	url:'?action=delall',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	if(data=="success"){
            		location.reload();
            	}else{
            		toastr.error(data, '错误');
            	}
            	}
            });
				return true;
}else{
	return false;
}
			}

$('input[name="selectAll"]').on("click",function(){
        if($(this).is(':checked')){
            $('input[name="id[]"]').each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $('input[name="id[]"]').each(function(){
                $(this).prop("checked",false);
            });
        }
    });


		</script>
	</body>
</html>