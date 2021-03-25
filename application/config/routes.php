<?php defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = "site";
$route['lien-he.html'] = 'site/contact';
$route['thoat.html'] = 'site/logout';
$route['tim-kiem.html'] = 'site/search';
$route['personal-page.html'] = 'site/personalPage';
$route['doi-mat-khau.html'] = 'site/changePassword';
$route['dang-tin.html'] = 'site/dangtin';
$route['danh-sach-tin-dang.html'] = 'site/listPost';
$route['thong-tin-ca-nhan.html'] = 'adminhp/thongtincanhan';
$route['scaffolding_trigger'] = "";
//ketnoi db
$servername = dbhostname;
$username = dbuser;
$password = dbpass;
$dbname = dbdatabase;
$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die('Ket noi that bai:' . mysqli_connect_error());

} else {
    //echo"Ket noi thanh cong";
}
//danh mục bài viết
$sqlbv="SELECT id,alias,status from tblarticle_category where status='1'";
$result = mysqli_query($con,$sqlbv);
while ($row = mysqli_fetch_array($result)) 
{
    $ten=$row["alias"];
    $route[$ten.'(/:num)?']= "site/baivietcap1/".$row["id"].'/$2'; 
    $route['(:any)/'.$ten.'(/:num)?']="site/baivietcap1/$1/".$row["id"].'/$2';
}
function danhmucbaiviet($id)
{
	$servername =dbhostname;
	$username = dbuser;
	$password = dbpass;
	$dbname = dbdatabase;
	$con = mysqli_connect($servername,$username,$password,$dbname);
	$sp = mysqli_query($con,"SELECT id,alias from tblarticle_category where id='$id'");
	while ($row = mysqli_fetch_array($sp)) 
    {
		$tensp=$row["alias"];
	}
	return $tensp;
    msqli_close($con);
}
//Tin tuc
$tt=mysqli_query($con,"SELECT * from tblarticle where status='1'");
while($item = mysqli_fetch_array($tt))
{		
	$title =$item["alias"];
	$route[$title] = "site/baivietchitiet/".$item["id"];
}
function url_tt($id)
{
	$servername =dbhostname;
	$username = dbuser;
	$password = dbpass;
	$dbname = dbdatabase;
	$con = mysqli_connect($servername,$username,$password,$dbname);
	$tt = mysqli_query($con,"SELECT * from tblarticle where id='$id'");
	while($item = mysqli_fetch_array($tt)) 
    {		
		$title =$item["alias"];
	}	
	return $title; 
    msqli_close($con);
}
function BoDau($str)
{
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|�� �|ặ|ẳ|ẵ|ắ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|�� �|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ợ|Ở|Ớ|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	$str = preg_replace("/( |'|,|\||\.|\"|\?|\/|\%|–|!)/", '-', $str);
	$str = preg_replace("/(\()/", '-', $str);
	$str = preg_replace("/(\))/", '-', $str);
	$str = preg_replace("/(&)/", '-', $str);    
    $str = preg_replace("/(“|”)/", '-', $str);
	return strtolower($str);    
}

