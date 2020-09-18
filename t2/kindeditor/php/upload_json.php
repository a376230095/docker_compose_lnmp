<?php
/**
 * KindEditor PHP
 *
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 *
 */


require '../../conn/conn.php';
require '../../conn/function.php';
require_once 'JSON.php';

$php_path = dirname(__FILE__) . '/';
$php_url = dirname($_SERVER['PHP_SELF']) . '/';

//文件保存目录路径
$save_path = $php_path . '../attached/';
//文件保存目录URL
$save_url = $php_url . '../attached/';
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3','mp4', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 100*1024*1024;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	$file_url=str_replace("php/../","",$file_url);
	if($C_m_position>0){

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
	  setWater("../../".$file_url, "../../media/".$C_m_logo, "", "", $markPos, "", "img");
	}

	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
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
