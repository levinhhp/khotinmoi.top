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

    function getTableNameAll($table_name,$name,$value)
    {
        $this->db->where('status',1);
        $this->db->where($name,$value);
        $this->db->order_by('ordernum','desc');
        $this->db->order_by('id','desc');
		$query = $this->db->get($table_name);
		return $query;		
    }
    function getTableNameAll_limited($table_name,$name,$value,$limit,$start_row)
	{
	   $this->db->where('status',1);
       $this->db->where($name,$value);
       $this->db->order_by('ordernum','desc');
       $this->db->order_by('id','desc');
       $this->db->limit($limit,$start_row);
       $query = $this->db->get($table_name);
	   return $query;
	  
	}
}
?>