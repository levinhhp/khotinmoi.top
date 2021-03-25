<?php
$CI=&get_instance();
$CI->load->model('site/site_model');
$danhmuc_home1=$CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',1,'home',1);
$danhmuc_home2=$CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',2,'home',1);
$danhmuc_home3=$CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',3,'home',1);
$danhmuc_home4=$CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',4,'home',1);
$danhmuc_home5=$CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status','','home',1);
$tinhot_desk = $this->site_model->gettablename_all('tblarticle','id,title,ordernum,status',10,'hot',1);
$ads=$CI->site_model->postRamdomHome();
?>
<div id="app_home">
<div class="content">
    <div class="w980">  
        <div style="height:47px;overflow:hidden;">
        <div class="jctkr-label">
            <strong><i class="fa fa-clock-o" aria-hidden="true"></i> Tin hot</strong>
        </div>               
        <div class="js-conveyor-1">            
            <ul style="list-style:none;">
                <?php 
                    foreach($tinhot_desk->result() as $item_hot_ds){
                    ?>
                    <li style="float:left !important;">
                        <a style="color:#333" href="<?php echo site_url(url_tt($item_hot_ds->id)); ?>" title="<?php echo htmlspecialchars($item_hot_ds->title);?>"><i class="fa fa-circle" aria-hidden="true"></i> <?php echo htmlspecialchars($item_hot_ds->title);?>!</a>
                    </li>
                    <?php 
                    }
                    $tinhot_desk->free_result();
                ?>                
            </ul>
            
        </div>
        </div>
        <div class="clearfix"></div>
            <div id="tin_tuc_one" v-html="tin_tuc_one">                
                <div class="clearfix"></div>
            </div>            
            <div id="tin_tuc_two">
                <ul>
                    <li v-for="row_new in allNews"><a :href="row_new.link" :title="row_new.title" v-html="row_new.title"></a></li>                            
                </ul>                
            <div class="clearfix"></div>
        </div>
        <div id="ads_home_right">
            <?php 
                if(!empty($ads)){
                    $dem_ads = 1;
                    foreach($ads as $jt=>$kt){                                
                        $tach_tin_news_kt = explode('-',$kt); 
                        if($tach_tin_news_kt[1]=='ads'){
                            $ads_end_new_kt=$CI->site_model->gettablename_all('tblads','id,title,link,image_square,ordernum,status',1,'id',$tach_tin_news_kt[0]);  
                            if($ads_end_new_kt->num_rows()>0){
                            ?>
                            <div class="box_ads_home">
                                <div class="box_ads_home_number"><?php echo $dem_ads; ?></div>
                                <a><img src="<?php echo $ads_end_new_kt->row()->image_square; ?>"></a>
                                <a href="<?php echo $ads_end_new_kt->row()->link; ?>" title="<?php echo htmlspecialchars($ads_end_new_kt->row()->title); ?>" target="_blank"><?php echo catchuoi(htmlspecialchars($ads_end_new_kt->row()->title),80); ?></a>
                            </div>
                            <?php
                            }
                        }elseif($tach_tin_news_kt[1]=='tt'){
                            $new_end_kt=$CI->site_model->gettablename_all('tblarticle','id,title,date_day,image_square,ordernum,status',1,'id',$tach_tin_news_kt[0]); 
                            if($new_end_kt->num_rows()>0){
                            ?>
                            <div class="box_ads_home">
                                <div class="box_ads_home_number"><?php echo $dem_ads; ?></div>
                                <a><img src="<?php echo $new_end_kt->row()->image_square; ?>" title="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>" title="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>" alt="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>"></a>
                                <a href="<?php echo site_url(url_tt($new_end_kt->row()->id)); ?>" title="<?php echo htmlspecialchars($new_end_kt->row()->title); ?>"><?php echo catchuoi(htmlspecialchars($new_end_kt->row()->title),80); ?></a>
                            </div>
                            <?php
                            }
                        }  
                        if($dem_ads%2==0){
                            echo '<div cllass="clearfix" style="clear:both;"></div>';
                        }
                        $dem_ads++;
                    }
                }
            ?>            
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>        
            <div id="noibat_home">                
                    <div v-for="row_noibat in allNoibat" :class="row_noibat.old">
                        <a :href="row_noibat.link"><img :title="row_noibat.title" :alt="row_noibat.title" :src="row_noibat.thumb"></a>
                        <a :href="row_noibat.link" :title="row_noibat.title" v-html="row_noibat.cat_title"></a>
                    </div>                          
                <div class="clearfix"></div>
            </div>            
        <div class="clearfix"></div>
    </div>
    <div class="bottom-page-home w980">                        
        <div class="bgpink">
            <div class="wIpad">
                    
