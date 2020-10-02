<section class="collapse_area myorders-area">
    <div class="container">
        <div class="row">
        		<div class="col-xs-12 col-sm-3">
                <?php $this->loadTheme('customer-sidebar');?>
        		</div>

            <div class="panel col-xs-12 col-sm-9 my-orders"></div>
    </div>
</section>
<script type="text/javascript">
<?php
if ($_GET['orderno'] <> '') {
?>
    jQuery(document).ready(function() {
        jQuery.ajax({
                url: "<?php echo ISP :: FrontendUrl('orders/getmyorderdetails/id/'.$_GET['orderno']);?>",
            context: document.body
        }).done(function(data) {
            jQuery('.my-orders').html(data.data);
        });
    });
<?php
}
else {
?>
jQuery(document).ready(function() {
		jQuery.ajax({
			url: "<?php echo ISP :: FrontendUrl('orders/getmyorders');?>",
		  context: document.body
		}).done(function(data) {
		  jQuery('.my-orders').html(data.data);
		});
});
<?php
}
?>
</script>