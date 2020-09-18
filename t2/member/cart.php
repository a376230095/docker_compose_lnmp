<?php 
require '../conn/conn.php';
require '../conn/function.php';
require 'member_check.php';

$action=$_GET["action"];
if($action=="del"){
	$O_id=intval($_GET["O_id"]);
	mysqli_query($conn,"delete from sl_orders  where O_id=$O_id and O_state=0 and O_mid=".$M_id);
	die("success");
}


if($action=="delall"){
	$id=$_POST["O"];
	if(count($id)>0) {
		$shu=0 ;
		for ($i=0 ;$i<count($id);$i++ ) {
			mysqli_query($conn,"delete from sl_orders where O_id=".intval($id[$i])." and O_state=0 and O_mid=".$M_id);
			$shu=$shu+1 ;
			$ids=$ids.$id[$i].",";
		}
		$ids= substr($ids,0,strlen($ids)-1);
		if($shu>0) {
			die("{\"msg\":\"success\",\"ids\":\"".$ids."\"}");
		} else {
			die("{\"msg\":\"删除失败\"}");
		}
	} else {
		die("{\"msg\":\"未选择要删除的内容\"}");
	}
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="会员中心">
  <title>会员中心 - <?php echo $C_title?></title>
  <link href="../media/<?php echo $C_ico?>" rel="shortcut icon" />

  <!-- Stylesheets -->
  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
 
  <!--[if lt IE 9]>
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
  
</head>

<body class="body-index">
<?php require 'top.php';?>

		<div class="container m_top_30">
					<div class="yto-box">
						<h5>购物车</h5>
						<form action="cartpay.php" method="get" id="form">
						<div class="panel panel-default">
							<div class="panel-heading">购物车</div>
							<div class="table-responsive">
								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th>选择</th>
										<th>图片</th>
										<th>商品</th>
										<th>总价</th>
										<th>付款</th>
										<th>移除</th>
									</tr>
									</thead>
									<tbody>
									<?php

							$sql="select * from sl_orders where O_del=0 and O_mid=".$M_id." and O_type=0 and O_state=0 order by O_id desc";
							$result = mysqli_query($conn,  $sql);
							if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								$O_id=$row["O_id"];

							        echo "<tr id=\"".$row["O_id"]."\">
							        <td><input type=\"checkbox\" name=\"O[]\" value=\"".$row["O_id"]."\" data-price=\"".($row["O_price"]*$row["O_num"])."\"></td>
							        <td><img src=\"".pic2($row["O_pic"])."\" height=\"50\"></td>
							        <td>
							        <p><a href=\"../?type=productinfo&id=".$row["O_pid"]."\" target=\"_blank\">".$row["O_title"]."</a></p>
							        <p>".$row["O_price"]."元 × ".$row["O_num"]."件</p>
							        </td>
							        <td><span style=\"color:#ff0000;font-weight:bold\">".round($row["O_num"]*$row["O_price"],2)."元</span></td>
							        <td><a href=\"unlogin.php?type=product&id=".$row["O_pid"]."&genkey=".$row["O_genkey"]."\" class=\"btn btn-xs btn-primary\" type=\"submit\">付款</a></td>
							        <td><button class=\"btn btn-xs btn-danger\" type=\"button\" onclick=\"del(".$row["O_id"].")\">移除</button></td>
							        </tr>";
							    }
							} 
									?>

									</tbody>
								</table>
					</div>
				</div>
				<label><input type="checkbox" id="selectAll" name="selectAll" data-price="0"> 全选</label>
				<input type="hidden" value="1" name="no">
				<button class="btn btn-sm btn-danger" type="button" onclick="delall()">移除选中</button>
				<button class="btn btn-sm btn-primary" type="submit">支付选中</button>
				<div style="color: #ff0000;font-size: 20px;font-weight: bold;float:right">总价：<span id="price_all"></span>元</div>
			</form>
			</div>
		</div>
	</div>
<?php 
require 'foot.php';
?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>


	<script src="../js/sweetalert.min.js"></script>
<script>
function p(){
	var $p=0;
	$.each($('input:checkbox:checked'),function(){
		$p=$p+Number($(this).attr("data-price"));
	});

	$("#price_all").html($p.toFixed(2));
}


$("input").click(function(){
	p();
})

function del(id){
			if (confirm("确定移除商品吗？")==true){
                $.ajax({
            	url:'?action=del&O_id='+id,
            	type:'post',
            	success:function (data) {
            	if(data=="success"){
            		$("#"+id).hide();
            	}else{
            		alert(data);
            	}
            	}
            });
                return true;
            }else{
                return false;
            }
}


function delall() {
    if (confirm("确定删除吗？") == true) {
        $.ajax({
            url: '?action=delall',
            type: 'post',
            data: $("#form").serialize(),
            success: function(data) {
                data = JSON.parse(data);
                if (data.msg == "success") {
                    //alert("删除成功");
                    id = data.ids.split(",");
                    for (var i = 0; i < id.length; i++) {
                        $("#" + id[i]).hide();
                    };
                } else {
                    alert(data.msg);
                }
            }
        });
        return true;
    } else {
        return false;
    }
}

$('input[name="selectAll"]').on("click",function(){

        if($(this).is(':checked')){
            $('input[name="O[]"]').each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $('input[name="O[]"]').each(function(){
                $(this).prop("checked",false);
            });
        }
        p();
    });
$("input").prop("checked",true);
p();
	</script>
</body>
</html>