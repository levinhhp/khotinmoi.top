<?php
class Site_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }    

    function gettablename($table_name,$data_select,$id)
    {
        if($id!=''){
            $this->db->where('id',$id);
        }  
        if($data_select!=''){      
            $this->db->select($data_select);
        }
        $sql=$this->db->get($table_name);
        return $sql->row();
    }  
    public function getdanhmuc2($id)
    {
        $this->db->where('parent_id', $id);
        $sql = $this->db->get('tblarticle_category');
        return $sql->result();
    }
    public function getListPost() {    
        if(isset($_SESSION['username_frontend'])){
            $this->db->where('author',$_SESSION['username_frontend']);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get('tblarticle');
        return $query;
    }
    public function getListPostLimit($limit, $start) { 
        if(isset($_SESSION['username_frontend'])){
            $this->db->where('author',$_SESSION['username_frontend']);
        }
        $this->db->order_by('id','desc');     
        $this->db->limit($limit, $start);        
        $query = $this->db->get('tblarticle');
        return $query;
    }
    public function validate($user, $pass)
    {
        $this->db->where('status',1);        
        $this->db->where('username', $user);
        $this->db->where('password', md5($pass));
        $this->db->select('id,username,password,status');            
        $query = $this->db->get('tbluser');        
        return $query;
    }
    public function checkFacebook($username){	        
        $this->db->where('username',$username);
        $sql = $this->db->get('tbluser');
		return $sql;
	}
    public function createUpdateTable($table_name,$data,$id)
    {
        if($id==''){
            $this->db->insert($table_name,$data,'');
        }
        else{
            $this->db->where('id',$id);
            $this->db->insert($table_name,$data,$id);
        }
    }
    public function sliderRamdom($category,$id='')
    {
        $data_ads_slider = [];
        $data_same_slider = [];
        $data_random_slider = [];
        $category_ads_slider = $this->gettablename_all('tblcategory_ads','id,category,number_post,number_slider,number_ads,number_post_same,status',1,'category',$category);
        if($category_ads_slider->num_rows()>0){
            $limit_slider = $category_ads_slider->row()->number_slider;
            $limie_same_slider = $category_ads_slider->row()->number_post_same;
            $limit_ramdom_slider = ($limit_slider - $limie_same_slider);
        }else{
            $limit_slider = '';
            $limie_same_slider = 3;
            $limit_ramdom_slider = 6;
        }           
        $ads_end_slider=$this->gettablename_all('tblads','id,ordernum,status',$limit_slider,'category',$category);              
        foreach($ads_end_slider->result() as $item_and_end_slider){            
            $data_ads_slider[] = $item_and_end_slider->id.'-ads';
        }            
        $new_same_slider = $this->gettablename_all('tblarticle','id,ordernum,status',$limie_same_slider,'category',$category);
        foreach($new_same_slider->result() as $item_same_slider){
            //if($item_same_slider->id!=$id){
                $data_same_slider[] = $item_same_slider->id.'-tt';    
            //}
        }            
        $this->db->where('status',1);
        $this->db->where('id !=',380);
        $this->db->where('id !=',381);
        $this->db->where('id !=',382);
        $this->db->order_by('id','random');
        $this->db->limit($limit_ramdom_slider);
        $sqlrandom_slider = $this->db->get("tblarticle");
        foreach($sqlrandom_slider->result() as $item_tin_random_slider){
            //if($item_tin_random_slider->id!=$id){
                $data_random_slider[] = $item_tin_random_slider->id.'-tt';
            //}
        }          
        $tin_1_slider = array_merge($data_ads_slider,$data_same_slider,$data_random_slider);               
        $tin_ads_slider =  twodshuffle($tin_1_slider);  
        return $tin_ads_slider;                  
    }
    public function postRamdomHome(){
        $limit_total = 4;
        $data_ads_home = []; 
        $data_random_home = []; 
        $ads_end_home=$this->gettablename_all('tblads','id,ordernum,status','','home',1); 
        $total_ads_home = $ads_end_home->num_rows();          
        $limit_ramdom_home = $limit_total - $total_ads_home;        
        if($limit_ramdom_home>0){
            $limit_ramdom_home_to = $limit_ramdom_home;
        }else{
            $limit_ramdom_home_to = 0;
        }
        foreach($ads_end_home->result() as $item_ads_end_h){
            $data_ads_home[] =  $item_ads_end_h->id.'-ads';
        }
        if($total_ads_home<3){
            $this->db->where('status',1);
            $this->db->where('id !=',380);
            $this->db->where('id !=',381);
            $this->db->where('id !=',382);
            $this->db->order_by('id','random');
            $this->db->limit($limit_ramdom_home);
            $sqlrandom_home = $this->db->get("tblarticle");
            foreach($sqlrandom_home->result() as $item_tin_random_home){            
                $data_random_home[] = $item_tin_random_home->id.'-tt';            
            }  
        }  
        $tin_1_home = array_merge($data_ads_home,$data_random_home);                        
        $tin_ads_home =  twodshuffle($tin_1_home);          
        return $tin_ads_home;        
    }
    public function postNewsAds($category,$limit_all='9'){        
        $data_ads_new = [];        
        $data_new = [];
        $category_ads_new = $this->gettablename_all('tblcategory_ads','id,category,number_post,number_ads,number_post_same,status','','category',$category);
        if($category_ads_new->num_rows()>0){            
            $limit = $category_ads_new->row()->number_ads;            
            $limit_news_post = ($limit_all - $limit);
        }else{
            $limit = '';
            $limie_same = 4;
            $limit_ramdom_post = 4;
            $limit_news_post = 5;
        }                 
        $ads_end=$this->gettablename_all('tblads','id,ordernum,status',$limit,'category',$category);              
        foreach($ads_end->result() as $item_and_end){            
            $data_ads_new[] = $item_and_end->id.'-ads';
        }                               
        $this->db->where('status',1);   
        $this->db->where('id !=',380);
        $this->db->where('id !=',381);
        $this->db->where('id !=',382);  
        $this->db->order_by('id','desc');   
        $this->db->limit($limit_news_post);
        $sqlnew = $this->db->get("tblarticle");
        foreach($sqlnew->result() as $item_tin_new){
            //if($item_and_end!=$id){
                $data_new[] = $item_tin_new->id.'-tt';
            //}
        }                                     
        $tin_1_new = array_merge($data_ads_new,$data_new);                      
        $tin_ads_new =  twodshuffle($tin_1_new);          
        return $tin_ads_new;                      
    }
    public function postRamdom($category,$id=''){           
        $data_ads = [];
        $data_same = [];
        $data_random = [];
        $category_ads = $this->gettablename_all('tblcategory_ads','id,category,number_post,number_ads,number_post_same,status',1,'category',$category);
        if($category_ads->num_rows()>0){
            $limit = $category_ads->row()->number_ads;
            $limie_same = $category_ads->row()->number_post_same;
            $limit_ramdom_post = $category_ads->row()->number_post - ($limit + $limie_same);
        }else{
            $limit = '';
            $limie_same = 4;
            $limit_ramdom_post = 4;
        }           
        $ads_end=$this->gettablename_all('tblads','id,ordernum,status',$limit,'category',$category);              

        foreach($ads_end->result() as $item_and_end){            
            $data_ads[] = $item_and_end->id.'-ads';
        }                  
        $new_same = $this->gettablename_all('tblarticle','id,ordernum,status',$limie_same,'category',$category);
        foreach($new_same->result() as $item_same){
            //if($item_and_end!=$id){
                $data_same[] = $item_same->id.'-tt';    
            //}
        }   
        if($new_same->num_rows()<$limie_same){
            $limit_ram = ($limie_same - $new_same->num_rows()) + $limit_ramdom_post;
        }else{
            if($ads_end->num_rows() < $limit){            
                $limit_ram = $limit_ramdom_post + ($limit - $ads_end->num_rows());
            }else{
                $limit_ram = $limit_ramdom_post;
            }
        }     
        if($limit_ram >0){
            $this->db->where('status',1);
            $this->db->where('id !=',380);
            $this->db->where('id !=',381);
            $this->db->where('id !=',382);
            $this->db->order_by('id','random');        
            $this->db->limit($limit_ram);               
            $sqlrandom = $this->db->get("tblarticle");
            foreach($sqlrandom->result() as $item_tin_random){
                //if($item_and_end!=$id){
                    $data_random[] = $item_tin_random->id.'-tt';
                //}
            }     
        }                              
        $tin_1 = array_merge($data_ads,$data_same,$data_random);          
        $tin_ads =  twodshuffle($tin_1);  
        return $tin_ads;                  
    }
    public function getTableParent($parent_id,$table_name,$dataall_selct,$limit,$data_key,$data_value)
    {
        $this->db->where('status',1);  
        $this->db->where('parent_id',$parent_id);      
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
    function gettablename_all($table_name,$dataall_selct,$limit,$data_key,$data_value)
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
    function getnew($id)
	{
		$this->db->where('status',1);
		$this->db->where('id',$id);
		$sql=$this->db->get('tblarticle');
		return $sql;
    }
    public function getSearchTable($table_name,$name,$value){
        $this->db->where('status',1);
        $ten=$this->input->post($value);
        if($ten!=''){                                        
            $this->db->like($name,$ten);                                  
        }
        $this->db->order_by('ordernum','desc');
        $this->db->order_by('id','desc');            
        $search = $this->db->get($table_name);
        return $search;
    }
    public function getSearchTableLimited($table_name,$name,$value,$limit,$start_row){
        $this->db->where('status',1);        
        $ten=$this->input->post($value);
        if($ten!=''){                            
            $this->db->like($name,$ten);                                   
        }       
        $this->db->order_by('ordernum','desc');
        $this->db->order_by('id','desc');    
        $this->db->limit($limit,$start_row);
        $search = $this->db->get($table_name);
        return $search;    
    }

    public function getTagNew($table_name,$id)
	{
		$this->db->where('id',$id);
		$sql=$this->db->get($table_name);
		return $sql->row();
	}

    public function getnewByTagId($table_name1,$id,$categorie_type)
	{
		$this->db->where('idtag',$id);
		$this->db->where('categories',$categorie_type);
		$query=$this->db->get($table_name1);
		return $query;
	}	

    public function getnewByTagId_limited($table_name1,$id,$categorie_type,$limit,$start_row)
	{
		$this->db->where('idtag',$id);
		$this->db->where('categories',$categorie_type);
		$this->db->limit($limit,$start_row);
		$query=$this->db->get($table_name1);
		return $query;
	}

    public function getTableNameAll($table_name,$name,$value,$name2)
    {
        $this->db->where('status',1);
        $this->db->where($name,$value);
        $this->db->order_by('ordernum','desc');
        $this->db->order_by('id','desc');
        $query = $this->db->get($table_name);
        if($query->num_rows()>0)
        {
            return $query;
        }		
        else
        {
            $this->db->where('status',1);
            $this->db->where($name2,$value);
            $this->db->order_by('ordernum','desc');
            $this->db->order_by('id','desc');
            $query = $this->db->get($table_name);   
            return $query; 
        }
    }
    public function getTableNameAll_limited($table_name,$name,$value,$name2,$limit,$start_row)
	{
	   $this->db->where('status',1);
       $this->db->where($name,$value);
       $this->db->order_by('ordernum','desc');
       $this->db->order_by('id','desc');
       $this->db->limit($limit,$start_row);
       $query = $this->db->get($table_name);
       if($query->num_rows()>0)
       {
            return $query;
       }
       else
       {
            $this->db->where('status',1);
            $this->db->where($name2,$value);
            $this->db->order_by('ordernum','desc');
            $this->db->order_by('id','desc');
            $this->db->limit($limit,$start_row);
            $query = $this->db->get($table_name); 
            return $query;    
       }
	  
    }
    
    public function checkPassOld($password){
        $this->db->where('password',md5($password));
        $sql = $this->db->get('tbluser');
        return $sql;
    }
}
?>