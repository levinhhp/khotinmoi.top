<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
    if($query->num_rows()>0){        
$category_end=$CI->site_model->gettablename_all('tblarticle_category','id,category,ordernum,status','','page_sub',1);
$bread_crumbs = $CI->site_model->gettablename_all('tblarticle_category','id,category,parent_id,ordernum,status',1,'id',$query->row()->category);
$tin_moi=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,thumb,description,ordernum,status',9,'','');
if($query->row()->categgory_sub >0){    
    $tincung_loai = $CI->site_model->gettablename_all('tblarticle','id,category,category_sub,title,date_day,description,thumb,ordernum,status',5,'category_sub',$query->row()->categgory_sub);
}else{
    $tincung_loai = $CI->site_model->gettablename_all('tblarticle','id,category,title,date_day,description,thumb,ordernum,status',5,'category',$query->row()->categgory);
}
    ?>
	<div class="content">
	 <div class="content-detail column-2" id="main-detail"> 
	<section class="detail-w fl">
    <div id="mainContentDetail">    
                <div class="title-content clearfix first">
            <div class="content-left fl">                
                <div class="bread-crumbs fl">
                    <?php 
                        if($bread_crumbs->num_rows()>0){
                        ?>
                        <ul>
                            <li class="fl" style="padding-bottom:12px;"><a href="<?php echo site_url(danhmucbaiviet($bread_crumbs->row()->id)); ?>" title="<?php echo $bread_crumbs->row()->category; ?>"><?php echo $bread_crumbs->row()->category; ?></a></li>                                                                                                                
                            <li><div style="float:right;margin-top:0px;" class="fb-like" data-href="<?php echo site_url(url_tt($query->row()->id)); ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div></li>
                        </ul>
                        <?php 
                        }
                    ?> 
                    <div class="clearfix"></div>                   
                </div>                
            </div>            
        </div>                
                    <h1 style="text-align:left;" class="article-title"><?php echo $query->row()->title; ?></h1>
                    <p class="post_link" style="text-align:left;"><i class="fa fa-link" aria-hidden="true"></i><a title="<?php echo htmlspecialchars($query->row()->title); ?>" href="<?php echo site_url(url_tt($query->row()->id)); ?>" target="_blank">&nbsp;<?php echo site_url(url_tt($query->row()->id)); ?></a></p>
                <div class="date-time" style="text-align:left;"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d-m-Y H:i',strtotime($query->row()->date_day)); ?>             
            </div>
                
<div class="column-first-second">

    <div class="main-content-body">
        <h2 class="sapo" style="text-align:left;"><?php echo $query->row()->description; ?></h2>  
        <?php 
            if($tincung_loai->num_rows()>0){
        ?>      
            <div class="relate-container">                                 
                <ul>
                <?php 
                    foreach($tincung_loai->result() as $item_tin_cl){                        
                    ?>
                    <li class="xem_nhieu_popup" data-id="<?php echo $item_tin_cl->id; ?>"><a style="cursor: pointer;" title="<?php echo htmlspecialchars($item_tin_cl->title); ?>"><?php echo htmlspecialchars($item_tin_cl->title); ?></a></li>
                    <?php
                    }
                    $tincung_loai->free_result();
                ?>                      
                </ul>
            </div>
            <?php 
            }
        ?>
        <div class="content fck" id="main-detail-body" style="text-align:left;">            
        <?php echo $query->row()->content; ?>
        
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
                    
<div class="tags-container" style="margin-top:0px;"> 
    <?php 
        $this->db->where('categories','2');
        if(empty($query1))
        {
            $this->db->where('idnew',$query->row()->id);
        }
        else
        {
            $this->db->where('idnew',$query->row()->id);
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
</div>
                    <div class="clearfix"></div>
                    
                    
                    <div class="tagandtopicandbanner">
                        
                        
                        <div class="clearfix"></div>
                        <span class="line mgt16"></span>
                        <div class="clearfix"></div>
                        

                        <div id="fb" style="width:100%;">       
    	                    <div id="fb-root"></div>                            
                            <script src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                            <fb:comments href="<?php echo site_url(url_tt($query->row()->id)); ?>" num_posts="2" width="100%"></fb:comments>
                            <script>FB.XFBML.parse();</script>
                        </div>
                        
                    </div>
                    
                </div>
				</section>                
                <div class="clearfix"></div>
				</div>
                <div id="list-news1_all">                   
                <?php 
                $data['ct'] = $query->row()->id;
                $this->load->view('elements/modal_ads',$data) ?>
            </div>
			</div>
    <?php
    }
?>
<script type="text/javascript">
    jQuery(document).ready(function () {                
        jQuery(".xem_nhieu_popup").click(function(){                    
            var id = jQuery(this).attr('data-id');                    
            jQuery.ajax({
                cache:false,
                type:"POST",
                data:{id : id},
                url:"<?php echo site_url('site/showPopup'); ?>", 
                success:function(html){
                    jQuery("#load_popup").html(html);                            
                    //showPopup();                   
                }                                                          
            });                 
        });                  
                                                                       
    });     
</script>        