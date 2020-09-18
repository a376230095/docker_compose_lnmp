<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);
$N_id=intval($_GET["N_id"]);

if($page==""){
	$page=1;
}

if($action=="del"){
	mysqli_query($conn,"update sl_news set N_del=1 where N_id=".$N_id);
	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','删除文章')");
	die("success");
}

if($action=="dels"){
	mysqli_query($conn,"update sl_nsort set S_del=1 where S_id=".$S_id." or S_sub=".$S_id);
	mysqli_query($conn,"update sl_news set N_del=1 where N_sort=".$S_id." or N_sort in (select S_id from sl_nsort where S_sub=".$S_id.")");
	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','删除文章分类')");
	die("success");
}

if($action=="save"){
	foreach ($_POST as $x=>$value) {
		if(splitx($x,"_",0)=="title"){
			mysqli_query($conn,"update sl_news set N_title='".$_POST[$x]."' where N_id=".intval(splitx($x,"_",1)));
		}
		if(splitx($x,"_",0)=="order"){
			mysqli_query($conn,"update sl_news set N_order=".$_POST[$x]." where N_id=".intval(splitx($x,"_",1)));
		}
		if(splitx($x,"_",0)=="sort"){
			mysqli_query($conn,"update sl_news set N_sort=".$_POST[$x]." where N_id=".intval(splitx($x,"_",1)));
		}
	}
	die("success");
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_news set N_del=1 where N_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除文章')");
			die("success");
		} else {
			die("删除失败");
		}

	} else {
		die("未选择要删除的内容");
	}
}

