<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$S_id=intval($_GET["S_id"]);
if($S_id!=""){
	$aa="edit&S_id=".$S_id;
	$sql="select * from sl_slide where S_id=".$S_id;

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$S_pic=$row["S_pic"];
		$S_order=$row["S_order"];
		$S_title=$row["S_title"];
		$S_content=$row["S_content"];
		$S_link=$row["S_link"];
	}
	$title="编辑";
}else{
	$S_pic="nopic.png";
	$aa="add";
	$title="新增";
}

if($action=="add"){
$S_pic=$_POST["S_pic"];
$S_order=intval($_POST["S_order"]);
$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];
$S_link=$_POST["S_link"];

if($S_title!=""){
	if(getrs("select * from sl_slide where S_title='$S_title' and S_del=0","S_id")==""){
		mysqli_query($conn,"insert into sl_slide(S_pic,S_order,S_title,S_content,S_link) values('$S_pic',$S_order,'$S_title','$S_content','$S_link')");
		$S_id=getrs("select * from sl_slide where S_title='$S_title' and S_del=0","S_id");
		mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增焦点图')");
		die("{\"msg\":\"success\",\"id\":\"".$S_id."\"}");
	}else{
		die("{\"msg\":\"已存在同名记录\"}");
	}
	
}else{
	die("{\"msg\":\"请填全信息\"}");
}

}

if($action=="edit"){
$S_pic=$_POST["S_pic"];
$S_order=intval($_POST["S_order"]);
$S_title=$_POST["S_title"];
$S_content=$_POST["S_content"];
$S_link=$_POST["S_link"];

if($S_title!=""){
	mysqli_query($conn, "update sl_slide set
	S_pic='$S_pic',
	S_title='$S_title',
	S_order=$S_order,
	S_content='$S_content',
	S_link='$S_link'
	where S_id=".$S_id);
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑焦点图')");
	die("{\"msg\":\"success\",\"id\":\"".$S_id."\"}");
}else{
	die("{\"msg\":\"请填全信息\"}");
}
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_slide set S_del=1 where S_id=".$id[$i]);
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除焦点图')");
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
		<title><?php echo $title?>焦点图 - 后台管理</title>

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
                            <li class="breadcrumb-item active" aria-current="page">焦点图管理</li>
                        </ol>


						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-5">
									<form id="list">
									<div class="card card-primary">

										<div class="card-header">
											<h4>焦点图列表</h4>

										</div>
										
												<ul class="list-group">
													<li class="list-group-item " style="background: #f7f7f7"><div class="part">标题</div><div class="part">链接到</div></li>
													<?php 
														$sql="select * from sl_slide where S_del=0 order by S_order asc,S_id desc limit 20";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["S_id"]==$S_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	echo "<a id=\"".$row["S_id"]."\" href=\"?S_id=".$row["S_id"]."\" class=\"list-group-item ".$active."\">
																	<div class=\"part\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row["S_id"]."\"> ".$row["S_order"].".".$row["S_title"]."</div> 
																	<div class=\"part\">".$row["S_link"]."</div>
																	<img src=\"".pic2($row["S_pic"])."\" alt=\"<img src='".pic2($row["S_pic"])."' class='showpicx'>\" style=\"height:25px;border-radius:10px;\" class=\"pull-right\"></a>";
																}
															}
													?>
													
												</ul>
											
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<a href="slide.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增焦点图</a>
								</form>
								</div>
								<?php if($action!="menu"){?>
								
								<div class="col-lg-7">
									<form id="form">
									<div class="card card-primary">
										<div class="card-header ">
											<h4><?php echo $title?>焦点图</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >焦点图标题</label>
													<div class="col-md-9">
														<input type="text"  name="S_title" class="form-control" value="<?php echo $S_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >焦点图排序</label>
													<div class="col-md-9">
														<input type="text"  name="S_order" class="form-control" value="<?php echo $S_order?>" placeholder="数字越小，排序越靠前">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >焦点图链接</label>
													<div class="col-md-9">
														<input type="text"  name="S_link" class="form-control" value="<?php echo $S_link?>">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*为兼容app和小程序，请填写绝对路径的链接</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >焦点图</label>
													<div class="col-md-9">
														<p><img src="<?php echo pic2($S_pic)?>" id="S_picx" class="showpic" onClick="showUpload('S_pic','S_pic','../media',1,null,'','');" alt="<img src='<?php echo pic2($S_pic)?>' class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="S_pic" name="S_pic" class="form-control" value="<?php echo $S_pic?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('S_pic','S_pic','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >焦点图描述</label>
													<div class="col-md-9">
														<textarea class="form-control" rows="3" name="S_content"><?php echo $S_content?></textarea>
														
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
		function save(){
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		toastr.success("保存成功，2秒后刷新", "成功");
            		setTimeout("window.location.href='slide.php?S_id="+data.id+"'", 2000 )
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
