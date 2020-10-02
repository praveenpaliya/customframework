<div class="row">
	<?php 
	foreach ($this->pageData as $blog) {
	?>
	<div class="col-xs-12 bloglist">
		<div class="row">
			<div class="col-xs-12 col-sm-3 blog_post_thumb">
				<a href="<?php echo $this->getUrl($this->blogUrl.'pagedetails/postid/'.$blog->blog_id);?>"><img src="<?php echo SITE_URL.SITE_UPLOADPATH.$blog->image;?>" alt=""></a>
			</div>
			<div class="col-xs-12 col-sm-9">
				<div class="date">
					<p><?php echo strftime('%d %b, %Y', strtotime($blog->add_date));?></p>
				</div>
				<div class="titleblog">
					<h2><a href="<?php echo $this->getUrl($this->blogUrl.'pagedetails/postid/'.$blog->blog_id);?>"><?php echo $blog->title;?></a></h2>
					<p><?php echo substr(strip_tags($blog->content), 0, 550).'...';?></p>
					<p><a href="<?php echo $this->getUrl($this->blogUrl.'pagedetails/postid/'.$blog->blog_id);?>"><button class="btn btn-primary">Read More</button></a></p>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>