<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);

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
    	box("成功充值".$R_money."元！","list.php","success");
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
  document.location.href="list.php";
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
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="会员中心">
  <title>账户充值 - 会员中心</title>
<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="../js/qrcode.min.js"></script>
  <!-- Stylesheets -->
  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 <style>

.submit{ width:131px;height:34px; border:hidden; font-family:"微软雅黑";color:#FFFFFF;background-image:url(img/btn.png);cursor:hand;font-size:15px}
.submit2{ width:131px;height:34px; border:hidden; font-family:"微软雅黑";color:#FFFFFF;background-image:url(img/btn2.png);cursor:hand;font-size:15px}
.boxx{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#EEEEEE;border:#DDDDDD solid 1px; text-align:center;}
.box2x{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#EEEEEE;border-top:#DDDDDD solid 1px;border-right:#DDDDDD solid 1px;border-bottom:#DDDDDD solid 1px;text-align:center;}
.box3x{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#FFFFFF;border-left:#DDDDDD solid 1px;border-right:#DDDDDD solid 1px;border-top:#ff0000 solid 2px;text-align:center; }
.box4x{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#FFFFFF;border-right:#DDDDDD solid 1px;border-top:#ff0000 solid 2px; text-align:center;}

.boxy{background-color:#0066FF; padding:10px; margin:10px 3px 10px 3px; float:left; color:#FFFFFF; font-size:14px; width:60px;}
.box2y{background-color:#0099FF; padding:10px; margin:10px 3px 10px 3px; float:left; color:#FFFFFF; font-size:14px; width:60px;}
.bankbox{padding:5px; margin:5px; border:#CCCCCC solid 1px; width:195px; height:45px; float:left;}
 ul,li{list-style: none;margin:0;padding:0;}

#tabbox{ width:600px; overflow:hidden; margin:0 auto;}
.tab_conbox{}
.tab_con{ display:none;}

.tabs{height:50px; background:#f7f7f7;}
.tabs li{line-height:48px;float:left;border:1px solid #DDDDDD;border-left:none;margin-bottom: -1px;background: #f7f7f7;overflow: hidden;position: relative; font-size:15px; }
.tabs li a {display: block;padding: 0 20px;outline: none;}
.tabs li a:hover {}	
.tabs .thistab{background: #ffffff;border-bottom: 1px solid #ffffff;  border-top:1px solid #FF0000;}

.tab_con {padding:12px;font-size: 12px; line-height:175%;}

.code{padding: 10px;border:solid 1px #DDDDDD;width: 100%;max-width: 300px}


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

<script type="text/javascript">
$(document).ready(function() {
	jQuery.jqtab = function(tabtit,tab_conbox,shijian) {
		$(tab_conbox).find("li").hide();
		$(tabtit).find("li:first").addClass("thistab").show(); 
		$(tab_conbox).find("li:first").show();
	
		$(tabtit).find("li").bind(shijian,function(){
		  $(this).addClass("thistab").siblings("li").removeClass("thistab"); 
			var activeindex = $(tabtit).find("li").index(this);
			$(tab_conbox).children().eq(activeindex).show().siblings().hide();
			return false;
		});
	};
	/*调用方法如下：*/
	$.jqtab("#tabs","#tab_conbox","click");
	$.jqtab("#tabs2","#tab_conbox2","mouseenter");
});
</script>
  <!--[if lt IE 9]>
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
	<script>
		var _ctxPath='';
	</script>    
</head>

<body class="body-index">
		<?php require 'top.php';?>
		<div class="container m_top_30">
					<div class="yto-box">
						<h5>账户充值</h5>
						<ul class="tabs" id="tabs" style="display: block">
		<?php if ($C_alipayon==1){?>
       <li><a href="javascript:;"><img src="img/alipay<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_wxpayon==1){?>
       <li><a href="javascript:;"><img src="img/weixin<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_qpayon==1){?>
       <li><a href="javascript:;"><img src="img/qqpay<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_dmfon==1){?>
       <li><a href="javascript:;"><img src="img/dmf<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_7payon==1){?>
       <li><a href="javascript:;"><img src="img/7pay<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_codepayon==1){?>
       <li><a href="javascript:;"><img src="img/codepay<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>
       	<?php if ($C_payjson==1){?>
       <li><a href="javascript:;"><img src="img/payjs<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

<li><a href="javascript:;"><img src="img/card<?php 
       if (isMobile()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
    </ul><div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
	<ul class="tab_conbox" id="tab_conbox" style="display: block;">
	<?php if ($C_alipayon==1){?>
<li class="tab_con">
<div id="v">
<form action="../pay/alipay/alipayapi.php<?php echo $port_info?>" method="post"  class="form-horizontal" id="form">

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
		<p>充值即时到帐</p>
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
</div>
</li>

<?php }?>
<?php if ($C_wxpayon==1){?>
<li class="tab_con">
<div id="t">
<form action="?show=t&type=wxpay" method="post" class="form-horizontal" id="form">
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
	<p>充值即时到帐</p>
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

</div>
</li>
<?php }?>

<?php if ($C_qpayon==1){?>
<li class="tab_con">
<div id="v">

	<form action="" method="post" id="qpay_form" class="form-horizontal">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label">充值金额</label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="total_fee" value="<?php echo $_REQUEST["money"]?>" id="qpay_fee" title="nickname" class="form-control"  placeholder="元" >
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
	<p>充值即时到帐</p>
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
</li>
	<?php }?>

<?php if ($C_dmfon==1){?>
<li class="tab_con">
<div id="v">

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
	<p>充值即时到帐</p>
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
</li>
	<?php }?>


<?php if ($C_7payon==1){?>
<li class="tab_con">
<div id="v">
<form action="../pay/7pay/api.php?action=pay" method="post"  class="form-horizontal" id="form">

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
		<p>充值即时到帐</p>
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
</div>
</li>

<?php }?>


<?php if ($C_codepayon==1){?>
<li class="tab_con">
<div id="v">
<form action="../pay/codepay/api.php?action=pay" method="post"  class="form-horizontal" id="form">

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
</div>
</li>
<?php }?>

<?php if ($C_payjson==1){?>
<li class="tab_con">
<div id="t">
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
	<p>充值即时到帐</p>
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
</div>
</li>
<?php }?>

<li class="tab_con">
<div id="t">
<form action="?action=card" method="post" class="form-horizontal" id="form">
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
	<p>充值即时到帐</p>
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
</li>
</ul>
	
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
		<?php require 'foot.php';?>

	<!-- js plugins  -->
	<script type="text/javascript">
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

	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
	
</body>
</html>
<?php }?>