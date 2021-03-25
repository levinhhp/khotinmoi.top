<?php
$CI = &get_instance();
$CI->load->model('site/site_model');
$category_end = $CI->site_model->gettablename_all('tblarticle_category', 'id,category,ordernum,status', '', 'page_sub', 1);
$bread_crumbs = $CI->site_model->gettablename_all('tblarticle_category', 'id,category,parent_id,ordernum,status', 1, 'id', $query1->category);
$bread_crumb_sub = $CI->site_model->gettablename_all('tblarticle_category', 'id,category,parent_id,ordernum,status', 1, 'id', $query1->category_sub);
$tin_moi = $CI->site_model->gettablename_all('tblarticle', 'id,title,date_day,thumb,description,ordernum,status', 9, '', '');
$adsSlider = $CI->site_model->postRamdom($query1->category);
if ($query1->category_sub > 0) {
    $tincung_loai = $CI->site_model->gettablename_all('tblarticle', 'id,category,category_sub,title,date_day,description,thumb,ordernum,status', 5, 'category_sub', $query1->category_sub);
} else {
    $tincung_loai = $CI->site_model->gettablename_all('tblarticle', 'id,category,title,date_day,description,thumb,ordernum,status', 5, 'category', $query1->categgory);
}
if (isset($dm)) {
    $sqldanhmucdmv = $CI->site_model->getTableParent(0, 'tblarticle_category', 'id,category,parent_id,ordernum,status', '', 'id', $dm);
    if ($sqldanhmucdmv->num_rows() > 0) {
        $query1 = $CI->site_model->gettablename_all('tblarticle', 'id,title,date_day,thumb,description,content,thumb,thumb,ordernum,status', 1, 'category', $dm)->row();
    } else {
        $query1 = $CI->site_model->gettablename_all('tblarticle', 'id,title,date_day,thumb,description,content,thumb,thumb,ordernum,status', 1, 'category_sub', $dm)->row();
    }
}
?>
<div id="app_ct">
    <div style="background:#fff;" class="w980">
        <?php $this->load->view('elements/ads_slider') ?>

        <div id="crudApp">
            <div id="share_post">
                <div class="w980">
                    <div id="share_post_custom">
                        <div class="share_post_custom_box">
                            <div class="share_post_custom_box_icon" id="click_like">
                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                            </div>
                            <span id="like_number"><?php echo $query1->like_post; ?></span>
                        </div>
                        <div class="share_post_custom_box">
                            <div class="share_post_custom_box_icon">
                                <a href="#fb"><i class="fa fa-commenting-o" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="share_post_custom_box">
                            <div class="share_post_custom_box_icon">
                                <a href="#list-news1_all"><i class="fa fa-book" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="share_post_custom_box">
                            <div class="share_post_custom_box_icon">
                                <a href="javascript:fbShare('<?php echo site_url(url_tt($query1->id)); ?>', '<?php echo htmlspecialchars($query1->title); ?>', '<?php echo htmlspecialchars($query1->description); ?>', '<?php echo $query1->thumb; ?>', 600, 350)"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content w980">
                <div class="content-detail column-2" id="main-detail">
                    <section class="detail-w fl">
                        <div id="mainContentDetail">
                            <div class="title-content clearfix first">
                                <div class="content-left fl">
                                    <div style="float:right;margin-top:10px;" class="fb-like" data-href="<?php echo site_url(url_tt($query1->id)); ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <h1 class="article-title" v-html="article_title"></h1>
                            <div class="date-time" v-html="date_time">
                            </div>

                            <div class="column-first-second">

                                <div class="main-content-body">
                                    <p class="sapo"><strong v-html="description"></strong></p>
                                    <?php
                                    if ($tincung_loai->num_rows() > 0) {
                                    ?>
                                        <div class="relate-container">
                                            <ul>
                                                <?php
                                                foreach ($tincung_loai->result() as $item_tin_cl) {
                                                ?>
                                                    <li class="xem_nhieu_popup" data-id="<?php echo $item_tin_cl->id ?>"><a style="cursor: pointer;" title="<?php echo htmlspecialchars($item_tin_cl->title); ?>"><?php echo htmlspecialchars($item_tin_cl->title); ?></a></li>
                                                <?php
                                                }
                                                $tincung_loai->free_result();
                                                ?>
                                            </ul>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="content fck" id="main-detail-body" v-html="content"></div>

                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="tagandnetwork" id="tagandnetwork">
                                <div id="chiase" v-html="chiase"></div>
                                <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4eae23e6468992a2"></script>
                                <script src="https://sp.zalo.me/plugins/sdk.js"></script>

                                <div class="clearfix"></div>

                                <div class="tags-container" style="margin-top:0px;">
                                    <ul class="tags-wrapper">
                                        <li v-for="row_tag in allTag" class="tags-item"><a :href="row_tag.tag_link" :title="row_tag.tag_name" v-html="row_tag.tag_name"></a></li>
                                    </ul>
                                </div>
                                <div class="pre-next">
                                    <div class="button-pre">Bài viết trước</div>
                                    <div class="button-next">Bài viết kế tiếp</div>
                                </div>
                                <div class="clearfix"></div>


                                <div class="tagandtopicandbanner">


                                    <div class="clearfix"></div>
                                    <span class="line mgt16"></span>
                                    <div class="clearfix"></div>


                                    <div id="fb" style="width:100%;">
                                        <div id="fb-root"></div>
                                        <script src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                                        <fb:comments :href="facebook_comment" num_posts="2" width="100%"></fb:comments>
                                        <script>
                                            FB.XFBML.parse();
                                        </script>
                                        <!--fb-->
                                    </div>

                                </div>

                            </div>
                    </section>

                    <!-- <section class="slidebar fr">

                        <div class="area1">
                            <div class="bannerright1" style="margin-top: -7px;">
                                <div class="area1_2">

                                    <?php $this->load->view('elements/ads_new') ?>
                                </div>

                                <div class="area1_2">
                                    <div class="box_xem_nhieu_detail_column23">

                                        <div class="box-worldcup-2018 typeother">
                                            <p class="title-box box-new-title" title="Xem nhiều">Xu hướng quan tâm nhiều</p>
                                            <?php
                                            $this->db->where('status', 1);
                                            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-7 day')));
                                            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') <=", date('Y-m-d'));
                                            $this->db->order_by('view', 'desc');
                                            $this->db->limit(5);
                                            $this->db->select('id,title,thumb,date_day');
                                            $xemnhieu = $this->db->get('tblarticle');
                                            if ($xemnhieu->num_rows() > 0) {
                                                $dem_xn = 1;
                                            ?>
                                                <ul>
                                                    <?php
                                                    foreach ($xemnhieu->result() as $item_xn) {
                                                    ?>
                                                        <li class="xem_nhieu_popup" data-id="<?php echo $item_xn->id; ?>">
                                                            <a style="cursor:pointer" title="<?php echo htmlspecialchars($item_xn->title); ?>" class="img120x75 pos-rlt">
                                                                <img class="img120x75" src="<?php echo $item_xn->thumb; ?>" alt="<?php echo htmlspecialchars($item_xn->title); ?>">
                                                                <span class="number"><?php echo $dem_xn; ?></span>
                                                            </a>
                                                            <div class="title-box-wc-2018"><a style="cursor:pointer" title="<?php echo htmlspecialchars($item_xn->title); ?>"><?php echo $item_xn->title; ?></a></div>
                                                            <span class="timeago"><?php echo get_time(strtotime($item_xn->date_day)); ?></span>
                                                            <div class="clearfix"></div>
                                                        </li>
                                                    <?php
                                                        $dem_xn++;
                                                    }
                                                    $xemnhieu->free_result();
                                                    ?>
                                                </ul>
                                            <?php
                                            }
                                            ?>
                                            <div class="clearfix"></div>
                                        </div>



                                    </div>
                                </div>


                    </section> -->

                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div id="list-news1_all">
                    <?php $this->load->view('elements/ads') ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


</div>
</div>
</div>
<div class="clearfix"></div>
</div>
<?php $this->load->view('modal/detail_modal') ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#click_like").click(function() {
            var id = '<?php echo $query1->id; ?>';
            $.ajax({
                cache: false,
                type: "POST",
                data: {
                    id: id
                },
                url: "<?php echo site_url('site/dolike/'); ?>",
                success: function(html) {
                    $("#like_number").html(html);
                }
            });
        });
        $('#share_post a[href^="#"]').on('click', function(event) {
            var target = $($(this).attr('href'));

            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 500);
            }
            return false;
        });
    });

    function fbShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 3) - (winHeight / 3);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('https://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
</script>
<script>
    var app_ct = new Vue({
        el: '#app_ct',
        data: {
            allTag: [],
            article_title: '',
            date_time: '',
            description: '',
            content: '',
            chiase: '',
            tag_view: '',
            facebook_comment: ''
        },
        methods: {
            fetchAllTag: function() {
                axios.post('<?php echo site_url('api/api_tag'); ?>', {
                    id: '<?php echo $query1->id; ?>',
                    action: 'fetchAllTag'
                }).then(function(response) {
                    app_ct.allTag = response.data;
                });
            },
            fetchAllNewCt: function() {
                axios.post('<?php echo site_url('api/api_news_ct'); ?>', {
                    id: '<?php echo $query1->id; ?>',
                    action: 'fetchNewCt'
                }).then(function(response) {
                    app_ct.article_title = response.data.article_title;
                    app_ct.date_time = response.data.date_time;
                    app_ct.description = response.data.description;
                    app_ct.content = response.data.content;
                    app_ct.chiase = response.data.chiase;
                    app_ct.tag_view = response.data.tag_view;
                    app_ct.facebook_comment = response.data.facebook_comment;
                });
            },
        },
        created: function() {
            this.fetchAllNewCt();
            this.fetchAllTag();
        }
    });
</script>