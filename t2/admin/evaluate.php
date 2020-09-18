<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$E_id=intval($_GET["E_id"]);

if($page==""){
	$page=1;
}

if($E_id!=""){
	$aa="reply&E_id=".$E_id;
	$sql="select * from sl_evaluate,sl_orders,sl_member where E_mid=M_id and E_oid=O_id and E_id=".$E_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$O_id=$row["O_id"];
		$O_pid=$row["O_pid"];
		$O_title=$row["O_title"];
		$O_pic=$row["O_pic"];
		$E_content=htmlspecialchars($row["E_content"]);
		$E_time=$row["E_time"];
		$E_reply=$row["E_reply"];
		$E_star=$row["E_star"];
		$M_login=$row["M_login"];
		$M_id=$row["M_id"];
	}
}

if($action=="reply"){
	if($_POST["E_reply"]!=""){
		mysqli_query($conn,"update sl_evaluate set E_reply='".$_POST["E_reply"]."' where E_id=".$E_id);
		mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','回复商品评价')");
		die("{\"msg\":\"success\",\"id\":\"".$E_id."\"}");
	}else{
		die("{\"msg\":\"请填全信息\"}");
	}
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_evaluate set E_del=1 where E_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除评价')");
			die("{\"msg\":\"success\",\"ids\":\"".$ids."\"}");
		} else {
			die("{\"msg\":\"删除失败\"}");
		}

	} else {
		die("{\"msg\":\"未选择要删除的内容\"}");
	}
}

$sql="select count(E_id) as E_count from sl_evaluate,sl_orders,sl_member where E_mid=M_id and E_oid=O_id and E_del=0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$E_counts=$row["E_count"];
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>评价管理 - 后台管理</title>

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

		<script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 500px}
		.list-group a{text-decoration:none}
		.part{display:inline-block;width:30%;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;}


#buy label {
	padding: 1px 5px;
	cursor: pointer;
	border: #CCCCCC solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

#buy .checked {
	border: #ff0000 solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	color: #ff0000;
}

