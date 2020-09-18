<?php 
require '../conn/conn.php';
require '../conn/function.php';

$S_filetype=$C_format;
$id=$_GET["id"];
$path=$_GET["path"];
$path = str_replace("@@", "..", $path);
$processid=$_GET["processid"];
$kname=splitx($_POST['filename'],".",1);

$k=$processid.".".$kname."_temp";
$g=date("YmdHis",time()).gen_key(2).".".$kname;

if(strpos($S_filetype,strtolower($kname))!==false){
  if (strpos($path, "../") !== false) {
      $p = $path;
  } else {
      $p = $_SERVER["DOCUMENT_ROOT"] . $path;
  }

if (preg_match('/asp|php|apsx|asax|ascx|cdx|cer|pht|htaccess|cgi|jsp/i', $k)) {
    die("error|上传文件格式不允许！");
} else {
  if(!file_exists($p . "/" . $k)){ 
    move_uploaded_file($_FILES['video']['tmp_name'],$p . "/" . $k); 
  }else{ 
    file_put_contents($p . "/" . $k,file_get_contents($_FILES['video']['tmp_name']),FILE_APPEND); 
  } 

  if(filesize($p . "/" . $k)==$_POST['size']){
  rename($p . "/" . $k,$p . "/" . $g);
  if($C_m_position>0){
  if ($id != "C_logo" && $id != "C_ico" && $id != "C_m_logo" && $id != "C_qrcode" && ($kname=="jpg" || $kname=="png" || $kname=="jpeg" || $kname=="gif" || $kname=="bmp")) {
  switch ($C_m_position) {
  case 1:
  $markPos = 1;
  break;

  case 2:
  $markPos = 3;
  break;

  case 3:
  $markPos = 7;
  break;

  case 4:
  $markPos = 9;
  break;

  case 5:
  $markPos = 5;
  break;
  }
  setWater($p . "/" . $g, $p ."/". $C_m_logo, "", "", $markPos, "", "img");
  }
  }

  if($C_osson==1){
    tooss($p."/".$g);
  }
  echo $g;
  }
}
}else{
  echo "error|文件格式不支持";
}

