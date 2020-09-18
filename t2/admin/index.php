<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$dir=str_replace("/", "\\",dirname(__FILE__));
if($_GET["action"]=="mod"){
  mysqli_query($conn,"update sl_config set C_admin='".splitx($dir,"\\",count(explode("\\",$dir))-1)."'");
  box("修复成功！","./","success");
}
if(splitx($dir,"\\",count(explode("\\",$dir))-1)!=$C_admin){
  die("系统检测到您手动修改过后台目录，请<a href='?action=mod'>点击此处</a>进行修复");
}

$sql="select sum(L_money) as L_all from sl_list,sl_member where L_del=0 and L_mid=M_id and L_money>0 and L_title like '%充值%' and to_days(L_time) = to_days(now())";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$L_all=round($row["L_all"],2);


$sql="select count(L_id) as L_all from sl_list,sl_member where L_del=0 and L_mid=M_id and L_money>0 and L_title like '%充值%' and to_days(L_time) = to_days(now())";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$L_all2=round($row["L_all"],2);


$sql="select sum(L_money) as L_all from sl_list,sl_member where L_del=0 and L_mid=M_id and L_money>0 and L_title like '%充值%' and DATE_FORMAT( L_time, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$L_all3=round($row["L_all"],2);


$sql="select count(L_id) as L_all from sl_list,sl_member where L_del=0 and L_mid=M_id and L_money>0 and L_title like '%充值%' and DATE_FORMAT( L_time, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$L_all4=round($row["L_all"],2);


for ($i=1;$i<=12;$i++){

$sql="select sum(L_money) as money_total from sl_list,sl_member where L_del=0 and L_mid=M_id and L_money>0 and L_title like '%充值%' and year(L_time)=".date('Y')." and month(L_time)=".$i;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$m_all=round($row["money_total"],2);
	if($m_all==""){
		$m_all=0;
	}
	$info=$info.$m_all.",";
	} 

