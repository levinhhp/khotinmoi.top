<!DOCTYPE html>
<html>
<head>
<title>Đăng nhập hệ thống</title>
<base href="<?php echo base_url(); ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Slide Login Form template Responsive, Login form web template, Flat Pricing tables, Flat Drop downs Sign up Web Templates, Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

	 <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

	<!-- Custom Theme files -->
	<link href="backend/css/login.css" rel="stylesheet" type="text/css" media="all" />
	<link href="backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
	<!-- //Custom Theme files -->

	<!-- web font -->
	<link href="//fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
	<!-- //web font -->

</head>
<body>

<!-- main -->
<div class="w3layouts-main"> 
	<div class="bg-layer">
		<h1>Đăng nhập hệ thống</h1>
		<div class="header-main">
			<div class="main-icon">
				<span class="fa fa-eercast"></span>
			</div>
			<div class="header-left-bottom">				
				<?php echo form_open('/adminhp/doLogin/',['method'=>'POST']); ?>
					<div class="icon1">
						<span class="fa fa-user"></span>						
						<?php echo form_input('username',null,['placeholder'=>'Tài khoản','required'=>'']) ?>
					</div>
					<div class="icon1">
						<span class="fa fa-lock"></span>						
						<?php echo form_password('password',null,['placeholder'=>'Mật khẩu','required'=>'']) ?>
					</div>
					<div class="login-check">
						 <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i> Ghi nhớ mật khẩu</label>
					</div>
					<div class="bottom">
						<button class="btn">Đăng nhập</button>
					</div>					
				<?php echo form_close(); ?>	
			</div>			
		</div>
	</div>
</div>	
<!-- //main -->

</body>
</html>