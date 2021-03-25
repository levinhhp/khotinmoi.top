<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$category_end=$CI->site_model->gettablename_all('tblarticle_category','id,category,ordernum,status','','page_sub',1);
$bread_crumbs = $CI->site_model->gettablename_all('tblarticle_category','id,category,parent_id,ordernum,status',1,'id',$query1->category);
if($query1->categgory_sub >0){    
    $tincung_loai = $CI->site_model->gettablename_all('tblarticle','id,category,title,date_day,description,thumb,ordernum,status',5,'category',$query1->categgory_sub);
}else{
    $tincung_loai = $CI->site_model->gettablename_all('tblarticle','id,category,title,date_day,description,thumb,ordernum,status',5,'category',$query1->categgory);
}
if(isset($dm)){    
    $sqldanhmucdmv= $CI->site_model->getTableParent(0,'tblarticle_category','id,category,parent_id,ordernum,status','','id',$dm);
    if($sqldanhmucdmv->num_rows()>0){                                                                                                                                                            
        $query1=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,thumb,description,content,thumb,thumb,ordernum,status',1,'category',$dm)->row();
    }else{        
        $query1=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,thumb,description,content,thumb,thumb,ordernum,status',1,'category_sub',$dm)->row();
    }    
}
?>
<div id="content_mobile">
    <?php $this->load->view('mobile/elements/ads_slider') ?>
    <div id="content_read">
        <div class="box_mobile">
            <div class="box_mobile_top" style="border-left:none;border-right:none;border-top:none;">
                <?php 
                    if($bread_crumbs->num_rows()>0){
                    ?>
                    <ul id="bread_crumbs">
                        <li><a href="<?php echo site_url(danhmucbaiviet($bread_crumbs->row()->id)); ?>" title="<?php echo $bread_crumbs->row()->category; ?>"><?php echo $bread_crumbs->row()->category; ?></a></li>                                                                                                                
                        <li><div style="float:right;" class="fb-like" data-href="<?php echo site_url(url_tt($query1->id)); ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div></li>
                        <div class="clearfix"></div>
                    </ul>
                    <?php 
                    }
                ?> 
            </div>
            <div id="content_nd">
                <h1 class="article-title"><?php echo $query1->title; ?></h1>
                <div class="date-time"><?php echo date('d-m-Y H:i',strtotime($query1->date_day)); ?></div>
                <h2 class="sapo"><?php echo $query1->description; ?></h2>  
                <div class="tincungload_ct">                                 
                    <ul>
                        <?php 
                            foreach($tincung_loai->result() as $item_tin_cl){                        
                            ?>
                            <li><a href="<?php echo site_url(url_tt($item_tin_cl->id)); ?>" title="<?php echo $item_tin_cl->title; ?>" href=""><?php echo $item_tin_cl->title; ?></a></li>
                            <?php
                            }
                            $tincung_loai->free_result();
                        ?>                      
                    </ul>
                </div>
                <div id="content_mid">
                    <?php echo $query1->content; ?>
                </div>
                <!--Chia Sẻ-->
                  <div id="chiase">                  	  
                      <div class="addthis_toolbox addthis_default_style " style="padding-top:5px;width:auto;height:auto;clear:both;">                          
                          <!-- AddThis Button BEGIN -->
                          <div class="addthis_toolbox addthis_default_style" style="float:left;">
                              <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                              <a class="addthis_button_tweet"></a>
                          <script type="text/javascript">
                          var GoShareType = "govnShareLink";
                          function share_zing() { var u = location.href; window.open("https://link.apps.zing.vn/share?u=" + encodeURIComponent(u)); }
                          </script>
                          <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>

                          <a class="addthis_counter addthis_pill_style"></a>

                   </div>
                          <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4eae23e6468992a2"></script>
<script src="https://sp.zalo.me/plugins/sdk.js"></script>
                          <!-- AddThis Button END -->
<div class="zalo-share-button" data-href="<?php echo site_url(url_tt($query1->id)); ?>" data-oaid="579745863508352884" data-layout="1" data-color="blue" data-customize=false></div>
                      </div>					 
                   </div>
                  <!--Chia Sẻ-->     
                <div class="tags-container" style="margin-top:0px;"> 
                    <?php 
                        $this->db->where('categories','2');
                        if(empty($query1))
                        {
                            $this->db->where('idnew',$query1->id);
                        }
                        else
                        {
                            $this->db->where('idnew',$query1->id);
                        }
                        $tag=$this->db->get('tag_new');
                        if($tag->num_rows()>0){
                        ?>   
                        <ul class="tags-wrapper">
                            <?php 
                                foreach($tag->result() as $tag){
                                    $this->db->where('id',$tag->idtag);
                                    $tagname=$this->db->get('tag');
                                    if($tagname->num_rows()>0){
                                        $tagname1=$tagname->row();
                                        {
                                        ?>
                                        <li class="tags-item"><a href="<?php echo site_url('/site/getnewsByTag/'.$tagname1->id.'/'.url_title($tagname1->tag));  ?>" title="<?php echo $tagname1->tag;?>"><?php echo $tagname1->tag;?></a></li>
                                        <?php
                                        }
                                    }
                                }                
                            ?>                       
                        </ul>
                        <?php 
                        }
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="line"></div>
                <div id="fb" style="width:100%;">       
                    <div id="fb-root"></div>                            
                    <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                    <fb:comments href="<?php echo site_url(url_tt($query1->id)); ?>" num_posts="2" width="100%"></fb:comments>
                    <script>FB.XFBML.parse();</script>
                </div>
            </div>
            <div id="list-news1_all">
                <?php $this->load->view('mobile/elements/ads') ?>
            </div>
        </div>
    </div>
</div>
    <div class="clearfix"></div>
</div>