<div class="box-category3 w584px fl">
    <?php 
        if($danhmuc_home1->num_rows()>0){
        ?>
        <p class="box_old"><a href="<?php echo site_url(danhmucbaiviet($danhmuc_home1->row()->id)); ?>" class="title-box" title="<?php echo $danhmuc_home1->row()->category; ?>"><?php echo $danhmuc_home1->row()->category; ?></a></p>
        <?php 
            $danhmuc_home1_sub = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status','','parent_id',$danhmuc_home1->row()->id);
            if($danhmuc_home1_sub->num_rows()>0){
            ?>
            <ul class="cate-title">  
                <?php 
                    foreach($danhmuc_home1_sub->result() as $item_dm_home_sub){
                    ?>
                    <li><h3><a href="<?php echo site_url(danhmucbaiviet($item_dm_home_sub->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home_sub->category); ?>"><?php echo htmlspecialchars($item_dm_home_sub->category); ?></a></h3></li>
                    <?php    
                    }
                    $danhmuc_home1_sub->free_result();
                ?>                                                
            </ul>
            <?php 
            }
        ?>
    <div class="clearfix"></div>
    <?php 
        $new_dm1 = $CI->site_model->gettablename_all('tblarticle','id,category,title,description,thumb,ordernum,status',3,'category',$danhmuc_home1->row()->id);
        if($new_dm1->num_rows()>0){
            $dem_co_1 = 1;
        ?>
        <ul class="list-news">     
            <?php 
                foreach($new_dm1->result() as $item_new_dm1){
            ?>       
            <li <?php if($dem_co_1 == 3){?> style="margin-right:0;"<?php } ?>>
                <a class="img188x117 pos-rlt" href="<?php echo site_url(url_tt($item_new_dm1->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm1->title); ?>">
                    <img class="img188x117" src="<?php echo $item_new_dm1->thumb; ?>" alt="<?php echo htmlspecialchars($item_new_dm1->title); ?>" />
                </a>
                <p class="name-title">
                    <a href="<?php echo site_url(url_tt($item_new_dm1->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm1->title); ?>"><?php echo htmlspecialchars($item_new_dm1->title); ?></a>
                    
                </p>                    
                <div class="clearfix"></div>
                <p class="sapo need-trimline" rel="3"><?php echo catchuoi($item_new_dm1->description,200); ?></p>
                
            </li>   
            <?php 
                $dem_co_1++;
                }
                $new_dm1->free_result();
            ?>                                 
        </ul>    
        <?php 
            }
        }
    ?>
