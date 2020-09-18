<?php
require_once("../../conn/conn.php");
require_once("../../conn/function.php");

$D_domain=splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/pay",0);

ksort($_POST); //排序post参数
reset($_POST); //内部指针指向数组中的第一个元素

$sign = '';//初始化
foreach ($_POST AS $key => $val) { //遍历POST参数
    if ($val == '' || $key == 'sign') continue; //跳过这些不签名
    if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
    $sign .= "$key=$val"; //拼接为url参数形式
}
if (!$_POST['pay_no'] || md5($sign . $C_codepay_key) != $_POST['sign']) { //不合法的数据
    exit('fail');  //返回失败 继续补单
} else { //合法的数据
    //业务处理
	$pay_id = $_POST['pay_id']; //需要充值的ID 或订单号 或用户名
	$money = (float)$_POST['money']; //实际付款金额
	$price = (float)$_POST['price']; //订单的原价
	$param = intval($_POST['param']); //自定义参数
	$pay_no = t($_POST['pay_no']); //流水号

	if(substr($pay_no,0,4)!="4200"){
		$sql="select * from sl_list where L_mid=".$param." and L_no='".$pay_no."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) > 0) {

		}else{
			mysqli_query($conn,"update sl_member set M_money=M_money+".$money." where M_id=".$param);
			mysqli_query($conn,"insert into sl_list(L_mid,L_no,L_title,L_time,L_money,L_genkey) values(".$param.",'$pay_no','帐号充值','".date('Y-m-d H:i:s')."',".$money.",'')");
		}
	}

	exit('success'); //返回成功 不要删除哦
}

?>