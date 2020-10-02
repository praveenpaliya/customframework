<section class="collapse_area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <?php $this->loadTheme('customer-sidebar');?>
            </div>
            <div class="col-xs-12 col-sm-9">
                
                <form method="post" name="frmchangepass" action="<?php echo SITE_URL.'customer/updatepass';?>" method="post" onsubmit="return checkChangePassword();">
                    <div class="form-group">
                        <label><?php echo $this->__t('Current Password');?></label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->__t('New Password');?></label>
                        <input type="password" class="form-control" id="newpass" name="new_password" required>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->__t('Confirm New Password');?></label>
                        <input type="password" class="form-control" id="confirmpass" name="confirm_password" required>
                    </div>
                    <div>
                        <input type="submit" value="<?php echo $this->__t('Save');?>"  class="btn btn-primary" onclick="updateProfile();">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
function checkChangePassword() {
    if(jQuery("#newpass").val() != jQuery("#confirmpass").val()) {
        alert('<?php echo $this->__t('New Password and Confirm New Password are not same. Please fill Password again!');?>');
        return false;
    }
}
</script>