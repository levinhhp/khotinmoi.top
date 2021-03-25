<?php
$CI = &get_instance();
$CI->load->model('site/site_model');
$danhmucmenu = $CI->site_model->getTableParent(0, 'tblarticle_category', 'id,category,menu,parent_id,ordernum,status', '', 'menu', 1);
$danhmucmenu_show = $CI->site_model->getTableParent(0, 'tblarticle_category', 'id,category,parent_id,ordernum,status', '', '', '');
?>
<div id="crudHeader">
	<!-- <div class="header-adss">
			<div class="header-logo">
				<img src="https://localhost/khotinmoi.com/frontend/images/logo_2.jpg" alt="">
			</div>
			<div class="banner-qc">
				<img src="upload/20140712112436-anh-choi-010-min_thumb.jpg" alt="">
				<p>Hỏa hoạn xảy ra tại một phòng trọ ở Hà Nội khiến 4 thanh niên tử vong.</p>
			</div>
			<div class="banner-qc">
				<img src="upload/20140712112436-anh-choi-010-min_thumb.jpg" alt="">
				<p>Hỏa hoạn xảy ra tại một phòng trọ ở Hà Nội khiến 4 thanh niên tử vong.</p>
			</div>
			<div class="banner-qc">
				<img src="upload/20140712112436-anh-choi-010-min_thumb.jpg" alt="">
				<p>Hỏa hoạn xảy ra tại một phòng trọ ở Hà Nội khiến 4 thanh niên tử vong.</p>
			</div>

		</div> -->
	<div class="header-adss">
		<div class="qc-newdetail">
			<div data-id="432" class="swiper-slide xem_nhieu_popup">
				<img src="https://localhost/khotinmoi.com/frontend/images/logo_2.jpg" alt="">
				<div class="clearfix"></div>
			</div>
			<div data-id="432" class="swiper-slide xem_nhieu_popup">
				<div class="swiper_slide_all">
					<img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="">
					<p>Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?</p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div data-id="432" class="swiper-slide xem_nhieu_popup">
				<div class="swiper_slide_all">
					<img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="">
					<p>Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?</p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div data-id="432" class="swiper-slide xem_nhieu_popup">
				<div class="swiper_slide_all">
					<img src="upload/benh_nhan_nam_phi_cong-min_thumb.jpg" alt="">
					<p>Vì sao Việt Nam có nhiều ca Covid-19 tử vong giai đoạn mới?</p>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="clearfix"></div>
		</div>
	</div>
	<nav id="bg_menu">
		<div class="desk">
			<div class="w980">
				<div id="menu">
					<div id="logo" v-html="logo_header"></div>
					<div id="toggleMenu">
						<ul>

							<li class="content-left fl">
								<ul class="breadcrumb">
									<li>
										<a href="https://localhost/khotinmoi.com/" title="Kho Tin mới">Trang chủ</a>
									</li>
									<li><a href="https://localhost/khotinmoi.com/tin-tuc.html" title="Tin tức">Tin tức</a></li>
									<li><a href="https://localhost/khotinmoi.com/covid.html" title="Covid">Covid</a></li>
								</ul>
							</li>

						</ul>
						<div class="clearfix"></div>
					</div>
					<?php
					if (isset($_SESSION['username_frontend'])) {
						$this->db->where('status', 1);
						$this->db->where('username', $_SESSION['username_frontend']);
						$sql_info_frontend = $this->db->get('tbluser');
						if ($sql_info_frontend->num_rows() > 0) {
							if ($sql_info_frontend->row()->thumb != '') {
								$thumb_front = $sql_info_frontend->row()->thumb;
							} else {
								$thumb_front = 'frontend/images/noimage.png';
							}
						} else {
							$thumb_front = 'frontend/images/noimage.png';
						}
					?>
					<?php
					} else {
					?>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</nav>
</div>
<div class="banner-top w980">