if($S_id==0){
	$S_title="";
	$sql="select count(N_id) as N_count from sl_news,sl_nsort where N_sort=S_id and N_del=0";
}else{
	$S_title=getrs("select * from sl_nsort where S_id=".$S_id,"S_title")." - ";
	$sql="select count(N_id) as N_count from sl_news,sl_nsort where N_sort=S_id and N_del=0 and (S_id=".$S_id." or S_sub=".$S_id.")";
}
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$N_counts=$row["N_count"];
$N_all=getrs("select count(N_id) as N_count from sl_news where N_del=0","N_count");
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>文章列表 - 后台管理</title>

		<!--favicon -->
		<link rel="icon" href="../media/<?php echo $C_ico?>" type="image/x-icon"/>

		<!--Bootstrap.min css-->
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

		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">

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

					<a href="recycle.php" class="btn btn-info pull-right btn-sm" style="z-index: 2;position: relative;"><i class="fa fa-recycle"></i> 回收站</a>
					<a href="nsort_add.php" class="btn btn-primary pull-right btn-sm" style="z-index: 2;position: relative;margin-right: 5px;"><i class="fa fa-plus-circle"></i> 新增文章分类</a>
					<a href="news_add.php" class="btn btn-primary pull-right btn-sm" style="z-index: 2;position: relative;margin-right: 5px;"><i class="fa fa-plus-circle"></i> 新增文章</a>
					<form class="input-group pull-right" style="width: 300px;z-index: 2;position: relative;margin-right: 5px;" method="post" action="?action=search">
	                    <input type="text" class="form-control input-sm" name="keyword" value="<?php echo t($_POST["keyword"])?>" placeholder="搜索文章">
	                    <span class="input-group-btn">
	                        <button class="btn btn-info btn-sm" type="form"><i class="fa fa-search"></i> 搜索</button>
	                    </span>
	                </form>

					<section class="section">
						<ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="news_list.php">文章管理</a></li>
                            <li class="breadcrumb-item"><a href="nsort_add.php">文章分类</a></li>
                            <li class="breadcrumb-item"><a href="excel_news.php">导入EXCEL</a></li>
                        </ol>
                        <style type="text/css">
                        .active a{font-weight: bold;color: #a2a9d4}
                    	</style>

						<div class="section-body ">

							<div class="row">

								<div class="col-lg-4">

									<div class="card card-primary">

										<div class="card-header">
											<h4>文章分类列表</h4>
											
										</div>
										
										<ul class="list-group">
											<a href="?S_id=0" class="list-group-item <?php if($S_id==0){echo "active";}?>"><b>所有文章 [<?php echo $N_all?>个]</b>
<span class="pull-right">首页展示 / 编辑 / 删除</span>
											</a>
											<?php 
													$sql="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {
															if($row["S_id"]==$S_id){
																$active="active";
															}else{
																$active="";
															}
															if($row["S_show"]==1){
																$show="<i class='fa fa-check-circle pull-right' style='margin-right:90px;'></i>";
															}else{
																$show="";
															}

															$N_count=getrs("select count(N_id) as N_count from sl_news,sl_nsort where N_sort=S_id and S_sub=".$row["S_id"]." and N_del=0","N_count");
															echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row["S_id"]."\"><a href=\"?S_id=".$row["S_id"]."\" class=\"list-group-item ".$active."\"><b>└ ".$row["S_order"].".".$row["S_title"]." [".$N_count."个] </b>".$show."</a><a href=\"nsort_add.php?S_id=".$row["S_id"]."\" style=\"position:absolute;right:55px;top:10px;z-index:999;font-size:15px\" class=\"btn btn-sm btn-info\"><i class=\"fa fa-edit\"></i></a> <button style=\"position:absolute;right:10px;top:10px;z-index:999;font-size:15px\" class=\"btn btn-sm btn-danger\" onClick=\"dels(".$row["S_id"].")\"><i class=\"fa fa-times-circle\"></i></button></div>";


															$sql2="select * from sl_nsort where S_del=0 and S_sub=".$row["S_id"]." order by S_order,S_id desc";
																$result2 = mysqli_query($conn, $sql2);
																if (mysqli_num_rows($result2) > 0) {
																while($row2 = mysqli_fetch_assoc($result2)) {
																	if($row2["S_id"]==$S_id){
																		$active2="active";
																	}else{
																		$active2="";
																	}

																	if($row2["S_show"]==1){
																		$show="<i class='fa fa-check-circle pull-right' style='margin-right:90px;'></i>";
																	}else{
																		$show="";
																	}

																	$N_count2=getrs("select count(N_id) as N_count from sl_news where N_del=0 and N_sort=".$row2["S_id"],"N_count");
																	echo "<div style=\"position:relative;border-top:solid 1px #EEEEEE;\" id=\"s".$row2["S_id"]."\"><a href=\"?S_id=".$row2["S_id"]."\" class=\"list-group-item ".$active2."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ ".$row2["S_order"].".".$row2["S_title"]." [".$N_count2."个] ".$show."</a><a href=\"nsort_add.php?S_id=".$row2["S_id"]."\" style=\"position:absolute;right:55px;top:10px;z-index:999;font-size:15px\" class=\"btn btn-sm btn-info\"><i class=\"fa fa-edit\"></i></a> <button style=\"position:absolute;right:10px;top:10px;z-index:999;font-size:15px\" class=\"btn btn-sm btn-danger\" onClick=\"dels(".$row2["S_id"].")\"><i class=\"fa fa-times-circle\"></i></button></div>";

																}
															}


														}
													}
											?>
											
										</ul>
											
									</div>

									
									<a href="nsort_add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增文章分类</a>
									<a href="excel_news.php" class="btn btn-sm btn-warning"><i class="fa fa-plus-circle"></i> 导入Excel</a>

								</div>
								<div class="col-lg-8">
									<form id="form">
									<div class="card card-primary">

										<div class="card-header">
											<h4><?php 
											if($action=="search"){
												echo "搜索“".t($_POST["keyword"])."” - ";
											}else{
												echo $S_title;
											}
											
											?>文章列表</h4>

										</div>
										<div class="card-body p-0">
											<div class="table-responsive">
												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>选择</th>
														<th>排序</th>
														<th>名称</th>
														<th>价格</th>
														<th>配图</th>
														
														<th>分类</th>
														<th>卖家</th>
														
														<th>操作</th>
														

													</tr>

