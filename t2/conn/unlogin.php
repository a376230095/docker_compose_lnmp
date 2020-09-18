<?php
require '../conn/conn.php';
require '../conn/function.php';

$type=$_GET["type"];
$from=$_GET["from"];
$genkey=t($_REQUEST["genkey"]);
$id=intval($_GET["id"]);
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/conn",0);

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
	$M_vip=1;
	if($M_viplong>30000){
		$N_discount=$C_n_discount2/10;
		$P_discount=$C_p_discount2/10;
	}else{
		$N_discount=$C_n_discount/10;
		$P_discount=$C_p_discount/10;
	}
	$vip_pic="<img src=\"../member/img/vip.png\" style=\"margin-left:5px;height:17px;\">";
}else{
	$M_vip=0;
	$N_discount=1;
	$P_discount=1;
	$vip_pic="";
}

$M_info="
<img src=\"../media/$M_head\" style=\"width:30px;height:30px;border-radius:10px\">
<div style=\"display:inline-block;vertical-align:top;font-size:12px;margin-left:10px;\"> <b>$M_login</b>$vip_pic<br>$login</div>";

if(isMobile()){
	$port_info="?port_type=wap";
}else{
	$port_info="";
}

if($type=="news"){
	$sql="select * from sl_news where N_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$O_mid=$row["N_mid"];
	$O_title=$row["N_title"]."-付费阅读";
	$O_price=$row["N_price"]*$N_discount;
	$O_pic=$row["N_pic"];
	$info="支付成功后，文章页面将自动刷新并显示全部内容，在这之前请不要关闭页面";
	$email="<p><div class=\"input-group\"><span class=\"input-group-addon\">电子邮箱</span><input class=\"form-control\" name=\"email\" placeholder=\"电子邮箱\" value=\"$M_email\" required></div></p>";
	if($row["N_sh"]==0){
		box("本文章尚未通过审核，请稍候购买！","back","error");
	}
	if($O_mid==$M_id){
		box("不支持购买自己的文章","back","error");
	}
	
}

if($type=="product"){
	$sql="select * from sl_product where P_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$O_mid=$row["P_mid"];
	$O_title=$row["P_title"]."-购买";
	$O_price=$row["P_price"]*$P_discount;
	$O_pic=splitx($row["P_pic"],"|",0);
	$P_selltype=$row["P_selltype"];
	$P_sell=$row["P_sell"];
	
	if($row["P_sh"]==0){
		box("本商品尚未通过审核，请稍候购买！","back","error");
	}
	if($O_mid==$M_id){
		box("不支持购买自己的商品","back","error");
	}

	switch ($row["P_selltype"]) {
		case 0:
		$P_rest=1;
		$P_resttitle="充足";
		break;

		case 1:
		$P_rest=getrs("select count(C_id) as C_count from sl_card where C_del=0 and C_sort=".intval($row["P_sell"])." and C_use=0","C_count");
		$P_resttitle=$P_rest."件";
		break;

		case 2:
		$P_rest=$row["P_rest"];
		$P_resttitle=$P_rest."件";
		break;
	}
	
	if($row["P_selltype"]==2){
		$email="<p><input class=\"form-control\"  name=\"email[]\" value=\"\" placeholder=\"收件人\" required></p><p><input class=\"form-control\"  name=\"email[]\" value=\"\" placeholder=\"手机号码\" required></p><p><textarea class=\"form-control\" placeholder=\"收件地址\" name=\"email[]\" required></textarea></p>";
		$info="该商品为实物商品，支付成功后，由商家手动发货";
	}else{
		$email="<p><div class=\"input-group\"><span class=\"input-group-addon\">电子邮箱</span><input class=\"form-control\" id=\"email\" name=\"email\" value=\"$M_email\" placeholder=\"电子邮箱\" required></div></p>";
		$info="该商品为虚拟商品，支付成功后，商品将自动发送到您的电子邮箱";
	}

	if($O_price==0){
		$no=1;
		switch($P_selltype){
	  	case 0:
	  		$O_content=$P_sell;
	  	break;
	  	case 1:
	  		for($i=0;$i<$no;$i++){
				$C_id=getrs("select * from sl_card where C_del=0 and C_use=0 and C_sort=".intval($P_sell),"C_id");
				$C_content=getrs("select * from sl_card where C_id=".intval($C_id),"C_content");
				if($C_content==""){
					$O_content=$O_content."商品缺货，请联系客服||";
				}else{
					$O_content=$O_content.$C_content."||";
				}
				mysqli_query($conn,"update sl_card set C_use=1 where C_id=".intval($C_id));
			}
			$O_content=substr($O_content,0,strlen($O_content)-2);
	  	break;
	  	case 2:
		  	if($address==0){
		  		box("请先完善您的收货信息","member/address.php","error");
		  	}else{
		  		mysqli_query($conn,"update sl_product set P_rest=P_rest-1 where P_id=$id");
		  		$O_content="实物商品，由商家手动发货";
		  	}
	  	break;
	  }

	  	mysqli_query($conn, "update sl_product set P_sold=P_sold+$no where P_id=$id");
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(1,'".date('YmdHis').rand(10000000,99999999)."','购买商品-".$O_title."','".date('Y-m-d H:i:s')."',0,'$genkey')");
		mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey) values($id,1,'".date('Y-m-d H:i:s')."',0,0,1,'".$O_content."','$O_title','$O_pic','免费商品，无需邮箱',1,'$genkey')");
		Header("Location: ?type=fahuo&id=$id&genkey=$genkey");
		die();
	}

}
if($type=="checkbuy"){
	$O_id=getrs("select * from sl_orders where O_content='".t($genkey)."' and O_nid=".$id,"O_id");
	if($O_id==""){
		die("0");
	}else{
		die("1");
	}
}