</div>

                    
<div class="box-category2 border-left-pd w376px fr">
    <?php 
        if($danhmuc_home2->num_rows()>0)
        {
            $dem_home2 = 1;
            foreach($danhmuc_home2->result() as $item_dm_home2){
                if($dem_home2>1){
                ?>
                <h2 class="box_event"><a href="<?php echo site_url(danhmucbaiviet($item_dm_home2->id)); ?>" class="title-box" title="<?php echo $item_dm_home2->category; ?>"><?php echo $item_dm_home2->category; ?></a></h2>
                    <?php 
                        $danhmuc_home2_sub = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',2,'parent_id',$item_dm_home2->id);
                        if($danhmuc_home2_sub->num_rows()>0){
                            ?>
                            <ul class="cate-title">  
                                <?php 
                                    foreach($danhmuc_home2_sub->result() as $item_dm_home2_sub){
                                        if($item_dm_home2_sub->ordernum >=0){
                                        ?>
                                        <li>
                                            <h3><a href="<?php echo site_url(danhmucbaiviet($item_dm_home2_sub->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home2_sub->category); ?>"><?php echo htmlspecialchars($item_dm_home2_sub->category); ?></a></h3>
                                        </li> 
                                        <?php   
                                        } 
                                    }
                                    $danhmuc_home2_sub->free_result();
                                ?>                                                                                                             
                            </ul>
                            <?php
                            }
                        ?>
                <div class="clearfix"></div>
                <?php 
                    $new_dm2 = $CI->site_model->gettablename_all('tblarticle','id,category,category_sub,title,description,thumb,ordernum,status',3,'category',$item_dm_home2->id);
                    if($new_dm2->num_rows()>0){
                        $dem_new2 = 1;
                    ?>
                    <ul class="list-news">
                        <?php 
                            foreach($new_dm2->result() as $item_new_dm2){
                                if($dem_new2==1){
                                ?>
                                <li>
                                    <a class="img188x117 pos-rlt" href="<?php echo site_url(url_tt($item_new_dm2->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm2->title); ?>">
                                        <img class="img188x117" src="<?php echo $item_new_dm2->thumb; ?>" alt="<?php echo htmlspecialchars($item_new_dm2->title); ?>" title="<?php echo htmlspecialchars($item_new_dm2->title); ?>" />
                                    </a>
                                    <div class="description">
                                        <p class="name-title clearfix">
                                            <a href="<?php echo site_url(url_tt($item_new_dm2->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm2->title); ?>"><?php echo htmlspecialchars($item_new_dm2->title); ?></a>
                                            
                                        </p>
                                        <p class="sapo news_dm2"><?php echo catchuoi($item_new_dm2->description,90); ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                                <?php
                                }else{
                                ?>
                                <li>
                                    <a class="img90x56 pos-rlt" href="<?php echo site_url(url_tt($item_new_dm2->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm2->title); ?>">
                                        <img class="img90x56" src="<?php echo $item_new_dm2->thumb; ?>" alt="<?php echo htmlspecialchars($item_new_dm2->title); ?>" title="<?php echo htmlspecialchars($item_new_dm2->title); ?>" />
                                    </a>
                                    
                                        <a class="title-name" href="<?php echo site_url(url_tt($item_new_dm2->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm2->title); ?>"><?php echo htmlspecialchars($item_new_dm2->title); ?></a>
                                        
                                    
                                    <?php                                     
                                        if($item_new_dm2->category_sub>0){
                                            $sub_out = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',1,'id',$item_new_dm2->category_sub);    
                                            ?>
                                            <a class="category-name" href="<?php echo site_url(danhmucbaiviet($sub_out->row()->id)); ?>" title="<?php echo htmlspecialchars($sub_out->row()->category); ?>"><?php echo htmlspecialchars($sub_out->row()->category); ?></a>
                                            <?php
                                        }else{
                                            ?>
                                            <a class="category-name" href="<?php echo site_url(danhmucbaiviet($item_dm_home2_sub->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home2->category); ?>"><?php echo htmlspecialchars($item_dm_home2->category); ?></a>
                                            <?php
                                        }
                                    ?>   
                                     <div class="clearfix"></div>                                 
                                </li>
                                <?php
                                }                             
                            $dem_new2++;  
                            }
                            $new_dm2->free_result();
                        ?>                                                                                                                                                          
                    </ul>
                    <?php 
                    }
                }
            $dem_home2++;
            }
            $danhmuc_home2->free_result();
        }
    ?>
</div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <span class="line"></span>
            <div class="wIpad">
                
