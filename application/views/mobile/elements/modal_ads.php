<?php     
    $CI=&get_instance();
    $CI->load->model('site/site_model');
    if(isset($ct)){                        
        $sql_tin_ct=$CI->site_model->gettablename_all('tblarticle','id,category,ordernum,status','','id',$ct);
        if($sql_tin_ct->num_rows()>0){
            $adsHome = $CI->site_model->postRamdom($sql_tin_ct->row()->category,$sql_tin_ct->row()->id);
        }
    }elseif(isset($dm)){        
        $adsHome = $CI->site_model->postRamdom($dm,'');
    }          
    if(!empty($adsHome)){      
    ?>  
    <span class="line mgt16"></span>   
    <p style="font-size:14px;font-weight:bold;border-bottom:1px solid #ededed;padding-bottom:15px;padding-top:8px;text-transform:uppercase">Tin ngẫu nhiên</p>     
    <ul class="list-news-modal">
    <?php               
        $dem_ads = 1;
        foreach($adsHome as $k=>$v){
            $tach_tin = explode('-',$v);                               
            if($tach_tin[1]=='ads'){
                $ads_end=$CI->site_model->gettablename_all('tblads','id,title,link,thumb,ordernum,status',1,'id',$tach_tin[0]);                    
                ?>
                <li <?php if($dem_ads%4==0){ ?>style="margin-right:0;"<?php } ?>>
                    <a class="" style="width:100%;" target="_blank" href="<?php echo $ads_end->link; ?>" title="<?php echo $ads_end->row()->title; ?>">
                        <img style="width:100%;" class="img188x117" src="<?php echo $ads_end->row()->thumb; ?>" alt="<?php echo $ads_end->row()->title; ?>" title="<?php echo $ads_end->row()->title; ?>">
                    </a>
                    <h3 class="name-title">
                        <a href="<?php echo $ads_end->link; ?>" target="_blank" title="<?php echo $ads_end->row()->title; ?>"><?php echo catchuoi($ads_end->row()->title,80); ?></a>                                
                    </h3>                    
                    <div class="clearfix"></div>                                                    
                </li>
            <?php 
            }elseif($tach_tin[1]=='tt'){   
                $post_end=$CI->site_model->gettablename_all('tblarticle','id,title,thumb,ordernum,status',1,'id',$tach_tin[0]); 
                if($post_end->num_rows()>0){
                ?>                
                <li class="xem_nhieu_popup" data-id="<?php echo $post_end->row()->id; ?>" <?php if($dem_ads%4==0){ ?>style="margin-right:0;"<?php } ?>>
                    <a style="cursor:pointer;" title="<?php echo $post_end->row()->title; ?>">
                        <img style="width:100%;" class="img188x117" src="<?php echo $post_end->row()->thumb; ?>" alt="<?php echo $post_end->row()->title; ?>" title="<?php echo $post_end->row()->title; ?>">
                    </a>
                    <h3 class="name-title">
                        <a style="cursor:pointer;" title="<?php echo $post_end->row()->title; ?>"><?php echo catchuoi($post_end->row()->title,80)  ; ?></a>                                
                    </h3>                    
                    <div class="clearfix"></div>                            
                    
                </li>
                <?php
                }
            }
            if($dem_ads%4==0){
                echo '<div class="clearfix"></div>';
            }
        $dem_ads++;
        }            
        ?>                                          
        <div class="clearfix"></div>                         
    </ul>   
    <?php 
    }
?>  
