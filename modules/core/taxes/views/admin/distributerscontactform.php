<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('distributer/saveDistributersContact');?>">
<div class="page-header">
    <div class="page-title">
        <h3><?php echo !empty($this->distributerContactDetail)? 'Edit' : 'Add New';?> <?php echo $this->__aT("Distributer's Contact");?></h3>
    </div>
    <div class="pull-right">
        <h3>
    		<button type="button" onclick="window.location='<?php echo mainframe::__adminBuildUrl('distributer/distributerslist');?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back');?></button>
        </h3>	
    </div>
</div>

<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
    
    <div class="col-xs-12 innerbox">
                    <fieldset>
                        <div class="form-group">
				<label><?php echo $this->__aT('Contact Name');?></label>
                                <input type="text" class="form-control" name="md_name" value="<?php echo $this->distributerContactDetail[0]->name ?>"/>
			</div>
                        <div class="form-group">
				<label><?php echo $this->__aT('Email');?></label>
				<input type="text" class="form-control" name="md_email" value="<?php echo $this->distributerContactDetail[0]->email ?>"/>
			</div>
                        <div class="form-group">
				<label><?php echo $this->__aT('Number');?></label>
				<input type="text" class="form-control" name="md_number" value="<?php echo $this->distributerContactDetail[0]->number ?>"/>
			</div>
                        <div class="form-group">
				<label class="col-md-2 nopadding control-label"><?php echo $this->__aT("Person image");?></label> 
				<div class="col-md-10">
                                    <input type="file" data-style="fileinput" name="db_person_image"/>
                                   <?php
                                    if ($this->distributerContactDetail[0]->person_image != "") {
                                        ?>
                                        <img src="<?php echo SITE_URL . 'var/'.SITE_THEME.'/images/' . $this->distributerContactDetail[0]->person_image; ?>" style="height:150px;">
                                        <?php
                                    }
                                    ?>
				</div>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->__aT('Description'); ?></label>
                            <textarea class="form-control editor"  name="db_description"><?php echo $this->distributerContactDetail[0]->description; ?></textarea>
                        </div>

                        <input type="hidden" id="distributer_id" name="db_distributer_id" value="<?php echo empty($this->distributerContactDetail) ? $this->distributerId :  $this->distributerContactDetail[0]->distributer_id ?>">
                        <input type="hidden" id="editDistributerContactId" name="editDistributerContactId" value="<?php echo $this->distributorContactId ?>">
		   </fieldset>
        <br><br><br><br><br>
        
		<div>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit');?> <i class="icon-angle-right"></i></button>
	        <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New');?> <i class="icon-angle-right"></i></button>
		</div>
  </div>	
</div>
</form>
