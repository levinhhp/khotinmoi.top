<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    { 
        parent::__construct();
    }
    function fetch_data()
    {
        if(isset($_SESSION['start_date']) && isset($_SESSION['end_date'])){
            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >=",$_SESSION['start_date']);
            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <=",$_SESSION['end_date']);
        }else{
            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d')",date('Y-m-d'));
        }
        $this->db->order_by("view", "desc");
        $query = $this->db->get("tbladdress_ip_view");
        return $query->result();
    }
    public function getStaticCategoryInAll($category_static_in,$title_static_in){        
        $ids = '';
        if(!empty($title_static_in)){
            $this->db->where('status',1);
            $this->db->like('title',$title_static_in);            
            $sql_tin_bv = $this->db->get('tblarticle');
            foreach($sql_tin_bv->result() as $item){
                $ids.=$item->id;
            }
        }            
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >=",$_SESSION['start_date']);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <=",$_SESSION['end_date']);
        if($category_static_in!=0 && $title_static_in==''){
            $this->db->where('category_id',$category_static_in);
        }elseif($title_static_in!='' && $category_static_in==0){
            $this->db->where_in('article_id',$ids); 
        }elseif($category_static_in!=0 && $title_static_in!=''){
            $this->db->where('category_id',$category_static_in);
            $this->db->where_in('article_id',$ids);            
        }
        $this->db->order_by('view','desc');
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStaticCategoryIn($category_static_in,$title_static_in,$limit, $start){
        $ids = '';
        if(!empty($title_static_in)){
            $this->db->where('status',1);
            $this->db->like('title',$title_static_in);            
            $sql_tin_bv = $this->db->get('tblarticle');
            foreach($sql_tin_bv->result() as $item){
                $ids.= $item->id;
            }
        }        
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >=",$_SESSION['start_date']);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <=",$_SESSION['end_date']);
        if($category_static_in!=0 && $title_static_in==''){
            $this->db->where('category_id',$category_static_in);
        }elseif($title_static_in!='' && $category_static_in==0){
            $this->db->where_in('article_id',$ids); 
        }elseif($category_static_in!=0 && $title_static_in!=''){
            $this->db->where('category_id',$category_static_in);
            $this->db->where_in('article_id',$ids);            
        }
        $this->db->order_by('view','desc');
        $this->db->limit($limit, $start);   
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStaticCategoryAll($category_static,$title_static){
        $ids = '';
        if(!empty($title_static)){
            $this->db->where('status',1);
            $this->db->like('title',$title_static);            
            $sql_tin_bv = $this->db->get('tblarticle');
            foreach($sql_tin_bv->result() as $item){
                $ids.=$item->id;
            }
        }            
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        if($category_static!=0 && $title_static==''){
            $this->db->where('category_id',$category_static);
        }elseif($title_static!='' && $category_static==0){
            $this->db->where_in('article_id',$ids); 
        }elseif($category_static!=0 && $title_static!=''){
            $this->db->where('category_id',$category_static);
            $this->db->where_in('article_id',$ids);            
        }
        $this->db->order_by('view','desc');
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStaticCategory($category_static,$title_static,$limit, $start){        
        $ids = '';
        if(!empty($title_static)){
            $this->db->where('status',1);
            $this->db->like('title',$title_static);            
            $sql_tin_bv = $this->db->get('tblarticle');
            foreach($sql_tin_bv->result() as $item){
                $ids.= $item->id;
            }
        }               
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        if($category_static!=0 && $title_static==''){
            $this->db->where('category_id',$category_static);
        }elseif($title_static!='' && $category_static==0){
            $this->db->where_in('article_id',$ids); 
        }elseif($category_static!=0 && $title_static!=''){
            $this->db->where('category_id',$category_static);
            $this->db->where_in('article_id',$ids);            
        }
        $this->db->order_by('view','desc');
        $this->db->limit($limit, $start);   
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStaticAll() {
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        $this->db->order_by('view','desc');
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStatic($limit, $start) {
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        $this->db->order_by('view','desc');
        $this->db->limit($limit, $start);        
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStaticAllSearch($start_date,$end_date){
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >=",$start_date);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <=",$end_date);
        $this->db->order_by('view','desc');
        $query = $this->db->get('tbladdress_ip_view');
        return $query;
    }
    public function getStaticSearch($start_date,$end_date,$limit, $start){
        $this->db->where('article_id !=',382);
        $this->db->where('article_id !=',380);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >=",$start_date);
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <=",$end_date);
        $this->db->order_by('view','desc');
        $this->db->limit($limit, $start);  
        $query = $this->db->get('tbladdress_ip_view');
        return $query;        
    }
    public function getUserByValue($table_name, $name, $value)
    {
        $this->db->where($name, $value);
        $sql = $this->db->get($table_name);
        return $sql;
    }

    public function anh_thumb($table_name, $id_new, $thumb)
    {
        $data = array(
            'thumb' => $thumb,
        );

        $this->db->where('id', $id_new);
        $this->db->update($table_name, $data);
    }

    public function getdanhmuc2($id)
    {
        $this->db->where('parent_id', $id);
        $sql = $this->db->get('tblarticle_category');
        return $sql->result();
    }

    public function show_categories($table_name, $parent_id = "0", $insert_text = "-")
    {
        $this->db->where('parent_id', $parent_id);
        $query_dq = $this->db->get($table_name);
        foreach ($query_dq->result() as $category) {
            echo("<option value='" . $category->id . "'>" . $insert_text . $category->category . "</option>");
            $this->show_categories($table_name, $category->id, $insert_text . "-");
        }
        return true;
    }

    public function getTableAll($table_name)
    {
		if($table_name == 'tblarticle' && $_SESSION['uid']!=1){
			$this->db->where('author',$_SESSION['username']);
		}
        return $this->db->get($table_name);
    }

    public function delete_image($table_name, $id)
    {
        $this->db->where('id', $id);
        $sql = $this->db->get($table_name);
        if ($sql->num_rows() > 0) {
            $this->db->where('id', $id);
            unlink($sql->row()->name);
            $this->db->delete($table_name, ['id' => $id]);
        }
    }

    public function getTableIdValue($table_name, $id, $data_key, $data_value)
    {
        $this->db->where('id', $id);
        $this->db->where($data_key,$data_value);
        $sql = $this->db->get($table_name);
        return $sql;
    }

    public function deleteMultiple($table_name, $data)
    {
        $this->db->delete($table_name, $data);
    }

    public function createTable($table_name, $data)
    {
        $this->db->insert($table_name, $data);
    }

    public function updateTable($table_name, $id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($table_name, $data);
    }

    public function getTableAllByValue($table_name, $name, $value, $name_order, $value_order)
    {
        $this->db->order_by($name_order, $value_order);
        $this->db->where($name, $value);
        return $this->db->get($table_name);
    }

    public function selectCtrl($table_name, $name, $class, $id)
    {
        echo "<select name='" . $name . "' class='" . $class . " form-control' id='" . $id . "'>";
        echo "<option value='0'>Danh mục cha</option>";
        $this->show_categories($table_name);
        echo "</select>";
    }

    public function selectCtrl_tl_e($table_name, $uid, $name1, $class1, $id1)
    {
        echo "<select name='" . $name1 . "' class='" . $class1 . "' id='" . $id1 . "'>";
        echo "<option value='0'>Danh mục cha</option>";
        $this->show_categories_tl_e($table_name, $uid);
        echo "</select>";
    }

    public function show_categories_tl_e($table_name, $uid, $parent_id1 = "0", $insert_text1 = "-")
    {
        $this->db->where('parent_id', $parent_id1);
        $query_dq1 = $this->db->get($table_name);
        foreach ($query_dq1->result() as $category1) {
            if ($uid == $category1->id) {
                echo("<option selected='selected' value='" . $category1->id . "'>" . $insert_text1 . $category1->category . "</option>");
            } else {
                echo("<option value='" . $category1->id . "'>" . $insert_text1 . $category1->category . "</option>");
            }
            $this->show_categories_tl_e($table_name, $uid, $category1->id, $insert_text1 . "-");
        }
        return true;
    }

    public function sitemap()
    {
        $doc = new DOMDocument("1.0", "utf-8");
        $doc->formatOutput = true;
        $r = $doc->createElement("urlset");
        $r->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
        $doc->appendChild($r);
        $url = $doc->createElement("url");
        $name = $doc->createElement("loc");
        $name->appendChild(
            $doc->createTextNode(cnf_link)
        );
        $url->appendChild($name);
        $changefreq = $doc->createElement("changefreq");
        $changefreq->appendChild(
            $doc->createTextNode('daily')
        );
        $url->appendChild($changefreq);
        $priority = $doc->createElement("priority");
        $priority->appendChild(
            $doc->createTextNode('1.00')
        );
        $url->appendChild($priority);
        $r->appendChild($url);
        //Danhmuc b�i vi?t 1
        $this->db->where('status', 1);
        $cate = $this->db->get('tblarticle_category');
        if ($cate->num_rows() > 0) {
            foreach ($cate->result() as $row) {
                $url = $doc->createElement("url");

                $name = $doc->createElement("loc");
                $name->appendChild(
                    $doc->createTextNode(site_url(danhmucbaiviet($row->id)))
                );
                $url->appendChild($name);

                $changefreq = $doc->createElement("changefreq");
                $changefreq->appendChild(
                    $doc->createTextNode('daily')
                );
                $url->appendChild($changefreq);

                $priority = $doc->createElement("priority");
                $priority->appendChild(
                    $doc->createTextNode('1.00')
                );
                $url->appendChild($priority);

                $r->appendChild($url);
            }
        }
        //baiviet
        $this->db->where('status', 1);
        $cate = $this->db->get('tblarticle');
        if ($cate->num_rows() > 0) {
            foreach ($cate->result() as $row) {
                $url = $doc->createElement("url");

                $name = $doc->createElement("loc");
                $name->appendChild(
                    $doc->createTextNode(site_url(url_tt($row->id)))
                );
                $url->appendChild($name);

                $changefreq = $doc->createElement("changefreq");
                $changefreq->appendChild(
                    $doc->createTextNode('daily')
                );
                $url->appendChild($changefreq);

                $priority = $doc->createElement("priority");
                $priority->appendChild(
                    $doc->createTextNode('1.00')
                );
                $url->appendChild($priority);

                $r->appendChild($url);
            }
        }        
        $doc->save("sitemap.xml");
    }

    public function tag($tag0, $id_new, $categories)
    {
        $tag1 = explode(",", $tag0);
        foreach ($tag1 as $tag) {
            //  $tag = trim($tag);
            //Lay id cua tag c? t?n l? $tag, neu ko c? th? th?m moi
            // $this->db->where('tag',$tag);
            $sql = $this->db->get('tag');
            if ($sql->num_rows() > 0) {
                $ok = 0;
                foreach ($sql->result() as $s) {
                    if ($s->tag == $tag) {
                        $id_tag = $s->id;
                        $ok = 1;
                        break;
                    }
                }
                if ($ok == 0) {
                    $data = array(
                        'tag' => $tag,
                    );
                    $this->db->insert('tag', $data);
                    $id_tag = $this->db->insert_id();
                }
                // if($sql->row()->tag==$tag)
//							 {
//							 $id_tag=$sql->row()->id;
//							 }
//							 else
//							 {
//							 $data=array(
//										 'tag'=>$tag,
//										 );
//							 $this->db->insert('tag',$data);
//							 $id_tag= mysql_insert_id();	 
//							 }
            } else {
                $data = array(
                    'tag' => $tag,
                );
                $this->db->insert('tag', $data);
                $id_tag = mysql_insert_id();
            }
            $data = array(
                'idnew' => $id_new,
                'idtag' => $id_tag,
                'categories' => $categories,
            );
            $this->db->insert('tag_new', $data);
        }//end if tag
    }

    public function edittag($tag0, $id_new, $categories)
    {
        $this->db->where('idnew', $id_new);
        $this->db->where('categories', $categories);
        $this->db->delete('tag_new');
        $tag1 = explode(",", $tag0);
        /*print_r($arrtags);*/
        foreach ($tag1 as $tag) {
            $tag = trim($tag);
            //Lay id cua tag c? t?n l? $tag, neu ko c? th? th?m moi
            // $this->db->where('tag',$tag);
            $sql = $this->db->get('tag');
            if ($sql->num_rows() > 0) {
                $ok = 0;
                foreach ($sql->result() as $s) {
                    if ($s->tag == $tag) {
                        $id_tag = $s->id;
                        $ok = 1;
                        break;
                    }
                }
                if ($ok == 0) {
                    $data = array(
                        'tag' => $tag,
                    );
                    $this->db->insert('tag', $data);
                    $id_tag = $this->db->insert_id();
                }


                $data = array(
                    'idnew' => $id_new,
                    'idtag' => $id_tag,
                    'categories' => $categories,
                );
                $this->db->insert('tag_new', $data);
            } else {
                $data = array(
                    'tag' => $tag,
                );
                $this->db->insert('tag', $data);
                $id_tag = mysql_insert_id();
                $data = array(
                    'idnew' => $id_new,
                    'idtag' => $id_tag,
                    'categories' => $categories,
                );
                $this->db->insert('tag_new', $data);
            }
        }//end if tag
    }

    public function adminLogin($username, $password)
    {
        $this->db->where('status', 1);
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $sql = $this->db->get('tbladmin');
        return $sql->row();
    }

    public function getresult($search, $compare, $tableName, $limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $this->db->like($compare, $search); // Produces: WHERE seach LIKE '%compare%'
        $sql = $this->db->get($tableName);
        return $sql->result();
    }

    public function getContentCheck($tableName,$status, $limit, $offset){
        $this->db->order_by('id','desc');
        if($_SESSION['username']!='admin'){
            $this->db->where('author',$_SESSION['username']);
        }
        $this->db->where('status',$status);
        $sql = $this->db->get($tableName);
        return $sql->result();    
    }

    public function getTotalCheckRows($tableName,$status){        
        if($_SESSION['username']!='admin'){
            if($tableName == 'tblarticle'){
                $this->db->where('author',$_SESSION['username']);
            }
        }
        $this->db->where('status',$status);
        $this->db->from($tableName);
        return $this->db->count_all_results();
    }

    public function getContentToDay($tableName, $limit, $offset){
        if($_SESSION['username']!='admin'){
            $this->db->where('author',$_SESSION['username']);
        }
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        $sql = $this->db->get($tableName);
        return $sql->result();
    }

    public function getTotalToDayRows($tableName){
        if($_SESSION['username']!='admin'){
            if($tableName == 'tblarticle'){
                $this->db->where('author',$_SESSION['username']);
            }
        }
        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        $this->db->from($tableName);
        return $this->db->count_all_results();
    }

    public function getContent($tableName, $limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        if($_SESSION['username']!='admin'){
            if($tableName == 'tblarticle'){
                $this->db->where('author !=','admin');
            }
        }
        $sql = $this->db->get($tableName);
        return $sql->result();
    }

    public function getTotalRows($tableName)
    {
        if($_SESSION['username']!='admin'){
            if($tableName == 'tblarticle'){
                $this->db->where('author !=','admin');
            }
        }
        $this->db->from($tableName);
        return $this->db->count_all_results();
    }

    public function getEditRow($tableName, $id)
    {
        $this->db->where('id', $id);
        $sql = $this->db->get($tableName);
        return $sql->row();
    }

    public function getAdmin($tableName)
    {
        $this->db->where('username', $this->session->userdata('admin'));
        $sql = $this->db->get($tableName);
        return $sql->row();
    }

    public function getDetail($table_name, $id)
    {
        $this->db->where('id', $id);
        $sql = $this->db->get($table_name);
        return $sql->row();
    }

    public function getDetailNews($id)
    {
        $this->db->where('id', $id);
        $sql = $this->db->get('tblsinhnhat');
        return $sql->row();
    }

    public function getListnews()
    {
        $this->db->order_by('ordernum', 'desc');
        $this->db->order_by('id', 'desc');
        $sql = $this->db->get('tbl_news');
        return $sql->result();
    }

    public function getListnews_limited($limit, $offset)
    {
        $this->db->order_by('dateup', 'desc');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        $sql = $this->db->get('tbl_news');
        return $sql->result();
    }

    public function getdangky()
    {
        $this->db->order_by('ordernum', 'desc');
        $this->db->order_by('id', 'desc');
        $sql = $this->db->get('tblsinhnhat');
        return $sql->result();
    }

    public function getdangky_limited($limit, $offset)
    {
        $this->db->order_by('ordernum', 'desc');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        $sql = $this->db->get('tblsinhnhat');
        return $sql->result();
    }

    public function delete_news($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_news');
    }

    public function delete_sinhnhat($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblsinhnhat');
    }

    public function do_addsinhnhat()
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('anhbe')) {
            $name_img = '';
            $thumb = '';
        } else {
            $image_data = $this->upload->data();
            $name_img = 'upload/' . $image_data['file_name'];
            $duongdan = $image_data['file_name'];
            $config1['image_library'] = 'gd2';
            $config1['source_image'] = './upload/' . $duongdan;
            $config1['create_thumb'] = TRUE;
            $config1['maintain_ratio'] = TRUE;
            $config1['width'] = 214;
            $config1['height'] = 153;
            $this->load->library('image_lib', $config1);
            $this->image_lib->resize();
            $temp = explode('.', $image_data['file_name']);
            $thumb = 'upload/' . $temp[0] . '_thumb' . '.' . $temp[1];
            $name_img = 'upload/' . $image_data['file_name'];
        }
        $checkbox = $_POST['checkbox'];
        $countCheck = count($_POST['checkbox']);
        $del_id = '';
        for ($i = 0; $i < $countCheck; $i++) {
            $del_id = $del_id . ',' . $checkbox[$i];
        }
        $diung = $_POST['diung'];
        $countdiung = count($_POST['diung']);
        $del_du = '';
        for ($j = 0; $j < $countdiung; $j++) {
            $del_du = $del_du . ',' . $diung[$j];
        }
        $tiemphong = $_POST['tiemphongtt'];
        $counttienphong = count($_POST['tiemphongtt']);
        $del_tp = '';
        for ($k = 0; $k < $counttienphong; $k++) {
            $del_tp = $del_tp . ',' . $tiemphong[$k];
        }
        $lophoc = $_POST['lop'];
        $countlophoc = count($_POST['lop']);
        $del_lh = '';
        for ($m = 0; $m < $countlophoc; $m++) {
            $del_lh = $del_lh . ',' . $lophoc[$m];
        }
        $ngaysinh = $this->input->post('ngaysinh');
        $thangsinh = $this->input->post('thangsinh');
        $namsinh = $this->input->post('namsinh');
        $sinhnhat = $namsinh . '-' . $thangsinh . '-' . $ngaysinh;
        $data_birđay = array(
            'hotenme' => $this->input->post('hotenme'),
            'hotencha' => $this->input->post('hotencha'),
            'nghenghiepme' => $this->input->post('nghenghiepme'),
            'nghenghiepbo' => $this->input->post('nghenghiepbo'),
            'noilamviecme' => $this->input->post('noilamviecme'),
            'noilamvieccha' => $this->input->post('noilamvieccha'),
            'diachinoilamviecme' => $this->input->post('diachinoilamviecme'),
            'diachinoilamvieccha' => $this->input->post('diachinoilamvieccha'),
            'diachigiadinh' => $this->input->post('diachigiadinh'),
            'didongme' => $this->input->post('didongme'),
            'didongcha' => $this->input->post('didongcha'),
            'dienthoaigiadinh' => $this->input->post('dienthoaigd'),
            'hoten' => $this->input->post('hoten'),
            'ngaysinh' => $sinhnhat,
            'sothich' => $this->input->post('sothich'),
            'thoiquen' => $this->input->post('thoiquen'),
            'gioitinh' => $this->input->post('gioitinh'),
            'tinhtrang' => $del_id,
            'diung' => $del_du,
            'ditat' => $this->input->post('ditat'),
            'tieusubenh' => $this->input->post('tieusubenh'),
            'tiemphong' => $del_tp,
            'thongtinkhac' => $this->input->post('thongtinkhac'),
            'nguoiduadon' => $this->input->post('nguoduadon'),
            'lop' => $del_lh,
            'anh' => $name_img,
            'anh_thumb' => $thumb,
            'ngaydang' => $this->input->post('ngaydang'),
            'chuky' => $this->input->post('chuky'),
            'ordernum' => $this->input->post('thutu'),
            'status' => $this->input->post('status')
        );
        $this->db->insert('tblsinhnhat', $data_birđay);
    }

    public function do_addnews()
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000000';
        //$config['max_width']  = '0';
        //$config['max_height']  = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('anh')) {
            $name_img = '';
            $thumb = '';
        } else {
            //$image_data = $this->upload->data();
            //$name_img='upload/'.$image_data['file_name'];
            $image_data = $this->upload->data();
            //$slider='upload/'.$image_data['file_name'];
            $duongdan = $image_data['file_name'];
            $config1['image_library'] = 'gd2';
            $config1['source_image'] = './upload/' . $duongdan;
            $config1['create_thumb'] = TRUE;
            $config1['maintain_ratio'] = TRUE;
            $config1['width'] = 80;
            $config1['height'] = 63;
            $this->load->library('image_lib', $config1);
            $this->image_lib->resize();
            $temp = explode('.', $image_data['file_name']);
            $thumb = 'upload/' . $temp[0] . '_thumb' . '.' . $temp[1];
            $name_img = 'upload/' . $image_data['file_name'];
        }
        if (!$this->upload->do_upload('upslider')) {
            $name_img1 = '';
        } else {
            $image_data = $this->upload->data();
            $name_img1 = 'upload/' . $image_data['file_name'];
        }
        $datens = explode('-', $this->input->post('ngaydang'));
        $ngaydang = $datens[2] . '-' . $datens[1] . '-' . $datens[0];
        $data = array(
            'title' => $this->input->post('title'),
            'titleen' => $this->input->post('titleen'),
            'tomtat' => $this->input->post('tomtat'),
            'tomtaten' => $this->input->post('tomtaten'),
            'danhmucbaiviet' => $this->input->post('danhmucbaiviet'),
            'danhmucbaivietcap2' => $this->input->post('danhmucbaivietcap2'),
            'anh' => $name_img,
            'anh_thumb' => $thumb,
            'noidung' => $this->input->post('noidung'),
            'noidungen' => $this->input->post('noidungen'),
            'ngaydang' => $ngaydang,
            'giodang' => $this->input->post('giodang'),
            'moi' => $this->input->post('moi'),
            'hoatdong' => $this->input->post('hoatdong'),
            'slider' => $this->input->post('slider'),
            'anhslider' => $name_img1,
            'meta_title' => $this->input->post('meta_title'),
            'meta_des' => $this->input->post('meta_des'),
            'keyword' => $this->input->post('keyword'),
            'ordernum' => $this->input->post('ordernum'),
            'status' => $this->input->post('status'),
            'tag' => trim($this->input->post('tags')),
        );
        $this->db->insert('tbltintuc', $data);
        if ($this->input->post('tags')) {
            //Cat tag dua vao database
            $id_a = $this->db->insert_id();
            $arrtags = explode(",", $this->input->post('tags'));
            /*print_r($arrtags);*/
            foreach ($arrtags as $tag) {
                $tag = trim($tag);
                //Lay id cua tag c� t�n l� $tag, neu ko c� th� th�m moi
                $this->db->where('tag', $tag);
                $sql = $this->db->get('tag');
                if ($sql->num_rows() > 0) {
                    if ($sql->row()->tag == $tag) {
                        $id_tag = $sql->row()->id;
                    } else {
                        $data = array(
                            'tag' => $tag,
                        );
                        $this->db->insert('tag', $data);
                        $id_tag = mysql_insert_id();
                    }
                } else {
                    $data = array(
                        'tag' => $tag,
                    );
                    $this->db->insert('tag', $data);
                    $id_tag = mysql_insert_id();
                }
                $data = array(
                    'idnew' => $id_a,
                    'idtag' => $id_tag,
                    'categories' => 2
                );
                $this->db->insert('tag_new', $data);
            }//end if tag
        }
    }


    public function do_editnews()
    {
        $id = $this->input->post('txtid');
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('anhbe')) {
            $name_img = $this->input->post('anhbe_edit');
            $thumb = $this->input->post('anhbe_thumb');
        } else {
            $image_data = $this->upload->data();
            $name_img = 'upload/' . $image_data['file_name'];
            $duongdan = $image_data['file_name'];
            $config1['image_library'] = 'gd2';
            $config1['source_image'] = './upload/' . $duongdan;
            $config1['create_thumb'] = TRUE;
            $config1['maintain_ratio'] = TRUE;
            $config1['width'] = 80;
            $config1['height'] = 63;
            $this->load->library('image_lib', $config1);
            $this->image_lib->resize();
            $temp = explode('.', $image_data['file_name']);
            $thumb = 'upload/' . $temp[0] . '_thumb' . '.' . $temp[1];
            $name_img = 'upload/' . $image_data['file_name'];
        }
        $checkbox = $_POST['checkbox'];
        $countCheck = count($_POST['checkbox']);
        $del_id = '';
        for ($i = 0; $i < $countCheck; $i++) {
            $del_id = $del_id . ',' . $checkbox[$i];
        }
        $diung = $_POST['diung'];
        $countdiung = count($_POST['diung']);
        $del_du = '';
        for ($j = 0; $j < $countdiung; $j++) {
            $del_du = $del_du . ',' . $diung[$j];
        }
        $tiemphong = $_POST['tiemphongtt'];
        $counttienphong = count($_POST['tiemphongtt']);
        $del_tp = '';
        for ($k = 0; $k < $counttienphong; $k++) {
            $del_tp = $del_tp . ',' . $tiemphong[$k];
        }
        $lophoc = $_POST['lop'];
        $countlophoc = count($_POST['lop']);
        $del_lh = '';
        for ($m = 0; $m < $countlophoc; $m++) {
            $del_lh = $del_lh . ',' . $lophoc[$m];
        }
        $ngaysinh = $this->input->post('ngaysinh');
        $thangsinh = $this->input->post('thangsinh');
        $namsinh = $this->input->post('namsinh');
        $sinhnhat = $namsinh . '-' . $thangsinh . '-' . $ngaysinh;
        $data_birđay = array(
            'hotenme' => $this->input->post('hotenme'),
            'hotencha' => $this->input->post('hotencha'),
            'nghenghiepme' => $this->input->post('nghenghiepme'),
            'nghenghiepbo' => $this->input->post('nghenghiepbo'),
            'noilamviecme' => $this->input->post('noilamviecme'),
            'noilamvieccha' => $this->input->post('noilamvieccha'),
            'diachinoilamviecme' => $this->input->post('diachinoilamviecme'),
            'diachinoilamvieccha' => $this->input->post('diachinoilamvieccha'),
            'diachigiadinh' => $this->input->post('diachigiadinh'),
            'didongme' => $this->input->post('didongme'),
            'didongcha' => $this->input->post('didongcha'),
            'dienthoaigiadinh' => $this->input->post('dienthoaigd'),
            'hoten' => $this->input->post('hoten'),
            'ngaysinh' => $sinhnhat,
            'sothich' => $this->input->post('sothich'),
            'thoiquen' => $this->input->post('thoiquen'),
            'gioitinh' => $this->input->post('gioitinh'),
            'tinhtrang' => $del_id,
            'diung' => $del_du,
            'ditat' => $this->input->post('ditat'),
            'tieusubenh' => $this->input->post('tieusubenh'),
            'tiemphong' => $del_tp,
            'thongtinkhac' => $this->input->post('thongtinkhac'),
            'nguoiduadon' => $this->input->post('nguoduadon'),
            'lop' => $del_lh,
            'anh' => $name_img,
            'anh_thumb' => $thumb,
            'ngaydang' => $this->input->post('ngaydang'),
            'chuky' => $this->input->post('chuky'),
            'ordernum' => $this->input->post('thutu'),
            'status' => $this->input->post('status')
        );
        $this->db->where('id', $id);
        $this->db->update('tblsinhnhat', $data_birđay);
    }

    public function getGroupById($id)
    {


        $this->db->where('status', 0);


        $this->db->where('id', $id);


        $sql = $this->db->get('tbl_group');


        return $sql->row();


    }


    public function getCateById($id)


    {


        $this->db->where('status', 0);


        $this->db->where('id', $id);


        $sql = $this->db->get('tbl_categories');


        return $sql->row();


    }


    public function getGroup2()


    {


        $this->db->where('status', 0);


        $sql = $this->db->get('tbl_group');


        return $sql->result();


    }


}


?>