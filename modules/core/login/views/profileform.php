<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('login/updateProfile'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo !empty($this->adminData) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('User'); ?></h3>
        </div>
    </div>
<?php //echo "<pre>"; print_r($this->adminData); die;?>
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
                    <label><?php echo $this->__aT('Date of Birth'); ?></label>
                    <input type="text" data-attr="dob" class="form-control datepicker hasDatepicker" name="md_dob"  value="<?php echo $this->adminData->dob; ?>"/>
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
                    <label><?php echo $this->__aT('Contact'); ?></label>
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
                <div class="form-group">
                    <label><?php echo $this->__aT('CV') ; ?></label><br>
                    <?php if (!empty($this->adminData->cv)): ?>
                    <a href="<?php echo SITE_URL . SITE_UPLOADPATH . $this->adminData->cv ?>" title="Download" class="btn btn-info">
                        <i class="fa fa-download"></i> &nbsp;&nbsp; Download
                    </a>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('Documents'); ?></label>
                    <div>
                        <?php
                        if (!empty($this->adminData->doc)):
                                $docs = json_decode($this->adminData->doc);
                                foreach ($docs as $doc):
                                   $fileName='';
                                   $title = substr($doc, 10);
                                   if(strlen($title) >= 12 ){
                                      $fileName = substr($title, 0,12); 
                                      $fileName .= '...';
                                   }else{
                                       $fileName = $title;
                                   }
                        ?>        
                                <a href="<?php echo SITE_URL . SITE_UPLOADPATH . $doc ?>" title="<?php echo $title?>" class="btn btn-info">
                                    <i class="fa fa-download"></i> &nbsp;&nbsp; <?php echo $fileName ?>
                                </a>
                                <?php endforeach;?>
                        <?php endif;?>
                    </div>
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
