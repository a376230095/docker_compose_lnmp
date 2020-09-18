$("body").append("<div id='adx' style='position:fixed;right:5px;bottom:5px;z-index:9999999999;'></div>")
ad="<div style='font-size:12px;margin-right:3px;'><a href='https://www.s-cms.cn/pay.html?from=ad' target='_blank'>去除广告[×]</a> <a href='https://www.s-cms.cn/newsinfo_80.html' target='_blank' style='float:right;'>广告位招商[√]</a></div>";
info2="<iframe src='https://www.s-cms.cn/ad.htm' style='width:200px;height:200px;border:none'></iframe>";
$.ajax({
	url: "https://www.s-cms.cn/access.html?action=ad&domain="+window.location.host,
	type: "GET",
	dataType: "jsonp",
	success: function (data) {
	    if(data.auth=="success"){
	    	console.log("success "+window.location.host)
	    }else{
	    	$("#adx").html(ad+info2);
	    }
	}
});