<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/savewebsitetheme'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Website Theme Settings'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-10 box-padding">

            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Theme Logo'); ?></label>
                            <input type="file" name="site_logo" data-style="fileinput" accept="image/*">
                            <?php
                            if ($this->arrayData['site_logo']->config_value != "") {
                                ?>
                                <br><img src="<?php echo SITE_URL . SITE_UPLOADPATH . $this->arrayData['site_logo']->config_value; ?>" border="0" width="200">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Home Page Slider Short Code'); ?></label>
                            <input type="text" name="home_slider" class="form-control" value="<?php echo $this->arrayData['home_slider']->config_value; ?>">
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