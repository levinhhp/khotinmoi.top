var URL = 'https://khotinmoi.com/';
$(document).ready(function () {
    //Hover menu
    $('#toggleMenu ul > li').hover(function(){
        $(this).children('.sub_menu').css('display','block');                       
        },function(){
            jQuery(this).children('.sub_menu').css('display','none');    
    });
    $('.sub_menu > li').hover(function(){
        jQuery(this).children('.sub_menu_hai').css('display','block');                       
        },function(){
            $(this).children('.sub_menu_hai').css('display','none');    
    });   
    paginate();
    function paginate() {
        $('#ajax_links a').click(function() {                           
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'POST',
                data: 'ajax=true',
                success: function(data) {
                    $('#ajax_content').html(data);
                }
            });
            return false;
        });
    }
    //Tab login and register             
    $("#register_tab").on('click',function(){
      $(".login_all_main").hide(200);
      $("#login_tab").css('border-bottom','none');
      $("#register_tab").css('border-bottom','2px solid #e32');
      $(".register_all_main").show(200);
    });
    $("#login_tab").on('click',function(){
      $(".login_all_main").show(200);
      $("#register_tab").css('border-bottom','none');
      $("#login_tab").css('border-bottom','2px solid #e32');
      $(".register_all_main").hide(200);
    });
    //Modal Login
    var modal_login = $('.modal_login');
    var btn_login = $('#login_desk a');
    var span_login = $('.close_login');
    btn_login.click(function () {
      modal_login.show();                   
    });
    span_login.click(function () {
      modal_login.hide();
    });
    $(window).on('click', function (e) {
      if ($(e.target).is('.modal_login')) {
          modal_login.hide();
      }
    });
    //Check Email
    function checkMail(mail){
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;								
        if (!filter.test(mail)) return false;								
            return true;								
    }
    //Check Phone
    function validatePhone(txtPhone) {        
        var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (filter.test(txtPhone)) {
            return true;
        }
        else {
            return false;
        }
    }
    //Check UserName Already exits
    $("#user_dk").keyup(function(){
        var username_check = $(this).val().trim();
        if(username_check != ''){
            $.ajax({
               url: URL+'site/checkUserName',
               type: 'POST',
               data: {username_check: username_check},
               success: function(response){
                   $('#uname_response').html(response);
                }
            });
         }else{
            $("#uname_response").html("");
         }
    });
    //Create User    
    $("#create_user").on('click',function(){
        var user_dk = $("#user_dk").val();
        var pwd_dk = $("#pwd_dk").val();
        var re_password_dk = $("#re_password_dk").val();
        var fullname_dk = $("#fullname_dk").val();
        var email_dk = $("#email_dk").val();
        var phone_dk = $("#phone_dk").val();
        var url_html = $("#uname_response span").text();   
        var response = grecaptcha.getResponse();         
        if(user_dk == ''){
            alert('Tài khoản không để trống');
            $("#user_dk").focus();
            return false;
        }else if(user_dk.length<6){
            alert('Tài khoản phải lớn hơn 6 ký tự');
            $("#user_dk").focus();
            return false;
        }else if(url_html=="Tài khoản đã tồn tại. Vui lòng chọn Tài khoản khác."){
            $("#user_dk").focus();
            return false;
        }else if(pwd_dk == ''){
            alert('Mật khẩu không để trống');
            $("#pwd_dk").focus();
            return false;
        }else if(pwd_dk.length<6){
            alert('Mật khẩu phải lớn hơn 6 ký tự');
        }else if(re_password_dk!= pwd_dk){
            alert('Xác nhận mật khẩu không giống nhau');
            $("#re_password_dk").focus();
            return false;
        }else if(fullname_dk==''){
            alert('Họ tên không để trống');
            $("#fullname_dk").focus();
            return false;
        }else if(!checkMail(email_dk)){
            alert('Email không đúng định dạng (xyz@abc.de)');
            $("#email_dk").focus();
        }else if(!validatePhone(phone_dk)){
            alert('Điện thoại không đúng');
            $("#phone_dk").focus();
            return false;
        }else if(response.length == 0){
            $('#g-recaptcha-error').html('<span style="color:red;">This field is required.</span>');
            return false;
        }else{
            $.ajax({
                cache:false,
                type:"POST",
                data:{user_dk : user_dk,pwd_dk : pwd_dk,fullname_dk : fullname_dk,email_dk : email_dk,phone_dk : phone_dk},
                url: URL+ "site/doRegister", 
                success:function(html){
                    alert('Tạo tài khoản thành công. Vui lòng kiểm tra Email để kích hoạt tài khoản !');    
                    window.location.reload();                   
                }                                                          
            });    
        }
    });       
    $("#create_user").prop('disabled',true);
    $("#create_user").css('opacity','.5');
    //Check Checkbox
    $("#not_register").on('click',function(){
        if (this.checked) {
            $("#create_user").css('opacity','1');
            $("#create_user").prop('disabled',false);
        }else{
            $("#create_user").prop('disabled',true);            
            $("#create_user").css('opacity','.5');
        }
    });
    $("#search").on('click',function(){        
        var menuSearch = document.getElementById('search_form_desk');  
        if(menuSearch.style.display == "block") { // if is menuBox displayed, hide it
            menuSearch.style.display = "none";
        }
        else { // if is menuBox hidden, display it
            menuSearch.style.display = "block";
        }
    });  
    //Load Category sub  
    $('#post_category').on('change',function() {
        giatri = this.value;
        $('#post_category_sub').load(URL + 'site/load_category_sub/' + giatri);                    
    }); 
});

