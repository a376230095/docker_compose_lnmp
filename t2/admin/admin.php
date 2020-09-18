<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$A_id=intval($_GET["A_id"]);

if($A_id!=""){
	$aa="edit&A_id=".$A_id;
	$sql="select * from sl_admin where A_id=".$A_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$A_head=$row["A_head"];
		$A_login=$row["A_login"];
		$A_part=$row["A_part"];
		$A0_0=splitx(splitx($A_part,"A0_0:",1),",",0);
		$A1_0=splitx(splitx($A_part,"A1_0:",1),",",0);
		$A1_1=splitx(splitx($A_part,"A1_1:",1),",",0);
		$A1_2=splitx(splitx($A_part,"A1_2:",1),",",0);
		$A1_3=splitx(splitx($A_part,"A1_3:",1),",",0);
		$A1_4=splitx(splitx($A_part,"A1_4:",1),",",0);
		$A1_5=splitx(splitx($A_part,"A1_5:",1),",",0);
		$A2_0=splitx(splitx($A_part,"A2_0:",1),",",0);
		$A2_1=splitx(splitx($A_part,"A2_1:",1),",",0);
		$A2_2=splitx(splitx($A_part,"A2_2:",1),",",0);
		$A2_3=splitx(splitx($A_part,"A2_3:",1),",",0);
		$A3_0=splitx(splitx($A_part,"A3_0:",1),",",0);
		$A3_1=splitx(splitx($A_part,"A3_1:",1),",",0);
		$A3_2=splitx(splitx($A_part,"A3_2:",1),",",0);
		$A3_3=splitx(splitx($A_part,"A3_3:",1),",",0);
		$A3_4=splitx(splitx($A_part,"A3_4:",1),",",0);
		$A4_0=splitx(splitx($A_part,"A4_0:",1),",",0);
		$A4_1=splitx(splitx($A_part,"A4_1:",1),",",0);
		$A4_2=splitx(splitx($A_part,"A4_2:",1),",",0);
		$A5_0=splitx(splitx($A_part,"A5_0:",1),",",0);
		$A5_1=splitx(splitx($A_part,"A5_1:",1),",",0);
		$A5_2=splitx(splitx($A_part,"A5_2:",1),",",0);
		$A5_3=splitx(splitx($A_part,"A5_3:",1),",",0);
		$A6_0=splitx(splitx($A_part,"A6_0:",1),",",0);
	}
	$title="编辑";
}else{
	$A_head="nopic.png";
	$aa="add";
	$title="新增";
}

