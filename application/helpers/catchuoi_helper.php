<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
function catchuoi($chuoi,$gioihan){
	if(strlen($chuoi)<=$gioihan)
	{
		return $chuoi;
	}
	else{
	if(strpos($chuoi," ",$gioihan) > $gioihan){
		$new_gioihan=strpos($chuoi," ",$gioihan);
		$new_chuoi = substr($chuoi,0,$new_gioihan)."...";
		return $new_chuoi;
	}
	$new_chuoi = substr($chuoi,0,$gioihan)."...";
		return $new_chuoi;
	}
}
