<?php
require '../conn/conn.php';
require '../conn/function.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0);
$ids=$_GET["O"];
$type=$_GET["type"];

$pinfo="<table class=\"table\">";
$money=0;
for ($i=0 ;$i<count($ids);$i++) {
	$sql="select * from sl_orders where O_del=0 and O_state=0 and O_id=".intval($ids[$i]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$pinfo=$pinfo."<tr><td><img src=\"".pic2($row["O_pic"])."\" height=\"50\"></td><td><p><b>".$row["O_title"]."</b></p><p>".$row["O_price"]."元 × ".$row["O_num"]."件</p></td><td class=\"all\">".($row["O_price"]*$row["O_num"])."元</td></tr>";
		$genkey=$row["O_genkey"];
		$money=$money+($row["O_price"]*$row["O_num"]);
		$O_ids=$O_ids.$ids[$i].",";
	}
}
$O_ids= substr($O_ids,0,strlen($O_ids)-1);
$pinfo=$pinfo."</table>";

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

$M_info="
<img src=\"../media/$M_head\" style=\"width:30px;height:30px;border-radius:10px\">
<div style=\"display:inline-block;vertical-align:top;font-size:12px;margin-left:10px;\"> <b>$M_login</b>$vip_pic<br>$login</div>";

if(isMobile()){
	$port_info="?port_type=wap";
}else{
	$port_info="";
}

