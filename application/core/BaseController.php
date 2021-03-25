<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BaseController extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper( array('array', 'url', 'form'));		
        $this->load->helper('images');
        $this->load->helper('catchuoi');
		$this->load->library('form_validation');		
		$this->load->model('admin_model');
	}

	public function deleteTableImage($table_name,$id)
	{
		$this->admin_model->delete_image($table_name,$id);	
	}

	public function updateTable($table_name,$id,$data)
	{
		$this->admin_model->updateTable($table_name,$id,$data);
	}

	public function deleteMultiple($table_name,$data)
	{
		$this->admin_model->deleteMultiple($table_name,$data);
	}

	public function createTable($table_name,$data)
	{
		$this->db->insert($table_name, $data);		
	}

	public function getTableById($table_name,$id)
	{
		return $this->admin_model->getEditRow($table_name,$id);
    }
    
    public function getTableIdValue($table_name,$id,$data_key,$data_value)
    {
        return $this->admin_model->getTableIdValue($table_name,$id,$data_key,$data_value);
    }

	public function showSitemap()
	{
		$this->admin_model->sitemap();
    }
    
    public function listColumnCallback($table_name)
    {        
        //************//
        //warning: all of table must have active column

        //************//
        //set label for radio, checkbox
        //the value sequence:
                            //0			//1				//...
        $lblRadioShow = array('Không Hiển thị',' Hiển thị');
        $lblQuet = array('Chưa quét',' Đã quét');
        $lblYes = array('Có','Không');
        $lblRadioShow = array('Không Hiển thị',' Hiển thị');
        $lblRadiof=array('Dofollow','Nofollow');
        $lblRadioht=array('Không hiển thị','Hiển thị');
        $lblRadioac=array('Chưa kích hoạt','Kích hoạt');
        $lblRadiovt=array('Trái','Phải');
        $lblRadiosale=array('Mặc Định','Giảm Giá');
        $lblRadioloai=array('Ảnh thường','Ảnh flash');
        $lblRadiovitri=array('Top','Bottom','Right');
        $lblRadio2=array('Trái','Phải');
        $lblRadiopro=array('Còn hàng','Hết hàng');
        $lblhienthihome = array('Không hiện thị','Hiện thị');				
        $lblduyet = array('Chưa duyệt','Đã duyệt');  
        $lblgioitinh=array('Nữ','Nam'); 
        $lblhonnhan=array('Độc thân','Đã kết hôn');
        $lblloaihinh=array('Nhà nước','Tư nhân');     
        switch($table_name)
        {              
            case 'tblcontact':
                return array
                (
                    'status'    =>  array('radio',$lblduyet)
                );
            case 'tag':
                return array
                (
                    'status'    =>  array('radio',$lblRadioShow)
                );
            case 'tag_new':
                return array
                (
                    'status'    =>  array('radio',$lblRadioShow)
                );
            case 'tblinformation':
                return array
                (
                    'logo'  =>  array('upload','image'),  
                    'favicon'   =>  array('upload','image'),                                                  
                    'status'	=> array('radio',$lblRadioShow),
                );
            case 'tblmeta':
                return array
                (
                    'status'    =>array('radio',$lblRadioShow),
                ); 
            case 'tblsetting_scan':
                return array
                (
                    'is_href' => array('radio',$lblYes),
                    'status' => array('radio',$lblRadioShow)    
                );
            case 'tblscan_post':
                $this->db->select('id,category');                
                $query = $this->db->get('tblarticle_category'); 
                $this->db->where('status',1);
                $this->db->select('id,setting_scan');
                $query1 = $this->db->get('tblsetting_scan');
                return array(
                    'category' => array('dropdown',$query->result()),                                                             
                    'category_sub' => array('dropdown',$query->result()), 
                    'setting_scan_id' => array('dropdown',$query1->result()),
                    'dom_status' => array('format','postFilter'),
                    'is_send' => array('radio',$lblQuet), 
                    'is_href' => array('radio',$lblYes),
                    'status' => array('radio',$lblRadioShow)
                );            
            case 'tblarticle_category': 
                $this->db->select('id,category');
                $query=$this->db->get('tblarticle_category');                
                return array
                (    
                    'image'   =>  array('upload','image'),                         
                    'parent_id'=>array('dropdown',$query->result()),  
                    'home'  =>  array('radio',$lblhienthihome),                                                    
                    'footer' =>  array('radio',$lblhienthihome),
                    'menu' =>  array('radio',$lblhienthihome),                                                                                                                                                                                                                                                                                                                                                   																	
                    'page_sub' =>  array('radio',$lblhienthihome), 
                    'status'=>array('radio',$lblRadioShow)
            );	               
            case 'tblarticle':
                $this->db->select('id,category');                
                $query = $this->db->get('tblarticle_category');                                                                                      
                return array
                (				
                    'image'	=>array('upload','image'),                                
                    'category' => array('dropdown',$query->result()),                                                             
                    'category_sub' => array('dropdown',$query->result()),  
                    'slider'  =>  array('radio',$lblhienthihome), 
                    'noibat'  =>  array('radio',$lblhienthihome),                                                                   
                    'hot'  =>  array('radio',$lblhienthihome),
                    'status'=>array('radio',$lblduyet)
                );                         
            case 'tbluser':
                return array
                (
                    //'matkhau' =>array('password','md5'),
                    'image'	=>array('upload','image'),     
                    'status'    =>  array('radio',$lblRadioac)
                );                            
            case 'tbladmin':
                $queryrole=$this->db->get('tblrole');
                return array
                (				
                    //'password'=>array('password','md5'),    
                    'avatar'   =>  array('upload','image'),             
                    'status'=>array('radio',$lblRadioac),
                );
            case 'tblcategory_ads':
                $this->db->where('parent_id',0);
                $this->db->select('id,category,parent_id');            
                $query=$this->db->get('tblarticle_category');    
                return array
                (      
                    'category'=>array('dropdown',$query->result()),              
                    'number_post' => array('format','postNumber'),    
                    'number_slider' => array('format','postNumber'),    
                    'number_ads' => array('format','postNumber'),  
                    'number_post_same' => array('format','postNumber'), 
                    'status'	=> array('radio',$lblRadioShow), 
                );     
            case 'tblads':
                $this->db->select('id,category_ads');                
                $query = $this->db->get('tblcategory_ads'); 
                return array
                ( 
                    'category_ads' => array('dropdown',$query->result()),                                                                                  
                    'image'   =>  array('upload','image'),   
                    'home' => array('radio',$lblhienthihome),                                                        
                    'status'    =>  array('radio',$lblRadioShow)
                ); 
            case 'tblsetting_home':
                return array(
                    'post_number' => array('format','postNumber'),
                    'slider_number' => array('format','postNumber'),
                    'status'    =>  array('radio',$lblRadioShow)    
                );
            default:		
            return NULL;
        }
    }

	public function checkAlias()
	{
		$alias=$_POST['html'];
        if(isset($_POST['id']))
        {
            $id=$_POST['id'];
             $this->db->where('id <>',$id);
        }
        $this->db->where('alias',$alias);
        $t=$this->db->get('tblarticle');
        if($t->num_rows()>0)
        {
            echo 'trung';
        }
        else
        {
            $this->db->where('alias',$alias);
            $t=$this->db->get('tblarticle_category');
            if($t->num_rows()>0)
            {
                echo 'trung';
            }
            else
            {
                $this->db->where('alias',$alias);
                $t=$this->db->get('tbltheme_category');
                if($t->num_rows()>0)
                {
                    echo 'trung';
                }
                else
                {
                    $this->db->where('alias',$alias);
                    $t=$this->db->get('tbltheme');
                    if($t->num_rows()>0)
                    {
                        echo 'trung';
                    }
                    else
                    {
                        echo 'khongtrung';
                    }
                }
            }
        }
	}

	public function checkRwurl()
	{
		$str=$_POST['key'];
        $str=trim(stripslashes($str));
        $separator = 'dash';
        $lowercase = FALSE;
        if ($separator == 'dash')
        {
            $search     = '_';
            $replace    = '-';
        }
        else
        {
            $search     = '-';
            $replace    = '_';
        }

        $trans = array(
                        '&\#\d+?;'              => '',
                        '&\S+?;'                => '',
                        '\s+'                   => $replace,
                        
                        "à"                                    => 'a',
                        "á"                                    => 'a',
                        "ả"                                    => 'a', 
                        "ã"                                    => 'a',
                        "ạ"                                    => 'a',
                        
                        "â"                                    => 'a',
                        "ấ"                                    => 'a',
                        "ầ"                                    => 'a',
                        "ẩ"                                    => 'a',
                        "ẫ"                                    => 'a',
                        "ậ"                                    => 'a',
                        
                        "ă"                                    => 'a',
                        "ằ"                                    => 'a',
                        "ắ"                                    => 'a',
                        "ẳ"                                    => 'a',
                        "ẵ"                                    => 'a',
                        "ặ"                                    => 'a',
                        
                        "ò"                                    => 'o',
                        "ó"                                    => 'o',
                        "ỏ"                                    => 'o',
                        "õ"                                    => 'o',
                        "ọ"                                    => 'o',
                        
                        "ơ"                                    => 'o',
                        "ờ"                                    => 'o',
                        "ớ"                                    => 'o',
                        "ở"                                    => 'o',
                        "ỡ"                                    => 'o',
                        "ợ"                                    => 'o',
                        
                        "ô"                                    => 'o',
                        "ồ"                                    => 'o',
                        "ố"                                    => 'o',
                        "ổ"                                    => 'o',
                        "ỗ"                                    => 'o',
                        "ộ"                                    => 'o',
                        
                        "è"                                    => 'e',                      
                        "é"                                    => 'e',
                        "ẻ"                                    => 'e',
                        "ẽ"                                    => 'e',
                        "ẹ"                                    => 'e',
                        
                        "ê"                                    => 'e',
                        "ề"                                    => 'e',
                        "ế"                                    => 'e',
                        "ể"                                    => 'e',
                        "ễ"                                    => 'e',
                        "ệ"                                    => 'e',
                        
                        "ù"                                    => 'u',                  
                        "ú"                                    => 'u',
                        "ủ"                                    => 'u',
                        "ũ"                                    => 'u',
                        "ụ"                                    => 'u',
                        
                        "ư"                                    => 'u',
                        "ừ"                                    => 'u',                  
                        "ứ"                                    => 'u',
                        "ử"                                    => 'u',
                        "ữ"                                    => 'u',
                        "ự"                                    => 'u',
                        
                        "ì"                                    => 'i',
                        "í"                                    => 'i',
                        "ỉ"                                    => 'i',
                        "ĩ"                                    => 'i',
                        "ị"                                    => 'i',
                        
                        "ỳ"                                    => 'y',
                        "ý"                                    => 'y',
                        "ỷ"                                    => 'y',
                        "ỹ"                                    => 'y',
                        "ỵ"                                    => 'y',
                        
                        "đ"                                    => 'd',
                        "Đ"                                    => 'd',
                        

                        "À"                                    => 'a',
                        "Á"                                    => 'a',
                        "Ả"                                    => 'a', 
                        "Ã"                                    => 'a',
                        "Ạ"                                    => 'a',
                        
                        "Â"                                    => 'a',
                        "Ầ"                                    => 'a',
                        "Ấ"                                    => 'a',
                        "Ẩ"                                    => 'a',
                        "Ẫ"                                    => 'a',
                        "Ậ"                                    => 'a',
                        
                        "Ă"                                    => 'a',
                        "Ằ"                                    => 'a',
                        "Ắ"                                    => 'a',
                        "Ẳ"                                    => 'a',
                        "Ẵ"                                    => 'a',
                        "Ặ"                                    => 'a',
                        
                        "Ọ"                                    => 'o',
                        "Ò"                                    => 'o',
                        "Ó"                                    => 'o',
                        "Ỏ"                                    => 'o',
                        "Õ"                                    => 'o',
                        
                        "Ơ"                                    => 'o',
                        "Ờ"                                    => 'o',
                        "Ớ"                                    => 'o',
                        "Ở"                                    => 'o',
                        "Ỡ"                                    => 'o',
                        "Ợ"                                    => 'o',
                        
                        "Ô"                                    => 'o',
                        "Ồ"                                    => 'o',
                        "Ố"                                    => 'o',
                        "Ổ"                                    => 'o',
                        "Ỗ"                                    => 'o',
                        "Ộ"                                    => 'o',
                        
                        "È"                                    => 'e',                      
                        "É"                                    => 'e',
                        "Ẻ"                                    => 'e',
                        "Ẽ"                                    => 'e',
                        "Ẹ"                                    => 'e',
                        
                        "Ê"                                    => 'e',
                        "Ề"                                    => 'e',
                        "Ế"                                    => 'e',
                        "Ể"                                    => 'e',
                        "Ễ"                                    => 'e',
                        "Ệ"                                    => 'e',
                        
                        "Ù"                                    => 'u',                  
                        "Ú"                                    => 'u',
                        "Ủ"                                    => 'u',
                        "Ũ"                                    => 'u',
                        "Ụ"                                    => 'u',
                        
                        "Ư"                                    => 'u',
                        "Ừ"                                    => 'u',                  
                        "Ứ"                                    => 'u',
                        "Ử"                                    => 'u',
                        "Ữ"                                    => 'u',
                        "Ự"                                    => 'u',
                        
                        "Ì"                                    => 'i',
                        "Í"                                    => 'i',
                        "Ỉ"                                    => 'i',
                        "Ĩ"                                    => 'i',
                        "Ị"                                    => 'i',
                        
                        "Ỳ"                                    => 'y',
                        "Ý"                                    => 'y',
                        "Ỷ"                                    => 'y',
                        "Ỹ"                                    => 'y',
                        "Ỵ"                                    => 'y',
                        
                        "đ"                                    => 'd',
                        "Đ"                                    => 'd',
                        
                        '[^a-z0-9\-\._]'        => '',
                        $replace.'+'            => $replace,
                        $replace.'$'            => $replace,
                        '^'.$replace            => $replace,
                        '\.+$'                  => ''
                      );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);

        }

        //if ($lowercase === TRUE)
        //{
            $str = strtolower($str);
        //}
        
        echo  trim(stripslashes($str));    
	}

    public function backUrl()
    {
        echo "<script>window.location.href='javascript:history.back(-1);'</script>";
    }

    public function checkRoleViewContent($table_name)
    {        
        $this->db->where('username', $_SESSION['uid']);
        $useroleadd_tact = $this->db->get('tblrole');       
        $demadd = 0;
        foreach ($useroleadd_tact->result() as $useroleadd_tact) {            
            if ($table_name == $useroleadd_tact->table_name) {
                $ok = 1;
                break;
            }
        }        
        if ($ok <> 1) {
            $this->backUrl();
        }
    }

    public function checkRoleAccess($table_name,$value)
    {
        $this->db->where('username', $_SESSION['uid']);
        $useroleadd_tact = $this->db->get('tblrole');
        $demadd = 0;
        foreach ($useroleadd_tact->result() as $useroleadd_tact) {
            if ($table_name == $useroleadd_tact->table_name) {
                $tachaddaccess = explode('-', $useroleadd_tact->access);
                foreach ($tachaddaccess as $tachaddaccess) {
                    if ($tachaddaccess == $value) {
                        $ok = 1;
                        break;
                    }
                }
            }
        }
        if ($ok <> 1) {
            $this->backUrl();
        }
    }

	//check adminhp session
	public function checkadminSession()
	{
		if(isset($_SESSION['username'])){		  
		}
        else{
		  redirect('adminhp/login');
        } 
	}

	public function declareTables()
	{
		$this->loadConfig();
		$data['row_per_page']=$this->config->item('row_per_page');	
		$data['table_list']=$this->config->item('table_list');
		$data['labels']=$this->config->item('table_field_label');				
		return $data;						
	}

	public function viewContentTables()
	{
		$this->loadConfig();
		$data['row_per_page']=$this->config->item('row_per_page');	
		$data['table_list']=$this->config->item('table_list');
		$data['labels']=$this->config->item('table_field_view_content');				
		return $data;						
	}

    public function loadConfig()
    {
        $this->config->load('config');    
    }

	public function displayTemplate($data)
	{
		$this->load->view('layouts/template',$data);
	}    
	public function displayTemplateLogin()
	{
		$this->load->view('layouts/login');
	}  
}