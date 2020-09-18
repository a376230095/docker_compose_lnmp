<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$U_id=intval($_GET["U_id"]);
if($U_id!=""){
	$aa="edit&U_id=".$U_id;
	$sql="select * from sl_menu where U_id=".$U_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$U_order=$row["U_order"];
		$U_title=$row["U_title"];
		$U_type=$row["U_type"];
		$U_typeid=$row["U_typeid"];
		$U_link=$row["U_link"];
		$U_sub=$row["U_sub"];
	}
	$title="编辑";
}else{
	$aa="add";
	$title="新增";
}

if($action=="add"){
	$U_order=intval($_POST["U_order"]);
	$U_title=$_POST["U_title"];
	$U_type=splitx($_POST["U_type"],"_",0);
	$U_typeid=intval(splitx($_POST["U_type"],"_",1));
	$U_link=$_POST["U_link"];
	$U_sub=intval($_POST["U_sub"]);

	if($U_title!=""){
		if(getrs("select * from sl_menu where U_title='$U_title' and U_del=0 and U_type='$U_type' and U_typeid=$U_typeid and U_order=$U_order and U_sub=$U_sub","U_id")==""){
			mysqli_query($conn,"insert into sl_menu(U_order,U_title,U_type,U_typeid,U_link,U_sub) values($U_order,'$U_title','$U_type',$U_typeid,'$U_link',$U_sub)");
			$U_id=getrs("select * from sl_menu where U_title='$U_title' and U_del=0","U_id");
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增菜单')");
			die("{\"msg\":\"success\",\"id\":\"".$U_id."\"}");
		}else{
			die("{\"msg\":\"已存在同名记录\"}");
		}
		
	}else{
		die("{\"msg\":\"请填全信息\"}");
	}
}