if($type=="check"){
	$L_id=getrs("select * from sl_list where L_genkey='".t($genkey)."'","L_id");
	if($L_id==""){
		die("0");
	}else{
		die("1");
	}
}

if($type=="fahuo"){
	$sql="select * from sl_orders where O_genkey='".t($genkey)."' and O_pid=".$id;
	
	$result = mysqli_query($conn,  $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		die('<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8"> 
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>发货内容</title>
			<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
			<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
			<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		</head>
		<body>
		<div class="container">
		<a href="../"><img src="../media/'.$C_logo.'" style="height:60px;margin:10px 0"></a>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">订单信息</h3>
				</div>
				<div class="panel-body">
					<p><img src="../media/'.$row["O_pic"].'" width="100"></p>
					<p>商品名称：'.$row["O_title"].'</p>
					<p>商品价格：'.$row["O_price"].'元</p>
					<p>购买数量：'.$row["O_num"].'件</p>
					<p>购买时间：'.$row["O_time"].'</p>
					<p>收件邮箱：'.$row["O_address"].'</p>
				</div>
			</div>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">发货内容</h3>
				</div>
				<div class="panel-body">
					'.str_replace('||','<br>',$row["O_content"]).'
				</div>
			</div>
		</div>

		</body>
		</html>');
	}else{
		die("未获取到发货内容，请联系客服");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>收银台</title>
	<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../js/qrcode.min.js"></script>
	<style type="text/css">
	a{color: #666666;}
	a:hover{color: #000000;text-decoration:none}
	</style>
	<script type="text/javascript">
	function isWeiXin(){
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true; // 是微信端
        } else {
            return false;
        }
    }
    <?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false && $_REQUEST["jsApiParameters"]!=""){?>
	function jsApiCall(){
		$type="<?php echo $type?>";

		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo stripslashes(str_replace("__", "\"", $_REQUEST["jsApiParameters"]))?>,
			function(res){
				if(res.err_msg.indexOf(":ok")>-1){
					if($type=="news"){
						window.location.href="../pay/7pay/return.php?type=news&id=<?php echo $id?>&genkey=<?php echo $genkey?>";
					}else{
						//alert("支付成功，请到邮箱查收发货内容");
						//window.location.href="../?type=productinfo&id=<?php echo $id?>";
						window.location.href="?type=fahuo&genkey=<?php echo $genkey?>&id=<?php echo $id?>";
					}
				}else{
					alert(res.err_msg);
				}
			}
		);
	}

	function callpay(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	callpay();

	<?php }?>
	</script>

</head>
<body style="background: #f7f7f7">
<div class="container" style="padding: 20px;background: #ffffff;margin-top: 10px;">
<div style="font-size: 18px"><a href="../"><img src="../media/<?php echo $C_logo?>" style="height: 40px;margin-right: 10px;padding-right: 10px;border-right: solid 1px #DDDDDD;"></a>收银台</div>
<div style="float: right;margin-top: -35px;">
<?php echo $M_info;?>
</div>
</div>

<div class="container" style="padding: 10px;background: #ffffff;margin-top: 10px;">
<ul id="myTab" class="nav nav-tabs">
	<?php if ($C_alipayon==1){?><li><a href="#alipay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/alipay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_wxpayon==1){?><li><a href="#wxpay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/weixin<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_7payon==1){?><li><a href="#7pay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/7pay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_codepayon==1){?><li><a href="#codepay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/codepay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_payjson==1){?><li><a href="#payjs" data-toggle="tab" style="padding: 10px;"><img src="../member/img/payjs<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($M_id>1){?><li><a href="#money" data-toggle="tab" style="padding: 10px;"><img src="../member/img/money<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
</ul>
<div id="myTabContent" class="tab-content" style="padding: 20px;">
<img src="../media/<?php echo $O_pic?>" style="width:100%;max-width: 340px;border-radius: 5px;padding: 5px;border:solid 1px #DDDDDD;margin-bottom: 20px;">
	<?php if ($C_alipayon==1){?><div class="tab-pane fade" id="alipay">
		<form action="../pay/alipay/alipayapi.php<?php echo $port_info?>" method="post" class="buy">
				<p>标题：<b><?php echo $O_title;?></b></p>
				<p>价格：<span style="font-size: 25px;color: #ff0000"><?php echo $O_price;?>元<?php echo $vip_pic?></span></p>

				<?php if($type=="product"){?>
				<div style="margin-bottom: 10px;">数量：
					<div style="width: 120px;display: inline-block;vertical-align:middle; ">
						<div class="input-group input-group-sm">
							<span class="input-group-btn">
								<button class="btn btn-info" type="button" onClick="javascript:if(this.form.amount.value>=2){this.form.amount.value--;}">-</button>
							</span>
							<input type="number" name="num" value='1' class="form-control" id='amount' min='1' max='<?php echo $P_rest?>'>

							<span class="input-group-btn">
								<button class="btn btn-info" type="button" onClick="javascript:if(this.form.amount.value<<?php echo $P_rest?>){this.form.amount.value++;}">+</button>
							</span>
						</div>
					</div>
				（库存：<?php echo $P_resttitle?>）
				</div>
				<?php }?>
				<p>方式：<img src="../member/img/alipay.png" height="25"></p>
				<p>说明：<span style="font-size: 12px;color: #999999"><?php echo $info?></span></p>
				<p><?php echo $email?></p>
				<p><button class="btn btn-info" type="submit">立即支付</button></p>
				<input type="hidden" value="<?php echo $genkey?>" name="genkey">
				<input type="hidden" value="<?php echo $id?>" name="id">
				<input type="hidden" name="M_id" value="<?php echo $M_id?>">
				<input type="hidden" value="<?php echo $type?>" name="type">
		</form>
	</div><?php }?>

	<?php if ($C_wxpayon==1){?><div class="tab-pane fade" id="wxpay">
		<form action="" method="post" id="wxpay_form" class="buy">
			<p>标题：<b><?php echo $O_title;?></b></p>
			<p>价格：<span style="font-size: 25px;color: #ff0000"><?php echo $O_price;?>元<?php echo $vip_pic?></span></p>
			<?php if($type=="product"){?>
			<div style="margin-bottom: 10px;">数量：
					<div style="width: 120px;display: inline-block;vertical-align:middle; ">
						<div class="input-group input-group-sm">
							<span class="input-group-btn">
								<button class="btn btn-success" type="button" onClick="javascript:if(this.form.amount2.value>=2){this.form.amount2.value--;}">-</button>
							</span>
							<input type="number" name="num" value='1' class="form-control" id='amount2' min='1' max='<?php echo $P_rest?>'>
							<span class="input-group-btn">
								<button class="btn btn-success" type="button" onClick="javascript:if(this.form.amount2.value<<?php echo $P_rest?>){this.form.amount2.value++;}">+</button>
							</span>
						</div>
					</div>
				（库存：<?php echo $P_resttitle?>）
				</div>
				<?php }?>
			<p>方式：<img src="../member/img/weixin.png" height="25"></p>
			<p>说明：<span style="font-size: 12px;color: #999999"><?php echo $info?></span></p>
			<p><?php echo $email?></p>
			<p id="wx_btn"><button class="btn btn-success" type="button" onclick="qr()">立即支付</button></p>
			<p><div id="billImage" style="display: inline-block;width: 150px;height: 150px;"></div></p>
			<input type="hidden" value="<?php echo $genkey?>" name="genkey">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" name="M_id" value="<?php echo $M_id?>">
			<input type="hidden" value="<?php echo $type?>" name="type">
		</form>
	</div><?php }?>

	<?php if ($C_7payon==1){?><div class="tab-pane fade" id="7pay">
		<form action="../pay/7pay/api.php?action=unlogin" method="post" id="7pay_form" class="buy">
			<p>标题：<b><?php echo $O_title;?></b></p>
			<p>价格：<span style="font-size: 25px;color: #ff0000"><?php echo $O_price;?>元<?php echo $vip_pic?></span></p>
			<?php if($type=="product"){?>
			<div style="margin-bottom: 10px;">数量：
					<div style="width: 120px;display: inline-block;vertical-align:middle; ">
						<div class="input-group input-group-sm">
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" onClick="javascript:if(this.form.amount.value>=2){this.form.amount.value--;}">-</button>
							</span>
							<input type="number" name="num" value='1' class="form-control" id='amount' min='1' max='<?php echo $P_rest?>'>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="button" onClick="javascript:if(this.form.amount.value<<?php echo $P_rest?>){this.form.amount.value++;}">+</button>
							</span>
						</div>
					</div>
				（库存：<?php echo $P_resttitle?>）
				</div>
				<?php }?>
			<p>方式：<img src="../member/img/7pay.png" height="25"></p>
			<p>说明：<span style="font-size: 12px;color: #999999"><?php echo $info?></span></p>
			<p><?php echo $email?></p>
			<p id="wx_btn"><button class="btn btn-primary" type="submit">立即支付</button></p>

			<input type="hidden" value="<?php echo $genkey?>" name="genkey">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" name="M_id" value="<?php echo $M_id?>">
			<input type="hidden" value="<?php echo $type?>" name="type">
		</form>
	</div><?php }?>


	<?php if ($C_codepayon==1){?><div class="tab-pane fade" id="codepay">
		<form action="../pay/codepay/api.php?action=unlogin" method="post" id="7pay_form" class="buy">
			<p>标题：<b><?php echo $O_title;?></b></p>
			<p>价格：<span style="font-size: 25px;color: #ff0000"><?php echo $O_price;?>元<?php echo $vip_pic?></span></p>
			<?php if($type=="product"){?>
			<div style="margin-bottom: 10px;">数量：
					<div style="width: 120px;display: inline-block;vertical-align:middle; ">
						<div class="input-group input-group-sm">
							<span class="input-group-btn">
								<button class="btn btn-warning" type="button" onClick="javascript:if(this.form.amount.value>=2){this.form.amount.value--;}">-</button>
							</span>
							<input type="number" name="num" value='1' class="form-control" id='amount' min='1' max='<?php echo $P_rest?>'>
							<span class="input-group-btn">
								<button class="btn btn-warning" type="button" onClick="javascript:if(this.form.amount.value<<?php echo $P_rest?>){this.form.amount.value++;}">+</button>
							</span>
						</div>
					</div>
				（库存：<?php echo $P_resttitle?>）
				</div>
				<?php }?>
			<p>方式：
				<label><input type="radio" value="1" name="paytype" checked="checked"><img src="../member/img/alipay.png" height="25"></label>
				
				<label><input type="radio" value="3" name="paytype" > <img src="../member/img/weixin.png" height="25"></label>
				<label><input type="radio" value="2" name="paytype" ><img src="../member/img/qqpay.jpg" height="25"></label> </p>
			<p>说明：<span style="font-size: 12px;color: #999999"><?php echo $info?></span></p>
			<p><?php echo $email?></p>
			<p id="wx_btn"><button class="btn btn-warning" type="submit">立即支付</button></p>

			<input type="hidden" value="<?php echo $genkey?>" name="genkey">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" name="M_id" value="<?php echo $M_id?>">
			<input type="hidden" value="<?php echo $type?>" name="type">
		</form>
	</div><?php }?>

	<?php if ($C_payjson==1){?><div class="tab-pane fade" id="payjs">
		<form action="" method="post" id="payjs_form" class="buy">
			<p>标题：<b><?php echo $O_title;?></b></p>
			<p>价格：<span style="font-size: 25px;color: #ff0000"><?php echo $O_price;?>元<?php echo $vip_pic?></span></p>
			<?php if($type=="product"){?>
			<div style="margin-bottom: 10px;">数量：
					<div style="width: 120px;display: inline-block;vertical-align:middle; ">
						<div class="input-group input-group-sm">
							<span class="input-group-btn">
								<button class="btn btn-success" type="button" onClick="javascript:if(this.form.amount2.value>=2){this.form.amount2.value--;}">-</button>
							</span>
							<input type="number" name="num" value='1' class="form-control" id='amount2' min='1' max='<?php echo $P_rest?>'>
							<span class="input-group-btn">
								<button class="btn btn-success" type="button" onClick="javascript:if(this.form.amount2.value<<?php echo $P_rest?>){this.form.amount2.value++;}">+</button>
							</span>
						</div>
					</div>
				（库存：<?php echo $P_resttitle?>）
				</div>
				<?php }?>
			<p>方式：<img src="../member/img/weixin.png" height="25"></p>
			<p>说明：<span style="font-size: 12px;color: #999999"><?php echo $info?></span></p>
			<p><?php echo $email?></p>
			<p id="payjs_btn"><button class="btn btn-success" type="button" onclick="payjs()">立即支付</button></p>
			<p><div id="billImage2" style="display: inline-block;width: 150px;height: 150px;"></div></p>
			<input type="hidden" value="<?php echo $genkey?>" name="genkey">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" name="M_id" value="<?php echo $M_id?>">
			<input type="hidden" value="<?php echo $type?>" name="type">
		</form>
	</div><?php }?>

	<?php if ($M_id>1){?><div class="tab-pane fade" id="money">
		<form action="../pay/money/api.php?action=unlogin" method="post" id="7pay_form" class="buy" onsubmit="money()">
			<p>标题：<b><?php echo $O_title;?></b></p>
			<p>价格：<span style="font-size: 25px;color: #ff0000"><?php echo $O_price;?>元<?php echo $vip_pic?></span></p>
			<p>余额：<?php echo $M_money?>元</p>
			<?php if($type=="product"){?>
			<div style="margin-bottom: 10px;">数量：
					<div style="width: 120px;display: inline-block;vertical-align:middle; ">
						<div class="input-group input-group-sm">
							<span class="input-group-btn">
								<button class="btn btn-warning" type="button" onClick="javascript:if(this.form.amount.value>=2){this.form.amount.value--;}">-</button>
							</span>
							<input type="number" name="num" value='1' class="form-control" id='amount' min='1' max='<?php echo $P_rest?>'>
							<span class="input-group-btn">
								<button class="btn btn-warning" type="button" onClick="javascript:if(this.form.amount.value<<?php echo $P_rest?>){this.form.amount.value++;}">+</button>
							</span>
						</div>
					</div>
				（库存：<?php echo $P_resttitle?>）
				</div>
				<?php }?>
			<p>方式：<img src="../member/img/money.png" height="25"></p>
			<p>说明：<span style="font-size: 12px;color: #999999"><?php echo $info?></span></p>
			<p><?php echo $email?></p>
			<p id="wx_btn"><button class="btn btn-warning" type="submit" id="money_btn">立即支付</button></p>

			<input type="hidden" value="<?php echo $genkey?>" name="genkey">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" name="M_id" value="<?php echo $M_id?>">
			<input type="hidden" value="<?php echo $type?>" name="type">
		</form>
	</div><?php }?>
	
</div>
</div>
<script type="text/javascript">
function qr(){
	if(isWeiXin()){
		$email=$("#wxpay_form #email").val();
		$num=$("#amount2").val();
		//alert($email);
		window.location.href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $C_wx_appid?>&redirect_uri="+encodeURIComponent("http://<?php echo $D_domain?>/pay/wxpay/jsapi.php?genkey=<?php echo $genkey?>&id=<?php echo $id?>&M_id=<?php echo $M_id?>&type=<?php echo $type?>&email="+$email+"&num="+$num)+"&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect";
	}else{
		$.ajax({
	        type: "post",
	        url: "../pay/wxpay/native.php",
	        data: $("#wxpay_form").serialize(),
	        success: function(data) {
				if(data.indexOf("weixin://") != -1){
					$("#wx_btn").hide();
		            var qrcode = new QRCode('billImage', {width: 150,height: 150,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
		            qrcode.makeCode(data);
		            setInterval("check()",3000);
				}else{
					if(data.indexOf("https://") != -1){
						setInterval("check()",3000);
						window.location.href=data;
					}else{
						alert(data);
					}
				}
	        }
	    })
	}
}

function payjs(){
	if(isWeiXin()){
		$email=$("#payjs_form #email").val();
		$num=$("#amount2").val();
		//alert($email);

		window.location.href="https://payjs.cn/api/openid?mchid<?php echo $C_payjs_id?>&callback_url="+encodeURIComponent("http://<?php echo $D_domain?>/pay/payjs/jsapi.php?genkey=<?php echo $genkey?>&id=<?php echo $id?>&M_id=<?php echo $M_id?>&type=<?php echo $type?>&email="+$email+"&num="+$num);

	}else{
		$.ajax({
	        type: "post",
	        url: "../pay/payjs/native.php",
	        data: $("#payjs_form").serialize(),
	        success: function(data) {
				$("#payjs_btn").hide();
	            var qrcode = new QRCode('billImage2', {width: 150,height: 150,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
	            qrcode.makeCode(data);
	            setInterval("check()",3000);
	        }
	    })
	}
}

function check(){
	$type="<?php echo $type?>";
	$.post("?type=check",
    {
      genkey:"<?php echo $genkey?>",
    },
  function(data){
  if(data==1){
  	if($type=="news"){
  		window.location.href="../pay/7pay/return.php?type=news&id=<?php echo $id?>&genkey=<?php echo $genkey?>";
  	}
  	if($type=="product"){
  		//alert("支付成功，请到邮箱查收发货内容");
  		window.location.href="?type=fahuo&genkey=<?php echo $genkey?>&id=<?php echo $id?>";
  	}
  }
    });
}

function money(){
	$("#money_btn").html("请稍候...");
	$("#money_btn").attr("disabled",true);
}

$("#myTab").find("li:first").attr("class","active");
$("#myTabContent").find("div:first").attr("class","tab-pane fade in active");
</script>
</body>
</html>