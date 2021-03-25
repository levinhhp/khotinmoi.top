<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adminhp extends BaseController
{
    public function deleteImage($id)
    {
        $this->deleteTableImage('tblimages', $id);
    }

    public function checkurl()
    {
        $this->checkadminSession();
        $this->checkAlias();
    }    
    public function ScanPostContent($table_name,$id){
        $this->load->helper('simple_html'); 
        $this->checkadminSession();        
        $this->db->where('id',$id);
        $sql_show_view = $this->db->get($table_name);
        if($sql_show_view->num_rows()>0){                          
            $this->db->where('id',$sql_show_view->row()->setting_scan_id);
            $setting_scan = $this->db->get('tblsetting_scan');
            if($sql_show_view->row()->dom_status == 1){                    
                $html_e = file_get_html($sql_show_view->row()->link); 				
                $post_title_e =  $html_e->find($setting_scan->row()->dom_post_title,0)->plaintext;                
                $post_description_e = $html_e->find($setting_scan->row()->dom_post_description,0)->plaintext;
                $post_content_e = $html_e->find($setting_scan->row()->dom_post_content,0)->outertext; 
                $this->db->where('title',$post_title_e);              
                $sql_check_title_e = $this->db->get('tblarticle');
                if($sql_check_title_e->num_rows()>0){
                }else{
                    $data_up = [
                        'title' => strip_tags($post_title_e),
                        'alias' => LocDau(strip_tags($post_title_e)).'.html',
                        'category' => $sql_show_view->row()->category,
                        'category_sub' => $sql_show_view->row()->category_sub,
                        'description' => $post_description_e,
                        'content' => $post_content_e,
                        'date_day' => date('Y-m-d H:i'),
                        'author' => $_SESSION['username'],                            
                        'status' => 0
                    ];     
                    $this->db->insert('tblarticle',$data_up);      
                }
            }elseif($sql_show_view->row()->dom_status == 2){                                             
                $link = $sql_show_view->row()->link;                                
                $html = file_get_html($link);        
                $data_up = [];
                foreach($html->find($setting_scan->row()->dom_category) as $element){
                    if($setting_scan->row()->is_href == 1){
                        $explode_link = explode('//',$sql_show_view->row()->link);
                        $http = $explode_link[0].'//';
                        $http_con = explode('/',$explode_link[1]);
                        $link = $http.$http_con[0];  
                        $link_sub = $link.'/'.$element->href;
                    }else{
                        $link_sub = $element->href;
                    }                    
                    $html_sub = file_get_html($link_sub);
                    $post_title =  $html_sub->find($setting_scan->row()->dom_post_title,0)->plaintext;
                    $post_description = $html_sub->find($setting_scan->row()->dom_post_description,0)->plaintext;
                    $post_content = $html_sub->find($setting_scan->row()->dom_post_content,0)->outertext;     
                    $this->db->where('title',$post_title);              
                    $sql_check_title = $this->db->get('tblarticle');
                    if($sql_check_title->num_rows()>0){
                    }else{
                        $data_up = [
                            'title' => $post_title,
                            'alias' => LocDau($post_title).'.html',
                            'category' => $sql_show_view->row()->category,
                            'category_sub' => $sql_show_view->row()->category_sub,
                            'description' => $post_description,
                            'content' => $post_content,
                            'date_day' => date('Y-m-d H:i'),
                            'author' => $_SESSION['username'],                            
                            'status' => 0
                        ];     
                        $this->db->insert('tblarticle',$data_up);  
                    }                                 
                }                  
            }  
            $data_send = [
                'is_send'=>1
            ];  
            $this->db->where('id',$sql_show_view->row()->id);
            $this->db->update('tblscan_post',$data_send);
        }        
        redirect(site_url('adminhp/viewContent/'.$table_name));
    }    
    public function export_artive(){
        $this->checkadminSession();
        $this->load->library("excel");
        $object = new PHPExcel();    
        $object->setActiveSheetIndex(0);
        $table_columns = array("Ngày đăng", "Mã", "Lượt Xem", "Category", "Tiêu đề","Người đăng");
        $column = 0;
        foreach($table_columns as $field){
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $artive_data = $this->admin_model->fetch_data();
        $excel_row = 2;
        foreach($artive_data as $row)
        {
            $this->db->where('id',$row->article_id);
            $sql_post = $this->db->get('tblarticle');
            if($sql_post->num_rows()>0){
                $article_id = $sql_post->row()->id;
                $article_title = $sql_post->row()->title;
                $article_author = $sql_post->row()->author;
            }else{
                $article_id = '';
                $article_title = '';
                $article_author = '';
            }
            $this->db->where('id',$row->category_id);
            $sql_category_post = $this->db->get('tblarticle_category');
            if($sql_category_post->num_rows()>0){
                $category_id = $sql_category_post->row()->category;
            }else{
                $category_id = '';
            }
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, date('d-m-Y H:i:s',strtotime($row->date_day)));
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $article_id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->view);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $category_id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $article_title);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $article_author);
            $excel_row++;
        }      
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Artive_Data.xls"');
        $object_writer->save('php://output');
    }
    public function doSearchListStaticIn(){        
        unset($_SESSION['category_static_in']);
        unset($_SESSION['title_static_in']);  
        $category_static_in = $this->input->post('category_static_in');
        $title_static_in = $this->input->post('title_static_in');        
        $_SESSION['category_static_in'] = $category_static_in;
        $_SESSION['title_static_in'] = $title_static_in;          
        $this->load->library('pagination');
        $config['base_url'] = site_url('adminhp/statistic_category_pagi_in');
        $config['total_rows'] = $this->admin_model->getStaticCategoryInAll($category_static_in,$title_static_in)->num_rows();        
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // fetch employees list
        $data['results'] = $this->admin_model->getStaticCategoryIn($category_static_in,$title_static_in,$config['per_page'], $data['page']);       
        // create pagination links
        $pagination = $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['links'] = $lks;
        $total = 0;
        $kg = $this->admin_model->getStaticCategoryInAll($category_static_in,$title_static_in);
        foreach($kg->result() as $item_kg){
            $total+=$item_kg->view;
        }
        $data['total'] = $total;
        if($this->input->post('ajax')) {            
            $this->load->view('static_category_in_ajax', $data);
        } else {
            $this->load->view('list_category_in_static', $data);
        }
    }
    public function statistic_category_pagi_in(){
        $category_static_in = $_SESSION['category_static_in'];
        $title_static_in = $_SESSION['title_static_in'];
        $this->load->library('pagination');
        $config['base_url'] = site_url('adminhp/statistic_category_pagi_in');
        $config['total_rows'] = $this->admin_model->getStaticCategoryInAll($category_static_in,$title_static_in)->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // fetch employees list
        $data['results'] = $this->admin_model->getStaticCategoryIn($category_static_in,$title_static_in,$config['per_page'], $data['page']);       
        // create pagination links
        $pagination = $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['links'] = $lks;
        $total = 0;
        $kg = $this->admin_model->getStaticCategoryInAll($category_static_in,$title_static_in);
        foreach($kg->result() as $item_kg){
            $total+=$item_kg->view;
        }
        $data['total'] = $total;
        if($this->input->post('ajax')) {            
            $this->load->view('static_category_in_ajax', $data);
        } else {
            $this->load->view('list_category_in_static', $data);
        }
    }
    public function doSearchListStatic(){
        unset($_SESSION['category_static']);
        unset($_SESSION['title_static']);
        $category_static = $this->input->post('category_static');
        $title_static = $this->input->post('title_static');
        $_SESSION['category_static'] = $category_static;
        $_SESSION['title_static'] = $title_static;
        $this->load->library('pagination');
        $config['base_url'] = site_url('adminhp/statistic_category_pagi');
        $config['total_rows'] = $this->admin_model->getStaticCategoryAll($category_static,$title_static)->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // fetch employees list
        $data['results'] = $this->admin_model->getStaticCategory($category_static,$title_static,$config['per_page'], $data['page']);       
        // create pagination links
        $pagination = $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['links'] = $lks;
        $total = 0;
        $kg = $this->admin_model->getStaticCategoryAll($category_static,$title_static);
        foreach($kg->result() as $item_kg){
            $total+=$item_kg->view;
        }
        $data['total'] = $total;
        if($this->input->post('ajax')) {            
            $this->load->view('static_category_ajax', $data);
        } else {
            $this->load->view('list_category_static', $data);
        }
    }
    public function statistic_category_pagi(){
        $category_static = $_SESSION['category_static'];
        $title_static = $_SESSION['title_static'];
        $this->load->library('pagination');
        $config['base_url'] = site_url('adminhp/statistic_category_pagi');
        $config['total_rows'] = $this->admin_model->getStaticCategoryAll($category_static,$title_static)->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // fetch employees list
        $data['results'] = $this->admin_model->getStaticCategory($category_static,$title_static,$config['per_page'], $data['page']);       
        // create pagination links
        $pagination = $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['links'] = $lks;
        $total = 0;
        $kg = $this->admin_model->getStaticCategoryAll($category_static,$title_static);
        foreach($kg->result() as $item_kg){
            $total+=$item_kg->view;
        }
        $data['total'] = $total;
        if($this->input->post('ajax')) {            
            $this->load->view('static_category_ajax', $data);
        } else {
            $this->load->view('list_category_static', $data);
        }
    }
    public function statistic_search_pagi(){
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $this->load->library('pagination');
        $config['base_url'] = site_url('adminhp/statistic_search_pagi');
        $config['total_rows'] = $this->admin_model->getStaticAllSearch($start_date,$end_date)->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // fetch employees list
        $data['results'] = $this->admin_model->getStaticSearch($start_date,$end_date,$config['per_page'], $data['page']);       
        // create pagination links                        
        $pagination = $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['links'] = $lks;
        if($this->input->post('ajax')) {
            $this->load->view('static_search_ajax', $data);
        } else {
            $this->load->view('list_search_static', $data);
        }
    }
    public function statistic_pagi(){
        $this->load->library('pagination');
        $config['base_url'] = site_url('adminhp/statistic_pagi');
        $config['total_rows'] = $this->admin_model->getStaticAll()->num_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // fetch employees list
        $data['results'] = $this->admin_model->getStatic($config['per_page'], $data['page']);       
        // create pagination links
        $pagination = $this->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        $data['links'] = $lks;
        if($this->input->post('ajax')) {            
            $this->load->view('static_ajax', $data);
        } else {
            $this->load->view('list_static', $data);
        }
    }

    public function doTimKiem(){
        unset($_SESSION['start_date']);
        unset($_SESSION['end_date']);
        $datetimes = $_POST['datetimes'];   
        $explode_date = explode('-',$datetimes);
        $start_date = $explode_date[0];
        $start_explode = explode(' ',$start_date);
        $start_explode_day = explode('/',$start_explode[0]);
        $start_explode_day_db = $start_explode_day[2].'-'.$start_explode_day[1].'-'.$start_explode_day[0].' '.$start_explode[1];
        $end_date = $explode_date[1];
        $end_date_explode = explode(' ',$end_date);
        $end_explode_day = explode('/',$end_date_explode[1]);
        $end_explode_day_db = $end_explode_day[2].'-'.$end_explode_day[1].'-'.$end_explode_day[0].' '.$end_date_explode[2];
        $data['start_date'] = $start_explode_day_db;
        $data['end_date'] = $end_explode_day_db;
        $html = $this->load->view('do_statistic',$data);                   
        echo $html;
    }
    public function doPreview(){
        unset($_SESSION['title']);
        unset($_SESSION['category_id']);
        unset($_SESSION['category']);
        unset($_SESSION['category_sub_id']);
        unset($_SESSION['category_sub']);
        unset($_SESSION['description']);
        unset($_SESSION['content']);
        unset($_SESSION['date_day']);
        unset($_SESSION['post_time']);
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['category_id'] = $_POST['category_id'];
        $_SESSION['category'] = $_POST['category'];
        $_SESSION['category_sub_id'] = $_POST['category_sub_id'];
        $_SESSION['category_sub'] = $_POST['category_sub'];
        $_SESSION['description'] = $_POST['description'];
        $_SESSION['content'] = $_POST['content'];
        $_SESSION['date_day'] = $_POST['date_day'];
        $_SESSION['post_time'] = $_POST['post_time'];
    }

    public function rwurl()
    {
        $this->checkadminSession();
        $this->checkRwurl();
    }
    public function statistic(){    
        unset($_SESSION['start_date']);
        unset($_SESSION['end_date']);
        if(isset($_SESSION['username'])){	            
            $data = $this->declareTables();
            $data['message'] = array('information' => 'true');
            $data['action'] = "statistic";        
            $this->displayTemplate($data);            
		}else{
		  redirect('adminhp/login');
        } 
    }
    public function sapxep($id)
    {
        $this->checkadminSession();
        $ordernum = $_POST["ordernum"];
        $table_nameor = $_POST["table_nameor"];
        $data_up = array(
            'ordernum' => $ordernum
        );
        $this->updateTable($table_nameor, $id, $data_up);
    }

    public function statushp()
    {
        $this->checkadminSession();
        $id = $_POST["id"];
        $this->db->where('id', $id);
        $test = $this->db->get($table_name);
        if ($test->status == 0) {
            $this->adminhp_model->checkstatus($tblname, 1, $id);
        } else {
            $this->adminhp_model->checkstatus($tblname, 0, $id);
        }
    }

    public function deleteallcontent($table_name)
    {
        $this->checkadminSession();
        $this->loadConfig();
        //Check role
        $this->checkRoleAccess($table_name,'delete');        
        //End check role        		
        $checkbox = $_POST['checkbox'];
        $countCheck = count($_POST['checkbox']);
        for ($i = 0; $i < $countCheck; $i++) {
            $del_id = $checkbox[$i];             
            //delete image                     
            if(count($this->config->item('table_delete_image'))>0)
            {                
                foreach($this->config->item('table_delete_image') as $k_delete=>$v_delete)
                {                                     
                    if($table_name == $v_delete['table_delete']){                         
                        $explode_table_delete_field = explode(',',$v_delete['table_delete_field']);                        
                        foreach($explode_table_delete_field as $item_code){                                           
                            $this->db->where('id', $del_id);
                            $sql = $this->db->get($table_name);                      
                            if ($sql->num_rows() > 0) {                                                      
                                unlink($sql->row()->$item_code);                       
                            }
                        }
                    }        
                }
            }                     
            $this->deleteMultiple($table_name, ['id' => $del_id]);
            if ($table_name == 'tblarticle') {
                $this->deleteMultiple('tag_new', ['idnew' => $del_id, 'categories' => 2]);
            }
            if ($table_name == 'tblsanpham') {
                $this->deleteMultiple('tag_new', ['idnew' => $del_id, 'categories' => 1]);
            }
            if ($table_name == 'tbladmin') {
                $this->deleteMultiple('tblrole', ['username' => $del_id]);
            }
        }
        $this->showSitemap();
        if ($_SESSION['offset'] == 0) {
            redirect('adminhp/viewContent/' . $table_name);
        } else {
            redirect('adminhp/viewContent/' . $table_name . '/' . $_SESSION['offset']);
        }
    }

    public function resetmatkhau($id)
    {
        $this->checkadminSession();
        $table_name = "tbluser";
        //Check role
        $this->checkRoleViewContent($table_name);
        //End check role          
        $data = $this->declareTables();
        $data['message'] = array('information' => 'true');
        $data['action'] = "resetmatkhau";
        $data['id'] = $id;
        $this->displayTemplate($data);
    }
    public function thongtincanhan(){
        $this->checkadminSession();
        $data = $this->declareTables();
        $data['message'] = array('information' => 'true');
        $data['action'] = "thongtincanhan";        
        $this->displayTemplate($data);
    }

    public function dothongtincanhan(){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];
        $this->admin_model->updateTable('tbladmin',$_SESSION['uid'],$data);
        $html = '<div class="alert alert-success" role="alert">
        Cập nhật thành công
      </div>';
        echo $html;
    }
    
    public function changeImage(){
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
                $config1['width']	=35;
                $config1['height']	= 35;
                $this->load->library('image_lib', $config1); 
                $this->image_lib->resize();
                $temp=explode('.',$image_data['file_name']);
                $thumb='upload/'.$temp[0].'_thumb'.'.'.$temp[1];
                $name_img='upload/'.$image_data['file_name'];           
            }
            $data = [
                'avatar' => $name_img,
                'thumb' => $thumb,               
            ];
            $this->admin_model->updateTable('tbladmin',$_SESSION['uid'],$data);
        }
    }
    public function changPassword(){
        $password_old = $_POST['password_old'];
        $password_new = $_POST['password_new'];
        $checkPass = $this->admin_model->getUserByValue('tbladmin','password',md5($password_old));
        if($checkPass->num_rows()>0){
            $data = [
                'password' => md5($password_new)                       
            ];
            $this->admin_model->updateTable('tbladmin',$_SESSION['uid'],$data);
            $html = '<div class="alert alert-success" role="alert">
                Đổi mật khẩu thành công
            </div>';
        }else{
            $html = '<div class="alert alert-danger" role="alert">
            Mật khẩu cũ không dúng
          </div>';
        }
        echo $html;
    }

    public function do_rematkhau()
    {
        $this->checkadminSession();
        $table_name = "tbluser";
        //Check role
        $this->checkRoleViewContent($table_name);
        //End check role          
        $this->form_validation->set_rules('matkhaumoi', '<span style="color:red">Mật khẩu cũ</span>', 'required');
        $this->form_validation->set_rules('rematkhaumoi', '<span style="color:red">Xác nhận mật khẩu mới</span>', 'required|matches[matkhaumoi]');
        $this->form_validation->set_message('required', '<span>%s không để trống</span>');
        $this->form_validation->set_message('matches', '<span>%s không trùng với mật khẩu mới</span>');
        if ($this->form_validation->run() == FALSE) {
            $data = $this->declareTables();
            $data['message'] = array('error' => validation_errors());
            $data['action'] = "resetmatkhau";
            $data['id'] = $this->input->post('id');
            $this->displayTemplate($data);
        } else {
            $data_up = array(
                'matkhau' => md5($this->input->post('matkhaumoi'))
            );
            $this->updateTable('tbluser', $this->input->post('id'), $data_up);
            $data = $this->declareTables();
            $data['message'] = array('success' => 'Thông tin của bạn đã được cập nhật.');
            $data['action'] = "resetmatkhau";
            $data['id'] = $this->input->post('id');
            $this->displayTemplate($data);
        }
    }

    public function doimatkhau($id)
    {
        $this->checkadminSession();
        $table_name = "tbladmin";
        //Check role
        $this->checkRoleViewContent($table_name);
        $data = $this->declareTables();
        $data['message'] = array('information' => 'true');
        $data['action'] = "chang_password";
        $data['id'] = $id;
        $this->displayTemplate($data);
    }

    public function do_doimatkhau()
    {
        $this->checkadminSession();
        $table_name = "tbladmin";
        //Check role
        $this->checkRoleViewContent($table_name);
        //End check role          
        $this->form_validation->set_rules('matkhaumoi', '<span style="color:red">Mật khẩu cũ</span>', 'required');
        $this->form_validation->set_rules('rematkhaumoi', '<span style="color:red">Xác nhận mật khẩu mới</span>', 'required|matches[matkhaumoi]');
        $this->form_validation->set_message('required', '<span>%s không để trống</span>');
        $this->form_validation->set_message('matches', '<span>%s không trùng với mật khẩu mới</span>');
        if ($this->form_validation->run() == FALSE) {
            $data = $this->declareTables();
            $data['message'] = array('error' => validation_errors());
            $data['action'] = "doimatkhau";
            $data['id'] = $this->input->post('id');
            $this->displayTemplate($data);
        } else {
            $data_up = array(
                'password' => md5($this->input->post('matkhaumoi'))
            );
            $this->updateTable('tbladmin', $this->input->post('id'), $data_up);
            $data = $this->declareTables();
            $data['message'] = array('success' => 'Thông tin của bạn đã được cập nhật.');
            $data['action'] = "doimatkhau";
            $data['id'] = $this->input->post('id');
            $this->displayTemplate($data);
        }
    }

    public function addContent($table_name)
    {
        $this->checkadminSession();
        $data = $this->declareTables();
        //get table's name
        $data['table_name'] = $table_name;
        //Check role
        $this->checkRoleAccess($table_name,'add');         
        //End check role        
        //state action: add or view or delete
        $data['action'] = 'add';
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $data['message'] = array('information' => 'true');
        $this->displayTemplate($data);
    }

    public function doAddContent($table_name)
    {        
        $this->checkadminSession();
        $data = $this->declareTables();
        //Check role
        $this->checkRoleAccess($table_name,'add');         
        //state action: add or view or delete
        if ($table_name == 'tblarticle') {
            $categories = '2';
        } elseif ($table_name == 'tblsanpham') {
            $categories = '1';
        } else {
            $categories = '0';
        }
        $data['action'] = 'add';
        //get table's name
        $data['table_name'] = $table_name;
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);        
        $enumFields = element($table_name, $data['labels']);
        if (!$_POST) {
            $data['message'] = array('error' => 'Có lỗi xảy ra trong khi thực hiện. Dữ liệu chưa được cập nhật');
            $this->displayTemplate($data);
            return;
        }
        $passwordType = array();
        $uploadType = array();
        $dateType = array();        
        $priceType = array();
        foreach ($data['fields'] as $item) {
            if($table_name =='tbladmin' || $table_name=='tbluser'){
                $this->form_validation->set_rules('username', '<span style="color:red">Tài khoản</span>', 'required');                    
                $this->form_validation->set_rules('password', '<span style="color:red">Mật khẩu</span>', 'required|matches[repassword]'); 
                $this->form_validation->set_rules('repassword', '<span style="color:red">Xác nhận mật khẩu</span>', 'required'); 
                $this->form_validation->set_message('required', '<span>%s không để trống</span>');
                $this->form_validation->set_message('matches', '<span>%s không giống nhau</span>');
            }
            if (element($item->Field, $data['column_type'])) {                
                $temp = element($item->Field, $data['column_type']);
                if ($temp[0] == 'password') {                    
                    $passwordType[$item->Field] = $item->Field;                    
                }elseif($temp[0]=='format'){
                    if($temp[1]=='price'){
                        $priceType[$item->Field] = $item->Field;
                    }elseif($temp[1]=='postNumber'){
                        $priceType[$item->Field] = $item->Field;
                    }elseif($temp[1] == 'postFilter'){
                        $priceType[$item->Field] = $item->Field;
                    }
                } elseif ($temp[0] == 'upload') {
                    $uploadType[$item->Field] = $item->Field;
                }
            } elseif (substr($item->Type, 0, 3) == 'int' || substr($item->Type, 0, 6) == 'double' || substr($item->Type, 0, 5) == 'float' || substr($item->Type, 0, 4) == 'real' || substr($item->Type, 0, 7) == 'decimal') {
                $this->form_validation->set_rules($item->Field, $item->Field, 'numeric');
                $this->form_validation->set_message('numeric', 'Trường dữ liệu <b> %s </b> phải là số.');
            } elseif (substr($item->Type, 0, 4) == 'date') {
                $dateType[$item->Field] = $item->Field;
            }elseif(substr($item->Type, 0, 4) == 'datetime'){
                $datetimeType[$item->Field] = $item->Field;
            }
        }       
        do {
            if (element(key($enumFields), $passwordType)) {
                $column[key($enumFields)] = md5($this->input->post(key($enumFields)));
            }elseif (element(key($enumFields), $uploadType)) {
                //upload
                $config['upload_path'] = './upload/';
                $config['allowed_types'] = 'mp3|gif|jpg|png|zip|rar|csv|pdf|xls|jpeg|doc|docx|bmp|webp';
                $config['max_size'] = '1000000000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload(key($enumFields))) {
                    $getFileUpload = $this->upload->data();

                    $column[key($enumFields)] = 'upload/' . $getFileUpload['file_name'];
                    $temp = explode('.', $getFileUpload['file_name']);
                    if (isset($anh)) {
                    } else {
                        $duoi = strtolower($temp[1]);
                        if ($duoi == 'jpg' || $duoi == 'gif' || $duoi == 'png' || $duoi == 'jpeg' || $duoi == 'bmp' || $duoi == 'webp') {
                            $anh = true;
                            $duongdan = $getFileUpload['file_name'];
                            $config1['image_library'] = 'gd2';
                            $config1['source_image'] = './upload/' . $duongdan;
                            $config1['create_thumb'] = TRUE;
                            $config1['maintain_ratio'] = TRUE;
                            $config1['width'] = 670;
                            $config1['height'] = 500;
                            $this->load->library('image_lib', $config1);
                            $this->image_lib->resize();
                            $thumb = 'upload/' . $temp[0] . '_thumb' . '.' . $temp[1];
                        } else {
                            $thumb = '';
                        }
                    }
                } else {
                    $column[key($enumFields)] = NULL;
                }
                //end upload

            } elseif (element(key($enumFields), $dateType)) {                
                $column[key($enumFields)] = date('Y-m-d H:i:s',strtotime($this->input->post(key($enumFields))));                     
            }elseif(element(key($enumFields), $priceType)){
                $column[key($enumFields)] = str_replace(',','',$this->input->post(key($enumFields)));
            }elseif ($item->Field = 'tag') {
                $tag10 = $this->input->post(key($enumFields));
                $tag0 = $tag10;
                $column[key($enumFields)] = $this->input->post(key($enumFields));
            }else {
                $column[key($enumFields)] = $this->input->post(key($enumFields));
            }
        } while (next($enumFields));
        if (is_array($column)) {
            if ($this->form_validation->run() == TRUE) {
                if ($_POST) {
                    if ($table_name == 'tbladmin' || $table_name=='tbluser') {
                        $column['password'] = md5($this->input->post('password'));
                    }elseif($table_name == 'tblarticle' || $table_name == 'tblads'){
                        $config['upload_path'] = './upload/';
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['max_size']	= '1000000';
                        $config['max_width']  = '0';
                        $config['max_height']  = '0';
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('image_square')){
                            $image_data = $this->upload->data();
                            $name_img='upload/'.$image_data['file_name'];    
                        }else{
                            $name_img = '';   
                        }
                        $column['image_square'] = $name_img;
                    }             
                    $this->createTable($table_name, $column);
                    $id_new = $this->db->insert_id();
                    $this->admin_model->tag($tag0, $id_new, $categories);
                    if ($table_name == 'tbladmin') {
                        $chrole = $_POST['chrole'];
                        $countcheckrole = count($chrole);
                        $del_role = '';
                        for ($i = 0; $i < $countcheckrole; $i++) {
                            $explode_table = explode('.', $chrole[$i]);
                            $this->createTable('tblrole', ['username' => $id_new, 'table_name' => $explode_table[0], 'table_label' => $explode_table[1], 'access' => $explode_table[2]]);
                        }
                    }elseif($table_name == 'tblads'){
                        $category_ads = $this->input->post('category_ads');
                        $this->db->where('id',$category_ads);
                        $sqlcategory_ads = $this->db->get('tblcategory_ads');
                        if($sqlcategory_ads->num_rows()>0){
                            $column['category'] = $sqlcategory_ads->row()->category;
                            $this->updateTable($table_name,$id_new,$column);
                        }
                    } elseif ($table_name == 'tblsanpham') {
                        $countfiles = count($_FILES['files']['name']);
                        for ($i = 0; $i < $countfiles; $i++) {
                            if (!empty($_FILES['files']['name'][$i])) {
                                // Define new $_FILES array - $_FILES['file']
                                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                                $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                                // Set preference
                                $config['upload_path'] = './upload/';
                                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                                $config['max_size'] = '5000'; // max_size in kb
                                $config['file_name'] = $_FILES['files']['name'][$i];
                                //Load upload library
                                $this->load->library('upload', $config);
                                $arr = array('msg' => 'something went wrong', 'success' => false);
                                // File upload
                                if ($this->upload->do_upload('file')) {
                                    $data = $this->upload->data();
                                    $insert['post_id'] = $id_new;
                                    $insert['name'] = 'upload/' . $data['file_name'];
                                    $insert['loai'] = SAN_PHAM;
                                    $this->createTable('tblimages', $insert);
                                }
                            }
                        }
                    }
                    //sitemap
                    foreach($this->config->item('table_sitemap') as $k_site=>$v_site)
                    {
                        if($table_name==$v_site)
                        {
                            $this->showSitemap();    
                        }
                    }        
                    if (isset($thumb)) {
                        $this->admin_model->anh_thumb($table_name, $id_new, $thumb);
                    }
                    $data['message'] = array('success' => 'Cập nhật thông tin thành công.');
                    unset($_POST);
                } else {
                    $data['message'] = array('warning' => 'Dữ liệu đã được cập nhật!');
                }
                redirect('adminhp/viewContent/' . $table_name);
            } else {
                $data = $this->declareTables();                
                $data['table_name'] = $table_name;
                $data['action'] = 'add';
                $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
                $data['fields'] = $query->result();
                $data['column_type'] = $this->listColumnCallback($table_name);
                $data['message'] = array('error' => validation_errors());
                $data['action']='add';
                $this->displayTemplate($data);
            }
        } else {
            $data['message'] = array('error' => 'Có lỗi xảy ra trong khi thực hiện. Dữ liệu chưa được cập nhật');
        }        
    }

    public function deleteContent($table_name, $id)
    {        
        $this->checkadminSession();
        $this->loadConfig();
        //Check role
        $this->checkRoleAccess($table_name,'delete');         
        //delete image  
        if(count($this->config->item('table_delete_image'))>0)
        {
            foreach($this->config->item('table_delete_image') as $k_delete=>$v_delete)
            {                   
                if($table_name == $v_delete['table_delete']){
                    $explode_table_delete_field = explode(',',$v_delete['table_delete_field']);
                    foreach($explode_table_delete_field as $item_code){                    
                        $this->db->where('id', $id);
                        $sql = $this->db->get($table_name);                        
                        if ($sql->num_rows() > 0) {                                                      
                            unlink($sql->row()->$item_code);                       
                        }
                    }
                }        
            }
        }                                    
        $this->deleteMultiple($table_name, ['id' => $id]);         
        if ($table_name == 'tblarticle') {
            $this->deleteMultiple('tag_new', ['idnew' => $id, 'categories' => 2]);
        }
        if ($table_name == 'tblsanpham') {
            $this->deleteMultiple('tag_new', ['idnew' => $id, 'categories' => 1]);
        }
        if ($table_name == 'tbladmin') {
            $this->deleteMultiple('tblrole', ['username' => $id]);
        }
        $this->admin_model->sitemap();
        if ($_SESSION['offset'] == 0) {
            redirect('adminhp/viewContent/' . $table_name);
        } else {
            redirect('adminhp/viewContent/' . $table_name . '/' . $_SESSION['offset']);
        }
    }

    public function editContent($table_name, $id)
    {
        $this->checkadminSession();
        $data = $this->declareTables();
        //get table's name
        $data['table_name'] = $table_name;        
        //Check role
        $this->checkRoleAccess($table_name,'edit'); 
        //state action: add or view or delete
        $data['action'] = 'edit';
        $data['primaryKey'] = $id;
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $enumFields = element($table_name, $data['labels']);
        $sql = (array)$this->getTableById($table_name, $id);
        do {
            $column[key($enumFields)] = $sql[key($enumFields)];
        } while (next($enumFields));
        $data['editContent'] = $column;
        $data['is_edit'] = true;
        $data['message'] = array('warning' => 'Đang sửa nội dung bản ghi có mã là ' . $id . ' trong bảng ' . element($table_name, $data['table_list']));
        $this->displayTemplate($data);
    }

    public function doEditContent($table_name, $id)
    {
        $this->checkadminSession();
        $data = $this->declareTables();
        //state action: add or view or delete
        $data['action'] = 'edit';
        //get table's name
        $data['table_name'] = $table_name;
        //Check role
        $this->checkRoleAccess($table_name,'edit');         
        if ($table_name == 'tblsanpham') {
            $categories = '1';
            $tag_status = '1';
        } elseif ($table_name == 'tblarticle') {
            $categories = '2';
            $tag_status = '1';
        } elseif ($table_name == 'tblphukien') {
            $categories = '3';
            $tag_status = '1';
        }        
        $data['primaryKey'] = $id;
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $enumFields = element($table_name, $data['labels']);
        $password = array();
        $upload = array();
        $dateType = array();
        $priceType = [];
        foreach ($data['fields'] as $item) {
            if (element($item->Field, $data['column_type'])) {
                $temp = element($item->Field, $data['column_type']);
                if ($temp[0] == 'password') {                                                      
                    $password[$item->Field] = $item->Field;
                } elseif ($temp[0] == 'upload') {
                    $upload[$item->Field] = $item->Field;
                }
                elseif($temp[0]=='format'){
                    if($temp[1]=='price'){
                        $priceType[$item->Field] = $item->Field;
                    }elseif($temp[1]=='postNumber'){
                        $priceType[$item->Field] = $item->Field;
                    }elseif($temp[1]=='postFilter'){
                        $priceType[$item->Field] = $item->Field;
                    }                    
                }
            } elseif (substr($item->Type, 0, 3) == 'int' || substr($item->Type, 0, 6) == 'double' || substr($item->Type, 0, 5) == 'float' || substr($item->Type, 0, 4) == 'real' || substr($item->Type, 0, 7) == 'decimal') {                
                $fieldNameFiltered1 = element($table_name, $data['labels']);
                $fieldNameFiltered2 = element($item->Field, $fieldNameFiltered1);
                $this->form_validation->set_rules($item->Field, $fieldNameFiltered2, 'numeric');
                $this->form_validation->set_message('numeric', 'Trường dữ liệu <b> %s </b> phải là số.');
            } elseif (substr($item->Type, 0, 4) == 'date') {
                $dateType[$item->Field] = $item->Field;
            }
        }
        do {
            if (element(key($enumFields), $password)) {
                $column[key($enumFields)] = md5($this->input->post(key($enumFields)));
            } elseif (element(key($enumFields), $upload)) {
                //upload
                $config['upload_path'] = './upload/';
                $config['allowed_types'] = 'mp3|gif|jpg|png|zip|rar|csv|pdf|jpeg|xls|doc|docx|ico|svg|webp';
                $config['max_size'] = '100000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload(key($enumFields))) {                    
                    $getFileUpload = $this->upload->data();
                    $column[key($enumFields)] = 'upload/' . $getFileUpload['file_name'];

                    $temp = explode('.', $getFileUpload['file_name']);
                    if (isset($anh)) {
                    } else {
                        //delete image                          
                        if(count($this->config->item('table_delete_image'))>0)
                        {
                            foreach($this->config->item('table_delete_image') as $k_delete=>$v_delete)
                            {                   
                                if($table_name == $v_delete['table_delete']){
                                    $explode_table_delete_field = explode(',',$v_delete['table_delete_field']);
                                    foreach($explode_table_delete_field as $item_code){                    
                                        $this->db->where('id', $id);
                                        $sql = $this->db->get($v_delete['table_delete']);                                                             
                                        if ($sql->num_rows() > 0) {                                                      
                                            unlink($sql->row()->$item_code);                       
                                        }
                                    }
                                }        
                            }
                        }                        
                        $duoi = strtolower($temp[1]);
                        if ($duoi == 'jpg' || $duoi == 'gif' || $duoi == 'png' || $duoi == 'jpeg' || $duoi == 'bmp' || $duoi == 'webp') {
                            $anh = true;
                            $duongdan = $getFileUpload['file_name'];
                            $config1['image_library'] = 'gd2';
                            $config1['source_image'] = './upload/' . $duongdan;
                            $config1['create_thumb'] = TRUE;
                            $config1['maintain_ratio'] = TRUE;
                            $config1['width'] = 670;
                            $config1['height'] = 500;
                            $this->load->library('image_lib', $config1);
                            $this->image_lib->resize();
                            $thumb = 'upload/' . $temp[0] . '_thumb' . '.' . $temp[1];
                        }
                    }

                } else {
                    //get hidden field marked for image column
                    $column[key($enumFields)] = $this->input->post('hid' . key($enumFields));
                }
                //end upload
            } elseif (element(key($enumFields), $dateType)) {
                //$column[key($enumFields)]=$this->input->post(key($enumFields));
                $getdate = $this->input->post(key($enumFields));                
                $column[key($enumFields)] = date('Y-m-d H:i:s',strtotime($this->input->post(key($enumFields))));                                
            } elseif(element(key($enumFields), $priceType)){                
                $sql_price = $this->getTableIdValue($table_name,$id,key($enumFields),$this->input->post(key($enumFields)));
                if($sql_price->num_rows()>0){                    
                }else{
                    $column[key($enumFields)] = str_replace(',','',$this->input->post(key($enumFields)));
                }
            }elseif (isset($tag_status)) {
                if ($item->Field == 'tag') {
                    $tag10 = $this->input->post(key($enumFields));
                    $tag0 = $tag10;
                    $column[key($enumFields)] = $this->input->post(key($enumFields));
                }

            } else {
                $column[key($enumFields)] = $this->input->post(key($enumFields));
            }
        } while (next($enumFields));
        if ($_POST) {
            if ($this->form_validation->run() == TRUE) {
                //editing content statement
                if ($table_name == 'tbladmin') {
                    $chrole = $_POST['chrole'];
                    $countcheckrole = count($chrole);
                    $data_add = [];
                    $data_edit_no = [];
                    $data_no_delete = [];
                    $data_update_no = [];
                    for ($i = 0; $i < $countcheckrole; $i++) {
                        $explode_table = explode('.', $chrole[$i]);
                        $this->db->where('username', $id);
                        $this->db->where('table_name', $explode_table[0]);
                        $query_check = $this->db->get('tblrole');
                        if ($query_check->num_rows() > 0) {
                            $data_edit_no[] = $query_check->row()->id . '+' . $chrole[$i];
                        } else {
                            $data_add[] = $chrole[$i];
                        }
                    }
                    if (!empty($data_edit_no)) {
                        foreach ($data_edit_no as $k_e => $v_e) {
                            $delete_explode = explode('+', $v_e);
                            $data_no_delete[] = $delete_explode[0];
                            $data_update_no[] = $delete_explode[0] . '.' . $delete_explode[1];
                        }
                        foreach ($data_update_no as $k_up => $v_up) {
                            $update_explode = explode('.', $v_up);
                            $this->updateTable('tblrole', $update_explode[0], ['access' => $update_explode[3]]);
                        }
                        $this->db->where_not_in('id', $data_no_delete);
                        $this->db->where('username', $id);
                        $this->db->delete('tblrole');
                    }
                    if (!empty($data_add)) {

                        foreach ($data_add as $k => $v) {
                            $explode_table_add = explode('.', $v);
                            $this->createTable('tblrole', ['username' => $id, 'table_name' => $explode_table_add[0], 'table_label' => $explode_table_add[1], 'access' => $explode_table_add[2]]);
                        }
                    }
                } elseif ($table_name == 'tblinformation') {
                    $htaccess = file_get_contents('.htaccess');
                    file_put_contents('.htaccess', $_POST['ht']);
                    $robot = file_get_contents('robots.txt');
                    file_put_contents('robots.txt', $_POST['robot']);
                    $column['ht'] = $_POST['ht'];
                    $column['robot'] = $_POST['robot'];
                } elseif ($table_name == 'tblsanpham') {
                    $countfiles = count($_FILES['files']['name']);
                    for ($i = 0; $i < $countfiles; $i++) {
                        if (!empty($_FILES['files']['name'][$i])) {
                            // Define new $_FILES array - $_FILES['file']
                            $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                            // Set preference
                            $config['upload_path'] = './upload/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif';
                            $config['max_size'] = '5000'; // max_size in kb
                            $config['file_name'] = $_FILES['files']['name'][$i];
                            //Load upload library
                            $this->load->library('upload', $config);
                            $arr = array('msg' => 'something went wrong', 'success' => false);
                            // File upload
                            if ($this->upload->do_upload('file')) {
                                $data = $this->upload->data();
                                $insert['post_id'] = $id;
                                $insert['name'] = 'upload/' . $data['file_name'];
                                $insert['loai'] = SAN_PHAM;
                                $this->createTable('tblimages', $insert);
                            }
                        }
                    }
                }elseif($table_name == 'tblarticle' || $table_name == 'tblads'){
                    $config['upload_path'] = './upload/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	= '1000000';
                    $config['max_width']  = '0';
                    $config['max_height']  = '0';
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image_square')){
                        $image_data = $this->upload->data();
                        $name_img='upload/'.$image_data['file_name'];    
                    }else{
                        $name_img = $_POST['hidimage_square'];   
                    }
                    $column['image_square'] = $name_img;
                }             
                $this->updateTable($table_name, $id, $column);
                if($table_name == 'tblads'){
                    $category_ads = $this->input->post('category_ads');
                    $this->db->where('id',$category_ads);
                    $sqlcategory_ads = $this->db->get('tblcategory_ads');
                    if($sqlcategory_ads->num_rows()>0){
                        $column['category'] = $sqlcategory_ads->row()->category;
                        $this->updateTable($table_name,$id,$column);
                    }
                }                
                $sql = (array)$this->getTableById($table_name, $id);
                reset($enumFields);
                do {
                    $column[key($enumFields)] = $sql[key($enumFields)];
                } while (next($enumFields));
                if (isset($thumb)) {
                    $this->admin_model->anh_thumb($table_name, $id, $thumb);
                }
                $data['editContent'] = $column;
                $data['message'] = array('success' => 'Đã cập nhật thông tin bản ghi có mã ' . $id . ' trong ' . $table_name . '.');
                if (isset($tag_status)) {
                    $id_new = $id;
                    $this->admin_model->edittag($tag0, $id_new, $categories);
                }
            } else {
                $data['message'] = array('error' => validation_errors());
            }
        } else {
            $data['message'] = array('error' => 'Có lỗi xảy ra trong khi thực hiện. Dữ liệu chưa được cập nhật');
        }
        $sql = (array)$this->getTableById($table_name, $id);
        reset($enumFields);
        do {
            $column[key($enumFields)] = $sql[key($enumFields)];
        } while (next($enumFields));  
        //Site map             
        foreach($this->config->item('table_sitemap') as $k_site=>$v_site)
        {
            if($table_name==$v_site)
            {
                $this->showSitemap();    
            }
        }        
        $data['editContent'] = $column;
        if ($_SESSION['offset'] == 0) {
            redirect('adminhp/viewContent/' . $table_name);
        } else {
            redirect('adminhp/viewContent/' . $table_name . '/' . $_SESSION['offset']);
        }
        //$this->displayTemplate($data);
    }

    public function viewCheck($table_name,$status, $offset = 0){           
        $this->checkadminSession();        
        $data = $this->viewContentTables();        
        //Check role
        $this->checkRoleViewContent($table_name);
		$query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $limit = element($table_name, $data['row_per_page']);
        //if you does not set how many row per page, adminhp set default to 20
        //$offset=$this->uri->segment(3);
        if ($limit == NULL) {
            $limit = 20;
        }
        if (is_numeric($offset)) {
            $_SESSION['offset'] = $offset;
        } else {
            $_SESSION['offset'] = 0;
        }
        $data['rowLimit'] = $limit;
        $data['table_name'] = $table_name;
        $data['status'] = $status;
        $data['checkem'] = true;
        $data['action'] = 'view_check';        
        $data['contents'] = $this->admin_model->getContentCheck($table_name,$status, $limit, $_SESSION['offset']);
        $data['rowCounter'] = $this->admin_model->getTotalCheckRows($table_name,$status);
        $data['message'] = array('information' => 'true');
        $this->displayTemplate($data);   
    }

    public function newToday($table_name, $offset = 0){
        $this->checkadminSession();        
        $data = $this->viewContentTables();        
        //Check role
        $this->checkRoleViewContent($table_name);
		$query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $limit = element($table_name, $data['row_per_page']);
        //if you does not set how many row per page, adminhp set default to 20
        //$offset=$this->uri->segment(3);
        if ($limit == NULL) {
            $limit = 20;
        }
        if (is_numeric($offset)) {
            $_SESSION['offset'] = $offset;
        } else {
            $_SESSION['offset'] = 0;
        }
        $data['rowLimit'] = $limit;
        $data['table_name'] = $table_name;
        $data['checkem'] = true;
        $data['action'] = 'view_today';
        $data['contents'] = $this->admin_model->getContentToDay($table_name, $limit, $_SESSION['offset']);
        $data['rowCounter'] = $this->admin_model->getTotalToDayRows($table_name);
        $data['message'] = array('information' => 'true');
        $this->displayTemplate($data);
    }
    //view data in table
    public function viewContent($table_name, $offset = 0)
    {
        $this->checkadminSession();        
        $data = $this->viewContentTables();        
        //Check role
        $this->checkRoleViewContent($table_name);
		$query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $limit = element($table_name, $data['row_per_page']);
        //if you does not set how many row per page, adminhp set default to 20
        //$offset=$this->uri->segment(3);
        if ($limit == NULL) {
            $limit = 20;
        }
        if (is_numeric($offset)) {
            $_SESSION['offset'] = $offset;
        } else {
            $_SESSION['offset'] = 0;
        }
        $data['rowLimit'] = $limit;
        $data['table_name'] = $table_name;
        $data['checkem'] = true;
        $data['action'] = 'view';
        $data['contents'] = $this->admin_model->getContent($table_name, $limit, $_SESSION['offset']);
        $data['rowCounter'] = $this->admin_model->getTotalRows($table_name);
        $data['message'] = array('information' => 'true');
        $this->displayTemplate($data);
    }

    public function viewDetail($table_name, $id)
    {
        $this->checkadminSession();
        //init database information
        $data = $this->declareTables();
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $limit = element($table_name, $data['row_per_page']);
        //if you does not set how many row per page, adminhp set default to 20
        if ($limit == NULL) {
            $limit = 20;
        }
        $data['rowLimit'] = $limit;
        $data['table_name'] = $table_name;
        $data['action'] = 'view';
        $data['contents'] = $this->admin_model->getContent($table_name, $limit, 0);
        $data['rowCounter'] = $this->admin_model->getTotalRows($table_name);
        $data['message'] = array('information' => 'true');
        $data['detail'] = $this->admin_model->getDetail($table_name, $id);
        $this->displayTemplate($data);
    }

    public function loadcate2($id)
    {
        $district = $this->admin_model->getdanhmuc2($id);
        echo '<option value="">--Chuyên mục con--</option>';
        foreach ($district as $item) {
            echo '<option value="' . $item->id . '"' . set_select('cmbdanhmuccon', $item->id) . '>' . $item->category . '</option>';
        }
    }

    //called public function by default
    public function index()
    {
        $this->checkadminSession();
        $data = $this->declareTables();
        $this->displayTemplate($data);
    }

    public function login()
    {
        $this->displayTemplateLogin();
    }

    public function logout()
    {
        unset($_SESSION['username']);
        //unset($_SESSION['role']);
        $this->displayTemplateLogin();
    }

    public function doLogin()
    {
        $this->load->model('admin_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $admin = $this->admin_model->adminLogin($username, $password);
        if (count($admin) > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['uid'] = $admin->id;
            $_SESSION['role'] = $admin->role;
            redirect('adminhp/index');
        } else {
            redirect('adminhp/login');
        }
    }

    public function changeadminhpInfo()
    {
        $table_name = 'tbladminhp';
        $this->checkadminSession();
        $data = $this->declareTables();
        //get table's name
        $data['table_name'] = $table_name;
        //state action: add or view or delete
        $data['adminhpchangeinfor'] = 'true';
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $enumFields = element($table_name, $data['labels']);
        $sql = (array)$this->admin_model->getadminhp($table_name);
        do {
            $column[key($enumFields)] = $sql[key($enumFields)];
        } while (next($enumFields));
        $data['editcontent'] = $column;
        $data['message'] = array('warning' => 'Đang cập nhật thông tin tài khoản của bạn.');
        $data['adminhpchangeinfor'] = 'true';
        $this->displayTemplate($data);
    }

    public function doChangeInfor()
    {
        $table_name = 'tbladminhp';
        $this->checkadminSession();
        $data = $this->declareTables();
        //state action: add or view or delete
        $data['adminhpchangeinfor'] = 'true';
        //get table's name
        $data['table_name'] = $table_name;
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $enumFields = element($table_name, $data['labels']);
        $password = array();
        $upload = array();
        foreach ($data['fields'] as $item) {
            if (element($item->Field, $data['column_type'])) {
                $temp = element($item->Field, $data['column_type']);
                if ($temp[0] == 'password') {
                    $this->form_validation->set_message('required', 'Trường dữ liệu <b> %s </b> không được trống.');
                    $this->form_validation->set_message('matches', '<b>Xác nhận %s </b> không khớp nhau.');
                    $fieldNameFiltered1 = element($table_name, $data['labels']);
                    $fieldNameFiltered2 = element($item->Field, $fieldNameFiltered1);
                    $this->form_validation->set_rules($item->Field, $fieldNameFiltered2, 'required|matches[re' . $item->Field . ']');
                    $this->form_validation->set_rules('re' . $item->Field, 'Xác nhận ' . $fieldNameFiltered2, 'required');
                    $password[$item->Field] = $item->Field;
                } elseif ($temp[0] == 'upload') {
                    $upload[$item->Field] = $item->Field;
                }
            } elseif (substr($item->Type, 0, 3) == 'int' || substr($item->Type, 0, 6) == 'double' || substr($item->Type, 0, 5) == 'float' || substr($item->Type, 0, 4) == 'real' || substr($item->Type, 0, 7) == 'decimal') {
                $this->form_validation->set_message('numeric', 'Trường dữ liệu <b> %s </b> phải là số.');
                $fieldNameFiltered = element($table_name, $data['labels']);
                $fieldNameFiltered = element($item->Field, $table_name);
                $this->form_validation->set_rules($item->Field, $fieldNameFiltered, 'numeric');
            }
        }
        do {
            if (element(key($enumFields), $password)) {
                $column[key($enumFields)] = md5($this->input->post(key($enumFields)));
            } elseif (element(key($enumFields), $upload)) {
                //upload
                $config['upload_path'] = './upload/';
                $config['allowed_types'] = 'mp3|gif|jpg|png|zip|rar|csv|pdf|xls|doc|jpeg|docx';
                $config['max_size'] = '100000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload(key($enumFields))) {
                    $getFileUpload = $this->upload->data();
                    $column[key($enumFields)] = 'upload/' . $getFileUpload['file_name'];
                } else {
                    //get hidden field marked for image column
                    $column[key($enumFields)] = $this->input->post('hid' . key($enumFields));
                }
                //end upload
            } else {
                $column[key($enumFields)] = $this->input->post(key($enumFields));
            }
        } while (next($enumFields));
        if ($_POST) {
            if ($this->form_validation->run() == TRUE) {
                //editing content statement
                $this->db->where('username', $_SESSION['username']);
                $this->db->update($table_name, $column);
                $sql = (array)$this->admin_model->getadminhp($table_name);
                reset($enumFields);
                if (key($enumFields)) {
                    do {
                        $column[key($enumFields)] = $sql[key($enumFields)];
                    } while (next($enumFields));
                }
                $data['editcontent'] = $column;
                $data['message'] = array('success' => 'Thông tin của bạn đã được cập nhật.');
            } else {
                $data['message'] = array('error' => validation_errors());
            }
        } else {
            $data['message'] = array('error' => 'Có lỗi xảy ra trong khi thực hiện. Dữ liệu chưa được cập nhật');
        }
        $sql = (array)$this->admin_model->getadminhp($table_name);
        reset($enumFields);
        do {
            $column[key($enumFields)] = $sql[key($enumFields)];
        } while (next($enumFields));
        $data['editcontent'] = $column;
        $this->displayTemplate($data);
    }

    public function fileManager()
    {
        $this->checkadminSession();
        $data = $this->declareTables();
        $data['file_manager'] = 'file_manager';
        $data['message'] = array('information' => 'true');
        $this->displayTemplate($data);
    }

    public function edit_success()
    {
        $this->checkadminSession();
        $data = $this->declareTables();
        $data['action'] = 'editsuccess';
        $this->displayTemplate($data);
    }

    public function dosearchcontent($table_name)
    {
        $this->checkadminSession();
        $search = $this->input->post('search');
        $compare = $this->input->post('compare');
        //init database information
        $data = $this->viewContentTables();
        //get column's meta data
        $query = $this->db->query('SHOW COLUMNS FROM ' . $table_name);
        $data['fields'] = $query->result();
        //display dropdown, radio, checkbox, upload...
        $data['column_type'] = $this->listColumnCallback($table_name);
        $limit = element($table_name, $data['row_per_page']);
        //if you does not set how many row per page, adminhp set default to 20
        if ($limit == NULL) {
            $limit = 20;
        }
        $data['rowLimit'] = $limit;
        $data['table_name'] = $table_name;
        $data['action'] = 'view';
        $data['contents'] = $this->admin_model->getresult($search, $compare, $table_name, $limit, 0);
        $data['rowCounter'] = $this->admin_model->getTotalRows($table_name);
        //$data['message']=array('warning'=>'Bạn vừa xóa bản ghi có mã là '.$id.' trong bảng '.element($table_name,$data['table_list']));
        $this->displayTemplate($data);
    }
}

?>