<div class="content w980 list tag">
    <div class="title-content clearfix">
        <div class="content-left fl">
            <div class="bread-crumbs fl">
                <ul>
                    <li class="fl">
                        <h1><a href="javascript:;" title="Rác thải">Kết quả tìm kiếm: <span><?php echo $this->input->post('title'); ?></span></a></h1>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
    <span class="line"></span>
    <div class="title-content clearfix">
       
    </div>
    
    <div class="list-middle">
        <div class="list-middle-block">
            <div class="w479 fl stream-home list-middle-content">
                
<div class="box-news-latest isstream" style="padding-top:0;">
    <?php 
        if($query->num_rows()>0){
        ?>
        <ul class="list-news-content">
            <?php 
                foreach($query->result() as $row){                        
                    ?>
                    <li class="news-item">                                
                        <a href="<?php echo site_url(url_tt($row->id)); ?>" title="<?php echo $row->title; ?>" class="img212x132 pos-rlt">
                            <img class="img212x132" src="<?php echo $row->thumb; ?>" alt="<?php echo $row->title; ?>" title="<?php echo $row->title; ?>">
                        </a>                                
                        <div class="name-news">
                            <h3 class="title-news">
                                <a href="<?php echo site_url(url_tt($row->id)); ?>" title="<?php echo $row->title; ?>"><?php echo $row->title; ?></a>
                                
                            </h3>
                            <p class="sapo"><?php echo catchuoi($row->description,255); ?></p>
                            
                        </div>
                    </li>
                <?php 
                    
                }
            ?>
            <div style="padding:10px;"><?php echo $pagination;?></div>
        </ul>
        <?php 
        }
    ?>    
    
</div>


            </div>
            <div class="w500 fr list-middle-content">
                <div class="w200 fl pdt15">
                    
<div class="box-category4 pdl9 fl mgb15">
    <h2><a href="javascript:;" class="title-box" title="Đọc nhiều">Đọc nhiều</a></h2>
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 400px;">
    <?php 
        $this->db->where('status',1);
        $this->db->order_by('view','desc');
        $this->db->limit(6);
        $xemnhieu = $this->db->get('tblarticle');
        if($xemnhieu->num_rows()>0){
        ?>
        <ul class="clearfix" id="mostview-cate" style="overflow: hidden; width: auto; height: 400px;">        
            <?php 
                foreach($xemnhieu->result() as $item_xn){
                ?>    
                <li>
                    <h3><a class="box-category4-news-title" href="<?php echo site_url(url_tt($item_xn->id)); ?>" title="<?php echo $item_xn->title; ?>"><?php echo $item_xn->title; ?></a></h3>
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
   <div id="zone-jmzr1smt"><div id="share-jmzr1tg6"></div> </div>
 

                </div>
               
            </div>
        </div>
    </div>
</div>