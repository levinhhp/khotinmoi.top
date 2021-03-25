<?php
$CI = &get_instance();
$CI->load->model('site/site_model');
if (isset($ct)) {
    $sql_tin_ct = $CI->site_model->gettablename_all('tblarticle', 'id,category,ordernum,status', '', 'id', $ct);
    if ($sql_tin_ct->num_rows() > 0) {
        $adsSlider = $CI->site_model->sliderRamdom($sql_tin_ct->row()->category, $sql_tin_ct->row()->id);
    }
} elseif (isset($dm)) {
    $adsSlider = $CI->site_model->sliderRamdom($dm, '');
}
if (!empty($adsSlider)) {
?>

    <div class="group-ads">
        <div>
            <a href="">
                <div class="swiper_slide_all"><img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="">
                    <p>Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?</p>
                </div>
                <div class="clearfix"></div>
            </a>
            <div class="clearfix"></div>
        </div>
        <div>
            <a href="">
                <div class="swiper_slide_all"><img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="">
                    <p>Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?</p>
                </div>
                <div class="clearfix"></div>
            </a>
            <div class="clearfix"></div>
        </div>
    </div>




    <!-- <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $dem_ads = 1;
                foreach ($adsSlider as $j => $k) {
                    $tach_tin_slider = explode('-', $k);
                    if ($tach_tin_slider[1] == 'ads') {
                        $ads_end_slider = $CI->site_model->gettablename_all('tblads', 'id,title,link,thumb,ordernum,status', 1, 'id', $tach_tin_slider[0]);
                ?>
                            <div class="swiper-slide">
                                <div class="swiper_slide_all">
                                    <a class="<?php echo $ads_end_slider->link; ?>" target="_blank" href="<?php echo $ads_end_slider->link; ?>" title="<?php echo $ads_end_slider->row()->title; ?>">
                                        <img src="<?php echo $ads_end_slider->row()->thumb; ?>" alt="<?php echo $ads_end_slider->row()->title; ?>" title="<?php echo $ads_end_slider->row()->title; ?>">
                                    </a>
                                    <h3 class="name-title" style="padding-top:10px;">
                                        <a href="<?php echo $ads_end_slider->link; ?>" target="_blank" title="<?php echo $ads_end_slider->row()->title; ?>"><?php echo catchuoi($ads_end_slider->row()->title, 80); ?></a>                                
                                    </h3>        
                                </div>            
                                <div class="clearfix"></div>                                                    
                        </div>
                        <?php
                    } elseif ($tach_tin_slider[1] == 'tt') {
                        $post_end_slider = $CI->site_model->gettablename_all('tblarticle', 'id,title,thumb,ordernum,status', 1, 'id', $tach_tin_slider[0]);
                        if ($post_end_slider->num_rows() > 0) {
                        ?>
                            <div class="swiper-slide">
                                <div class="swiper_slide_all">
                                    <a href="<?php echo site_url(url_tt($post_end_slider->row()->id)); ?>" title="<?php echo $post_end_slider->row()->title; ?>">
                                        <img src="<?php echo $post_end_slider->row()->thumb; ?>" alt="<?php echo $post_end_slider->row()->title; ?>" title="<?php echo $post_end_slider->row()->title; ?>">
                                    </a>
                                    <h3 class="name-title" style="padding-top:10px;">
                                        <a href="<?php echo site_url(url_tt($post_end_slider->row()->id)); ?>" title="<?php echo $post_end_slider->row()->title; ?>"><?php echo catchuoi($post_end_slider->row()->title, 80); ?></a>                                
                                    </h3>  
                                </div>                  
                                <div class="clearfix"></div>                            
                                
                            </div>
                            <?php
                        }
                    }
                    $dem_ads++;
                }
                            ?>                                          
                    <div class="clearfix"></div>                         
            </div> 
    
        </div>   -->
    <span class="line"></span>
<?php
}
?>
<script src="frontend/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        autoHeight: true,
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>