<section class="collapse_area">
    <div class="container nopadding">
        <div class="row">
            <div class="error col-xs-12"><?php echo mainframe::showError(); ?></div>
            <div class="success col-xs-12"><?php echo mainframe::showSuccess(); ?></div>
        </div>
        <div class="col-xs-3 hidden-xs"></div>
        <div class="col-sm-6 col-xs-12 pull-center padd_box border-secondary">
            <form method="post" id="frmlogin2" name="frmlogin2" action="<?php echo SITE_URL . 'customer/dodistributorlogin'; ?>">
                <input type="hidden" name="redirect_to" value="<?php echo $_REQUEST['redirect_to']; ?>">
                <div class="row">
                    <h1><?php echo $this->__t('Distributor Login'); ?></h1>
                </div>
                <div class="row">
                    <div class="form-group">
                        <select class="form-control">
                            <option value="distributor">Distributor</option>
                        </select>
                    </div>
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
                        <a style="margin-left:10px;" href="javascript: void(0);" onclick="jQuery('#frmlogin2').hide();
                                jQuery('#frmforgot2').show();"><?php echo $this->__t("Forgot Password"); ?>
                        </a>
                        |
                        <a href="javascript: void(0);" onclick="jQuery('#frmlogin2').hide();
                                jQuery('#frmregister2').show();"><?php echo $this->__t("New Distributor? Register here"); ?>
                        </a>
                    </div>

                </div>

            </form>


            <form method="post" id="frmforgot2" name="frmforgot2" action="<?php echo SITE_URL . 'customer/doforgot'; ?>" style="display: none;">
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
                        <a style="" href="javascript: void(0);" onclick="jQuery('#frmforgot2').hide();
                                jQuery('#frmlogin2').show();"><?php echo $this->__t("Back to Login"); ?>   
                        </a>

                    </div>
                </div>   
            </form> 

            <form method="post" name="frmRegister2" id="frmregister2" action="<?php echo SITE_URL . 'customer/doregister'; ?>" style="display: none;">
                <input type="hidden" name="redirect_to" value="<?php echo $_REQUEST['redirect_to']; ?>">
                <div class="row">
                    <h1><?php echo $this->__t('New Distributor Registration'); ?></h1>
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
                            <input type="text" name="md_business_name" required class="form-control" placeholder="<?php echo $this->__t('Company Name'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="customer[vat_registration]" required class="form-control" placeholder="<?php echo $this->__t('TAX Number'); ?>">
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

                </div>
                <div class="form-group">
                    <button class="button2 get pull-left" type="submit" title="">
                        <span><?php echo $this->__t('Register'); ?></span>
                    </button>
                    <a style="margin-left:10px;" href="javascript: void(0);" onclick="jQuery('#frmregister2').hide();
                            jQuery('#frmlogin2').show();"><?php echo $this->__t("Already registered? Click here to Login"); ?>
                    </a>
                </div>
                <input type="hidden" name="md_customer_group" value="4">
                <input type="hidden" name="md_status" value="0">
            </form>
        </div>
        <div class="col-xs-3 hidden-xs"></div>

    </div>
</section>
