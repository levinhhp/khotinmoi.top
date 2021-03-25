<?php 
class Demo_model extends Model
{
	function Demo_model()
	{
		parent::Model();
	}
	function get()
	{
		echo 'This is my website welcome to visited ! ';	
	}
	function csdlthoitrangnu()
	{
		$sql = $this->db->get('tbthoitrangnu');	
		return $sql->result();
	}
	function csdlthoitrangnu_limited($limit,$start_row)
	{
		$this->db->limit($limit,$start_row);
		$sql=$this->db->get('tbthoitrangnu');
		return $sql->result();
	}
	function deletecsdlthoitrangnu($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tbthoitrangnu');
	}
	function getinfothoitrangnu($id)
	{
		$this->db->where('id',$id);
		$sql = $this->db->get('tbthoitrangnu');	
		return $sql->row();
	}
	function editcsdlthoitrangnu()
	{
	$data = array(
		'gia'	=>$this->input->post('txtgia'),
		'model'	=>$this->input->post('txtmodel'),
		'trangthai'	=>$this->input->post('txttrangthai'),
		'danhgia'	=>$this->input->post('txtdanhgia')
		);
		$this->db->where('id',$this->input->post('txtid'));
		$this->db->update('tbthoitrangnu', $data);	
	}
	function addthoitrangnu()
	{
		$data = array(
			'gia'	=>$this->input->post('txtgia'),
			'model'	=>$this->input->post('txtmodel'),
			'trangthai'	=>$this->input->post('txttrangthai'),
			'danhgia'	=>$this->input->post('txtdanhgia')
		);
		$this->db->insert('tbthoitrangnu',$data);	
	}
	function phukien()
	{
		$sql = $this->db->get('tbphukien');	
		return $sql->result();
	}
	function csdlphukien()
	{
		$config['upload_path']='./upload/';
		$config['allowed_types']='gif|jpg|png|bmp|jpeg';
		$config['max_size']='1000000';
		$config['max_width']='0';
		$config['max_height']='0';
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('anh'))
		{
			$name_img='assets/bg-co.png';
		}
		else
		{
			$image_data=$this->upload->data();
			$name_img='upload/'.$image_data['file_name'];
		}
		$data = array(
			'tensp'	=> $this->input->post('txttensp'),
			'giasp'	=> $this->input->post('txtgiasp'),
			'nhasx'	=> $this->input->post('nhasx'),
			'danhgia'	=> $this->input->post('txtdanhgia'),
			'trangthai'	=> $this->input->post('txttrangthai'),
			'anh'	=> $name_img
		);
		$this->db->insert('tbphukien', $data);	
	}
	function deletephukien($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tbphukien');
	}
	function editcsdlphukien($id)
	{
		$this->db->where('id',$id);
		$sql=$this->db->get('tbphukien');	
		return $sql->row();
	}
	function ecsdlphukien()
	{
		$config['upload_path']='./upload/';
		$config['allowed_types']='gif|jpg|png|bmp|jpeg';
		$config['max_size']='1000000';
		$config['max_width']='0';
		$config['max_height']='0';
		$this->load->library('upload',$config);
		if(!$this->upload->do_upload('anh'))
		{
			$img=$this->input->post('imgold');
		}
		else
		{
			$image_data=$this->upload->data();
			$img='upload/'.$image_data['file_name'];
		}
		$data = array(
			'tensp' =>$this->input->post('txttensp'),
			'giasp' =>$this->input->post('txtgiasp'),
			'nhasx' =>$this->input->post('nhasx'),
			'danhgia' =>$this->input->post('txtdanhgia'),
			'trangthai' =>$this->input->post('txttrangthai'),
			'anh' =>$img
			
		);
		$this->db->where('id',$this->input->post('txtid'));
		$this->db->update('tbphukien', $data);	
	}

	function csdllogin($usernam,$password)
	{
		$this->db->where('username', $usernam);
		$this->db->where('password',md5($password));
		$sql = $this->db->get('login');
		return $sql->row();
	}
	function csdldangnhap()
	{
		$ngay=$this->input->post('ngay');
		$thang=$this->input->post('thang');
		$nam=$this->input->post('nam');
		$ngaysinh=$nam.'/'.$thang.'/'.$ngay;
		$data=array(
			'username'	=>$this->input->post('txthoten'),
			'password '	=>md5($this->input->post('txtmatkhau')),
			'gioitinh '	=>$this->input->post('r_gioitinh'),
			'diachi'	=>$this->input->post('txtdiachi'),
			'email'	=>$this->input->post('txtemail'),
			'ngaysinh'	=>$ngaysinh
		);
		$this->db->insert('login', $data);
	}
	function checkusername($usernane)
	{
		$this->db->where('username', $usernane);
		$sql=$this->db->get('login');
		if($sql->num_rows==1)
		{
			return TRUE;
		}
	}
	function checkemail($email)
	{
		$this->db->where('email',$email);
		$sql=$this->db->get('login');
		if($sql->num_rows==1)	
		{
			return TRUE;
		}
	}
}

?>