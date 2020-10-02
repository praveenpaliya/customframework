<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/save'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Site Settings'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-md-10 box-padding">
            <input type="hidden" name="method" value="site">

            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset>
                        <div class="form-group">
                            <label><?php echo $this->__aT('Site Title'); ?></label>
                            <input class="form-control" value="<?php echo $this->arrayData['site_name']->config_value; ?>" name="config[site_name]" type="text" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Site URL'); ?></label>
                            <input class="form-control" value="<?php echo $this->arrayData['site_url']->config_value; ?>" name="config[site_url]" type="text" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Site Secure URL'); ?></label>
                            <input class="form-control" value="<?php echo $this->arrayData['secure_url']->config_value; ?>" name="config[secure_url]" type="text" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Admin Path'); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo SITE_URL; ?></span>
                                <input class="form-control" value="<?php echo $this->arrayData['admin_path']->config_value; ?>" name="config[admin_path]" type="text" required>
                            </div>
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
