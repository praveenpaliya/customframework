<section class="collapse_area">
    <div class="container nopadding">
        <div class="row">
            <div class="error col-xs-12"><?php echo mainframe::showError(); ?></div>
            <div class="success col-xs-12"><?php echo mainframe::showSuccess(); ?></div>
        </div>
        <div class="col-xs-3 hidden-xs"></div>
        <div class="col-md-6 col-sm-6 col-xs-12 omb_login padd_box border-secondary">
            <form method="post" id="frmlogin" name="frmlogin" action="<?php echo SITE_URL . 'customer/dologin'; ?>">
                <input type="hidden" name="redirect_to" value="<?php echo $_REQUEST['redirect_to']; ?>">
                <div class="row">
                    <h1><?php echo $this->__t('Customer Login'); ?></h1>
                </div>
                <div class="row">
                    <div class="form-group">
                        <input type="text" name="email" required class="form-control" placeholder="<?php echo $this->__t('Email Address'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="pwd" required class="form-control" placeholder="<?php echo $this->__t('Password'); ?>">
                    </div>
                    <div class="form-group">
                        <button class="button2 get" type="submit" title="">
                            <span><?php echo $this->__t('Login'); ?></span>
                        </button>
                    </div>
                    <div class="form-group">
                        <a href="javascript: void(0);" onclick="jQuery('#frmlogin').hide();
                                jQuery('#frmregister').show();"><?php echo $this->__t("New User? Register here"); ?>    /
                        </a>

                        <a style="margin-left:10px;" href="javascript: void(0);" onclick="jQuery('#frmlogin').hide();
                                jQuery('#frmforgot').show();"><?php echo $this->__t("Forgot Password"); ?>
                        </a>
                        
                    </div>
                </div>

                <!--                <div class="row  omb_loginOr">
                                    <div class="col-xs-12 col-sm-12">
                                        <hr class="omb_hrOr">
                                        <span class="omb_spanOr"><?php echo $this->__t('Or'); ?></span>
                                    </div>
                                </div>
                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
                                            <i class="fa fa-facebook visible-xs"></i>
                                            <span class="hidden-xs"><?php echo $this->__t('Login with Facebook'); ?></span>
                                        </a>
                                    </div>
                                    <div class="col-xs-4 col-sm-4">
                                        <a href="#" class="btn btn-lg btn-block omb_btn-twitter">
                                            <i class="fa fa-twitter visible-xs"></i>
                                            <span class="hidden-xs"><?php echo $this->__t('Login with Twitter'); ?></span>
                                        </a>
                                    </div>  
                                    <div class="col-xs-4 col-sm-4">
                                        <a href="#" class="btn btn-lg btn-block omb_btn-google">
                                            <i class="fa fa-google-plus visible-xs"></i>
                                            <span class="hidden-xs"><?php echo $this->__t('Login with Google+'); ?></span>
                                        </a>
                                    </div>  
                                </div>-->
            </form>

            <form method="post" id="frmforgot" name="frmforgot" action="<?php echo SITE_URL . 'customer/doforgot'; ?>" style="display: none;">
                <input type="hidden" name="redirect_to" value="<?php echo $_REQUEST['redirect_to']; ?>">
                <div class="row">
                    <h1><?php echo $this->__t('Forgot Password'); ?></h1>
                </div>
                <div class="row">
                    <div class="form-group">
                        <input type="text" name="email" required class="form-control" placeholder="<?php echo $this->__t('Email Address'); ?>">
                    </div>
                    <div class="form-group">
                        <button class="button2 get pull-right" type="submit" title="">
                            <span><?php echo $this->__t('Submit'); ?></span>
                        </button>
                        <a style="" href="javascript: void(0);" onclick="jQuery('#frmforgot').hide();
                                jQuery('#frmlogin').show();"><?php echo $this->__t("Back to Login"); ?>   
                        </a>

                    </div>
                </div>   
            </form>    


            <form method="post" name="frmRegister" id="frmregister" action="<?php echo SITE_URL . 'customer/doregister'; ?>" style="display: none;">
                <input type="hidden" name="redirect_to" value="<?php echo $_REQUEST['redirect_to']; ?>">
                <div class="row">
                    <h1><?php echo $this->__t('New Customer Registration'); ?></h1>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="md_first_name" required class="form-control" placeholder="<?php echo $this->__t('First Name'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="md_last_name" required class="form-control" placeholder="<?php echo $this->__t('Last Name'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="md_email" required class="form-control" placeholder="<?php echo $this->__t('Email'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="md_phone" required class="form-control" placeholder="<?php echo $this->__t('Phone'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="billing[db_address1]" required class="form-control" placeholder="<?php echo $this->__t('Address'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="billing[db_city]" required  class="form-control" placeholder="<?php echo $this->__t('City'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="billing[db_state]" required class="form-control" placeholder="<?php echo $this->__t('State'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="billing[db_zip_code]" required class="form-control" placeholder="<?php echo $this->__t('Postal Code'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <select name="billing[db_country]" required class="form-control select_country">
                            <option value="">-- <?php echo $this->__t('Country'); ?> --</option>
                            <?php foreach ($this->countries as $objcountries): ?>
                                <option value="<?php echo $objcountries->country_name; ?>"><?php echo $objcountries->country_name; ?></option> 
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="md_password" required class="form-control" placeholder="<?php echo $this->__t('Account Password'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="button2 get pull-left" type="submit" title="">
                        <span><?php echo $this->__t('Register'); ?></span>
                    </button>
                    <a style="margin-left:10px;" href="javascript: void(0);" onclick="jQuery('#frmregister').hide();
                            jQuery('#frmlogin').show();"><?php echo $this->__t("Already registered? Click here to Login"); ?>
                    </a>

                </div>
            </form>
        </div>
        <div class="col-xs-3 hidden-xs"></div>
    </div>
</section>

<script>
var showRegister = '<?php echo intval($_GET['sreg']);?>';

if (showRegister == 1) {
    jQuery('#frmlogin').hide();
    jQuery('#frmregister').show();
}
</script>
