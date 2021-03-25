
<div class="modal">
    <div class="modal-content">      
		<div id="load_popup"></div>
		<!--<span class="close">&times;</span>-->
    </div>
  </div>
  
<script type="text/javascript">
$(document).ready(function () {
  var modal = $('.modal');
  var btn = $('.xem_nhieu_popup');
  var span = $('.close');

  btn.click(function () {
	var id = jQuery(this).attr('data-id');                    
			jQuery.ajax({
				cache:false,
				type:"POST",
				data:{id : id},
				url:"<?php echo site_url('site/showPopup'); ?>", 
				success:function(html){
					jQuery("#load_popup").html(html);                            
					modal.show();                  
				}                                                          
			});                     
  });

  span.click(function () {
    modal.hide();
  });

  $(window).on('click', function (e) {
    if ($(e.target).is('.modal')) {
      modal.hide();
    }
  });
});
</script>        