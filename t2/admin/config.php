<?php
require '../conn/conn.php';
require '../conn/function.php';
require 'admin_check.php';

$action=$_GET["action"];
$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/".$C_admin,0);

if($action=="changeadmin"){
	if(validate($adminpath)){
		Header("Location: ../api/index.php?action=changeadmin&C_admin=".$_POST["C_admin"]);
	}else{
		echo "{\"code\":\"error\",\"msg\":\"仅限英文大小写及数字\"}";
	}
}

if($action=="push"){
	$urls = geturls($D_domain);
	$api = 'http://data.zz.baidu.com/urls?site='.$_SERVER["HTTP_HOST"].'&token='.$C_bd_token;
	$ch = curl_init();
	$options =  array(
	    CURLOPT_URL => $api,
	    CURLOPT_POST => true,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POSTFIELDS => implode("\n", $urls),
	    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);

	if(strpos($result,"success")!==false){
	    die("{\"code\":\"success\",\"msg\":\"成功向百度推送".json_decode($result)->success."个页面!\"}");
	}else{
		die("{\"code\":\"error\",\"msg\":\"推送失败!返回信息：".json_decode($result)->message."\"}");
	}
}

function validate($temp){
	$pattern = "/[^a-zA-Z0-9]/";
	if (preg_match($pattern, $temp)){
		return false;
	}else{
		return true;
	}
}

function check($dir){
    if(!is_dir($dir)) return false;
    $handle = opendir($dir);
    if($handle){
        while(($fl = readdir($handle)) !== false){
            $temp = $dir.DIRECTORY_SEPARATOR.$fl;
            if(is_dir($temp) && $fl!='.' && $fl != '..'){
                check($temp);
            }else{
                if(preg_match('/\.jpg|\.jpeg|\.png|\.gif|\.bmp|\.css|\.js/i', glpath($temp)) && strpos($temp,"#")===false){
                	$O_md5=getrs("select * from sl_oss where O_name='".glpath2($temp)."'","O_md5");
                	if($O_md5!=md5(file_get_contents(glpath2($temp)))){
                		echo glpath2($temp)."|";
                	}
                }
            }
        }
    }
}

function glpath($name){
	$name=str_replace("\\","/",$name);
	return str_replace("..//","../",$name);
}

function glpath2($name){
	$name=str_replace("\\","/",$name);
	$name=str_replace("//","/",$name);
	return str_replace("..//","",$name);
}

if($action=="oss"){
	check("../media/").check("../kindeditor/attached/image/");
	die();
}

if($action=="uppic"){
	$file=$_GET["file"];
	if(tooss($file)){
	    die("success");
	}else{
	    die("error");
	}
}

if($action=="reupload"){
	mysqli_query($conn,"delete from sl_oss");
	die("success");
}

if($action=="creat"){
	$sub=splitx($_SERVER["PHP_SELF"],"/".$C_admin,0);
	$callback=getbody("http://fh.s-cms.cn/api/index.php?action=creatapp&sub=$sub&domain=".$_SERVER["HTTP_HOST"],"data=".base64_encode(json_encode($H_data)));
	die($callback);
}

if($action=="sitemap"){
	$sitemap=$sitemap."<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL."<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">".PHP_EOL;

	$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."]]></loc><priority>1.00</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;

	$sql="select * from sl_text where T_del=0 order by T_id desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($C_html==0){
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=text&id=".$row["T_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}else{
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/text-".$row["T_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}
		}
	}

	$sql="select * from sl_nsort where S_del=0 order by S_id desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($C_html==0){
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=news&id=".$row["S_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}else{
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/news-".$row["S_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}
		}
	}

	$sql="select * from sl_news where N_del=0 order by N_id desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($C_html==0){
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=newsinfo&id=".$row["N_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}else{
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/newsinfo-".$row["N_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}
		}
	}

	$sql="select * from sl_psort where S_del=0 order by S_id desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($C_html==0){
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=product&id=".$row["S_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}else{
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/product-".$row["S_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}
		}
	}

	$sql="select * from sl_product where P_del=0 order by P_id desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if($C_html==0){
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=productinfo&id=".$row["P_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}else{
				$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/productinfo-".$row["P_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
			}
		}
	}
	$sitemap=$sitemap."</urlset>";
	file_put_contents("../sitemap.xml",$sitemap);
	die("{\"msg\":\"success\",\"info\":\"网站地图已生成，路径http://".$D_domain."/sitemap.xml，请到各站长平台提交sitemap\"}");
}

