<!DOCTYPE HTML>
<!--[if IE 7]><html class="ie ie7" lang="vi" prefix="og: https://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="vi" prefix="og: https://ogp.me/ns#"> <![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html lang="vi" prefix="og: https://ogp.me/ns#">
<!--<![endif]-->
<?php
echo header('Content-type: text/html; charset=utf-8');
?>

<head>
    <?php
    $offset = 60 * 15;
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");
    header("Cache-Control: max-age=$offset, must-revalidate");
    ?>
    <base href="<?php echo base_url(); ?>">
    <title>
        <?php
        $CI = &get_instance();
        $CI->load->model('site/site_model');
        $data_select = 'title,description,keyword';
        $meta = $CI->site_model->gettablename('tblmeta', $data_select, '');
        if (isset($home)) {
            echo $meta->title;
        } else {
            echo $header_title;
        }
        ?>
    </title>
    <meta name="google-signin-client_id" content="<?php echo CLIENT_ID; ?>">
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <meta name="description" content="<?php
                                        if (isset($home)) {
                                            echo $meta->description;
                                        } else {
                                            echo $description;
                                        } ?>" />
    <meta name="keywords" content="<?php
                                    if (isset($home)) {
                                        echo $meta->keyword;
                                    } else {
                                        echo $keyword;
                                    }
                                    ?>" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta name="facebook-domain-verification" content="mx0px21qg6p2jx01hqjjwyzq7e4m9e" />
    <link rel="shortcut&#32;icon" href="frontend/images/favicon.ico" type="image/x-icon" />
    <link href="frontend/css/style.css" rel="stylesheet" type="text/css">
    <link href="frontend/css/tienpv.css" rel="stylesheet" type="text/css">
    <script src="frontend/js/vue.min.js"></script>
    <script src="frontend/js/axios.min.js"></script>
    <script src="frontend/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script>
        /*function Google_signIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log('ID: ' + profile.getId());
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail());
            //pass information to server to insert or update the user record
            update_user_data(profile);
            $('.modal_login').hide();            
        }
        function update_user_data(response){
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: response,
                url: '<?php echo site_url('site/check_google'); ?>',
                success: function(msg) {
                    if(msg.error== 1){
                        alert('Something Went Wrong!');
                    }                      
                }
            });
        }*/
    </script>
    <?php
    if (isset($home)) {
    ?>
        <script src="frontend/js/jquery.jConveyorTicker.min.js" type="text/javascript"></script>
        <script>
            $(function() {
                $('.js-conveyor-1').jConveyorTicker();
            });
        </script>
    <?php
    }
    ?>
    <?php
    if (isset($ct)) {
        $this->db->where('id', $ct);
        $this->db->select('title,description,image');
        $sql_fb_new = $this->db->get('tblarticle')->row();
    ?>
        <meta property="og:title" content="<?php echo $sql_fb_new->title; ?>">
        <meta property="og:description" content="<?php echo $sql_fb_new->description; ?>">
        <meta property="og:image" content="<?php echo base_url() . $sql_fb_new->image; ?>">
    <?php
    } else {
    ?>
        <meta property="og:title" content="<?php
                                            if (isset($home)) {
                                                echo $meta->title;
                                            } else {
                                                echo $header_title;
                                            }
                                            ?>" />
        <meta property="og:description" content="<?php
                                                    if (isset($home)) {
                                                        echo $meta->description;
                                                    } else {
                                                        echo $description;
                                                    } ?>" />
    <?php
    }
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-188143194-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-188143194-1');
    </script>
</head>

<body>
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '609690863256420');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=609690863256420&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->
    <?php
    if (isset($home)) {
    ?>
        <div id="keyword_home">
            <h1>Kho Tin Mới</h1>
            <h4>Tin tức Mới</h3>
        </div>
    <?php
    }
    ?>
    <div id="admWrapsite">
        <div class="wapper">
            <header>
                <?php $this->load->view('elements/header') ?>
            </header>
            <section id="content">
                <?php $this->load->view($main_content) ?>
                <div class="clearfix"></div>
            </section>
            <footer>
                <?php $this->load->view('elements/footer') ?>
            </footer>
        </div>
    </div>
    <link href="frontend/mobile/css/tiencss.css" rel="stylesheet" type="text/css">  
</body>

</html>