<div class="box-category2 border-right-pd w376px fl">
    <?php 
        if($danhmuc_home3->num_rows()>0){
            $dem_new3 = 1;
            foreach($danhmuc_home3->result() as $item_dm_home3){
                if($dem_new3>2){
                ?>
                <h2 class="box_event"><a href="<?php echo site_url(danhmucbaiviet($item_dm_home3->id)); ?>" class="title-box" title="<?php echo htmlspecialchars($item_dm_home3->category); ?>"><?php echo htmlspecialchars($item_dm_home3->category); ?></a></h2>    
                <?php 
                    $danhmuc_home3_sub = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',2,'parent_id',$item_dm_home3->id);
                    if($danhmuc_home3_sub->num_rows()>0){
                    ?>
                    <ul class="cate-title"> 
                        <?php 
                            foreach($danhmuc_home3_sub->result() as $item_dm_home3_sub){
                            ?>
                            <li>
                                <h3><a href="<?php echo site_url(danhmucbaiviet($item_dm_home3_sub->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home3_sub->category); ?>"><?php echo htmlspecialchars($item_dm_home3_sub->category); ?></a></h3>
                            </li> 
                            <?php    
                            }
                            $danhmuc_home3_sub->free_result();
                        ?>                                                                     
                    </ul>
                    <?php 
                    }
                ?>
                <div class="clearfix"></div>
                <?php 
                    $new_dm3 = $CI->site_model->gettablename_all('tblarticle','id,category,category_sub,title,description,thumb,ordernum,status',3,'category',$item_dm_home3->id);                    
                    if($new_dm3->num_rows()>0){
                        $dem_new3 = 1;
                    ?>
                    <ul class="list-news">   
                        <?php 
                            foreach($new_dm3->result() as $item_n_dm3){
                                if($dem_new3 == 1){
                            ?>             
                                <li>
                                    <a class="img188x117 pos-rlt" href="<?php echo site_url(url_tt($item_n_dm3->id)); ?>" title="<?php echo htmlspecialchars($item_n_dm3->title); ?>">
                                        <img class="img188x117" src="<?php echo $item_n_dm3->thumb; ?>" alt="<?php echo htmlspecialchars($item_n_dm3->title); ?>" title="<?php echo htmlspecialchars($item_n_dm3->title); ?>" />
                                    </a>
                                    <div class="description">
                                        <p class="name-title clearfix">
                                            <a href="<?php echo site_url(url_tt($item_n_dm3->id)); ?>" title="<?php echo htmlspecialchars($item_n_dm3->title); ?>"><?php echo htmlspecialchars($item_n_dm3->title); ?></a>
                                            
                                        </p>
                                        <p class="sapo news_dm2"><?php echo catchuoi($item_n_dm3->description,90); ?></p>
                                    </div>
                                </li>
                                <?php 
                                }else{
                                
                                ?>                                    
                                <li>
                                    <a class="img90x56 pos-rlt" href="<?php echo site_url(url_tt($item_n_dm3->id)); ?>" title="<?php echo htmlspecialchars($item_n_dm3->title); ?>">
                                        <img class="img90x56" src="<?php echo $item_n_dm3->thumb; ?>" alt="<?php echo htmlspecialchars($item_n_dm3->title); ?>" />
                                    </a>
                                   
                                        <a class="title-name" href="<?php echo site_url(url_tt($item_n_dm3->id)); ?>" title="<?php echo htmlspecialchars($item_n_dm3->title); ?>"><?php echo htmlspecialchars($item_n_dm3->title); ?></a>
                                    <?php                                     
                                        if($item_n_dm3->category_sub>0){
                                            $sub_out3 = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',1,'id',$item_n_dm3->category_sub);    
                                            ?>
                                            <a class="category-name" href="<?php echo site_url(danhmucbaiviet($sub_out3->row()->id)); ?>" title="<?php echo htmlspecialchars($sub_out3->row()->category); ?>"><?php echo htmlspecialchars($sub_out3->row()->category); ?></a>
                                            <?php
                                        }else{
                                            ?>
                                            <a class="category-name" href="<?php echo site_url(danhmucbaiviet($item_dm_home3->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home3->category); ?>"><?php echo htmlspecialchars($item_dm_home3->category); ?></a>
                                            <?php
                                        }
                                    ?>                         
                                </li>
                            <?php 
                                }
                            $dem_new3++;
                            }
                            $new_dm3->free_result();
                        ?>                               
                    </ul>
                    <?php
                    } 
                }
                $dem_new3++;
            }
            $danhmuc_home3->free_result();
        }
    ?>
