<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'xsshtml.class.php';

$action=$_GET["action"];
$id=intval($_GET["id"]);
$uid=intval($_GET["uid"]);
$path=splitx($_SERVER["PHP_SELF"],"api",0);
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/api",0);
$M_id=intval($_GET["M_id"]);
$M_pwd=t($_GET["M_pwd"]);

function decrypt2($ciphertext, $iv, $app_key, $session_key) {
    $session_key = base64_decode($session_key);
    $iv = base64_decode($iv);
    $ciphertext = base64_decode($ciphertext);

    $plaintext = false;
    if (function_exists("openssl_decrypt")) {
        $plaintext = openssl_decrypt($ciphertext, "AES-192-CBC", $session_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
    } else {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, null, MCRYPT_MODE_CBC, null);
        mcrypt_generic_init($td, $session_key, $iv);
        $plaintext = mdecrypt_generic($td, $ciphertext);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
    }
    if ($plaintext == false) {
        return false;
    }

    // trim pkcs#7 padding
    $pad = ord(substr($plaintext, -1));
    $pad = ($pad < 1 || $pad > 32) ? 0 : $pad;
    $plaintext = substr($plaintext, 0, strlen($plaintext) - $pad);

    // trim header
    $plaintext = substr($plaintext, 16);
    // get content length
    $unpack = unpack("Nlen/", substr($plaintext, 0, 4));
    // get content
    $content = substr($plaintext, 4, $unpack['len']);
    // get app_key
    $app_key_decode = substr($plaintext, $unpack['len'] + 4);

    return $app_key == $app_key_decode ? $content : false;
}

class ErrorCode
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;
}


class WXBizDataCrypt
{
    private $appid;
    private $sessionKey;

    public function __construct( $appid, $sessionKey)
    {
        $this->sessionKey = $sessionKey;
        $this->appid = $appid;
    }

    public function decryptData( $encryptedData, $iv, &$data )
    {
        if (strlen($this->sessionKey) != 24) {
            return ErrorCode::$IllegalAesKey;
        }
        $aesKey=base64_decode($this->sessionKey);

        
        if (strlen($iv) != 24) {
            return ErrorCode::$IllegalIv;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return ErrorCode::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $this->appid )
        {
            return ErrorCode::$IllegalBuffer;
        }
        $data = $result;
        return ErrorCode::$OK;
    }

}

