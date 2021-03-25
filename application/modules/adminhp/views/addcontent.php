<section class="content-header">
	<h1><?php echo element($table_name,$table_list); ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>
		<li><?php echo element($table_name,$table_list); ?> </li>
		<li class="active">
			<?php 
				if(isset($is_edit)){
					echo 'Sửa';
				}
				else{
					echo 'Thêm mới';
				}
			?>
		</li>
	</ol>                
</section>
<section class="content">
	<div class="box box-primary borderless">
		<div class="box-header">
				<div class="pull-left">
					<h3 class="box-title"><i class="fa fa-info-circle"></i><?php echo element($table_name,$table_list); ?></h3>
				</div>
				<div class="pull-right"></div>
				<div class="clearfix"><!-- --></div>
		</div>
		<div class="box-body">
		<?php		
			if(isset($message['error']))
			{
			?>
			<div class="message error">
				<h2>Lỗi</h2>
				<p><?php echo $message['error'] ?></p>
			</div>
			<?php
			}
			if(isset($message['success']))
			{
			?>
			<div class="message success close">
				<h2>Nhập dữ liệu thành công!</h2>
				<p><?php echo $message['success']; ?></p>
			</div>
			<?php
			}
			if(isset($message['warning']))
			{
			?>
			<div class="alert alert-warning" role="alert">				
				<p><?php echo $message['warning']; ?></p>
			</div>
			<?php
			}
			if(isset($is_edit)){
				echo form_open_multipart('/adminhp/doeditcontent/'.$table_name.'/'.$primaryKey,['id'=>'frmAddContent','method'=>'POST','autocomplete'=>'off']);
			}else{
				echo form_open_multipart('/adminhp/doaddcontent/'.$table_name,['id'=>'frmAddContent','method'=>'POST','autocomplete'=>'off']);
			}
			?>
			<div class="row">
				<?php 
					$data['table_name'] = $table_name;
					$data['labels'] = $labels;
					$this->load->view('form/form',$data) 
				?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</section>