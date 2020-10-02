<div class="row">
	<?php 
	foreach ($this->pageData as $blog) {
	?>
	<div class="col-md-4 col-xs-12 col-sm-6">
		<div class="bloglists">
			<a href="<?php echo $this->getUrl($this->blogUrl.'pagedetails/postid/'.$blog->blog_id);?>"><img src="<?php echo SITE_URL.SITE_UPLOADPATH.$blog->image;?>" alt=""></a>
			<div class="date">
				<p><?php echo strftime('%d %b, %Y', strtotime($blog->add_date));?></p>
			</div>
			<div class="titleblog">
				<h2><a href="<?php echo $this->getUrl($this->blogUrl.'pagedetails/postid/'.$blog->blog_id);?>"><?php echo $blog->title;?></a></h2>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>