switch($action){
	case "changeadmin":
	if(admin_auth()){
		rename("../".$C_admin,"../".$_GET["C_admin"]);
		if(is_file("../".$_GET["C_admin"]."/index.php")){
			mysqli_query($conn,"update sl_config set C_admin='".$_GET["C_admin"]."'");
			die("{\"code\":\"success\",\"msg\":\"后台路径已修改为 ".$_GET["C_admin"]." 请牢记！\",\"admin\":\"".$_GET["C_admin"]."\"}");
		}else{
			die("{\"code\":\"error\",\"msg\":\"无修改权限或正在占用，请刷新页面再试！\"}");
		}
	}
	break;

	case "config":
	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$row["C_logo"]=img($row["C_logo"]);
	$row["config"]=$config;
	$api=json_encode($row);
	break;

	case "found":
	$M_email=t($_POST["email"]);
	$sql=sqlx($_GET["sql"]);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
        $M_pwdcode=gen_key(20);
        mysqli_query($conn,"update sl_member set M_pwdcode='".$M_pwdcode."' where M_email='".$M_email."'");
        sendmail("找回密码邮件","请点击链接重新设置密码<br><a href='http://".$D_domain."/member/setpwd.php?M_pwdcode=".$M_pwdcode."'>http://".$D_domain."/member/setpwd.php?M_pwdcode=".$M_pwdcode."</a><br>说明：重置密码后链接失效",$M_email);
        die("{\"code\":\"success\"}");
    }else{
    	die("{\"code\":\"error\",\"msg\":\"邮箱输入错误，请重新输入！\"}");
    }

	break;

	case "reg":
	$M_login=$_POST["M_login"];
    $M_pwd=$_POST["M_pwd"];
    $M_pwd2=$_POST["M_pwd2"];
    $M_email=removexss($_POST["M_email"]);
    if ($M_pwd!=$M_pwd2){
        die("{\"code\":\"error\",\"msg\":\"两次输入密码不一致!\"}");
    }
    if($M_login!="" && $M_pwd!="" && $M_email!=""){
        if (strpos($M_email,"@")===false){
            die("{\"code\":\"error\",\"msg\":\"请输入一个正确格式的邮箱!\"}");
        }else{
            $sql="select * from sl_member where M_login='".$M_login."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) > 0) {
                die("{\"code\":\"error\",\"msg\":\"用户名已被占用!\"}");
            }else{
                $sql="Select * from sl_member Where M_email='".$M_email."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if (mysqli_num_rows($result) > 0) {
                    die("{\"code\":\"error\",\"msg\":\"邮箱已被占用!\"}");
                }else{
                    mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_pwdcode,M_openid,M_from) values('".$M_login."','".md5($M_pwd)."','".$M_email."','head.jpg','".date('Y-m-d H:i:s')."','','',".$uid.")");
                    die("{\"code\":\"success\"}");
                }
            }
        }
    }else{
    	die("{\"code\":\"error\",\"msg\":\"请填全信息!\"}");
    }
	break;

	case "login":
	$M_login=t($_POST["login"]);
	$M_pwd=$_POST["pwd"];

	$sql = sqlx($_GET["sql"]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    	$row["msg"]="success";
    	$row["C_rzon"]=$C_rzon;
    	$row["M_head"]=img($row["M_head"]);

    	if($row["M_viplong"]-(time()-strtotime($row["M_viptime"]))/86400>0){
			$row["M_vip"]=1;
			$row["M_vipend"]=date('Y-m-d', strtotime ("+".$row["M_viplong"]." day", strtotime($row["M_viptime"])));
		}else{
			$row["M_vip"]=0;
		}

		if(time()-strtotime($row["M_sellertime"])>$row["M_sellerlong"]*86400){//商家到期
			$row["M_type"]=0;
		}else{
			$row["M_type"]=1;
		}

    	$api=json_encode($row);
    }else{
        $api="{\"msg\":\"帐号或密码错误\"}";
    }

	break;


	case "app_qqlogin":
    $openid=$_POST["openId"];
    $nickname=$_POST["nickName"];
    $head=$_POST["figureurl_qq"];

    $sql = sqlx($_GET["sql"]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    	$row["M_head"] = img($row["M_head"]);
    	$api=json_encode($row);
    } else {
    	if($openid!=""){
    		$pic=downpic("../media/",$head);
    		mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_wxid,M_openid,M_pwdcode,M_from) values('".$nickname."','".md5($openid)."','未设置邮箱@qq.com','".$pic."','".date('Y-m-d H:i:s')."','','".$openid."','',$uid)");
		    $sql2 = "select * from sl_member where M_openid='" . $openid . "' and not M_openid=''";
		    $result2 = mysqli_query($conn, $sql2);
		    $row2 = mysqli_fetch_assoc($result2);
		    if (mysqli_num_rows($result2) > 0) {
		    	$row2["M_head"] = img($row2["M_head"]);
		    	$api=json_encode($row2);
		    }
    	}
    }
    break;

	case "wxlogin_wx":
    $code=$_POST["code"];
    $info = GetBody("https://api.weixin.qq.com/sns/jscode2session?appid=" . $C_wxapp_id . "&secret=" . $C_wxapp_key . "&js_code=" . $code . "&grant_type=authorization_code", "");
    $info = json_decode($info);
    $openid = $info->openid;
    $unionid = $info->unionid;
    $session_key = $info->session_key;

    $sql = sqlx($_GET["sql"]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    	$row["M_head"]=img($row["M_head"]);
    	$row["msg"]="success";
    	$row["session_key"]=$session_key;
    } else {
        $row["msg"]="error";
        $row["session_key"]=$session_key;
    }
    $api = json_encode($row);
	break;

	case "wxlogin_wx2":
    $encryptedData = $_POST["encryptedData"];
    $iv = $_POST["iv"];
    $sessionkey = $_POST["session_key"];

    $pc = new WXBizDataCrypt($C_wxapp_id, $sessionkey);
    $errCode = $pc->decryptData($encryptedData, $iv, $data);

    if ($errCode == 0 && json_decode($data)->openId!="") {
    	$info = json_decode($data);
    	$pic=downpic("../media/",$info->avatarUrl);
    	mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_wxid,M_openid,M_pwdcode,M_from) values('".$info->nickName."','".md5($info->openId)."','未设置邮箱@qq.com','".$pic."','".date('Y-m-d H:i:s')."','".$info->openId."','','',$uid)");

        $sql = "select * from sl_member where M_wxid='".$info->openId."' and not M_wxid='' and M_del=0";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $row["msg"]="success";
            $row["M_head"]=img($row["M_head"]);
            $api = json_encode($row);
        }else{
        	$api = "{\"msg\":\"error1\"}";
        }

    }else{
    	$api = "{\"msg\":\"error2\"}";
    }
    break;

	case "mobile_login":
	$M_mobile=t($_POST["M_mobile"]);
	$M_code=t($_POST["M_code"]);

	$sql = sqlx($_GET["sql"]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    	$row["msg"]="success";
    	$row["C_rzon"]=$C_rzon;
    	$row["M_head"]=img($row["M_head"]);

    	if($row["M_viplong"]-(time()-strtotime($row["M_viptime"]))/86400>0){
			$row["M_vip"]=1;
			$row["M_vipend"]=date('Y-m-d', strtotime ("+".$row["M_viplong"]." day", strtotime($row["M_viptime"])));
		}else{
			$row["M_vip"]=0;
		}

		if(time()-strtotime($row["M_sellertime"])>$row["M_sellerlong"]*86400){//商家到期
			$row["M_type"]=0;
		}else{
			$row["M_type"]=1;
		}

    	$api=json_encode($row);
    }else{
        $api="{\"msg\":\"帐号或密码错误\"}";
    }

	break;

	case "mobile_send":
	$mobile=$_GET["mobile"];
	$pwd_code=rand(10000, 99999);

	if(preg_match("/^1[345678]{1}\d{9}$/",$mobile)){
		if(getrs("select * from sl_member where M_mobile='".$mobile."'","M_login")==""){
			mysqli_query($conn,"insert into sl_member(M_login,M_pwd,M_email,M_head,M_regtime,M_openid,M_from,M_mobile,M_pwdcode,M_from) values('".$mobile."','".md5($mobile)."','','head.jpg','".date('Y-m-d H:i:s')."','',0,'".$mobile."','".$pwd_code."',$uid)");
		}else{
			mysqli_query($conn,"update sl_member set M_pwdcode='".$pwd_code."' where M_mobile='".$mobile."'");
		}

		sendsms("【".$C_smssign."】您的验证码为".$pwd_code."；10分钟内有效,请尽快验证！",$mobile);
		$api="{\"code\":\"success\",\"msg\":\"发送成功！\"}";
	}else{
		$api="{\"code\":\"error\",\"msg\":\"请填写正确的手机号！\"}";
	}

	break;

	case "mylist":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

			if($row["L_money"]>0){
				$row["L_money"]="+".$row["L_money"];
			}
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);
	break;

	case "collection":
	$sql="select C_id,P_id,P_title,P_pic,P_price from sl_colletion,sl_member,sl_product where C_cid=P_id and C_type=0 and C_mid=M_id and M_id=$M_id and M_pwd='$M_pwd'";
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	while($row = mysqli_fetch_array($result)) {
		$row["P_pic"]=img(splitx($row["P_pic"],"|",0));
		$count=count($row);
		  for($i=0;$i<$count;$i++){ 
		    unset($row[$i]);
		  }   
	    array_push($arr,$row);
	} 
	$P_collection=$arr;

	$sql="select C_id,N_id,N_title,N_pic,N_price from sl_colletion,sl_member,sl_news where C_cid=N_id and C_type=1 and C_mid=M_id and M_id=$M_id and M_pwd='$M_pwd'";
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	while($row = mysqli_fetch_array($result)) {
		$row["N_pic"]=img($row["N_pic"]);
		$count=count($row);
		  for($i=0;$i<$count;$i++){ 
		    unset($row[$i]);
		  }
	    array_push($arr,$row);
	} 
	$N_collection=$arr;

	$sql="select C_id,M_id,M_shop,M_head,M_qq from sl_member,sl_colletion where C_cid=M_id and M_id in (select C_cid from sl_colletion,sl_member where C_type=2 and C_mid=M_id and M_id=$M_id and M_pwd='$M_pwd')";
	$result = mysqli_query($conn, $sql);
	$arr = array(); 
	while($row = mysqli_fetch_array($result)) {
		$row["M_head"]=img($row["M_head"]);
		$count=count($row);
		  for($i=0;$i<$count;$i++){ 
		    unset($row[$i]);
		  }   
	    array_push($arr,$row);
	} 
	$M_collection=$arr;
	$collection=array('P_collection'=>$P_collection,'N_collection'=>$N_collection,'M_collection'=>$M_collection);
	echo json_encode($collection);
	break;

	case "myorder":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

			$O_id=$row["O_id"];
			if($row["O_content"]=="实物商品，由商家手动发货"){
				if($row["O_state"]==1){
					$row["O_state"]="已发货";
				}else{
					$row["O_state"]="等待发货";
				}
			}else{
				$row["O_state"]="已发货";
			}
			if($row["O_type"]==1){
				$row["O_type"]="文章";
				$row["O_pic"]=img(getrs("select * from sl_news where N_id=".$row["O_nid"],"N_pic"));
				$row["O_url"]="../newsinfo/newsinfo?id=".$row["O_nid"];
			}else{
				$row["O_type"]="商品";
				$row["O_pic"]=img(splitx(getrs("select * from sl_product where P_id=".$row["O_pid"],"P_pic"),"|",0));
				$row["O_url"]="../productinfo/productinfo?id=".$row["O_pid"];
			}

			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);
	break;

	case "product_sell":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["P_pic"]=img(splitx($row["P_pic"],"|",0));
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);

	break;

	case "csort_list":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["S_count"]=getrs("select count(C_id) as C_count from sl_card where C_del=0 and C_sort=".$row["S_id"],"C_count");
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);

	break;

	case "card_list":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);

	break;

	case "editinfo":

	$M_email=htmlspecialchars($_POST["M_email"]);
	$M_mobile=htmlspecialchars($_POST["M_mobile"]);
	$M_shop=htmlspecialchars($_POST["M_shop"]);
	$M_qq=htmlspecialchars($_POST["M_qq"]);
	$M_notice=htmlspecialchars($_POST["M_notice"]);

	if($M_email!=""){
		mysqli_query($conn,"update sl_member set M_email='".$M_email."',M_mobile='".$M_mobile."',M_shop='".$M_shop."',M_qq='".$M_qq."',M_notice='".$M_notice."' where M_id=".$M_id." and M_pwd='".$M_pwd."'");
		$api="{\"code\":\"success\"}";
	}else{
		$api="{\"code\":\"error\",\"msg\":\"请填全信息\"}";
	}

	break;

	case "editpwd":

	$pwd=$_POST["pwd"];
	$pwd2=$_POST["pwd2"];
	$pwd3=$_POST["pwd3"];

	if($pwd2 != $pwd3){
		$api="{\"code\":\"error\",\"msg\":\"两次密码不一致\"}";
	}else{
	    if (md5($pwd) == $M_pwd) {
	    	mysqli_query($conn, "update sl_member set M_pwd='" . md5($pwd2) . "' where M_id=".$M_id." and M_pwd='".$M_pwd."'");
	        $api="{\"code\":\"success\"}";
	    } else {
	        $api="{\"code\":\"error\",\"msg\":\"旧密码错误\"}";
	    }
	}

	break;

	case "upvip":

	$sql="select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$M_money=$row["M_money"];
		$M_viptime=$row["M_viptime"];
		$M_viplong=$row["M_viplong"];
		if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
			$M_vip=1;
		}else{
			$M_vip=0;
		}
	}

	$viplong=intval($_GET["viplong"]);
	switch ($viplong) {
		case 1:
		$fee=$C_vip1;
		$longtitle="1个月";
		break;

		case 2:
		$fee=$C_vip2;
		$longtitle="2个月";
		break;

		case 3:
		$fee=$C_vip3;
		$longtitle="3个月";
		break;

		case 6:
		$fee=$C_vip6;
		$longtitle="6个月";
		break;

		case 12:
		$fee=$C_vip12;
		$longtitle="12个月";
		break;

		case 999:
		$fee=$C_vip0;
		$longtitle="永久";
		break;

		default:
		die();
		break;
	}

	if($M_money-$fee>=0 && $fee>0){
		if($M_vip==1){//原本是VIP会员
			mysqli_query($conn, "update sl_member set M_viplong=M_viplong+".(31*$viplong)." where M_id=".$M_id);
		}else{//原本是普通会员
			mysqli_query($conn, "update sl_member set M_viplong=".($viplong*31).",M_viptime='".date('Y-m-d H:i:s')."' where M_id=".$M_id);
		}
		mysqli_query($conn, "update sl_member set M_money=M_money-".$fee." where M_id=".$M_id);
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','开通VIP会员".$longtitle."','".date('Y-m-d H:i:s')."',-$fee,'')");
		$api="{\"code\":\"success\"}";
	}else{
		$api="{\"code\":\"erroe\",\"msg\":\"账户余额不足，请先充值\"}";
	}
	break;

	case "vipinfo":
	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$api=json_encode($row);
	break;

	case "address_del":
	$A_id=intval($_GET["A_id"]);

	mysqli_query($conn, "update sl_address set A_del=1 where A_id=".$A_id." and A_mid=".getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'","M_id"));
	$api="{\"code\":\"success\"}";
	break;

	case "address_add":
	$A_id=intval($_GET["A_id"]);

	$A_address=htmlspecialchars($_POST["A_address"]);
	$A_name=htmlspecialchars($_POST["A_name"]);
	$A_phone=htmlspecialchars($_POST["A_phone"]);
	$A_default=intval($_POST["A_default"]);

	if(getrs("select * from sl_address,sl_member where A_mid=M_id and M_id=".$M_id." and M_pwd='".$M_pwd."' and A_id=".$A_id,"A_name")!="" || ($A_id==0 && getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."' and M_del=0","M_login")!="")){
		if($A_default==1){
			mysqli_query($conn,"update sl_address set A_default=0 where A_mid=".$M_id);
		}

		if($A_name!=""){
			if($A_id==0){
				mysqli_query($conn,"insert into sl_address(A_name,A_address,A_phone,A_mid,A_default) values('$A_name','$A_address','$A_phone',".$M_id.",$A_default)");
			}else{
				mysqli_query($conn,"update sl_address set A_address='$A_address',A_name='$A_name',A_phone='$A_phone',A_default=$A_default where A_id=".$A_id." and A_mid=".$M_id);
			}
			$api="{\"code\":\"success\"}";
		}else{
			$api="{\"code\":\"error\",\"msg\":\"请填全信息\"}";
		}
	}else{
		$api="{\"code\":\"error\",\"msg\":\"请勿跨帐号\"}";
	}

	break;

	case "myyq":
	$uid=intval($_GET["uid"]);
	
	if(member_auth($M_id,$M_pwd)){
		$sql=sqlx($_GET["sql"]);
		$result = mysqli_query($conn, $sql);
		$arr = array();  
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$row["M_head"]=img($row["M_head"]);
				$count=count($row);
			      for($i=0;$i<$count;$i++){ 
			        unset($row[$i]);
			      }   
			    array_push($arr,$row);
			}
		}

		$index = array(); 
		$index["ulogin"]=getrs("select * from sl_member where M_id=".$uid,"M_login");
		$index["ufrom"]=getrs("select * from sl_member where M_id=".$uid,"M_from");
		$index["list"]=$arr;

		$api=json_encode($index);
	}
	break;
	case "address_info":
	$A_id=intval($_GET["A_id"]);

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$api=json_encode($row);
	break;

	case "csort_info":
	$S_id=intval($_GET["S_id"]);

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$api=json_encode($row);
	break;

	case "csort_add":
	$S_id=intval($_GET["S_id"]);
	$S_title=htmlspecialchars($_POST["S_title"]);
	$S_content=htmlspecialchars($_POST["S_content"]);

	if(getrs("select * from sl_csort,sl_member where S_mid=M_id and M_id=".$M_id." and M_pwd='".$M_pwd."' and S_id=".$S_id,"S_title")!="" || ($S_id==0 && getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."' and M_del=0","M_login")!="")){

		if($S_title!=""){
			if($S_id==0){
				mysqli_query($conn,"insert into sl_csort(S_title,S_content,S_mid) values('$S_title','$S_content',$M_id)");
			}else{
				mysqli_query($conn, "update sl_csort set S_title='$S_title',S_content='$S_content',S_mid=$M_id where S_id=".$S_id);
			}
			$api="{\"code\":\"success\"}";
		}else{
			$api="{\"code\":\"error\",\"msg\":\"请填全信息\"}";
		}
	}else{
		$api="{\"code\":\"error\",\"msg\":\"帐号状态错误，请尝试重新登录\"}";
	}

	break;
	case "moneyout":

	if(member_auth($M_id,$M_pwd)){
		$M_money = getrs("select M_money from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."' and M_del=0","M_money");
		$M_login = getrs("select M_login from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."' and M_del=0","M_login");
		$money = round($_POST["money"],2);
	    $name = removexss($_POST["name"]);
	    $alipay = removexss($_POST["alipay"]);
	    if ($money-$C_zd>=0) {
	        if ($money - $M_money <= 0) {
	            mysqli_query($conn, "update sl_member set M_money=M_money-$money where M_id=$M_id");
	            mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey,L_sh) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','余额提现（".$alipay."/".$name."）','".date('Y-m-d H:i:s')."',-$money,'',0)");
	            sendmail("用户提交提现申请","<p>用户提现申请</p><p>用户ID：".$M_id."</p><p>用户帐号：".$M_login."</p><p>提现账户：".$alipay."</p><p>真实姓名：".$name."</p><p>提现金额：".$money."元</p><p>请到后台-交易管理-资金明细，进行提现审核</p>",$C_email);
	            $api="{\"code\":\"success\"}";
	        } else {
	            $api="{\"code\":\"error\",\"msg\":\"余额不足！请重新输入\"}";
	        }
	    } else {
	    	$api="{\"code\":\"error\",\"msg\":\"最低提现金额为".$C_zd."元！\"}";
	    }
	}else{
		$api="{\"code\":\"error\",\"msg\":\"帐号状态错误，请尝试重新登录\"}";
	}

	break;

	case "card_add":
	$C_id=intval($_GET["C_id"]);

	$C_sort=intval($_POST["C_sort"]);
	$C_content=htmlspecialchars($_POST["C_content"]);
	$C_use=intval($_POST["C_use"]);

	if(getrs("select * from sl_csort,sl_member where S_mid=M_id and M_id=".$M_id." and M_pwd='".$M_pwd."' and S_id=".$S_id,"S_title")!="" || ($C_id==0 && getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."' and M_del=0","M_login")!="")){

		if($C_content!=""){
			if($C_id==0){
				mysqli_query($conn,"insert into sl_card(C_content,C_sort,C_use,C_mid) values('".trim($C_content)."',$C_sort,$C_use,$M_id)");
			}else{
				mysqli_query($conn,"update sl_card set C_content='$C_content',C_sort=$C_sort,C_use=$C_use where C_id=$C_id and C_mid=$M_id");
			}
			$api="{\"code\":\"success\"}";
		}else{
			$api="{\"code\":\"error\",\"msg\":\"请填全信息\"}";
		}
	}else{
		$api="{\"code\":\"error\",\"msg\":\"帐号状态错误，请尝试重新登录\"}";
	}

	break;

	case "card_info":
	$C_id=intval($_GET["C_id"]);

	if($C_id>0){
		$sql=sqlx($_GET["sql"]);
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$row["C_sort"]=intval($row["C_sort"]);
	}else{
		$row=array();
		$row["C_sort"]=0;
	}
	
	$sql2="select S_id,S_title from sl_csort,sl_member where S_del=0 and S_mid=M_id and M_id=".$M_id." and M_pwd='".$M_pwd."'";
	$result2 = mysqli_query($conn, $sql2);
	$arr = array();  
	while($row2 = mysqli_fetch_array($result2)) {
		$count=count($row2);
		  for($i=0;$i<$count;$i++){ 
		    unset($row2[$i]);
		  }   
	    array_push($arr,$row2);
	} 
	
	$row["csort"]=$arr;

	$api=json_encode($row);
	break;

	case "news_sell":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["N_pic"]=img($row["N_pic"]);
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);

	break;

	case "collection_del":
	$C_id=intval($_GET["C_id"]);
	mysqli_query($conn, "delete from sl_colletion where C_id=".$C_id." and C_mid=".getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'","M_id"));
	break;

	case "product_del":
	$P_id=intval($_GET["P_id"]);
	mysqli_query($conn, "update sl_product set P_del=1 where P_id=".$P_id." and P_mid=".getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'","M_id"));
	break;

	case "news_del":
	$N_id=intval($_GET["N_id"]);
	mysqli_query($conn, "update sl_news set N_del=1 where N_id=".$N_id." and N_mid=".getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'","M_id"));
	break;

	case "csort_del":
	$S_id=intval($_GET["S_id"]);
	mysqli_query($conn, "update sl_csort set S_del=1 where S_id=".$S_id." and S_mid=".getrs("select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'","M_id"));
	break;

	case "card_del":
	$C_id=intval($_GET["C_id"]);
	$S_id=intval($_GET["S_id"]);
	mysqli_query($conn, "update sl_card set C_del=1 where C_id=".$C_id." and C_sort=".getrs("select * from sl_member,sl_csort where S_id=".$S_id." and S_mid=M_id and M_id=".$M_id." and M_pwd='".$M_pwd."'","S_id"));
	break;

	case "evaluate":
	$O_id=intval($_GET["O_id"]);

	$E_star=intval($_POST["E_star"]);
	$E_content=t($_POST["E_content"]);

	if (getrs("select * from sl_orders,sl_member where O_mid=M_id and M_id=".$M_id." and M_pwd='".$M_pwd."' and O_id=".$O_id,"O_title")!="") {
		if(getrs("select * from sl_evaluate where E_mid=".$M_id." and E_oid=".$O_id,"E_id")!=""){
			$api="{\"code\":\"error\",\"msg\":\"该商品已评价过\"}";
		}else{
			if($E_content!=""){
				mysqli_query($conn,"insert into sl_evaluate(E_mid,E_oid,E_star,E_content,E_time,E_reply) values($M_id,$O_id,$E_star,'$E_content','".date('Y-m-d H:i:s')."','')");
				$api="{\"code\":\"success\"}";
			}else{
				$api="{\"code\":\"error\",\"msg\":\"请填写评价信息\"}";
			}
		}
	}else{
		$api="{\"code\":\"error\",\"msg\":\"您未购买该商品\"}";
	}

	break;

	case "myproduct":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["O_pic"]=img($row["O_pic"]);

			if($row["O_content"]=="实物商品，由商家手动发货"){
				if($row["O_state"]==1){
					$row["O_state"]="已发货";
				}else{
					$row["O_state"]="等待发货";
				}
			}else{
				$row["O_state"]="已发货";
			}

			if(getrs("select * from sl_evaluate where E_mid=".$M_id." and E_oid=".$row["O_id"],"E_id")==""){
				$row["O_evaluate"]=0;
			}else{
				$row["O_evaluate"]=1;
			}

			$row["O_content"]=str_replace("||","\r\n",$row["O_content"]);

			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);

	break;

	case "address":

	$sql=sqlx($_GET["sql"]);

	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);
	break;


	case "mynews":

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["O_pic"]=img($row["O_pic"]);

			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$api=json_encode($arr);

	break;

	case "seller":
	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$api=json_encode($row);
	break;

	case "upseller":

	$M_money=getrs("select M_money from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."'","M_money");

	if($C_rzfeetype==1){
		$sellerlong=1;
	}else{
		$sellerlong=999;
	}
	if($M_money-$C_rzfee>=0){
		mysqli_query($conn, "update sl_member set M_type=1,M_sellertime='".date('Y-m-d H:i:s')."',M_sellerlong=".($sellerlong*31*12)." where M_id=".$M_id);
		mysqli_query($conn, "update sl_member set M_money=M_money-".$C_rzfee." where M_id=".$M_id);
		mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'".date('YmdHis').rand(10000000,99999999)."','升级到商家','".date('Y-m-d H:i:s')."',-$C_rzfee,'')");
		$api="{\"msg\":\"success\"}";
	}else{
		$api="{\"msg\":\"error\"}";
	}
	break;

	case "order_info":
	$O_id=intval($_GET["O_id"]);

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$row["O_pic"]=img($row["O_pic"]);
	$api=json_encode($row);
	break;

	case "member_info":

	$sql = sqlx($_GET["sql"]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    	$row["msg"]="success";
    	$row["C_rzon"]=$C_rzon;
    	$row["M_head"]=img($row["M_head"]);

    	if($row["M_viplong"]-(time()-strtotime($row["M_viptime"]))/86400>0){
			$row["M_vip"]=1;
			$row["M_vipend"]=date('Y-m-d', strtotime ("+".$row["M_viplong"]." day", strtotime($row["M_viptime"])));
		}else{
			$row["M_vip"]=0;
		}

		if(time()-strtotime($row["M_sellertime"])>$row["M_sellerlong"]*86400){//商家到期
			$row["M_type"]=0;
		}else{
			$row["M_type"]=1;
		}

    	$api=json_encode($row);
    }else{
        $api="{\"msg\":\"error\"}";
    }
	break;

	case "index_product":

	//焦点图
	$sql=sqlx($_GET["sql"]);
		    $result = mysqli_query($conn, $sql);
		    $arr = array();  
		    while($row = mysqli_fetch_array($result)) {
		    $row["S_pic"]=img($row["S_pic"]);
		    $count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		} 
	$slide=$arr;

	//产品分类
	$sql="select * from sl_psort where S_del=0 order by S_sub,S_order,S_id desc limit 7";
		    $result = mysqli_query($conn, $sql);
		    $arr = array();  
		    while($row = mysqli_fetch_array($result)) {
		    $row["S_pic"]=img($row["S_pic"]);
		    $count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		} 
	$psort=$arr;

	//猜你喜欢
	$sql="select P_id,P_title,P_pic,P_price,P_sort,P_sold from sl_product where P_del=0 and P_sh=1 order by rand() limit 20";
		    $result = mysqli_query($conn, $sql);
		    $arr = array();  
		    while($row = mysqli_fetch_array($result)) {
		    $row["P_pic"]=img(splitx($row["P_pic"],"|",0));
		    $count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		} 
	$guess=$arr;

	//最新上架
	$sql="select P_id,P_title,P_pic,P_price,P_sort,P_sold from sl_product where P_del=0 and P_sh=1 order by P_id desc limit 10";
		    $result = mysqli_query($conn, $sql);
		    $arr = array();  
		    while($row = mysqli_fetch_array($result)) {
		    $row["P_pic"]=img(splitx($row["P_pic"],"|",0));
		    $count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		} 
	$latest=$arr;


	$index = array(); 
	$index["slide"]=$slide;
	$index["psort"]=$psort;
	$index["guess"]=$guess;
	$index["latest"]=$latest;
	$index["C_notice"]=$C_notice;
	$index["C_title"]=$C_title;

	$api=json_encode($index);

	break;

	case "search":
	$keyword = t($_GET["keyword"]);

	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["N_pic"]=img($row["N_pic"]);
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$news=$arr;

	$sql="select P_pic,P_title,P_id,S_title from sl_product,sl_psort where P_del=0 and P_sh=1 and S_del=0 and P_sort=S_id and P_title like '%".$keyword."%' order by P_id desc";
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$row["P_pic"]=img(splitx($row["P_pic"],"|",0));
			$count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		}
	}
	$product=$arr;

	$search = array(); 
	$search["news"]=$news;
	$search["product"]=$product;

	$api=json_encode($search);

	break;

	case "guestbook":

	$G_title = t($_POST["G_title"]);
	$G_name = t($_POST["G_name"]);
	$G_mail = t($_POST["G_mail"]);
	$G_phone = t($_POST["G_phone"]);
	$G_msg = t($_POST["G_msg"]);

	if(strpos($G_mail,"@")===false || strpos($G_mail,".")===false){
		$api="请填写一个正确的邮箱！";
	}else{
		if(strlen($G_phone)!=11 || !is_numeric($G_phone)){
			$api="请填写一个正确的手机号码！";
		}else{
			mysqli_query($conn, "insert into sl_guestbook(G_title,G_name,G_mail,G_phone,G_msg,G_time,G_reply) values('$G_title','$G_name','$G_mail','$G_phone','$G_msg','".date('Y-m-d H:i:s')."','')");
    		$api="success";
		}
	}
	break;

	case "contact":
	$sql="select * from sl_text where T_type=1";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$row["latitude"]=splitx($row["T_zb"],",",1);
	$row["longitude"]=splitx($row["T_zb"],",",0);

	$xss = new XssHtml($row["T_content"]);
	$row["T_content"] = $xss->getHtml();

	$kf=explode("|",$C_kefu);
	for($i=0;$i<count($kf);$i++){
		$kefu=$kefu."{\"info\":\"".splitx($kf[$i],"_",0)."\",\"type\":\"".splitx($kf[$i],"_",1)."\",\"job\":\"".splitx($kf[$i],"_",2)."\"},";
	}

	$kefu= substr($kefu,0,strlen($kefu)-1);

	$row["T_kefu"]=json_decode("[".$kefu."]");

	$api=json_encode($row);

	break;
	case "product_list":
	$page=intval($_GET["page"]);

	if($page==0){
		$page=1;
	}

