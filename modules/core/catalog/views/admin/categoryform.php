<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo intval($this->catObject->category_id) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Category'); ?></h1>
  </div> 
</div>

<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('catalog/savecategory'); ?>">
    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-xs-12 innerbox">
            <fieldset>
                <div class="form-group">
                    <label><?php echo $this->__aT('Parent Category'); ?></label> 
                    <select name="md_parent_cat" required class="form-control">
                        <option value="0"><?php echo $this->__aT('Top Level'); ?></option>
                        <?php echo $this->categoryBuild; ?>
                    </select>
                </div>
                <?php
                foreach ($this->categoryFields as $objFields) {
                    foreach ($this->activeLanguages as $objLang) {
                        $fieldValue = $this->getCategoryAttributeValue($this->catObject->category_id, $objFields->code, $objLang->lang_id);
                        ?>
                        <div class="form-group">
                            <label><?php echo $objFields->label; ?> (<?php echo $objLang->language; ?>)</label>
                            <?php ISP :: drawField($objFields, $objLang, $fieldValue); ?>
                        </div>
                        <?php
                    }
                }
                ?>

                <div class="form-group">
                    <label><?php echo $this->__aT('Category URL'); ?></label> 
                    <input name="md_seo_url" class="form-control" required value="<?php echo $this->catObject->seo_url;?>">
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Category Image'); ?></label>
                    <div class="custom-file">
                      <input type="file" name="db_cat_image" class="custom-file-input" id="validatedCustomFile">
                      <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                    </div>
                    <?php if (!empty($this->catObject->cat_image)) { ?>
                            <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $this->catObject->cat_image; ?>" width="70" height="70">
                            <input type="checkbox" name="rm_image" value="1"><?php echo $this->__aT('Remove'); ?>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Speical Promotion Discount'); ?></label>
                    <input type="text" value="<?php if (!empty($this->catObject->promotion_discount)) echo $this->catObject->promotion_discount; ?>" class="form-control" name="db_promotion_discount">
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Discount Type'); ?></label>
                    <select name="db_promotion_discount_type" class="form-control">
                        <option value="Fixed" <?php if ($this->catObject->promotion_discount_type == 'Fixed') echo 'selected'; ?>><?php echo $this->__aT('Fixed'); ?></option>
                        <option value="Percentage" <?php if ($this->catObject->promotion_discount_type == 'Percentage') echo 'selected'; ?>><?php echo $this->__aT('Percentage'); ?></option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label><?php echo $this->__aT('Promotion Start Date'); ?></label>
                        <div class="input-group date datetimepicker" id='datetimepicker1'>
                            <input type="text" value="<?php if ($this->catObject->promotion_start_date != '0000-00-00') echo $this->catObject->promotion_start_date; ?>" class="form-control" name="db_promotion_start_date">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <label><?php echo $this->__aT('Promotion End Date'); ?></label>
                        <div class="input-group date datetimepicker" id='datetimepicker2'>
                            <input type="text" value="<?php if ($this->catObject->promotion_end_date != '0000-00-00') echo $this->catObject->promotion_end_date; ?>" class="form-control" name="db_promotion_end_date">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

            </fieldset>	
            <div>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
            </div>
            <input type="hidden" id="catId" name="id" value="<?php echo intval($this->catObject->category_id); ?>">
        </div>	
    </div>
</form>
