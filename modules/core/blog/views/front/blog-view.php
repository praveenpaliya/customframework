<div class="top-full-tarea">
    <div class="full-ttlleft">
        <h1><?php echo $this->postedData['title']?></h1>
        <p><?php echo strftime('%d %b, %Y', strtotime($this->postedData['add_date']));?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
		<img src="<?php echo SITE_URL.SITE_UPLOADPATH.$this->postedData['image'];?>" alt="<?php echo $this->postedData['title']?>" title="<?php echo $this->postedData['title']?>">
	</div>
	<div class="col-xs-12">
		<?php
			$content = $this->postedData['content'];
			ISP ::parseContent($content);
		?>
	</div>
	<div class="col-xs-12 pull-left productdetails">
      <div class="addthis_inline_share_toolbox_setn"></div>
      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ppaliya"></script>
  </div>
</div>