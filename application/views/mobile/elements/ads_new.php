<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$tin_moi=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,thumb,description,ordernum,status',9,'','');
if(isset($ct)){
    $sql_tin_ct=$CI->site_model->gettablename_all('tblarticle','id,category,ordernum,status','','id',$ct);
    if($sql_tin_ct->num_rows()>0){
        $adsNews = $CI->site_model->postNewsAds($sql_tin_ct->row()->category);
    }
}elseif(isset($dm)){
    $adsNews = $CI->site_model->postNewsAds($dm);    
}
?>
<div class="box_xem_nhieu_detail_column23">
            <div class="box-worldcup-2018 typeother">
                <p class="title-box box-new-title">Tin mới</p>
                <?php                 
                    if(!empty($adsNews)){                        
                        $dem_moi = 1;                        
                     ?>
                    <ul>  
                        <?php 
                            foreach($adsNews as $j=>$k){                                
                                $tach_tin_news = explode('-',$k); 
                                if($tach_tin_news[1]=='ads'){
                                    $ads_end_new=$CI->site_model->gettablename_all('tblads','id,title,link,thumb,ordernum,status',1,'id',$tach_tin_news[0]);   
                                ?>                                
                                <li>
                                    <a target="_blank" href="<?php echo $ads_end_new->row()->link; ?>" title="<?php echo $ads_end_new->row()->title; ?>" class="img120x75 pos-rlt" >
                                        <img class="img120x75" src="<?php echo $ads_end_new->row()->thumb; ?>" alt="<?php echo $ads_end_new->row()->title; ?>" title="<?php echo $ads_end_new->row()->title; ?>">
                                        <span class="number"><?php echo $dem_moi; ?></span>
                                    </a>
                                    <div class="title-box-wc-2018"><a href="<?php echo $ads_end_new->row()->link; ?>" title="<?php echo $ads_end_new->row()->title; ?>"><?php echo catchuoi($ads_end_new->row()->title,80); ?></a></div>
                                    <span class="timeago"></span>
                                    <div class="clearfix"></div>
                                </li>  
                                <?php
                                }elseif($tach_tin_news[1]=='tt'){
                                    $new_end=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,thumb,ordernum,status',1,'id',$tach_tin_news[0]); 
                                    if($new_end->num_rows()>0){
                                    ?>      
                                    <li class="xem_nhieu_popup" data-id="<?php echo $new_end->row()->id; ?>">
                                        <a style="cursor:pointer" title="<?php echo $new_end->row()->title; ?>" class="img120x75 pos-rlt" >
                                            <img class="img120x75" src="<?php echo $new_end->row()->thumb; ?>" alt="<?php echo $new_end->row()->title; ?>" title="<?php echo $new_end->row()->title; ?>">
                                            <span class="number"><?php echo $dem_moi; ?></span>
                                        </a>
                                        <div class="title-box-wc-2018"><a style="cursor:pointer" title="<?php echo $new_end->row()->title; ?>"><?php echo catchuoi($new_end->row()->title,80); ?></a></div>
                                        <span class="timeago"><?php echo get_time(strtotime($new_end->row()->date_day)); ?></span>
                                        <div class="clearfix"></div>
                                    </li>  
                                <?php 
                                    }
                                }
                            $dem_moi++;
                            }
                            $tin_moi->free_result();
                        ?>                                                 
                    </ul>
                    <?php 
                    }
                ?>
        <div class="clearfix"></div>
            </div>
    
        
</div>