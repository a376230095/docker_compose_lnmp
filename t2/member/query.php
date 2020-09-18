<?php
require '../conn/conn.php';
require '../conn/function.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);

if($_SESSION["M_id"]==""){
	$M_id=1;
	$login="<a href=\"../member/login.php\">[登录]</a> <a href=\"../member/reg.php\">[注册]</a>";
}else{
	$M_id=intval($_SESSION["M_id"]);
	$login="<a href=\"../member/\">[会员中心]</a> <a href=\"../member/login.php?action=unlogin\">[退出]</a>";
}

$sql="select * from sl_member where M_id=$M_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_id=$row["M_id"];
$M_head=$row["M_head"];
$M_login=$row["M_login"];
$M_email=$row["M_email"];
if($M_id==1){
	$M_email="";
}
$M_money=$row["M_money"];
$M_viptime=$row["M_viptime"];
$M_viplong=$row["M_viplong"];

if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
	$vip_pic="<img src=\"../member/img/vip.png\" style=\"margin-left:5px;height:17px;\">";
}else{
	$vip_pic="";
}

$M_info="<img src=\"../media/$M_head\" style=\"width:30px;height:30px;border-radius:10px\">
<div style=\"display:inline-block;vertical-align:top;font-size:12px;margin-left:10px;\"> <b>$M_login</b>$vip_pic<br>$login</div>";

$action=$_GET["action"];
if($action=="query"){
	$no=t($_REQUEST["no"]);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>订单查询</title>
	<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../js/qrcode.min.js"></script>
	<style type="text/css">
	a{color: #666666;}
	a:hover{color: #000000;text-decoration:none}
	.containerx{width: 100%;max-width: 1000px;margin:0 auto;}
	</style>
</head>
<body style="background: #f7f7f7">
<div class="containerx" style="padding: 20px;background: #ffffff;margin-top: 10px;">
<div style="font-size: 18px"><a href="../"><img src="../media/<?php echo $C_logo?>" style="height: 40px;margin-right: 10px;padding-right: 10px;border-right: solid 1px #DDDDDD;"></a>订单查询</div>
<div style="float: right;margin-top: -35px;">
<?php echo $M_info;?>
</div>
</div>

<div class="containerx" style="padding: 10px;background: #ffffff;margin-top: 10px;">
	<form action="?action=query" method="post">
		<div class="input-group">
		    <input type="text" class="form-control" name="no" value="<?php echo $no;?>" placeholder="输入交易单号/订单号">
		    <span class="input-group-btn">
		        <button class="btn btn-primary" type="submit">查询订单</button>
		    </span>
		</div>
	</form>
</div>
<div class="containerx" style="padding: 10px;background: #ffffff;margin-top: 10px;">
	<?php
if($no!=""){
	$sql="select distinct(O_id),O_pic,O_title,O_price,O_num,O_time,O_address,L_no,O_content from sl_orders,sl_list where O_genkey=L_genkey and not O_genkey='' and (L_no='".t($no)."' or L_no2='".t($no)."')";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo '<div class="panel panel-primary" style="margin-top:20px;">
				<div class="panel-heading">
					<h3 class="panel-title">订单信息</h3>
				</div>
				<div class="panel-body">
					<p><img src="../media/'.splitx($row["O_pic"],"|",0).'" width="100"></p>
					<p>商品名称：'.$row["O_title"].'</p>
					<p>商品价格：'.$row["O_price"].'元</p>
					<p>购买数量：'.$row["O_num"].'件</p>
					<p>购买时间：'.$row["O_time"].'</p>
					<p>收件邮箱：'.str_replace("__"," ",$row["O_address"]).'</p>
					<p>订单编号：'.$row["L_no"].'</p>
				</div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">发货内容</h3>
				</div>
				<div class="panel-body">
					<textarea class="form-control" rows="5" id="content_copy">'.str_replace('||',PHP_EOL,$row["O_content"]).'</textarea>
					<button class="btn btn-info" style="margin-top:10px;" onclick="copy()">复制</button>
				</div>
			</div>';
		}
		echo '<script>
				function copy(){
					var e=document.getElementById("content_copy");
			        e.select();
			        document.execCommand("Copy");
			       alert("复制成功")
				}
			</script>';
	}else{
		die('<div class="panel panel-primary" style="margin-top:20px;">
				<div class="panel-heading">
					<h3 class="panel-title">订单信息</h3>
				</div>
				<div class="panel-body">
					未查询到订单，请重新输入！
				</div>
			</div>');
	}
}
	?>
	<div style="font-size:12px;margin-top:10px">请输入支付宝的交易单号或微信的订单号 <button class="btn btn-xs btn-info" type="button" data-toggle="modal" data-target="#myModal">查看示例</button></div>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">查看示例</h4>
            </div>
            <div class="modal-body"><img src="img/query.png" style="width: 100%"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
</body>
</html>