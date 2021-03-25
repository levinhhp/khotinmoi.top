<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Site extends FrontEndController
{
    public function index()
    {    
        $this->check_ip();           
        $mobile = detect_mobile();
        $data['home'] = true;          
        if($mobile === true){
            $data['main_content'] = 'mobile/elements/main_content';
            $this->displayTemplateMobile($data);
        }else{
            $data['main_content'] = 'elements/main_content';
            $this->displayTemplate($data);  
        }
    }  
    public function loadModalLogin(){
        $html = $this->load->view('login_modal');
        echo $html;
    }
    public function check_google(){
        $user_name = $_POST['yu'];
        $fullname = $_POST['Cd'];
        $image = $_POST['PK'];
        $thumb = $_POST['PK'];
        $oauth_provider	= 'google';
        $email = $_POST['email'];
        $data_up = [
            'username' => $user_name,
            'image' => $image,
            'thumb' => $thumb,
            'fullname' => $fullname,
            'email' => $email,
            'oauth_provider' => $oauth_provider,
            'status' => 1
        ];
        $check = $this->site_model->checkFacebook($user_name);
        if($check->num_rows()==1){
            $_SESSION['username_frontend'] = $user_name;
            $_SESSION['uid'] = $check->row()->id;		            
        }else{
            $this->db->insert('tbluser',$data_up);
            $_SESSION['username_frontend'] = $username;
		    $_SESSION['uid'] = $check->row()->id;	
        }        
        echo json_encode($_POST);        
    }
    public function fblogin(){
		$this->fblogin();
	}
	
    public function preview(){     
        $data['header_title'] = 'Preview';    
        $data['main_content'] = 'preview';
        $this->displayTemplate($data);  
    }

    public function changePassword(){
        $this->checkSessionLogin();
        $data['header_title'] = 'Đổi mật khẩu';    
        $data['main_content'] = 'change_password';
        $this->displayTemplate($data);  
    }
    public function dangtin(){
        $this->checkSessionLogin();
        $data['header_title'] = 'Đăng tin';    
        $data['main_content'] = 'dangtin_view';
        $this->displayTemplate($data);  
    }
    public function addPost(){
        $this->checkSessionLogin();
        $post_title = $this->input->post('post_title');
        $post_category = $this->input->post('post_category');
        $post_category_sub = $this->input->post('post_category_sub');
        $post_description = $this->input->post('post_description');
        $post_content = $this->input->post('post_content');
        if(!empty($_FILES['file']['name'])){ 
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '1000000';
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')){
                $image_data = $this->upload->data();                                  
                $duongdan=$image_data['file_name'];
                $config1['image_library'] = 'gd2';
                $config1['source_image']	= './upload/'.$duongdan;
                $config1['create_thumb'] = TRUE;
                $config1['maintain_ratio'] = TRUE;
                $config1['width']	=600;
                $config1['height']	= 500;
                $this->load->library('image_lib', $config1); 
                $this->image_lib->resize();
                $temp=explode('.',$image_data['file_name']);
                $thumb='upload/'.$temp[0].'_thumb'.'.'.$temp[1];
                $name_img='upload/'.$image_data['file_name'];           
            }
        }else{           
            $thumb = '';
            $name_img = '';            
        }
        $data_up_tin = [
            'title' => $post_title,
            'alias' => LocDau($post_title).'.html',
            'category' => $post_category,
            'category_sub' => $post_category_sub,
            'description' => $post_description,
            'image' => $name_img,
            'thumb' => $thumb,
            'content' => $post_content,
            'date_day' => date('Y-m-d H:i'),
            'author' => $_SESSION['username_frontend'],
            'status' => 0
        ];
        $this->db->insert('tblarticle',$data_up_tin);
    }
    public function listPost(){
        $this->checkSessionLogin();
        $data['header_title'] = 'Danh sách tin đăng';    
        $data['main_content'] = 'listpost_view';
        $this->displayTemplate($data);  
    }
    public function listPostAjax(){
        $config['base_url'] = site_url('site/listPostAjax');
        $config['total_rows'] = $this->site_model->getListPost()->num_rows();
        $config['per_page'] = 1;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;                                                        
        $data['results'] = $this->site_model->getListPostLimit($config['per_page'], $data['page']);                                                         
        $pagination = $this->pagination->create_links();                               
        $data['links'] = $pagination;
        if($this->input->post('ajax')) {
            $this->load->view('list_post_ajax', $data);
        } else {
            $this->load->view('list_post_all', $data);
        }
    }
    public function load_category_sub(int $id){
        $this->checkSessionLogin();
        $district = $this->site_model->getdanhmuc2($id);
        echo '<option value="">-- Danh mục con --</option>';
        foreach ($district as $item) {
            echo '<option value="' . $item->id . '"' . set_select('post_category_sub', $item->id) . '>' . $item->category . '</option>';
        }
    }
    public function doChangePass(){
        $this->checkSessionLogin();
        $id = $_SESSION['uid_frontend'];
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $config_password = $this->input->post('config_password');
        $check_pass = $this->site_model->checkPassOld($current_password); 
        if($check_pass->num_rows()>0){
            if($new_password==''){
                $html = '<p style="color:red;"><strong>Mật khẩu mới không để trống</strong></p>';     
            }elseif(strlen($new_password)<6){
                $html = '<p style="color:red;"><strong>Mật khẩu mới phải lớn hơn 6 ký tự</strong></p>';    
            }elseif($new_password!=$config_password){
                $html = '<p style="color:red;"><strong>Xác nhận mật khẩu không giống nhau</strong></p>';
            }else{
                $data_change = [
                    'password' => md5($new_password)
                ];
                $this->db->where('id',$id);
                $this->db->update('tbluser',$data_change);
                $html = '<p style="color:green;"><strong>Đổi mật khẩu thành công</strong></p>';
            }
        }else{
            $html = '<p style="color:red;"><strong>Mật khẩu cũ không đúng</strong></p>';
        }
        echo $html;
    }

    public function personalPage(){
        $this->checkSessionLogin();
        $data['header_title'] = 'Trang cá nhân'; 
        $data['main_content'] = 'personal_page';
        $this->displayTemplate($data);         
    }

    public function updatePersion(){
        $this->checkSessionLogin();
        $fullname = $this->input->post('fullname');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');        
        $info = $this->input->post('info');
        if(!empty($_FILES['file']['name'])){ 
            $config['upload_path'] = './upload/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '1000000';
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')){
                $image_data = $this->upload->data();                                  
                $duongdan=$image_data['file_name'];
                $config1['image_library'] = 'gd2';
                $config1['source_image']	= './upload/'.$duongdan;
                $config1['create_thumb'] = TRUE;
                $config1['maintain_ratio'] = TRUE;
                $config1['width']	=100;
                $config1['height']	= 100;
                $this->load->library('image_lib', $config1); 
                $this->image_lib->resize();
                $temp=explode('.',$image_data['file_name']);
                $thumb='upload/'.$temp[0].'_thumb'.'.'.$temp[1];
                $name_img='upload/'.$image_data['file_name'];           
            }
        }else{           
            $thumb = $this->input->post('hidden_thumb');
            $name_img = $this->input->post('hidden_avatar');            
        }
        $data_persion = [
            'image' => $name_img,
            'thumb' => $thumb,
            'fullname' => $fullname,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'info' => $info
        ];
        $this->db->where('id',$_SESSION['uid_frontend']);
        $this->db->update('tbluser',$data_persion);
        $html = '<p style="color:green;"><strong>Cập nhật thành công</strong></p>';
        echo $html;
    }

    public function contact()
    {
        $this->check_ip();
        $mobile = detect_mobile();
        $data['header_title'] = 'Liên hệ';        
        if($mobile === true){
            $data['main_content'] = 'mobile/contact';
            $this->displayTemplateMobile($data);
        }else{
            $data['main_content'] = 'contact';
            $this->displayTemplate($data); 
        }
    }

    public function checkUserName(){
        $username_check = $_POST['username_check'];
        $this->db->where('username',$username_check);
        $sql_check_user = $this->db->get('tbluser');
        if($sql_check_user->num_rows()>0){            
            $response = "<span style='color: red;font-size:12px;padding-bottom:10px;display:block;'>Tài khoản đã tồn tại. Vui lòng chọn Tài khoản khác.</span>";
        }else{
            $response = '<span style="color: green;font-size:12px;padding-bottom:10px;display:block;">Tài khoản khả dụng</span>';
        }
        echo $response;
        die;
    }

    public function doRegister(){
        $user_dk = $_POST['user_dk'];
        $pwd_dk = $_POST['pwd_dk'];
        $fullname_dk = $_POST['fullname_dk'];
        $email_dk = $_POST['email_dk'];
        $phone_dk = $_POST['phone_dk'];
        $api_token = $this->generateRandomString();
        $data_user = [
            'username' => $user_dk,
            'password' => md5($pwd_dk),
            'fullname' => $fullname_dk,
            'phone'  => $phone_dk,
            'email' => $email_dk,
            'post_date' => date('Y-m-d H:i'),
            'api_token' => $api_token,
            'status' => 1
        ];
        $this->createTable('tbluser',$data_user);      
        $ids = $this->db->insert_id();
        $this->db->where('id',$ids);
        $this->db->limit(1);
        $sql_email = $this->db->get('tbluser');
        $noidungemail='
            <p><h3><b>Thông tin Xác minh Email</b></h3></p>
            <p>Vui lòng click vào link để xác minh tài khoản.<a href="'.base_url().'/site/activate/'.$sql_email->row()->api_token.'">Link kích hoạt</a>:</p>            			
        ';    		  
        require_once('class.phpmailer.php');             
        require_once('class.pop3.php');                 
        define('GUSER','admin@buonchung.com');
        define('GPWD','tieuvu@123456');
        global $message;                            
        $this->smtpmailer($email_dk,'admin@buonchung.com', "khotinmoi.com", "Xác minh Email tại website khotinmoi.com",$noidungemail);  
        $this->smtpmailer('admin@buonchung.com',$email_dk, "khotinmoi.com", "Xác minh Email tại website khotinmoi.com",$noidungemail);    
    }
    
    public function doLogin(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->checkLogin($username,$password);                
    }

    public function activate($api_token){
        $this->db->where('api_token',$api_token);
        $sql_token = $this->db->get('tbluser');
        if($sql_token->num_rows()>0){
            $data_up = [
                'api_token'=>'',
                'status'=>1
            ];
            $this->db->where('id',$sql_token->row()->id);
            $this->db->update('tbluser',$data_up);
            $data['header_title'] = 'Xác minh tài khoản'; 
            $data['main_content'] = 'activate';
            $this->displayTemplate($data); 
        }else{
            echo 'Api token không tồn tại';
        }
    }

    public function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function logout(){
        session_destroy();
        unset($_SESSION['username_frontend']);
        unset($_SESSION['access_token']);
        redirect(base_url());
    }
    public function docontact()
    {
        $hoten = $_POST['hoten'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $diachi = $_POST['diachi'];
        $mota = $_POST['mota'];
        $data = [
            'name' => $hoten,
            'address' => $diachi,
            'phone' => $phone,
            'email' => $email,
            'content' => $mota,
            'date_contact' => date('Y-m-d'),
            'status' => NO_ACTION
        ];
        $this->createTable('tblcontact',$data);        
    }

    public function showPopup(){
        $this->check_ip();        
        $data['query'] = $this->site_model->gettablename_all('tblarticle','id,title,category,category_sub,description,date_day,content,view,ordernum,status',1,'id',$_POST['id']);
        $this->db->where('id',$_POST['id']);
        $sql_view = $this->db->get('tblarticle');
        $ip1 = $this->input->ip_address();
        if($ip1 =="183.81.68.187" || $ip1 =="117.5.146.87"){
	}else{
            if(isset($_COOKIE['visitor_id'])){
                if($_COOKIE['visitor_id']==$_POST['id']){
                    
                }else{
		    setcookie("visitor_id", $_POST['id'], time()+1*24*60*60);
                    $data_view = [
                        'view' => $sql_view->row()->view + 1
                    ]; 
                    $this->db->where('id',$_POST['id']); 
                    $this->db->update('tblarticle',$data_view); 
                    $this->db->where('article_id',$_POST['id']);                
                    $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));  
                    $this->db->limit(1);
                    $sql_ip_view = $this->db->get('tbladdress_ip_view');
                    if($sql_ip_view->num_rows()>0){
                        $data_new_ip = [                                        
                            'article_id' => $_POST['id'],
                            'view' => $sql_ip_view->row()->view + 1,                     
                        ];
                        $this->db->where('id',$sql_ip_view->row()->id);
                        $this->db->update('tbladdress_ip_view',$data_new_ip); 
                    }else{
                        $data_new_ip = [                    
                            'category_id' => $sql_view->row()->category,
                            'article_id' => $_POST['id'],
                            'view' => 1,
                            'date_day' => date('Y-m-d H:i'),
                            'status' => 1    
                        ];
                        $this->db->insert('tbladdress_ip_view',$data_new_ip);    
                    }     
                }
            }else{
                setcookie("visitor_id", $_POST['id'], time()+1*24*60*60);
                $data_view = [
                    'view' => $sql_view->row()->view + 1
                ];  
                $this->db->where('id',$_POST['id']); 
                $this->db->update('tblarticle',$data_view);  
                $this->db->where('article_id',$id);
                $this->db->limit(1);
                $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));  
                $sql_ip_view = $this->db->get('tbladdress_ip_view');
                if($sql_ip_view->num_rows()>0){
                    $data_new_ip = [                                        
                        'article_id' => $id,
                        'view' => $sql_ip_view->row()->view + 1,                     
                    ];
                    $this->db->where('id',$sql_ip_view->row()->id);
                    $this->db->update('tbladdress_ip_view',$data_new_ip); 
                }else{
                    $data_new_ip = [                    
                        'category_id' => $data['query1']->category,
                        'article_id' => $id,
                        'view' => 1,
                        'date_day' => date('Y-m-d H:i'),
                        'status' => 1    
                    ];
                    $this->db->insert('tbladdress_ip_view',$data_new_ip);    
                } 
            } 
        }             
        $html = $this->load->view('popup_view',$data);
        echo $html;
    }

    public function baivietcap1($id)
    {
        $mobile = detect_mobile();
        if($mobile === true){
            $this->displayPagePagination('tblarticle_category','tblarticle',$id,15,'category','category_sub','site/baivietcap1','mobile/news_mobile','mobile/news_view_mobile');
        }else{
            $this->displayPagePagination('tblarticle_category','tblarticle',$id,15,'category','category_sub','site/baivietcap1','news','news_view');        
        }
    }

    public function baivietchitiet($id)
    {  
        $mobile = detect_mobile();
        if($mobile === true){
            $this->displayPageDetail('tblarticle',$id,'title','mobile/news_view_mobile'); 
        }else{
            $this->displayPageDetail('tblarticle',$id,'title','news_view'); 		 
        }
    } 

    public function themeDetail($id)
    {
        $this->displayPageSingleDetail('tbltheme',$id,'title','single_view');        
    }
    
    public function customers()
    {
        $data['query'] = $this->getTableName('tblcustomers','','','','');        
        $data['main_content']='customer_view';
		$this->displayTemplate($data); 
    }

    public function interface()
    {
        $data['category'] = $this->getTableName('tbltheme_category','','','',''); 
        $data['themes'] = $this->getTableName('tbltheme','','','',''); 
        $data['main_content']='interface_view';
        $this->displayTemplate($data);         
    }

    public function search(){
        $mobile = detect_mobile();        
        if($mobile === true){
            $this->getSearch('tblarticle','title','title',15,4,'site/search_view','mobile/search_view');        
        }else{
            $this->getSearch('tblarticle','title','title',15,4,'site/search_view','search_view');        
        }
    }

    public function getnewsByTag($id){
        $mobile = detect_mobile();
        if($mobile === true){
            $this->getTag('tag','tag_new',2,$id,15,4,'site/getnewsByTag','mobile/newsbytag');
        }else{
            $this->getTag('tag','tag_new',2,$id,15,4,'site/getnewsByTag','newsbytag');
        }        
    }

    public function dolike(){
        $this->likePost('tblarticle','id');        
    }
}
?>