//获取该分类下所有的商品
		if($id>0){
			$sql="select P_id,P_title,P_pic,P_price,P_sort,P_sold from sl_product,sl_psort where P_del=0 and P_sh=1 and S_del=0 and P_sort=S_id and (S_id=".$id." or S_sub=".$id.") order by P_order,P_id desc limit ".(($page-1)*10).",10";
		}else{
			$sql="select P_id,P_title,P_pic,P_price,P_sort,P_sold from sl_product,sl_psort where P_del=0 and P_sh=1 and S_del=0 and P_sort=S_id order by P_order,P_id desc limit ".(($page-1)*10).",10";
		}
	
		    $result = mysqli_query($conn, $sql);
		    $arr = array();  
		    while($row = mysqli_fetch_array($result)) {
		    $row["P_pic"]=img(splitx($row["P_pic"],"|",0));
		    $count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		} 
	$productlist=$arr;
//获取该分类的详细信息
//
	if($id>0){
		$sql="select * from sl_psort where S_id=".$id;
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$psort=$row;
	}else{
		$psort=json_decode("{\"S_title\":\"全部商品\"}");
	}
	
	if(getrs("select * from sl_psort where S_id=$id","S_sub")==0){
		$psort2=$id;
	}else{
		$psort2=intval(getrs("select * from sl_psort where S_id=$id","S_sub"));
	}
