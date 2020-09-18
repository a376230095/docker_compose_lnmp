<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);
$C_id=intval($_GET["C_id"]);

if($page==""){
	$page=1;
}

if($action=="del"){
	mysqli_query($conn,"update sl_card set C_del=1 where C_id=".$C_id);
	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','删除卡密')");
	die("success");
}

if($action=="save"){
	foreach ($_POST as $x=>$value) {
		if(splitx($x,"_",0)=="content"){
			mysqli_query($conn,"update sl_card set C_content='".$_POST[$x]."' where C_id=".intval(splitx($x,"_",1)));
		}
		if(splitx($x,"_",0)=="sort"){
			mysqli_query($conn,"update sl_card set C_sort=".$_POST[$x]." where C_id=".intval(splitx($x,"_",1)));
		}
	}
	die("success");
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_card set C_del=1 where C_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除卡密')");
			die("success");
		} else {
			die("删除失败");
		}

	} else {
		die("未选择要删除的内容");
	}
}

if($action=="dels"){
	mysqli_query($conn,"update sl_csort set S_del=1 where S_id=".$S_id);
	mysqli_query($conn,"update sl_card set C_del=1 where C_sort=".$S_id);
	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','删除卡密分类')");
	die("success");
}

if($S_id==0){
	$S_title="";
	$sql="select count(C_id) as C_count from sl_card,sl_csort where C_sort=S_id and C_del=0";
}else{
	$S_title=getrs("select * from sl_csort where S_id=".$S_id,"S_title")." - ";
	$sql="select count(C_id) as C_count from sl_card,sl_csort where C_sort=S_id and C_del=0 and C_sort=".$S_id;
}
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$C_counts=$row["C_count"];

