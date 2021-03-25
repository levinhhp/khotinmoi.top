<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Api extends FrontEndController
{
    public function api_footer(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchSingle'){
            $result = $this->site_model->gettablename('tblinformation','company_name,logo,phone,fb_url,instagram_url,g_plus_url,youtube','');
            $data['logo'] = '<a href="'.base_url().'" title="'.$result->company_name.'"><img title="'.$result->company_name.'" alt="'.$result->company_name.'" src="frontend/images/logo_footer.webp"></a>';
            $data['phone'] = '<a href="tel:'.$result->phone.'" title="'.$result->phone.'"><i class="fa fa-phone-square" aria-hidden="true"></i></a>';
            $data['fb_url'] = '<a href="'.$result->fb_url.'" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
            $data['instagram_url'] = '<a href="'.$result->instagram_url.'" title="Intasgram"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
            $data['g_plus_url'] = '<a href="'.$result->g_plus_url.'" title="G+"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
            $data['youtube'] = '<a href="'.$result->youtube.'" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>';
            $data['fanpage'] = '<div class="fb-like-box" data-href="'.$result->fb_url.'" data-width="275" data-height="185" data-show-faces="true" data-stream="false" data-border-color="#ffffff" data-header="false"></div>';
            $data['footer_copy_text'] = '<p>© 2020 khotinmoi.com . All rights reserved.</p>
            <p>® Trang tin tức được nhiều người xem nhất</p>';
            echo json_encode($data);    
        }
    }

    public function api_header(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchFooter'){
            $result = $this->site_model->gettablename('tblinformation','company_name,logo','');
            $data['logo'] = '<a href="'.base_url().'" title="'.$result->company_name.'"><img src="'.$result->logo.'" title="'.$result->company_name.'" alt="'.$result->company_name.'"></a>';
            echo json_encode($data); 
        }        
    }

    public function api_newspost(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchNewPost'){
            $result=$this->site_model->gettablename_all('tblarticle','id,title,image,thumb,description,ordernum,status',1,'','');
            $data['tin_tuc_one']='<a href="'.site_url(url_tt($result->row()->id)).'" title="'.$result->row()->title.'"><img src="'.$result->row()->image.'" title="'.$result->row()->title.'" alt="'.$result->row()->title.'"></a>
            <a href="'.site_url(url_tt($result->row()->id)).'" class="tin_tuc_one_name">'.$result->row()->title.'&nbsp;<img src="frontend/images/new.gif"></a>
            <p>'.catchuoi($result->row()->description,300).'</p>';
            echo json_encode($data); 
        }        
    }

    public function api_news2(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchNewPost2'){
            $result=$this->site_model->gettablename_all('tblarticle','id,title,ordernum,status',8,'','');
            $dem_new2 = 1;
            foreach($result->result() as $row){
                if($dem_new2>1){
                    $data[]=[
                        'id'    => $row->id,
                        'title'=> '<i class="fa fa-angle-double-right" aria-hidden="true"></i>'.htmlspecialchars($row->title),
                        'link' => site_url(url_tt($row->id))                    
                    ];
                }
                $dem_new2++;
            }
            echo json_encode($data); 
        }   
    }

    public function api_noibat(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchAllNoiBat'){
            $dem_old = 1;
            $result = $this->site_model->gettablename_all('tblarticle','id,title,thumb,description,ordernum,status',6,'noibat',1);
            foreach($result->result() as $row){   
                if($dem_old==6){
                    $old = 'noibat_home_box event';
                }else{
                    $old='noibat_home_box';
                }             
                $data[]=[
                    'id'    => $row->id,
                    'title'=> htmlspecialchars($row->title),
                    'thumb' => $row->thumb,
                    'link' => site_url(url_tt($row->id)),
                    'cat_title' => catchuoi($row->title,80) ,
                    'old' =>$old                   
                ]; 
                $dem_old++;                          
            }
            echo json_encode($data); 
        }        
    }

    public function api_news_ct(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchNewCt'){
            $result=$this->site_model->gettablename_all('tblarticle','id,title,description,content,date_day,ordernum,status',1,'id',$received_data->id);
            if($result->num_rows()>0){
                $data['article_title'] = htmlspecialchars($result->row()->title);
                $data['date_time'] = '<i class="fa fa-calendar" aria-hidden="true"></i> '.date('d-m-Y H:i',strtotime($result->row()->date_day));
                $data['description'] = htmlspecialchars($result->row()->description);
                $data['content'] = $result->row()->content;
                $data['chiase'] = '<div class="addthis_toolbox addthis_default_style" style="padding-top:5px;width:auto;height:auto;clear:both;">                                          
                <div class="addthis_toolbox addthis_default_style" style="float:left;">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>                                                    
                <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                <a class="addthis_counter addthis_pill_style"></a>
                </div>                               
                <div class="zalo-share-button" data-href="'.site_url(url_tt($result->row()->id)).'" data-oaid="579745863508352884" data-layout="1" data-color="blue" data-customize=false></div>
            </div>			
                ';
                $data['facebook_comment'] = site_url(url_tt($result->row()->id));
            }
            echo json_encode($data); 
        }    
    }

    public function api_tag(){
        $received_data = json_decode(file_get_contents("php://input"));
        $data = array();
        if($received_data->action == 'fetchAllTag'){
            $this->db->where('categories','2');
            $this->db->where('idnew',$received_data->id);
            $tag=$this->db->get('tag_new');
            if($tag->num_rows()>0){
                foreach($tag->result() as $tag){
                    $this->db->where('id',$tag->idtag);
                    $tagname=$this->db->get('tag');
                    if($tagname->num_rows()>0){
                        $tagname1=$tagname->row();
                        $data[]=[
                            'tag_name' => $tagname1->tag,
                            'tag_link' => site_url('/site/getnewsByTag/'.$tagname1->id.'/'.url_title($tagname1->tag))
                        ];
                    }
                }
            }
            echo json_encode($data); 
        }
    }
}
?>