<div class="page-header">
    <div class="page-title">
        <h3><?php echo ($this->shippingId)?'Edit ':'Add ';?><?php echo $this->__aT('Shipping Method');?></h3>
    </div>
    <div class="pull-right">
    	<h3>
    		<button type="button" onclick="window.location='<?php echo mainframe::__adminBuildUrl('shipping');?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back');?></button>
	    	<button type="submit" value="exit" name="saveexit" class="btn btn-danger">Save & Exit <i class="icon-angle-right"></i></button>

        </h3>	
    </div>
</div>

<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
	<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('shipping/save');?>" class="col-md-10 box-padding">
		<div class="tab-content" style="padding-top:20px;">
			<div class="tab-pane active" id="1">
				<fieldset>
					<input class="form-control" value="<?php if(!empty($this->arrayData['shipping_code'])) echo $this->arrayData['shipping_code']; else echo 'custom';?>" name="md_shipping_code" type="hidden">

					<div class="form-group">
						<label><?php echo $this->__aT('Method Title');?></label>
						<input class="form-control" value="<?php if(!empty($this->arrayData['method_title'])) echo $this->arrayData['method_title'];?>" name="md_method_title" type="text" required>
					</div>

					<div class="form-group">
						<label><?php echo $this->__aT('Enabled');?></label>
						<select class="form-control" name="db_enabled">
							<option value="0"><?php echo $this->__aT('No');?></option>
							<option value="1"><?php echo $this->__aT('Yes');?></option>
						</select>
					</div>

					<!--<div class="form-group">
						<label><?php echo $this->__aT('Description');?></label>
						<textarea name="db_description" class="form-control"><?php if(!empty($this->arrayData['description'])) echo $this->arrayData['description'];?></textarea>
					</div>-->
					<?php
					foreach($this->shippingMeta as $objShipMeta) {
					?>
					<div class="form-group">
						<label><?php echo ucfirst($objShipMeta->meta_key);?></label>
						<input type="text" class="form-control" name="shipping_meta[<?php echo $objShipMeta->meta_key;?>]" value="<?php echo $objShipMeta->meta_value;?>">
					</div>
					<?php
					}

					if(intval($this->shippingId)==0) {
					?>
					<div class="form-group">
						<label><?php echo $this->__aT('Price');?></label>
						<input type="text" class="form-control" name="shipping_meta[price]" value="">
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
						<button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit');?> <i class="icon-angle-right"></i></button>
						</div>
					</div>
				</div> 
			</div>
		</div>
		<input type="hidden" name="id" value="<?php echo $this->shippingId;?>">
	</form>
</div>