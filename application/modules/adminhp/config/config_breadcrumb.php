<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['breadcrumb_table'] = array( 
    'breadcrumb_1'    =>  array(		
		'table_name'   => 'tblarticle',
        'table_label'    =>  'Bài viết',
        'table_column'  => 'col-lg-2 col-xs-6',
		    'table_list_icon' =>  '<i class="glyphicon glyphicon-book"></i>',
    ),   
    'breadcrumb_2'    =>  array(		
		'table_name'   => 'tblarticle_category',
        'table_label'    =>  'Danh mục bài viết',
        'table_column'  => 'col-lg-2 col-xs-6',
		    'table_list_icon' =>  '<i class="ion ion-gear-b"></i> ',
    ),
    'breadcrumb_3'    =>  array(		
      'table_name'   => 'tblads',
          'table_label'    =>  'Quảng cáo',
          'table_column'  => 'col-lg-2 col-xs-6',
      'table_list_icon' =>  '<i class="ion ion-paper-airplane"></i> ',
    ),
    'breadcrumb_4'    =>  array(		
      'table_name'   => 'tbluser',
          'table_label'    =>  'Thành viên',
          'table_column'  => 'col-lg-2 col-xs-6',
      'table_list_icon' =>  '<i class="glyphicon glyphicon-user"></i> ',
	  ),
);