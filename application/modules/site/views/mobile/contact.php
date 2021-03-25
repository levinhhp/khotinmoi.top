<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$contact_info=$CI->site_model->gettablename('tblinformation','company_name,logo,google_map','');
?>
<div class="content">
    <div class="w980">     
        <div class="box-category3" style="padding-top:0 !important;">
            <p class="title-box" style="padding-bottom:10px;">Liên hệ</p>
            <div class="clearfix"></div>
        </div>
        <span class="line"></span>
        <div class="box-category-main">
            <div id="contact_left">
                <?php echo $contact_info->google_map; ?>    
            </div>
            <div id="contact_right">
                <form id="contact_form" method="POST">
                        <div class="row_contact">   
                            <p><strong>Họ tên:</strong></p>                                                                                                     
                            <input type="text" name="hoten" id="hoten" value="" size="40" placeholder="Họ tên">
                        </div>
                        <div class="row_contact">   
                            <p><strong>Điện thoại:</strong></p>                                                   
                            <input type="text" name="phone" id="phone" value="" size="40" placeholder="Điện thoại">
                        </div>
                        <div class="row_contact">  
                            <p><strong>Email:</strong></p>                                                   
                            <input type="text" name="email" id="email" value="" size="40" placeholder="Email">
                        </div>
                        <div class="row_contact"> 
                            <p><strong>Địa chỉ:</strong></p>                                                    
                            <input type="text" name="diachi" id="diachi" value="" size="40" placeholder="Địa chỉ">
                        </div>
                        <div class="row_contact">   
                            <p><strong>Nội dung:</strong></p>                                                   
                            <textarea name="mota" class="mota" id="mota" cols="40" rows="10" placeholder="Viết yêu cầu nếu có!"></textarea>
                        </div>                        
                        <div class="row_contact">
                            <button type="submit" class="contact-submit1" name="contact-submit">Gửi liên hê</button>
                        </div>                   
                </form>              
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        function checkMail(mail){
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;								
            if (!filter.test(mail)) return false;								
                return true;								
        }
        $("#contact_form").submit(function(){
            var hoten=$("#hoten").val();
            var phone=$("#phone").val();
            var email=$("#email").val();  
            var diachi=$("#diachi").val();
            var mota=$("#mota").val();
            if(hoten=='')
            {
                alert("Họ tên không để trống");
                $("#hoten").focus();
                return false;
            }  
            else if(phone=='')
            {
                alert("Điện thoại không để trống");
                $("#phone").focus();
                return false;
            }
            else if(!checkMail(email))
            {
                alert("Email không đúng định dạng (xyz@abc.de)");
                $("#email").focus();
                return false;
            }
            else if(diachi=='')
            {
                alert("Địa chỉ không để trống");
                $("#diachi").focus();
                return false;
            }            
            else
            {                        
                $.ajax({
                    cache:false,
                    type:"POST",
                    data:{hoten : hoten,phone : phone,email : email,diachi : diachi,mota : mota},
                    url:"<?php echo site_url('site/docontact/'); ?>", 
                    success:function(html){
                        alert('Gửi liên hệ thành công');    
                        window.location.reload();                   
                    }                                                          
                }); 
            }
            return false;
        });		    
    });            	
</script>                                   