$C_all=getrs("select count(C_id) as C_count from sl_card where C_del=0","C_count");
$C_all2=getrs("select count(C_id) as C_count from sl_card where C_use=0 and C_del=0","C_count");
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>卡密列表 - 后台管理</title>

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
						<a href="card_add.php" class="btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i> 新增卡密</a>
						<a href="csort_add.php" class="btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i> 新增卡密分类</a>
						<a href="recycle.php" class="btn btn-info btn-sm" ><i class="fa fa-recycle"></i> 回收站</a>
					</div>
					<form class="input-group pull-right" style="width: 300px;z-index: 2;position: relative;margin-right: 5px;" method="post" action="?action=search">
	                    <input type="text" class="form-control input-sm" name="keyword" value="<?php echo t($_POST["keyword"])?>" placeholder="搜索卡密">
	                    <span class="input-group-btn">
	                        <button class="btn btn-info btn-sm" type="form"><i class="fa fa-search"></i> 搜索</button>
	                    </span>
	                </form>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="card_list.php">卡密管理</a></li>
                            <li class="breadcrumb-item"><a href="csort_add.php">卡密分类</a></li>
                            <li class="breadcrumb-item"><a href="card_out.php">导出卡密</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">

							<div class="row">

								<div class="col-lg-4">

									<div class="card card-primary">

										<div class="card-header">
											<h4>卡密分类 [未发放/全部]</h4>
											
										</div>
										
										<ul class="list-group">
											<a href="?S_id=0" class="list-group-item <?php if($S_id==0){echo "active";}?>"><b>所有卡密 [<?php echo $C_all2?>/<?php echo $C_all?>]</b></a>
											<?php 
												$sql="select * from sl_csort where S_del=0 order by S_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {
															if($row["S_id"]==$S_id){
																$active="active";
															}else{
																$active="";
															}
															$C_count=getrs("select count(C_id) as C_count from sl_card where C_del=0 and C_sort=".$row["S_id"],"C_count");
															$C_count2=getrs("select count(C_id) as C_count from sl_card where C_del=0 and C_use=0 and C_sort=".$row["S_id"],"C_count");
															echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row["S_id"]."\"><a href=\"?S_id=".$row["S_id"]."\" class=\"list-group-item ".$active."\">└ ".htmlspecialchars($row["S_title"])." [".$C_count2."/".$C_count."]</a>
															<a href=\"card_add.php?S_id=".$row["S_id"]."\" style=\"position:absolute;right:130px;top:10px;z-index:999\" class=\"btn btn-sm btn-info\">补货</a>
															<a href=\"csort_add.php?S_id=".$row["S_id"]."\" style=\"position:absolute;right:70px;top:10px;z-index:999\" class=\"btn btn-sm btn-warning\">编辑</a> 
															<button style=\"position:absolute;right:10px;top:10px;z-index:999\" class=\"btn btn-sm btn-danger\" onClick=\"dels(".$row["S_id"].")\">删除</button> </div>";
														}
													}
											?>
											
										</ul>
											
									</div>

									<a href="csort_add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增卡密分类</a>
									<a href="card_out.php" class="btn btn-sm btn-info"><i class="fa fa-plus-circle"></i> 导出卡密</a>
									<p style="margin-top: 20px">说明：序列号/激活码/帐号密码等无法重复发货的虚拟商品可使用卡密模块</p>
								</div>
								
								<div class="col-lg-8">
									<form id="form">

									<div class="card card-primary">

										<div class="card-header">
											<h4>
											<?php 
											if($action=="search"){
												echo "搜索“".t($_POST["keyword"])."” - ";
											}else{
												echo htmlspecialchars($S_title);
											}
											
											?>
										卡密列表</h4>

										</div>
										<div class="card-body p-0">
											<div class="table-responsive">

												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>选择</th>
														<th>卡密内容</th>
														<th>分类</th>
														<th>已发放</th>
														<th>编辑</th>
														<th>删除</th>

													</tr>

										<?php
									if($action=="search"){
										$sql="select * from sl_card,sl_csort where C_del=0 and S_del=0 and C_sort=S_id and C_content like '%".t($_POST["keyword"])."%' order by C_id desc";
									}else{
										if($S_id==0){
											$sql="select * from sl_card,sl_csort where C_del=0 and S_del=0 and C_sort=S_id order by C_id desc limit ".(($page-1)*20).",20";
										}else{
											$sql="select * from sl_card,sl_csort where C_del=0 and S_del=0 and C_sort=S_id and S_id=".$S_id." order by C_id desc limit ".(($page-1)*20).",20";
										}
									}

												$result = mysqli_query($conn, $sql);
												if (mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {

													if($row["C_use"]==1){
														$C_use="<span style=\"color:#ff0000;font-weight:bold;\">已发放</span>";
													}else{
														$C_use="未发放";
													}
													echo "<tr id='".$row["C_id"]."'>
													<td><input type=\"checkbox\" name=\"id[]\" value=\"".$row["C_id"]."\"></td>
													<td><textarea style=\"width:100%;min-width:180px;\" rows=\"3\" class=\"form-control\" name=\"content_".$row["C_id"]."\"/>".htmlspecialchars($row["C_content"])."</textarea></td>
													<td><select name=\"sort_".$row["C_id"]."\" class=\"form-control\" style=\"width:120px;\">";
													
																		$sql3="select * from sl_csort where S_del=0 order by S_id desc";
																			$result3 = mysqli_query($conn, $sql3);
																			if (mysqli_num_rows($result3) > 0) {
																			while($row3 = mysqli_fetch_assoc($result3)) {
																				if($row["S_id"]==$row3["S_id"]){
																					$selected="selected";
																				}else{
																					$selected="";
																				}
																				echo "<option value=\"".$row3["S_id"]."\" ".$selected.">".$row3["S_title"]."</option>";
																			}
																		}
																		

													echo "</select></td>
													<td>".$C_use."</td>
													<td><a href='card_add.php?C_id=".$row["C_id"]."' class='btn btn-sm btn-info'><i class=\"fa fa-edit\"></i> 编辑</a></td>
													<td><button class='btn btn-sm btn-danger' type='button' onClick='del(".$row["C_id"].")'><i class=\"fa fa-times-circle\"></i> 删除</button></td></tr>";

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
									<a href="card_add.php" class="btn btn-sm btn-info">新增卡密</a>
									<ul class="pagination" id="pagination" style="float: right;"></ul>
									</form>
								</div>
							
								
							</div>
						</div>
<?php if($action!="search"){?>	
        <input type="hidden" id="PageCount" runat="server" />
        <input type="hidden" id="PageSize" runat="server" value="20" />
        <input type="hidden" id="countindex" runat="server" value="20"/>
        <!--设置最多显示的页码数 可以手动设置 默认为7-->
        <input type="hidden" id="visiblePages" runat="server" value="7" />
<?php }?>
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
                window.location="card_list.php?S_id="+<?php echo $S_id?>+"&page="+num;
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

function del(id){
			if (confirm("确定删除卡密吗？")==true){
                $.ajax({
            	url:'?action=del&C_id='+id,
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

function dels(id){
			if (confirm("确定删除卡密分类吗（分类下卡密也会删除）？")==true){
                $.ajax({
            	url:'?action=dels&S_id='+id,
            	type:'post',
            	success:function (data) {
            	if(data=="success"){
            		$("#s"+id).hide();
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
	if (confirm("确定删除卡密分类吗（分类下卡密也会删除）？")==true){
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