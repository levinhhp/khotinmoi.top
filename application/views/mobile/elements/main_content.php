
<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$tinmoi_mobile_one = $this->site_model->gettablename_all('tblarticle','id,title,thumb,date_day,description,ordernum,status',1,'','');
$tinmoi_mobile_two = $this->site_model->gettablename_all('tblarticle','id,title,ordernum,status',8,'','');
$danhmuc_home_mobile=$CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status','','home',1);
$ads_mobile=$CI->site_model->postRamdomHome();
?>
<div id="new_mb_top_mb">    
    <?php 
        if($tinmoi_mobile_one->num_rows()>0){
        ?>
        <div class="new_mb_top_mb_img">
            <a href="<?php echo site_url(url_tt($tinmoi_mobile_one->row()->id)); ?>" title="<?php echo htmlspecialchars($tinmoi_mobile_one->row()->title);?>"><img src="<?php echo $tinmoi_mobile_one->row()->thumb;?>" title="<?php echo htmlspecialchars($tinmoi_mobile_one->row()->title);?>" alt="<?php echo htmlspecialchars($tinmoi_mobile_one->row()->title);?>"></a>
        </div>
        <a href="<?php echo site_url(url_tt($tinmoi_mobile_one->row()->id)); ?>" class="new_mb_top_mb_name" title="<?php echo htmlspecialchars($tinmoi_mobile_one->row()->title);?>"><?php echo htmlspecialchars($tinmoi_mobile_one->row()->title);?></a>
        <p class="new_mb_top_mb_content"><?php echo catchuoi($tinmoi_mobile_one->row()->description,300);?>...<a style="display:inline" href="<?php echo site_url(url_tt($tinmoi_mobile_one->row()->id)); ?>"><strong style="color:#0088CC;"> <span style="color:red;">+</span> Xem thêm</strong></a></p>   
        <p class="time"><?php echo date('d-m-Y H:i',strtotime($tinmoi_mobile_one->row()->date_day)); ?></p>     
        <div class="clearfix"></div>
        <?php 
        }
    ?>
    <ul id="new_mb_top_mb_ul">
        <?php 
            $dem_tin_moi_home = 1;
            foreach($tinmoi_mobile_two->result() as $item_tinmoi_two){
                if($dem_tin_moi_home>1){
                ?>
                <li><a href="<?php echo site_url(url_tt($item_tinmoi_two->id)); ?>" title="<?php echo htmlspecialchars($item_tinmoi_two->title); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo htmlspecialchars($item_tinmoi_two->title); ?></a></li>
                <?php 
                }
                $dem_tin_moi_home++;
            }
            $tinmoi_mobile_two->free_result();
        ?>
    </ul>        
</div>
<div class="line"></div>
<div id="ads_home">
    <?php 
        if(!empty($ads_mobile)){
            $dem_ads_mobile = 1;
            foreach($ads_mobile as $jt=>$kt){                                
                $tach_tin_news_kt = explode('-',$kt); 
                if($tach_tin_news_kt[1]=='ads'){
                    $ads_end_new_kt=$CI->site_model->gettablename_all('tblads','id,title,link,image_square,ordernum,status',1,'id',$tach_tin_news_kt[0]);  
                    if($ads_end_new_kt->num_rows()>0){
                    ?>
                    <div class="box_ads_home_mobile">                        
                        <a class="box_ads_home_mobile_img" href="<?php echo $ads_end_new_kt->row()->link; ?>" target="_blank"><img src="<?php echo $ads_end_new_kt->row()->image_square; ?>" title="<?php echo htmlspecialchars($ads_end_new_kt->row()->title); ?>" alt="<?php echo htmlspecialchars($ads_end_new_kt->row()->title); ?>"></a>
                        <a class="box_ads_home_mobile_name" href="<?php echo $ads_end_new_kt->row()->link; ?>" title="<?php echo htmlspecialchars($ads_end_new_kt->row()->title); ?>" target="_blank"><?php echo catchuoi($ads_end_new_kt->row()->title,80); ?></a>
                    </div>
                    <?php
                    }
                }elseif($tach_tin_news_kt[1]=='tt'){
                    $new_end_kt=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,image_square,ordernum,status',1,'id',$tach_tin_news_kt[0]); 
                    if($new_end_kt->num_rows()>0){
                    ?>
                    <div class="box_ads_home_mobile">                        
                        <a class="box_ads_home_mobile_img" href="<?php echo site_url(url_tt($new_end_kt->row()->id)); ?>" title="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>"><img src="<?php echo $new_end_kt->row()->image_square; ?>" title="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>" alt="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>"></a>
                        <a class="box_ads_home_mobile_name" href="<?php echo site_url(url_tt($new_end_kt->row()->id)); ?>" title="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>"><?php echo catchuoi($new_end_kt->row()->title,80); ?></a>
                    </div>
                    <?php
                    }
                }  
                if($dem_ads_mobile%2==0){
                    echo '<div cllass="clearfix" style="clear:both;"></div>';
                }
                $dem_ads_mobile++;
            }
        }
    ?>            
    <div class="clearfix"></div>