//获取所有子分类
	$sql="select * from sl_psort where S_sub=$psort2 and S_del=0 order by S_order,S_id desc";
	$result = mysqli_query($conn, $sql);
		$arr = array();  
		while($row = mysqli_fetch_array($result)) {
		$count=count($row);
		  for($i=0;$i<$count;$i++){ 
		    unset($row[$i]);
		  }   
	    array_push($arr,$row);
	} 
	$psortlist=$arr;

//获取所有商品大分类
	$sql="select * from sl_psort where S_sub=0 and S_del=0 order by S_order,S_id desc";
		$result = mysqli_query($conn, $sql);
		$arr = array();  
		while($row = mysqli_fetch_array($result)) {
		$count=count($row);
		  for($i=0;$i<$count;$i++){ 
		    unset($row[$i]);
		  }   
	    array_push($arr,$row);
	} 
	$psortlist2=$arr;

	$arr = array(); 
	$arr["productlist"]=$productlist;
	$arr["psort"]=$psort;
	$arr["psort2"]=$psort2;
	$arr["psortlist"]=$psortlist;
	$arr["psortlist2"]=$psortlist2;
	$arr["page"]=$page;

	$api=json_encode($arr);

	break;

	case "psort":
		$sql=sqlx($_GET["sql"]);
	    $result = mysqli_query($conn, $sql);
	    $arr = array();  
	    while($row = mysqli_fetch_array($result)) {

	    $sql2="select * from sl_psort where S_del=0 and S_sub=".$row["S_id"]." order by S_order,S_id";
	    $result2 = mysqli_query($conn, $sql2);
	    $arr2 = array();  
	    while($row2 = mysqli_fetch_array($result2)) {
	    $row2["S_pic"]=img(splitx($row2["S_pic"],"|",0));
	    $count2=count($row2);
	      for($j=0;$j<$count2;$j++){ 
	        unset($row2[$j]);
	      }
	    array_push($arr2,$row2);
		} 

	    $row["S_pic"]=img($row["S_pic"]);
	    $row["S_sub"]=$arr2;
	    $count=count($row);
	      for($i=0;$i<$count;$i++){ 
	        unset($row[$i]);
	      }
	    array_push($arr,$row);

	} 
	$api=json_encode($arr);
	break;

