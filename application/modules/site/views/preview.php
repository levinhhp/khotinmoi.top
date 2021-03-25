<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$category_end=$CI->site_model->gettablename_all('tblarticle_category','id,category,ordernum,status','','page_sub',1);
$tin_moi=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,thumb,description,ordernum,status',9,'','');
$tincung_loai = $CI->site_model->gettablename_all('tblarticle','id,category,title,date_day,description,thumb,ordernum,status',5,'category',$_SESSION['category_id']);
$adsSlider = $CI->site_model->postRamdom($query1->category);
?>
<div style="background:#fff;" class="w980">
    <?php 
    $data['dm'] = $_SESSION['category_id'];
    $this->load->view('elements/ads_slider',$data) 
    ?>
<div id="crudApp">
<div class="content w980">
        <div class="content-detail column-2" id="main-detail">              
            <section class="detail-w fl">
                <div id="mainContentDetail">    
                <div class="title-content clearfix first">
            <div class="content-left fl">                
                <div class="bread-crumbs fl">                   
                        <ul>
                            <li class="fl" style="padding-bottom:12px;"><a href="<?php echo site_url(danhmucbaiviet($_SESSION['category_id'])); ?>" title="<?php echo $_SESSION['category']; ?>"><?php echo $_SESSION['category']; ?></a></li>                                                                                                                                            
                            <li><div style="float:right;margin-top:7px;" class="fb-like" data-href="<?php echo site_url(url_tt('site/preview')); ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div></li>
                        </ul>                        
                    <div class="clearfix"></div>                   
                </div>                
            </div>            
        </div>                
                    <h1 class="article-title"><?php echo $_SESSION['title']; ?></h1>
                <div class="date-time"><?php echo date('d-m-Y',strtotime($_SESSION['date_day'])).' '.$_SESSION['post_time']; ?>             
            </div>
                
<div class="column-first-second">

    <div class="main-content-body">
        <p class="sapo"><strong><?php echo $_SESSION['description']; ?></strong></p>  
        <?php 
            if($tincung_loai->num_rows()>0){
        ?>      
            <div class="relate-container">                                 
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
            <?php 
            }
        ?>
        <div class="content fck" id="main-detail-body">            
        <?php echo $_SESSION['content']; ?>
        
    </div>

</div>



                </div>
                
                <div class="clearfix"></div>
                
                <div class="tagandnetwork" id="tagandnetwork">                   			
<!--Chia Sẻ-->
<div id="chiase">                  	  
                      <!-- AddThis Button BEGIN @@ Chèn vào chổ mà bạn muốn nó hiển thị -->
<div class="addthis_toolbox addthis_default_style">
<a class="addthis_button_google"></a>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_yahoobkm"></a>
<a class="addthis_button_zingme"></a>
<a class="addthis_button_govn"></a>
<a class="addthis_button_email"></a>
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f50c8104ae535bf"></script>
<!-- AddThis Button END -->		 
                   </div>
                  <!--Chia Sẻ-->

                    <div class="clearfix"></div>
                    
                    <div class="tagandtopicandbanner">
                        
                        
                        <div class="clearfix"></div>
                        <span class="line mgt16"></span>
                        <div class="clearfix"></div>
                        

                        <div id="fb" style="width:100%;">       
    	                    <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <html xmlns:fb="http://ogp.me/ns/fb#">
                                <fb:comments href="<?php echo site_url('site/preview'); ?>" width="100%" num_posts="10" ></fb:comments>
                            </html>
                            <!--fb-->
                        </div>
                        
                    </div>
                    
                </div>                            
            </section>
            
                <!-- <section class="slidebar fr">
                    
                    <div class="area1">
                        <div class="bannerright1" style="margin-top: -7px;">                            
                        <div class="area1_2">
                        
                           <?php 
                           $data['dm'] = $_SESSION['category_id'];
                           $this->load->view('elements/ads_new',$data)?>
                        </div>
                
                        <div class="area1_2">
                            <div class="box_xem_nhieu_detail_column23">
    
            <div class="box-worldcup-2018 typeother">
                <p class="title-box box-new-title" title="Xem nhiều">Xem nhiều</p>
                <?php 
                     $this->db->where('status',1);
                     $this->db->order_by('view','desc');
                     $this->db->limit(5);
                     $this->db->select('id,title,thumb,date_day');
                     $xemnhieu = $this->db->get('tblarticle');
                     if($xemnhieu->num_rows()>0){
                         $dem_xn = 1;
                    ?>
                    <ul>   
                        <?php 
                            foreach($xemnhieu->result() as $item_xn){
                            ?>     
                            <li class="xem_nhieu_popup" data-id="<?php echo $item_xn->id; ?>">
                                <a style="cursor:pointer" title="<?php echo $item_xn->title; ?>" class="img120x75 pos-rlt">
                                    <img class="img120x75" src="<?php echo $item_xn->thumb; ?>">
                                    <span class="number"><?php echo $dem_xn; ?></span>
                                </a>
                                <div class="title-box-wc-2018"><a style="cursor:pointer" title="<?php echo $item_xn->title; ?>"><?php echo $item_xn->title; ?></a></div>
                                <span class="timeago"><?php echo get_time(strtotime($item_xn->date_day)); ?></span>
                                <div class="clearfix"></div>
                            </li>   
                            <?php 
                            $dem_xn++;
                            }
                            $xemnhieu->free_result();
                        ?>                 
                    </ul>
                <?php 
                    }
                ?>
                <div class="clearfix"></div>
            </div>
    
        

                        </div>
                    </div>
                    
                    
                </section>
             -->
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>                                 
            <div id="list-news1_all">
                <?php 
                $data['dm'] = $_SESSION['category_id'];
                $this->load->view('elements/ads',$data) ?>
            </div>
        <div class="clearfix"></div>
        </div>		
    </div>	
</div>
                      
           
        </div>
    </div>
                </div>
    <div class="clearfix"></div>                  
</div>       
<?php $this->load->view('modal/detail_modal') ?>         