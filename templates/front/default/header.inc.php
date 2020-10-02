<div id="myOverlay" class="overlay">
  <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
  <div class="overlay-content">
    <form action="<?php echo SITE_URL;?>catalog/search">
      <input type="text" placeholder="Search.." name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>

<!-- header Top area--->
<section class="headertop">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="top-left">
					<p><i class="fa fa-truck" aria-hidden="true"></i> <b>Free shipping</b> on orders over <b>$150</b></p>
				</div>
			</div>
			
			<div class="col-sm-3 col-md-4 col-xs-12">
				<div class="top-center">
					<ul>
						<li><a href="https://facebook.com/eternityletter" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://twitter.com/eternityletter"  target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://instagram.com/eternityletters"  target="_blank"><i class="fa fa-instagram"></i></a></li>
						<li><a href="https://pinterest.com/eternityletter"  target="_blank"><i class="fa fa-pinterest"></i></a></li>
						<li><a href="https://www.linkedin.com/in/inna-gaker/"  target="_blank"><i class="fa fa-linkedin"></i></a></li>
					</ul>
				</div>
			</div>
			
			<div class="col-sm-5 col-md-4 col-xs-12">
				<div class="top-right">
					<ul>
						<li>
						<?php
						if (isset($_SESSION['uid']) && $_SESSION['customer_group'] == 1) {
						?>
							<a href="<?php echo ISP::FrontendUrl('customer/editprofile');?>"><i class="fa fa-lock"></i> My Account</a>
						<?php
						}
						else {
						?>
							<a href="<?php echo ISP::FrontendUrl('customer/login');?>"><i class="fa fa-lock"></i> Customer Login</a>
						<?php
						}
						?>
						</li>

						<li>
						<?php
						if (isset($_SESSION['uid']) && $_SESSION['customer_group'] == 4) {
						?>
							<a href="<?php echo ISP::FrontendUrl('customer/editprofile');?>"><i class="fa fa-lock"></i> My Account</a>
						<?php
						}
						else {
						?>
							<a href="<?php echo ISP::FrontendUrl('customer/distributor');?>"><i class="fa fa-lock"></i> Distributor Login</a>
						<?php
						}
						?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<!---- Header menu area --->
<section class="menupart">
	<div class="container">
		<div class="row">
			<div class="col-sm-5 nopadding smnopadding">
				
				
				
				<div class="menus hidden-lg hidden-md">
					<nav id="cssmenu">
						<div id="head-mobile"></div>
						<div class="button"></div>
						<ul>
						<li><a href="https://www.eternityletter.com/catalog">Shop</a>
							<ul>
							<li><a href="https://www.eternityletter.com/memorial-events">Memorial Events</a></li>
							<li><a href="https://www.eternityletter.com/birthdays">Birthday Letters</a></li>
							<li><a href="https://www.eternityletter.com/weddings">Graduations</a></li>
							<li><a href="https://www.eternityletter.com/baby-shower">Baby Shower, Naming, Baptism, Circumcision and other Events</a></li>
							<li><a href="https://www.eternityletter.com/forgiveness-letter">Forgiveness Letter</a></li>
							<li><a href="https://www.eternityletter.com/candle-holders">Candle Holders</a></li>
							<li><a href="https://www.eternityletter.com/personal-letters">Personal Goodbye Letters</a></li>
							<li><a href="https://www.eternityletter.com/animal-memorial">Remembering Our Pets</a></li>
							<li><a href="https://www.eternityletter.com/tree-of-life-letters">Eternity Letter Life Trees & Flowers</a></li>
							<li><a href="https://www.eternityletter.com/weddings-anniversaries-valentines-love-letters">Wedding, Anniversaries, Valentines & Love Letters</a></li>
							<li><a href="https://www.eternityletter.com/mothers-fathers-day">Mothers's & Father's Day</a></li>
							<li><a href="https://www.eternityletter.com/thank-you-letters">Thank You Letters</a></li>	
							</ul>
							</li>
							<li><a href="https://www.eternityletter.com/world-of-eternity-letter">World of Eternity Letter</a></li>
							<li><a href="https://www.eternityletter.com/blog">Blog</a></li>
							<li><a href="https://www.eternityletter.com/our-story">Our Story</a></li>
							<li><a href="https://www.eternityletter.com/frequently-asked-questions">FAQ</a></li>
							<li><a href="https://www.eternityletter.com/contact-us">Contact</a></li>
						</ul>
					</nav>
				</div>
				
				
				
				
				<div class="menus hidden-xs hidden-sm">
					<nav id="cssmenu">
						<div id="head-mobile"></div>
						<div class="button"></div>
						<?php 
		            	$objMenu = new menu();
		            	echo $objMenu->setMenu('menu_1573997725436', 'metismenu','submenu collapse nopadding');
		        		?> 
					</nav>
					</div>
			</div>
			
			<div class="col-sm-2 smnopadding">
				<div class="logo">
					<a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/img/logo.png" alt=""></a>
				</div>
			</div>
			
			<div class="col-sm-5 smnopadding">
				<div class="menus text-right">
					<nav id="cssmenu">
						<?php 
            	echo $objMenu->setMenu('menu_1576611025657', 'metismenu dispinline right_menu_wrapper','submenu collapse nopadding');
        		?>
						<ul class="dispinline" style="float:right">
							<li><a href="javascript: void(0);" onclick="openSearch();"><i class="fa fa-search"></i> Search</a></li>
							<li>
								<a href="<?php echo ISP::FrontendUrl('catalog/cart');?>"><i class="fa fa-shopping-cart"></i>
									<span>
									<?php $objCatalog = new catalog();
										echo $objCatalog->cartItemsCount();
	                ?>
	                </span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
function openSearch() {
  document.getElementById("myOverlay").style.display = "block";
}

function closeSearch() {
  document.getElementById("myOverlay").style.display = "none";
}
</script>