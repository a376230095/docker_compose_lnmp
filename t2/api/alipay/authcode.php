<?php
require '../../conn/conn.php';
require '../../conn/function.php';

include('aop/AopClient.php');
include('aop/request/AlipaySystemOauthTokenRequest.php');

$authcode=$_GET["authcode"];
$aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = $C_aliapp_id;
$aop->rsaPrivateKey = $C_aliapp_key;
$aop->alipayrsaPublicKey=$C_aliapp_key2;
$aop->apiVersion = '1.0';
$aop->signType = 'RSA2';
$aop->postCharset='UTF-8';
$aop->format='json';
$request = new AlipaySystemOauthTokenRequest ();
$request->setGrantType("authorization_code");
$request->setCode($authcode);
$request->setRefreshToken("201208134b203fe6c11548bcabd8da5bb087a83b");
$result = $aop->execute ( $request); 


$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
$user_id = $result->$responseNode->user_id;
die($user_id);
?>