#buy input[type="radio"] {
	display: none;
}
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

					<a href="recycle.php" class="btn btn-info pull-right" style="z-index: 2;position: relative;"><i class="fa fa-recycle"></i> 回收站</a>
					<a href="evaluate_add.php" class="btn btn-primary pull-right" style="z-index: 2;position: relative;margin-right: 5px;"><i class="fa fa-plus-circle"></i> 虚拟评价</a>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">评价管理</li>
                        </ol>


						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-4">
									<form id="list">
									<div class="card card-primary">

										<div class="card-header">
											<h4>评价列表</h4>
										</div>
												<ul class="list-group">
													<li class="list-group-item " style="background: #f7f7f7"><div class="part">评价</div><div class="part">商品</div><div class="part">时间</div></li>
													<?php 
														$sql="select * from sl_evaluate,sl_orders,sl_member where E_mid=M_id and E_oid=O_id and E_del=0 order by E_id desc limit ".(($page-1)*20).",20";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["E_id"]==$E_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	
																	echo "<a id=\"".$row["E_id"]."\" href=\"?E_id=".$row["E_id"]."\" class=\"list-group-item ".$active."\">
																	<div class=\"part\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row["E_id"]."\"> [".$row["E_star"]."星] ".$row["E_content"]."</div> 
																	<div class=\"part\">".$row["O_title"]."</div> 
																	<div class=\"part\">".$row["E_time"]."</div> 
																	<img src=\"../media/".$row["O_pic"]."\" alt=\"<img src='../media/".$row["O_pic"]."' width='300'>\" style=\"height:25px;border-radius:10px;\" class=\"pull-right\"></a>";
																}
															}
													?>
													
												</ul>
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									
									<ul class="pagination" id="pagination" style="float: right;"></ul>
									<input type="hidden" id="PageCount" runat="server" />
        <input type="hidden" id="PageSize" runat="server" value="20" />
        <input type="hidden" id="countindex" runat="server" value="20"/>
        <!--设置最多显示的页码数 可以手动设置 默认为7-->
        <input type="hidden" id="visiblePages" runat="server" value="7" />
								</form>
								</div>
								<?php if($action!="menu"){?>
								
								<div class="col-lg-8">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4>评价管理</h4>
										</div>
										<div class="card-body">
											<div class="form-group row">
													<label class="col-md-3 col-form-label" >商品标题</label>
													<div class="col-md-9" style="margin-top: 7px">
														<a href="../?type=productinfo&id=<?php echo $O_pid?>" target="_blank"><?php echo $O_title?></a>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >商品图片</label>
													<div class="col-md-9" style="margin-top: 7px">
														<a href="../?type=productinfo&id=<?php echo $O_pid?>" target="_blank"><img src="../media/<?php echo $O_pic?>" width="100"></a>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >评价时间</label>
													<div class="col-md-9" style="margin-top: 7px">
														<?php echo $E_time?>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >评价内容</label>
													<div class="col-md-9" style="margin-top: 7px">
														[<?php echo $E_star?>星] <?php echo $E_content?>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >评价会员</label>
													<div class="col-md-9" style="margin-top: 7px">
														<a href="member.php?M_id=<?php echo $M_id?>"><i class="fa fa-user"></i> <?php echo $M_login?></a>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-3 col-form-label">回复评价</label>
													<div class="col-md-9" style="margin-top: 7px">
														<textarea class="form-control" name="E_reply" rows="10"><?php echo $E_reply?></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-info" type="button" onClick="save()">回复</button>
														
														
													</div>
												</div>
										</div>
									</div>
									</form>
								</div>
							
							<?php }?>
							
							</div>
							
						</div>
					</section>
				</div>

			</div>
		</div>

		<!--Jquery.min js-->
		<script src="assets/js/jquery.min.js"></script>

		

		<script src="assets/js/help.js"></script>

		<!--Bootstrap.min js-->
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--Jquery.nicescroll.min js-->
		<script src="assets/plugins/nicescroll/jquery.nicescroll.min.js"></script>

		<!--mCustomScrollbar js-->
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!--Scroll-up-bar.min js-->
		<script src="assets/plugins/scroll-up-bar/dist/scroll-up-bar.min.js"></script>

		<!--Sidemenu js-->
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
		<!--Scripts js-->
		<script src="assets/js/scripts.js"></script>

		<script src="assets/plugins/toastr/build/toastr.min.js"></script>
		<script src="assets/plugins/toaster/garessi-notif.js"></script>

		<script src="assets/js/jqPaginator.min.js" type="text/javascript"></script>
		<script type="text/javascript">

function loadData(num) {
    $("#PageCount").val("<?php echo $E_counts?>");
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
        first: '<li class="first page-item"><a href="javascript:;" class="page-link">|<</a></li>',
        prev: '<li class="prev page-item"><a href="javascript:;" class="page-link"><i class="arrow arrow2"></i><</a></li>',
        next: '<li class="next page-item"><a href="javascript:;" class="page-link">><i class="arrow arrow3"></i></a></li>',
        last: '<li class="last page-item"><a href="javascript:;" class="page-link">>|</a></li>',
        page: '<li class="page page-item"><a href="javascript:;" class="page-link">{{page}}</a></li>',
        onPageChange: function (num, type) {
            if (type == "change") {
                window.location="evaluate.php?action=menu&page="+num;
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

		function save(){
			
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		toastr.success("保存成功，2秒后刷新", "成功");
            		setTimeout("window.location.href='evaluate.php?E_id="+data.id+"'", 2000 )
            	}else{
            		toastr.error(data.msg, '错误');
            	}
            	}
            });

			}
function delall() {
    if (confirm("确定删除吗？") == true) {
        $.ajax({
            url: '?action=delall',
            type: 'post',
            data: $("#list").serialize(),
            success: function(data) {
                data = JSON.parse(data);
                if (data.msg == "success") {
                    toastr.success("删除成功", "成功");
                    id = data.ids.split(",");
                    for (var i = 0; i < id.length; i++) {
                        $("#" + id[i]).hide();
                    };
                } else {
                    toastr.error(data.msg, '错误');
                }
            }
        });
        return true;
    } else {
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
