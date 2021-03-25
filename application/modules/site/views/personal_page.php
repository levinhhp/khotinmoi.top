<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
if(isset($_SESSION['username_frontend'])){
    $this->db->where('username',$_SESSION['username_frontend']);
    $this->db->select('username,image,thumb,fullname,address,phone,email,info');
    $this->db->limit(1);
    $info_info=$this->db->get('tbluser')->row();
}
?>
<div class="content">
    <div class="w980">     
        <div class="persion_sidebar">
            <?php $this->load->view('elements/side-bar') ?>            
        </div>
        <div class="persion_right">
            <div class="persion_sidebar_box">
                    <div class="persion_sidebar_box_top"><p><i class="fa fa-info-circle fa-fw"></i>Thông tin tài khoản</p></div>
                    <div class="persion_sidebar_box_main" style="padding:10px 15px;">
                        <div id="load_persion"></div>
                        <div class="person_info">
                            <div class="person_info_item" style="float:none;width:100%;">
                                <?php 
                                    if(!empty($info_info->thumb)){
                                    ?>
                                    <img style="border:1px solid #ddd;width:100px;margin-bottom:15px;display:block;" id="blah" src="<?php echo $info_info->thumb; ?>" alt="your image">
                                    <?php
                                    }else{
                                    ?>
                                    <img style="border:1px solid #ddd;width:100px;margin-bottom:15px;display:block;" id="blah" src="frontend/images/noimage.png" alt="your image">
                                    <?php 
                                    }
                                ?>
                                <label for="imgInp" id="upload_avatar">Ảnh đại diện</label>
                                <input type="file" name="avatar" style="opacity:0;position:absolute;z-index:-1;" id="imgInp">
                                <input type="hidden" name="hidden_thumb" id="hidden_thumb" value="<?php echo $info_info->thumb; ?>">
                                <input type="hidden" name="hidden_avatar" id="hidden_avatar" value="<?php echo $info_info->image; ?>">
                                <div class="clearfix"></div>
                            </div>
                            <br>
                            <div class="person_info_item">
                                <p>Họ tên</p>
                                <input type="text" name="fullname_person" id="fullname_person" value="<?php echo $info_info->fullname; ?>">
                            </div>
                            <div class="person_info_item" style="margin-right:0;">
                                <p>Địa chỉ</p>
                                <input type="text" name="address_persion" id="address_persion" value="<?php echo $info_info->address; ?>">
                            </div>
                            <div class="person_info_item">
                                <p>Điện thoại</p>
                                <input type="text" name="phone_person" id="phone_person" value="<?php echo $info_info->phone; ?>">
                            </div>
                            <div class="person_info_item" style="margin-right:0;">
                                <p>Email</p>
                                <input type="text" name="email" value="<?php echo $info_info->email; ?>" id="email_person">
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="person_info_item" style="float:none;width:100%;">
                                <p>Giới thiệu bản thân</p>
                                <textarea name="info_person" id="info_person"><?php echo $info_info->info; ?></textarea>                                
                            </div>
                            <div class="person_info_item" style="float:none;width:100%;">
                                <button type="submit" id="update_persion" onclick="submitFormPersion()">Cập nhật</button>                               
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>            