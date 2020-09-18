<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$O_id=intval($_GET["O_id"]);
$M_id=intval($_GET["M_id"]);

if($M_id>0){
	$M_info=" and O_mid=$M_id";
}else{
	$M_info="";
}

if($page==""){
	$page=1;
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_orders set O_del=1 where O_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除订单')");
			die("success");
		} else {
			die("删除失败");
		}

	} else {
		die("未选择要删除的内容");
	}
}


$sql="select count(O_id) as O_count from sl_orders where O_state>0 and O_del=0".$M_info;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$O_count=$row["O_count"];
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>订单管理 - 后台管理</title>

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
					<a href="recycle.php" class="btn btn-sm btn-primary pull-right" style="z-index: 2;position: relative;"><i class="fa fa-recycle"></i> 回收站</a>

					<form class="input-group pull-right" style="width: 300px;z-index: 2;position: relative;margin-right: 5px;" method="post" action="?action=search">
	                    <input type="text" class="form-control input-sm" name="keyword" value="<?php echo t($_POST["keyword"])?>" placeholder="搜索订单">
	                    <span class="input-group-btn">
	                        <button class="btn btn-info btn-sm" type="form"><i class="fa fa-search"></i> 搜索</button>
	                    </span>
	                </form>

					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">订单管理</li>
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
											?>订单记录</h4>

										</div>
										<div class="card-body p-0">
											<div class="table-responsive">
												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>选择</th>
														<th>名称</th>
														<th>图片</th>
														<th>会员/邮箱</th>
														<th>交易单号</th>
														<th>发货内容</th>
													</tr>
<?php
if($action=="fh"){
	$sql="select * from sl_orders,sl_member where O_mid=M_id and O_del=0 ".$M_info." and O_state=2 and O_type=0 and O_content='实物商品，由商家手动发货' order by O_id desc";
}else{
	if($action=="search"){
		$sql="select * from sl_orders,sl_member where O_state>0 and O_mid=M_id and O_del=0 and (O_title like '%".t($_POST["keyword"])."%' or M_login like '%".t($_POST["keyword"])."%') ".$M_info." order by O_id desc";
	}else{
		$sql="select * from sl_orders,sl_member where O_state>0 and O_mid=M_id and O_del=0 ".$M_info." order by O_id desc limit ".(($page-1)*20).",20";
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

			if($row["O_state"]==0){
				$f="<span style=\"color:#ff9900\">未付款</span>";
			}
			if($row["O_state"]==1){
				$f="<span  style=\"color:#009900\">已发货</span>";
			}
			if($row["O_state"]==2){
				if($row["O_sellmid"]==0){
					$f="<a href=\"send.php?O_id=".$row["O_id"]."\" target=\"_blank\" class=\"btn btn-sm btn-info\">发货</a>";
				}else{
					$f="等待商家发货";
				}
			}
			if($row["O_wl"]!=""){
				$wl="<p>快递公司：".$row["O_wl"]." <br>快递单号：".$row["O_wlno"]."</p>";
			}else{
				$wl="";
			}

			$L_no2=getrs("select * from sl_list where L_genkey='".$row["O_genkey"]."'","L_no2");
			if($L_no2==""){
				$L_no=getrs("select * from sl_list where L_genkey='".$row["O_genkey"]."'","L_no");
			}else{
				$L_no=$L_no2;
			}

			if($row["O_type"]==0){
				echo "<tr id='".$row["O_id"]."'><td><input type=\"checkbox\" name=\"id[]\" value=\"".$row["O_id"]."\"></td><td><a href=\"../?type=productinfo&id=".$row["O_pid"]."\" target=\"_blank\"><div style=\"width:100%;max-width:400px;display:block;white-space:normal;\"><p>[商品] ".$row["O_title"]."</p></div></a><p>".$row["O_price"]." × ".$row["O_num"]." = <b>".($row["O_price"]*$row["O_num"])."元</b></p><p>".$row["O_time"]."</p></td><td><img src=\"".pic2(splitx($row["O_pic"],"|",0))."\" height=\"50\" alt=\"<img src='".pic2(splitx($row["O_pic"],"|",0))."' width='500'>\"></td><td><p><a href=\"member.php?M_id=".$row["M_id"]."\"><i class=\"fa fa-user\"></i> ".$row["M_login"].$M_vip."</a> <a href=\"?M_id=".$row["M_id"]."\" class=\"btn btn-sm btn-info\">查询</a></p><p>".str_replace("__","<br>",$row["O_address"])."</p></td><td>".$L_no."</td><td><p><b>状态：".$f."</b></p><div style=\"width:100%;max-width:400px;display:block;white-space:normal;\">".str_replace("||","<br>",$row["O_content"])."</div>".$wl."</td></tr>";
			}else{
				echo "<tr id='".$row["O_id"]."'><td><input type=\"checkbox\" name=\"id[]\" value=\"".$row["O_id"]."\"></td><td><a href=\"../?type=newsinfo&id=".$row["O_nid"]."\" target=\"_blank\"><div style=\"width:100%;max-width:400px;display:block;white-space:normal;\"><p>[新闻] ".$row["O_title"]."</p></div></a><p>".$row["O_price"]." × ".$row["O_num"]." = <b>".($row["O_price"]*$row["O_num"])."元</b></p><p>".$row["O_time"]."</p></td><td><img src=\"".pic2($row["O_pic"])."\" height=\"50\" alt=\"<img src='".pic2($row["O_pic"])."' width='500'>\"></td><td><p><a href=\"member.php?M_id=".$row["M_id"]."\"><i class=\"fa fa-user\"></i> ".$row["M_login"].$M_vip."</a> <a href=\"?M_id=".$row["M_id"]."\" class=\"btn btn-sm btn-info\">查询</a></p><p>".$row["O_address"]."</p></td><td>".$L_no."</td><td><p><b>状态：".$f."</b></p></td></tr>";
			}
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
						<?php if($action!="fh" && $action!="search"){?>
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
		<script src="assets/js/help.js"></script>
		<!--Toastr js-->
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>
		<script src="assets/plugins/toaster/garessi-notif.js"></script>


		<script src="assets/js/jqPaginator.min.js" type="text/javascript"></script>
		<script>
function loadData(num) {
            $("#PageCount").val("<?php echo $O_count?>");
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
                window.location="orders_list.php?page="+num+"&M_id=<?php echo $M_id?>";
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

function del(id){
			if (confirm("确定删除吗？")==true){
                $.ajax({
            	url:'?action=del&S_id='+id,
            	type:'post',
            	success:function (data) {
            	if(data=="success"){
            		$("#"+id).hide();
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