for ($j=1;$j<=31;$j++){
$sql="select sum(L_money) as money_total from sl_list,sl_member where L_del=0 and L_mid=M_id and L_money>0 and L_title like '%充值%' and DATE_FORMAT( L_time, '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' ) and DAY(L_time)=".$j;

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$m_all2=round($row["money_total"],2);
	if ($m_all2==""){
		$m_all2=0;
	}
	$info2=$info2.$m_all2.",";
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>后台首页</title>

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

	<body class="app ">

		<div id="spinner"></div>

		<div id="app">
			<div class="main-wrapper" >
				
					<?php
					require 'nav.php';
					?>
				</aside>

				<div class="app-content">
					<a class="btn btn-primary pull-right" style="z-index: 2;position: relative;" href="wholesale.php"><i class="fa fa-shopping-cart"></i> 货源采购</a>
					<?php if(!checkauth()){?>
					<a class="btn btn-info pull-right" style="z-index: 2;position: relative;margin-right: 10px;" href="https://qm.qq.com/cgi-bin/qm/qr?k=3swmiy--f9CxM2HtKVWdHvl2UH_Qkumj&jump_from=webapi"><i class="fa fa-qq"></i> 交流群</a>
					<?php }else{?>
					<a class="btn btn-info pull-right" style="z-index: 2;position: relative;margin-right: 10px;" href="http://shang.qq.com/wpa/qunwpa?idkey=9c5ac8be3ccf266c4eaeca487d289807db31707de19d5e742949bb06be3636e4"><i class="fa fa-qq"></i> 售后群</a>
					<?php }?>
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台首页</a></li>
                            <li class="breadcrumb-item">版本：<?php
                        echo file_get_contents("version.txt");
                        $update=GetBody("http://106.12.118.146:83/php/update.txt","","GET");
                        $version=splitx($update,"|",0);

                        if(trim($version,"\xEF\xBB\xBF")!=trim(file_get_contents("version.txt"),"\xEF\xBB\xBF")){
                        	echo " <a class=\"btn btn-sm btn-info\" href=\"update.php\"><i class=\"fa fa-refresh\"></i> 检测更新</a>";
                        }

                        ?></li>
                        </ol>
                        

						<div class="row">
							<div class="col-xl-3 col-lg-6 col-sm-6 col-md-12">
								<div class="card">
									<div class="card-body knob-chart">
										<div class="row mb-0">
											<div class="col-6" style="font-size: 50px;text-align: center;">
												<i class="fa fa-cny"></i>
											</div>
											<div class="col-6">
												<div class="dash3 text-center">
													<small class="text-muted mt-0">今日交易额</small>
													<h2 class="text-dark mb-0">￥<?php echo $L_all?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-sm-6 col-md-12">
								<div class="card">
									<div class="card-body knob-chart">
										<div class="row mb-0">
											<div class="col-6" style="font-size: 50px;text-align: center;">
												<i class="fa fa-line-chart"></i>
											</div>
											<div class="col-6">
												<div class="dash3 text-center">
													<small class="text-muted mt-0">今日成交量</small>
													<h2 class="text-dark mb-0"><?php echo $L_all2?>次</h2>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-sm-6 col-md-12">
								<div class="card">
									<div class="card-body knob-chart">
										<div class="row mb-0">
											<div class="col-6" style="font-size: 50px;text-align: center;">
												<i class="fa fa-money"></i>
											</div>
											<div class="col-6">
												<div class="dash3 text-center">
													<small class="text-muted mt-0">本月交易额</small>
													<h2 class="text-dark mb-0">￥<?php echo $L_all3?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-sm-6 col-md-12">
								<div class="card">
									<div class="card-body knob-chart">
										<div class="row mb-0">
											<div class="col-6" style="font-size: 50px;text-align: center;">
												<i class="fa fa-bar-chart"></i>
											</div>
											<div class="col-6">
												<div class="dash3 text-center">
													<small class="text-muted mt-0">本月交易量</small>
													<h2 class="text-dark mb-0"><?php echo $L_all4?>次</h2>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						
						

						<div class="row ">
							<div class="col-lg-12 col-xl-6 col-md-12 col-12 col-sm-12">
								<div class="card">
									<div class="card-header">
										<h4>月度统计</h4>
									</div>
									<div class="card-body">
										<div id="main3" style="height:255px"></div>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-xl-6 col-md-12 col-12 col-sm-12">
								<div class="card">

										<div class="card-header">
											<h4>最新订单<div style="float: right;">
												<a href="orders_list.php" class="btn btn-info">更多</a>
											</div></h4>
										</div>
										<div class="card-body p-0">
											<div class="table-responsive">
												<table class="table table-striped mb-0 text-nowrap">
													<tr>
														<th>名称</th>
														<th>总价</th>
														<th>会员</th>
														<th>时间</th>
													</tr>

<?php

$sql="select * from sl_orders,sl_member where O_mid=M_id and O_del=0 and O_state>0 order by O_id desc limit 6";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

			if($row["M_viplong"]-(time()-strtotime($row["M_viptime"]))/86400>0){
				$M_vip=" <img src=\"img/vip.png\" height=\"20\">";
			}else{
				$M_vip="";
			}

			if($row["O_type"]==0){
				echo "<tr id='".$row["O_id"]."'><td><a href=\"../?type=productinfo&id=".$row["O_pid"]."\" target=\"_blank\">[商品] ".$row["O_title"]."</a></td><td>".$row["O_price"]." × ".$row["O_num"]." = ".($row["O_price"]*$row["O_num"])."元</td><td><a href=\"member.php?M_id=".$row["M_id"]."\"><i class=\"fa fa-user\"></i> ".$row["M_login"].$M_vip."</a></td><td>".$row["O_time"]."</td></tr>";
			}else{
				echo "<tr id='".$row["O_id"]."'><td><a href=\"../?type=newsinfo&id=".$row["O_nid"]."\" target=\"_blank\">[新闻] ".$row["O_title"]."</a></td><td>".$row["O_price"]." × ".$row["O_num"]." = ".($row["O_price"]*$row["O_num"])."元</td><td><a href=\"member.php?M_id=".$row["M_id"]."\"><i class=\"fa fa-user\"></i> ".$row["M_login"].$M_vip."</a></td><td>".$row["O_time"]."</td></tr>";
			}
		}
	}
?>
												</table>
											</div>
										</div>
									</div>
							</div>
						</div>
						

						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="card">
									<div class="card-header">
										<h4>日度统计</h4>
									</div>
									<div class="card-body">
										<div id="main4" style="height:250px"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
						<div class="col-lg-12">

									<div class="card">

										<div class="card-header">
											<h4>最新会员<div style="float: right;">
												<a href="member.php" class="btn btn-info">更多</a>
											</div></h4>
										</div>
										<div class="card-body p-0" style="height:140px; overflow:hidden;">
											
