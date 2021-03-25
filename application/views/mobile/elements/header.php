<?php 
$CI=&get_instance();
$CI->load->model('site/site_model');
$header_mobile = $this->site_model->gettablename('tblinformation','company_name,logo','');
$danhmucmenu=$CI->site_model->getTableParent(0,'tblarticle_category','id,category,menu,image,parent_id,ordernum,status','','menu',1);
?>
<div id="bg_header">
	<div class="logo_mb"><a href="<?php echo base_url(); ?>" title="<?php echo $header_mobile->company_name; ?>"><img src="<?php echo $header_mobile->logo; ?>" title="<?php echo $header_mobile->company_name; ?>" alt="<?php echo $header_mobile->company_name; ?>"></a></div>
	<div class="search_mobile"><i class="fa fa-search" aria-hidden="true"></i></div>
	<div id="search_form_mobile">
		<form name="frmsearch_mobile" method="POST" action="<?php echo site_url('tim-kiem.html'); ?>">
			<input type="text" name="title" placeholder="Nội dung cần tìm">
			<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
		</form>
	</div>
</div>
<ul class="mobile_menu">		
		<li><a href="<?php echo base_url(); ?>" title="<?php echo $header_mobile->company_name; ?>">Trang chủ</a></li>
		<?php 
			if($danhmucmenu->num_rows()>0){
				foreach($danhmucmenu->result() as $item_danhmuc_mb){
				?>
				<li>
					<a href="<?php echo site_url(danhmucbaiviet($item_danhmuc_mb->id)); ?>" title="<?php echo $item_danhmuc_mb->category; ?>"><?php echo $item_danhmuc_mb->category; ?></a>
					<?php 
						$danhmucmenu_sub_con=$CI->site_model->gettablename_all('tblarticle_category','id,category,menu,parent_id,ordernum,status','','parent_id',$item_danhmuc_mb->id);
						if($danhmucmenu_sub_con->num_rows()>0){
						?>
						<ul class="submenu">	
							<?php 
								foreach($danhmucmenu_sub_con->result() as $item_dm_sub_mb){
								?>					
								<li>
									<a href="<?php echo site_url(danhmucbaiviet($item_dm_sub_mb->id)); ?>" title="<?php echo $item_dm_sub_mb->category; ?>"><?php echo $item_dm_sub_mb->category; ?></a>								
								</li>
								<?php 
								}
								$danhmucmenu_sub_con->free_result();
							?>
						</ul>
						<?php 
						}
					?>
				</li>
				<?php 
				}
				$danhmucmenu->free_result();
			}
		?>    
		<li><a href="<?php echo site_url('lien-he.html'); ?>" title="Liên hệ">Liên hệ</a></li>    
    </ul>