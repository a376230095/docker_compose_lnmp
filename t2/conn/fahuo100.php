<?php
require '../conn/conn.php';
require '../conn/function.php';

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/conn",0);

switch ($_GET["action"]) {
	case "collection":
	?>
function c(){
if(document.getElementById("collection_product")){
		$.ajax({
	    url: "conn/fahuo100.php?action=check_collection&type=product&id="+$("#collection_product").attr("pid"),
	    type: 'get',
	    success:function(res){
		    if(res=="true"){
		    	$("#collection_product").html("<a href='javascript:collect(\"product\","+$("#collection_product").attr("pid")+");'><span style='color: #ff9900;'>★</span> 已加入收藏</a>");
			}else{
				$("#collection_product").html("<a href='javascript:collect(\"product\","+$("#collection_product").attr("pid")+");'><span style='color: #ff9900;'>☆</span> 加入收藏</a>");
			}	
		}
	  });
	}
	if(document.getElementById("collection_news")){
		$.ajax({
	    url: "conn/fahuo100.php?action=check_collection&type=news&id="+$("#collection_news").attr("nid"),
	    type: 'get',
	    success:function(res){
		    if(res=="true"){
		    	$("#collection_news").html("<a href='javascript:collect(\"news\","+$("#collection_news").attr("nid")+");'><span style='color: #ff9900;'>★</span> 已加入收藏</a>");
			}else{
				$("#collection_news").html("<a href='javascript:collect(\"news\","+$("#collection_news").attr("nid")+");'><span style='color: #ff9900;'>☆</span> 加入收藏</a>");
			}	
		}
	  });
	}
	if(document.getElementById("collection_shop")){
		$.ajax({
	    url: "conn/fahuo100.php?action=check_collection&type=shop&id="+$("#collection_shop").attr("mid"),
	    type: 'get',
	    success:function(res){
		    if(res=="true"){
		    	$("#collection_shop").html("<a href='javascript:collect(\"shop\","+$("#collection_shop").attr("mid")+");'><span style='color: #ff9900;'>★</span> 已收藏店铺</a>");
			}else{
				$("#collection_shop").html("<a href='javascript:collect(\"shop\","+$("#collection_shop").attr("mid")+");'><span style='color: #ff9900;'>☆</span> 收藏店铺</a>");
			}
		}
	  });
	}
}

	function collect(type,id){
		$.ajax({
	    url: "conn/fahuo100.php?action=collect&type="+type+"&id="+id,
	    type: 'get',
	    success:function(res){
		    data=JSON.parse(res);
		    if(data.code=="error"){
		    	alert(data.msg);
			}else{
				c();
			}
		}
	  });
	}
c();
	<?php
	break;
	case "collect":
	$type=$_GET["type"];
	$id=intval($_GET["id"]);
	switch($type){
		case "product":
			$C_type=0;
		break;
		case "news":
			$C_type=1;
		break;
		case "shop":
			$C_type=2;
			if($id==0){
				die("{\"code\":\"error\",\"msg\":\"官方自营店不支持收藏\"}");
			}
		break;
	}
	if(intval($_SESSION["M_id"])==0){
		die("{\"code\":\"error\",\"msg\":\"请登录会员后操作\"}");
	}else{
		if(getrs("select * from sl_colletion where C_type=$C_type and C_mid=".intval($_SESSION["M_id"])." and C_cid=$id","C_id")!=""){
			mysqli_query($conn,"delete from sl_colletion where C_type=$C_type and C_mid=".intval($_SESSION["M_id"])." and C_cid=$id");
			die("{\"code\":\"success\",\"msg\":\"取消收藏\"}");
		}else{
			mysqli_query($conn,"insert into sl_colletion(C_type,C_mid,C_cid) values($C_type,".intval($_SESSION["M_id"]).",$id)");
			die("{\"code\":\"success\",\"msg\":\"收藏成功\"}");
		}
	}
	break;
	case "check_collection":
	$type=$_GET["type"];
	$id=intval($_GET["id"]);
	switch($type){
		case "product":
			$C_type=0;
		break;
		case "news":
			$C_type=1;
		break;
		case "shop":
			$C_type=2;
		break;
	}
	if(intval($_SESSION["M_id"])==0){
		die("false");
	}else{
		if(getrs("select * from sl_colletion where C_type=$C_type and C_mid=".intval($_SESSION["M_id"])." and C_cid=$id","C_id")==""){
			die("false");
		}else{
			die("true");
		}
	}

	break;
	case "wxjs":
?>$.ajax({
    url: "conn/fahuo100.php?action=jssdk",
    type: 'post',
    data: { url: location.href.split('#')[0],action:"jssdk",pagetype:"<?php echo htmlspecialchars($_GET["type"])?>",pageid:"<?php echo intval($_GET["id"])?>" },
    success:function(res){
    res=JSON.parse(res);
      wx.config({
        debug: false,
        appId: res.appid,
        timestamp: res.timestamp,
        nonceStr: res.nonceStr,
        signature: res.signature,
        jsApiList: [
          'checkJsApi',
          'onMenuShareTimeline',
          'onMenuShareAppMessage',
          'onMenuShareQQ'
        ]
      }); 
      wx.ready(function () {
        var shareData = {
          title: document.title,
          desc: getDesc(),
          link: res.url,
          imgUrl: res.img
        };
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);
        wx.onMenuShareQQ(shareData);
      });
      wx.error(function (res) {
       
      });
    }
  });

  function getDesc() {
    var meta = document.getElementsByTagName("meta");
    for (var i=0;i<meta.length;i++){
      if(typeof meta[i].name!="undefined"&&meta[i].name.toLowerCase()=="description"){
        return meta[i].content;
      }
    }
};
<?php
break;

case "jssdk":
	$APPID = $C_wx_appid;
	$APPSECRET = $C_wx_appsecret;
	$info=getbody("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET,"");
	$access_token=json_decode($info)->access_token;
	$info=getbody("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi","");
	$ticket=json_decode($info)->ticket;
	$url=$_POST["url"];
	$noncestr=gen_key(20);
	$timestamp=time();
	$pageid=$_POST["pageid"];

	if($pageid==""){
		$pageid=1;
	}else{
	  	$pageid=intval($pageid);
	}
	switch($_POST["pagetype"]){

		case "index":
			$img=$C_ico;
		break;

		case "text":
			$img=getrs("select * from sl_text where T_id=".$pageid,"T_pic");
		break;

		case "product":
			$img=getrs("select * from sl_psort where S_id=".$pageid,"S_pic");
		break;

		case "productinfo":
			$img=splitx(getrs("select * from sl_product where P_id=".$pageid,"P_pic"),"|",0);
		break;

		case "news":
			$img=getrs("select * from sl_nsort where S_id=".$pageid,"S_pic");
		break;

		case "newsinfo":
			$img=getrs("select * from sl_news where N_id=".$pageid,"N_pic");
		break;

		case "form":
			$img=getrs("select * from sl_form where F_id=".$pageid,"F_pic");
		break;

		case "contact":
			$img=$C_ico;
		break;

		case "guestbook":
			$img=$C_ico;
		break;

		default:
			$img=$C_ico;
		break;
	}

	$sign=sha1("jsapi_ticket=".$ticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$url);

	die("{\"nonceStr\":\"".$noncestr."\",\"timestamp\":\"".$timestamp."\",\"signature\":\"".$sign."\",\"appid\":\"".$APPID."\",\"img\":\"".gethttp().$D_domain."/media/".$img."\",\"ticket\":\"".$ticket."\"}");
break;
	
	default:
		# code...
		break;
}

?>