<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php self::getPageTitle(); ?>
    <?php self::getMetaKeywords(); ?>
    <?php self::getMetaDescription(); ?>
    <?php self::getOgMetaTags(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/css/bootstrap.min.css" type="text/css">
   <link rel="stylesheet" href="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/css/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/css/responsive.css" type="text/css">
    
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/css/animate.css" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700&display=swap" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/css/nivo.slider.css" rel="stylesheet">
    <script src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/js/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Merienda&display=swap" rel="stylesheet">

    <script type="text/javascript" src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/js/fancybox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/css/fancybox.css" media="screen" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-11227857-18"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-11227857-18');
    </script>

    <script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1740028,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
 </head>
<body>
<?php 
include('header.inc.php'); 
$is_home = mainframe :: isHome();
if ($is_home ) {
    ISP :: parseContent(HOME_SLIDER);
?>
    <div class="container-fluid">
<?php
    echo $this->loadBody();
?>
    </div>

<?php
}
else {
    $bread_crums = self::getBreadcrumTitle();
    $bannerImage = self :: getPageBanner();
    list($width, $height) = getimagesize($bannerImage);
?>
<section class="innerpagetop pagebanner" data-w="<?php echo $width;?>" data-h="<?php echo $height;?>" data-bg="<?php echo SITE_URL.$bannerImage;?>">
</section>

<div class="container">
    <div class="row headingrow">
        <?php
        if (count($bread_crums) >0) {
        ?>
        <div class="bradcrum">
            <ul>
                <li><a href="<?php echo SITE_URL;?>">Home</a></li>
                <?php
                foreach($bread_crums as $key=>$bread_cum_title) {
                ?>
                <li><a href="<?php echo empty($key)?'#':$key;?>"><?php echo $bread_cum_title;?></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
        <?php
        }
        ?>
        <div class="pagetitle">
            <h1><?php echo self::$pageTitle; ?></h1>
        </div>
    </div>
</div>
<div class="productdetails">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php echo $this->loadBody(); ?>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<?php include('footer.inc.php'); ?>
<script src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/js/bootstrap.min.js"></script>
<script src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/js/slick.js"></script>
<script src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/js/custom.js"></script>
<script src="<?php echo SITE_URL; ?>templates/front/<?php echo SITE_THEME;?>/js/wow.min.js"></script>
<script type="text/javascript">
  new WOW().init();
  var bannerWidth = jQuery(".pagebanner").attr("data-w");
  var bannerHeight= jQuery(".pagebanner").attr("data-h");
  var bannerImg= jQuery(".pagebanner").attr("data-bg");

  var ratio = (bannerHeight/bannerWidth);
  var windowWidth = jQuery(window).width();
  var responseHeight = Math.round(windowWidth*ratio);
  console.log("screen H:"+responseHeight);
  jQuery(".pagebanner").attr("style", "background-image: url("+bannerImg+"); height:"+responseHeight+"px;");
</script>
</body>
</html>