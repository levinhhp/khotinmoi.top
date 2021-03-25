<!DOCTYPE html>
<html dir="ltr">
<head>
    <base href="<?php echo base_url() ?>">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="backend/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/ionicons.min.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/adminlte.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/style.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/skin-green.css" />
    <link rel="stylesheet" type="text/css" href="backend/css/search.css" />
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.css" />
    <script type="text/javascript" src="backend/js/jquery.min.js"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="ckfinder/ckfinder.js"></script> 			  
	<link type="text/css" rel="stylesheet" href="backend/css/jquery-ui.css">
    <script type="text/javascript" src="backend/js/jquery-ui.js"></script>
	<script type="text/javascript" src="backend/js/custom_admin.js"></script>
    <script type="text/javascript" src="backend/js/drag-drop-editor.js"></script>
    <script type="text/javascript" src="backend/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="backend/js/knockout.min.js"></script>
    <script type="text/javascript" src="backend/js/notify.js"></script>
    <script type="text/javascript" src="backend/js/adminlte.js"></script>
    <script type="text/javascript" src="backend/js/cookie.js"></script>
    <script type="text/javascript" src="backend/js/app.js"></script>
    <script type="text/javascript" src="backend/js/dashboard.js"></script>
    <script type="text/javascript" src="backend/js/search.js"></script> 
    <script type="text/javascript" src="vendor/select2/select2.js"></script>    
    <script type="text/javascript">   
        $(document).ready(function() {            
            $('#cmbdanhmuc1').select2();
            $('#cmbdanhmuccon').select2();
            $('#parent_id').select2();
            $("#ten_tt").keyup(function(){                                            
                var key = $(this).val();      
                $.ajax({
                    type: "post", 
                    data: {key:key},
                    url: "<?php echo site_url('adminhp/rwurl/')?>",
                    success: function(html)
                    {
                        var html=html+'.html'
                        $('#alias').val(html);
                        $.ajax({
                            type: "post", 
                            data: {html:html},
                            url: "<?php echo site_url('adminhp/checkurl/')?>",
                            success: function(html)
                            {
                                if(html=='trung')
                                {
                                    $('.khongkhadung').show();
                                    $('.khadung').hide();
                                }
                                else
                                {
                                    $('.khongkhadung').hide();
                                    $('.khadung').show();
                                }
                            }
                        });
                    }
                });
                return false; 
            });
            $("#alias").keyup(function(){
                var html = $(this).val();  
                $.ajax({
                    type: "post", 
                    data: {html:html},
                    url: "<?PhP echo site_url('adminhp/checkurl/')?>",
                    success: function(html)
                    {
                        if(html=='trung')
                        {
                            $('.khongkhadung').show();
                            $('.khadung').hide();
                        }
                        else
                        {
                            $('.khongkhadung').hide();
                            $('.khadung').show();
                        }
                    }
                });
                return false;
            });
        });
    </script>
    <title>Quản trị hệ thống</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Quản trị hệ thống">
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="sidebar-mini skin-green ctrl-dashboard act-index">

<div class="modal fade modal-search" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="search-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="search-wrapper">
                    <form id="search-modal-form" autocomplete="off" action="/backend/search" method="GET">					<div class="search-input">
                        <input autocomplete="off" name="term" id="search-term" type="text" placeholder="Enter search keyword">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    </form>					<div id="search-results-wrapper"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
	<?php $this->load->view('elements/header') ?>
    <aside class="main-sidebar">
		<?php $this->load->view('elements/side-bar') ?>
    </aside>
    <div class="content-wrapper">
         <?php 
			  if(isset($AdminChangeInfor))
			  {
				 $this->load->view('elements/changeinfor');
			  }
			  elseif(isset($file_manager))
			  {
				 $this->load->view('elements/filemanager');
			  }
			  else
			  {
				$this->load->view('elements/main_content');
			  }
		?>
    </div>
	<?php $this->load->view('elements/footer')?>
</div>
</body>
</html>