<?php
		if($action=="sh"){
			$sql="select * from sl_news,sl_nsort where N_del=0 and S_del=0 and N_sort=S_id and N_sh=0 order by N_id desc,N_order";
		}else{
			if($action=="search"){
				$sql="select * from sl_news,sl_nsort where N_del=0 and S_del=0 and N_sort=S_id and N_title like '%".t($_POST["keyword"])."%' order by N_top desc,N_order,N_id desc";
			}else{
				if($S_id==0){
					$sql="select * from sl_news,sl_nsort where N_del=0 and S_del=0 and N_sort=S_id order by N_top desc,N_order,N_id desc limit ".(($page-1)*20).",20";
				}else{
					$sql="select * from sl_news,sl_nsort where N_del=0 and S_del=0 and N_sort=S_id and (S_id=".$S_id." or S_sub=".$S_id.") order by N_top desc,N_order,N_id desc limit ".(($page-1)*20).",20";
				}
			}
		}
		

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {


		switch($row["N_sh"]){
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


		if($row["N_mid"]>0){
			$from=getrs("select M_login from sl_member where M_id=".$row["N_mid"],"M_login");
		}else{
			$from="自营";
		}

		if($row["N_top"]==1){
			$top="<div style=\"background:#0099ff;color:#ffffff;border-radius:5px;font-size:12px;padding:2px 6px;display:inline-block;margin-top:5px;\"><i class=\"fa fa-arrow-circle-up\"></i> 置顶</div>";
		}else{
			$top="";
		}
			echo "<tr id='".$row["N_id"]."'>
			<td><input type=\"checkbox\" name=\"id[]\" value=\"".$row["N_id"]."\"></td>
			<td><input type=\"txt\" style=\"width:50px;\" class=\"form-control\" name=\"order_".$row["N_id"]."\" value=\"".$row["N_order"]."\">".$top."</td>
			<td><textarea style=\"width:100%;min-width:180px;\" rows=\"3\" class=\"form-control\" name=\"title_".$row["N_id"]."\"/>".htmlspecialchars($row["N_title"])."</textarea></td>
			<td><div style=\"font-weight:bold;color:#ff0000\">￥".$row["N_price"]."</div></td>
			<td><img src=\"".pic2($row["N_pic"])."\" height=\"50\" alt=\"<img src='".pic2($row["N_pic"])."' width='500'>\"></td>
			<td><p><select name=\"sort_".$row["N_id"]."\" class=\"form-control\" style=\"width:100px;\">";
													$sql2="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
																	$result2 = mysqli_query($conn, $sql2);
																	if (mysqli_num_rows($result2) > 0) {
																	while($row2 = mysqli_fetch_assoc($result2)) {
																		echo "<optgroup label=\"".$row2["S_title"]."\">";
																		$sql3="select * from sl_nsort where S_del=0 and S_sub=".$row2["S_id"]." order by S_order,S_id desc";
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
																		echo "</optgroup>";
																	}
																}

													echo "</select><p><p>
<a class=\"btn btn-sm btn-warning\" target=\"_blank\" href=\"../?type=newsinfo&id=".$row["N_id"]."\"><i class=\"fa fa-send\"></i> 浏览</a>
<button class=\"btn btn-primary btn-sm\" type=\"button\" onclick=\"\$('#haibao').modal('show');\$('#poster').html('<iframe src=\'poster.php?type=news&id=".$row["N_id"]."\' scrolling=\'no\' name=\'mapif\' type=\'1\' frameborder=\'0\' height=\'820\' width=\'100%\'></iframe>')\"><i class=\"fa fa-image\"></i> 海报</button></p>
													</td>
			<td><p>".$from."</p><p>".$sh."</p></td>
			<td><p><a href='news_add.php?N_id=".$row["N_id"]."' class='btn btn-sm btn-info'><i class=\"fa fa-edit\"></i> 编辑</a></p><p><button class='btn btn-sm btn-danger' type='button' onClick='del(".$row["N_id"].")'><i class=\"fa fa-times-circle\"></i> 删除</button></p></td>
			
			</tr>";

		}
	}
?>

												</table>
											</div>
										</div>
									</div>

									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<button class="btn btn-sm btn-primary" type="button" onclick="save()"><i class="fa fa-save"></i> 保存修改</button>
									<a href="news_add.php" class="btn btn-sm btn-info"><i class="fa fa-plus-circle"></i> 新增文章</a>
									

									<ul class="pagination" id="pagination" style="float: right;"></ul>
									</form>
								</div>
								
							</div>
						</div>
<?php if($action!="search" && $action!="sh"){?>	
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


<!-- Large Modal -->
<div id="haibao" class="modal fade">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header pd-x-20">
				<h6 class="modal-title">生成海报</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="poster"></div>
		</div>
	</div><!-- modal-dialog -->
</div><!-- modal -->

		<!--Jquery.min js-->
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
            $("#PageCount").val("<?php echo $N_counts?>");
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
                window.location="news_list.php?S_id="+<?php echo $S_id?>+"&page="+num;
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

function del(id){
			if (confirm("确定删除文章吗？")==true){
                $.ajax({
            	url:'?action=del&N_id='+id,
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
			if (confirm("确定删除文章分类吗（分类下文章也会删除）？")==true){
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

function delall(){
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