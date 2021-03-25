<?php
$CI = &get_instance();
$CI->load->model('site/site_model');
$danhmuc_footer = $CI->site_model->getTableParent(0, 'tblarticle_category', 'id,category,footer,parent_id,ordernum,status', 4, 'footer', 1);
?>
<div class="w980">
    <div class="footer_all-write">
        <div class="footer_copy-write">
            <p>© 2020 khotinmoi.com . All rights reserved.</p>
            <p>® Trang tin tức được nhiều người xem nhất</p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
</div>
<div class="clearfix"></div>
<?php $this->load->view('modal/login_modal') ?>
<link href="frontend/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="frontend/js/custom.js"></script>
<?php
if (isset($home)) {
} else {
?>
    <script src="frontend/js/swiper.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            autoHeight: true,
            slidesPerView: 4,
            spaceBetween: 15.1,
            loop: true,
            autoplay: {
                delay: 5000,
            }
        });
    </script>
<?php
}
?>
<script src="frontend/component/config/config.js"></script>
<script src="frontend/component/template/vue_template.js"></script>
<?php
if (isset($home)) {
?>
    <script src="frontend/component/home/vue_home.js"></script>
<?php
}
?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "url": "https://khotinmoi.com/",
        "name": "Tin tức, tin nóng, đọc báo điện tử - Tin tức Online",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://khotinmoi.com/?s={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
</script>