function compressedImage($imgsrc, $imgdst,$w=600) {
    list($width, $height, $type) = getimagesize($imgsrc);
     
    $new_width = $width;//压缩后的图片宽
    $new_height = $height;//压缩后的图片高
         
    if($width >= $w){
      $per = $w / $width;//计算比例
      $new_width = $width * $per;
      $new_height = $height * $per;
    }
     
    switch ($type) {
      case 1:
        $giftype = check_gifcartoon($imgsrc);
        if ($giftype) {
          header('Content-Type:image/gif');
          $image_wp = imagecreatetruecolor($new_width, $new_height);

        /* --- 用以处理缩放gif和png图透明背景变黑色问题 开始 --- */
        $color = imagecolorallocate($image_wp,255,255,255);
        imagecolortransparent($image_wp,$color);
        imagefill($image_wp,0,0,$color);
        /* --- 用以处理缩放gif和png图透明背景变黑色问题 结束 --- */


          $image = imagecreatefromgif($imgsrc);
          imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
          //90代表的是质量、压缩图片容量大小
          imagejpeg($image_wp, $imgdst, 90);
          imagedestroy($image_wp);
          imagedestroy($image);
        }
        break;
      case 2:
        header('Content-Type:image/jpeg');
        $image_wp = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($imgsrc);
        imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        //90代表的是质量、压缩图片容量大小
        imagejpeg($image_wp, $imgdst, 90);
        imagedestroy($image_wp);
        imagedestroy($image);
        break;
      case 3:
                //header('Content-Type:image/png');
                $image_wp = imagecreatetruecolor($new_width, $new_height);
                $alpha = imagecolorallocatealpha($image_wp, 0, 0, 0, 127);
                imagefill($image_wp, 0, 0, $alpha);
                $image = imagecreatefrompng($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagesavealpha($image_wp, true);
                //90代表的是质量、压缩图片容量大小
                imagepng($image_wp, $imgdst);
                imagedestroy($image_wp);
                imagedestroy($image);
                break;

    }
  }

function setWater($imgSrc,$markImg,$markText,$TextColor,$markPos,$fontType,$markType){
global $C_m_width;
 
  $srcInfo = @getimagesize($imgSrc);
  $srcImg_w  = $srcInfo[0];
  $srcImg_h  = $srcInfo[1];
     
  switch ($srcInfo[2]) 
  { 
    case 1: 
      $srcim =imagecreatefromgif($imgSrc); 
      break; 
    case 2: 
      $srcim =imagecreatefromjpeg($imgSrc); 
      break; 
    case 3: 
      $srcim =imagecreatefrompng($imgSrc); 
      break; 
    default: 
      die("不支持的图片文件类型"); 
      exit; 
  }
     

  if(!strcmp($markType,"img"))
  {
    if(!file_exists($markImg) || empty($markImg))
    {
      return;
    }
       
	compressedImage($markImg,$markImg."2",$C_m_width);
	$markImgInfo = @getimagesize($markImg."2");
	
    $markImg_w  = $markImgInfo[0];
    $markImg_h  = $markImgInfo[1];
       
    if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h)
    {
      return;
    }
       
    switch ($markImgInfo[2]) 
    { 
      case 1: 
        $markim =imagecreatefromgif($markImg."2"); 
        break; 
      case 2: 
        $markim =imagecreatefromjpeg($markImg."2"); 
        break; 
      case 3: 
        $markim =imagecreatefrompng($markImg."2"); 
        break; 
      default: 
        die("不支持的水印图片文件类型"); 
        exit; 
    }
       
    $logow = $markImg_w;
    $logoh = $markImg_h;
  }
     
  if(!strcmp($markType,"text"))
  {


    $fontSize = 16;

    $box = @imagettfbbox($fontSize, 0, $fontType,$markText);
    $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
    $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);
  }
     
  if($markPos == 0)
  {
    $markPos = rand(1, 9);
  }

  switch($markPos)
  {
    case 1:
      $x = +5;
      $y = +20;
      break;
    case 2:
      $x = ($srcImg_w - $logow) / 2;
      $y = +5;
      break;
    case 3:
      $x = $srcImg_w - $logow - 10;
      $y = +20;
      break;
    case 4:
      $x = +5;
      $y = ($srcImg_h - $logoh) / 2;
      break;
    case 5:
      $x = ($srcImg_w - $logow) / 2;
      $y = ($srcImg_h - $logoh) / 2;
      break;
    case 6:
      $x = $srcImg_w - $logow - 5;
      $y = ($srcImg_h - $logoh) / 2;
      break;
    case 7:
      $x = +5;
      $y = $srcImg_h - $logoh ;
      break;
    case 8:
      $x = ($srcImg_w - $logow) / 2;
      $y = $srcImg_h - $logoh - 5;
      break;
    case 9:
      $x = $srcImg_w - $logow - 10;
      $y = $srcImg_h - $logoh ;
      break;
    default: 
      die("此位置不支持"); 
      exit;
  }
     
  $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);
     
  imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);
     
  if(!strcmp($markType,"img"))
  {
  	if($markImgInfo[2]==2){
  		imagecopymerge($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh,50);
  	}else{
  		imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
  	}
    imagedestroy($markim);
  }
     
  if(!strcmp($markType,"text"))
  {
    $rgb = explode(',', $TextColor);
       
    $color = imagecolorallocate($dst_img, $rgb[0], $rgb[1], $rgb[2]);
    imagettftext($dst_img, $fontSize, 0, $x, $y, $color, $fontType,$markText);
  }
     
  switch ($srcInfo[2]) 
  { 
    case 1:
      imagegif($dst_img, $imgSrc); 
      break; 
    case 2: 
      imagejpeg($dst_img, $imgSrc); 
      break; 
    case 3: 
      imagepng($dst_img, $imgSrc); 
      break;
    default: 
      die("不支持的水印图片文件类型"); 
      exit; 
  }
     
  imagedestroy($dst_img);
  imagedestroy($srcim);
}

//16进制转RGB颜色
function hex2rgb($hexColor) {
        $color = str_replace('#', '', $hexColor);
        if (strlen($color) > 3) {
            $rgb=hexdec(substr($color, 0, 2)).",".hexdec(substr($color, 2, 2)).",".hexdec(substr($color, 4, 2));
            
        } else {
            $color = $hexColor;
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb=hexdec($r).",".hexdec($g).",".hexdec($b);
        }
        return $rgb;
    }
?>