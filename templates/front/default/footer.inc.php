<footer class="footer">
    <div class="container">
		<div class="row">
		<div class="col-md-2">
			<div class="footerpart">
			<h2>Collections</h2>
				<?php 
          $objMenu = new menu();
          echo $objMenu->setMenu('menu_1574615133684', 'metismenu','submenu collapse');
        ?> 
			</div>
			</div>
			<div class="col-md-2">
			<div class="footerpart">
			<h2>Information</h2>
				<?php
					echo $objMenu->setMenu('menu_1574615336645', 'metismenu','submenu collapse');
        ?>
			</div>
			</div>
			<div class="col-md-3">
			<div class="footerpart">
			<h2>Contact us</h2>
				<ul>
				<li><i class="fa fa-phone"></i> (813) 538-3370</li>
					<li><i class="fa fa-envelope"></i> hello@eternityletter.com</li>
					<li><i class="fa fa-location-arrow"></i> 16243 Ivy Lake Drive<br>Odessa, Florida 33556</li>
				</ul>
			</div>
			</div>
			<div class="col-md-2">
			<div class="footerpart socialmedia">
			<h2>Connect</h2>
				<ul>
				<li><a href="https://facebook.com/eternityletter" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="https://twitter.com/eternityletter"  target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="https://instagram.com/eternityletters"  target="_blank"><i class="fa fa-instagram"></i></a></li>
					<li><a href="https://pinterest.com/eternityletter"  target="_blank"><i class="fa fa-pinterest"></i></a></li>
					<li><a href="https://www.linkedin.com/in/inna-gaker/"  target="_blank"><i class="fa fa-linkedin"></i></a></li>
					<li><a href="https://www.youtube.com/channel/UCPaRWT9vNpOFIqQyAZc81tQ/"  target="_blank"><i class="fa fa-youtube"></i></a></li>
				</ul>
			</div>
			</div>
			<div class="col-md-3">
			<div class="footerpart">
				<form method="post" name="frmnewsletter" action="<?php echo SITE_URL.'newsletter/newsletterSubscription';?>">
					<h2>Newsletter</h2>
					<p>Promotions, new products and sales.<br>Directly to your inbox.</p>
					<input type="email" placeholder="Enter your email address..." required="true" name="email">
					<button type="submit">Join</button>
				</form>
			</div>
			</div>
		</div>
		<div class="row">
		<div class="footer-bottom">
			<div class="col-md-8">
			<p>© <?php echo date('Y');?> Eternity Letter, All rights reserved. | Site Design: Joker Media</p>
			</div>
			<div class="col-md-4">
			<img src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/img/payment.png">
			</div>
			</div>
		</div>
		</div>
	</footer>