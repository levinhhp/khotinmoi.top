<?php 
$CI = &get_instance();
$CI = $CI->load->model('site/site_model');
require_once 'vendor/facebook-php-sdk/autoload.php';
$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
// Call Facebook API
$facebook = new \Facebook\Facebook([
	'app_id'      => APP_ID,
	'app_secret'     => APP_SECRET,
	'default_graph_version'  => 'v8.0'
]);
$facebook_output = '';
$facebook_helper = $facebook->getRedirectLoginHelper();
function GetAccessTokenGoogle($client_id, $redirect_uri, $client_secret, $code) {	
	$url = 'https://www.googleapis.com/oauth2/v4/token';			
	$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
	$ch = curl_init();		
	curl_setopt($ch, CURLOPT_URL, $url);		
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
	curl_setopt($ch, CURLOPT_POST, 1);		
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
	$data = json_decode(curl_exec($ch), true);
	$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
	if($http_code != 200) 
		throw new Exception('Error : Failed to receieve access token');
	return $data;
}
// $access_token is the access token you got earlier
function GetUserProfileInfo($access_token1) {	
	$url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email';	
	
	$ch = curl_init();		
	curl_setopt($ch, CURLOPT_URL, $url);		
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token1));
	$data = json_decode(curl_exec($ch), true);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
	if($http_code != 200) 
		throw new Exception('Error : Failed to get user information');
		
	return $data;
}
if(isset($_GET['code'])){
	/*try {
		// Get the access token 
		$data = GetAccessTokenGoogle(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

		// Access Token
		$access_token1 = $data['access_token'];
		
		// Get user information
		$user_info = GetUserProfileInfo($access_token1);
	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}*/
	if(isset($_SESSION['access_token'])){
		$access_token = $_SESSION['access_token'];
	}
	else{
		$access_token = $facebook_helper->getAccessToken();
		$_SESSION['access_token'] = $access_token;
		$facebook->setDefaultAccessToken($_SESSION['access_token']);
	}
	$graph_response = $facebook->get("/me?fields=name,email", $access_token);
	$facebook_user_info = $graph_response->getGraphUser();		
	if(isset($_SESSION['username_frontend'])){
		$username = $_SESSION['username_frontend'];
	}else{
		$username = $facebook_user_info['email'];
	}
	$fullname = $facebook_user_info['name'];
	$image = 'http://graph.facebook.com/'.$facebook_user_info['id'].'/picture';
	$thumb = 'http://graph.facebook.com/'.$facebook_user_info['id'].'/picture';
	$email = $facebook_user_info['email'];
	$oauth_provider = 'facebook';	
	$check = $CI->site_model->checkFacebook($username);
	if($check->num_rows()==1){
		$_SESSION['username_frontend'] = $username;
		$_SESSION['uid'] = $check->row()->id;		
		header('Location:'.base_url());	
		echo "<script>window.location.reload();</script>";
		echo "<script>window.location.href='javascript:history.back(-1);'</script>";		
	}else{
		$data_ins = [
			'username' => $username,
			'image' => $image,
			'thumb' => $thumb,
			'fullname' => $fullname,
			'email' => $email,
			'oauth_provider' => $oauth_provider,
			'post_date' => date('Y-m-d H:i:s'),
			'status' => 1
		];
		$this->db->insert('tbluser',$data_ins);
		$_SESSION['username_frontend'] = $username;
		$_SESSION['uid'] = $check->row()->id;				
		echo "<script>window.location.reload();</script>";
		echo "<script>window.location.href='javascript:history.back(-1);'</script>";		
	}		
}else{
	// Get login url
    $facebook_permissions = ['email']; // Optional permissions
    $facebook_login_url = $facebook_helper->getLoginUrl('https://khotinmoi.com/', $facebook_permissions);
    // Render Facebook login button
    $facebook_login_url = '<a id="login_input_fb" href="'.$facebook_login_url.'"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>';
}
?>
<div class="login_all_main">
                <p class="login_all_top">Đăng nhập</p>
                <div class="login_l">                                   
                        <div class="login_input">
                            <input type="text" name="username_res" id="username_res" placeholder="Tài khoản" autocomplete="off">
                        </div>
                        <div class="login_input">
                            <input type="password" name="password_res" id="password_res" placeholder="Mật khẩu" autocomplete="off">
                        </div>
                        <div class="login_input">
                            <input type="checkbox" name="rememberme" checked value="1"> Ghi nhớ mật khẩu
                        </div>
                        <div class="login_input">
                            <button type="submit" onclick="submitFormLogin()">Đăng nhập</button>
                        </div>                    
                </div>   
                <div class="login_r">
                    <p class="other">
                        <span>Hoặc</span>
                    </p>
                    <div class="login_input">
                        <?php echo $facebook_login_url; ?>
                    </div>
                    <div class="login_input">
                        <a href="<?php //echo $login_url; ?>" id="login_input_google"><i class="fa fa-google" aria-hidden="true"></i> Google</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <p class="login_notification_res">Chưa có tài khoản ? <a id="register_tab">Đăng ký tài khoản mới</a></p>
            </div>
            <script src="https://www.google.com/recaptcha/api.js"></script>            
            <div class="register_all_main">
                <p class="login_all_top">Đăng ký tài khoản</p>
                <div id="uname_response"></div>
                <div class="register_input">
                    <input type="text" name="username" id="user_dk" placeholder="Tài khoản" autocomplete="off">                    
                </div>
                <div class="register_input_pwd">
                    <input type="password" name="password" id="pwd_dk" placeholder="Mật khẩu" autocomplete="off">
                </div>
                <div class="register_input_pwd" style="margin-right:0;">
                    <input type="password" name="re_password" id="re_password_dk" placeholder="Xác nhận mật khẩu" autocomplete="off">
                </div>
                <div class="register_input">
                    <input type="text" name="fullname" id="fullname_dk" placeholder="Họ tên" autocomplete="off">
                </div>
                <div class="register_input">
                    <input type="text" name="email" id="email_dk" placeholder="Email" autocomplete="off">
                </div>
                <div class="register_input">
                    <input type="text" name="phone" id="phone_dk" placeholder="Điện thoại" autocomplete="off">
                </div> 
                <div id="recaptcha" style="margin-bottom:10px;" class="g-recaptcha" data-sitekey="6LfhIrsZAAAAAEp2uhaUnbGTRu3ZKpkz9NadGwZn" data-callback="verifyCaptcha"></div> 
                <div id="g-recaptcha-error"></div>               
                <div class="register_input register_input_check">
                    <input type="checkbox" name="not_register" id="not_register" value="0"> Tôi đồng ý với <a href="<?php echo site_url('thoa-thuan-cung-cap-su-dung-dich-vu.html'); ?>" target="_blank" title="Thoả thuận cung cấp & sử dụng dịch vụ">điều khoản dịch vụ</a> và <a href="<?php echo site_url('chinh-sach-quyen-rieng-tu.html'); ?>" target="_blank" title="Chính sách quyền riêng tư">chính sách quyền riêng tư</a>
                </div>                
                <div class="register_input" style="margin:auto;float:none;">
                    <button type="submit" id="create_user">Tạo tài khoản</button>
                </div>
                <p class="other">
                    <span>Hoặc</span>
                </p>
                <div class="login_input">
                    <?php echo $facebook_login_url; ?>
                </div>
                <div class="login_input">
                    <a href="" id="login_input_google"><i class="fa fa-google" aria-hidden="true"></i> Google</a>
                </div>
                <div class="clearfix"></div>
                <p class="login_notification_res">Đã có tài khoản ? <a id="login_tab">Đăng nhập</a></p>
            </div>