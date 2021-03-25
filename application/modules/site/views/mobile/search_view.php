<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
?>
<div id="content_mobile">
    <div id="content_read">
        <div class="box_mobile">
            <div class="box_mobile_top" style="border-left:none;border-right:none;border-top:none;">                    
                <h1><a href="javascript:;" title="Rác thải">Kết quả tìm kiếm: <span><?php echo $this->input->post('title'); ?></span></a></h1>                    
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
                                    <p class="sapo"><?php echo catchuoi($item_query->description,280); ?></p>                                            
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
                ?>                
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="box_mobile">
            <div class="box_mobile_top">
                <h2><a class="title-box box-new-title" title="Đọc nhiều">Đọc nhiều</a></h2>
            </div>
            <div class="box_mobile_main">
            <?php 
                $this->db->where('status',1);
                $this->db->order_by('view','desc');
                $this->db->limit(6);
                $this->db->select('id,title,thumb,view,status');
                $xemnhieu = $this->db->get('tblarticle');
                if($xemnhieu->num_rows()>0){
                ?>
                <ul id="mostview-cate">        
                    <?php 
                        foreach($xemnhieu->result() as $item_xn){
                        ?>    
                        <li>
                            <a class="mostview-cate-img"><img src="<?php echo $item_xn->thumb; ?>" title="<?php echo $item_xn->title; ?>" alt="<?php echo $item_xn->title; ?>"></a>
                            <a class="box-category4-news-title" href="<?php echo site_url(url_tt($item_xn->id)); ?>" title="<?php echo $item_xn->title; ?>"><?php echo $item_xn->title; ?></a>                            
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
        </div>
    </div>
</div>