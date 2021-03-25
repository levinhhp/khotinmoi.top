<?php 
$CI=&get_instance();
$CI->load->model('admin/admin_model');
?>
<section class="content-header">
	<h1>Trang chủ</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>
		<li class="active">Trang chủ </li></ol>                
</section>
<section class="content">
	<div class="box box-primary borderless">
		<div class="box-header">
			<div class="pull-left">
				<h3 class="box-title"><i class="fa fa-info-circle"></i>Trang chủ</h3>
			</div>
			<div class="pull-right"></div>
			<div class="clearfix"></div>
		</div>
		<div class="box-body">
			<div class="row boxes-mw-wrapper">
				<?php 
					$data_bat_home = 0;
					foreach($this->config->item('breadcrumb_table') as $item_home)
					{		
						$this->db->where('username',$_SESSION['uid']);
						$userole_tact=$this->db->get('tblrole');
						foreach($userole_tact->result() as $userole_tact){					
							if($item_home['table_name']==$userole_tact->table_name){																																			
							?>
							<div class="<?php echo $item_home['table_column']; ?>">
								<div class="small-box">
									<div class="inner">
										<div class="middle">
											<?php 
												$home_count = $CI->admin_model->getTableAll($item_home['table_name']);
											?>
											<h4><a href="<?php echo site_url('adminhp/viewContent/'.$item_home['table_name']); ?>"><?php echo $home_count->num_rows(); ?></a></h4>
											<p style="font-size:14px;"><?php echo $item_home['table_label']; ?></p>
										</div>
									</div>
									<div class="icon">								
										<?php echo $item_home['table_list_icon']; ?>                          
									</div>
								</div>
							</div>
							<?php 
							}
						}	
					}
				?>				
			</div>

		</div>
	</div>
</section>