case "news_all":
$sql="select S_id,S_title from sl_nsort where S_del=0 and S_sub=0 order by S_order,S_id desc";
	$result = mysqli_query($conn, $sql);
	$arr = array();  
	while($row = mysqli_fetch_array($result)) {
		$sql2="select N_title,N_id,N_date,N_author,N_view,N_pic from sl_nsort,sl_news where N_del=0 and S_del=0 and N_sort=S_id and S_sub=".$row["S_id"]." order by N_order,N_id desc limit 10";
			$result2 = mysqli_query($conn, $sql2);
			$arr2 = array();  
			while($row2 = mysqli_fetch_array($result2)) {
			$row2["N_pic"]=img($row2["N_pic"]);
			$count2=count($row2);
			  for($j=0;$j<$count2;$j++){ 
			    unset($row[$j]);
			  }   
		    array_push($arr2,$row2);
		}
		$row["S_list"]=$arr2;
		$row["S_page"]=1;

	$count=count($row);
	  for($i=0;$i<$count;$i++){ 
	    unset($row[$i]);
	  }   
    array_push($arr,$row);
}
$api=json_encode($arr);
break;


case "news_list":
$page=intval($_GET["page"]);

if($page==0){
	$page=1;
}
	if($id>0){
		$sql=sqlx($_GET["sql"]);
	}else{
		$sql="select N_id,N_title,N_pic,N_date,N_view,N_author from sl_news,sl_nsort where N_del=0 and N_sh=1 and N_sort=S_id order by N_order,N_id desc limit ".(($page-1)*10).",10";
	}

	    $result = mysqli_query($conn, $sql);
	    $arr = array();  
	    while($row = mysqli_fetch_array($result)) {
	    $row["N_pic"]=img($row["N_pic"]);
	    $count=count($row);
	      for($i=0;$i<$count;$i++){ 
	        unset($row[$i]);
	      }   
	    array_push($arr,$row);
	} 
