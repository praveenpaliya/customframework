<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo intval($this->brandId)?'Edit':'Add New';?> <?php echo $this->__aT('Brand');?></h1>
  </div> 
</div>


<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

	<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('brands/save');?>" class="col-md-10 box-padding">
		<div class="tab-content" style="padding-top:20px;">
			<div class="tab-pane active" id="1">
				<fieldset>
					<div class="form-group">
						<label><?php echo $this->__aT('Brand Name');?></label>
						<input class="form-control" value="<?php if(!empty($this->arrayData['brand_name'])) echo $this->arrayData['brand_name'];?>" name="md_brand_name" type="text" required>
					</div>
					<div class="form-group">
						<label><?php echo $this->__aT('Company Address');?></label>
						<textarea class="form-control" rows="2" name="db_address"><?php if(!empty($this->arrayData['address'])) echo $this->arrayData['address'];?></textarea>
					</div>
					
					<div class="form-group">
						<label><?php echo $this->__aT('Brand Logo');?></label> 
						<input type="file" data-style="fileinput" name="<?php if($this->brandId>0) echo 'db_'; else echo 'md_';?>brand_image">
						<?php if(!empty($this->arrayData['brand_image'])) {?>
							<img src="<?php echo SITE_URL.SITE_UPLOADPATH.$this->arrayData['brand_image'];?>" width="70" height="70">
						<?php } ?>
					</div>

					<div class="form-group">
						<label><?php echo $this->__aT('Website Url');?></label>
						<input type="text" class="form-control" name="db_website" value="<?php if(!empty($this->arrayData['website'])) echo $this->arrayData['website'];?>">
					</div>
                    
          <div class="form-group">
						<label>Description</label>
						<textarea name="db_description" class="form-control editor" rows="6" cols="55"><?php echo $this->arrayData['description']?></textarea>
					</div>
					
				</fieldset>
			</div>

			<div class="form-actions fluid zero-botom-margin">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-offset-3 col-md-9">
						<button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save');?> <i class="icon-angle-right"></i></button>
						</div>
					</div>
				</div> 
			</div>
		</div>
		

		<input type="hidden" name="id" value="<?php echo $this->brandId;?>">
	</form>
</div>