function verifyCaptcha() {
    $('#g-recaptcha-error').html('');
}
//login Form
function submitFormLogin(){
    var flag = 0;
    var username = $('#username_res').val();
    var password = $('#password_res').val();
    if (username == '' || username == undefined) {
        $('#username_res').css('border', '1px solid red');
        flag = 1;
    }
    if (password == '' || password == undefined) {
        $('#password_res').css('border', '1px solid red');
        flag = 1;
    }
    if (flag == 0) {
        $.ajax({
            cache:false,
            type:"POST",
            url: URL + "site/doLogin",            
            data:{username : username,password : password},
            success: function (result) {
                if (result == 1) {
                    $('#username_res').css('border', '1px solid green');
                    $('#password_res').css('border', '1px solid green');
                    setTimeout(function () {
                        alert('Đăng nhập thành công');
                        window.location.reload(); 
                    },1000)                    
                }else if(result == 2){
                    $('#username_res').css('border', '1px solid red');
                    alert('Tài khoản không hợp lệ');
                }else if(result == 3){
                    $('#password_res').css('border', '1px solid red');
                    alert('Mật khẩu không hợp lệ');
                }else if (result == 4 || result == 5) {
                    $('#username_res').css('border', '1px solid red');
                    $('#password_res').css('border', '1px solid red');
                    alert('Tài khoản và mật khẩu không hợp lệ');
                }else{
                    alert('Đã xảy ra lỗi'); 
                }
            }
        });
    }else{
        alert('Đã xảy ra lỗi');
    }
}
//Preview Image
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
    readURL(this);
});

//Update Persion
function submitFormPersion(){
    var hidden_avatar = $("#hidden_avatar").val();
    var hidden_thumb = $("#hidden_thumb").val();
    var fullname_person = $("#fullname_person").val();
    var address_persion = $("#address_persion").val();
    var phone_person = $("#phone_person").val();
    var email_person = $("#email_person").val();
    var info_person = $("#info_person").val();
    var file = $("#imgInp").prop('files')[0];
    var data = new FormData();
    data.append('hidden_avatar', hidden_avatar);
    data.append('hidden_thumb', hidden_thumb);
    data.append('fullname', fullname_person);
    data.append('address', address_persion);
    data.append('phone', phone_person);
    data.append('email', email_person);
    data.append('info', info_person);
    data.append('file', file);    
    $.ajax({  
        cache:false,
        url:URL + "site/updatePersion",  
        method:"POST",  
        data: data,  
        contentType:false,  
        processData:false,              
        success:function(html){                   
            $("#load_persion").html(html);  
        }  
    });           
}
//Change Password
function submitFormChangPass(){
    var current_password = $("#current_password").val();
    var new_password = $("#new_password").val();
    var config_password = $("#config_password").val();    
    $.ajax({
        cache:false,
        type:"POST",
        data:{current_password : current_password,new_password : new_password,config_password : config_password},
        url: URL+ "site/doChangePass", 
        success:function(html){             
            $("#changepass_message").html(html);               
        }                                                          
    });    
}
//Submit Post
function submitFormPost(){
    var post_title = $("#post_title").val();
    var post_category = $("#post_category").val();
    var post_category_sub = $("#post_category_sub").val();
    var post_description = $("#post_description").val();
    var post_content = CKEDITOR.instances.post_content.getData();
    var file = $("#imgInp").prop('files')[0];
    var data = new FormData();    
    data.append('post_title', post_title);
    data.append('post_category', post_category);
    data.append('post_category_sub', post_category_sub);
    data.append('post_description', post_description);
    data.append('post_content', post_content);    
    data.append('file', file);    
    if(post_title==''){
        alert('Tiêu đề không để trống');
        $("#post_title").focus();
        return false;
    }else if(post_category == 0){
        alert('Bạn chưa chọn Danh mục cha');
        return false;
    }else if(post_content.length <10){
        alert('Nội dung phải lớn hơn 10 ký tự');
        return false;
    }else{
        $.ajax({  
            cache:false,
            url:URL + "site/addPost",  
            method:"POST",  
            data: data,  
            contentType:false,  
            processData:false,              
            success:function(html){                   
                alert('Bài viết của bạn đã được đăng thành công!');
                window.location.reload();
            }  
        });   
        return true;        
    }
}