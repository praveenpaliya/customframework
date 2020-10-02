<!doctype html>
<html lang="en">
    <head>
        <?php //$this->loadCss('head', $isAdmin=1);?>
        <?php //$this->loadJs('head', $isAdmin=1);?>
        <meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" /> 

        <link rel="stylesheet" href="<?php echo SITE_URL;?>templates/admin/default/css/style.css">
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

        <!-- Date Range Picker -->
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>templates/admin/default/css/daterangepicker/daterangepicker.css" />

        <!-- Full Calendar Icons -->
        <link href="<?php echo SITE_URL;?>templates/admin/default/css/fullcalendar/fullcalendar.css" rel="stylesheet">
        <script src="//cdn.ckeditor.com/4.7.1/full/ckeditor.js"></script>
        <?php if(!isset($_SESSION['adminLogin'])) {
        ?>
        <link href="<?php echo SITE_URL;?>templates/admin/default/css/login.css" rel="stylesheet">
        <?php 
        } 
        ?>
        <?php //$this->loadJs('head', 1);?>
        <script type="text/javascript" src="<?php echo SITE_URL;?>templates/admin/default/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo SITE_URL;?>assets.plugins/imagebrowser"></script>
</head>
<body>
<?php 
if(!isset($_SESSION['adminLogin'])) {
    echo $this->loadBody();
}
else {
?>
    <section class="wrapper">
        <?php $this->loadSection('menu', $isAdmin=1); ?>

        <div class="content-area">
            <?php $this->loadSection('header', $isAdmin=1); ?>

            <div class="content-wrapper">
                <?php 
                    if(isset($_SESSION['adminLogin'])) {
                        echo mainframe ::showSuccess();
                        echo mainframe ::showError();
                    }
                    ?>
                    <?php echo $this->loadBody();?>
            </div>
        </div>

    </section>      

    <?php $this->loadSection('footer', $isAdmin=1); ?>
<?php
}
?> 
    <script type="text/javascript" src="<?php echo SITE_URL;?>templates/admin/default/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>templates/admin/default/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>templates/admin/default/js/chosen.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>templates/admin/default/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/admin.js"></script>  
    </body>
</html>