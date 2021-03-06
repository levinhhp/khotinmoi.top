<?php
class Demo extends Controller
{
	function Demo()
	{
		parent::Controller();
		$this->load->model('Demo_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	function index()
	{
		$this->load->view('include/template');
	}
	function getview()
	{
		$data['ad'] = $this->Demo_model->get();
		$this->load->view('Demo_view',$data);
	}
	function getcsdlthoitrangnu()
	{
		$query=$this->Demo_model->csdlthoitrangnu();
		$total_rows=count($query);
		$start_row=$this->uri->segment(3);
		$per_page=4;
		$config['base_url']=site_url('Demo/getcsdlthoitrangnu/');
		$config['total_rows']=$total_rows;
		$config['uri_segment']=3;
		$config['per_page']=$per_page;
		$config['next_link']='Next';		
		$config['num_links']=4;
		$config['first_link']='First';
		$config['last_link']='Last';
		$this->pagination->initialize($config);	
		$data['query'] = $this->Demo_model->csdlthoitrangnu_limited($per_page,$start_row);	
		$data['pagination']=$this->pagination->create_links();
		$data['main_content'] ='thoitrangnu_view';		
		$this->load->view('include/template',$data);	
	}

	function dodeletecsdlthoitrangnu($id)
	{
		$this->Demo_model->deletecsdlthoitrangnu($id);
		redirect ('Demo/getcsdlthoitrangnu');
	}
	function editthoitrangnu($id)
	{
		$data['info'] = $this->Demo_model->getinfothoitrangnu($id);
		$data['main_content'] = 'editthoitrangnu_view';
		$this->load->view('include/template', $data);	
	}
	function doeditthoitrangnu()
	{
		$this->form_validation->set_rules('txtgia','gia san pham','required');
		$this->form_validation->set_rules('txttrangthai','trang thai san pham','required');
		$this->form_validation->set_rules('txtmodel','model san pham','required');
		$this->form_validation->set_rules('txtdanhgia','danh gia san pham','required');
		$this->form_validation->set_message('required','%s khong de trong');
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			$data['info'] = $this->Demo_model->getinfothoitrangnu($this->input->post('txtid'));
			$this->load->view('editthoitrangnu_view', $data);	
		}	
		else
		{
			$this->Demo_model->editcsdlthoitrangnu();
			$data['info'] = $this->Demo_model->getinfothoitrangnu($this->input->post('txtid'));	
			$data['mgs'] = '<span style="color:red">ban da sua thanh cong</span>';
			$this->load->view('editthoitrangnu_view',$data);
		}
	}
	
	function addcsdlthoitrangnu()
	{
		$data['main_content'] = 'thoitrangnu_add';
		$this->load->view('include/template', $data);	
	}
	function doaddcsdlthoitrangnu()
	{
		$this->form_validation->set_rules('txtgia',' <span style="color:red">gia san pham </span>','required');
		$this->form_validation->set_rules('txttrangthai','<span style="color:red">trang thai san pham</span>','required');
		$this->form_validation->set_rules('txtmodel','<span style="color:red">model san pham</span>','required');
		$this->form_validation->set_rules('txtdanhgia','<span style="color:red">danh gia san pham</span>','required');
		$this->form_validation->set_message('required','%s khong de trong');
		if($this->form_validation->run()==FALSE)
		{
			$data['error'] =validation_errors();
			$this->load->view('thoitrangnu_add',$data);	
		}
		else
		{
			$this->Demo_model->addthoitrangnu();
			$data['thongbao'] = 'b???n ???? th??m th??nh c??ng';
			$this->load->view('thoitrangnu_add',$data);	
		}
	}
	function viewphukien()
	{
		$data['query'] = $this->Demo_model->phukien();
		$this->load->view('phukien_view',$data);	
	}
	function addphukien()
	{
		$this->load->view('addphukien_view');
	}
	function doaddphukien()
	{
		$this->form_validation->set_rules('txttensp','t??n s???n ph???m','required');
		$this->form_validation->set_rules('txtgiasp','gi?? s???n ph???m','required');
		
		$this->form_validation->set_rules('txtdanhgia','????nh gi?? nh?? s???n xu???t','required');
		$this->form_validation->set_rules('txttrangthai','tr???ng th??i s???n ph???m','required');
		
		$this->form_validation->set_message('required', '%s kh??ng ????? tr???ng');
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			$this->load->view('addphukien_view', $data);
		}
		else
		{
			$this->Demo_model->csdlphukien();
			$data['msg']='ban da them thanh cong';
			$this->load->view('addphukien_view', $data);	
		}
	}
	function dodeletephukien($id)
	{
		$this->Demo_model->deletephukien($id);
		redirect ('Demo/viewphukien');	
	}
	function editphukien($id)
	{		
		$data['main_content'] = 'editphukien_view';
		$data['info'] = $this->Demo_model->editcsdlphukien($id);
		$this->load->view('include/template',$data);
	}
	function doeditphukien()
	{
		$this->form_validation->set_rules('txttensp','t??n s???n ph???m','required');
		$this->form_validation->set_rules('txtgiasp','gi?? s???n ph???m','required');
		$this->form_validation->set_rules('nhasx','nh?? s???n xu???t','required');
		$this->form_validation->set_rules('txtdanhgia','????nh gi?? s???n ph???m','required');
		$this->form_validation->set_rules('txttrangthai','tr???ng th??i s???n ph???m','required');		
		$this->form_validation->set_message('required','%s kh??ng b??? tr???ng');
		if($this->form_validation->run() == FALSE)
		{
			$data['info'] = $this->Demo_model->editcsdlphukien($this->input->post('txtid'));
			$data['msg'] = validation_errors();
			$this->load->view('editphukien_view', $data);	
		}
		else
		{
			$this->Demo_model->ecsdlphukien();
			$data['info'] = $this->Demo_model->editcsdlphukien($this->input->post('txtid'));
			$data['thongbao'] ='b???n ???? s???a th??nh c??ng r???i nh??';
			$this->load->view('editphukien_view', $data);
		}
	}
	function login()
	{
		$data['main_content'] ='login';
		$this->load->view('include/template', $data);	
	}
	function dologin()
	{

		$username = $this->input->post('txtuser');
		$password = $this->input->post('txtpass');
		$t = $this->Demo_model->csdllogin($username,$password);
		if(count($t)>0)
		{
			$this->session->set_userdata(array('admin'=>$username));
			$this->load->view('dangnhapthanhcong');
		}
		else
		{
			redirect ('Demo/login');
		}
		
	}
	function dangnhap()
	{
		$data['main_content'] = 'dangnhap';
		$this->load->view('include/template', $data);
	}
	function dodangnhap()
	{
		$this->form_validation->set_rules('txthoten','ho ten','required');
		$this->form_validation->set_rules('txtmatkhau','mat khau','required');
		$this->form_validation->set_rules('txthoten','ho ten','required');
		$this->form_validation->set_rules('txtdiachi','dia chi','required');
		$this->form_validation->set_rules('txtemail','email','required');
		//$this->form_validation->set_rules('txtngaysinh','ngay sinh','required');
		$this->form_validation->set_message('required','%s khong de trong');
		if($this->form_validation->run() == FALSE)
		{
			$data['error']= validation_errors();
			$this->load->view('dangnhap',$data);
		}
		else
		{
			if($this->Demo_model->checkusername($this->input->post('txthoten'))==true)
			{
				$data['smg']='ban da dang ki trung ten';
				$this->load->view('dangnhap',$data);
				return;
			}
			elseif($this->Demo_model->checkemail($this->input->post('txtemail'))==true)
			{
				$data['smg']='email da trung';
				$this->load->view('dangnhap',$data);
				return;	
			}
			
			$this->Demo_model->csdldangnhap();
			$data['smg'] ='ban da dang ki thanh cong';
			$this->load->view('dangnhap',$data);	
		}
	}
	function logout()
	{
		$this->session->unset_userdata('admin');
		redirect('Demo/dangnhap');
	}
}

?>