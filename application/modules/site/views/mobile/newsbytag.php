<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
?>
<div id="content_mobile">
    <div class="content_read">    
        <div class="box_mobile">
            <div class="box_mobile_top" style="border-left:none;border-right:none;border-top:none;">
                <h1><a class="title-box box-new-title" title="Đọc nhiều">Tag: <span><?php echo $tag->tag; ?></a></h1>
            </div>
            <div id="content_nd">
                <?php 
                    if($query->num_rows()>0){
                    ?>
                    <ul class="list-news-content">
                            <?php 
                                foreach($query->result() as $row1){
                                    $row=$CI->site_model->getnew($row1->idnew);
                                    if($row->num_rows() > 0){
                                    ?>
                                    <li class="news-item">                                
                                        <a href="<?php echo site_url(url_tt($row->row()->id)); ?>" class="list-news-content-img" title="<?php echo $row->row()->title; ?>" class="img212x132 pos-rlt">
                                            <img class="img212x132" src="<?php echo $row->row()->thumb; ?>" alt="<?php echo $row->row()->title; ?>" title="<?php echo $row->row()->title; ?>">
                                        </a>                                
                                        <div class="name-news">
                                            <h3 class="title-news">
                                                <a href="<?php echo site_url(url_tt($row->row()->id)); ?>" title="<?php echo $row->row()->title; ?>"><?php echo $row->row()->title; ?></a>
                                                
                                            </h3>
                                            <p class="sapo"><?php echo catchuoi($row->row()->description,250); ?></p>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php 
                                    }
                            }
                        ?>
                        <div><?php echo $pagination;?></div>
                    </ul>
                    <?php 
                    }
                ?>    
                
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