<?php
require '../conn/conn.php';
require '../conn/function.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);
$M_id=intval($_GET["M_id"]);

$show=$_REQUEST["show"];
$action=$_GET["action"];

if($action=="card"){
	$card=$_POST["card"];

	$sql = "select * from sl_rcard where R_content='".t($card)."' and R_use=0 and R_del=0";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    	$R_money=$row["R_money"];
    	$R_id=$row["R_id"];
    	mysqli_query($conn, "update sl_member set M_money=M_money+".round($R_money,2)." where M_id=".$M_id);
    	mysqli_query($conn, "update sl_rcard set R_use=1,R_usetime='".date('Y-m-d H:i:s')."',R_mid=".$M_id." where R_id=".intval($R_id));
    	mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'".gen_key(20)."','充值卡充值','".date('Y-m-d H:i:s')."',".round($R_money,2).",'".gen_key(20)."')");

		die(app_back("../my/my","充值成功！"));
    }else{
    	box("未找到该卡号或已使用，请重试！","back","error");
    }
}

if(isMobile()){
	$port_info="?port_type=wap";
}else{
	$port_info="";
}
$genkey=gen_key(20);
if ($show=="t"){
	
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<title>微信充值跳转</title>
<script src="js/jquery.min.js"></script>
<script src="../js/qrcode.min.js"></script>
<link href="https://qzonestyle.gtimg.cn/open_proj/proj_qcloud_v2/css/shop_cart/wechat_pay.css?v=201605201" rel="stylesheet" media="screen"/>
<script type="text/javascript" src="https://js.cdn.aliyun.dcloud.net.cn/dev/uni-app/uni.webview.1.5.2.js"></script>
</head>
<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico-wechat"></span><span class="text">微信支付</span>
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount">
            ￥<?php echo round($_REQUEST["wx_fee"],2)?>
        </div>
        <div class="qr-image" >
        	<div id="billImage" style="display: inline-block;width: 200px;height: 200px;"></div>

           
        </div>
        <!--detail-open 加上这个类是展示订单信息，不加不展示-->
        <div class="detail detail-open" id="orderDetail" >
            <dl class="detail-ct">
                <dt>商家</dt>
                <dd id="storeName"><?php echo $C_title?></dd>
                <dt>商品名称</dt>
                <dd id="productName">用户充值<?php echo $_REQUEST["wx_fee"]?>元</dd>
                <dt>交易单号</dt>
                <dd id="billId"><?php echo $genkey?></dd>
                <dt>创建时间</dt>
                <dd id="createTime"><?php echo date('Y-m-d H:i:s')?></dd>
            </dl>

        </div>
        <div class="tip">
            <span class="dec dec-left"></span>
            <span class="dec dec-right"></span>
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p>请使用微信扫一扫</p>
                <p>扫描二维码完成支付</p>
            </div>
        </div>
     </div>

</div>
<script type="text/javascript">
function test(){
$.post("post.php",
    {
      L_genkey:"<?php echo $genkey?>",
    },
 function(data){
  if(data==1){
  //document.location.href="list.php";
	document.addEventListener('UniAppJSBridgeReady', function(){
		uni.reLaunch({
			url: '../my/my'
		});
	});
  }
    });
}

$.ajax({
    type: "post",
    url: "../pay/<?php echo $_GET["type"]?>/native.php",
    data: {body:"用户充值<?php echo $_REQUEST["wx_fee"]?>元",attach:"<?php echo $_REQUEST["M_id"]."|".$genkey?>",total_fee:"<?php echo $_REQUEST["wx_fee"]?>"},
    success: function(data) {
		if(data.indexOf("weixin://") != -1){
            var qrcode = new QRCode('billImage', {width: 200,height: 200,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
            qrcode.makeCode(data);
            setInterval("test()",3000);
		}else{
			if(data.indexOf("https://") != -1){
				setInterval("test()",3000);
				window.location.href=data;
			}else{
				alert(data);
			}
		}
    }
})

</script>
</body>

</html>
<?php 
}else{

if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){
	if ($_REQUEST["jsApiParameters"]=="" && $_REQUEST["type"]=="jsapi"){
		Header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$C_wx_appid."&redirect_uri=".urlencode("http://".$D_domain."/pay/wxpay/jsapi.php?M_id=".$_SESSION["M_id"]."|".gen_key(20)."&fee=".$_REQUEST["fee"]."&page=pay.php")."&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect"); 
		die();
	}

	if ($_REQUEST["type"]=="jsapi_payjs"){
		Header("Location: https://payjs.cn/api/openid?mchid=".$C_payjs_id."&callback_url=".urlencode("http://".$D_domain."/pay/payjs/jsapi.php?M_id=".$_SESSION["M_id"]."|".gen_key(20)."&fee=".$_REQUEST["fee"]."&page=pay.php")); 
		die();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>账户充值</title>
	<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="../js/qrcode.min.js"></script>
	<style type="text/css">
	a{color: #666666;}
	a:hover{color: #000000;text-decoration:none}
	</style>
    <?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false && $_REQUEST["jsApiParameters"]!=""){?>
 <script type="text/javascript">
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo stripslashes(str_replace("__", "\"", $_REQUEST["jsApiParameters"]))?>,
			function(res){
				//WeixinJSBridge.log(res.err_msg);
				if(res.err_msg.indexOf(":ok")>-1){
					window.location.href="list.php";
				}
				//else{
				//	alert(res.err_msg);
				//}
				
			}
		);
	}

	function callpay()
	{
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
	</script>
<?php }?>

</head>
<body style="background: #f7f7f7;padding-top:0px ">
<div class="container" style="padding: 20px;background: #ffffff;margin-top: 10px;">
<div style="font-size: 18px"><a href="../"><img src="../media/<?php echo $C_logo?>" style="height: 40px;margin-right: 10px;padding-right: 10px;border-right: solid 1px #DDDDDD;"></a>账户充值</div>

</div>

<div class="container" style="padding: 10px;background: #ffffff;margin-top: 10px;">
<ul id="myTab" class="nav nav-tabs">
	<?php if ($C_alipayon==1){?><li><a href="#alipay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/alipay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_wxpayon==1){?><li><a href="#wxpay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/weixin<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_qpayon==1){?><li><a href="#qpay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/qqpay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_dmfon==1){?><li><a href="#dmf" data-toggle="tab" style="padding: 10px;"><img src="../member/img/dmf<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_7payon==1){?><li><a href="#7pay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/7pay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_codepayon==1){?><li><a href="#codepay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/codepay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_payjson==1){?><li><a href="#payjs" data-toggle="tab" style="padding: 10px;"><img src="../member/img/payjs<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<li><a href="#money" data-toggle="tab" style="padding: 10px;"><img src="../member/img/card<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li>
</ul>
<div id="myTabContent" class="tab-content" style="padding: 20px;">

	<?php if ($C_alipayon==1){?><div class="tab-pane fade" id="alipay">
		<form action="../pay/alipay/alipayapi.php<?php echo $port_info?>&from=app" method="post"  class="form-horizontal" id="form">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="fee"  value="<?php echo str_replace(",","",$_REQUEST["money"])?>" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="<?php echo $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>" name="M_url">
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style=" padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
		<p><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/alipay.png"></p>
		
	</div>
	</div>
</div>
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20"  value="付款"  />
	</div>
</div>
</form>
	</div><?php }?>

	<?php if ($C_wxpayon==1){?><div class="tab-pane fade" id="wxpay">
<form action="?show=t&type=wxpay&from=app" method="post" class="form-horizontal" id="form">
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="wx_fee" value="<?php echo $_REQUEST["money"]?>" id="wx_fee" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="<?php echo $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>" name="M_url">
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
	<p><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/weixin.png"></p>
	
		</div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
<?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){?>
<input type="button" class="btn btn-primary btn-block m_top_20" value="微信付款" onClick="location.href='?type=jsapi&fee='+$('#wx_fee').val()">
<?php }else{?>
	<input type="submit" class="btn btn-primary btn-block m_top_20" value="付款"  />
	<?php }?>
	</div>
</div>
</form>
	</div><?php }?>

	<?php if ($C_qpayon==1){?>
	<div class="tab-pane fade" id="qpay">
	<form action="" method="post" id="qpay_form" class="form-horizontal">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="total_fee" value="<?php echo $_REQUEST["money"]?>" id="wx_fee" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="账户充值" name="body">
	<input type="hidden" name="attach" value="<?php echo $M_id."|".$genkey?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
	<p><input type="radio" name="pay_type" checked="checked" > <img src="img/qqpay.png"></p>
		</div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
		<input type="button" class="btn btn-primary btn-block m_top_20" value="付款" onclick="qpay()" />
	</div>
</div>
</form>
	</div>


<?php }?>


	<?php if ($C_dmfon==1){?>
	<div class="tab-pane fade" id="dmf">
	<form action="" method="post" id="dmf_form" class="form-horizontal">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="total_fee" value="<?php echo $_REQUEST["money"]?>" id="wx_fee" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="账户充值" name="body">
	<input type="hidden" name="attach" value="<?php echo $M_id."|".$genkey?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
	<p><input type="radio" name="pay_type" checked="checked" > <img src="img/alipay.png"></p>
		</div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
		<input type="button" class="btn btn-primary btn-block m_top_20" value="付款" onclick="dmf()" />
	</div>
</div>
</form>
	</div>


<?php }?>
	<?php if ($C_7payon==1){?><div class="tab-pane fade" id="7pay">
		<form action="../pay/7pay/api.php?action=pay&from=app" method="post"  class="form-horizontal" id="form">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="fee"  value="<?php echo str_replace(",","",$_REQUEST["money"])?>" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style=" padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
		<p><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/7pay.png"></p>
		
	</div>
	</div>
</div>
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20"  value="付款"  />
	</div>
</div>
</form>
	</div><?php }?>


	<?php if ($C_codepayon==1){?><div class="tab-pane fade" id="codepay">
		<form action="../pay/codepay/api.php?action=pay&from=app" method="post"  class="form-horizontal" id="form">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="fee"  value="<?php echo str_replace(",","",$_REQUEST["money"])?>" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-10">
		<span id="codepaytype">
				<?php if(strpos($C_codepay_type,"alipay")!==false){
					echo "<label><input type=\"radio\" value=\"1\" name=\"paytype\"><img src=\"img/alipay.png\" height=\"25\"></label>";
				}?>
				<?php if(strpos($C_codepay_type,"wxpay")!==false){
					echo "<label><input type=\"radio\" value=\"3\" name=\"paytype\" > <img src=\"img/weixin.png\" height=\"25\"></label>";
				}?>
				<?php if(strpos($C_codepay_type,"qqpay")!==false){
					echo "<label><input type=\"radio\" value=\"2\" name=\"paytype\" ><img src=\"img/qqpay.jpg\" height=\"25\"></label>";
				}?>
			</span>
	</div>

</div>
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20"  value="付款"  />
	</div>
</div>
</form>
	</div><?php }?>

	<?php if ($C_payjson==1){?><div class="tab-pane fade" id="payjs">
		<form action="?show=t&type=payjs" method="post" class="form-horizontal" id="form">
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="wx_fee" value="<?php echo $_REQUEST["money"]?>" id="payjs_fee" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="<?php echo $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>" name="M_url">
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
	<p><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/payjs.png" style="height: 25px;"></p>
	
		</div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
<?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){?>
<input type="button" class="btn btn-primary btn-block m_top_20" value="微信付款" onClick="location.href='?type=jsapi_payjs&fee='+$('#payjs_fee').val()">
<?php }else{?>
	<input type="submit" class="btn btn-primary btn-block m_top_20" value="付款"  />
	<?php }?>
	</div>
</div>
</form>
	</div><?php }?>

	<div class="tab-pane fade" id="money">
		<form action="?action=card&M_id=<?php echo $M_id?>" method="post" class="form-horizontal" id="form">
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值卡号</label>
	<div class="col-sm-4">
	<input name="card" value="" class="form-control"  placeholder="" >
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">付款方式</label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;">
	<p><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/card.png"></p>
	
		</div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20" value="确定"  />
	</div>
</div>
</form>
	</div>
	
</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					扫码支付
				</h4>
			</div>
			<div class="modal-body" style="text-align: center;" id="modal_body">
				<img src="img/alipay.png" style="margin-bottom: 20px;" id="pay_img"><br>
				<div id="billImage" style="width: 200px;display: inline-block;margin-bottom: 10px"></div>
				<div id="pay_info">请使用支付宝扫码支付</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$("#myTab").find("li:first").attr("class","active");
$("#myTabContent").find("div:first").attr("class","tab-pane fade in active");
function dmf(){
	$.ajax({
        type: "post",
        url: "../pay/dmf/api.php",
        data: $("#dmf_form").serialize(),
        success: function(data) {
			if(data.indexOf("https://") != -1){
				if(IsPC()){
					$('#myModal').modal('show');
					$("#pay_img").attr("src","img/alipay.png");
					$("#pay_info").html("请使用支付宝扫码支付");
		            qrcode.makeCode(data);
				}else{
					$('#myModal').modal('show');
					$("#pay_img").attr("src","img/alipay.png");
					$("#pay_info").html("<a href='"+data+"' target='_blank' class='btn btn-info'>使用支付宝APP支付</a>");
		            qrcode.makeCode(data);
				}
			}else{
				alert("支付出错：请检查以下原因：（1）应用appid和应用私钥是否填写正确（2）是否开通了当面付这个产品（3）有无在应用里添加当面付这个产品（4）PHP版本需5.5或以上");
			}
        }
    })
}

function qpay(){
	$.ajax({
        type: "post",
        url: "../pay/qpay/native.php",
        data: $("#qpay_form").serialize(),
        success: function(data) {
			if(data.indexOf("https://") != -1){
				if(IsPC()){
					$('#myModal').modal('show');
					$("#pay_img").attr("src","img/qqpay.png");
					$("#pay_info").html("请使用手机QQ扫码支付");
		            qrcode.makeCode(data);
				}else{
					$('#myModal').modal('show');
					$("#pay_img").attr("src","img/qqpay.png");
					$("#pay_info").html("<a href='"+data+"' target='_blank' class='btn btn-info'>使用手机QQ支付</a>");
		            qrcode.makeCode(data);
				}
			}else{
				alert(data);
			}
        }
    })
}

function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
                "SymbianOS", "Windows Phone",
                "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}

function check(){
$.post("post.php",
    {
      L_genkey:"<?php echo $genkey?>",
    },
 function(data){
  if(data==1){
  document.location.href="list.php";
  }
    });
}

var qrcode = new QRCode('billImage', {width: 200,height: 200,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
setInterval("check()",3000);
$("#codepaytype").find("input:first").attr("checked","checked");
</script>
</body>
</html>
<?php }?>