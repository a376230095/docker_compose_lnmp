<?php
$url = file_get_contents($_GET["url"], true);
header("Content-Type: image/jpeg; charset=utf-8");
echo $url;
?>