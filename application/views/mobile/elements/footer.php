<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$footer_mobile = $this->site_model->gettablename('tblinformation','company_name,phone,fb_url,instagram_url,g_plus_url,youtube','');
$danhmuc_footer_mobile = $CI->site_model->getTableParent(0,'tblarticle_category','id,category,footer,parent_id,ordernum,status',4,'footer',1);
?>
<div id="footer_mb">
    <!-- <div id="footer_end_top">
        <div class="footer_end_top_left">
            <span class="footer_total_mb"><i aria-hidden="true" class="fa fa-bars"></i></span>
            <ul id="menu_home_mb">
                <li><a href="">Trang chủ </a></li>
                <li><a href="">Đăng ký</a></li>
                <li><a href="">Đăng nhập</a></li>
                <li><a href="">Diễn đàn</a></li>
                <li><a href="<?php echo site_url('lien-he.html'); ?>" title="Liên hệ">Liên hệ</a></li>
            </ul>                
        </div>
        <div class="footer_end_top_right">
            <ul id="menu_top_ul_mb">
                <li><a href="tel:<?php echo $footer_mobile->phone; ?>" title="<?php echo $footer_mobile->phone; ?>"><i class="fa fa-phone-square" aria-hidden="true"></i></a></li> 
                <li><a href="<?php echo $footer_mobile->fb_url; ?>" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li> 
                <li><a href="" title="G+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li> 
                <li><a href="<?php echo $footer_mobile->instagram_url; ?>" title="Intasgram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li> 
                <li><a href="<?php echo $footer_mobile->youtube; ?>" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> -->
    <!-- <div id="footer_end_content">
        <?php 
            if($danhmuc_footer_mobile->num_rows()>0){
                $dem_mb_footer_dm = 1;
            ?>
            <ul>
                <?php 
                    foreach($danhmuc_footer_mobile->result() as $item_dm_footer_mb){                        
                    ?>
                    <li <?php if($dem_mb_footer_dm%2==0){ ?>style="margin-right:0;"<?php } ?>><a href="<?php echo site_url(danhmucbaiviet($item_dm_footer_mb->id)); ?>" title="<?php echo $item_dm_footer_mb->category;?>"><?php echo $item_dm_footer_mb->category;?></a>
                        <?php 
                            $danhmuc_footer_mobile_sub=$CI->site_model->gettablename_all('tblarticle_category','id,category,menu,parent_id,ordernum,status','','parent_id',$item_dm_footer_mb->id);
                            if($danhmuc_footer_mobile_sub->num_rows()>0){
                            ?>
                            <ul class="footer_end_content_sub">
                                <?php 
                                    foreach($danhmuc_footer_mobile_sub->result() as $item_danhmuc_footer_mobile_sub){
                                        if($item_danhmuc_footer_mobile_sub->ordernum >=0){
                                        ?>
                                        <li><a href="<?php echo site_url(danhmucbaiviet($item_danhmuc_footer_mobile_sub->id)); ?>" title="<?php echo $item_danhmuc_footer_mobile_sub->category; ?>"><?php echo $item_danhmuc_footer_mobile_sub->category; ?></a></li>
                                        <?php 
                                        }
                                    }
                                    $danhmuc_footer_mobile_sub->free_result();
                                ?>
                            </ul>
                            <?php 
                            }
                        ?>
                    </li>
                    <?php 
                    $dem_mb_footer_dm++;
                    }
                    $danhmuc_footer_mobile->free_result();
                ?>
            </ul>
            <?php 
            }
        ?>
        <div class="clearfix"></div>
    </div> -->
    <div id="footer_end_mb">
        <!-- <p><img src="frontend/mobile/images/logo_footer.png" title="<?php echo $footer_mobile->company_name; ?>" alt="<?php echo $footer_mobile->company_name; ?>"></p> -->
        <p>© 2020 khotinmoi.com . All rights reserved.</p>
        <p>® Trang tin tức được nhiều người xem nhất</p>
    </div>
</div>