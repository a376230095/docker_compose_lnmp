<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);
$genkey=$_POST["genkey"];
$O_ids=$_POST["O_ids"];

if($O_ids!=""){
    $total_fee=0;
    $ids=explode(",",$O_ids);
    for ($i=0 ;$i<count($ids);$i++) {
        $sql="select * from sl_orders where O_del=0 and O_state=0 and O_id=".intval($ids[$i]);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $total_fee=$total_fee+($row["O_price"]*$row["O_num"]);
        }
    }

    $body="购物车订单";
    $attach = "cart@".$O_ids;
}else{
    if($genkey==""){
    	$total_fee=$_POST["total_fee"];
    	$body=$_POST["body"];
    	$attach=$_POST["attach"];
    }else{
    	$type=$_POST["type"];
        if(is_array($_POST["email"])){
            for ($i=0 ;$i<count($_POST["email"]);$i++ ) {
                $email=$email.$_POST["email"][$i]."__";
            }
            $email= substr($email,0,strlen($email)-2);
        }else{
            $email=$_POST["email"];
        }
        $id=intval($_POST["id"]);
        $M_id=intval($_POST["M_id"]);
        $num=intval($_POST["num"]);
        if($num<1){
            $num=1;
        }

        $attach=$type."|".$id."|".$genkey."||".$num."|".$M_id."|".intval($_SESSION["uid"]);

        $sql="Select * from sl_member where M_id=".intval($M_id);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $M_id=$row["M_id"];
        $M_email=$row["M_email"];
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
        }else{
            $M_vip=0;
            $N_discount=1;
            $P_discount=1;
        }

        if($type=="news"){
            $sql="select * from sl_news where N_id=".$id;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $body=mb_substr($row["N_title"],0,10,"utf-8")."...-付费阅读";
            $total_fee=p($row["N_price"]*$N_discount);
            $N_title=$row["N_title"];
            $N_pic=$row["N_pic"];
            $N_mid=$row["N_mid"];
        }
        if($type=="product"){
            $sql="select * from sl_product where P_id=".$id;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $body=mb_substr($row["P_title"],0,10,"utf-8")."...-购买";
            $P_title=$row["P_title"];
            $P_pic=splitx($row["P_pic"],"|",0);
            $P_mid=$row["P_mid"];
            if($row["P_vip"]==1){
                $total_fee=p($row["P_price"]*$P_discount)*$num;
            }else{
                $total_fee=p($row["P_price"])*$num;
            }
        }
        if($total_fee>0){
            if(getrs("select O_id from sl_orders where O_genkey='$genkey'","O_id")==""){
                if($type=="news"){
                    mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,$total_fee,1,'$N_title','$N_pic',0,'$email','$genkey','$genkey',$N_mid)");
                }
                if($type=="product"){
                    mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".($total_fee/$num).",$num,'','$P_title','$P_pic','$email',0,'$genkey',$P_mid)");
                }
            }
        }
    }
}

$appid = $C_dmf_id;  //https://open.alipay.com 账户中心->密钥管理->开放平台密钥，填写添加了电脑网站支付的应用的APPID
$notifyUrl = gethttp().$D_domain."/pay/dmf/notify_url.php";     //付款成功后的异步回调地址
$returnUrl = gethttp().$D_domain."/pay/7pay/return.php";
$outTradeNo = date("YmdHis");     //你自己的商品订单号
$payAmount = $total_fee;          //付款金额，单位:元
$orderName = $body;    //订单标题
$signType = 'RSA2';       //签名算法类型，支持RSA2和RSA，推荐使用RSA2
//商户私钥，填写对应签名算法类型的私钥，如何生成密钥参考：https://docs.open.alipay.com/291/105971和https://docs.open.alipay.com/200/105310
$saPrivateKey=$C_dmf_key;

$aliPay = new AlipayService($appid,$returnUrl,$notifyUrl,$saPrivateKey);
$result = $aliPay->doPay($payAmount,$outTradeNo,$orderName,$returnUrl,$notifyUrl,$attach);
$result = $result['alipay_trade_precreate_response'];
if($result['code'] && $result['code']=='10000'){
    die($result['qr_code']);
}else{
    die($result['msg'].' : '.$result['sub_msg']);
}
class AlipayService
{
    protected $appId;
    protected $returnUrl;
    protected $notifyUrl;
    //私钥文件路径
    protected $rsaPrivateKeyFilePath;
    //私钥值
    protected $rsaPrivateKey;
    public function __construct($appid, $returnUrl, $notifyUrl,$saPrivateKey)
    {
        $this->appId = $appid;
        $this->returnUrl = $returnUrl;
        $this->notifyUrl = $notifyUrl;
        $this->charset = 'utf8';
        $this->rsaPrivateKey=$saPrivateKey;
    }
    /**
     * 发起订单
     * @param float $totalFee 收款总费用 单位元
     * @param string $outTradeNo 唯一的订单号
     * @param string $orderName 订单名称
     * @param string $notifyUrl 支付结果通知url 不要有问号
     * @param string $timestamp 订单发起时间
     * @return array
     */
    public function doPay($totalFee, $outTradeNo, $orderName, $returnUrl,$notifyUrl,$body)
    {
        //请求参数
        $requestConfigs = array(
            'out_trade_no'=>$outTradeNo,
            'total_amount'=>$totalFee, //单位 元
            'subject'=>$orderName,  //订单标题
            'body'=>$body,  //订单标题
        );
        $commonConfigs = array(
            //公共参数
            'app_id' => $this->appId,
            'method' => 'alipay.trade.precreate',             //接口名称
            'format' => 'JSON',
            'charset'=>$this->charset,
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url' => $notifyUrl,
            'biz_content'=>json_encode($requestConfigs),
        );
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        $result = $this->curlPost('https://openapi.alipay.com/gateway.do',$commonConfigs);
        return json_decode($result,true);
    }
    public function generateSign($params, $signType = "RSA") {
        return $this->sign($this->getSignContent($params), $signType);
    }
    protected function sign($data, $signType = "RSA") {
        $priKey=$this->rsaPrivateKey;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256); //OPENSSL_ALGO_SHA256是php5.4.8以上版本才支持
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, $this->charset);
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }
    public function curlPost($url = '', $postData = '', $options = array())
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
