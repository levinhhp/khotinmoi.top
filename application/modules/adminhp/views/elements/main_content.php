<?php
	if(!(isset($action))){
		$this->load->view('home');
	}elseif($action=='add'){
		$this->load->view('addcontent');
	}elseif($action=='chang_password'){
		$this->load->view('chang_password');
	}elseif($action=='view'){
		$this->load->view('viewcontent');
	}elseif($action=='view_today'){
		$this->load->view('view_today');
	}elseif($action =='view_check'){
		$this->load->view('view_check');
	}elseif($action=='edit'){
		$this->load->view('addcontent');	
	}elseif($action=='editsuccess'){
		$this->load->view('edit_wait_success');
	}elseif($action == 'thongtincanhan'){
		$this->load->view('thongtincanhan');
	}elseif($action=='statistic'){
		$this->load->view('statistic');
	}
?>