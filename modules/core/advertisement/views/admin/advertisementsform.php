<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('advertisement/saveAdvertisements'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo !empty($this->advertisementsData) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Advertise '); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('advertisement/advertisements'); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-xs-12 innerbox">
            <fieldset>
                
                <div class="form-group">
                <label><?php echo $this->__aT('Type'); ?></label>
                <?php 
                if (!empty($this->advertisementsData[0]->type)){
                    
                } 
                ?>
                <select name="md_type" required class="form-control">
                        <option value="">-- Select --</option>
                        <option value="Print media" <?php if($this->advertisementsData[0]->type == 'Print media') {echo 'selected';}?>>Print media</option>
                        <option value="Social media" <?php if($this->advertisementsData[0]->type == 'Social media') {echo 'selected';}?>>Social media</option>
                        <option value="Online advertising" <?php if($this->advertisementsData[0]->type == 'Online advertising') {echo 'selected';}?>>Online advertising</option>
                        <option value="Brochures" <?php if($this->advertisementsData[0]->type == 'Brochures') {echo 'selected';}?>>Brochures</option>
                        <option value="Catalogs" <?php if($this->advertisementsData[0]->type == 'Catalogs') {echo 'selected';}?>>Catalogs</option>
                        <option value="Campaigns" <?php if($this->advertisementsData[0]->type == 'Campaigns') {echo 'selected';}?>>Campaigns</option>
                        <option value="Events offer" <?php if($this->advertisementsData[0]->type == 'Events offer') {echo 'selected';}?>>Events offer</option>
                        <option value="E-Marketing" <?php if($this->advertisementsData[0]->type == 'E-Marketing') {echo 'selected';}?>>E-Marketing</option>
                    </select>
                </div>
               
                
                <div class="form-group">
                    <label><?php echo $this->__aT('Title'); ?></label>
                    <input type="text" class="form-control" name="md_title" required value="<?php echo $this->advertisementsData[0]->title ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('Strat date'); ?></label>
                    <input type="text" class="form-control  datepicker hasDatepicker" name="md_start_date" placeholder="yyyy-mm-dd" value="<?php echo $this->advertisementsData[0]->start_date ?>"/>
                </div>
                <div class="form-group">
                    <label><?php echo $this->__aT('End date'); ?></label>
                    <input type="text" class="form-control  datepicker hasDatepicker" name="md_end_date" placeholder="yyyy-mm-dd" value="<?php echo $this->advertisementsData[0]->end_date ?>"/>
                </div>
                <div class="form-group">
                    <label class="col-md-2 nopadding control-label"><?php echo $this->__aT("File upload"); ?></label> 
                    <div class="col-md-10">
                        <ul style="list-style: none; padding-left: 0px;" id="fileUploadList">
                            <li><input type="file" data-style="fileinput" name="fileToUpload[]" multiple="multiple" accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,video/*,image/*"/></li>
                        </ul>
                        
                        <input type="button" onclick="addMore();" value="&plus;Add More">
                        
                        <?php if (!empty($this->advertisementItems)) : ?>
                           <br><br>
                        <?php foreach($this->advertisementItems as $advertisementItems): ?>
                           <ul style="padding: 0px; list-style: none">
                               <li>
                                   <?php echo $advertisementItems->file_name; ?> &nbsp; &nbsp; &nbsp; 
                                   <a href="<?php echo mainframe::__adminBuildUrl('advertisement/deleteAdItem/id/'.$advertisementItems->id); ?>" title="Delete"> <i class="fa fa-trash-o text-danger" onclick="return confirm('Do you really want to delete this ?');"></i></a>
                               </li>
                           </ul>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Description'); ?></label>
                    <textarea class="form-control editor"  name="db_description" required><?php echo $this->advertisementsData[0]->description; ?></textarea>
                </div>
            </fieldset>
            <div>
                <input type="hidden" name="id" value="<?php echo $this->advertisementsId; ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
        </div>	
    </div>
</form>


<script>

function addMore(){
    $('#fileUploadList').append('<li><input type="file" data-style="fileinput" name="fileToUpload[]" multiple="multiple" accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,video/*,image/*"/></li>');
}

</script>