<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

if(checkauth()){
	plug("x8","../conn/plug/");
	require "../conn/plug/x8.php";
}else{
	die("{\"msg\":\"免费版暂不支持回收站功能\"}");
}

$action=$_GET["action"];
if($action=="clear"){
	/*
	$pic="|";
	$sql="select * from sl_text";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["T_pic"]."|";
	    }
	} 

	$sql="select * from sl_news";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["N_pic"]."|";
		    if($row["N_video"]!=""){
		        $pic=$pic.$row["N_video"]."|";
		    }
	    }
	} 

	$sql="select * from sl_product";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["P_pic"]."|";
	        if($row["P_video"]!=""){
		        $pic=$pic.$row["P_video"]."|";
		    }
	    }
	} 

	$sql="select * from sl_nsort";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["S_pic"]."|";
	    }
	} 

	$sql="select * from sl_psort";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["S_pic"]."|";
	    }
	} 

	$sql="select * from sl_slide";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["S_pic"]."|";
	    }
	} 

	$sql="select * from sl_link";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["L_pic"]."|";
	    }
	} 

	$sql="select * from sl_member";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["M_head"]."|";
	    }
	} 

	$sql="select * from sl_admin";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	        $pic=$pic.$row["A_head"]."|";
	    }
	} 
	$pic=$pic."$C_logo|$C_ico|$C_qrcode|nopic.png|admin.jpg|img.php|";

	//删除media文件夹里用不到的文件
	$handler=opendir('../media/');
	while(($filename = readdir($handler)) !== false ) {
		if($filename != "." && $filename != ".."){  
			if(strpos($pic,"|$filename|")===false){
				unlink("../media/$filename");
			}
		}
	}
*/

	//清理无上级的商品
	mysqli_query($conn,"delete from sl_product where not P_sort in (select S_id from sl_psort where not S_sub=0)");
	//清理无上级的新闻
	mysqli_query($conn,"delete from sl_news where not N_sort in (select S_id from sl_nsort where not S_sub=0)");
	//清理无上级的卡密
	mysqli_query($conn,"delete from sl_card where not C_sort in (select S_id from sl_csort)");
	//清理无上级的商品子分类
	mysqli_query($conn,"delete from sl_psort where not S_sub in (select S_id from sl_psort where S_sub=0)");
	//清理无上级的新闻子分类
	mysqli_query($conn,"delete from sl_nsort where not S_sub in (select S_id from sl_nsort where S_sub=0)");
	//清理无上级的子菜单
	mysqli_query($conn,"delete from sl_menu where not U_sub in (select U_id from sl_menu where U_sub=0)");

	die("success");

}
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>回收站管理 - 后台管理</title>

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
					<section class="section">

						<button class="btn btn-info pull-right" style="z-index: 2;position: relative;" onclick="clearx();">清理冗余数据</button>
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">回收站管理</li>
                        </ol>

						<div class="section-body ">

							<div class="row">
								<div class="col-lg-12">
									<form id="form">
									<div class="card card-primary">

										<div class="card-header">
											<h4>回收站管理</h4>
										</div>
										<div class="card-body p-0">
											<div class="table-responsive">
												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>选择</th>
														<th>名称</th>
														<th>类型</th>
														<th>图片</th>
														<th>恢复</th>
														<th>删除</th>
													</tr>

