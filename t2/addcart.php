<?php
require 'conn/conn.php';
require 'conn/function.php';
$type=$_GET["type"];
$id=intval($_GET["id"]);
$no=intval($_POST["no"]);
if($no<1){
	die("购买数量有误！");
}
$address=intval($_POST["A_address"]);

if($_SESSION["M_id"]==""){
	die("请登录会员帐号后继续购买！");
}else{
	$sql="Select * from sl_member where M_id=".intval($_SESSION["M_id"]);
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
}

if($type=="addcart"){
	$sql="select * from sl_product where P_del=0 and P_id=".$id;
	$result = mysqli_query($conn, $sql);
	  $row = mysqli_fetch_assoc($result);
	  if (mysqli_num_rows($result) > 0) {
	    $P_title=$row["P_title"];
	    $P_pic=splitx($row["P_pic"],"|",0);
	    $P_sell=$row["P_sell"];
	    $P_selltype=$row["P_selltype"];
	    $P_mid=$row["P_mid"];
	    $P_vip=$row["P_vip"];

	    if($P_vip==1){
	    	$P_price=p($row["P_price"]*$P_discount);
	    }else{
	    	$P_price=p($row["P_price"]);
	    }

	    if($P_mid==$M_id){
	    	die("无法购买自己的商品");
	    }

	    if($P_price==0){
	    	die("免费商品不支持加入购物车，请点击立即购买");
	    }

		if($no>1 && $P_selltype==0){
		 	die("该商品每次只可买一件！");
		}

	  }else{
	  	die("该商品未找到！");
	  }

	  switch($P_selltype){
	  	case 0:
	  		$O_address=getrs("select * from sl_member where M_id=".intval($M_id),"M_email");
	  	break;
	  	case 1:
			$O_address=getrs("select * from sl_member where M_id=".intval($M_id),"M_email");
	  	break;
	  	case 2:
		  	if($address==0){
		  		$A_id=getrs("select * from sl_address where A_mid=".intval($M_id)." order by A_default desc","A_id");
		  		if($A_id!=""){
		  			$O_address=getrs("select * from sl_address where A_id=".$A_id,"A_address")." ".getrs("select * from sl_address where A_id=".$A_id,"A_name")." ".getrs("select * from sl_address where A_id=".$A_id,"A_phone");
		  		}else{
		  			die("请先完善您的收货信息");
		  		}
		  	}else{
		  		$O_address=getrs("select * from sl_address where A_id=".$address,"A_address")." ".getrs("select * from sl_address where A_id=".$address,"A_name")." ".getrs("select * from sl_address where A_id=".$address,"A_phone");
		  	}
	  	break;
	  }
	  mysqli_query($conn, "insert into sl_orders(O_pid,O_mid,O_time,O_type,O_price,O_num,O_content,O_title,O_pic,O_address,O_state,O_genkey,O_sellmid) values($id,$M_id,'".date('Y-m-d H:i:s')."',0,".$P_price.",$no,'','$P_title','$P_pic','$O_address',0,'".gen_key(20)."',$P_mid)");

	die("success");
}
?>