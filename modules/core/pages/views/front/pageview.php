<?php
if ($this->postedData['page_id'] <> HOME_PAGE) {
?>
<!--<div class="top-full-tarea">
    <div class="full-ttlleft">
        <p><?php echo $this->postedData['title']?></p>
    </div>
</div>-->
<?php
}
?>
<div class="row">
	<div class="col-xs-12">
	<?php
	$content = $this->postedData['content'];
	ISP ::parseContent($content);
	?>
	</div>
</div>
<p>&nbsp;</p>