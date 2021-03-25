<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
if(isset($_SESSION['uid_frontend'])){
    $info_info=$CI->site_model->gettablename('tbluser','username,image,thumb,fullname,address,phone,email,info',$_SESSION['uid_frontend']);
}
?>
<div class="content">
    <div class="w980">     
        <div class="persion_sidebar">
            <?php $this->load->view('elements/side-bar') ?>            
        </div>
        <div class="persion_right">
            <div class="persion_sidebar_box">
                    <div class="persion_sidebar_box_top"><p><i class="fa fa-info-circle fa-fw"></i>Đổi mật khẩu</p></div>
                    <div class="persion_sidebar_box_main" style="padding:10px 15px;">
                        <div id="changepass_message"></div>
                        <div class="change_password_box">
                            <label>Mật khẩu cũ</label>
                            <input type="password" name="current_password" id="current_password" placeholder="******">
                            <div class="clearfix"></div>
                        </div>
                        <div class="change_password_box">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="new_password" id="new_password" placeholder="******">
                            <div class="clearfix"></div>
                        </div>
                        <div class="change_password_box">
                            <label>Xác nhận mật khẩu mới</label>
                            <input type="password" name="config_password" id="config_password" placeholder="******">
                            <div class="clearfix"></div>
                        </div>
                        <div class="change_password_box">                                                        
                            <button type="submit" onclick="submitFormChangPass()">Đổi mật khẩu</button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>            