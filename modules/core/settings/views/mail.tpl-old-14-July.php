<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/save'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3>Mail Settings</h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger">Save <i class="icon-angle-right"></i></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-10 box-padding">
            <input type="hidden" name="method" value="mail">


            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset>   
                        <div class="form-group">
                            <label>From Mail Id</label>
                            <input class="form-control" value="<?php echo $this->arrayData['mail_from']->config_value; ?>" name="config[mail_from]" type="text" required>
                        </div>

                        <div class="form-group">
                            <label>From Mail Name</label>
                            <input class="form-control" value="<?php echo $this->arrayData['mail_fromname']->config_value; ?>" name="config[mail_fromname]" type="text" required>
                        </div>	
                    </fieldset>
                </div>	
                <div class="form-actions fluid zero-botom-margin">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" value="exit" name="saveexit" class="btn btn-danger">Save & Exit <i class="icon-angle-right"></i></button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>