<?php

$sql="select * from sl_member where M_del=0 and not M_login='未登录帐号' order by M_id desc limit 20";
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
																		$M_vip="vip";
																	}else{
																		$M_vip="";
																	}
																	echo "<a href='member.php?M_id=".$row["M_id"]."'><div class='member_box'><img src='../media/".$row["M_head"]."'><p style='margin-top:5px;' class=\"".$M_vip."\"><b>".mb_substr(htmlspecialchars($row["M_login"]),0,20,"utf-8")."</b><br>".date("m-d",strtotime($row["M_regtime"]))."</p></div></a>";

																	
																}
															}

?>
									</div>
									</div>
								</div>
</div>
<?php if(!checkauth()){?>
				<div class="row">
							<div class="col-12 col-sm-12">
								<div class="card">
									<div class="card-header">
										<h4>广告区（授权后自动去除）</h4>
									</div>
									<div class="card-body">
										<a target="_blank" href="https://www.aliyun.com/activity/daily/bestoffer?spm=5176.11533457.1089570.41.4ad677e3J2U8kN&userCode=oguhd2dz"><img src="https://img.alicdn.com/tfs/TB1qnR3R1L2gK0jSZFmXXc7iXXa-440-240.jpg" height="100"></a>
										<a target="_blank" href="https://club.aliyun.com/?spm=5176.11533457.1089570.47.4ad677e3J2U8kN&userCode=oguhd2dz"><img src="https://img.alicdn.com/tfs/TB16PhYiBBh1e4jSZFhXXcC9VXa-880-480.png" height="100"></a>
										<a target="_blank" href="https://www.aliyun.com/database/dbfirstbuy?spm=5176.11533457.1089570.53.4ad677e3J2U8kN&userCode=oguhd2dz"><img src="https://img.alicdn.com/tfs/TB1a4HiQuL2gK0jSZPhXXahvXXa-440-240.png" height="100"></a>
										<a target="_blank" href="https://www.aliyun.com/daily-act/ecs/activity_selection?spm=5176.11533457.1089570.59.4ad677e3J2U8kN&userCode=oguhd2dz"><img src="https://img.alicdn.com/tfs/TB1EYNWOEH1gK0jSZSyXXXtlpXa-440-240.png" height="100"></a>
										<a target="_blank" href="https://yqh.aliyun.com/live/cdncarnival?spm=5176.11533457.1089570.65.4ad677e3J2U8kN&userCode=oguhd2dz"><img src="https://img.alicdn.com/tfs/TB1iRpff8Bh1e4jSZFhXXcC9VXa-440-240.png" height="100"></a>
									</div>
								</div>
							</div>
						</div>		
<?php }?>
					</section>
				</div>

			</div>
		</div>
		<style>
.member_box{display:inline-block;margin:10px;text-align: center;}
.member_box img{height:70px;width:70px;border-radius:100px;margin-bottom: 3px;border:solid 1px #EEEEEE;}
.member_box p{text-align: center;font-size: 12px;}
.vip{color: #ff0000}
</style>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="assets/js/help.js"></script>
<script src="assets/plugins/toastr/build/toastr.min.js"></script>
<script src="assets/js/echarts-all.js"></script>
<script type="text/javascript">

        var myChart3 = echarts.init(document.getElementById('main3')); 
        var myChart4 = echarts.init(document.getElementById('main4')); 
        
option4 = {
    title : {
        text: '',
        subtext: ''
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['成交']
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'成交',
            type:'line',
            smooth:true,
            itemStyle: {normal: {areaStyle: {type: 'default'}}},
            data:[<?php echo $info2?>]
        },
        
    ]
};
       

option3 = {
    title : {
        text: '',
        subtext: ''
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['成交']
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'成交',
            type:'line',
            smooth:true,
            itemStyle: {normal: {areaStyle: {type: 'default'}}},
            data:[<?php echo $info?>]
        },
        
    ]
};             



        myChart3.setOption(option3); 
        myChart4.setOption(option4); 
    </script>
	</body>
</html>
