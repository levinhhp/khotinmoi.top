<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['side_bar_table'] = array( 
    'side_bar_1'    =>  array(	
        'side_bar_name' => 'Quản lý Quét tin',
        'side_bar_icon' => '<i class="glyphicon glyphicon-search"></i>',
        'side_bar_table' => array(
            'table_1' => 'tblsetting_scan',
            'table_2' => 'tblscan_post',            
        )
    ),    
    'side_bar_2'    =>  array(	
        'side_bar_name' => 'Quản lý Thành viên',
        'side_bar_icon' => '<i class="glyphicon glyphicon-user"></i>',
        'side_bar_table' => array(
            'table_1' => 'tbluser',            
        )
    ),    
    'side_bar_3'    =>  array(	
        'side_bar_name' => 'Quản lý bài viết',
        'side_bar_icon' => '<i class="glyphicon glyphicon-book"></i>',
        'side_bar_table' => array(
            'table_1' => 'tblarticle_category',
            'table_2' => 'tblarticle',
        )
    ),    
    'side_bar_4'    =>  array(	
        'side_bar_name' => 'Quản lý Quảng cáo',
        'side_bar_icon' => '<i class="glyphicon glyphicon-picture"></i>',
        'side_bar_table' => array(
            'table_1' => 'tblcategory_ads', 
            'table_2' => 'tblads',                 
        )
    ),
    'side_bar_5'    =>  array(	
        'side_bar_name' => 'Quản lý phân quyền',
        'side_bar_icon' => '<i class="glyphicon glyphicon-lock"></i>',
        'side_bar_table' => array(
            'table_1' => 'tbladmin',                       
        )
    ),    
    'side_bar_6'    =>  array(	
        'side_bar_name' => 'Thông tin chung',
        'side_bar_icon' => '<i class="glyphicon glyphicon-globe"></i>',
        'side_bar_table' => array(
            'table_1' => 'tblinformation',
            'table_2' => 'tblmeta',
            'table_3' => 'tblcontact',                      
        )
    ),    
);
