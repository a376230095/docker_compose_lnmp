<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$M_id=intval($_GET["M_id"]);
$type=intval($_GET["type"]);


if($type==0){
	$type_info="会员";
}else{
	$type_info="商家";
}

if($page==""){
	$page=1;
}

if($M_id!=""){
	$aa="edit&M_id=".$M_id;
	$sql="select * from sl_member where M_id=".$M_id;

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$M_head=$row["M_head"];
		$M_from=$row["M_from"];
		$M_login=htmlspecialchars($row["M_login"]);
		$M_money=$row["M_money"];
		$M_fen=$row["M_fen"];
		$M_stop=$row["M_stop"];
		$M_stopinfo=$row["M_stopinfo"];
		$M_email=htmlspecialchars($row["M_email"]);
		$M_viptimex=$row["M_viptime"];
		$M_viplongx=$row["M_viplong"];
		$M_sellertimex=$row["M_sellertime"];
		$M_sellerlongx=$row["M_sellerlong"];

		if($M_viplongx-(time()-strtotime($M_viptimex))/86400>0){
			$M_vip=1;
			if($M_viplongx>30000){
				$M_viptitle="<span style=\"color:#ff0000\">VIP会员 [永久]</span>";
			}else{
				$M_viptitle="<span style=\"color:#ff0000\">VIP会员 [".date('Y-m-d', strtotime ("+".$M_viplongx." day", strtotime($M_viptimex)))."到期]</span>";
			}
			
		}else{
			$M_vip=0;
			$M_viptitle="普通会员";
		}

		if($M_sellerlongx-(time()-strtotime($M_sellertimex))/86400>0){
			$M_seller=1;
			if($M_sellerlongx>30000){
				$M_sellertitle="<span style=\"color:#ff0000\">商家用户 [永久]</span>";
			}else{
				$M_sellertitle="<span style=\"color:#ff0000\">商家用户 [".date('Y-m-d', strtotime ("+".$M_sellerlongx." day", strtotime($M_sellertimex)))."到期]</span>";
			}
			
		}else{
			$M_seller=0;
			$M_sellertitle="会员用户";
		}

	}
	$title="编辑";
}else{
	$M_head="head.jpg";
	$aa="add";
	$title="新增";
	$M_viptitle="普通会员";
	$M_sellertitle="会员用户";
	$M_money=0;
	$M_fen=0;
	$M_from=0;
	$M_type=0;
	$M_vip=0;
	$M_seller=0;
	$M_stop=0;
}

if($action=="add"){
$M_head=$_POST["M_head"];
$M_login=$_POST["M_login"];
$M_pwd=$_POST["M_pwd"];
$M_from=intval($_POST["M_from"]);
$M_money=round($_POST["M_money"],2);
$M_fen=intval($_POST["M_fen"]);
$M_stop=intval($_POST["M_stop"]);
$M_email=$_POST["M_email"];
$M_stopinfo=$_POST["M_stopinfo"];
$M_viplong=intval($_POST["M_viplong"]);
$M_sellerlong=intval($_POST["M_sellerlong"]);

if($M_login!="" && $M_pwd!=""){
	if(getrs("select * from sl_member where M_login='$M_login' and M_del=0","M_id")==""){
		mysqli_query($conn,"insert into sl_member(M_head,M_login,M_pwd,M_money,M_fen,M_email,M_regtime,M_pwdcode,M_openid,M_from,M_type,M_stop,M_stopinfo) values('$M_head','$M_login','".md5($M_pwd)."',$M_money,$M_fen,'$M_email','".date('Y-m-d H:i:s')."','','',$M_from,0,$M_stop,'$M_stopinfo')");
		$M_id=getrs("select * from sl_member where M_login='$M_login' and M_del=0","M_id");

		switch($M_viplong){
			case -1:
			mysqli_query($conn, "update sl_member set M_viplong=0,M_viptime='1970-01-01 00:00:00' where M_id=".$M_id);
			break;

			case 1:
			case 2:
			case 3:
			case 6:
			case 12:
			case 999:
			mysqli_query($conn, "update sl_member set M_viplong=".($M_viplong*31).",M_viptime='".date('Y-m-d H:i:s')."' where M_id=".$M_id);
			break;
		}

		switch($M_sellerlong){
			case -1:
			mysqli_query($conn, "update sl_member set M_type=0,M_sellerlong=0,M_sellertime='1970-01-01 00:00:00' where M_id=".$M_id);
			break;
			case 12:
			case 999:
			mysqli_query($conn, "update sl_member set M_type=1,M_sellerlong=".($M_sellerlong*31).",M_sellertime='".date('Y-m-d H:i:s')."' where M_id=".$M_id);
			break;
		}

		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增会员')");
		die("{\"msg\":\"success\",\"id\":\"".$M_id."\"}");
	}else{
		die("{\"msg\":\"已存在同名记录\"}");
	}
	
}else{
	die("{\"msg\":\"请填全信息\"}");
}

}

