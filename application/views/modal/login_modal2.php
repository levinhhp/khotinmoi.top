<?php 
$CI = &get_instance();
$CI = $CI->load->model('site/site_model');
require_once 'vendor/facebook-php-sdk/autoload.php';
require_once 'vendor/google-api-php-client/autoload.php';
$google_client = new Google_Client();
//Set the OAuth 2.0 Client ID
$google_client->setClientId('121717500831-cfe7mks4fqj724qdkercd67v0r9jsd64.apps.googleusercontent.com');
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('C694ToM-lG0LsJlynqNm1IOA');
//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri(base_url());
$google_client->addScope('email');
$google_client->addScope('profile');
// Call Facebook API
$facebook = new \Facebook\Facebook([
	'app_id'      => APP_ID,
	'app_secret'     => APP_SECRET,
	'default_graph_version'  => 'v8.0'
]);
$facebook_output = '';
$facebook_helper = $facebook->getRedirectLoginHelper();
//google
$login_button = '';
if(isset($_GET['code'])){
	//google
	$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
	if(!isset($token['error'])){
		 $google_client->setAccessToken($token['access_token']);
		//Store "access_token" value in $_SESSION variable for future use.
		$_SESSION['access_token_google'] = $token['access_token'];
		//Create Object of Google Service OAuth 2 class
		$google_service = new Google_Service_Oauth2($google_client);
		$data = $google_service->userinfo->get();	
		$oauth_provider_google = 'google';
		$username_google = $data['email'];		
		$image_google = $data['picture'];
		$thumb_google = $data['picture'];
		$fullname_google = $data['given_name'];
		$email_google =  $data['email'];
		$check_google = $CI->site_model->checkFacebook($username_google);
		if($check_google->num_rows()==1){
			$_SESSION['username_frontend'] = $username_google;
			$_SESSION['uid'] = $check_google->row()->id;		
			header('Location:'.base_url());				
		}else{
			$data_ins_google = [
				'username' => $username_google,
				'image' => $image_google,
				'thumb' => $thumb_google,
				'fullname' => $fullname_google,
				'email' => $email_google,
				'oauth_provider' => $oauth_provider_google,
				'post_date' => date('Y-m-d H:i:s'),
				'status' => 1
			];
			$this->db->insert('tbluser',$data_ins_google);
			$_SESSION['username_frontend'] = $username_google;
			$_SESSION['uid'] = $check_google->row()->id;	
			header('Location:'.base_url());	
		}
	}
	//Facebook
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
		//echo "<script>window.location.reload();</script>";
		//echo "<script>window.location.href='javascript:history.back(-1);'</script>";		
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
		header('Location:'.base_url());	
		//echo "<script>window.location.reload();</script>";
		//echo "<script>window.location.href='javascript:history.back(-1);'</script>";		
	}		
}else{
	// Get login url
    $facebook_permissions = ['email']; // Optional permissions
    $facebook_login_url = $facebook_helper->getLoginUrl('https://khotinmoi.com/', $facebook_permissions);
    // Render Facebook login button
    $facebook_login_url = '<a id="login_input_fb" href="'.$facebook_login_url.'"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>';
}
if(!isset($_SESSION['access_token_google'])){
 $login_button = '<a id="login_input_google" href="'.$google_client->createAuthUrl().'"><i class="fa fa-google" aria-hidden="true"></i> Google</a>';
}
?>
<div class="modal_login">
    <div class="modal-content_login">
		<span class="close_login">&times;</span>
        <div class="login_all">            
            <div class="login_all_main">
                <p class="login_all_top">????ng nh???p</p>
                <div class="login_l">                                   
                        <div class="login_input">
                            <input type="text" name="username_res" id="username_res" placeholder="T??i kho???n" autocomplete="off">
                        </div>
                        <div class="login_input">
                            <input type="password" name="password_res" id="password_res" placeholder="M???t kh???u" autocomplete="off">
                        </div>
                        <div class="login_input">
                            <input type="checkbox" name="rememberme" checked value="1"> Ghi nh??? m???t kh???u
                        </div>
                        <div class="login_input">
                            <button type="submit" onclick="submitFormLogin()">????ng nh???p</button>
                        </div>                    
                </div>   
                <div class="login_r">
                    <p class="other">
                        <span>Ho???c</span>
                    </p>
                    <div class="login_input">
                        <?php echo $facebook_login_url; ?>
                    </div>
                    <div class="login_input">
                        <?php echo $login_button; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <p class="login_notification_res">Ch??a c?? t??i kho???n ? <a id="register_tab">????ng k?? t??i kho???n m???i</a></p>
            </div>
            <script src="https://www.google.com/recaptcha/api.js"></script>            
            <div class="register_all_main">
                <p class="login_all_top">????ng k?? t??i kho???n</p>
                <div id="uname_response"></div>
                <div class="register_input">
                    <input type="text" name="username" id="user_dk" placeholder="T??i kho???n" autocomplete="off">                    
                </div>
                <div class="register_input_pwd">
                    <input type="password" name="password" id="pwd_dk" placeholder="M???t kh???u" autocomplete="off">
                </div>
                <div class="register_input_pwd" style="margin-right:0;">
                    <input type="password" name="re_password" id="re_password_dk" placeholder="X??c nh???n m???t kh???u" autocomplete="off">
                </div>
                <div class="register_input">
                    <input type="text" name="fullname" id="fullname_dk" placeholder="H??? t??n" autocomplete="off">
                </div>
                <div class="register_input">
                    <input type="text" name="email" id="email_dk" placeholder="Email" autocomplete="off">
                </div>
                <div class="register_input">
                    <input type="text" name="phone" id="phone_dk" placeholder="??i???n tho???i" autocomplete="off">
                </div> 
                <div id="recaptcha" style="margin-bottom:10px;" class="g-recaptcha" data-sitekey="6LfhIrsZAAAAAEp2uhaUnbGTRu3ZKpkz9NadGwZn" data-callback="verifyCaptcha"></div> 
                <div id="g-recaptcha-error"></div>               
                <div class="register_input register_input_check">
                    <input type="checkbox" name="not_register" id="not_register" value="0"> T??i ?????ng ?? v???i <a href="<?php echo site_url('thoa-thuan-cung-cap-su-dung-dich-vu.html'); ?>" target="_blank" title="Tho??? thu???n cung c???p & s??? d???ng d???ch v???">??i???u kho???n d???ch v???</a> v?? <a href="<?php echo site_url('chinh-sach-quyen-rieng-tu.html'); ?>" target="_blank" title="Ch??nh s??ch quy???n ri??ng t??">ch??nh s??ch quy???n ri??ng t??</a>
                </div>                
                <div class="register_input" style="margin:auto;float:none;">
                    <button type="submit" id="create_user">T???o t??i kho???n</button>
                </div>
                <p class="other">
                    <span>Ho???c</span>
                </p>
                <div class="login_input">
                    <?php echo $facebook_login_url; ?>
                </div>
                <div class="login_input">
                    <a href="" id="login_input_google"><i class="fa fa-google" aria-hidden="true"></i> Google</a>
                </div>
                <div class="clearfix"></div>
                <p class="login_notification_res">???? c?? t??i kho???n ? <a id="login_tab">????ng nh???p</a></p>
            </div>
        </div>
    </div>
  </div>     