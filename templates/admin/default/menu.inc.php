<aside class="sidebar">
	<nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand m-0 py-2 brand-title" href="<?php echo mainframe::__adminBuildUrl('dashboard'); ?>">Eternity Letter</a>
    <span></span>
    <a class="navbar-brand py-2 material-icons toggle-sidebar" href="#">menu</a>
  </nav>

  <nav class="navigation">
  <?php
  mainframe::showAdminMenuUlList(mainframe::$adminMenuItems, array('class'=>'list-sidebar bg-defoult ajaxprocess')); 
  ?>
	</nav>
</aside>
