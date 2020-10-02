<div class="login">
  <div class="image-placeholder">
    <h1>Lorem ipsum dolor sit amet<br>consectetur pellentesque adipiscing elit.</h1>
  </div>
  <div class="form">
      <div class="text-center mb-4">
        <img src="<?php echo SITE_URL;?>templates/admin/default/images/eternity_logo.png" height="100">
        <!--<span class="material-icons text-danger" style="font-size:6rem;">wifi_tethering</span>-->
      </div>

      <h3 class="h4 mb-5 text-center">Admin Login</h3>
      <form class="login-form noajax" method="post">
        <?php echo mainframe ::showError(); ?>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn mt-4 btn-primary btn-block">Login</button>
      </form>

  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery("a.forgot-password-link").click(function() {
        jQuery(".form_box").css("transform", "rotateX(180deg)");  
    });
    jQuery(".closeflip a").click(function() {
        jQuery(".form_box").css("transform", "rotateX(0deg)");  
    });
});
</script>