if($action=="edit"){
$M_head=$_POST["M_head"];
$M_login=$_POST["M_login"];
$M_pwd=$_POST["M_pwd"];
$M_from=intval($_POST["M_from"]);
$M_money=round($_POST["M_money"],2);
$M_fen=intval($_POST["M_fen"]);
$M_stop=intval($_POST["M_stop"]);
$M_email=$_POST["M_email"];
$M_stopinfo=$_POST["M_stopinfo"];
$M_viplong=intval($_POST["M_viplong"]);
$M_sellerlong=intval($_POST["M_sellerlong"]);

if($M_login!=""){
	mysqli_query($conn, "update sl_member set
	M_head='$M_head',
	M_login='$M_login',
	M_money=$M_money,
	M_fen=$M_fen,
	M_email='$M_email',
	M_stop=$M_stop,
	M_stopinfo='$M_stopinfo',
	M_from=$M_from
	where M_id=".$M_id);

	if($M_pwd!=""){
		mysqli_query($conn, "update sl_member set M_pwd='".md5($M_pwd)."' where M_id=".$M_id);
	}

	switch($M_viplong){
		case -1:
		mysqli_query($conn, "update sl_member set M_viplong=0,M_viptime='1970-01-01 00:00:00' where M_id=".$M_id);
		break;

		case 1:
		case 2:
		case 3:
		case 6:
		case 12:
		case 999:

		if($M_vip==1){//原本是VIP会员
			mysqli_query($conn, "update sl_member set M_viplong=M_viplong+".(31*$M_viplong)." where M_id=".$M_id);
		}else{//原本是普通会员
			mysqli_query($conn, "update sl_member set M_viplong=".($M_viplong*31).",M_viptime='".date('Y-m-d H:i:s')."' where M_id=".$M_id);
		}

		break;
	}

	switch($M_sellerlong){
		case -1:
		mysqli_query($conn, "update sl_member set M_type=0,M_sellerlong=0,M_sellertime='1970-01-01 00:00:00' where M_id=".$M_id);
		break;
		case 12:
		case 999:

		if($M_seller==1){//原本是VIP会员
			mysqli_query($conn, "update sl_member set M_type=1,M_sellerlong=M_sellerlong+".(31*$M_sellerlong)." where M_id=".$M_id);
		}else{//原本是普通会员
			mysqli_query($conn, "update sl_member set M_type=1,M_sellerlong=".($M_sellerlong*31).",M_sellertime='".date('Y-m-d H:i:s')."' where M_id=".$M_id);
		}

		break;
	}

	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑会员')");
	die("{\"msg\":\"success\",\"id\":\"".$M_id."\"}");
}else{
	die("{\"msg\":\"请填全信息\"}");
}
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_member set M_del=1 where M_id=".intval($id[$i]));
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

$sql="select count(M_id) as M_count from sl_member where M_del=0 and M_type=$type";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_counts=$row["M_count"];
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title.$type_info?> - 后台管理</title>

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

		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">

		<script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 100px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 300px}
		.list-group a{text-decoration:none}
		.part{display:inline-block;width:23%;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;}

.buy label {
	padding: 1px 5px;
	cursor: pointer;
	border: #CCCCCC solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

.buy .checked {
	border: #ff0000 solid 2px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	color: #ff0000;
}

.buy input[type="radio"] {
	display: none;
}
.vip{font-weight: bold;color: #ff0000}
.stop{font-weight: bold;color: #DDDDDD}
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
					<a href="member.php" class="btn btn-primary pull-right" style="z-index: 2;position: relative;margin-right: 5px;"><i class="fa fa-plus-circle"></i> 新增会员</a>
					<form class="input-group pull-right" style="width: 300px;z-index: 2;position: relative;margin-right: 5px;" method="post" action="?action=search">
	                    <input type="text" class="form-control" name="keyword" value="<?php echo t($_POST["keyword"])?>" placeholder="搜索会员">
	                    <span class="input-group-btn">
	                        <button class="btn btn-info" type="form"><i class="fa fa-search"></i> 搜索</button>
	                    </span>
	                </form>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $type_info?>管理</li>
                        </ol>


						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-5">
									<form id="list">
									<div class="card card-primary">

										<div class="card-header">
											<h4><?php echo $type_info?>列表</h4>
										</div>
												<ul class="list-group">
													<li class="list-group-item " style="background: #f7f7f7"><div class="part"><?php echo $type_info?>ID-帐号</div><div class="part">邮箱</div><div class="part">余额</div><div class="part">店铺名称</div></li>
													<?php 

								if($action=="search"){
									$sql="select * from sl_member where M_del=0 and not M_login='未登录帐号' and (M_login like '%".t($_POST["keyword"])."%' or M_email like '%".t($_POST["keyword"])."%') order by M_id desc";
								}else{
									$sql="select * from sl_member where M_del=0 and not M_login='未登录帐号' and M_type=$type order by M_id desc limit ".(($page-1)*20).",20";
								}

																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["M_id"]==$M_id){
																		$active="active";
																	}else{
																		$active="";
																	}

																	$M_viptime=$row["M_viptime"];
																	$M_viplong=$row["M_viplong"];

																	if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
																		$M_vip=" <img src=\"img/vip.png\" height=\"20\">";
																		$vipclass="vip";
																	}else{
																		if($row["M_stop"]==1){
																			$M_vip="[封]";
																			$vipclass="stop";
																		}else{
																			$M_vip="";
																			$vipclass="";
																		}
																	}

																	echo "<a id=\"".$row["M_id"]."\" href=\"?M_id=".$row["M_id"]."&type=".$type."\" class=\"list-group-item ".$active."\">
																	<div class=\"part ".$vipclass."\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row["M_id"]."\"> ".$row["M_id"]."-".htmlspecialchars($row["M_login"]).$M_vip."</div> 
																	<div class=\"part\">".htmlspecialchars($row["M_email"])."</div>
																	<div class=\"part\">".$row["M_money"]."元</div>
																	<div class=\"part\">".$row["M_shop"]."</div>
																	<img src=\"".pic2($row["M_head"])."\" alt=\"<img src='".pic2($row["M_head"])."' width='300'>\" style=\"height:25px;border-radius:10px;\" class=\"pull-right\"></a>";
																}
															}
													?>
													
												</ul>
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<a href="member.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增<?php echo $type_info?></a>
									<ul class="pagination" id="pagination" style="float: right;"></ul>