if($action=="add"){
	if($A4_0x==0){
		die("{\"msg\":\"您的帐号不支持新增管理员！\"}");
	}

	$A_head=$_POST["A_head"];
	$A_login=$_POST["A_login"];
	$A_pwd=$_POST["A_pwd"];

	$A0_0=intval($_POST["A0_0"]);
	$A1_0=intval($_POST["A1_0"]);
	$A1_1=intval($_POST["A1_1"]);
	$A1_2=intval($_POST["A1_2"]);
	$A1_3=intval($_POST["A1_3"]);
	$A1_4=intval($_POST["A1_4"]);
	$A1_5=intval($_POST["A1_5"]);
	$A2_0=intval($_POST["A2_0"]);
	$A2_1=intval($_POST["A2_1"]);
	$A2_2=intval($_POST["A2_2"]);
	$A2_3=intval($_POST["A2_3"]);
	$A3_0=intval($_POST["A3_0"]);
	$A3_1=intval($_POST["A3_1"]);
	$A3_2=intval($_POST["A3_2"]);
	$A3_3=intval($_POST["A3_3"]);
	$A3_4=intval($_POST["A3_4"]);
	$A4_0=intval($_POST["A4_0"]);
	$A4_1=intval($_POST["A4_1"]);
	$A4_2=intval($_POST["A4_2"]);
	$A5_0=intval($_POST["A5_0"]);
	$A5_1=intval($_POST["A5_1"]);
	$A5_2=intval($_POST["A5_2"]);
	$A5_3=intval($_POST["A5_3"]);
	$A6_0=intval($_POST["A6_0"]);
	$A_part="A0_0:$A0_0,A1_0:$A1_0,A1_1:$A1_1,A1_2:$A1_2,A1_3:$A1_3,A1_4:$A1_4,A1_5:$A1_5,A2_0:$A2_0,A2_1:$A2_1,A2_2:$A2_2,A2_3:$A2_3,A3_0:$A3_0,A3_1:$A3_1,A3_2:$A3_2,A3_3:$A3_3,A3_4:$A3_4,A4_0:$A4_0,A4_1:$A4_1,A4_2:$A4_2,A5_0:$A5_0,A5_1:$A5_1,A5_2:$A5_2,A5_3:$A5_3,A6_0:$A6_0,";

	if($A_login!="" && $A_pwd!=""){
		if(preg_match('/<|\(|\*|--|#| |\'|"|\.\//i', $A_login)){
			die("{\"msg\":\"用户名含有特殊字符，请重新输入\"}");
		}

		if(getrs("select * from sl_admin where A_login='$A_login' and A_del=0","A_id")==""){
			mysqli_query($conn,"insert into sl_admin(A_head,A_login,A_pwd,A_part) values('$A_head','$A_login','".md5($A_pwd)."','$A_part')");
			$A_id=getrs("select * from sl_admin where A_login='$A_login' and A_del=0","A_id");
			mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增管理员')");
			die("{\"msg\":\"success\",\"id\":\"".$A_id."\"}");
		}else{
			die("{\"msg\":\"已存在同名记录\"}");
		}
		
	}else{
		die("{\"msg\":\"请填全信息\"}");
	}
}

