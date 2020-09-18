<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$page=$_GET["page"];
$action=$_GET["action"];
$T_id=intval($_GET["T_id"]);

if($page==""){
	$page=1;
}

if($T_id!=""){
	$aa="edit&T_id=".$T_id;
	$sql="select * from sl_text where T_id=".$T_id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$T_pic=$row["T_pic"];
		$T_title=$row["T_title"];
		$T_order=$row["T_order"];
		$T_content=$row["T_content"];
		$T_type=$row["T_type"];
		$T_zb=$row["T_zb"];
		$T_address=$row["T_address"];
		$T_keywords=$row["T_keywords"];
		$T_description=$row["T_description"];
	}
	$title="编辑";
}else{
	$T_pic="nopic.png";
	$aa="add";
	$title="新增";
	$T_type=0;
}

if($action=="add"){
	$T_pic=$_POST["T_pic"];
	$T_title=$_POST["T_title"];
	$T_order=intval($_POST["T_order"]);
	$T_content=$_POST["T_content"];
	$T_zb=$_POST["T_zb"];
	$T_address=$_POST["T_address"];
	$T_keywords=$_POST["T_keywords"];
	$T_description=$_POST["T_description"];
	$T_type=intval($_POST["T_type"]);

	if($C_osson==1){
		editor2oss($T_content);
	}

	if($T_title!=""){
		if(getrs("select * from sl_text where T_title='$T_title' and T_del=0","T_id")==""){
			mysqli_query($conn,"insert into sl_text(T_pic,T_title,T_order,T_content,T_type,T_zb,T_address,T_keywords,T_description) values('$T_pic','$T_title',$T_order,'$T_content',$T_type,'$T_zb','$T_address','$T_keywords','$T_description')");
			$T_id=getrs("select * from sl_text where T_title='$T_title' and T_del=0","T_id");
			mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','新增单页')");
			die("{\"msg\":\"success\",\"id\":\"".$T_id."\"}");
		}else{
			die("{\"msg\":\"已存在同名记录\"}");
		}
	}else{
		die("{\"msg\":\"请填全信息\"}");
	}
}

if($action=="edit"){
$T_pic=$_POST["T_pic"];
$T_title=$_POST["T_title"];
$T_order=intval($_POST["T_order"]);
$T_content=$_POST["T_content"];
$T_zb=$_POST["T_zb"];
$T_address=$_POST["T_address"];
$T_type=intval($_POST["T_type"]);
$T_keywords=$_POST["T_keywords"];
$T_description=$_POST["T_description"];

if($C_osson==1){
	editor2oss($T_content);
}

if($T_title!=""){
mysqli_query($conn, "update sl_text set
	T_pic='$T_pic',
	T_title='$T_title',
	T_order=$T_order,
	T_content='$T_content',
	T_zb='$T_zb',
	T_address='$T_address',
	T_keywords='$T_keywords',
	T_description='$T_description',
	T_type=$T_type
	where T_id=".$T_id);
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑单页')");
	die("{\"msg\":\"success\",\"id\":\"".$T_id."\"}");
}else{
	die("{\"msg\":\"请填全信息\"}");
}
}

if($action=="delall"){
	$id=$_POST["id"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"update sl_text set T_del=1 where T_type=0 and T_id=".intval($id[$i]));
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','批量删除单页')");
			die("{\"msg\":\"success\",\"ids\":\"".$ids."\"}");
		} else {
			die("{\"msg\":\"删除失败\"}");
		}
	} else {
		die("{\"msg\":\"未选择要删除的内容\"}");
	}
}

