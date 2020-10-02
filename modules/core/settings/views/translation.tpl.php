<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/savetranslation'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Admin Theme Translation'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-10 box-padding">

            <input type="hidden" name="method" value="store">
            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset>
                        <?php
                        foreach ($this->labelTranslations as $objTrans) {
                            ?>
                            <div class="form-group">
                                <label><?php echo $objTrans->label; ?></label>
                                <input type="text" class="form-control" name="translate[<?php echo $objTrans->id; ?>]" value="<?php echo $objTrans->translation; ?>">
                            </div>
                            <?php
                        }
                        ?>    


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