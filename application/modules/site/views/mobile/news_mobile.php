<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$tin_moi_category=$CI->site_model->gettablename_all('tblarticle','id,title,thumb,description,ordernum,status',7,'','');
$category_end=$CI->site_model->gettablename_all('tblarticle_category','id,category,ordernum,status','','page_sub',1);
$ads=$CI->site_model->gettablename_all('tblads','id,title,thumb,ordernum,status',2,'','');
?>
<div id="content_mobile">
    <?php $this->load->view('mobile/elements/ads_slider') ?>
    <div id="content_read">
        <div class="box_mobile">
            <div class="box_mobile_top" style="border-left:none;border-right:none;border-top:none;">
                    <?php 
                    if(isset($dm)){
                        $danhmuc = $CI->site_model->gettablename_all('tblarticle_category','id,category',1,'id',$dm);
                    ?>
                    <h1><a href="<?php echo site_url(danhmucbaiviet($danhmuc->row()->id)); ?>" title="<?php echo $danhmuc->row()->category; ?>"><?php echo $danhmuc->row()->category; ?></a></h1>
                    <?php 
                    }
                ?>     
            </div>
            <div id="content_nd">
            <?php 
                    if($query->num_rows() > 0){
                    ?>
                    <ul class="list-news-content">
                        <?php 
                            foreach($query->result() as $item_query){
                            ?>
                            <li class="news-item">
                                
                                <a title="<?php echo $item_query->title; ?>" class="list-news-content-img" href="<?php echo site_url(url_tt($item_query->id)); ?>">
                                    <img class="img212x132" src="<?php echo $item_query->thumb; ?>" alt="<?php echo $item_query->title; ?>" title="<?php echo $item_query->title; ?>">
                                </a>
                                
                                <div class="name-news">
                                    <h3 class="title-news">
                                    <a title="<?php echo $item_query->title; ?>" href="<?php echo site_url(url_tt($item_query->id)); ?>"><?php echo $item_query->title; ?></a>
                                    </h3>
                                    <p class="sapo" rel="3"><?php echo catchuoi($item_query->description,280); ?></p>                                            
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <?php 
                            }
                            $query->free_result();
                        ?>                                
                    </ul>
                    <aside class="wp-pagenavi">
                        <nav class="pagination">
                            <?php echo $pagination;?>
                        </nav>
                </aside>
                    <?php 
                    }else{
                        ?>
                        <p style="text-align:center;">Dữ liệu đang cập nhật</p>
                        <?php
                    }
                    if(isset($dm)){                        
                        $theh = $CI->site_model->gettablename_all('tblarticle_category','id,category,heading,ordernum,status',1,'id',$dm)->row();                        
                    ?>                
                    <div id="theh">
                        <p style="font-size:18px !important;line-height:35px;border-bottom:1px solid #ddd;">Các từ khóa</p>
                        <div style="padding-top:5px;">
                            <?php echo $theh->heading; ?>
                        </div>
                    </div>
                    <?php 
                    }
                ?>                
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>