$newslist=$arr;

$arr = array(); 
$arr["newslist"]=$newslist;

$api=json_encode($arr);

break;

	case "member_nsort":
	$sql=sqlx($_GET["sql"]);
		$result = mysqli_query($conn, $sql);
		$arr = array();  
		while($row = mysqli_fetch_array($result)) {
		$count=count($row);
		  for($i=0;$i<$count;$i++){ 
		    unset($row[$i]);
		  }   
	    array_push($arr,$row);
	} 
	$api=json_encode($arr);

	break;

	case "product_listx":
	$sql=sqlx($_GET["sql"]);
		    $result = mysqli_query($conn, $sql);
		    $arr = array();  
		    while($row = mysqli_fetch_array($result)) {
		    $row["P_pic"]=img(splitx($row["P_pic"],"|",0));
		    $count=count($row);
		      for($i=0;$i<$count;$i++){ 
		        unset($row[$i]);
		      }   
		    array_push($arr,$row);
		} 
	$api=json_encode($arr);
	break;

	case "product_info":
	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if(substr($row["P_video"],0,1)=="<"){
		$row["P_video"]="";
	}else{
		$row["P_video"]=img($row["P_video"]);
	}

	$pic=explode("|",$row["P_pic"]);
	for($i=0;$i<count($pic);$i++){
		$p=$p."{\"pic\":\"".img($pic[$i])."\"},";
	}
	$p= substr($p,0,strlen($p)-1);
	$row["P_list"] = json_decode("[".$p."]");
	$row["P_content"]=str_replace("src=\"".$path."kindeditor/","src=\"http://".$_SERVER["HTTP_HOST"].$path."kindeditor/",$row["P_content"]);

	$xss = new XssHtml($row["P_content"]);
	$row["P_content"] = $xss->getHtml();


	$sql2="select M_head,M_login,O_title,O_time,O_num from sl_orders,sl_member where not O_state=2 and O_mid=M_id and O_pid=$id and O_del=0 and M_del=0 order by O_id desc";//购买记录
		$result2 = mysqli_query($conn, $sql2);
		$arr = array();  
		while($row2 = mysqli_fetch_array($result2)) {
		$row2["M_head"]=img($row2["M_head"]);
		$row2["M_login"]=enname($row2["M_login"]);
		$count=count($row2);
		  for($i=0;$i<$count;$i++){ 
		    unset($row2[$i]);
		  }   
	    array_push($arr,$row2);
	} 
	$row["P_buylist"] = $arr;

	$sql2="select M_head,M_login,E_star,E_content,E_time,E_reply from sl_evaluate,sl_member,sl_orders where E_del=0 and M_del=0 and O_del=0 and E_mid=M_id and E_oid=O_id and O_pid=$id order by E_id desc";//评价记录
		$result2 = mysqli_query($conn, $sql2);
		$arr = array();  
		while($row2 = mysqli_fetch_array($result2)) {
		$row2["M_head"]=img($row2["M_head"]);
		$row2["M_login"]=enname($row2["M_login"]);
		$count=count($row2);
		  for($i=0;$i<$count;$i++){ 
		    unset($row2[$i]);
		  }   
	    array_push($arr,$row2);
	} 
	$row["P_evaluate"] = $arr;

	$B_count=getrs("select count(*) as B_count from sl_orders where O_del=0 and not O_state=2 and O_pid=$id","B_count");
	$E_count=getrs("select count(*) as E_count from sl_evaluate,sl_orders where E_del=0 and O_del=0 and E_oid=O_id and O_pid=$id","E_count");

	$row["P_bcount"] = $B_count;
	$row["P_ecount"] = $E_count;


	switch ($row["P_selltype"]) {
		case 0:
		$P_rest="充足";
		break;

		case 1:
		$P_rest=getrs("select count(C_id) as C_count from sl_card where C_sort=".intval($row["P_sell"])." and C_use=0 and C_del=0","C_count");
		break;

		case 2:
		$P_rest=$row["P_rest"];
		break;
	}

	$row["P_rest"]=$P_rest;
	$api=json_encode($row);
	break;

	case "news_info":
	mysqli_query($conn,"update sl_news set N_view=N_view+1 where N_id=".$id);
	$genkey=t($_GET["genkey"]);
	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$row["N_pic"]=img($row["N_pic"]);
	if(substr($row["N_video"],0,1)=="<"){
		$row["N_video"]="";
	}else{
		$row["N_video"]=img($row["N_video"]);
	}
	$row["N_content"]=preg_replace('/style=".*?"/i', '', $row["N_content"]);
	$row["N_content"]=str_replace("src=\"".$path."kindeditor/","src=\"http://".$_SERVER["HTTP_HOST"].$path."kindeditor/",$row["N_content"]);

	$xss = new XssHtml($row["N_content"]);
	$N_content = $xss->getHtml();

	$N_price=$row["N_price"];
	$N_date=$row["N_date"];
	$N_long=$row["N_long"];

	$row["N_end"]=date("Y-m-d H:i:s",strtotime("+$N_long hour",strtotime($N_date)));

	if(strpos($row["N_content"],"[fh_free]")!==false){
		$N_preview=splitx($N_content,"[fh_free]",0);
	}else{
		$N_preview=" ";
	}

	if($N_price>0){//文章不免费
		if($N_long==0){//没开启了限时付费
			if(getrs("select * from sl_orders where O_content='".$genkey."' and O_nid=".$id,"O_id")!="" && $genkey!=""){//已免登录购买
				$t = str_replace("[fh_free]","",$N_content);
				$b = 1;
			}else{
				if(member_auth($M_id,$M_pwd)){//登录了会员
					$sql2 = "select * from sl_orders where O_del=0 and O_type=1 and O_nid=".$id." and O_mid=".intval($M_id);
					$result2 = mysqli_query($conn, $sql2);
					$row2 = mysqli_fetch_assoc($result2);
					if (mysqli_num_rows($result2) > 0) {//已购买
						$t = str_replace("[fh_free]","",$N_content);
						$b = 1;
					} else {//没购买
						$sql3="select * from sl_member where M_id=".intval($M_id);
						$result3 = mysqli_query($conn, $sql3);
						$row3 = mysqli_fetch_assoc($result3);
						$M_viptime=$row3["M_viptime"];
						$M_viplong=$row3["M_viplong"];
						if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
							if($M_viplong>30000){
								$N_discount=$C_n_discount2/10;
							}else{
								$N_discount=$C_n_discount/10;
							}
						}else{
							$N_discount=1;
						}
						if($N_discount==0){//VIP会员0折
							$t = str_replace("[fh_free]","",$N_content);
							$b = 1;
						}else{
							$t = $N_preview;
							$b = 0;
						}
					}
				}else{//没登录会员
					$t = $N_preview;
					$b = 0;
				}
			}
		}else{//开启了限时付费
			if(time()>strtotime("+$N_long hour",strtotime($N_date))){//已过收费期
				$t = str_replace("[fh_free]","",$N_content);
				$b = 1;
			}else{//未过收费期
				$t = $N_preview;
				$b = 0;
			}
		}
	}else{//免费
		$t = str_replace("[fh_free]","",$N_content);
		$b = 1;
	}

	$row["N_content"]=$t;
	$row["b"]=$b;
	$api=json_encode($row);
	break;

	case "unlogin":
	$type=$_GET["type"];
	$id=intval($_GET["id"]);
	$genkey=$_GET["genkey"];

	if($type=="news"){
		$sql="select * from sl_news where N_id=".$id;
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$O_title=$row["N_title"]."-付费阅读";
		$O_price=$row["N_price"];
		$O_pic=img($row["N_pic"]);
		$info="支付成功后，文章页面将自动刷新并显示全部内容，在这之前请不要关闭页面";
		$address="email";
	}

	if($type=="product"){
		$sql="select * from sl_product where P_id=".$id;
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$O_title=$row["P_title"]."-购买";
		$O_price=$row["P_price"];
		$O_pic=img(splitx($row["P_pic"],"|",0));

		switch ($row["P_selltype"]) {
			case 0:
			$P_rest=1;
			$P_resttitle="充足";
			break;

			case 1:
			$P_rest=getrs("select count(C_id) as C_count from sl_card where C_sort=".intval($row["P_sell"])." and C_use=0","C_count");
			$P_resttitle=$P_rest."件";
			break;

			case 2:
			$P_rest=$row["P_rest"];
			$P_resttitle=$P_rest."件";
			break;
		}
		
		if($row["P_selltype"]==2){
			$address="address";
			$info="该商品为实物商品，支付成功后，由商家手动发货";
		}else{
			$address="email";
			$info="该商品为虚拟商品，支付成功后，商品将自动发送到您的电子邮箱";
		}
	}
	$arr = array();
	$arr["O_title"]=$O_title;
	$arr["O_price"]=$O_price;
	$arr["O_pic"]=$O_pic;
	$arr["info"]=$info;
	$arr["address"]=$address;
	$arr["P_rest"]=$P_rest;
	$arr["P_resttitle"]=$P_resttitle;

	$api=json_encode($arr);
	break;

	case "ttpay":
	include('alipay/aop/AopClient.php');
	include('alipay/aop/request/AlipayTradeAppPayRequest.php');

	$app_id=$C_ttpay_appid;
	$merchant_id=$C_ttpay_mchid;
	$secret=$C_ttpay_secret;

	$attach=t($_POST["attach"]);
	$body=mb_substr($_POST["body"],0,48,"utf-8");

	$money=round($_GET["money"],2)*100;
	$out_order_no=date("YmdHis").gen_key(10,2);
	

	if($body!="账户充值"){
		$a=explode("|",$attach);
		$type=$a[0];
		$id=$a[1];
		$genkey=$a[2];
		$email=$a[3];
		$num=$a[4];
		$M_id=intval($a[5]);
		$uid=intval($a[6]);

		if($M_id==0){
			$M_id=1;
		}
		if($num<1){
	        $num=1;
	    }

	    $attach="$type|$id|$genkey|$email|$num|$M_id|$uid";

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
                    mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,".($total_fee).",1,'$N_title','$N_pic',0,'$email','$genkey','$genkey',$N_mid)");
                }
                if($type=="product"){
                    mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".($total_fee/$num).",$num,'','$P_title','$P_pic','$email',0,'$genkey',$P_mid)");
                }
            }
        }
	}
	
	//支付宝APP支付
	$notify_url=gethttp().$D_domain."/pay/dmf/notify_url.php";
	$aop = new AopClient;
	$aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
	$aop->appId = $C_dmf_id;
	$aop->rsaPrivateKey = $C_dmf_key;
	$aop->format = "json";
	$aop->charset = "UTF-8";
	$aop->signType = "RSA2";
	$aop->alipayrsaPublicKey = $C_dmf_key2;
	$request = new AlipayTradeAppPayRequest();
	$bizcontent = "{\"body\":\"".$attach."\"," 
	                . "\"subject\": \"".$body."\","
	                . "\"out_trade_no\": \"".$out_order_no."\","
	                . "\"timeout_express\": \"30m\","
	                . "\"total_amount\": \"".($money/100)."\","
	                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
	                . "}";
	$request->setNotifyUrl($notify_url);
	$request->setBizContent($bizcontent);
	$response = $aop->sdkExecute($request);
	$alipay_url=$response;

	//微信H5支付
	$NOTIFY_URL = gethttp().$D_domain."/pay/wxpay/notify_url.php";
	$sign=strtoupper(MD5("appid=".$C_wx_appid."&attach=".$attach."&body=".$body."&mch_id=".$C_wx_mchid."&nonce_str=".$out_trade_no."&notify_url=".$NOTIFY_URL."&out_trade_no=".$out_trade_no."&scene_info={\"h5_info\": {\"type\":\"Wap\",\"wap_url\": \"".gethttp().$_SERVER["HTTP_HOST"]."\",\"wap_name\": \"".$C_title."\"}}&spbill_create_ip=".getip()."&total_fee=".$total_fee."&trade_type=MWEB&key=".$C_wx_key));

    $info=getbody("https://api.mch.weixin.qq.com/pay/unifiedorder","<xml><appid>".$C_wx_appid."</appid><attach>".$attach."</attach><body>".$body."</body><mch_id>".$C_wx_mchid."</mch_id><nonce_str>".$out_trade_no."</nonce_str><notify_url>".$NOTIFY_URL."</notify_url><out_trade_no>".$out_trade_no."</out_trade_no><spbill_create_ip>".getip()."</spbill_create_ip><total_fee>".$total_fee."</total_fee><trade_type>MWEB</trade_type><scene_info>{\"h5_info\": {\"type\":\"Wap\",\"wap_url\": \"".gethttp().$_SERVER["HTTP_HOST"]."\",\"wap_name\": \"".$C_title."\"}}</scene_info><sign>".$sign."</sign></xml>");

    $postObj = simplexml_load_string( $info );
	$mweb_url=$postObj->mweb_url;

	$wx_url=$mweb_url||"none";
	$timestamp=time();

	$sgin=md5("alipay_url=".$alipay_url."&app_id=".$app_id."&body=".$body."&currency=CNY&merchant_id=".$merchant_id."&notify_url=".$notify_url."&out_order_no=".$out_order_no."&payment_type=direct&product_code=pay&sign_type=MD5&subject=".$body."&timestamp=".$timestamp."&total_amount=".$money."&trade_time=".$timestamp."&trade_type=H5&uid=".$app_id."&valid_time=600&version=2.0&wx_type=MWEB&wx_url=".$wx_url.$secret);

	$api='{
  "app_id": "'.$app_id.'",
  "sign_type": "MD5",
  "out_order_no": "'.$out_order_no.'",
  "merchant_id": "'.$merchant_id.'",
  "timestamp": "'.$timestamp.'",
  "product_code": "pay",
  "payment_type": "direct",
  "total_amount": '.$money.',
  "trade_type": "H5",
  "uid": "'.$app_id.'",
  "version": "2.0",
  "currency": "CNY",
  "subject": "'.$body.'",
  "body": "'.$body.'",
  "trade_time": "'.$timestamp.'",
  "valid_time": "600",
  "notify_url": "'.$notify_url.'",
  "wx_url": "'.$wx_url.'",
  "wx_type": "MWEB",
  "alipay_url": "'.$alipay_url.'",
  "sign": "'.$sgin.'",
  "risk_info": "{\"ip\":\"'.getip().'\"}"
}';
	break;
	case "check_orders":
	$out_order_no=t($_GET["out_order_no"]);
	
	break;
	case "wxlogin":
    $code=$_POST["code"];
    $info = GetBody("https://api.weixin.qq.com/sns/jscode2session?appid=" . $C_wxapp_id . "&secret=" . $C_wxapp_key . "&js_code=" . $code . "&grant_type=authorization_code", "");
    $info = json_decode($info);
    $openid = $info->openid;

    $api = "{\"openid\":\"" . $openid . "\"}";
    break;

    case "prepay":

	$money=round($_GET["money"],2);
	$total_money = $money*100;

	$openid=$_POST["openid"];
	$attach=t($_POST["attach"]);
	$body=$_POST["body"];

	if($body!="账户充值"){
		$a=explode("|",$attach);
		$type=$a[0];
		$id=$a[1];
		$genkey=$a[2];
		$email=$a[3];
		$num=$a[4];
		$M_id=intval($a[5]);
		$uid=intval($a[6]);

		if($M_id==0){
			$M_id=1;
		}
		if($num<1){
	        $num=1;
	    }

	    $attach="$type|$id|$genkey|$email|$num|$M_id|$uid";

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
	            $total_fee=p($row["N_price"]*$N_discount)*100;
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
	                $total_fee=p($row["P_price"]*$P_discount)*$num*100;
	            }else{
	                $total_fee=p($row["P_price"])*$num*100;
	            }
	        }
	        if($total_fee>0){
	            if(getrs("select O_id from sl_orders where O_genkey='$genkey'","O_id")==""){
	                if($type=="news"){
	                    mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,".($total_fee/100).",1,'$N_title','$N_pic',0,'$email','$genkey','$genkey',$N_mid)");
	                }
	                if($type=="product"){
	                    mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".($total_fee/100/$num).",$num,'','$P_title','$P_pic','$email',0,'$genkey',$P_mid)");
	                }
	            }
	        }
	}
	
	$nonce_str = gen_key(20);
	$str = "appid=$C_wxapp_id&attach=$attach&body=$body&mch_id=$C_wx_mchid&nonce_str=$nonce_str&notify_url=".gethttp().$D_domain."/api/wxpay/notify_url.php&openid=$openid&out_trade_no=$nonce_str&spbill_create_ip=127.0.0.1&total_fee=$total_money&trade_type=JSAPI&key=$C_wx_key";

	$sign = md5($str);
	$formData = "<xml>
	<appid>$C_wxapp_id</appid>
	<attach>$attach</attach>
	<body>$body</body>
	<mch_id>$C_wx_mchid</mch_id>
	<nonce_str>$nonce_str</nonce_str>
	<notify_url>".gethttp().$D_domain."/api/wxpay/notify_url.php</notify_url>
	<openid>$openid</openid>
	<out_trade_no>$nonce_str</out_trade_no>
	<spbill_create_ip>127.0.0.1</spbill_create_ip>
	<total_fee>$total_money</total_fee>
	<trade_type>JSAPI</trade_type>
	<sign>" . strtoupper($sign) . "</sign>
	</xml>";

	$info = GetBody("https://api.mch.weixin.qq.com/pay/unifiedorder", $formData);
	//die($formData);
	$info = simplexml_load_string($info);
	$prepay_id = $info->prepay_id[0];
	$str2 = "appId=" . $C_wxapp_id . "&nonceStr=BiIUif6MUIWM0S7YaXlH&package=prepay_id=" . $prepay_id . "&signType=MD5&timeStamp=1490840662&key=" . $C_wx_key;
	$pay_sign = md5($str2);
	$api = "{\"prepay_id\":\"" . $prepay_id . "\",\"pay_sign\":\"" . strtoupper($pay_sign) . "\"}";

	break;

	case "fahuo":
	$genkey=t($_GET["genkey"]);
	$sql=sqlx($_GET["sql"]);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$api=json_encode($row);
	break;

}

