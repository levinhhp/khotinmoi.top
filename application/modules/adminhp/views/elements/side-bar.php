<?php 
$CI=&get_instance();
$CI->load->model('admin/admin_model');
$users = $CI->admin_model->getUserByValue('tbladmin','id',$_SESSION['uid']);
?>
<section class="sidebar">
	<div class="user-panel">
		<div class="pull-left image">
			<?php 
				if($users->num_rows()>0){
					if($users->row()->avatar=='')
					{
					?>
					<img style="border:1px solid #fff;" src="backend/img/noimage.png" class="img-circle" />
					<?php
					}
					else
					{
					?>
					<img src="<?php echo $users->row()->avatar; ?>" class="img-circle" />
					<?php
					}
				}else{	
					?>
					<img src="assets/noimage.png" class="img-circle" />
					<?php 
				}
			?>
		</div>
		<div class="pull-left info">
			<p>
				<?php 
					if($users->num_rows()>0){
						echo $users->row()->name;
					}
				?>
			</p>
		</div>
	</div>
	<ul class="sidebar-menu">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i><span>Trang chủ</span></a></li>				
		<li><a href="javascript:;">
			<i class="fa fa-bar-chart" aria-hidden="true"></i><span>Thống kê</span>
			<span class="pull-right-container" data-original-title="" title=""><i class="fa fa-angle-left pull-right" data-original-title="" title=""></i></span>
		</a>
			<ul class="treeview-menu">			
				<li><a href="<?php echo site_url('adminhp/statistic'); ?>" title="Thống kê bài viết"><i class="fa fa-circle-o text-primary"></i>Thống kê bài viết</a></li>
			</ul>
		</li>			
		<?php 									
			foreach($this->config->item('side_bar_table') as $k_side=>$v_side)
			{					
				if(count($v_side['side_bar_table'])==1)				
				{									
					$listOfTableName1=$table_list;
					foreach($table_list as $k_test=>$item)
					{
						foreach($v_side['side_bar_table'] as $item_sub)	
						{
							if($item_sub==$k_test)
							{
								$this->db->where('username',$_SESSION['uid']);
								$userole_tact=$this->db->get('tblrole');    
								$demleft2=0;
								foreach($userole_tact->result() as $userole_tact)
								{
									if($item==$userole_tact->table_label)
									{
									?>
									<li class="treeview"><a href="<?php echo site_url('adminhp/viewContent/'.key($listOfTableName1)) ?>"><?php echo $v_side['side_bar_icon']; ?><span><?php echo $v_side['side_bar_name']; ?></span></a></li>
									<?php	
									}
								}	
							}	
						}
						next($listOfTableName1);	
					}
				?>				
				<?php
				}
				else{	
					$data_bat = 0;
					$listOfTableName=$table_list;
					foreach($table_list as $k_test=>$item){
						foreach($v_side['side_bar_table'] as $item_sub)	{
							foreach($v_side['side_bar_table'] as $item_sub)	{
								if($item_sub==$k_test){
									$this->db->where('username',$_SESSION['uid']);
									$userole_tact=$this->db->get('tblrole');
									foreach($userole_tact->result() as $userole_tact){
										if($item==$userole_tact->table_label){
											$data_bat = 1;	
										}
									} 
								}
							}
						}
					}	
					if($data_bat == 1){
					?>
					<li class="treeview"><a href="javascript:;"><?php echo $v_side['side_bar_icon']; ?><span><?php echo $v_side['side_bar_name']; ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
						<ul class="treeview-menu">
							<?php 
								$listOfTableName=$table_list;
								$demleft=1;								
								foreach($table_list as $k_test=>$item)
								{									
									foreach($v_side['side_bar_table'] as $item_sub)														
									{									
										if($item_sub==$k_test)
										{										
											$this->db->where('username',$_SESSION['uid']);
											$userole_tact=$this->db->get('tblrole');  										
											$demleft2=0;
											foreach($userole_tact->result() as $userole_tact)
											{											
												if($item==$userole_tact->table_label)
												{
												?>
												<li><a href="<?php echo site_url('adminhp/viewContent/'.key($listOfTableName)) ?>"><i class="fa fa-circle-o text-primary"></i><?php echo $item; ?></a></li>
												<?php
												}
												$demleft2++;	
											}									
										}
									}
									next($listOfTableName);
									$demleft++;
								}
							?>						
						</ul>
					</li>
					<?php 
					}
				?>
				<?php
				}				
			}
		?>		
	</ul>                                    
</section>