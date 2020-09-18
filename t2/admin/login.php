<?php
require '../conn/conn.php';
require '../conn/function.php';

if($_GET["action"]=="unlogin"){
	$_SESSION["A_id"]="";
	$_SESSION["A_login"]="";
	$_SESSION["A_pwd"]="";
	mysqli_query($conn,"insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','退出后台')");
	Header("Location:login.php");
    die();
}

if(getrs("select * from sl_admin where A_login='".$_SESSION["A_login"]."' and A_pwd='".$_SESSION["A_pwd"]."' and A_del=0","A_id")!=""){
	Header("Location: index.php");
    die();
}

if($_GET["action"]=="login"){
	$A_login=t($_POST["A_login"]);
	$A_pwd=$_POST["A_pwd"];
    $M_code = $_POST["M_code"];
    $M_emailcode = $_POST["M_emailcode"];
    $L_add = removexss($_POST["add"]);

    if($fmid>0){
    	die("{\"code\":\"error2\",\"msg\":\"分站域名不支持登录后台\"}");
    }else{
	    if((xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0)!=$_SESSION["CmsCode"] || $_POST["M_code"]=="" || $_SESSION["CmsCode"]=="") && $C_slide==1){
	        die("{\"code\":\"error2\",\"msg\":\"验证码错误\"}");
	    } else {//滑块验证通过
	        $sql = "select * from sl_admin where A_login='" . $A_login . "' and A_pwd='" . md5($A_pwd) . "' and A_del=0";
	        $result = mysqli_query($conn, $sql);
	        $row = mysqli_fetch_assoc($result);
	        if (mysqli_num_rows($result) > 0) {//用户名密码正确

	            $sql2="select * from sl_log where L_title='后台登录成功' and L_del=0 order by L_id desc limit 1";
				$result = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result);
				if (mysqli_num_rows($result) > 0) {
					$L_ip=$row2["L_ip"];
				}else{
					$L_ip="";
				}

				if($C_twice==1 && $L_ip!=getip() && $C_email!=""){//开启了二次验证 && 登录IP有变动
					if($M_emailcode=="" || $M_emailcode=="undefined"){//没有传入邮箱验证码
						$code=rand(111111, 999999);
						mysqli_query($conn,"update sl_config set C_pwdcode='".$code."'");
						sendmail("邮箱验证码[".$code."]","您正在进行帐号登录，邮箱验证码为：<b>".$code."</b>，如果不是您的操作请及时修改密码。<br>用户位置：".$L_add."<br>登录IP地址：".getip(),$C_email);
						if($C_dx2==1){
							sendsms("【".$C_smssign."】后台验证码为".$code."；10分钟内有效,请尽快验证！",$C_mobile);
						}
						mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$row["A_id"].",'".date('Y-m-d H:i:s')."','".$L_add."','".getip()."','验证登录邮箱')");
						die("{\"code\":\"error3\",\"msg\":\"登录IP发生变动，请到邮箱【".$C_email."】查收验证码\"}");
					}else{//传入了邮箱验证码
						if($M_emailcode!=$C_pwdcode){//邮箱验证码错误
							mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$row["A_id"].",'".date('Y-m-d H:i:s')."','".$L_add."','".getip()."','邮箱验证码填写错误')");
							die("{\"code\":\"error3\",\"msg\":\"邮箱验证码有误，请重新填写\"}");
						}else{//邮箱验证码正确
							$check="success";
						}
					}
				}else{//没有触发二次验证
					$check="success";
				}

				if($check=="success"){

					$_SESSION["A_id"] = $row["A_id"];
		        	$_SESSION["A_login"] = $row["A_login"];
		        	$_SESSION["A_pwd"] = $row["A_pwd"];
		        	$_SESSION["A_head"] = $row["A_head"];
		        	$_SESSION["add"] = $L_add;

		            @removeDir("../conn/plug");  //更新插件
		            @mkdir("../conn/plug",0777,true);

		            $info=getbody("http://access.fahuo100.cn/api/index.php?action=checkauth","domain=$C_domain&authcode=$C_authcode");
		            if($info=="success"){
		            	$_SESSION["auth"]="auth";
		            }

		            //清理数据库备份，仅保留10天
		            $handler = opendir('../backup');
		            while( ($FileName = readdir($handler)) !== false ) {
		                if(is_file("../backup/".$FileName)){  
		                    if(time()-filemtime("../backup/".$FileName)>864000 && substr($FileName,-11)=="_backup.sql"){
		                        unlink("../backup/".$FileName);
		                    }
		                }
		            }

		            //备份数据库
		            if($C_backup==1 && is_dir("../backup")){
		                $q1 = mysqli_query($conn, "show tables");
		                while ($t = mysqli_fetch_array($q1)) {
		                    $table = $t[0];
		                    
		                    $q2 = mysqli_query($conn, "show create table `$table`");
		                    $sql = mysqli_fetch_array($q2);
		                    $mysql.= "DROP TABLE IF EXISTS `$table`" . ";\r\n" . $sql['Create Table'] . ";\r\n";
		                    $q3 = mysqli_query($conn, "select * from `$table`");
		                    while ($data = mysqli_fetch_assoc($q3)) {
		                        $keys = array_keys($data);
		                        $keys = array_map('addslashes', $keys);
		                        $keys = join('`,`', $keys);
		                        $keys = "`" . $keys . "`";
		                        $vals = array_values($data);
		                        $vals = array_map('addslashes', $vals);
		                        $vals = join("','", $vals);
		                        $vals = "'" . $vals . "'";
		                        $mysql.= "insert into `$table`($keys) values($vals);\r\n";
		                    }
		                
		                }
		                $mysql = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $mysql);
		                $mysql = "-- 备份时间：" . date('Y-m-d H:i:s') . " 域名：" . $_SERVER["HTTP_HOST"] . " 备份者：" . $_SESSION["A_login"] . " 程序版本：" . file_get_contents("version.txt") . " 电脑端：" . $C_template . " 手机端：" . $C_wap . " --;\r\n" . $mysql;
		                @file_put_contents("../backup/" . gen_key(20) . "_backup.sql", $mysql);
		            }

		            mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$L_add."','".getip()."','后台登录成功')");
		            die("{\"code\":\"success\",\"msg\":\"成功\"}");
		        }

	        } else {//用户名密码错误
	        	mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(0,'".date('Y-m-d H:i:s')."','".$L_add."','".getip()."','后台登录失败')");
	            die("{\"code\":\"error2\",\"msg\":\"用户名或密码错误\"}");
	        }
	    }
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>后台登录</title>
		
		<!--Favicon -->
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

		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">

	</head>

	<body class="bg-primary">
		<div id="app">
			<section class="section section-2">
                <div class="container">
					<div class="row">
						<div class="single-page single-pageimage construction-bg cover-image " data-image-src="https://shanlingtest.oss-cn-shenzhen.aliyuncs.com/7pay/assets/img/news/img14.jpg">
							<div class="row">
								<div class="col-lg-6">
									<div class="wrapper wrapper2">
										<form class="card-body" tabindex="500" id="form" onsubmit="login();return false;">
											<h3>管理员登录</h3>

											<div class="mail">
												<input type="text" name="A_login">
												<label>账号</label>
											</div>
											<div class="passwd">
												<input type="password" name="A_pwd">
												<input type="hidden" name="add">
												<label>密码</label>
											</div>

											<div class="passwd" id="emailcode" style="display: none">
												<input type="text" name="M_emailcode">
												<label>邮箱验证码</label>
											</div>

											<?php if($C_slide==1){
												echo "<div class=\"passwd\">
												<iframe id=\"slide\" src=\"../conn/code_1.php?name=M_code\" scrolling=\"no\" frameborder=\"0\" width=\"100%\" height=\"40\"></iframe>
											</div>";
											}?>
											
											<div class="submit">
												<button class="btn btn-primary btn-block" type="submit" type="button">登录</button>
											</div>
											
											
										</form>
										<!--
										<div class="card-body border-top">
											<a class="btn  btn-social btn-facebook btn-block"><i class="fa fa-facebook"></i> Sign in with Facebook</a>
											<a class="btn  btn-social btn-google btn-block mt-2"><i class="fa fa-google-plus"></i> Sign in with Google</a>
										</div>
										-->
									</div>
								</div>
								<div class="col-lg-6">
									<div class="log-wrapper text-center">
										
										<p style="margin-top: 20px;">我得到的每一份支持， 都是我坚定前行的动力。</p>
										<p>期待为您服务</p>
										
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</section>
		</div>

