<?php //print_r($this->taxData); die;?>

<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('menu/saveMenuType'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo !empty($this->taxId) ? 'Edit' : 'Add Menu'; ?> <?php echo $this->__aT('Type'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('menu/allMenuType'); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-xs-12 innerbox">
            <fieldset>
                <div class="form-group">
                    <label><?php echo $this->__aT('Menu type'); ?></label>
                    <input type="text" class="form-control" name="md_menu_title" value="<?php echo $this->menuTypeData->menu_title; ?>"/>
                    <input type="hidden" class="form-control" name="md_menu_code" value="<?php echo 'menu_'.round(microtime(true) * 1000);; ?>"/>
                </div>
            </fieldset>
            <div>
                <input type="hidden" name="taxRecordId" value="<?php echo $this->menuTypeData->id; ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
        </div>	
    </div>
</form>