<?php
$sql="select * from sl_address where A_del=1 order by A_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"admin_A_".$row["A_id"]."\"></td><td>".$row["A_address"]."</td><td><b>收货地址</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('address_A_".$row["A_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('address_A_".$row["A_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_admin where A_del=1 order by A_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"admin_A_".$row["A_id"]."\"></td><td>".$row["A_login"]."</td><td><b>管理员</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('admin_A_".$row["A_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('admin_A_".$row["A_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_card where C_del=1 order by C_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"card_C_".$row["C_id"]."\"></td><td>".$row["C_content"]."</td><td><b>卡密</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('card_C_".$row["C_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('card_C_".$row["C_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_rcard where R_del=1 order by R_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"rcard_R_".$row["R_id"]."\"></td><td>".$row["R_content"]."</td><td><b>充值卡</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('rcard_R_".$row["R_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('rcard_R_".$row["R_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_csort where S_del=1 order by S_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"csort_S_".$row["S_id"]."\"></td><td>".$row["S_title"]."</td><td><b>卡密分类</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('csort_S_".$row["S_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('csort_S_".$row["S_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_guestbook where G_del=1 order by G_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"guestbook_G_".$row["G_id"]."\"></td><td>".$row["G_title"]."</td><td><b>在线留言</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('guestbook_G_".$row["G_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('guestbook_G_".$row["G_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_link where L_del=1 order by L_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"link_L_".$row["L_id"]."\"></td><td>".$row["L_title"]."</td><td><b>友链</b></td><td><img src=\"../media/".$row["L_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('link_L_".$row["L_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('link_L_".$row["L_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_list where L_del=1 order by L_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"list_L_".$row["L_id"]."\"></td><td>".$row["L_title"]."</td><td><b>资金明细</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('list_L_".$row["L_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('list_L_".$row["L_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_log where L_del=1 order by L_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"log_L_".$row["L_id"]."\"></td><td>".$row["L_title"]."</td><td><b>操作记录</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('log_L_".$row["L_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('log_L_".$row["L_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

$sql="select * from sl_member where M_del=1 order by M_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"member_M_".$row["M_id"]."\"></td><td>".$row["M_login"]."</td><td><b>会员帐号</b></td><td><img src=\"../media/".$row["M_head"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('member_M_".$row["M_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('member_M_".$row["M_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}


$sql="select * from sl_menu where U_del=1 order by U_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"menu_U_".$row["U_id"]."\"></td><td>".$row["U_title"]."</td><td><b>菜单</b></td><td><img src=\"../media/nopic.png\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('menu_U_".$row["U_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('menu_U_".$row["U_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}


$sql="select * from sl_news where N_del=1 order by N_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"news_N_".$row["N_id"]."\"></td><td>".$row["N_title"]."</td><td><b>新闻</b></td><td><img src=\"../media/".$row["N_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('news_N_".$row["N_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('news_N_".$row["N_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}
$sql="select * from sl_nsort where S_del=1 order by S_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"nsort_S_".$row["S_id"]."\"></td><td>".$row["S_title"]."</td><td><b>新闻分类</b></td><td><img src=\"../media/".$row["S_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('nsort_S_".$row["S_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('nsort_S_".$row["S_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}
$sql="select * from sl_orders where O_del=1 order by O_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"orders_O_".$row["O_id"]."\"></td><td>".$row["O_title"]."</td><td><b>订单记录</b></td><td><img src=\"../media/".$row["O_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('orders_O_".$row["O_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('orders_O_".$row["O_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

	$sql="select * from sl_product where P_del=1 order by P_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"product_P_".$row["P_id"]."\"></td><td>".$row["P_title"]."</td><td><b>商品</b></td><td><img src=\"../media/".splitx($row["P_pic"],"|",0)."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('product_P_".$row["P_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('product_P_".$row["P_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

	$sql="select * from sl_psort where S_del=1 order by S_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"psort_S_".$row["S_id"]."\"></td><td>".$row["S_title"]."</td><td><b>商品分类</b></td><td><img src=\"../media/".$row["S_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('psort_S_".$row["S_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('psort_S_".$row["S_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

	$sql="select * from sl_slide where S_del=1 order by S_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"slide_S_".$row["S_id"]."\"></td><td>".$row["S_title"]."</td><td><b>焦点图</b></td><td><img src=\"../media/".$row["S_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('slide_S_".$row["S_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('slide_S_".$row["S_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}

	$sql="select * from sl_text where T_del=1 order by T_id";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"text_T_".$row["T_id"]."\"></td><td>".$row["T_title"]."</td><td><b>单页</b></td><td><img src=\"../media/".$row["T_pic"]."\" height=\"50\"></td><td><button class='btn btn-sm btn-info' type='button' onClick=\"recycle('text_T_".$row["T_id"]."')\"><i class=\"fa fa-recycle\"></i> 恢复</button></td><td><button class='btn btn-sm btn-danger' type='button' onClick=\"del('text_T_".$row["T_id"]."')\"><i class=\"fa fa-times-circle\"></i> 彻底删除</button></td></tr>";
		}
	}
?>

												</table>
											</div>
										</div>
									</div>
<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
<button class="btn btn-sm btn-info" type="button" onClick="recycleall()"><i class="fa fa-times-circle" ></i> 恢复所选</button>
</form>
								</div>
								
							</div>
						</div>

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


function del(id){
			if (confirm("确定删除吗？")==true){
                $.ajax({
            	url:'?action=del&id='+id,
            	type:'post',
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

function recycle(id){
			if (confirm("确定恢复吗？")==true){
                $.ajax({
            	url:'?action=recycle&id='+id,
            	type:'post',
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

function recycleall(){
				$.ajax({
            	url:'?action=recycleall',
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
function clearx(){
			if(window.confirm('清理冗余数据说明：\r1.清理没有用的图片，节省本地空间\r2.清理没有分类的新闻，商品，卡密\r3.清理没有上级分类的新闻子分类，商品子分类\r4.清理没有上级菜单的子菜单')){
				$.ajax({
	            	url:'?action=clear',
	            	type:'get',
	            	success:function (data) {
		            	if(data=="success"){
		            		toastr.success("清理完成", '成功');
		            	}else{
		            		toastr.error(data, '错误');
		            	}
	            	}
	            });
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