if($action=="save"){

	$C_title=$_POST["C_title"];
	$C_keyword=$_POST["C_keyword"];
	$C_description=$_POST["C_description"];
	$C_logo=$_POST["C_logo"];
	$C_ico=$_POST["C_ico"];
	$C_code=$_POST["C_code"];
	$C_copyright=$_POST["C_copyright"];

	$C_alipay_pid=trim($_POST["C_alipay_pid"]);
	$C_alipay_pkey=trim($_POST["C_alipay_pkey"]);
	$C_dmf_id=trim($_POST["C_dmf_id"]);
	$C_dmf_key=trim($_POST["C_dmf_key"]);

	$C_qpay_appid=trim($_POST["C_qpay_appid"]);
	$C_qpay_mchid=trim($_POST["C_qpay_mchid"]);
	$C_qpay_key=trim($_POST["C_qpay_key"]);

	$C_ttpay_appid=trim($_POST["C_ttpay_appid"]);
	$C_ttpay_mchid=trim($_POST["C_ttpay_mchid"]);
	$C_ttpay_secret=trim($_POST["C_ttpay_secret"]);

	$C_dmf_key2=trim($_POST["C_dmf_key2"]);
	$C_7pay_pid=trim($_POST["C_7pay_pid"]);
	$C_7pay_pkey=trim($_POST["C_7pay_pkey"]);
	$C_codepay_id=trim($_POST["C_codepay_id"]);
	$C_codepay_key=trim($_POST["C_codepay_key"]);

	$codepaytype=$_POST["C_codepay_type"];
	if($codepaytype!=""){
		for ($i=0 ;$i<count($codepaytype);$i++){
			$C_codepay_typex=$C_codepay_typex.$codepaytype[$i].",";
		}
		$C_codepay_typex= substr($C_codepay_typex,0,strlen($C_codepay_typex)-1);
	}
	
	$C_payjs_id=trim($_POST["C_payjs_id"]);
	$C_payjs_key=trim($_POST["C_payjs_key"]);
	$C_wx_appid=trim($_POST["C_wx_appid"]);
	$C_wx_appsecret=trim($_POST["C_wx_appsecret"]);
	$C_wx_mchid=trim($_POST["C_wx_mchid"]);
	$C_wx_key=trim($_POST["C_wx_key"]);
	$C_qqid=trim($_POST["C_qqid"]);
	$C_qqkey=trim($_POST["C_qqkey"]);

	$C_alicode=$_POST["C_alicode"];
	$C_wxcode=$_POST["C_wxcode"];
	$C_notice=$_POST["C_notice"];

	$C_m_logo=$_POST["C_m_logo"];
	$C_m_position=intval($_POST["C_m_position"]);
	$C_m_width=intval($_POST["C_m_width"]);
	$C_m_height=intval($_POST["C_m_height"]);
	$C_m_transparent=intval($_POST["C_m_transparent"]);

	$C_wxapp_id=trim($_POST["C_wxapp_id"]);
	$C_wxapp_key=trim($_POST["C_wxapp_key"]);
	$C_aliapp_id=trim($_POST["C_aliapp_id"]);
	$C_aliapp_key=trim($_POST["C_aliapp_key"]);
	$C_aliapp_key2=trim($_POST["C_aliapp_key2"]);
	$C_bdapp_id=trim($_POST["C_bdapp_id"]);
	$C_bdapp_key=trim($_POST["C_bdapp_key"]);
	$C_bdapp_key2=trim($_POST["C_bdapp_key2"]);
	$C_qqapp_id=trim($_POST["C_qqapp_id"]);
	$C_qqapp_key=trim($_POST["C_qqapp_key"]);
	$C_zjapp_id=trim($_POST["C_zjapp_id"]);
	$C_zjapp_key=trim($_POST["C_zjapp_key"]);
	$C_appt=$_POST["C_appt"];

	$C_alipayon=intval($_POST["C_alipayon"]);
	$C_wxpayon=intval($_POST["C_wxpayon"]);
	$C_dmfon=intval($_POST["C_dmfon"]);
	$C_7payon=intval($_POST["C_7payon"]);
	$C_qpayon=intval($_POST["C_qpayon"]);
	$C_codepayon=intval($_POST["C_codepayon"]);
	$C_payjson=intval($_POST["C_payjson"]);
	$C_alicodeon=intval($_POST["C_alicodeon"]);
	$C_wxcodeon=intval($_POST["C_wxcodeon"]);
	$C_regon=intval($_POST["C_regon"]);
	$C_qqon=intval($_POST["C_qqon"]);
	$C_wxon=intval($_POST["C_wxon"]);
	$C_dxon=intval($_POST["C_dxon"]);
	$C_kefuon=intval($_POST["C_kefuon"]);

	$C_punsh=intval($_POST["C_punsh"]);
	$C_nunsh=intval($_POST["C_nunsh"]);

	$C_fzon=intval($_POST["C_fzon"]);
	$C_fzk=intval($_POST["C_fzk"]);
	$C_fzvip=intval($_POST["C_fzvip"]);

	$C_rzon=intval($_POST["C_rzon"]);
	$C_fee=intval($_POST["C_fee"]);
	$C_rzfee=round($_POST["C_rzfee"],2);
	$C_rzfeetype=intval($_POST["C_rzfeetype"]);
	$C_zd=round($_POST["C_zd"],2);

	$C_beian=$_POST["C_beian"];
    $C_qrcode=$_POST["C_qrcode"];
    $C_email=$_POST["C_email"];
    $C_phone=$_POST["C_phone"];

    $C_osson=intval($_POST["C_osson"]);
    $C_oss_id=$_POST["C_oss_id"];
	$C_oss_key=$_POST["C_oss_key"];
	$C_oss_domain=$_POST["C_oss_domain"];
	$C_bucket=$_POST["C_bucket"];
	$C_region=$_POST["C_region"];

    $C_mobile=trim($_POST["C_mobile"]);
    $C_smssign=trim($_POST["C_smssign"]);
    $C_userid=intval($_POST["C_userid"]);
    $C_codeid=trim($_POST["C_codeid"]);
    $C_codekey=trim($_POST["C_codekey"]);

    $C_mailtype=intval($_POST["C_mailtype"]);
    $C_mailcode=trim($_POST["C_mailcode"]);
    $C_smtp=$_POST["C_smtp"];

    $C_fx1=intval($_POST["C_fx1"]);
    $C_fx2=intval($_POST["C_fx2"]);
    $C_fx3=intval($_POST["C_fx3"]);

    $C_hotwords=$_POST["C_hotwords"];

    $C_memberon=intval($_POST["C_memberon"]);

    $C_backup=intval($_POST["C_backup"]);
    $C_slide=intval($_POST["C_slide"]);
    $C_uncopy=intval($_POST["C_uncopy"]);
    $C_twice=intval($_POST["C_twice"]);
    $C_format=$_POST["C_format"];
    $C_bd_token=$_POST["C_bd_token"];

    $C_dx1=intval($_POST["C_dx1"]);
    $C_dx2=intval($_POST["C_dx2"]);
    $C_dx3=intval($_POST["C_dx3"]);
    $C_dx4=intval($_POST["C_dx4"]);
    $C_dx5=intval($_POST["C_dx5"]);

    if($C_osson==1 &&($C_oss_id=="" || $C_bucket=="" || $C_region=="")){
    	die("如果开启OSS功能，请正确填写OSS信息");
    }
    if($C_oss_domain!="" && substr($C_oss_domain,0,4)!="http"){
    	die("OSS自定义域名格式错误");
    }
    if(!checkauth()){
    	$C_fx1=0;
    	$C_fx2=0;
    	$C_fx3=0;
    	if($C_rzon==1){
    		die("免费版暂时不支持开启商家入驻功能");
    	}
    	if($C_qqon==1 || $C_wxon==1){
    		die("免费版暂时不支持开启快捷登录");
    	}
    }

    $C_html=intval($_POST["C_html"]);

	foreach ($_POST as $x=>$value) {
	    if(splitx($x,"_",0)=="picpic1"){
	        $C_kf=$C_kf.$_POST[$x]."_".$_POST["picpic2_".splitx($x,"_",1)]."_".$_POST["picpic3_".splitx($x,"_",1)]."|";
	    }
	}

	$C_kf=substr($C_kf,0,strlen($C_kf)-1);
	if($C_title==""){
		die("请填全信息");
	}else{
		mysqli_query($conn,"update sl_config set
		C_title='$C_title',
		C_keyword='$C_keyword',
		C_description='$C_description',
		C_logo='$C_logo',
		C_ico='$C_ico',
		C_code='$C_code',
		C_copyright='$C_copyright',
		C_m_logo='$C_m_logo',
		C_m_position=$C_m_position,
		C_m_width=$C_m_width,
		C_m_height=$C_m_height,
		C_m_transparent=$C_m_transparent,
		C_kefu='$C_kf',
		C_alipay_pid='$C_alipay_pid',
		C_qpay_appid='$C_qpay_appid',
		C_qpay_mchid='$C_qpay_mchid',
		C_ttpay_appid='$C_ttpay_appid',
		C_ttpay_mchid='$C_ttpay_mchid',
		C_dmf_id='$C_dmf_id',
		C_7pay_pid='$C_7pay_pid',
		C_codepay_id='$C_codepay_id',
		C_codepay_type='$C_codepay_typex',
		C_payjs_id='$C_payjs_id',
		C_wx_appid='$C_wx_appid',
		C_wx_mchid='$C_wx_mchid',
		C_qqid='$C_qqid',
		C_wxapp_id='$C_wxapp_id',
		C_aliapp_id='$C_aliapp_id',
		C_bdapp_id='$C_bdapp_id',
		C_qqapp_id='$C_qqapp_id',
		C_zjapp_id='$C_zjapp_id',
		C_appt='$C_appt',
		C_alicode='$C_alicode',
		C_wxcode='$C_wxcode',
		C_kefuon=$C_kefuon,
		C_alipayon=$C_alipayon,
		C_wxpayon=$C_wxpayon,
		C_7payon=$C_7payon,
		C_qpayon=$C_qpayon,
		C_dmfon=$C_dmfon,
		C_codepayon=$C_codepayon,
		C_payjson=$C_payjson,
		C_qqon=$C_qqon,
		C_regon=$C_regon,
		C_wxon=$C_wxon,
		C_dxon=$C_dxon,
		C_rzon=$C_rzon,
		C_fzon=$C_fzon,
		C_fzk=$C_fzk,
		C_fzvip=$C_fzvip,
		C_punsh=$C_punsh,
		C_nunsh=$C_nunsh,
		C_fee=$C_fee,
		C_rzfee=$C_rzfee,
		C_rzfeetype=$C_rzfeetype,
		C_zd=$C_zd,
		C_alicodeon=$C_alicodeon,
		C_wxcodeon=$C_wxcodeon,
		C_beian='$C_beian',
		C_qrcode='$C_qrcode',
		C_email='$C_email',
		C_notice='$C_notice',
		C_mailtype=$C_mailtype,
		C_smtp='$C_smtp',
		C_html=$C_html,
		C_phone='$C_phone',
		C_mobile='$C_mobile',
		C_smssign='$C_smssign',
		C_userid='$C_userid',
		C_codeid='$C_codeid',
		C_hotwords='$C_hotwords',
		C_osson=$C_osson,
		C_oss_id='$C_oss_id',
		C_oss_domain='$C_oss_domain',
		C_bucket='$C_bucket',
		C_region='$C_region',
		C_fx1=$C_fx1,
		C_fx2=$C_fx2,
		C_fx3=$C_fx3,
		C_dx1=$C_dx1,
		C_dx2=$C_dx2,
		C_dx3=$C_dx3,
		C_dx4=$C_dx4,
		C_dx5=$C_dx5,
		C_twice=$C_twice,
		C_format='$C_format',
		C_uncopy=$C_uncopy,
		C_slide=$C_slide,
		C_backup=$C_backup,
		C_memberon=$C_memberon
		");
		if($C_bd_token!=""){
			mysqli_query($conn,"update sl_config set C_bd_token='$C_bd_token'");
		}
		if($C_qqkey!=""){
			mysqli_query($conn,"update sl_config set C_qqkey='$C_qqkey'");
		}
		if($C_alipay_pkey!=""){
			mysqli_query($conn,"update sl_config set C_alipay_pkey='$C_alipay_pkey'");
		}
		if($C_qpay_key!=""){
			mysqli_query($conn,"update sl_config set C_qpay_key='$C_qpay_key'");
		}
		if($C_ttpay_secret!=""){
			mysqli_query($conn,"update sl_config set C_ttpay_secret='$C_ttpay_secret'");
		}
		if($C_dmf_key!=""){
			mysqli_query($conn,"update sl_config set C_dmf_key='$C_dmf_key'");
		}
		if($C_dmf_key2!=""){
			mysqli_query($conn,"update sl_config set C_dmf_key2='$C_dmf_key2'");
		}
		if($C_7pay_pkey!=""){
			mysqli_query($conn,"update sl_config set C_7pay_pkey='$C_7pay_pkey'");
		}
		if($C_codepay_key!=""){
			mysqli_query($conn,"update sl_config set C_codepay_key='$C_codepay_key'");
		}
		if($C_payjs_key!=""){
			mysqli_query($conn,"update sl_config set C_payjs_key='$C_payjs_key'");
		}
		if($C_wx_appsecret!=""){
			mysqli_query($conn,"update sl_config set C_wx_appsecret='$C_wx_appsecret'");
		}
		if($C_wx_key!=""){
			mysqli_query($conn,"update sl_config set C_wx_key='$C_wx_key'");
		}
		if($C_mailcode!=""){
			mysqli_query($conn,"update sl_config set C_mailcode='$C_mailcode'");
		}
		if($C_codekey!=""){
			mysqli_query($conn,"update sl_config set C_codekey='$C_codekey'");
		}

		if($C_wxapp_key!=""){
			mysqli_query($conn,"update sl_config set C_wxapp_key='$C_wxapp_key'");
		}
		if($C_aliapp_key!=""){
			mysqli_query($conn,"update sl_config set C_aliapp_key='$C_aliapp_key'");
		}
		if($C_aliapp_key2!=""){
			mysqli_query($conn,"update sl_config set C_aliapp_key2='$C_aliapp_key2'");
		}
		if($C_bdapp_key!=""){
			mysqli_query($conn,"update sl_config set C_bdapp_key='$C_bdapp_key'");
		}
		if($C_bdapp_key2!=""){
			mysqli_query($conn,"update sl_config set C_bdapp_key2='$C_bdapp_key2'");
		}
		if($C_qqapp_key!=""){
			mysqli_query($conn,"update sl_config set C_qqapp_key='$C_qqapp_key'");
		}
		if($C_zjapp_key!=""){
			mysqli_query($conn,"update sl_config set C_zjapp_key='$C_zjapp_key'");
		}
		if($C_oss_key!=""){
			mysqli_query($conn,"update sl_config set C_oss_key='$C_oss_key'");
		}

		mysqli_query($conn, "insert into sl_log(L_aid,L_time,L_add,L_ip,L_title) values(".$_SESSION["A_id"].",'".date('Y-m-d H:i:s')."','".$_SESSION["add"]."','".getip()."','编辑基本设置')");
		die("success");
	}
}

if($C_userid=="" || $C_codeid=="" || $C_codekey==""){
	$sms_rest="<font color='#ff0000'>未知</font>";
}else{
	$info=GetBody("http://dx.10691.net:8888/sms.aspx?action=overage&userid=".$C_userid."&account=".$C_codeid."&password=".$C_codekey,"");
	$xml =simplexml_load_string($info);

	if ($xml->returnstatus=="Sucess"){
		$sms_rest=$xml->overage;
	}else{
		$sms_rest="<font color='#ff0000'>未知</font>";
	}
}

$sitemap=$sitemap."<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL."<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">".PHP_EOL;

$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."]]></loc><priority>1.00</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;

$sql="select * from sl_text where T_del=0 order by T_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		if($C_html==0){
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=text&id=".$row["T_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}else{
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/text-".$row["T_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}
	}
}