</div>
<div class="line"></div>
<?php 
    $dem_cate_home = 1;
    foreach($danhmuc_home_mobile->result() as $item_home_mobile){
    ?>
    <div class="box_mobile">
        <div class="box_mobile_top">
            <a href="<?php echo site_url() ?>" title="<?php echo htmlspecialchars($item_home_mobile->category); ?>"><?php echo htmlspecialchars($item_home_mobile->category); ?></a>
        </div>
        <div class="box_mobile_main">
            <?php 
                $new_dm_mobile = $CI->site_model->gettablename_all('tblarticle','id,category,category_sub,title,description,thumb,ordernum,status',6,'category',$item_home_mobile->id);  
                $dem_cate_sub = 1;
                foreach($new_dm_mobile->result() as $item_new_dm_mobile){
                ?>
                <div class="<?php if($dem_cate_home%2==0){ echo 'box_tintuc_mobile_old';}else{ echo 'box_tintuc_mobile';} ?>">
                    <a href="<?php echo site_url(url_tt($item_new_dm_mobile->id)); ?>" class="<?php if($dem_cate_home%2==0){ echo 'box_tintuc_mobile_img_old';}else{ echo 'box_tintuc_mobile_img';} ?>" title="<?php echo htmlspecialchars($item_new_dm_mobile->title); ?>"><img src="<?php echo $item_new_dm_mobile->thumb; ?>" title="<?php echo htmlspecialchars($item_new_dm_mobile->title); ?>" alt="<?php echo htmlspecialchars($item_new_dm_mobile->title); ?>"></a>
                    <div class="box_tintuc_mobile_content">
                        <a href="<?php echo site_url(url_tt($item_new_dm_mobile->id)); ?>" class="<?php if($dem_cate_home%2==0){ echo 'box_tintuc_mobile_name_old';}else{ echo 'box_tintuc_mobile_name';} ?>" title="<?php echo htmlspecialchars($item_new_dm_mobile->title); ?>"><?php echo catchuoi($item_new_dm_mobile->title,80); ?></a>                        
                    </div>                    
                    <div class="clearfix"></div>
                </div>
                <?php                    
                    if($dem_cate_sub%2==0){
                        echo '<div class="clearfix"></div>';
                    }                  
                    $dem_cate_sub++;                  
                }
            ?>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php
    $dem_cate_home++; 
    }
    $danhmuc_home_mobile->free_result();
?>
<div class="box_mobile">
    <div class="box_mobile_top">
        <p>Tin xem nhiều</p>
    </div>
    <div class="box_mobile_main">
        <?php 
            $this->db->where('status',1);
            $this->db->order_by('view','desc');
            $this->db->limit(5);
            $this->db->select('id,category,title,thumb,description,date_day');
            $sql_xn_mobile = $this->db->get('tblarticle');
            foreach($sql_xn_mobile->result() as $item_xn_mobile){
            ?>
            <div class="box_xemnhieu_mobile">
                <a href="<?php echo site_url(url_tt($item_xn_mobile->id)); ?>" class="box_xemnhieu_mobile_img" title="<?php echo htmlspecialchars($item_xn_mobile->title); ?>"><img src="<?php echo $item_xn_mobile->thumb; ?>" title="<?php echo htmlspecialchars($item_xn_mobile->title); ?>" alt="<?php echo htmlspecialchars($item_xn_mobile->title); ?>"></a>
                <div class="box_xemnhieu_mobile_content">
                    <a href="<?php echo site_url(url_tt($item_xn_mobile->id)); ?>" class="box_xemnhieu_mobile_name" title="<?php echo htmlspecialchars($item_xn_mobile->title); ?>"><?php echo catchuoi($item_xn_mobile->title,80); ?></a>                        
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
            }
            $sql_xn_mobile->free_result();
        ?>
        <div class="clearfix"></div>
    </div>
</div>