if($action=="edit"){
	if($A4_0x==0 && $_SESSION["A_id"]!=$A_id){
		die("{\"msg\":\"请勿编辑其他管理员！\"}");
	}

	$A_head=$_POST["A_head"];
	$A_login=$_POST["A_login"];
	$A_pwd=$_POST["A_pwd"];
	$A0_0=intval($_POST["A0_0"]);
	$A1_0=intval($_POST["A1_0"]);
	$A1_1=intval($_POST["A1_1"]);
	$A1_2=intval($_POST["A1_2"]);
	$A1_3=intval($_POST["A1_3"]);
	$A1_4=intval($_POST["A1_4"]);
	$A1_5=intval($_POST["A1_5"]);
	$A2_0=intval($_POST["A2_0"]);
	$A2_1=intval($_POST["A2_1"]);
	$A2_2=intval($_POST["A2_2"]);
	$A2_3=intval($_POST["A2_3"]);
	$A3_0=intval($_POST["A3_0"]);
	$A3_1=intval($_POST["A3_1"]);
	$A3_2=intval($_POST["A3_2"]);
	$A3_3=intval($_POST["A3_3"]);
	$A3_4=intval($_POST["A3_4"]);
	$A4_0=intval($_POST["A4_0"]);
	$A4_1=intval($_POST["A4_1"]);
	$A4_2=intval($_POST["A4_2"]);
	$A5_0=intval($_POST["A5_0"]);
	$A5_1=intval($_POST["A5_1"]);
	$A5_2=intval($_POST["A5_2"]);
	$A5_3=intval($_POST["A5_3"]);
	$A6_0=intval($_POST["A6_0"]);
	$A_part="A0_0:$A0_0,A1_0:$A1_0,A1_1:$A1_1,A1_2:$A1_2,A1_3:$A1_3,A1_4:$A1_4,A1_5:$A1_5,A2_0:$A2_0,A2_1:$A2_1,A2_2:$A2_2,A2_3:$A2_3,A3_0:$A3_0,A3_1:$A3_1,A3_2:$A3_2,A3_3:$A3_3,A3_4:$A3_4,A4_0:$A4_0,A4_1:$A4_1,A4_2:$A4_2,A5_0:$A5_0,A5_1:$A5_1,A5_2:$A5_2,A5_3:$A5_3,A6_0:$A6_0,";
	if($A_login!=""){
		if(preg_match('/<|\(|\*|--|#| |\'|"|\.\//i', $A_login)){
			die("{\"msg\":\"用户名含有特殊字符，请重新输入\"}");
		}
		if($A4_0x==1){
			if($A_pwd!=""){
				mysqli_query($conn, "update sl_admin set
				A_head='$A_head',
				A_login='$A_login',
				A_part='$A_part',
				A_pwd='".md5($A_pwd)."'
				where A_id=".$A_id);
			}else{
				mysqli_query($conn, "update sl_admin set
				A_head='$A_head',
				A_login='$A_login',
				A_part='$A_part'
				where A_id=".$A_id);
			}
		}else{
			if($A_pwd!=""){
				mysqli_query($conn, "update sl_admin set A_head='$A_head',A_pwd='".md5($A_pwd)."' where A_id=".$A_id);
			}else{
				mysqli_query($conn, "update sl_admin set A_head='$A_head' where A_id=".$A_id);
			}
		}
		
		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑管理员')");
		die("{\"msg\":\"success\",\"id\":\"".$A_id."\"}");
	}else{
		die("{\"msg\":\"请填全信息\"}");
	}
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_admin set A_del=1 where A_id=".intval($id[$i]));
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
		<title><?php echo $title?>管理员 - 后台管理</title>

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
		.part{display:inline-block;width:30%;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;}
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
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">管理员管理</li>
                        </ol>


						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-5">
									<form id="list">
									<div class="card card-primary">

										<div class="card-header">
											<h4>管理员列表</h4>
										</div>
												<ul class="list-group">
													<?php 
													if($A4_0x==1){
														$sql="select * from sl_admin where A_del=0 order by A_id desc limit 20";
													}else{
														$sql="select * from sl_admin where A_del=0 and A_id=".$_SESSION["A_id"];
													}
														
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["A_id"]==$A_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	echo "<a id=\"".$row["A_id"]."\" href=\"?A_id=".$row["A_id"]."\" class=\"list-group-item ".$active."\">
																	<div class=\"part\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row["A_id"]."\"> ".$row["A_login"]."</div> 
																	
																	<img src=\"".pic2($row["A_head"])."\" alt=\"<img src='".pic2($row["A_head"])."' width='300'>\" style=\"height:25px;border-radius:10px;\" class=\"pull-right\"></a>";
																}
															}
													?>
													
												</ul>
									</div>
									<?php if($A4_0x==1){?>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<a href="admin.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增管理员</a>
									<?php }?>
								</form>
								</div>
								<?php if($action!="menu"){?>
								
								<div class="col-lg-7">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4><?php echo $title?>管理员</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >管理员帐号</label>
													<div class="col-md-9">
														<?php if($A4_0x==1){?>
														<input type="text"  name="A_login" class="form-control" value="<?php echo $A_login?>">
														<?php }else{
															echo "<input type=\"hidden\"  name=\"A_login\" class=\"form-control\" value=\"".$A_login."\"><div style=\"margin-top:8px\">".$A_login."</div>";
														}
															?>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >管理员密码</label>
													<div class="col-md-9">
														<input type="text" name="A_pwd" class="form-control" value="" placeholder="<?php
														if($A_id!=""){
															echo "留空则不修改密码";
														}
														?>">
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >管理员头像</label>
													<div class="col-md-9">
														<p><img src="<?php echo pic2($A_head)?>" id="A_headx" class="showpic" onClick="showUpload('A_head','A_head','../media',1,null,'','');" alt="<img src='<?php echo pic2($A_head)?>' class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="A_head" name="A_head" class="form-control" value="<?php echo $A_head?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('A_head','A_head','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>
												<?php if($A4_0x==1){?>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >权限设置</label>
													<div class="col-md-9">
														<p>后台首页 → 
															<label><input type="checkbox" value="1" name="A0_0" <?php if($A0_0==1){echo "checked='checked'";}?>>后台首页</label></p>
														<p>系统设置 →
															<label><input type="checkbox" value="1" name="A1_0" <?php if($A1_0==1){echo "checked='checked'";}?>>基本设置</label> 
															<label><input type="checkbox" value="1" name="A1_1" <?php if($A1_1==1){echo "checked='checked'";}?>>VIP会员设置</label> 
															<label><input type="checkbox" value="1" name="A1_2" <?php if($A1_2==1){echo "checked='checked'";}?>>模板管理</label>
															<label><input type="checkbox" value="1" name="A1_3" <?php if($A1_3==1){echo "checked='checked'";}?>>焦点图管理</label>
															<label><input type="checkbox" value="1" name="A1_4" <?php if($A1_4==1){echo "checked='checked'";}?>>友链管理</label>
															<label><input type="checkbox" value="1" name="A1_5" <?php if($A1_5==1){echo "checked='checked'";}?>>菜单设置</label>
														</p>
														<p>内容管理 →
															<label><input type="checkbox" value="1" name="A2_0" <?php if($A2_0==1){echo "checked='checked'";}?>>单页管理</label> 
															<label><input type="checkbox" value="1" name="A2_1" <?php if($A2_1==1){echo "checked='checked'";}?>>商品管理</label> 
															<label><input type="checkbox" value="1" name="A2_2" <?php if($A2_2==1){echo "checked='checked'";}?>>文章管理</label>
															<label><input type="checkbox" value="1" name="A2_3" <?php if($A2_3==1){echo "checked='checked'";}?>>卡密管理</label>
														</p>
														<p>交易管理 →
															<label><input type="checkbox" value="1" name="A3_0" <?php if($A3_0==1){echo "checked='checked'";}?>>订单管理</label> 
															<label><input type="checkbox" value="1" name="A3_1" <?php if($A3_1==1){echo "checked='checked'";}?>>评价管理</label> 
															<label><input type="checkbox" value="1" name="A3_2" <?php if($A3_2==1){echo "checked='checked'";}?>>资金明细</label>
															<label><input type="checkbox" value="1" name="A3_3" <?php if($A3_3==1){echo "checked='checked'";}?>>货源采购</label>
															<label><input type="checkbox" value="1" name="A3_4" <?php if($A3_4==1){echo "checked='checked'";}?>>会员卡充值</label>
														</p>
														<p>账户管理 →
															<label><input type="checkbox" value="1" name="A4_0" <?php if($A4_0==1){echo "checked='checked'";}?>><span style="color: #ff0000">管理员管理</span></label> 
															<label><input type="checkbox" value="1" name="A4_1" <?php if($A4_1==1){echo "checked='checked'";}?>>会员管理</label> 
															<label><input type="checkbox" value="1" name="A4_2" <?php if($A4_2==1){echo "checked='checked'";}?>>商家管理</label>
														</p>
														<p>其他设置 →
															<label><input type="checkbox" value="1" name="A5_0" <?php if($A5_0==1){echo "checked='checked'";}?>>操作日志</label> 
															<label><input type="checkbox" value="1" name="A5_1" <?php if($A5_1==1){echo "checked='checked'";}?>>回收站</label> 
															<label><input type="checkbox" value="1" name="A5_2" <?php if($A5_2==1){echo "checked='checked'";}?>>留言管理</label>
															<label><input type="checkbox" value="1" name="A5_3" <?php if($A5_3==1){echo "checked='checked'";}?>>自定义设置</label>
														</p>
														<p>检测更新 → 
															<label><input type="checkbox" value="1" name="A6_0" <?php if($A6_0==1){echo "checked='checked'";}?>>检测更新</label></p>
															<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*说明：子管理员不要给“管理员管理”的权限</div>
													</div>
												</div>
												<?php }else{
													echo "<div class=\"form-group row\">
													<label class=\"col-md-3 col-form-label\" >权限说明</label>
													<div class=\"col-md-9\" style=\"padding-top:8px\">子管理员仅支持修改密码和头像</div></div>";
												}?>


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

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/help.js"></script>
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>

		<script type="text/javascript">
		function save(){
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		toastr.success("保存成功，2秒后刷新", "成功");
            		setTimeout("window.location.href='admin.php?A_id="+data.id+"'", 2000 )
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