die(trim($api,"\xEF\xBB\xBF"));

function sqlx($sql){
	global $M_email,$M_login,$M_pwd,$openid,$M_mobile,$M_code,$M_id,$uid,$A_id,$S_id,$C_id,$O_id,$keyword,$id,$genkey,$page;
	$sql=ycode($sql);
	$sql=str_replace("[M_email]",$M_email,$sql);
	$sql=str_replace("[M_login]",$M_login,$sql);
	$sql=str_replace("[M_pwd]",$M_pwd,$sql);
	$sql=str_replace("[md5(M_pwd)]",md5($M_pwd),$sql);
	$sql=str_replace("[openid]",$openid,$sql);
	$sql=str_replace("[M_mobile]",$M_mobile,$sql);
	$sql=str_replace("[M_code]",$M_code,$sql);
	$sql=str_replace("[M_id]",$M_id,$sql);
	$sql=str_replace("[uid]",$uid,$sql);
	$sql=str_replace("[A_id]",$A_id,$sql);
	$sql=str_replace("[S_id]",$S_id,$sql);
	$sql=str_replace("[C_id]",$C_id,$sql);
	$sql=str_replace("[O_id]",$O_id,$sql);
	$sql=str_replace("[keyword]",$keyword,$sql);
	$sql=str_replace("[id]",$id,$sql);
	$sql=str_replace("[genkey]",$genkey,$sql);
	$sql=str_replace("[page]",($page-1)*10,$sql);
	return $sql;
}

function img($head){
	$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/api",0);
	if($head==""){
		return "";
	}else{
		if(substr($head,0,4)!="http"){
			return gethttp().$D_domain."/media/".$head;
		}else{
			return $head;
		}
	}
}
?>