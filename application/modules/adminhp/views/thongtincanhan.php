<?php 
$CI = &get_instance();
$CI->load->model('adminhp/admin_model');
if(isset($_SESSION['uid'])){
    $user_id = $CI->admin_model->getUserByValue('tbladmin','id',$_SESSION['uid']);
    $name = $user_id->row()->name;
    $email = $user_id->row()->email;
    $phone = $user_id->row()->phone;
    $address = $user_id->row()->address;
    $avatar = $user_id->row()->avatar;
}else{
    $name = '';
    $email = '';
    $phone = '';
    $address = '';
    $avatar = 'backend/img/noimage.png';
}
?>
<section class="content-header">
	<h1><?php echo element($table_name,$table_list); ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>		
		<li class="active">
			Thông tin cá nhân
		</li>
	</ol>                
</section>
<section class="content">
    <div class="box box-primary borderless">
        <div class="box-header">
            <div class="pull-left">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>Thông tin cá nhân</h3>
            </div>
            <div class="pull-right"></div>
            <div class="clearfix"><!-- --></div>
		</div>
        <div class="box-body">            
            <div id="exTab1">	
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1a" data-toggle="tab">Thông tin cá nhân</a>
                    </li>
                    <li><a href="#2a" data-toggle="tab">Đổi mật khẩu</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content clearfix">                    
                    <div class="tab-pane active" id="1a">
                    <div id="con"></div>
                        <form id="frmthongtincanhan" method="POST" enctype="multipart/form-data">                        
                        <div class="row">
                            <div class="col-md-12">
                            <img style='border:1px solid #ddd;width:150px;margin-bottom:15px;display:block;' id="blah" src="<?php echo $avatar; ?>" alt="your image" />  
                            <?php                                                
                                echo form_label('Chọn ảnh', 'imgInp',['id'=>'upload_avatar']);
                                echo form_upload('avatar','',['class'=>'fileUpload form-control','style'=>'opacity:0;position:absolute;z-index:-1;','id'=>'imgInp']);
                            ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                       
                                    <?php 
                                        echo form_label('Họ tên');                              
                                        echo form_input('name',$name,['class'=>'form-control','id'=>'name','placeholder'=>'Họ tên']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                   
                                    <?php 
                                        echo form_label('Email');                                   
                                        echo form_input('email',$email,['class'=>'form-control','id'=>'email','placeholder'=>'Email']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                    
                                    <?php 
                                        echo form_label('Điên thoại');                                  
                                        echo form_input('phone',$phone,['class'=>'form-control','id'=>'phone','placeholder'=>'Điện thoại']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php 
                                        echo form_label('Địa chỉ');                                     
                                        echo form_input('address',$address,['class'=>'form-control','id'=>'address','placeholder'=>'Địa chỉ']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-12">		
                                <div class="form-group">                                                                  
                                    <?php 
                                        echo form_button('submit','Cập nhật',['class'=>'btn btn-primary','id'=>'submit_val']);                                       
                                    ?>                                                                              
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="2a">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="message_pass"></div>
                            </div>
                            <div class="col-lg-6">                                
                                <div class="form-group">                                    
                                    <?php 
                                        echo form_label('Tài khoản');                                  
                                        echo form_input('username',$_SESSION['username'],['class'=>'form-control','id'=>'phone','placeholder'=>'Điện thoại','readonly'=>true]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">                                    
                                    <?php 
                                        echo form_label('Mật khẩu cũ');                                  
                                        echo form_password('password_old',null,['class'=>'form-control','id'=>'password_old','autocomplete'=>'off','placeholder'=>'******']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">                                    
                                    <?php 
                                        echo form_label('Mật khẩu mới');                                  
                                        echo form_password('password_new',null,['class'=>'form-control','id'=>'password_new','placeholder'=>'******']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">                                    
                                    <?php 
                                        echo form_label('Xác nhận mật khẩu mới');                                  
                                        echo form_password('password_new_re',null,['class'=>'form-control','id'=>'password_new_re','placeholder'=>'******']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <?php 
                                    echo form_button('submit','Đổi mật khẩu',['class'=>'btn btn-primary','id'=>'change_pass']);                                    
                                ?>        
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function checkMail(mail){
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;								
        if (!filter.test(mail)) return false;								
            return true;								
    }
    $("#change_pass").on('click',function(){
        var password_old = $("#password_old").val();
        var password_new = $("#password_new").val();
        var password_new_re = $("#password_new_re").val();
        if(password_new!=password_new_re){
            alert('Xác nhận mật khẩu mới không đúng');
            $("#password_new_re").focus();
            return false;
        }else{
            $.ajax({
                cache:false,
                type:"POST",
                data:{password_old : password_old,password_new : password_new},
                url:"<?php echo site_url('adminhp/changPassword'); ?>", 
                success:function(html){
                    $("#password_old").val('');
                    $("#password_new").val('');
                    $("#password_new_re").val('');
                    $("#message_pass").html(html);                                        
                }                                                          
            });    
        }
        return false;
    });
    $("#submit_val").click(function(){
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var address = $("#address").val();                                   
        if(!checkMail(email)){
            alert("Email không đúng định dạng (xyz@abc.de)");
            $("#email").focus();
            return false;
        }else{                                             
            $.ajax({
                cache:false,
                type:"POST",
                data:{name : name,email : email,phone : phone,address : address},
                url:"<?php echo site_url('adminhp/dothongtincanhan'); ?>", 
                success:function(html){
                    $("#con").html(html);   
                    //window.location.reload();                   
                }                                                          
            });
            return false;
        }
        return false;
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function() {
        var file = $(this).prop('files')[0];
        var data = new FormData();
        data.append('file', file);        
        $.ajax({  
            cache:false,
            url:"<?php echo site_url('adminhp/changeImage'); ?>",  
            method:"POST",  
            data: data,  
            contentType:false,  
            processData:false,              
            success:function(data){                   
                $(this).val('');  
            }  
        });          
        readURL(this);
    });
</script>