if($action=="edit"){
	$U_order=intval($_POST["U_order"]);
	$U_title=$_POST["U_title"];
	$U_type=splitx($_POST["U_type"],"_",0);
	$U_typeid=intval(splitx($_POST["U_type"],"_",1));
	$U_link=$_POST["U_link"];
	$U_sub=intval($_POST["U_sub"]);

	if($U_title!=""){
		mysqli_query($conn, "update sl_menu set
		U_title='$U_title',
		U_order=$U_order,
		U_type='$U_type',
		U_typeid=$U_typeid,
		U_link='$U_link',
		U_sub=$U_sub
		where U_id=".$U_id);
		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑菜单')");
		die("{\"msg\":\"success\",\"id\":\"".$U_id."\"}");
	}else{
		die("{\"msg\":\"请填全信息\"}");
	}
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_menu set U_del=1 where U_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			die("{\"msg\":\"success\",\"ids\":\"".$ids."\"}");
		} else {
			die("{\"msg\":\"删除失败\"}");
		}
	} else {
		die("{\"msg\":\"未选择要删除的内容\"}");
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title?>菜单 - 后台管理</title>

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
		.list-group a{text-decoration:none}
		.part{display:inline-block;width:40%;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;}
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

					<a href="recycle.php" class="btn btn-info pull-right" style="z-index: 2;position: relative;"><i class="fa fa-recycle"></i> 回收站</a>
					<a href="menu.php" class="btn btn-primary pull-right" style="z-index: 2;position: relative;margin-right: 5px;"><i class="fa fa-plus-circle"></i> 新增菜单</a>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">菜单管理</li>
                        </ol>


						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-5">
									<form id="list">
									<div class="card card-primary">

										<div class="card-header">
											<h4>菜单列表</h4>
										</div>
												<ul class="list-group">
											<li class="list-group-item " style="background: #f7f7f7"><div class="part">标题</div><div class="part">链接到</div></li>
											<?php 
													$sql="select * from sl_menu where U_del=0 and U_sub=0 order by U_order,U_id desc";
														$result = mysqli_query($conn, $sql);
														if (mysqli_num_rows($result) > 0) {
														while($row = mysqli_fetch_assoc($result)) {
															if($row["U_id"]==$U_id){
																$active="active";
															}else{
																$active="";
															}
															switch($row["U_type"]){
																case "index":
																$type="首页";
																break;

																case "query":
																$type="内部链接 → 订单查询";
																break;
																case "member":
																$type="内部链接 → 会员中心";
																break;
																case "seller":
																$type="内部链接 → 商家入驻";
																break;
																case "login":
																$type="内部链接 → 会员登录";
																break;
																case "reg":
																$type="内部链接 → 会员注册";
																break;

																case "product":
																if($row["U_typeid"]==0){
																	$type="商品 → 全部商品";
																}else{
																	$type="商品 → ".getrs("select * from sl_psort where S_id=".$row["U_typeid"],"S_title");
																}
																
																break;
																case "news":
																if($row["U_typeid"]==0){
																	$type="文章 → 全部文章";
																}else{
																	$type="文章 → ".getrs("select * from sl_nsort where S_id=".$row["U_typeid"],"S_title");
																}
																
																break;
																case "text":
																$type="单页 → ".getrs("select * from sl_text where T_id=".$row["U_typeid"],"T_title");
																break;
																case "link":
																$type=$row["U_link"];
																break;

															}
															
															echo "<a id=\"".$row["U_id"]."\" href=\"?U_id=".$row["U_id"]."\" class=\"list-group-item ".$active."\">
															<div class=\"part\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row["U_id"]."\"> <b>└ ".$row["U_order"].".".$row["U_title"]."</b></div>
															<div class=\"part\"><b>".$type."</b></div>
															</a>";

															$sql2="select * from sl_menu where U_del=0 and U_sub=".$row["U_id"]." order by U_order,U_id desc";
																$result2 = mysqli_query($conn, $sql2);
																if (mysqli_num_rows($result2) > 0) {
																while($row2 = mysqli_fetch_assoc($result2)) {
																	if($row2["U_id"]==$U_id){
																		$active2="active";
																	}else{
																		$active2="";
																	}

																	switch($row2["U_type"]){
																		case "index":
																		$type2="首页";
																		break;

																		case "query":
																		$type2="内部链接 → 订单查询";
																		break;
																		case "member":
																		$type2="内部链接 → 会员中心";
																		break;
																		case "seller":
																		$type2="内部链接 → 商家入驻";
																		break;
																		case "login":
																		$type2="内部链接 → 会员登录";
																		break;
																		case "reg":
																		$type2="内部链接 → 会员注册";
																		break;

																		case "product":
																		if($row2["U_typeid"]==0){
																			$type2="商品 → 全部商品";
																		}else{
																			$type2="商品 → ".getrs("select * from sl_psort where S_id=".$row2["U_typeid"],"S_title");
																		}
																		
																		break;
																		case "news":
																		if($row2["U_typeid"]==0){
																			$type2="文章 → 全部文章";
																		}else{
																			$type2="文章 → ".getrs("select * from sl_nsort where S_id=".$row2["U_typeid"],"S_title");
																		}
																		
																		break;
																		case "text":
																		$type2="单页 → ".getrs("select * from sl_text where T_id=".$row2["U_typeid"],"T_title");
																		break;
																		case "link":
																		$type2=$row2["U_link"];
																		break;
																	}
																	
																	echo "<a id=\"".$row2["U_id"]."\"  href=\"?U_id=".$row2["U_id"]."\" class=\"list-group-item ".$active2."\">
																	<div class=\"part\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row2["U_id"]."\"> 
																	&nbsp;&nbsp;&nbsp;&nbsp;└ ".$row2["U_order"].".".$row2["U_title"]."
																	</div> 
																	<div class=\"part\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└ ".$type2."</div>
																	</a>";
																}
															}

														}
													}
											?>
											
										</ul>
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<a href="menu.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增菜单</a>
								</form>
								</div>
								<?php if($action!="menu"){?>
								
								<div class="col-lg-7">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4><?php echo $title?>菜单</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >上级菜单</label>
													<div class="col-md-9">
														<select name="U_sub" class="form-control">
															<option value="0">根分类</option>
															<?php

															$sql="select * from sl_menu where U_del=0 and U_sub=0 order by U_order,U_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($U_sub==$row["U_id"]){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"".$row["U_id"]."\" ".$selected.">".$row["U_title"]."</option>";
																}
															}

															?>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >链接到</label>
													<div class="col-md-9">
														<select name="U_type" class="form-control" onchange="change()" id="to">
															<option value="index_0" <?php if($U_type=="index"){
																		echo "selected='selected'";
																	}?>>首页</option>

															<optgroup label="单页模块">
															<?php

															$sql="select * from sl_text where T_del=0 order by T_order,T_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($U_typeid==$row["T_id"] && $U_type=="text"){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"text_".$row["T_id"]."\" ".$selected.">└ ".$row["T_title"]."</option>";

																}
															}

															?>
														</optgroup>

															<optgroup label="商品模块">
															<option value="product_0" <?php if($U_type=="product" && $U_typeid==0){
																		echo "selected='selected'";
																	}?>>所有商品</option>
															<?php

															$sql="select * from sl_psort where S_del=0 and S_sub=0 order by S_order,S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($U_typeid==$row["S_id"] && $U_type=="product"){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"product_".$row["S_id"]."\" ".$selected.">└ ".$row["S_title"]."</option>";


																	$sql2="select * from sl_psort where S_del=0 and S_sub=".$row["S_id"]." order by S_order,S_id desc";
																		$result2 = mysqli_query($conn, $sql2);
																		if (mysqli_num_rows($result2) > 0) {
																		while($row2 = mysqli_fetch_assoc($result2)) {
																			if($U_typeid==$row2["S_id"] && $U_type=="product"){
																				$selected2="selected";
																			}else{
																				$selected2="";
																			}
																			echo "<option value=\"product_".$row2["S_id"]."\" ".$selected2.">└── ".$row2["S_title"]."</option>";
																		}
																	}



																}
															}

															?>
														</optgroup>
														<optgroup label="文章模块">
															<option value="news_0" <?php if($U_type=="news" && $U_typeid==0){
																		echo "selected='selected'";
																	}?>>所有文章</option>
															<?php

															$sql="select * from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($U_typeid==$row["S_id"] && $U_type=="news"){
																		$selected="selected";
																	}else{
																		$selected="";
																	}
																	echo "<option value=\"news_".$row["S_id"]."\" ".$selected.">└ ".$row["S_title"]."</option>";


																	$sql2="select * from sl_nsort where S_del=0 and S_sub=".$row["S_id"]." order by S_order,S_id desc";
																		$result2 = mysqli_query($conn, $sql2);
																		if (mysqli_num_rows($result2) > 0) {
																		while($row2 = mysqli_fetch_assoc($result2)) {
																			if($U_typeid==$row2["S_id"] && $U_type=="news"){
																				$selected2="selected";
																			}else{
																				$selected2="";
																			}
																			echo "<option value=\"news_".$row2["S_id"]."\" ".$selected2.">└── ".$row2["S_title"]."</option>";
																		}
																	}
																}
															}

															?>
														</optgroup>

														<optgroup label="内部链接">
															<option value="query_1" <?php if($U_type=="query"){echo "selected='selected'";}?>>订单查询</option>
															<option value="login_1" <?php if($U_type=="login"){echo "selected='selected'";}?>>会员登录</option>
															<option value="reg_1" <?php if($U_type=="reg"){echo "selected='selected'";}?>>会员注册</option>
															<option value="member_1" <?php if($U_type=="member"){echo "selected='selected'";}?>>会员中心</option>
															<option value="seller_1" <?php if($U_type=="seller"){echo "selected='selected'";}?>>商家入驻</option>
														</optgroup>

														<option value="link_1" <?php if($U_type=="link"){
																		echo "selected='selected'";
																	}?>>外部链接</option>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >菜单标题</label>
													<div class="col-md-9">
														<input type="text"  name="U_title" class="form-control" value="<?php echo $U_title?>" id="title">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >菜单排序</label>
													<div class="col-md-9">
														<input type="text"  name="U_order" class="form-control" value="<?php echo $U_order?>" placeholder="数字越小，排序越靠前">
													</div>
												</div>

												<div class="form-group row" id="link" style=" <?php if($U_type=="link"){
													echo "";
												}else{
													echo "display:none";
												}?>">
													<label class="col-md-3 col-form-label" >外部链接</label>
													<div class="col-md-9">
														<input type="text"  name="U_link" class="form-control" value="<?php echo $U_link?>" placeholder="以http(s)://开头">
													</div>
												</div>
												

												<div class="form-group row" >
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button class="btn btn-info" type="button" onClick="save()">保存</button>
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

		<script type="text/javascript">


		function change(){
			if(document.getElementById("to").value=="link_1"){
				$("#link").show();
			}else{
				$("#link").hide();
			}
		}
		function save(){
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		toastr.success("保存成功，2秒后刷新", "成功");
            		setTimeout("window.location.href='menu.php?U_id="+data.id+"'", 2000 )
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
