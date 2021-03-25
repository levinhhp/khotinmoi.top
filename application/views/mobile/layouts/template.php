<!DOCTYPE HTML>
<!--[if IE 7]><html class="ie ie7" lang="vi" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="vi" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html lang="vi" prefix="og: http://ogp.me/ns#">
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
            $data_select='title,description,keyword';
            $meta = $CI->site_model->gettablename('tblmeta',$data_select,'');
            if(isset($home))
            {
                echo $meta->title;
            }
            else
            {
                echo $header_title;
            }
        ?>
    </title>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />	
    <meta name="description" content="<?php
    if(isset($home))
    {
        echo $meta->description;
    }
    else
    {
        echo $description;
    }?>" />
    <meta name="keywords" content="<?php
    if(isset($home))
    {
        echo $meta->keyword;
    }
    else
    {
        echo $keyword;
    }
    ?>"/>    
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />    
    <link rel="shortcut&#32;icon" href="frontend/images/favicon.ico" type="image/x-icon" />
    <link href="frontend/mobile/css/style.css" rel="stylesheet" type="text/css">    
    <link href="frontend/mobile/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
    <script src="frontend/mobile/js/jquery-3.4.1.min.js" type="text/javascript"></script>  
    <script type="text/javascript" src="frontend/mobile/js/jquery-simple-mobilemenu.min.js"></script>    
    <script type="text/javascript" src="frontend/mobile/js/custom_mobile.js">
    </script>
    <?php 
        if(isset($ct)){     
            $this->db->where('id',$ct);
            $this->db->select('title,description,image');
            $sql_fb_new = $this->db->get('tblarticle')->row();   
        ?>
        <meta property="og:title" content="<?php echo $sql_fb_new->title; ?>">
        <meta property="og:description" content="<?php echo $sql_fb_new->description; ?>">
        <meta property="og:image" content="<?php echo base_url().$sql_fb_new->image; ?>">  
        <?php 
        }else{
        ?>
        <meta property="og:title" content="<?php
            if(isset($home))
            {
                echo $meta->title;
            }
            else
            {
                echo $header_title;
            }
        ?>" />
        <meta property="og:description" content="<?php
        if(isset($home))
        {
            echo $meta->description;
        }
        else
        {
            echo $description;
        }?>" />
        <?php
        }
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-164486332-10"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-164486332-10');
    </script> 
    <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '609690863256420');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=609690863256420&ev=PageView&noscript=1"
/></noscript>
</head>

<body> 
    <header>
        <?php $this->load->view('mobile/elements/header') ?>        
    </header>
    <section id="main_content">
        <?php $this->load->view($main_content) ?>
    </section>
    <footer>
        <?php $this->load->view('mobile/elements/footer') ?>
    </footer>
<?php 
             $this->db->where('status',1);
             $this->db->order_by('id','random');
             $this->db->limit(1);
             $sqlads_popup = $this->db->get('tblads');
             if($sqlads_popup->num_rows()>0){
             ?>
    <div class="modal">
    <div class="modal-content">   
        <span class="close"><i class="fa fa-times" aria-hidden="true"></i></span>           
             <a href="<?php echo $sqlads_popup->row()->link; ?>" target="_blank" title="<?php echo $sqlads_popup->row()->title; ?>"><img src="<?php echo $sqlads_popup->row()->image; ?>" title="<?php echo $sqlads_popup->row()->title; ?>" alt="<?php echo $sqlads_popup->row()->title; ?>"></a>
             
    </div>
  </div>
<?php 
             }
        ?>
  <script type="text/javascript">
$(document).ready(function () {
  var modal = $('.modal');
  var span = $('.close');
    window.setTimeout(function(){modal.show();},5000);
    span.click(function () {
        modal.hide();
    });
    $(window).on('click', function (e) {          
        modal.hide();       
    });
});
</script>        
</body>
</html>