<?php if($action!="search"){?>	
		<input type="hidden" id="PageCount" runat="server" />
        <input type="hidden" id="PageSize" runat="server" value="20" />
        <input type="hidden" id="countindex" runat="server" value="20"/>
        <!--设置最多显示的页码数 可以手动设置 默认为7-->
        <input type="hidden" id="visiblePages" runat="server" value="7" />
<?php }?>
								</form>
								</div>
								<?php if($action!="menu" && $action!="search"){?>
								
								<div class="col-lg-7">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4><?php echo $title?><?php echo $type_info?></h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" ><?php echo $type_info?>帐号</label>
													<div class="col-md-9">
														<input type="text"  name="M_login" class="form-control" value="<?php echo htmlspecialchars($M_login)?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ><?php echo $type_info?>密码</label>
													<div class="col-md-9">
														<input type="text" name="M_pwd" class="form-control" value="" placeholder="<?php
														if($M_id!=""){
															echo "留空则不修改密码";
														}
														?>">
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ><?php echo $type_info?>头像</label>
													<div class="col-md-9">
														<p><img src="<?php echo pic2($M_head)?>" id="M_headx" class="showpic" onClick="showUpload('M_head','M_head','../media',1,null,'','');" alt="<img src='<?php echo pic2($M_head)?>' class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="M_head" name="M_head" class="form-control" value="<?php echo $M_head?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('M_head','M_head','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ><?php echo $type_info?>邮箱</label>
													<div class="col-md-9">
														<input type="text"  name="M_email" class="form-control" value="<?php echo $M_email?>">
													</div>
												</div>

												<div class="form-group row" >
													<label class="col-md-3 col-form-label" ><?php echo $type_info?>类型</label>
													<div class="col-md-9 buy">
														<div style="font-weight: bold;margin-top: 7px"><?php echo $M_sellertitle?></div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >开通商户</label>
													<div class="col-md-9">
														<select name="M_sellerlong" class="form-control">
															<option value="0">不变动商户状态</option>
															<option value="12">开通一年商户</option>
															<option value="999">开通永久商户</option>
															<option value="-1">恢复到会员用户</option>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >会员VIP</label>
													<div class="col-md-9">
														<div style="font-weight: bold;margin-top: 7px"><?php echo $M_viptitle?></div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >开通VIP</label>
													<div class="col-md-9">
														<select name="M_viplong" class="form-control">
															<option value="0">不变动会员状态</option>
															<option value="1">增加1个月VIP会员</option>
															<option value="2">增加2个月VIP会员</option>
															<option value="3">增加3个月VIP会员</option>
															<option value="6">增加6个月VIP会员</option>
															<option value="12">增加12个月VIP会员</option>
															<option value="999">开通永久VIP会员</option>
															<option value="-1">恢复到普通会员</option>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >账户余额</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="M_money" class="form-control" value="<?php echo $M_money?>">
														<span class="input-group-addon">元</span>
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ><?php echo $type_info?>积分</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text" name="M_fen" class="form-control" value="<?php echo $M_fen?>">
														<span class="input-group-addon">分</span>
														</div>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*会员每消费1元获得1积分，100积分兑换1元</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >上级会员</label>
													<div class="col-md-9">
														<input type="text"  name="M_from" class="form-control" value="<?php echo $M_from?>">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*填写会员ID编号，0则表示无上级</div>
													</div>
													
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >账户状态</label>
													<div class="col-md-9" style="padding-top: 7px">
														<label><input type="radio" value="0" name="M_stop" <?php if($M_stop==0){echo "checked='checked'";}?>> 正常</label>
														<label><input type="radio" value="1" name="M_stop" <?php if($M_stop==1){echo "checked='checked'";}?>> 封停</label>
													</div>
													
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >封停原因</label>
													<div class="col-md-9">
														<textarea name="M_stopinfo" class="form-control"><?php echo $M_stopinfo?></textarea>
													</div>
													
												</div>


												<div class="form-group row">
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
            $("#PageCount").val("<?php echo $M_counts?>");
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
                window.location="member.php?action=menu&type=<?php echo $type?>&page="+num;
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
            		setTimeout("window.location.href='member.php?M_id="+data.id+"'", 2000 )
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
$(function() { $('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});});
		</script>
		
	</body>
</html>