</div>        
<div class="box-category3 w584px fr">
    <?php 
        if($danhmuc_home4->num_rows()>0){
            $dem_home4= 1;
            foreach($danhmuc_home4->result() as $item_dm_home4){
                if($dem_home4 >3){
                ?>
                <h2 class="box_old"><a href="<?php echo site_url(danhmucbaiviet($item_dm_home4->id)); ?>" class="title-box" title="<?php echo htmlspecialchars($item_dm_home4->category); ?>"><?php echo htmlspecialchars($item_dm_home4->category); ?></a></h2>
                <?php 
                    $danhmuc_home4_sub = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',5,'parent_id',$item_dm_home4->id);
                    if($danhmuc_home4_sub->num_rows()>0){
                    ?>
                    <ul class="cate-title">  
                        <?php 
                            foreach($danhmuc_home4_sub->result() as $item_dm_home4_sub){
                                if($item_dm_home4_sub->ordernum >=0){
                                ?>                              
                                <li>
                                    <h3><a href="<?php echo site_url(danhmucbaiviet($item_dm_home4_sub->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home4_sub->category); ?>"><?php echo htmlspecialchars($item_dm_home4_sub->category); ?></a></h3>
                                </li>   
                                <?php 
                                }
                            }
                            $danhmuc_home4_sub->free_result();
                        ?>                                                                             
                    </ul>
                    <?php 
                    }
                ?>
                <div class="clearfix"></div>
                <?php 
                    $new_dm4 = $CI->site_model->gettablename_all('tblarticle','id,category,category_sub,title,description,thumb,ordernum,status',3,'category',$item_dm_home4->id);                    
                    if($new_dm4->num_rows()>0){
                        $dem_co_4 = 1;
                    ?>
                    <ul class="list-news">
                        <?php 
                            foreach($new_dm4->result() as $item_new_dm4){
                                ?>
                                <li <?php if($dem_co_4 == 3){ ?> style="margin-right:0;" <?php } ?>>
                                    <a class="img188x117 pos-rlt" href="<?php echo site_url(url_tt($item_new_dm4->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm4->title); ?>">
                                        <img class="img188x117" src="<?php echo $item_new_dm4->thumb; ?>" alt="<?php echo htmlspecialchars($item_new_dm4->title); ?>" title="<?php echo htmlspecialchars($item_new_dm4->title); ?>" />
                                    </a>
                                    <p class="name-title">
                                        <a href="<?php echo site_url(url_tt($item_new_dm4->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm4->title); ?>"><?php echo  htmlspecialchars($item_new_dm4->title);?></a>                                        
                                    </p>                    
                                    <div class="clearfix"></div>
                                    <p class="sapo need-trimline"><?php echo catchuoi($item_new_dm4->description,130); ?></p>
                                    <div class="clearfix"></div>
                                </li>
                            <?php 
                            $dem_co_4++;
                            }
                        ?>                                
                    </ul>
                    <?php 
                    }
                }
            $dem_home4++;
            }
            $danhmuc_home4->free_result();
        }
    ?>
</div>

            </div>
            <div class="clearfix"></div>             
           
                       
            
        </div>
        <div class="w980">
            <span class="line"></span>
<?php 
    if($danhmuc_home5->num_rows()>0){
        $dem_home5 = 1;
        foreach($danhmuc_home5->result() as $item_dm_home5){
            if($dem_home5 >4){
            ?>
            <div class="box-needknown box_category_end">
                <h2 class="box_old"><a href="<?php echo site_url(danhmucbaiviet($item_dm_home5->id)); ?>" class="title-box" title="<?php echo $item_dm_home5->category; ?>"><?php echo $item_dm_home5->category; ?></a></h2>
                <?php 
                    $danhmuc_home5_sub = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status','','parent_id',$item_dm_home5->id);
                    if($danhmuc_home5_sub->num_rows()>0){
                    ?>
                    <ul class="cate-title">
                        <?php 
                            foreach($danhmuc_home5_sub->result() as $item_dm_home_sub5){
                            ?>
                            <li>
                                <h3><a href="<?php echo site_url(danhmucbaiviet($item_dm_home_sub5->id)); ?>" title="<?php echo htmlspecialchars($item_dm_home_sub5->category); ?>"><?php echo htmlspecialchars($item_dm_home_sub5->category); ?></a></h3>
                            </li>
                            <?php 
                            }
                            $danhmuc_home5_sub->free_result();
                        ?>                        
                    </ul>
                    <div class="clearfix"></div> 
                    <?php 
                    }
                    $new_dm5 = $CI->site_model->gettablename_all('tblarticle','id,category,category_sub,title,description,thumb,ordernum,status',10,'category',$item_dm_home5->id); 
                    if($new_dm5->num_rows()>0){
                        $dem_clear = 1;
                    ?>
                    <ul class="list-news clearfix">   
                        <?php 
                            foreach($new_dm5->result() as $item_new_dm5){
                            ?>                 
                            <li <?php if($dem_clear%5==0){?> style="margin-right:0;" <?php } ?>>
                                <a class="img188x117 pos-rlt" href="<?php echo site_url(url_tt($item_new_dm5->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm5->title); ?>">
                                    
                                    <img class="img188x117" src="<?php echo $item_new_dm5->thumb; ?>" alt="<?php echo htmlspecialchars($item_new_dm5->title); ?>" title="<?php echo htmlspecialchars($item_new_dm5->title); ?>" />
                                    
                                </a>
                                <p class="name-title">
                                    <a href="<?php echo site_url(url_tt($item_new_dm5->id)); ?>" title="<?php echo htmlspecialchars($item_new_dm5->title); ?>"><?php echo htmlspecialchars($item_new_dm5->title); ?></a>
                                    
                                </p>   
                                <div class="clearfix"></div>
                                <?php                                     
                                    if($item_new_dm5->category_sub>0){
                                        $sub_out5 = $CI->site_model->gettablename_all('tblarticle_category','id,category,home,ordernum,status',1,'id',$item_new_dm5->category_sub);    
                                        ?>
                                        <a class="category-name" href="<?php echo site_url(danhmucbaiviet($sub_out5->row()->id)); ?>" title="<?php echo htmlspecialchars($sub_out5->row()->category); ?>"><?php echo htmlspecialchars($sub_out5->row()->category); ?></a>
                                        <?php
                                    }else{
                                        ?>
                                        <a class="category-name" href="<?php echo site_url(danhmucbaiviet($item_dm_home5->id)); ?>" title="<?php echo $item_dm_home5->category; ?>"><?php echo htmlspecialchars($item_dm_home5->category); ?></a>
                                        <?php
                                    }
                                ?>                                                      
                                <div class="clearfix"></div>                                
                            </li> 
                            <?php 
                            if($dem_clear==5){
                                echo '<div class="clearfix"></div>';
                            }
                            $dem_clear++;
                            }
                            $new_dm5->free_result();
                        ?>                                                  
                    </ul>
                    <?php 
                    }
                ?>
                <div class="clearfix"></div>
            </div>               
            <?php 
            }
            $dem_home5++;
        }
        $danhmuc_home5->free_result();
    }
