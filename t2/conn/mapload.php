<?php
$C_zb=htmlspecialchars($_GET["C_zb"]);
$C_address=htmlspecialchars($_GET["C_address"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	 <script type="text/javascript" src="../js/jquery.min.js"></script>
	 <script src="https://api.map.baidu.com/api?v=2.0&ak=UwrDLDbFuAtRiZXGzkgx4c3m&s=1"></script>
    <style type="text/css">
    body{margin: 0; padding: 0; font:12px/1 "Microsoft Yahei", "微软雅黑", sans-serif;}
    p, span {
      font-family: 'Microsoft Yahei'!important;
    }
    </style>
</head>
<body>
	<div id="map">
	    <div style="width: 100%; height: 503px;" id="allmap"></div>
	</div>
</body>
</html>
<script type="text/javascript">
    $(function () {
        ShowMap('<?php echo $C_zb?>', '', '<?php echo $C_address?>','','', '15');
    })
    function getInfo(id) {
        $.ajax({
            type: "POST",
            url: "WebUserControl/Contact/GetInfo.ashx",
            cache: false,
            async: false,
            data: { ID: id },
            success: function (data) {
                data = eval(data);
                var length = data.length;
                if (length > 0) {
                    ShowMap(data[0]["Image"], data[0]["NewsTitle"], data[0]["Address"], data[0]["Phone"], data[0]["NewsTags"], data[0]["NewsNum"]);
                }
            }
        });
    }
    function ShowMap(zuobiao, name, addrsee, phone, chuanzhen, zoom) {
        var arrzuobiao = zuobiao.split(',');
        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(arrzuobiao[0], arrzuobiao[1]), zoom);
        map.addControl(new BMap.NavigationControl());
        var marker = new BMap.Marker(new BMap.Point(arrzuobiao[0], arrzuobiao[1]));
        map.addOverlay(marker);
        var infoWindow = new BMap.InfoWindow('<p style="color: #bf0008;font-size:14px;">' + name + '</p><p>地址：' + addrsee + '</p>');
        marker.addEventListener("click", function () {
            this.openInfoWindow(infoWindow);
        });
map.enableScrollWheelZoom(true);
        marker.openInfoWindow(infoWindow);
    }
</script>