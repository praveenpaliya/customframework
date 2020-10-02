<div class="row">
	<div class="col-xs-12 page-wel">
	
	</div>
</div>
<p>&nbsp;</p>
<script type="text/javascript">
jQuery(document).ready(function() {
	var hash = window.location.hash;
		jQuery.ajax({
			url: "<?php echo ISP :: FrontendUrl('catalog/allcategorylist/ajax/1');?>",
		  context: document.body
		}).done(function(data) {
		  jQuery('.page-wel').html(data.data);
		  jQuery(window).scrollTop($(hash).offset().top);
		});
});
</script>