$sql="select count(T_id) as T_count from sl_text where T_del=0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$T_counts=$row["T_count"];
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title?>单页 - 后台管理</title>

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
                            <li class="breadcrumb-item active" aria-current="page">单页管理</li>
                        </ol>


						<div class="section-body ">
							
							<div class="row">
								
								<div class="col-lg-4">
									<form id="list">
									<div class="card card-primary">

										<div class="card-header">
											<h4>单页列表</h4>
										</div>
												<ul class="list-group">
													<li class="list-group-item " style="background: #f7f7f7"><div class="part">标题</div><div class="part">类型</div></li>
													<?php 
														$sql="select * from sl_text where T_del=0 order by T_order,T_id desc limit ".(($page-1)*20).",20";
																$result = mysqli_query($conn, $sql);
																if (mysqli_num_rows($result) > 0) {
																while($row = mysqli_fetch_assoc($result)) {
																	if($row["T_id"]==$T_id){
																		$active="active";
																	}else{
																		$active="";
																	}
																	switch($row["T_type"]){
																		case 0:
																		$type="普通单页";
																		break;
																		case 1:
																		$type="联系方式";
																		break;
																		case 2:
																		$type="在线留言";
																		break;
																	}
																	echo "<a id=\"".$row["T_id"]."\" href=\"?T_id=".$row["T_id"]."\" class=\"list-group-item ".$active."\">
																	<div class=\"part\"><input type=\"checkbox\" name=\"id[]\" value=\"".$row["T_id"]."\"> ".$row["T_order"].".".$row["T_title"]."</div> 
																	<div class=\"part\">".$type."</div>
																	
																	<img src=\"".pic2($row["T_pic"])."\" alt=\"<img src='".pic2($row["T_pic"])."' width='300'>\" style=\"height:25px;border-radius:10px;\" class=\"pull-right\"></a>";
																}
															}
													?>
													
												</ul>
									</div>
									<label><input type="checkbox" id="selectAll" name="selectAll"> 全选</label>
									<button class="btn btn-sm btn-danger" type="button" onClick="delall()"><i class="fa fa-times-circle" ></i> 删除所选</button>
									<a href="text.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> 新增单页</a>
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
											<h4><?php echo $title?>单页</h4>
										</div>
										<div class="card-body">
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >单页标题</label>
													<div class="col-md-9">
														<input type="text"  name="T_title" class="form-control" value="<?php echo $T_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >单页排序</label>
													<div class="col-md-9">
														<input type="text"  name="T_order" class="form-control" value="<?php echo $T_order?>" placeholder="数字越小，排序越靠前">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >单页配图</label>
													<div class="col-md-9">
														<p><img src="<?php echo pic2($T_pic)?>" id="T_picx" class="showpic" onClick="showUpload('T_pic','T_pic','../media',1,null,'','');" alt="<img src='<?php echo pic2($T_pic)?>' class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="T_pic" name="T_pic" class="form-control" value="<?php echo $T_pic?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('T_pic','T_pic','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row" >
													<label class="col-md-3 col-form-label" >单页类型</label>
													<div class="col-md-9 buy"">
														<label aa="T_type" <?php if($T_type==0){echo "class='checked'";}?>><input type="radio" name="T_type" value="0" onclick="change(0)" <?php if($T_type==0){echo "checked='checked'";}?>> 普通单页</label>
														<label aa="T_type" <?php if($T_type==1){echo "class='checked'";}?>><input type="radio" name="T_type" value="1" onclick="change(1)" <?php if($T_type==1){echo "checked='checked'";}?>> 联系方式</label>
														<label aa="T_type" <?php if($T_type==2){echo "class='checked'";}?>><input type="radio" name="T_type" value="2" onclick="change(2)" <?php if($T_type==2){echo "checked='checked'";}?>> 在线留言</label>
													</div>
												</div>

												<div id="contact">
													<div class="form-group row">
														<label class="col-md-3 col-form-label" >地图坐标</label>
														<div class="col-md-9">
															<input type="text"  name="T_zb" class="form-control" value="<?php echo $T_zb?>">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-md-3 col-form-label" >地图位置</label>
														<div class="col-md-9">
															<input type="text"  name="T_address" class="form-control" value="<?php echo $T_address?>">
														</div>
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >SEO关键词</label>
													<div class="col-md-9">
														<input type="text"  name="T_keywords" class="form-control" value="<?php echo $T_keywords?>" placeholder="多个词用,隔开">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >SEO描述</label>
													<div class="col-md-9">
														<textarea name="T_description" class="form-control" ><?php echo $T_description?></textarea>
													</div>
												</div>
												<hr>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >单页内容</label>
													<div class="col-md-9">
														<script charset='utf-8' src='../kindeditor/kindeditor-all-min.js'></script>
		                                                <script charset='utf-8' src='../kindeditor/lang/zh-CN.js'></script>
		                                                <script>KindEditor.ready(function(K) {window.editor = K.create('#content', {uploadJson : '../kindeditor/php/upload_json.php', fileManagerJson : '../kindeditor/php/file_manager_json.php',allowFileManager : true,items:[
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
         'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
] });});</script>
		                                                <textarea name='T_content' style='width:100%;height:350px;' id='content'><?php echo $T_content?></textarea>
														
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

		var $T_type=<?php echo $T_type?>;
		if($T_type==1){
			$("#contact").show();
		}else{
			$("#contact").hide();
		}

		function change(id){
			if(id==1){
				$("#contact").show();
			}else{
				$("#contact").hide();
			}
		}


		function loadData(num) {
            $("#PageCount").val("<?php echo $T_counts?>");
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
                window.location="text.php?page="+num;
            }
        }
    });
}
$(function () {
    loadData(<?php echo $page?>);
    loadpage(<?php echo $page?>);

});

		function save(){
			editor.sync();
				$.ajax({
            	url:'?action=<?php echo $aa?>',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            	data=JSON.parse(data);
            	if(data.msg=="success"){
            		toastr.success("保存成功，2秒后刷新", "成功");
            		setTimeout("window.location.href='text.php?T_id="+data.id+"'", 2000 )
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
