<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$contact_info=$CI->site_model->gettablename('tblinformation','company_name,logo,google_map','');
?>
<div class="content">
    <div class="w980">     
        <div class="box-category">
            <p><strong>Xác minh Email</strong></p>
            <div class="clearfix"></div>
        </div>
        <span class="line"></span>
        <div class="box-category-main">
            <p>Xác minh Email thành công. Vui lòng click Đăng nhập để đăng nhập vào hệ thống</p>
            <br>
            <div class="clearfix"></div>
        </div>
    </div>
</div>                                  