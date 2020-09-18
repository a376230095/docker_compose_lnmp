<?php 
require '../conn/conn.php';
require '../conn/function.php';

$L_genkey = t($_REQUEST["L_genkey"]);
$genkey = t($_REQUEST["genkey"]);
if ($L_genkey == "" && $genkey == "") {
    die();
} else {
    if ($L_genkey != "") {
        $sql = "select * from sl_list where L_genkey='$L_genkey'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            echo 1;
        }else{
            echo 0;
        }
    }

    if ($genkey != "") {
        $sql = "select * from sl_member where M_pwdcode='$genkey'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["M_login"] = $row["M_login"];
            $_SESSION["M_pwd"] = $row["M_pwd"];
            $_SESSION["M_id"] = $row["M_id"];
            //$genkey=gen_key(20);
            //mysqli_query($conn,"update sl_member set M_pwdcode='".$genkey."' where M_id=".$row["M_id"]);
            $_SESSION["M_pwdcode"] = $genkey;
            echo 1;
        } else {
            echo 0;
        }
    }
}
?>