$sql="select * from sl_nsort where S_del=0 order by S_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		if($C_html==0){
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=news&id=".$row["S_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}else{
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/news-".$row["S_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}
	}
}

$sql="select * from sl_news where N_del=0 order by N_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		if($C_html==0){
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=newsinfo&id=".$row["N_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}else{
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/newsinfo-".$row["N_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}
	}
}

$sql="select * from sl_psort where S_del=0 order by S_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		if($C_html==0){
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=product&id=".$row["S_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}else{
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/product-".$row["S_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}
	}
}

$sql="select * from sl_product where P_del=0 order by P_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		if($C_html==0){
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."?type=productinfo&id=".$row["P_id"]."]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}else{
			$sitemap=$sitemap."<url><loc><![CDATA[".gethttp().$D_domain."/productinfo-".$row["P_id"].".html]]></loc><priority>0.5</priority><lastmod>".date("Y-m-d",time())."</lastmod><changefreq>weekly</changefreq></url>".PHP_EOL;
		}
	}
}
$sitemap=$sitemap."</urlset>";
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>基本设置 - 后台管理</title>

		<!--favicon -->
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

		<!--Toastr css-->
		<link rel="stylesheet" href="assets/plugins/toastr/build/toastr.css">


		<script type="text/javascript" src="../upload/upload.js"></script>
		<style type="text/css">
		.showpic{height: 50px;border: solid 1px #DDDDDD;padding: 5px;}
		.showpicx{width: 100%;max-width: 300px}
		.table td{padding: 0px}

		.buy label {
			padding: 1px 5px;
			cursor: pointer;
			border: #CCCCCC solid 2px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			color: #CCCCCC;
		}

		.buy .checked {
			border: #ff0000 solid 2px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			color: #ff0000;
		}

		.buy input[type="radio"] {
			display: none;
		}

		.nav>li>a {
    position: relative;
    display: block;
    margin-right: 0px;

}
.intro{font-size: 12px;color: #AAAAAA}
	</style>
	<script type="text/javascript">

function AddPic(){
 var i =pic1.rows.length;
 var newTr = pic1.insertRow();
 var _id='pp'+i;
 var newTd0 = newTr.insertCell();
 newTr.id=_id;
 newTd0.innerHTML ='<div class="input-group"><input type="text" name="picpic3_'+i+'" class="form-control" value="" placeholder="职务"><input type="text" name="picpic1_'+i+'" class="form-control" value="" placeholder="号码"><select class="form-control" name="picpic2_'+i+'"><option value="qq">QQ客服</option><option value="ww">旺旺客服</option><option value="wx">微信客服</option><option value="phone">电话号码</option><option value="email">电子邮箱</option></select><span class="input-group-btn"><button class="btn btn-primary m-b-5  m-t-5" type="button" onclick="DelPic('+i+')">－ 删除</button></span></div>'
 
}
function DelPic(i){
  var Container = document.getElementById("pic1");    
    var _tr=document.getElementById("pp"+i);  
    row=_tr.rowIndex;
    Container.deleteRow(row); 
}

	</script>
	</head>

	<body class="app ">

		<div id="spinner"></div>

		<div id="app">
			<div class="main-wrapper" >
				
					<?php
					require 'nav.php';
					?>

				<div class="app-content">
					<section class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">后台管理</a></li>
                            <li class="breadcrumb-item active" aria-current="page">基本设置</li>
                        </ol>

						<div class="section-body ">
							<form id="form">
							<div class="row">
								
								<div class="col-lg-12">
									<div class="card card-primary">
		
										<div class="card-body">
											<ul class="nav nav-tabs" id="myTab2" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" id="home-tab2" data-toggle="tab" href="#t1" role="tab" aria-controls="home" aria-selected="true">基本设置</a>
												</li>
												
												<li class="nav-item">
													<a class="nav-link" id="profile-tab2" data-toggle="tab" href="#t2" role="tab" aria-controls="profile" aria-selected="false">注册/登录</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t3" role="tab" aria-controls="contact" aria-selected="false">收款接口</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t4" role="tab" aria-controls="contact" aria-selected="false">图片水印</a>
												</li>
												
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t5" role="tab" aria-controls="contact" aria-selected="false">商家入驻</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t6" role="tab" aria-controls="contact" aria-selected="false">邮箱接口</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t10" role="tab" aria-controls="contact" aria-selected="false">短信接口</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t7" role="tab" aria-controls="contact" aria-selected="false">辅助功能</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t8" role="tab" aria-controls="contact" aria-selected="false">APP/小程序</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t9" role="tab" aria-controls="contact" aria-selected="false">安全设置</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t11" role="tab" aria-controls="contact" aria-selected="false">页面收录</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab2" data-toggle="tab" href="#t12" role="tab" aria-controls="contact" aria-selected="false">OSS云储存</a>
												</li>
											</ul>
											<div class="tab-content tab-bordered" id="myTab2Content">
												<div class="tab-pane fade show active" id="t1" role="tabpanel" aria-labelledby="home-tab2">
													
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站标题</label>
													<div class="col-md-9">
														<input type="text"  name="C_title" class="form-control" value="<?php echo $C_title?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站关键词</label>
													<div class="col-md-9">
														<input type="text"  name="C_keyword" class="form-control" value="<?php echo $C_keyword?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站描述</label>
													<div class="col-md-9">
														<textarea class="form-control" rows="3" name="C_description"><?php echo $C_description?></textarea>
														
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站LOGO</label>
													<div class="col-md-9">
														<p><img src="../media/<?php echo $C_logo?>" id="C_logox" class="showpic" onClick="showUpload('C_logo','C_logo','../media',1,null,'','');" alt="<img src='../media/<?php echo $C_logo?>' class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="C_logo" name="C_logo" class="form-control" value="<?php echo $C_logo?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('C_logo','C_logo','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站ICO图标</label>
													<div class="col-md-9">
														<p><img src="../media/<?php echo $C_ico?>" id="C_icox" class="showpic" onClick="showUpload('C_ico','C_ico','../media',1,null,'','');"></p>
														<div class="input-group">
						                                        <input type="text" id="C_ico" name="C_ico" class="form-control" value="<?php echo $C_ico?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5  m-t-5" type="button" onClick="showUpload('C_ico','C_ico','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
													</div>
												</div>
												<hr>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站备案号</label>
													<div class="col-md-9">
														<input type="text"  name="C_beian" class="form-control" value="<?php echo $C_beian?>" placeholder="没有可留空">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >网站公告</label>
													<div class="col-md-9">
														<textarea class="form-control" rows="3" name="C_notice"><?php echo $C_notice?></textarea>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >版权文字</label>
													<div class="col-md-9">
														<textarea class="form-control" rows="3" name="C_copyright"><?php echo $C_copyright?></textarea>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >统计代码</label>
													<div class="col-md-9">
														<textarea class="form-control" rows="3" name="C_code"><?php echo $C_code?></textarea>
														
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信二维码</label>
													<div class="col-md-9">
														<p><img src="../media/<?php echo $C_qrcode?>" id="C_qrcodex" class="showpic" onClick="showUpload('C_qrcode','C_qrcode','../media',1,null,'','');" alt="<img src='../media/<?php echo $C_qrcode?>'  class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="C_qrcode" name="C_qrcode" class="form-control" value="<?php echo $C_qrcode?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('C_qrcode','C_qrcode','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >拨打电话</label>
													<div class="col-md-9">
														<input type="text"  name="C_phone" class="form-control" value="<?php echo $C_phone?>">
													</div>
												</div>
												<hr>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >客服开关</label>
													<div class="col-md-9 buy">
														<label aa="C_kefuon" <?php if($C_kefuon==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_kefuon" <?php if($C_kefuon==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_kefuon" <?php if($C_kefuon==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_kefuon" <?php if($C_kefuon==0){echo "checked='checked'";}?>> 关闭</label>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >客服设置</label>
													<div class="col-md-9">

														<table class="table" id="pic1">

														<?php
															$kf=explode("|",$C_kefu);
															for($i=0;$i<count($kf);$i++){
																if(splitx($kf[$i],"_",1)=="qq"){
																	$qq="selected='selected'";
																}else{
																	$qq="";
																}

																if(splitx($kf[$i],"_",1)=="ww"){
																	$ww="selected='selected'";
																}else{
																	$ww="";
																}

																if(splitx($kf[$i],"_",1)=="wx"){
																	$wx="selected='selected'";
																}else{
																	$wx="";
																}

																if(splitx($kf[$i],"_",1)=="phone"){
																	$phone="selected='selected'";
																}else{
																	$phone="";
																}

																if(splitx($kf[$i],"_",1)=="email"){
																	$email="selected='selected'";
																}else{
																	$email="";
																}
																echo '<tr id="pp'.$i.'"><td><div class="input-group">
															            <input type="text" placeholder="职务" name="picpic3_'.$i.'" class="form-control" value="'.splitx($kf[$i],"_",2).'">
															            <input type="text" placeholder="号码" name="picpic1_'.$i.'" class="form-control" value="'.splitx($kf[$i],"_",0).'">
															            <select class="form-control" name="picpic2_'.$i.'">
															            	<option value="qq" '.$qq.'>QQ客服</option>
															            	<option value="ww" '.$ww.'>旺旺客服</option>
															            	<option value="wx" '.$wx.'>微信客服</option>
															            	<option value="phone" '.$phone.'>电话号码</option>
															            	<option value="email" '.$email.'>电子邮箱</option>
															            </select>
															            <span class="input-group-btn">
															                    <button class="btn btn-primary m-b-5  m-t-5" type="button" onclick="DelPic('.$i.')">－ 删除</button>
															            </span>
															    </div></td></tr>';
															}
														?>

</table>
														<button type="button" class="btn btn-primary btn-sm" onclick="AddPic()">＋ 新增一个客服</button>
														<span class="pull-right">说明：显示在网站右侧</span>
													</div>
												</div>

										
												</div>



												<div class="tab-pane fade" id="t2" role="tabpanel" aria-labelledby="profile-tab2">

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >开启会员中心</label>
													<div class="col-md-9 buy">
														<label aa="C_memberon" <?php if($C_memberon==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_memberon" <?php if($C_memberon==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_memberon" <?php if($C_memberon==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_memberon" <?php if($C_memberon==0){echo "checked='checked'";}?>> 关闭</label>
														
													</div>
												</div>
												<hr>

											
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >QQ ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_qqid" class="form-control" value="<?php echo $C_qqid?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >QQ KEY</label>
													<div class="col-md-9">
														<input type="text"  name="C_qqkey" class="form-control" value="" <?php if($C_qqkey!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >会员注册开关</label>
													<div class="col-md-9">
														<label><input value="1" type="checkbox" name="C_regon" <?php if($C_regon==1){echo "checked='checked'";}?>> 常规注册</label><br>
														<label><input value="1" type="checkbox" name="C_dxon" <?php if($C_dxon==1){echo "checked='checked'";}?>> 手机号注册</label><br>
														<label><input value="1" type="checkbox" name="C_qqon" <?php if($C_qqon==1){echo "checked='checked'";}?>> QQ快捷登录</label><br>
														<label><input value="1" type="checkbox" name="C_wxon" <?php if($C_wxon==1){echo "checked='checked'";}?>> 微信快捷登录</label><br>
														
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*配置收款接口的微信APP ID及微信APP secret即可实现微信快捷登录</div>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h2.html" target="_blank">查看帮助</a></div>
													</div>
												</div>

												</div>

												<div class="tab-pane fade" id="t3" role="tabpanel" aria-labelledby="contact-tab2">
													<div class="row">
														<div class="col-md-6">
										<div class="card card-info">
										<div class="card-header ">
											<h4>商户接口（需营业执照）</h4>
										</div>
										<div class="card-body">
												<p style="text-align: center;font-weight: bold;font-size: 17px">支付宝收款</p>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付宝PID</label>
													<div class="col-md-9">
														<input type="text"  name="C_alipay_pid" class="form-control" value="<?php echo $C_alipay_pid?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付宝PKEY</label>
													<div class="col-md-9">
														<input type="text"  name="C_alipay_pkey" class="form-control" value="" <?php if($C_alipay_pkey!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h1.html" target="_blank">查看帮助</a> 提供平台：<a href="https://b.alipay.com/index2.htm" target="_balnk">支付宝官网</a></div>
													</div>
												</div>
												
												<hr>
												<p style="text-align: center;font-weight: bold;font-size: 17px">微信支付收款</p>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信APP ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_wx_appid" class="form-control" value="<?php echo $C_wx_appid?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信APP secret</label>
													<div class="col-md-9">
														<input type="text"  name="C_wx_appsecret" class="form-control" value="" <?php if($C_wx_appsecret!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果只需要实现微信登录功能，配置好以上两项即可</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信MCHID</label>
													<div class="col-md-9">
														<input type="text"  name="C_wx_mchid" class="form-control" value="<?php echo $C_wx_mchid?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信KEY</label>
													<div class="col-md-9">
														<input type="text"  name="C_wx_key" class="form-control" value="" <?php if($C_wx_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h1.html" target="_blank">查看帮助</a> 提供平台：<a href="https://pay.weixin.qq.com" target="_balnk">微信支付官网</a></div>
													</div>
												</div>
												<hr>
												<p style="text-align: center;font-weight: bold;font-size: 17px">QQ钱包收款</p>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >商户ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_qpay_mchid" class="form-control" value="<?php echo $C_qpay_mchid?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >KEY</label>
													<div class="col-md-9">
														<input type="text"  name="C_qpay_key" class="form-control" value="" <?php if($C_qpay_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h1.html" target="_blank">查看帮助</a> 提供平台：<a href="https://qpay.qq.com/" target="_balnk">QQ钱包官网</a></div>
													</div>
												</div>
												
											</div>
										</div>
<div class="card card-warning">
										<div class="card-header ">
											<h4>支付开关</h4>
										</div>
										<div class="card-body">
										<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付开关</label>
													<div class="col-md-9">
														<label><input value="1" type="checkbox" name="C_alipayon" <?php if($C_alipayon==1){echo "checked='checked'";}?>> 支付宝商户</label>
														<label><input value="1" type="checkbox" name="C_wxpayon" <?php if($C_wxpayon==1){echo "checked='checked'";}?>> 微信支付商户 </label>
														<label><input value="1" type="checkbox" name="C_qpayon" <?php if($C_qpayon==1){echo "checked='checked'";}?>> QQ钱包商户 </label><br>
														<label><input value="1" type="checkbox" name="C_dmfon" <?php if($C_dmfon==1){echo "checked='checked'";}?>> 当面付收款 </label>
														
														<label><input value="1" type="checkbox" name="C_7payon" <?php if($C_7payon==1){echo "checked='checked'";}?>> 7支付收款 </label>
														
														<label><input value="1" type="checkbox" name="C_codepayon" <?php if($C_codepayon==1){echo "checked='checked'";}?>> 码支付收款 </label>
														
														<label><input value="1" type="checkbox" name="C_payjson" <?php if($C_payjson==1){echo "checked='checked'";}?>> PAYJS收款 </label>
														

													</div>
												</div>
											</div>
										</div>


														</div>

														<div class="col-md-6">
															<div class="card card-success">
										<div class="card-header ">
											<h4>个人免签接口</h4>
										</div>
										<div class="card-body">
															<p style="text-align: center;font-weight: bold;font-size: 17px">当面付收款</p>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >应用appid</label>
													<div class="col-md-9">
														<input type="text"  name="C_dmf_id" class="form-control" value="<?php echo $C_dmf_id?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付宝公钥</label>
													<div class="col-md-9">
														<textarea  name="C_dmf_key2" class="form-control" <?php if($C_dmf_key2!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >应用私钥</label>
													<div class="col-md-9">
														<textarea  name="C_dmf_key" class="form-control" <?php if($C_dmf_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>></textarea>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h23.html" target="_blank">查看帮助</a> 提供平台：<a href="https://www.alipay.com" target="_balnk">支付宝官网</a></div>
													</div>
												</div>
												

												<hr>
												<p style="text-align: center;font-weight: bold;font-size: 17px">7支付收款</p>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >7支付PID</label>
													<div class="col-md-9">
														<input type="text"  name="C_7pay_pid" class="form-control" value="<?php echo $C_7pay_pid?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >7支付PKEY</label>
													<div class="col-md-9">
														<input type="text"  name="C_7pay_pkey" class="form-control" value="" <?php if($C_7pay_pkey!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h4.html" target="_blank">查看帮助</a> 提供平台：<a href="https://7-pay.cn" target="_balnk">7支付官网</a></div>
													</div>
												</div>
												
												<hr>
												<p style="text-align: center;font-weight: bold;font-size: 17px">码支付收款</p>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >码支付ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_codepay_id" class="form-control" value="<?php echo $C_codepay_id?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >通信密钥</label>
													<div class="col-md-9">
														<input type="text"  name="C_codepay_key" class="form-control" value="" <?php if($C_codepay_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付方式</label>
													<div class="col-md-9">
														<label><input value="alipay" type="checkbox" name="C_codepay_type[]" <?php if(strpos($C_codepay_type,"alipay")!==false){echo "checked='checked'";}?>> 支付宝</label>
														<label><input value="wxpay" type="checkbox" name="C_codepay_type[]" <?php if(strpos($C_codepay_type,"wxpay")!==false){echo "checked='checked'";}?>> 微信支付 </label>
														<label><input value="qqpay" type="checkbox" name="C_codepay_type[]" <?php if(strpos($C_codepay_type,"qqpay")!==false){echo "checked='checked'";}?>> QQ钱包 </label>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h17.html" target="_blank">查看帮助</a> 提供平台：<a href="https://codepay.fateqq.com/home.htm" target="_balnk">码支付官网</a></div>
													</div>
												</div>

												<hr>
												<p style="text-align: center;font-weight: bold;font-size: 17px">PAYJS收款</p>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >商户号</label>
													<div class="col-md-9">
														<input type="text"  name="C_payjs_id" class="form-control" value="<?php echo $C_payjs_id?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" >通信密钥</label>
													<div class="col-md-9">
														<input type="text"  name="C_payjs_key" class="form-control" value="" <?php if($C_payjs_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h20.html" target="_blank">查看帮助</a> 提供平台：<a href="https://payjs.cn/" target="_balnk">payjs官网</a></div>
													</div>
												</div>
														</div>

													</div>
											</div>
										</div>


										
												</div>

												<div class="tab-pane fade" id="t4" role="tabpanel" aria-labelledby="contact-tab2">
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >水印图片</label>
													<div class="col-md-9">
														<p><img src="../media/<?php echo $C_m_logo?>" id="C_m_logox" class="showpic" onClick="showUpload('C_m_logo','C_m_logo','../media',1,null,'','');" alt="<img src='../media/<?php echo $C_m_logo?>' class='showpicx'>"></p>
														<div class="input-group">
															
						                                        <input type="text" id="C_m_logo" name="C_m_logo" class="form-control" value="<?php echo $C_m_logo?>">
						                                        <span class="input-group-btn">
						                                                <button class="btn btn-primary m-b-5 m-t-5" type="button" onClick="showUpload('C_m_logo','C_m_logo','../media',1,null,'','');">上传</button>
						                                        </span>
						                                </div>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">水印位置 </label>
													<div class="col-md-9 buy">
														<label aa="C_m_position" <?php if($C_m_position==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_m_position" <?php if($C_m_position==0){echo "checked='checked'";}?>> 关闭</label>
														<label aa="C_m_position" <?php if($C_m_position==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_m_position" <?php if($C_m_position==1){echo "checked='checked'";}?>> 左上</label>
														<label aa="C_m_position" <?php if($C_m_position==2){echo "class='checked'";}?>><input value="2" type="radio" name="C_m_position" <?php if($C_m_position==2){echo "checked='checked'";}?>> 右上</label>
														<label aa="C_m_position" <?php if($C_m_position==3){echo "class='checked'";}?>><input value="3" type="radio" name="C_m_position" <?php if($C_m_position==3){echo "checked='checked'";}?>> 左下</label>
														<label aa="C_m_position" <?php if($C_m_position==4){echo "class='checked'";}?>><input value="4" type="radio" name="C_m_position" <?php if($C_m_position==4){echo "checked='checked'";}?>> 右下</label>
														<label aa="C_m_position" <?php if($C_m_position==5){echo "class='checked'";}?>><input value="5" type="radio" name="C_m_position" <?php if($C_m_position==5){echo "checked='checked'";}?>> 居中</label>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">水印宽度</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_m_width" class="form-control" value="<?php echo $C_m_width?>">
														<span class="input-group-addon">像素</span>
													</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">水印高度</label>
													<div class="col-md-9" style="padding-top:7px">
														等比例缩放
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">水印透明度</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_m_transparent" class="form-control" value="<?php echo $C_m_transparent?>">
														<span class="input-group-addon">%</span>
													</div>
													<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">说明：（1）水印透明度仅适用于jpg格式水印（2）水印图需小于原图，否则会加水印失败</div>
													</div>

												</div>

												</div>

												<div class="tab-pane fade" id="t5" role="tabpanel" aria-labelledby="contact-tab2">
													
												<div class="form-group row">
													<label class="col-md-3 col-form-label">商家入驻 <img src="img/vip.png" height="15"></label>
													<div class="col-md-9 buy">
														<label aa="C_rzon" <?php if($C_rzon==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_rzon" <?php if($C_rzon==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_rzon" <?php if($C_rzon==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_rzon" <?php if($C_rzon==0){echo "checked='checked'";}?>> 关闭</label>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">入驻费用</label>
													<div class="col-md-9">
														<div class="input-group">
														<select class="form-control" name="C_rzfeetype">
															<option value="0" <?php if($C_rzfeetype==0){echo "selected='selected'";}?>>一次性</option>
															<option value="1" <?php if($C_rzfeetype==1){echo "selected='selected'";}?>>每年</option>
														</select>
														<input type="text"  name="C_rzfee" class="form-control" value="<?php echo $C_rzfee?>">
														<span class="input-group-addon">元</span>
													</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*成为商家后可以享受普通会员的所有权限，并且可以发布自己的商品/文章</div>

													</div>
												</div>
												<hr>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">最低提现金额</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_zd" class="form-control" value="<?php echo $C_zd?>">
														<span class="input-group-addon">元</span>
													</div>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-3 col-form-label">提现手续费</label>
													<div class="col-md-9">
														<div class="input-group">
														<input type="text"  name="C_fee" class="form-control" value="<?php echo $C_fee?>">
														<span class="input-group-addon">%</span>
													</div>
													</div>
												</div>
												<hr>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">商品免审核</label>
													<div class="col-md-9 buy">
														<label aa="C_punsh" <?php if($C_punsh==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_punsh" <?php if($C_punsh==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_punsh" <?php if($C_punsh==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_punsh" <?php if($C_punsh==0){echo "checked='checked'";}?>> 关闭</label>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">文章免审核</label>
													<div class="col-md-9 buy">
														<label aa="C_nunsh" <?php if($C_nunsh==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_nunsh" <?php if($C_nunsh==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_nunsh" <?php if($C_nunsh==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_nunsh" <?php if($C_nunsh==0){echo "checked='checked'";}?>> 关闭</label>
													</div>
												</div>
										
												</div>

												<div class="tab-pane fade" id="t6" role="tabpanel" aria-labelledby="contact-tab2">
												<div class="form-group row">
													<label class="col-md-3 col-form-label">电子邮箱</label>
													<div class="col-md-9">
														<input type="text"  name="C_email" class="form-control" value="<?php echo $C_email?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label">邮箱接口</label>
													<div class="col-md-9 buy">
														<label aa="C_mailtype" <?php if($C_mailtype==1){echo "class='checked'";}?> onclick="e_s(1)"><input value="1" type="radio" name="C_mailtype" <?php if($C_mailtype==1){echo "checked='checked'";}?>> 自行提供</label>
														<label aa="C_mailtype" <?php if($C_mailtype==0){echo "class='checked'";}?> onclick="e_s(0)"><input value="0" type="radio" name="C_mailtype" <?php if($C_mailtype==0){echo "checked='checked'";}?>> 官网提供</label>

													</div>
												</div>
												<div id="email_set">
												
												<div class="form-group row">
													<label class="col-md-3 col-form-label">SMTP</label>
													<div class="col-md-9">
														<input type="text"  name="C_smtp" class="form-control" value="<?php echo $C_smtp?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label">邮箱授权码<br>或邮箱密码</label>
													<div class="col-md-9">
														<input type="text"  name="C_mailcode" class="form-control" value="" <?php if($C_mailcode!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h8.html" target="_blank">查看帮助</a></div>

													</div>
												</div>
												</div>
										
												</div>


												<div class="tab-pane fade" id="t10" role="tabpanel" aria-labelledby="contact-tab2">

												<div class="form-group row">
													<label class="col-md-3 col-form-label">短信签名</label>
													<div class="col-md-9">
														<input type="text"  name="C_smssign" class="form-control" value="<?php echo $C_smssign?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label">企业ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_userid" class="form-control" value="<?php echo $C_userid?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label">帐号</label>
													<div class="col-md-9">
														<input type="text"  name="C_codeid" class="form-control" value="<?php echo $C_codeid?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label">密码</label>
													<div class="col-md-9">
														<input type="text"  name="C_codekey" class="form-control" value="" <?php if($C_codekey!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >短信余量</label>
													<div class="col-md-9">
														<div style="margin-top: 5px;"><?php echo $sms_rest?> <button type="button" class="btn btn-info btn-sm" onclick="$('#sms').modal('show');$('#sms_pay').html('<iframe src=\'https://www.s-cms.cn/sms/\' name=\'mapif\' type=\'1\' frameborder=\'0\' height=\'820\' width=\'100%\'></iframe>');">购买短信包</button></div>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-3 col-form-label">您的手机号码</label>
													<div class="col-md-9">
														<input type="text"  name="C_mobile" class="form-control" value="<?php echo $C_mobile?>">
														
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<label class="col-md-3 col-form-label" >短信用途开关</label>
													<div class="col-md-9">
														<label><input value="1" type="checkbox" name="C_dx1" <?php if($C_dx1==1){echo "checked='checked'";}?>> 会员登录</label>（<span class="intro">说明：用户可以使用短信验证码登录会员中心</span>）<br>
														<label><input value="1" type="checkbox" name="C_dx2" <?php if($C_dx2==1){echo "checked='checked'";}?>> 后台登录 </label>（<span class="intro">说明：登录后台的IP变动时向管理员发送验证码</span>）<br>
														<label><input value="1" type="checkbox" name="C_dx3" <?php if($C_dx3==1){echo "checked='checked'";}?>> 提现审核 </label>
														（<span class="intro">说明：用户提交提现申请时提醒管理元审核</span>）<br>
														<label><input value="1" type="checkbox" name="C_dx4" <?php if($C_dx4==1){echo "checked='checked'";}?>> 商户审核 </label>（<span class="intro">说明：商户发布商品/文章时提醒管理员审核</span>）<br>
														<label><input value="1" type="checkbox" name="C_dx5" <?php if($C_dx5==1){echo "checked='checked'";}?>> 发货提醒 </label>
														（<span class="intro">说明：用户购买商品后提醒管理员发货</span>）
													</div>
												</div>

												</div>

												<div class="tab-pane fade" id="t7" role="tabpanel" aria-labelledby="contact-tab2">

												<div class="form-group row">
													<label class="col-md-3 col-form-label">分站功能 <img src="img/vip.png" height="15"></label>
													<div class="col-md-9 buy">
														<label aa="C_fzon" <?php if($C_fzon==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_fzon" <?php if($C_fzon==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_fzon" <?php if($C_fzon==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_fzon" <?php if($C_fzon==0){echo "checked='checked'";}?>> 关闭</label>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">分站权限 </label>
													<div class="col-md-9 buy">
														<label aa="C_fzk" <?php if($C_fzk==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_fzk" <?php if($C_fzk==0){echo "checked='checked'";}?>> 全部用户开启</label>
														<label aa="C_fzk" <?php if($C_fzk==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_fzk" <?php if($C_fzk==1){echo "checked='checked'";}?>> 仅可商户开启</label>
														
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">分站开通VIP提成 </label>
													<div class="col-md-9">
														<div class="input-group">
												            <input type="text" class="form-control" name="C_fzvip" value="<?php echo $C_fzvip?>">
												            <span class="input-group-addon">%</span>
												        </div>
												        <div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*该功能仅适用于站群版授权，请点击<a href="https://fahuo100.cn/h27.html" target="_blank">查看帮助</a></div>
													</div>
												</div>


												<hr>

												<div class="form-group row">
													<label class="col-md-3 col-form-label">伪静态 <img src="img/vip.png" height="15"></label>
													<div class="col-md-9 buy">
														<label aa="C_html" <?php if($C_html==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_html" <?php if($C_html==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_html" <?php if($C_html==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_html" <?php if($C_html==0){echo "checked='checked'";}?>> 关闭</label>
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果开启伪静态，需额外配置文件，请点击<a href="https://fahuo100.cn/h10.html" target="_blank">查看帮助</a></div>
													</div>
												</div>
												

												<div class="form-group row">
													<label class="col-md-3 col-form-label">三级分销 <img src="img/vip.png" height="15"></label>
													<div class="col-md-9">
														<p><div class="input-group">
												            <span class="input-group-addon">一级佣金</span>
												            <input type="text" class="form-control" name="C_fx1" value="<?php echo $C_fx1?>">
												            <span class="input-group-addon">%</span>
												        </div></p>
												        <p><div class="input-group">
												            <span class="input-group-addon">二级佣金</span>
												            <input type="text" class="form-control" name="C_fx2" value="<?php echo $C_fx2?>">
												            <span class="input-group-addon">%</span>
												        </div></p>
												        <p><div class="input-group">
												            <span class="input-group-addon">三级佣金</span>
												            <input type="text" class="form-control" name="C_fx3" value="<?php echo $C_fx3?>">
												            <span class="input-group-addon">%</span>
												        </div></p>
												        <div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">
															*佣金比例设置为0则不开启该级分销功能<br>
															如果不懂如何设置分销规则，请点击<a href="https://fahuo100.cn/h16.html" target="_blank">查看帮助</a></div>
													</div>
												</div>


												<div class="form-group row">
													<label class="col-md-3 col-form-label" >搜索热词</label>
													<div class="col-md-9">
														<input type="text"  name="C_hotwords" class="form-control" value="<?php echo $C_hotwords?>">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">
															*显示在搜索栏下方，多个词使用半角逗号（,）隔开</div>
													</div>
												</div>


												</div>

												<div class="tab-pane fade" id="t8" role="tabpanel" aria-labelledby="contact-tab2">

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >APP/小程序说明：</label>
													<div class="col-md-9">
														1.APP/小程序数据与网站端同步，一次发布多端同时更新<br>
														2.APP支持安卓端及IOS端，小程序支持微信/支付宝/百度/QQ/头条（抖音）共五个平台<br>
														3.点击查看APP/小程序演示 <a href="https://m3w.cn/fh100" target="_blank" class="btn btn-sm btn-primary">查看演示</a>
													</div>
													</div>
													<hr>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信小程序-AppID</label>
													<div class="col-md-9">
														<input type="text"  name="C_wxapp_id" class="form-control" value="<?php echo $C_wxapp_id?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >微信小程序-AppSecret</label>
													<div class="col-md-9">
														<input type="text"  name="C_wxapp_key" class="form-control" value="" <?php if($C_wxapp_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>
													<hr>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付宝小程序-AppID</label>
													<div class="col-md-9">
														<input type="text"  name="C_aliapp_id" class="form-control" value="<?php echo $C_aliapp_id?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付宝小程序-应用私钥</label>
													<div class="col-md-9">
														<textarea name="C_aliapp_key" class="form-control" rows="3" <?php if($C_aliapp_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>></textarea>
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >支付宝小程序-支付宝公钥</label>
													<div class="col-md-9">
														<textarea name="C_aliapp_key2" class="form-control" rows="3" <?php if($C_aliapp_key2!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>></textarea>
													</div>
													</div>
													<hr>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >百度小程序-App ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_bdapp_id" class="form-control" value="<?php echo $C_bdapp_id?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >百度小程序-App Key</label>
													<div class="col-md-9">
														<input type="text"  name="C_bdapp_key" class="form-control" value="" <?php if($C_bdapp_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >百度小程序-App Secret</label>
													<div class="col-md-9">
														<input type="text"  name="C_bdapp_key2" class="form-control" value="" <?php if($C_bdapp_key2!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>
													<hr>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >QQ小程序-AppID</label>
													<div class="col-md-9">
														<input type="text"  name="C_qqapp_id" class="form-control" value="<?php echo $C_qqapp_id?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >QQ小程序-AppSecret</label>
													<div class="col-md-9">
														<input type="text"  name="C_qqapp_key" class="form-control" value="" <?php if($C_qqapp_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>
													<hr>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >字节跳动小程序-AppID</label>
													<div class="col-md-9">
														<input type="text"  name="C_zjapp_id" class="form-control" value="<?php echo $C_zjapp_id?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >字节跳动小程序-AppSecret</label>
													<div class="col-md-9">
														<input type="text"  name="C_zjapp_key" class="form-control" value="" <?php if($C_zjapp_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >字节跳动小程序-商户号</label>
													<div class="col-md-9">
														<input type="text"  name="C_ttpay_mchid" class="form-control" value="<?php echo $C_ttpay_mchid?>">
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >字节跳动小程序-支付AppID</label>
													<div class="col-md-9">
														<input type="text"  name="C_ttpay_appid" class="form-control" value="<?php echo $C_ttpay_appid?>">
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >字节跳动小程序-支付secret</label>
													<div class="col-md-9">
														<input type="text"  name="C_ttpay_secret" class="form-control" value="" <?php if($C_ttpay_secret!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >选择模板</label>
													<div class="col-md-9">
														<label><input type="radio" name="C_appt" value="shop" <?php if($C_appt=="shop"){echo "checked='checked'";}?>> 商城型</label> <button type="button" class="btn btn-info btn-sm" onclick="show('t1')">演示</button>
														<label><input type="radio" name="C_appt" value="news" <?php if($C_appt=="news"){echo "checked='checked'";}?>> 文章型</label> <button type="button" class="btn btn-info btn-sm" onclick="show('t2')">演示</button>
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >生成代码包</label>
													<div class="col-md-9">
														<button type="button" onClick="save()" class="btn btn-info">保存信息</button>
														<button type="button" onClick="creat()" class="btn btn-primary">生成代码包</button>
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >说明</label>
													<div class="col-md-9">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如何不知道如何生成，请点击<a href="https://fahuo100.cn/h12.html" target="_blank">生成教程</a>和<a href="https://fahuo100.cn/h13.html" target="_blank">配置教程</a></div>
													</div>
													</div>

												</div>


												<div class="tab-pane fade" id="t9" role="tabpanel" aria-labelledby="contact-tab2">
													<div class="form-group row">
														<label class="col-md-3 col-form-label">后台二次验证</label>
														<div class="col-md-9 buy">
															<label aa="C_twice" <?php if($C_twice==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_twice" <?php if($C_twice==1){echo "checked='checked'";}?>> 开启</label>
															<label aa="C_twice" <?php if($C_twice==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_twice" <?php if($C_twice==0){echo "checked='checked'";}?>> 关闭</label>
															<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*当登录IP有变动时会触发二次验证</div>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-md-3 col-form-label">滑块验证</label>
														<div class="col-md-9 buy">
															<label aa="C_slide" <?php if($C_slide==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_slide" <?php if($C_slide==1){echo "checked='checked'";}?>> 开启</label>
															<label aa="C_slide" <?php if($C_slide==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_slide" <?php if($C_slide==0){echo "checked='checked'";}?>> 关闭</label>
															<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*会员中心及后台登录时拖动滑块验证</div>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-md-3 col-form-label">页面防复制</label>
														<div class="col-md-9 buy">
															<label aa="C_uncopy" <?php if($C_uncopy==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_uncopy" <?php if($C_uncopy==1){echo "checked='checked'";}?>> 开启</label>
															<label aa="C_uncopy" <?php if($C_uncopy==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_uncopy" <?php if($C_uncopy==0){echo "checked='checked'";}?>> 关闭</label>

															<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*禁用鼠标右键，防止页面内容被复制</div>

														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">数据自动备份</label>
														<div class="col-md-9 buy">
															<label aa="C_backup" <?php if($C_backup==1){echo "class='checked'";}?>><input value="1" type="radio" name="C_backup" <?php if($C_backup==1){echo "checked='checked'";}?>> 开启</label>
															<label aa="C_backup" <?php if($C_backup==0){echo "class='checked'";}?>><input value="0" type="radio" name="C_backup" <?php if($C_backup==0){echo "checked='checked'";}?>> 关闭</label>
															<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*每次登录后台时，自动备份一次数据库</div>

														</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >允许上传格式</label>
													<div class="col-md-9">
														<input type="text"  name="C_format" class="form-control" value="<?php echo $C_format?>">
													</div>
													</div>



													<div class="form-group row">
														<label class="col-md-3 col-form-label">后台路径</label>
														<div class="col-md-3 buy">
						<div class="input-group">
		                    <input type="text" class="form-control" name="C_admin" id="C_admin" value="<?php echo $C_admin?>">
		                    <span class="input-group-btn">
		                        <button class="btn btn-info" type="button" onclick="changeadmin()">修改</button>
		                    </span>
		                </div>

														</div>
													</div>

												</div>


												<div class="tab-pane fade" id="t11" role="tabpanel" aria-labelledby="contact-tab2">
													<div class="form-group row">
														<label class="col-md-3 col-form-label">sitemap</label>
														<div class="col-md-9">
															<textarea class="form-control" rows="10"><?php echo $sitemap?></textarea>
														</div>
													</div>

													<div class="form-group row">

														<label class="col-md-3 col-form-label"></label>
														<div class="col-md-9">
															<button class="btn btn-info" type="button" onclick="sitemap()">生成sitemap</button>
															<span id="sitemap_info"></span>
														</div>
														
													</div>
													<hr>
													<div class="form-group row">
													<label class="col-md-3 col-form-label">百度站长TOKEN</label>
													<div class="col-md-9">
														<input type="text"  name="C_bd_token" class="form-control" value="" <?php if($C_bd_token!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>

													<div class="form-group row">
														<label class="col-md-3 col-form-label"></label>
														<div class="col-md-9">
															<button class="btn btn-info" type="button" onclick="push()">推送页面</button>
				<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">*如果您不知道如何使用以上功能，请点击<a href="http://fahuo100.cn/h32.html" target="_blank">使用帮助</a></div>
														</div>
														
													</div>

												</div>

												<div class="tab-pane fade" id="t12" role="tabpanel" aria-labelledby="contact-tab2">
													<div class="form-group row">
													<label class="col-md-3 col-form-label">开启云储存 <img src="img/vip.png" height="15"></label>
													<div class="col-md-9 buy">
														<label aa="C_html" <?php if($C_osson==1){echo "class='checked'";}?> onclick="showoss(1)"><input value="1" type="radio" name="C_osson" <?php if($C_osson==1){echo "checked='checked'";}?>> 开启</label>
														<label aa="C_html" <?php if($C_osson==0){echo "class='checked'";}?> onclick="showoss(0)"><input value="0" type="radio" name="C_osson" <?php if($C_osson==0){echo "checked='checked'";}?>> 关闭</label>

													</div>
												</div>

												<div id="oss_set">
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >Access Key ID</label>
													<div class="col-md-9">
														<input type="text"  name="C_oss_id" class="form-control" value="<?php echo $C_oss_id?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >Access Key Secret</label>
													<div class="col-md-9">
														<input type="text"  name="C_oss_key" class="form-control" value="" <?php if($C_oss_key!=""){echo "placeholder=\"已加密保存，留空则不修改\"";}?>>
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >bucket</label>
													<div class="col-md-9">
														<input type="text"  name="C_bucket" class="form-control" value="<?php echo $C_bucket?>">
													</div>
													</div>
													<div class="form-group row">
													<label class="col-md-3 col-form-label" >Endpoint</label>
													<div class="col-md-9">
														<input type="text"  name="C_region" class="form-control" value="<?php echo $C_region?>">
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" >自定义域名</label>
													<div class="col-md-9">
														<input type="text"  name="C_oss_domain" class="form-control" value="<?php echo $C_oss_domain?>" placeholder="以http或https开头，结尾不要加/">
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<button style="display: none;" id="stop" onclick="uppic('stop')" class="btn btn-sm btn-primary" type="button">停止上传</button>
														<button class="btn btn-sm btn-info" onclick="oss()" type="button" id="ossbtn">一键同步本地文件</button> *将之前上传的图片文件一键同步到OSS
															<div class="progress progress-striped active" style="margin-top: 10px;margin-bottom:0px;display: none" id="progressx">
														        <div class="progress-bar progress-bar-success" role="progressbar"
														           aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
														           style="width: 0%;" id="progress">
														        </div>
														      </div>
														      <div id="info" style="margin-top: 5px;display: none">已上传0个文件</div>
														      <button type="button" onclick="reuploadx()" class="btn btn-primary btn-xs" style="display: none;" id="reupload">重新上传</button>
													</div>
													</div>

													<div class="form-group row">
													<label class="col-md-3 col-form-label" ></label>
													<div class="col-md-9">
														<div style="margin-top: 10px;font-size: 12px;color: #AAAAAA">
															*使用OSS云储存功能可以极大的提高图片加载速度并且节省本地空间<br>
															如果您不知道如何填写，请点击<a href="https://fahuo100.cn/h26.html" target="_blank">查看帮助</a> 提供平台：<a href="https://www.aliyun.com/product/oss" target="_balnk">阿里云OSS云存储</a></div>

													</div>
												</div>
											</div>

												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<button class="btn btn-primary" type="button" onClick="save()" style="margin-bottom: 20px;margin-right: 20px;">保存</button>
									说明：带 <img src="img/vip.png" height="15"> 标识的功能仅限授权版用户使用。
								</div>
							
							</div>
							</form>
						</div>
					</section>
				</div>

			</div>
		</div>

		<!-- Large Modal -->
		<div id="sms" class="modal fade">
			<div class="modal-dialog modal-lg" role="document" >
				<div class="modal-content " style="max-width: 900px;width:100%">
					<div class="modal-header pd-x-20">
						<h6 class="modal-title">购买授权</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div id="sms_pay"></div>
				</div>
			</div><!-- modal-dialog -->
		</div><!-- modal -->

		<!-- Large Modal -->
		<div id="appt" class="modal fade">
			<div class="modal-dialog" role="document" >
				<div class="modal-content " style="width: 430px">
					<div class="modal-header pd-x-20">
						<h6 class="modal-title">模板演示</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div id="app_show"></div>
				</div>
			</div><!-- modal-dialog -->
		</div><!-- modal -->

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/toggle-menu/sidemenu.js"></script>
		<script src="assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/help.js"></script>
		<script src="assets/plugins/toastr/build/toastr.min.js"></script>

		<script type="text/javascript">

		function oss(){
			window.stop=0;
        	toastr.warning("正在计算文件个数"); 
        	$.ajax({
            	url:'?action=oss',
            	type:'post',
            	data:$("#form").serialize(),
            	success:function (data) {
            		window.response=data;
            		window.count=data.split("|").length-1;
            		$.ajax({
	            	url:'?action=save',
	            	type:'post',
	            	data:$("#form").serialize(),
	            	success:function (data) {
	            	if(data=="success"){
			            uppic(0);
	            	}else{
	            		toastr.error(data, '错误');
	            	}
	            	}
	            });
            	}
            });
		}
		function push(){
			//console.log($("#form").serialize());
				$.ajax({
	            	url:'?action=save',
	            	type:'post',
	            	data:$("#form").serialize(),
	            	success:function (data) {
		            	if(data=="success"){
				            $.ajax({
				            	url:'?action=push',
				            	type:'post',
				            	data:$("#form").serialize(),
				            	success:function (data) {
				            		data=JSON.parse(data);
					            	if(data.code=="success"){
					            		toastr.success(data.msg, '成功');
					            	}else{
					            		toastr.error(data.msg, '错误');
					            	}
				            	}
				            });

		            	}else{
		            		toastr.error(data, '错误');
		            	}
	            	}
	            });
		}

		function uppic(i) {
        if(i=="stop"){
            window.stop=1;
            $("#progressx").hide();
            $("#info").hide();
            $("#stop").hide();
            $("#ossbtn").show();
            toastr.success("上传已停止"); 
            return false;
        }

        if(window.count==0){
            toastr.success("本地文件上传完毕"); 
            $("#info").show();
            $("#reupload").show();
            $("#info").html("所有文件上传完毕");
        }else{
            if(window.stop==0){
                $("#progressx").show();
                $("#info").show();
                $("#stop").show();
                $("#ossbtn").hide();
                $("#reupload").hide();

                if(i==0){
                    toastr.warning("正在上传中，请勿关闭页面..."); 
                }

                $.ajax({
                    type: "post",
                    url: "?action=uppic&file="+window.response.split("|")[i],
                    data: "1",
                    success: function(data) {
                        if(data=="success"){
                            $("#progress").attr("style","width: "+((i+1)/window.count)*100+"%");
                            $("#progress").html((((i+1)/window.count)*100).toFixed(2)+"%");
                            if(i<window.count-1){
                                $("#info").html("<span style='color:#009900'>已上传"+i+"个文件（共"+window.count+"个），正在上传 "+window.response.split("|")[i]+"</span>");
                                uppic(i+1);
                            }else{
                                $("#reupload").show();
                                $("#info").html("所有文件已上传完毕");
                                toastr.clear();
                                toastr.success("本地文件上传完毕"); 
                            }
                        }else{
                            toastr.clear();
                            toastr.error("OSS信息配置有误，请重新检查"); 
                        }
                    },
                    error:function(data) {
                        uppic(i+1);
                    }
                })
            }
        }
    };

    function reuploadx(){
    	$.ajax({
        	url:'?action=reupload',
        	type:'get',
        	success:function (data) {
	        	if(data=="success"){
	        		oss();
	        	}else{
	        		toastr.error(data, '错误');
	        	}
        	}
        });
    }

		function show(T_id){
			$('#appt').modal('show');
			$('#app_show').html('<iframe src="http://fhdemo.s-cms.cn/'+T_id+'/wap/" style="border:none;height:700px;width:100%"></iframe>')
		}
		function save(){
			console.log($("#form").serialize());
				$.ajax({
	            	url:'?action=save',
	            	type:'post',
	            	data:$("#form").serialize(),
	            	success:function (data) {
	            	if(data=="success"){
	            		toastr.success("保存成功", "成功");
	            	}else{
	            		toastr.error(data, '错误');
	            	}
	            	}
	            });
			}

			function changeadmin(){
				$.ajax({
	            	url:'?action=changeadmin',
	            	type:'post',
	            	data:$("#form").serialize(),
	            	success:function (data) {
		            	data=JSON.parse(data);
		            	if(data.code=="success"){
		            		alert(data.msg);
		            		window.location.href="../"+data.admin;
		            	}else{
		            		toastr.error(data.msg, '错误');
		            	}
	            	}
	            });
			}

			function creat(){
				var C_appt=$("input[name='C_appt']:checked").val();
				$.ajax({
	            	url:'?action=creat',
	            	type:'post',
	            	data:$("#form").serialize(),
	            	success:function (data) {
	            	data=JSON.parse(data);
	            	if(data.msg=="success"){
	            		toastr.success("生成成功", "成功");
	            		window.location.href="http://fh.s-cms.cn/app/download/"+data.url+".zip";
	            	}else{
	            		toastr.error(data.msg, '错误');
	            	}
	            	}
	            });
			}

			function sitemap(){
				$.ajax({
	            	url:'?action=sitemap',
	            	type:'post',
	            	data:$("#form").serialize(),
	            	success:function (data) {
	            	data=JSON.parse(data);
	            	if(data.msg=="success"){
	            		$("#sitemap_info").html(data.info);
	            	}else{
	            		toastr.error(data.msg, '错误');
	            	}
	            	}
	            });
			}
			function e_s($s){
				if($s==1){
					$("#email_set").show();
				}else{
					$("#email_set").hide();
				}
			}
			function showoss($s){
				if($s==1){
					$("#oss_set").show();
				}else{
					$("#oss_set").hide();
				}
			}
			$(function() { 
				$('.buy label').click(function(){var aa = $(this).attr('aa');$('[aa="'+aa+'"]').removeAttr('class') ;$(this).attr('class','checked');});
				var C_mailtype=<?php echo $C_mailtype?>;
				if(C_mailtype==1){
					$("#email_set").show();
				}else{
					$("#email_set").hide();
				}

				var C_osson=<?php echo $C_osson?>;
				if(C_osson==1){
					$("#oss_set").show();
				}else{
					$("#oss_set").hide();
				}
			});
		</script>
	</body>
</html>
