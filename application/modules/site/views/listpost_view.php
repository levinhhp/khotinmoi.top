<?php 
$CI = get_instance();
$CI->load->model('site/site_model');
?>
<div class="content">
    <div class="w980">     
        <div class="persion_sidebar">
            <?php $this->load->view('elements/side-bar') ?>            
        </div>
        <div class="persion_right">
            <div class="persion_sidebar_box">
                    <div class="persion_sidebar_box_top"><p><i class="fa fa-info-circle fa-fw"></i>Danh sách tin đăng</p></div>
                    <div class="persion_sidebar_box_main" style="padding:10px 15px;">                        
                        <div id="ajax_content">                    
                            <?php                         
                                $config['base_url'] = site_url('site/listPostAjax');
                                $config['total_rows'] = $CI->site_model->getListPost()->num_rows();
                                $config['per_page'] = 15;
                                $config['uri_segment'] = 3;
                                $choice = $config['total_rows'] / $config['per_page'];
                                $config['num_links'] = floor($choice);
                                $this->pagination->initialize($config);
                                $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;                                                        
                                $data['results'] = $CI->site_model->getListPostLimit($config['per_page'], $data['page']);                                                         
                                $pagination = $CI->pagination->create_links();                               
                                $data['links'] = $pagination;
                                if($this->input->post('ajax')) {
                                    $this->load->view('list_post_ajax', $data);
                                } else {
                                    $this->load->view('list_post_all', $data);
                                }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>      