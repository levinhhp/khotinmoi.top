<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
for($i=0;$i<$countfiles;$i++){
    if(!empty($_FILES['files']['name'][$i])){
        // Define new $_FILES array - $_FILES['file']
        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
          $_FILES['file']['type'] = $_FILES['files']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['files']['error'][$i];
        $_FILES['file']['size'] = $_FILES['files']['size'][$i];
        // Set preference
        $config['upload_path'] = './uploads/'; 
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['max_size'] = '5000'; // max_size in kb
        $config['file_name'] = $_FILES['files']['name'][$i];
        //Load upload library
        $this->load->library('upload',$config); 
        $arr = array('msg' => 'something went wrong', 'success' => false);
        // File upload
        if($this->upload->do_upload('file')){
            $data = $this->upload->data(); 	
            $insert['post_id'] = $lastest_id;								
            $insert['name'] = $data['file_name'];
            $insert['loai']	= 2;
               $this->db->insert('tblimages',$insert);
        }
    }
}                        