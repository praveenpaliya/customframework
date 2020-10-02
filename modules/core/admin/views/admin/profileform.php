<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('admin/updateProfile'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo !empty($this->adminData) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('User'); ?></h3>
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-xs-12 innerbox">
            <fieldset>
                <div class="form-group">
                    <label class="col-md-2 nopadding control-label"><?php echo $this->__aT("Image"); ?></label> 
                    <div class="col-md-10">
                        <input type="file" data-style="fileinput" name="db_image"/>
                        <?php
                        if ($this->adminData->image != "") {
                            ?>
                            <img src="<?php echo SITE_URL . 'var/'.SITE_THEME.'/images/' . $this->adminData->image; ?>" style="height:150px;">
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Name'); ?></label>
                    <input type="text" class="form-control" name="md_name" value="<?php echo $this->adminData->name; ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('Email'); ?></label>
                    <input type="text" class="form-control" name="md_email" value="<?php echo $this->adminData->email; ?>"/>
                </div>
                <?php if(empty($this->adminData->password)):?>
                <div class="form-group">
                    <label><?php echo $this->__aT('Password'); ?></label>
                    <input type="password" class="form-control" name="md_password" value="<?php echo $this->adminData->password; ?>"/>
                </div>
                <?php endif;?>
                <div class="form-group">
                    <label><?php echo $this->__aT('contact'); ?></label>
                    <input type="text" class="form-control" name="md_phone" value="<?php echo $this->adminData->phone; ?>"/>
                </div>
                

                <div class="form-group">
                    <label><?php echo $this->__aT('Web mail'); ?></label>
                    <input type="text" class="form-control" name="db_webmail_link" placeholder="https://" value="<?php echo $this->adminData->webmail_link; ?>"/>
                </div>
                
                <div class="form-group">
                    <label><?php echo $this->__aT('Address'); ?></label>
                    <textarea  class="form-control" name="md_address" ><?php echo $this->adminData->address; ?></textarea>
                </div>
                
                <?php if(!empty($this->adminData->password)):?>
                <div class="form-group">
                    <label><?php echo $this->__aT('Change Password'); ?></label>
                    <input type="password" class="form-control" name="cng_password"/>
                </div>
                <?php endif;?>
            </fieldset>
            <div>
                <input type="hidden" name="id" value="<?php echo $this->adminData->id; ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
        </div>	
    </div>
</form>
