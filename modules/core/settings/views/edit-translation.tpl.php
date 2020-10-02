<form method="post" action="<?php echo mainframe::__adminBuildUrl('settings/saveFrontTranslation'); ?>">
    <input type="hidden" name="lang_id" value="<?php echo $this->objTrans->lang_id;?>">

    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Edit Language Translation'); ?></h3>
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12">
    	<div class="form-group">
    		<label><?php echo $this->__aT('Language');?>: </label>
    		<?php echo $this->objTrans->language;?>
    	</div>

    	<div class="form-group">
    		<label><?php echo $this->__aT('Text');?>: </label>
    		<?php echo $this->objTrans->label;?>
    	</div>

    	<div class="form-group">
    		<label><?php echo $this->__aT('Translated Text');?>: </label>
    		<input type="text" class="form-control" name="translate[<?php echo $this->objTrans->id;?>]" value="<?php echo $this->objTrans->translation;?>">
    	</div>

    	<div class="form-group">
    	<input type="submit" class="btn-danger" value="<?php echo $this->__aT('Save Translation');?>">
    	</div>
    </div>
</form>