?>
<div class="box_xem_nhieu">
    <span class="line"></span>
    <div class="box_xem_nhieu_top">
        <p>Xu hướng được quan tâm nhiều</p>
    </div> 
    <div class="box_xem_nhieu_main">
        <?php 
            $this->db->where('status',1);            
            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') >=",date('Y-m-d',strtotime('-7 day')));
            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') <=",date('Y-m-d'));
            $this->db->order_by('view','desc');
            $this->db->limit(5);
            $this->db->select('id,category,title,thumb,description,date_day');
            $sql_xn = $this->db->get('tblarticle');
            if($sql_xn->num_rows()>0){
                $dem_xn = 1;
                foreach($sql_xn->result() as $item_xn){					
                    $category_xn = $CI->site_model->gettablename_all('tblarticle_category','id,category,ordernum,status',1,'id',$item_xn->category);                    
                ?>        
                <div class="xem_nhieu_box" <?php if($dem_xn==5){ ?>style="margin-right:0;"<?php } ?>>
                    <a href="<?php echo site_url(url_tt($item_xn->id)); ?>" class="xem_nhieu_box_img"><img src="<?php echo $item_xn->thumb; ?>" title="<?php echo htmlspecialchars($item_xn->title); ?>" alt="<?php echo htmlspecialchars($item_xn->title); ?>"></a>
                    <div class="xem_nhieu_box_number">
                        <?php echo $dem_xn; ?>
                    </div>
                    <div class="xem_nhieu_box_content">
                        <a href="<?php echo site_url(danhmucbaiviet($category_xn->row()->id)); ?>" class="xem_nhieu_box_category" title="<?php echo htmlspecialchars($category_xn->row()->category); ?>"><?php echo htmlspecialchars($category_xn->row()->category); ?></a>
                        <a class="xemnhieu_title" href="<?php echo site_url(url_tt($item_xn->id)); ?>"><?php echo $item_xn->title; ?></a>
                        <p><?php echo catchuoi($item_xn->description,70); ?></p>
                        <div class="clearfix"></div>
                        <span class="timeago"><?php echo get_time(strtotime($item_xn->date_day)); ?></span>
                    </div>            
                    <div class="clearfix"></div> 
                </div>
                <?php 
                $dem_xn++;
                }
            }
        ?>
        <div class="clearfix"></div>   
    </div>
</div>
</div>
        </div>
    </div>
    <div class="clearfix"></div>