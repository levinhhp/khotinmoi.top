<?php //session_start(); 
//$img = imagecreatefrompng('bg6.png'); //Tạo hình ảnh
//$numero = rand(100, 999); //tạo ngẫu nhiên chuỗi hien63 thị trên captcha
//$_SESSION['img'] = ($numero); 
//$white = imagecolorallocate($img, 225, 225, 225); //Định dạng màu cho hình ảnh
//imagestring($img, 10, 8, 3, $numero, $white); //tạo hình từ chuỗi ngẫu nhiên ở trên - tạo captcha
//header ("Content-type: image/png");
//imagepng($img); //xuất hình ảnh ra
// Create a 100*30 image





//
//$im = imagecreate(60, 20);
//// White background and blue text
//$bg = imagecolorallocate($im, 255, 255, 255);
//$textcolor = imagecolorallocate($im, 0, 0, 255);
//$numero = rand(100, 999); //tạo ngẫu nhiên chuỗi hien63 thị trên captcha
//$_SESSION['img'] = ($numero); 
//// Write the string at the top left
//imagestring($im, 5, 0, 0,$numero , $textcolor);
//
//// Output the image
//header('Content-type: image/png');
//
//imagepng($im);
//imagedestroy($im);


session_start();
function create_image()
{
 $md5_hash = md5(rand(0,999));
 $security_code = substr($md5_hash, 15, 5);
 $width = 100;
 $height = 30;
 $image = imagecreate($width, $height);
 $white = imagecolorallocate($image, 255, 255, 255);
 $black = imagecolorallocate($image, 0, 0, 0);
 imagefill($image, 0, 0, $black);
 imagestring($image, 5, 30, 6, $security_code, $white);
 header("Content-Type: image/jpeg");
 imagejpeg($image);
 imagedestroy($image);
 $_SESSION["img"] = $security_code;
}
create_image() ;
exit();
?>