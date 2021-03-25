<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['table_field_view_content'] = array( 
	'tblsetting_scan' => [
		'id'	=>	'Mã',
		'setting_scan' => 'Tiêu đề',
		'dom_category' => 'Dom HTML Category',
		'dom_post_title' => 'Dom HTML Post Title',
		'dom_post_description' => 'Dom HTML Post Description',
		'dom_post_content' => 'Dom HTML Post Content',
		'is_href' => 'Link có URL home',
		'ordernum' => 'Thứ tự',
		'status'	=>	'Trạng thái',
	],
	'tblscan_post' => [
		'id' => 'Mã',
		'category' => 'Category',
		'link' => 'Link',
		'dom_status' => 'Lọc theo',	
		'is_send' => 'Quét',		
		'ordernum' => 'Thứ tự',
		'status'	=>	'Trạng thái'
	],
	'tbluser'   =>  [
		'id'    =>  'Mã',
		'username' =>  'Tài khoản',		
		'image'	=>	'Ảnh đại diện',				
		'address' =>  'Họ tên',
		'phone'    =>  'Điện thoại',
		'email' =>  'Email',		
		'post_date'  =>  'Ngày đăng ký',
		'ordernum' => 'Thứ tự',
		'status'    =>  'Trạng thái'
	],                           
	'tblarticle_category' =>  [
		'id'    =>  'Mã',
		'category'   =>  'Danh mục bài viết',                
		'home'=>'Hiện thị Home',          		                          
		'menu'    =>  'Hiện thị Menu',  
		'footer'    =>  'Hiện thị Footer',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   		
		'page_sub'    =>  'Hiện thị Page con',
		'ordernum'  =>  'Thứ tự',
		'status'    =>  'Trạng thái'
	],                     
	'tblarticle' =>  [
		'id'    =>  'Mã', 
		'title' =>  'Tiêu đề',  		                                                                                                                         
		'category'   =>  'Category', 				
		'image'       =>  'Ảnh',		                                                                                                                                                                                      
		'date_day'  =>  'Ngày đăng',		
		'author' =>  'Người đăng',                                                                                                                                                            
		'view'      =>  'Lượt xem',   		                                                                                                                                                                         		            
		'ordernum'  =>  'Thứ tự',
		'status'    =>  'Trạng thái',
	],  
	'tblcategory_ads' => [
		'id'	=>	'Mã',
		'category' => 'Danh mục bài viết',
		'category_ads' => 'Danh mục quảng cáo',
		'number_post' => 'Số bài viết hiện thị',
		'number_slider' => 'Số Slider hiện thị',
		'number_ads' => 'Số quảng cáo',
		'number_post_same' => 'Số bài viết cùng loại',
		'ordernum'	=>	'Thứ tự',
		'status'	=>	'Trạng thái'
	], 		
	'tblads' => [
		'id'   =>  'Mã',
		'title'    =>  'Title ADS',
		'category_ads'   =>  'Danh mục Quảng cáo',
		'image'  =>  'Ảnh đại diện',		
		'link' =>  'Link',
		'home' =>  'Hiện thị Home',		
		'ordernum' =>  'Thứ tự',
		'status'   =>  'Trạng thái'   
	],  
	'tblsetting_home' => [
		'id'	=>	'Mã',
		'post_number' => 'Số Post hiện thị',
		'slider_number' => 'Số Slider hiện thị',
		'ordernum' => 'Thứ tự',
		'status'	=>	'Trạng thái'
	],                                                                                                    								
	'tbladmin'   =>  [
		'id'			=>'Mã',
		'username'		=>'Tên đăng nhập',
		'email'			=>'Email ',
		'phone'			=>'Phone',
		'address'		=>'Địa chỉ',
		'status'		=>'Trạng thái',				    
	],           					
	'tblinformation' => [
		'id'    =>  'Mã',                                            
		'company_name'   =>  'Tên website',                                                                                                                                                                                                                    		
		'phone'	=> 'Điện thoại',				   		
		'logo'  =>  'Logo',		  
		'google_map' => 'Code Google Map',
		'header'   =>  'Code Header',    
		'footer' => 'Code Footer',            
		'heading'  =>  'Thẻ Heading',                                                                                                                                                                                                                                                                                                                                                                                                                                                            			                
	],              
	'tblcontact' =>[
		'id'    =>  'Mã',
		'name' =>  'Họ tên',
		'address'    =>  'Địa chỉ',
		'phone' =>  'Điện thoại',
		'email' =>  'Email',
		'content'   =>  'Nội dung',
		'date_contact'    =>  'Ngày liên hệ',
		'status'    =>  'Trạng thái'    
	],      
	'tblmeta'   => [
		'id'    =>  'Mã',
		'title' =>  'Tiêu đề',
		'description'   =>  'Mô tả',
		'keyword'  =>  'Từ khóa'                
	],   	
);