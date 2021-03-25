<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FrontEndController extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('site/site_model');		        	
        $this->load->library('form_validation');  
        $this->load->helper('catchuoi');  
        $this->load->library('pagination');
        $this->load->helper('mobile');          				
    }  
    public function check_ip(){
        $mobile = detect_mobile();
        $ip = $this->input->ip_address();
		if($ip!='183.81.68.187' || $ip!='117.5.146.87'){
			$this->db->where('ip_address',$ip);
			$this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
			$sql = $this->db->get('tbladdress_ip');    
			if($sql->num_rows()>0){
			}else{ 
				if($mobile === true){
					$devices = MOBILE;
				}else{
					$devices = PC;
				}           
				$data = [
					'ip_address' => $ip,
					'devices' => $devices,
					'date_day' => date('Y-m-d H:i'),
					'status' => 1
				];
				$this->db->insert('tbladdress_ip',$data);        
			}
		}
    }
	public function fblogin(){
		
		$userData = array();
		//Authenticate user with facebook
		if($this->facebook->is_authenticated()){ 
			//Get user info from facebook 
			$fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture'); 
			//Preparing data for database insertion			
			$username = !empty($fbUser['email'])?$fbUser['email']:''; 
			$image = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:''; 
			$thumb = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:''; 
			$fullname = !empty($fbUser['first_name'])?$fbUser['first_name']:''; 
			$email = !empty($fbUser['email'])?$fbUser['email']:''; 
			$oauth_provider = 'facebook';
			$check = $this->site_model->checkFacebook($username);
			if($check->num_rows()==1){
				$_SESSION['username_frontend'] = $username;
				$_SESSION['uid'] = $check->row()->id;
			}else{
				$data_ins = [
				    'username' => $username,
					'image' => $image,
					'thumb' => $thumb,
					'fullname' => $fullname,
					'email' => $email,
					'oauth_provider' => $oauth_provider					
				];
				$this->db->insert('tbluser',$data_ins);
				$_SESSION['username_frontend'] = $username;
				$_SESSION['uid'] = $check->row()->id;
			}
		}
		redirect(base_url());
	}
    public function displayTemplate($data)
    {
        $this->load->view('layouts/template',$data);    
    }

    public function displayTemplateMobile($data){
        $this->load->view('mobile/layouts/template',$data);  
    }

    public function getTag($table_name,$table_name1,$categorie_type,$id,$per_page,$page_segment,$page_link,$page_view)
	{	
        $this->check_ip();
        $mobile = detect_mobile();			
		$data['tag']=$this->site_model->getTagNew($table_name,$id);	
		if($data['tag'])
		{
			$data['header_title']=$data['tag']->tag;
		}
		else
		{
			$data['header_title']='';
		}
		$query=$this->site_model->getnewByTagId($table_name1,$id,$categorie_type);
		$total_rows =$query->num_rows();		
		$start_row=$this->uri->segment(4);
		$config['base_url'] = site_url().'/'.$page_link.'/'.$id;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['uri_segment'] =$page_segment;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['num_links'] = 10;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open']='<div class="pagination">';
		$config['full_tag_close']='</div>';
		$this->pagination->initialize($config);
		$data['query']=$this->site_model->getnewByTagId_limited($table_name1,$id,$categorie_type,$per_page,$start_row);
		$data['pagination']= $this->pagination->create_links();	
		$lks=$pagination;
        $lks='<ul class="page-numbers">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li><a class="page-numbers current">','<li><a rel="nofollow" class="page-numbers" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['pagination']=$lks;   	
        $data['main_content']=$page_view;
        if($mobile === true){
            $this->displayTemplateMobile($data);
        }else{
            $this->displayTemplate($data);     		
        }
    }
    
    public function getSearch($table_name,$name,$value,$per_page,$page_segment,$page_link,$page_view){  
        $this->check_ip();
        $mobile = detect_mobile();      
        $start_row=$this->uri->segment($page_segment);        
		if(is_numeric($start_row))
		{
			$start_row=$start_row;
		}
		else
		{
			$start_row=0;
		}
        $query=$this->site_model->getSearchTable($table_name,$name,$value);
		$total_rows = $query->num_rows();
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/'.$page_link.'/'.$name;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['uri_segment'] =4;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['num_links'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open']='<div class="pagination">';
		$config['full_tag_close']='</div>';
		$this->pagination->initialize($config);
		$data['query']=$this->site_model->getSearchTableLimited($table_name,$name,$value,$per_page,$start_row);
		$pagination= $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="page-numbers">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li><a class="page-numbers current">','<li><a rel="nofollow" class="page-numbers" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['pagination']=$lks;   	
        $data['main_content']=$page_view;        
        if($mobile === true){
            $this->displayTemplateMobile($data);
        }else{
            $this->displayTemplate($data);     			
        }
    }

    public function displayPagePagination($table_name,$table_name2,$id,$per_page,$name,$name2,$page_link,$page_view,$page_view2)
    {
        $this->check_ip();
        $mobile = detect_mobile();
        $this->db->where('id',$id);
        $cate=$this->db->get($table_name);
        if($cate->num_rows()>0){
            $this->db->where('id',$id);        
            $data['danhmuc1'] = $this->db->get($table_name)->row();            
            $data['danhmuc'] = $data['danhmuc1'];   
            $data['danhmucbaiviet']=$cate->row()->id;   
            if($data['danhmuc1']->keyword!='')
            {
    	       $data['keyword']=$data['danhmuc1']->keyword;
            }
            if($data['danhmuc1']->meta_title!='')
            {
    	       $data['header_title']=$data['danhmuc1']->meta_title;
        	}
            else
        	{          	   
                $data['header_title']=$data['danhmuc1']->$name;                                                                                                             	                   
        	}
            if($data['danhmuc1']->meta_des!='')
        	{
        	    $data['description']=$data['danhmuc1']->meta_des;
        	}
            $start_row=$this->uri->segment(4);
            $per_page=$per_page;
    		if(is_numeric($start_row))
    		{
    			$start_row=$start_row;
    		}
    		else
    		{
    			$start_row=0;
    		}
            $query=$this->site_model->getTableNameAll($table_name2,$name,$id,$name2);            
    		$total_rows = $query->num_rows();    		
    		$config['base_url'] = site_url().'/'.$page_link.'/'.$id;
    		$config['total_rows'] = $total_rows;
    		$config['per_page'] = $per_page;
    		$config['uri_segment'] =4;
    		$config['next_link'] = '→';
    		$config['prev_link'] = '←';
    		$config['num_links'] = 4;
    		$config['first_link'] = 'First';
    		$config['last_link'] = 'Last';
    		//$config['full_tag_open']='<div class="pagination">';
    		//$config['full_tag_close']='</div>';
    		$this->pagination->initialize($config);
    		$data['query']=$this->site_model->getTableNameAll_limited($table_name2,$name,$id,$name2,$per_page,$start_row);
            $data['dm'] = $id;            
            if($data['query']->num_rows()==1)
    		{	                
      		    $this->db->where($name,$id);
                $sqlview=$this->db->get($table_name2)->row();      		    
                $data['main_content']=$page_view2;   
                if($mobile == true){
                    $this->displayTemplateMobile($data);
                }else{             
                    $this->displayTemplate($data);
                }
    		}
    		else
    		{    			
    			$pagination= $this->pagination->create_links();
                $lks=$pagination;
                $lks='<ul class="page-numbers">'.$pagination; 
                $datar1=array('<strong>','<a hr');    
                $datar2=array('<li><a class="page-numbers current">','<li><a rel="nofollow" class="page-numbers" hr');
                $datar3=array('</strong>','</a>');    
                $datar4=array('</a></li>','</a><li>');         
                $lks=str_replace($datar1,$datar2,$lks);
                $lks=str_replace($datar3,$datar4,$lks);        
                $lks.='</ul>';
                $data['pagination']=$lks;   	
                $data['main_content']=$page_view;
                if($mobile == true){
                    $this->displayTemplateMobile($data);
                }else{
                    $this->displayTemplate($data);
                }
    	   }                	    
        }
        else{
            $data['main_content']='error/error';
            if($mobile == true){
                $this->displayTemplateMobile($data);
            }else{
                $this->displayTemplate($data);
            }
        }           
    }

    public function displayPageDetail($table_name,$id,$category_name,$page_view)
    {      
        $this->check_ip();          
        $mobile = detect_mobile();        
        $this->db->where('id',$id);
        $data['query1'] = $this->site_model->gettablename($table_name,'',$id);  
        $ip1 = $this->input->ip_address();
        if($ip1 == "183.81.68.187" || $ip1 == "117.5.146.87"){            
	}else{                        
            if(isset($_COOKIE['visitor_id'])){               
                if($_COOKIE['visitor_id']==$id){                                   
                }else{        
                    setcookie("visitor_id", $id, time()+1*24*60*60);   
                    $data_up_view = [
                        'view' => $data['query1']->view + 1
                    ]; 
                    $this->db->where('id',$id);
                    $this->db->update($table_name,$data_up_view); 
                    $this->db->where('article_id',$id);            
                    $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d')",date('Y-m-d'));  
                    $this->db->limit(1);
                    $sql_ip_view = $this->db->get('tbladdress_ip_view');
                    if($sql_ip_view->num_rows()>0){
                        $data_new_ip = [                                            
                            'article_id' => $id,
                            'view' => $sql_ip_view->row()->view + 1,                          
                        ];
                        $this->db->where('id',$sql_ip_view->row()->id);
                        $this->db->update('tbladdress_ip_view',$data_new_ip); 
                    }else{
                        $data_new_ip1 = [                    
                            'category_id' => $data['query1']->category,
                            'article_id' => $id,
                            'view' => 1,
                            'date_day' => date('Y-m-d H:i'),
                            'status' => 1    
                        ];
                        $this->db->insert('tbladdress_ip_view',$data_new_ip1);    
                    }  
                }
            }else{       
                setcookie("visitor_id", $id, time()+1*24*60*60);          
                $data_up_view = [
                    'view' => $data['query1']->view + 1
                ];  
                $this->db->where('id',$id);
                $this->db->update($table_name,$data_up_view);  
                $this->db->where('article_id',$id);
                $this->db->limit(1);
                $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d')",date('Y-m-d'));  
                $sql_ip_view = $this->db->get('tbladdress_ip_view');
                if($sql_ip_view->num_rows()>0){
                    $data_new_ip3 = [                                        
                        'article_id' => $id,
                        'view' => $sql_ip_view->row()->view + 1,                     
                    ];
                    $this->db->where('id',$sql_ip_view->row()->id);
                    $this->db->update('tbladdress_ip_view',$data_new_ip3); 
                }else{
                    $data_new_ip4 = [                    
                        'category_id' => $data['query1']->category,
                        'article_id' => $id,
                        'view' => 1,
                        'date_day' => date('Y-m-d H:i'),
                        'status' => 1    
                    ];
                    $this->db->insert('tbladdress_ip_view',$data_new_ip4);    
                }
            }   
        }
        if($data['query1']->meta_title!='')
    	{
    	    $data['header_title']=$data['query1']->meta_title;
    	}
    	else
    	{    	    
            $data['header_title']=$data['query1']->$category_name;                                                         
    	}
    	if($data['query1']->keyword!='')
    	{
    	    $data['keyword']=$data['query1']->keyword;
    	}
    	if($data['query1']->meta_des!='')
    	{
    	    $data['description']=$data['query1']->meta_des;
    	}
    	else
    	{    	    
            $data['description']=$data['query1']->$category_name;                                                             
    	}      
        $data['ct'] = $id;        
        $data['main_content']=$page_view;        
        if($mobile === true){            
            $this->displayTemplateMobile($data);
        }else{
            $this->displayTemplate($data);
        }		 
    }

    public function displayPageSingleDetail($table_name,$id,$name,$page_view)
    {
        $this->check_ip();
        $this->db->where('id',$id);
        $data['theme_ct'] = $this->site_model->gettablename($table_name,'',$id);         
        if($data['theme_ct']->meta_title!='')
    	{
    	    $data['header_title']=$data['theme_ct']->meta_title;
    	}
    	else
    	{    	    
            $data['header_title']=$data['theme_ct']->$name;                                                         
    	}
    	if($data['theme_ct']->keyword!='')
    	{
    	    $data['keyword']=$data['theme_ct']->keyword;
    	}
    	if($data['theme_ct']->meta_des!='')
    	{
    	    $data['description']=$data['theme_ct']->meta_des;
    	}
    	else
    	{    	    
            $data['description']=$data['theme_ct']->$name;                                                             
        }    
        $data['main_content']=$page_view;
        $this->displaySingleTemplate($data);
    }

    public function displaySingleTemplate($data)
    {
        $this->load->view('layouts/single',$data);       
    }

    public function createTable($table_name,$data)
    {
        $this->site_model->createUpdateTable($table_name,$data,'');
    }
    public function updateTable($table_name,$data,$id)
    {
        $this->site_model->createUpdateTable($table_name,$data,$id);
    }
    public function getTableName($table_name,$dataall_selct,$limit,$data_key,$data_value)
    {
        $this->db->where('status',1);        
        if($data_key!='' && $data_value!='')
        {
            $this->db->where($data_key,$data_value);
        }          
        $this->db->order_by('ordernum','desc');
        $this->db->order_by('id','desc');
        if($dataall_selct!='')
        {
            $this->db->select($dataall_selct);
        }
        if($limit!='')
        {
            $this->db->limit($limit);
        }
        $sqlall=$this->db->get($table_name);
        return $sqlall;
    } 
    public function checkSessionLogin(){
        if(isset($_SESSION['username_frontend'])){

        }else{
            echo "<script>window.location.href='javascript:history.back(-1);'</script>";
        }
    }
    public function likePost($table_name,$id){  
        $ip = $this->input->ip_address();      
        $id = $this->input->post($id);
        $this->db->where('id',$id);
        $sql_article = $this->db->get($table_name)->row(); 
        $this->db->where('ip_address',$ip);  
        $this->db->where('article_id',$id);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));  
        $sql_ip_like = $this->db->get('tbladdress_ip_like');     
        if($sql_ip_like->num_rows()>0){

        }else{
            $data_id =[
                'like_post' => $sql_article->like_post + 1
            ];
            $this->db->where('id',$id);
            $this->db->update($table_name,$data_id);
            $data_new_ip = [
                'ip_address' => $ip,                
                'article_id' => $id,
                'date_day' => date('Y-m-d H:i'),
                'status' => 1    
            ];
            $this->db->insert('tbladdress_ip_like',$data_new_ip);                 
        }
        $this->db->where('id',$id);
        $sql_article1 = $this->db->get($table_name)->row();    
        $html = $sql_article1->like_post;
        echo $html;
    }
    
    public function checkLogin($username,$password){     
        $this->check_ip();   
        if (!isset($username) || $username == '' || $username == 'undefined') {            
            echo 2;
            exit();
        }
        if (!isset($password) || $password == '' || $password == 'undefined') {            
            echo 3;
            exit();
        }
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo 4;
            exit();
        }else{
            $result = $this->site_model->validate($username,$password);
            if($result->num_rows() == 1){                
                $_SESSION['username_frontend'] = $username;
                $_SESSION['uid_frontend'] = $result->row()->id;                
                echo 1;
            }else{
                echo 5;
            }
        }
    }

    public function smtpmailer($to, $from, $from_name, $subject, $body)
     {
        $mail = new PHPMailer();                  // tạo một đối tượng mới từ class PHPMailer
        $mail->IsSMTP();                         // bật chức năng SMTP
        $mail->SMTPDebug = 0;                      // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;                  // bật chức năng đăng nhập vào SMTP này
        $mail->SMTPSecure = 'ssl';                 // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
        $mail->Host = 'smtp.zoho.com';         // smtp của gmail
        $mail->Port = 465;                         // port của smpt gmail
        $mail->Username = GUSER;  
        $mail->Password = GPWD;    
        $mail->CharSet = "UTF-8";        
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $message = 'Gởi mail bị lỗi: '.$mail->ErrorInfo; 
            return false;
        } 
        else 
        {
            $message = 'Thư của bạn đã được gởi đi ';
            return true;
        }
     }     
}