if($type=="check"){
	$L_no=getrs("select * from sl_list where L_genkey='".t($_POST["genkey"])."' and not L_genkey=''","L_no");
	if($L_no==""){
		die("0");
	}else{
		die($L_no);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>购物车收银台 - <?php echo $C_title?></title>
	<link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />
	<meta name="description" content="<?php echo $C_description?>" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="../js/qrcode.min.js"></script>
	<script src="../js/autoMail.js"></script>
	<style type="text/css">
	a{color: #666666;}
	a:hover{color: #000000;text-decoration:none}
	#mailBox{background:#fff;border:1px solid #ddd;padding:3px 5px 5px;position:absolute;z-index:9999;display:none;-webkit-box-shadow:0px 2px 7px rgba(0, 0, 0, 0.35);-moz-box-shadow:0px 2px 7px rgba(0, 0, 0, 0.35);}
	#mailBox p{width:100%;margin:0;padding:0;height:20px;line-height:20px;clear:both;font-size:12px;color:#ccc;cursor:default;}
	#mailBox ul{padding:0;margin:0;}
	#mailBox li{font-size:15px;height:30px;line-height:30px;color:#939393;font-family:'Tahoma';list-style:none;cursor:pointer;overflow:hidden;}
	#mailBox .cmail{color:#000;background:#e8f4fc;}
	table{border-left: solid 1px #DDDDDD;border-right: solid 1px #DDDDDD;border-bottom: solid 1px #DDDDDD;background: #f7f7f7;}
	td{font-size: 12px;}
	.all{font-weight: bold;font-size: 13px;color: #ff0000}
	</style>
	<script type="text/javascript">
	function isAlipay(){
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/Alipay/i) == 'alipay') {
            return true; // 是支付宝端
        } else {
            return false;
        }
    }
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


		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo stripslashes(str_replace("__", "\"", $_REQUEST["jsApiParameters"]))?>,
			function(res){
				if(res.err_msg.indexOf(":ok")>-1){
					window.location.href="?type=fahuo&genkey=<?php echo $genkey?>&id=<?php echo $id?>";
				}
				//else{
				//	alert(res.err_msg);
				//}
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
<body style="background: #f7f7f7;padding-top:10px ">



<div class="container" style="padding: 20px;background: #ffffff;">
<div style="font-size: 18px"><a href="../"><img src="../media/<?php echo $C_logo?>" style="height: 40px;margin-right: 10px;padding-right: 10px;border-right: solid 1px #DDDDDD;"></a>收银台</div>

<div style="float: right;margin-top: -35px;">
<?php echo $M_info;?>
</div>
</div>

<div class="container" style="padding: 10px;background: #ffffff;margin-top: 10px;position: relative;">


<div style="position: absolute;bottom: 10px;right: 20px;text-align: center;padding: 10px;background: #ffffff;font-size: 12px;display: none" id="qrcode2">
<div id="qrcode_url"></div>
<div style="margin-top: 5px;">扫码进入手机版</div>
</div>


<ul id="myTab" class="nav nav-tabs">
	<?php if ($C_alipayon==1){?><li><a href="#alipay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/alipay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_wxpayon==1){?><li><a href="#wxpay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/weixin<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_qpayon==1){?><li><a href="#qpay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/qqpay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_dmfon==1){?><li><a href="#dmf" data-toggle="tab" style="padding: 10px;"><img src="../member/img/dmf<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_7payon==1){?><li><a href="#7pay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/7pay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_codepayon==1){?><li><a href="#codepay" data-toggle="tab" style="padding: 10px;"><img src="../member/img/codepay<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($C_payjson==1){?><li><a href="#payjs" data-toggle="tab" style="padding: 10px;"><img src="../member/img/payjs<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
	<?php if ($M_id>1){?><li><a href="#money" data-toggle="tab" style="padding: 10px;"><img src="../member/img/money<?php if(isMobile()){echo "_m";}?>.png" style="height: 25px;"></a></li><?php }?>
</ul>
<div id="myTabContent" class="tab-content" style="padding: 20px;">

<?php echo $pinfo?>

	<?php if ($C_alipayon==1){?><div class="tab-pane fade" id="alipay">
		<form action="../pay/alipay/alipayapi.php<?php echo $port_info?>" method="post" class="buy">
				<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
				<p>方式：<img src="../member/img/alipay.png" height="25"></p>
				
				<p>
					<button class="btn btn-info" type="submit">立即支付</button>
				</p>
				<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
				
		</form>
	</div><?php }?>

	<?php if ($C_wxpayon==1){?><div class="tab-pane fade" id="wxpay">
		<form action="" method="post" id="wxpay_form" class="buy">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>方式：<img src="../member/img/weixin.png" height="25"></p>

			<p id="wx_btn">
				<button class="btn btn-success" type="button" onclick="qr()">立即支付</button>
			</p>
			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>

	<?php if ($C_qpayon==1){?><div class="tab-pane fade" id="qpay">
		<form action="" method="post" id="qpay_form" class="buy">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>方式：<img src="../member/img/qqpay.png" height="25"></p>
			<p id="dmf_btn">
				<button class="btn btn-info" type="button" onclick="qpay()">立即支付</button>
			</p>
			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>

	<?php if ($C_dmfon==1){?><div class="tab-pane fade" id="dmf">
		<form action="" method="post" id="dmf_form" class="buy">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>方式：<img src="../member/img/alipay.png" height="25"></p>
			<p id="dmf_btn">
				<button class="btn btn-info" type="button" onclick="dmf()">立即支付</button>
			</p>
			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>

	<?php if ($C_7payon==1){?><div class="tab-pane fade" id="7pay">
		<form action="../pay/7pay/api.php?action=cartpay" method="post" id="7pay_form" class="buy">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>方式：<img src="../member/img/alipay.png" height="25"></p>
			<p id="wx_btn">
				<button class="btn btn-primary" type="submit">立即支付</button>
			</p>

			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>


	<?php if ($C_codepayon==1){?><div class="tab-pane fade" id="codepay">
		<form action="../pay/codepay/api.php?action=cartpay" method="post" id="7pay_form" class="buy">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>方式：
				<span id="codepaytype">
				<?php if(strpos($C_codepay_type,"alipay")!==false){
					echo "<label><input type=\"radio\" value=\"1\" name=\"paytype\"><img src=\"../member/img/alipay.png\" height=\"25\"></label>";
				}?>
				<?php if(strpos($C_codepay_type,"wxpay")!==false){
					echo "<label><input type=\"radio\" value=\"3\" name=\"paytype\" > <img src=\"../member/img/weixin.png\" height=\"25\"></label>";
				}?>
				<?php if(strpos($C_codepay_type,"qqpay")!==false){
					echo "<label><input type=\"radio\" value=\"2\" name=\"paytype\" ><img src=\"../member/img/qqpay.jpg\" height=\"25\"></label> ";
				}?>
			</span>
			</p>
			
			<p id="wx_btn">
				<button class="btn btn-warning" type="submit">立即支付</button>
			</p>

			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>

	<?php if ($C_payjson==1){?><div class="tab-pane fade" id="payjs">
		<form action="" method="post" id="payjs_form" class="buy">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>方式：<img src="../member/img/weixin.png" height="25"></p>
			<p id="payjs_btn">
				<button class="btn btn-success" type="button" onclick="payjs()">立即支付</button>
			</p>
	
			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>

	<?php if ($M_id>1){?><div class="tab-pane fade" id="money">
		<form action="../pay/money/api.php?action=cartpay" method="post" id="7pay_form" class="buy" onsubmit="money()">
			<p>总价：<span style="font-size: 25px;color: #ff0000"><?php echo $money;?>元<?php echo $vip_pic?></span></p>
			<p>余额：<?php echo $M_money?>元</p>
			<p>方式：<img src="../member/img/money.png" height="25"></p>

			<p id="wx_btn">
				<button class="btn btn-warning" type="submit" id="money_btn">立即支付</button>
			</p>

			<input type="hidden" value="<?php echo $O_ids?>" name="O_ids">
		</form>
	</div><?php }?>
	
</div>
</div>

<!-- 模态框（Modal） -->
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
					$('#myModal').modal('show')
					$("#pay_img").attr("src","img/weixin.png");
					$("#pay_info").html("请使用微信扫码支付");
		            qrcode.makeCode(data);
				}else{
					if(data.indexOf("https://") != -1){
						$('#myModal').modal('show')
						$("#pay_img").attr("src","img/weixin.png");
						$("#pay_info").html("<a href='"+data+"' target='_blank' class='btn btn-success'>使用微信APP支付</a>");
		            	qrcode.makeCode(data);
					}else{
						alert(data);
					}
				}
	        }
	    })
	}
}

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
				$('#myModal').modal('show');
				$("#pay_img").attr("src","img/weixin.png");
				$("#pay_info").html("请使用微信扫码支付");
	            qrcode.makeCode(data);
	        }
	    })
	}
}

function check(){

	$.post("?type=check",
    {
      genkey:"<?php echo $genkey?>",
    },
  function(data){
  if(data>0){
  	window.location.href="query.php?action=query&no="+data;
  }
    });
}

function money(){
	$("#money_btn").html("请稍候...");
	$("#money_btn").attr("disabled",true);
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


if(IsPC()){
	$("#qrcode2").show()
	var qrcode2 = new QRCode('qrcode_url', {width: 100,height: 100,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
	qrcode2.makeCode(window.location.href);
}
$("#codepaytype").find("input:first").attr("checked","checked");
$("#myTab").find("li:first").attr("class","active");
$("#myTabContent").find("div:first").attr("class","tab-pane fade in active");
var qrcode = new QRCode('billImage', {width: 200,height: 200,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
setInterval("check()",3000);
$(document).ready(function(){
	$('#email').autoMail({
		emails:['qq.com','163.com','126.com','sina.com','sohu.com','yahoo.cn','gmail.com','hotmail.com','live.cn']
	});
});
</script>

<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script src="../conn/fahuo100.php?action=wxjs&type=&id="></script>
</body>
</html>