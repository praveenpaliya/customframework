<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/save'); ?>" class="noajax">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Admin Theme Settings'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
            </h3>   
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-10 box-padding">
            <input type="hidden" name="method" value="theme">
            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset>
                        <div class="form-group">
                            <label><?php echo $this->__aT('Admin Logo'); ?></label>
                            <input type="file" name="admin_logo" data-style="fileinput" accept="image/*">
                            <?php
                            if ($this->arrayData['admin_logo'] != "") {
                                ?>
                                <br><img src="<?php echo SITE_URL . SITE_UPLOADPATH .'admin/'.$this->arrayData['admin_logo']; ?>" border="0" height="80">
                                <?php
                            }
                            ?>
                        </div>
                        
                        <div class="form-group">
                            <label><?php echo $this->__aT('Admin Theme'); ?></label>
                            <select name="config[admin_theme]">
                                <?php
                                foreach ($this->admin_templates as $template=>$templateinfo) {
                                ?>
                                    <option value="<?php echo $template;?>" data-preview="<?php echo $templateinfo['preview'];?>" data-author="<?php echo $templateinfo['author'];?>" data-date="<?php echo $templateinfo['date'];?>" <?php echo ($this->arrayData['admin_theme'] == $template) ? 'selected' : '';?>><?php echo $templateinfo['name'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                    </fieldset>
                </div>

                <div class="form-actions fluid zero-botom-margin">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>