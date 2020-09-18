<?php
require '../../conn/conn.php';
require '../../conn/function.php';

include('aop/AopClient.php');
include('aop/request/AlipayTradeCreateRequest.php');

$fee=round($_GET["money"],2);
$body=$_POST["attach"];
$subject=$_POST["body"];
$user_id=$_POST["user_id"];

$no = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/api",0);

$aop = new AopClient;
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = $C_aliapp_id;
$aop->rsaPrivateKey = $C_aliapp_key;
$aop->alipayrsaPublicKey=$C_aliapp_key2;
$aop->apiVersion = '1.0';
$aop->signType = 'RSA2';
$aop->postCharset='UTF-8';
$aop->format='json';
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
$request = new AlipayTradeCreateRequest();
//SDK已经封装掉了公共参数，这里只需要传入业务参数
$bizcontent = "{
        \"out_trade_no\":\"$no\",
        \"total_amount\":$fee,
        \"subject\":\"$subject\",
        \"body\":\"$body\",
        \"buyer_id\":\"$user_id\"
        }";
$request->setNotifyUrl(gethttp().$D_domain."/api/alipay/notify_url.php");
$request->setBizContent($bizcontent);
$result = $aop->execute ( $request); 
die(json_encode($result));
?>