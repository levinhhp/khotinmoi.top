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
    <div class="group-qc-newdetail">
        <div class="qc-newdetail">
            <div data-id="432" class="swiper-slide xem_nhieu_popup">
                <div class="swiper_slide_all"><a title="Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?" style="cursor: pointer;"><img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?" title="Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?" style="width: 100%;"></a>
                    <h3 class="name-title" style="padding-top: 10px;"><a title="Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?" style="cursor: pointer;">Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?</a></h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div data-id="195" class="swiper-slide xem_nhieu_popup">
                <div class="swiper_slide_all"><a title="Bạc trở thành kênh đầu tư sáng giá" style="cursor: pointer;"><img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="Bạc trở thành kênh đầu tư sáng giá" title="Bạc trở thành kênh đầu tư sáng giá" style="width: 100%;"></a>
                    <h3 class="name-title" style="padding-top: 10px;"><a title="Bạc trở thành kênh đầu tư sáng giá" style="cursor: pointer;">Bạc trở thành kênh đầu tư sáng giá</a></h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div data-id="228" class="swiper-slide xem_nhieu_popup">
                <div class="swiper_slide_all"><a title="Hội An cách ly xã hội từ 0h ngày 31/7" style="cursor: pointer;"><img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="Hội An cách ly xã hội từ 0h ngày 31/7" title="Hội An cách ly xã hội từ 0h ngày 31/7" style="width: 100%;"></a>
                    <h3 class="name-title" style="padding-top: 10px;"><a title="Hội An cách ly xã hội từ 0h ngày 31/7" style="cursor: pointer;">Hội An cách ly xã hội từ 0h ngày 31/7</a></h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div data-id="242" class="swiper-slide xem_nhieu_popup">
                <div class="swiper_slide_all"><a title="Dung dịch sát khuẩn có thể ảnh hưởng tới nội thất ô tô" style="cursor: pointer;"><img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="Dung dịch sát khuẩn có thể ảnh hưởng tới nội thất ô tô" title="Dung dịch sát khuẩn có thể ảnh hưởng tới nội thất ô tô" style="width: 100%;"></a>
                    <h3 class="name-title" style="padding-top: 10px;"><a title="Dung dịch sát khuẩn có thể ảnh hưởng tới nội thất ô tô" style="cursor: pointer;">Dung dịch sát khuẩn có thể ảnh hưởng tới nội thất ô tô</a></h3>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <!--         
        <div class="swiper-container">
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
                                        <img style="width:100%;" src="<?php echo $ads_end_slider->row()->thumb; ?>" alt="<?php echo $ads_end_slider->row()->title; ?>" title="<?php echo $ads_end_slider->row()->title; ?>">
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
                            <div class="swiper-slide xem_nhieu_popup" data-id="<?php echo $post_end_slider->row()->id; ?>">
                                <div class="swiper_slide_all">
                                    <a style="cursor: pointer;" title="<?php echo htmlspecialchars($post_end_slider->row()->title); ?>">
                                        <img style="width:100%;" src="<?php echo $post_end_slider->row()->thumb; ?>" alt="<?php echo htmlspecialchars($post_end_slider->row()->title); ?>" title="<?php echo htmlspecialchars($post_end_slider->row()->title); ?>">
                                    </a>
                                    <h3 class="name-title" style="padding-top:10px;">
                                        <a style="cursor: pointer;" title="<?php echo htmlspecialchars($post_end_slider->row()->title); ?>"><?php echo catchuoi($post_end_slider->row()->title, 80); ?></a>                                
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