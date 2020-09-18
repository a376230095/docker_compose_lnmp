<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$L_id=intval($_GET["L_id"]);
$M_id=intval($_GET["M_id"]);

if($M_id>0){
	$M_info=" and L_mid=$M_id";
}else{
	$M_info="";
}


if($page==""){
	$page=1;
}

if($action=="sh1"){
	mysqli_query($conn,"update sl_list set L_sh=1 where L_id=".$L_id);
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','审核提现')");
	die("success");
}

if($action=="sh2"){
	$money=getrs("select L_money from sl_list where L_id=".$L_id,"L_money");
	$M_id=getrs("select L_mid from sl_list where L_id=".$L_id,"L_mid");
	$M_email=getrs("select M_email from sl_member where M_id=".$M_id,"M_email");
	
	sendmail("申请提现被驳回","提现金额：".(-$money)."元<br>驳回原因：".$_POST["msg"]."，资金已退回余额",$M_email);
	mysqli_query($conn,"update sl_list set L_sh=2,L_title=CONCAT(L_title,'<br><b>原因：".$_POST["msg"]."，资金已退回余额</b>') where L_id=".$L_id);
	mysqli_query($conn,"update sl_member set M_money=M_money-".$money." where M_id=".$M_id);
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','驳回提现')");
	die("success");
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_list set L_del=1 where L_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除明细')");
			die("success");
		} else {
			die("删除失败");
		}

	} else {
		die("未选择要删除的内容");
	}
}


$sql="select count(L_id) as L_count from sl_list where L_del=0".$M_info;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$L_count=$row["L_count"];

?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>资金明细 - 后台管理</title>

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
					<form class="input-group pull-right" style="width: 300px;z-index: 2;position: relative;margin-right: 5px;" method="post" action="?action=search">
	                    <input type="text" class="form-control" name="keyword" value="<?php echo t($_POST["keyword"])?>" placeholder="输入会员帐号">
	                    <span class="input-group-btn">
	                        <button class="btn btn-info" type="form"><i class="fa fa-search"></i> 搜索</button>
	                    </span>
	                </form>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">资金明细</li>
                        </ol>

						<div class="section-body ">

							<div class="row">
								<div class="col-lg-12">
									<form id="form">
									<div class="card card-primary">

										<div class="card-header">
											<h4><?php
											if($M_id>0){
												echo "用户：<b>".getrs("select M_login from sl_member where M_id=".$M_id,"M_login")."</b>的";
											}
											?>资金明细</h4>

										</div>
										<div class="card-body p-0">
											<div class="table-responsive">
												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>选择</th>
														<th>名称</th>
														<th>金额</th>
														<th>会员</th>
														<th>编号</th>
														<th>时间</th>
														<th>审核</th>
													</tr>
<?php
if($action=="search"){
	$sql="select * from sl_list,sl_member where L_mid=M_id and L_del=0 and M_login like '%".t($_POST["keyword"])."%' order by L_id desc";
}else{
	if($action=="money"){
		$sql="select * from sl_list,sl_member where L_mid=M_id and L_del=0".$M_info." and L_title like '%余额提现%' order by L_sh asc,L_id desc";
	}else{
		$sql="select * from sl_list,sl_member where L_mid=M_id and L_del=0".$M_info." order by L_id desc limit ".(($page-1)*20).",20";
	}
}


		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

			if($row["M_viplong"]-(time()-strtotime($row["M_viptime"]))/86400>0){
				$M_vip=" <img src=\"img/vip.png\" height=\"20\">";
			}else{
				$M_vip="";
			}
			if($row["L_money"]>0){
				$f="+";
			}else{
				$f="";
			}
			switch($row["L_sh"]){
				case 0:
				$sh="<textarea placeholder=\"回复内容\" id=\"msg_".$row["L_id"]."\"></textarea><br><button type=\"button\" class=\"btn btn-sm btn-primary\" onClick=\"sh(1,".$row["L_id"].")\">通过</button> <button type=\"button\" class=\"btn btn-sm btn-danger\" onClick=\"sh(2,".$row["L_id"].")\">驳回</button>";
				break;
				case 1:
				$sh="<span style=\"color:#009900\">已通过</span>";
				break;
				case 2:
				$sh="<span style=\"color:#ff0000\">未通过</span>";
				break;
			}
			
			echo "<tr id='".$row["L_id"]."'><td><input type=\"checkbox\" name=\"id[]\" value=\"".$row["L_id"]."\"></td><td>".$row["L_title"]."</td><td>".$f.$row["L_money"]."</td><td><a href=\"member.php?M_id=".$row["M_id"]."\"><i class=\"fa fa-user\"></i> ".$row["M_login"].$M_vip."</a> <a href=\"?M_id=".$row["M_id"]."\" class=\"btn btn-sm btn-info\">查询</a></td><td>".$row["L_no"]."</td><td>".$row["L_time"]."</td><td>".$sh."</td></tr>";
		}
	}
?>

												</table>
											</div>
										</div>
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<ul class="pagination" id="pagination" style="float: right;"></ul>
								</form>
								</div>
								
							</div>
						</div>
<?php if($action!="money" && $action!="search"){?>
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



		<!--Jquery.min js-->
		<script src="assets/js/jquery.min.js"></script>

		<!--popper js-->
		<script src="assets/js/popper.js"></script>

		<!--Tooltip js-->
		<script src="assets/js/tooltip.js"></script>

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

		<script src="assets/plugins/toaster/garessi-notif.js"></script>
		<script src="assets/js/jqPaginator.min.js" type="text/javascript"></script>
		<script>
function loadData(num) {
            $("#PageCount").val("<?php echo $L_count?>");
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
                window.location="list.php?page="+num+"&M_id=<?php echo $M_id?>";
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});


function sh(action,id){
			if (confirm("确定审核吗？")==true){
                $.ajax({
            	url:'?action=sh'+action+'&L_id='+id,
            	type:'post',
            	data:{msg:$("#msg_"+id).val()},
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