<!-- Large Modal -->
				<div id="myModal" class="modal fade">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content ">
							
							<div class="modal-body pd-20" id="modal-body">
								
							</div><!-- modal-body -->
							
						</div>
					</div><!-- modal-dialog -->
				</div><!-- modal -->



				<script src="assets/js/jquery.min.js"></script>

		<!--popper js-->
		<script src="assets/js/popper.js"></script>

		<!--Tooltip js-->
		<script src="assets/js/tooltip.js"></script>

		<!--Bootstrap.min js-->
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		
		<script src="assets/js/moment.min.js"></script>

		<!--mCustomScrollbar js-->
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!--Sidemenu js-->
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>

		<!--Scripts js-->
		<script src="assets/js/scripts.js"></script>
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>
		<script src="https://pv.sohu.com/cityjson?ie=utf-8"></script>
<script>
			$("[name='add']").val(returnCitySN.cname);
			function login(){
				toastr.warning('请稍等...','');
				$.ajax({
	            url:'login.php?action=login',
	            type:'post',
	            data:$("#form").serialize(),
	            success:function (data) {
	            	toastr.clear();
	            	data=JSON.parse(data);

	            	if(data.code=="success"){
	            		toastr.success('登录成功，即将进入会员中心', '成功');
	            		window.location='index.php';
	            	}

	            	if(data.code=="error3"){
	            		$("#emailcode").show();
	            		toastr.error(data.msg, '错误');
	            	}

	            	if(data.code=="error2"){
	            		toastr.error(data.msg, '错误');
	            	}

	            	if(data.code=="error1"){
	            		$("#modal-body").html("<iframe scrolling='no' type='1' frameborder='0' src='checkmail.php' width='100%' height='450'></iframe>");
	            		$('#myModal').modal('show');
	            	}
	            }
	            });
			}
		//document.getElementById('slide').contentWindow.location.reload(true);
		</script>
	</body>
</html>