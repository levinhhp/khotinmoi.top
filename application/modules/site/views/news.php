<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$tin_moi_category=$CI->site_model->gettablename_all('tblarticle','id,title,thumb,description,ordernum,status',7,'','');
$category_end=$CI->site_model->gettablename_all('tblarticle_category','id,category,ordernum,status','','page_sub',1);
$ads=$CI->site_model->gettablename_all('tblads','id,title,thumb,ordernum,status',2,'','');
?>
<div style="background:#fff;" class="w980">
    <?php $this->load->view('elements/ads_slider') ?>
<div class="content w980 list nhip-song-tre ">
                   
    <div class="clearfix"></div>
    
    <div class="list-middle-block">
        <div class="w479 fl stream-home list-middle-content">  
        <div class="title-content clearfix">
        <div class="content-left fl">         
            <div class="bread-crumbs fl">
                <?php 
                    if(isset($dm)){
                        $danhmuc = $CI->site_model->gettablename_all('tblarticle_category','id,category',1,'id',$dm);
                    ?>
                    <ul>
                        <li class="fl">
                            <h1>
                            <a href="<?php echo site_url(danhmucbaiviet($danhmuc->row()->id)); ?>" title="<?php echo $danhmuc->row()->category; ?>"><?php echo $danhmuc->row()->category; ?></a>
                            </h1>
                        </li>                        
                    </ul>
                    <?php 
                    }
                ?>
            </div>
        </div>            
    </div>                              
            <div class="box-news-latest isstream">
                <?php 
                    if($query->num_rows() > 0){
                    ?>
                    <ul class="list-news-content">
                        <?php 
                            foreach($query->result() as $item_query){
                            ?>
                            <li class="news-item">
                                
                                <a title="<?php echo $item_query->title; ?>" class="img212x132 pos-rlt" href="<?php echo site_url(url_tt($item_query->id)); ?>">
                                    <img class="img212x132" src="<?php echo $item_query->thumb; ?>" alt="<?php echo $item_query->title; ?>" title="<?php echo $item_query->title; ?>">
                                </a>
                                
                                <div class="name-news">
                                    <h3 class="title-news">
                                    <a title="<?php echo $item_query->title; ?>" href="<?php echo site_url(url_tt($item_query->id)); ?>"><?php echo $item_query->title; ?></a>
                                    </h3>
                                    <p class="sapo" rel="3"><?php echo catchuoi($item_query->description,280); ?></p>                                            
                                </div>
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
            </div>
        </div>
        <div class="w500 fr list-middle-content">                
            <div class="clearfix">
                <div class="coldrscate fl pdt15 bgcd8">                            
                    <div class="box-category4 pdl9 fl">
                        <h2><a class="title-box box-new-title" title="Xem nhiều">Xem nhiều</a></h2>    
                        <?php 
                            $this->db->where('status',1);
                            $this->db->order_by('view','desc');
                            $this->db->limit(10);
                            $this->db->select('id,title');
                            $xemnhieu = $this->db->get('tblarticle');
                            if($xemnhieu->num_rows()>0){
                            ?>
                            <ul class="clearfix" id="mostview-cate">
                                <?php 
                                    foreach($xemnhieu->result() as $item_xemnhieu){
                                    ?>
                                    <li>
                                        <h3><a class="box-category4-news-title" href="<?php echo site_url(url_tt($item_xemnhieu->id)); ?>" title="<?php echo $item_xemnhieu->title; ?>"><?php echo $item_xemnhieu->title; ?></a></h3>
                                    </li>    
                                    <?php 
                                    }
                                    $xemnhieu->free_result();
                                ?>                               
                            </ul>    
                            <?php 
                            }
                        ?>
                    </div>                            
                                <div class="bannerwidesky1 mgt15">
                                    


   


                                </div>
                                
                                    <div class="bannerwidesky1">
                                        


    

 
                                    </div>
                                

                                <div class="bannerwidesky1">
                                    



                                </div>
                            
</div>
<div class="w300 bgcff">
                            



                            
<?php $this->load->view('elements/ads_new')?>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="clearfix"></div>
        
        

        <?php $this->load->view('elements/ads') ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->load->view('modal/detail_modal') ?>   