<?php
if($_SESSION["A_login"]=="" || $_SESSION["A_pwd"]==""){
	Header("Location: login.php");
    die();
}else{
	$sql="select * from sl_admin where A_login='".$_SESSION["A_login"]."' and A_pwd='".$_SESSION["A_pwd"]."' and A_del=0";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result) > 0) {
		$A_part=$row["A_part"];
		if($A_part==""){
			$A0_0x=1;
			$A1_0x=1;
			$A1_1x=1;
			$A1_2x=1;
			$A1_3x=1;
			$A1_4x=1;
			$A1_5x=1;
			$A2_0x=1;
			$A2_1x=1;
			$A2_2x=1;
			$A2_3x=1;
			$A3_0x=1;
			$A3_1x=1;
			$A3_2x=1;
			$A3_3x=1;
			$A3_4x=1;
			$A4_0x=1;
			$A4_1x=1;
			$A4_2x=1;
			$A5_0x=1;
			$A5_1x=1;
			$A5_2x=1;
			$A5_3x=1;
			$A6_0x=1;
		}else{
			$A0_0x=splitx(splitx($A_part,"A0_0:",1),",",0);
			$A1_0x=splitx(splitx($A_part,"A1_0:",1),",",0);
			$A1_1x=splitx(splitx($A_part,"A1_1:",1),",",0);
			$A1_2x=splitx(splitx($A_part,"A1_2:",1),",",0);
			$A1_3x=splitx(splitx($A_part,"A1_3:",1),",",0);
			$A1_4x=splitx(splitx($A_part,"A1_4:",1),",",0);
			$A1_5x=splitx(splitx($A_part,"A1_5:",1),",",0);
			$A2_0x=splitx(splitx($A_part,"A2_0:",1),",",0);
			$A2_1x=splitx(splitx($A_part,"A2_1:",1),",",0);
			$A2_2x=splitx(splitx($A_part,"A2_2:",1),",",0);
			$A2_3x=splitx(splitx($A_part,"A2_3:",1),",",0);
			$A3_0x=splitx(splitx($A_part,"A3_0:",1),",",0);
			$A3_1x=splitx(splitx($A_part,"A3_1:",1),",",0);
			$A3_2x=splitx(splitx($A_part,"A3_2:",1),",",0);
			$A3_3x=splitx(splitx($A_part,"A3_3:",1),",",0);
			$A3_4x=splitx(splitx($A_part,"A3_4:",1),",",0);
			$A4_0x=splitx(splitx($A_part,"A4_0:",1),",",0);
			$A4_1x=splitx(splitx($A_part,"A4_1:",1),",",0);
			$A4_2x=splitx(splitx($A_part,"A4_2:",1),",",0);
			$A5_0x=splitx(splitx($A_part,"A5_0:",1),",",0);
			$A5_1x=splitx(splitx($A_part,"A5_1:",1),",",0);
			$A5_2x=splitx(splitx($A_part,"A5_2:",1),",",0);
			$A5_3x=splitx(splitx($A_part,"A5_3:",1),",",0);
			$A6_0x=splitx(splitx($A_part,"A6_0:",1),",",0);
		}

		$page=substr(strrchr($_SERVER['PHP_SELF'], '/'), 1);
		switch($page){
			case "index.php":
			if($A0_0x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "config.php":
			if($A1_0x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "vip.php":
			if($A1_1x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "template.php":
			if($A1_2x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "slide.php":
			if($A1_3x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "link.php":
			if($A1_4x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "menu.php":
			if($A1_5x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "text.php":
			if($A2_0x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "product_list.php":
			case "product_add.php":
			case "psort_add.php":
			if($A2_1x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "news_list.php":
			case "news_add.php":
			case "nsort_add.php":
			if($A2_2x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "card_list.php":
			case "card_add.php":
			case "csort_add.php":
			if($A2_3x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;

			case "orders_list.php":
			case "send.php":
			if($A3_0x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "evaluate.php":
			if($A3_1x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "list.php":
			if($A3_2x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "wholesale.php":
			if($A3_3x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "rcard_list.php":
			if($A3_4x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;

			//case "admin.php":
			//if($A4_0x!=1){
			//	die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			//}
			//break;

			case "member.php":
			if($_GET["type"]==0){
				if($A4_1x!=1){
					die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
				}
			}
			if($_GET["type"]==1){
				if($A4_2x!=1){
					die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
				}
			}
			case "log.php":
			if($A5_0x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "recycle.php":
			if($A5_1x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "guestbook.php":
			if($A5_2x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "config2.php":
			if($A5_3x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			case "update.php":
			if($A6_0x!=1){
				die("您没有该页面的管理权限，请联系顶级管理员！<a href=\"javascript:history.back();\">点击返回</a>");
			}
			break;
			break;
		}
	}else{
		Header("Location: login.php");
    	die();
	}
}
?>