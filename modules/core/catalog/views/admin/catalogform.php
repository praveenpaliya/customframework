<style>
    .delete_file{font-size: 16px; color: #fda2a2;}
    .delete_file:hover{ color: #ff0101; font-size: 18px;}
</style>
<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo intval($this->editProductId) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Product'); ?></h1>
  </div> 
</div>

<form method="post" enctype="multipart/form-data">
    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link px-3 active show" href="#1" id="1-tab" aria-controls="1-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Basic Details'); ?>">
                    <?php echo $this->__aT('Basic Details'); ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3" href="#2" id="2-tab" aria-controls="2-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Price'); ?>">
                    <?php echo $this->__aT('Price'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="#3" id="3-tab" aria-controls="3-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Inventory'); ?>">
                    <?php echo $this->__aT('Inventory'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="#4" id="4-tab" aria-controls="4-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Assign Categories'); ?>">
                    <?php echo $this->__aT('Assign Categories'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="#5" id="5-tab" aria-controls="5-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Images'); ?>">
                    <?php echo $this->__aT('Images'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="#6" id="6-tab" aria-controls="6-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Custom Options'); ?>">
                    <?php echo $this->__aT('Custom Options'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="#7" id="7-tab" aria-controls="7-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Uploads'); ?>">
                    <?php echo $this->__aT('Uploads'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-3" href="#8" id="8-tab" aria-controls="8-tab" role="tab" data-toggle="tab" title="<?php echo $this->__aT('Related Products'); ?>">
                    <?php echo $this->__aT('Related Products'); ?>
                </a>
            </li>
        </ul>
        <div class="card border-top-0 mb-4">
            <div class="card-body">
                <div class="tab-content" id="myTabContent" style="padding-top:20px;">
                    <div class="tab-pane fade active show" id="1" role='tabpanel' aria-labelledby="">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Brand Name'); ?></label>
                                <select name="db_brand_id" required class="form-control">
                                    <option value=""><?php echo $this->__aT('Select Brand'); ?></option>
                                    <?php
                                    foreach ($this->brandOptions as $brandData) {
                                        ?>
                                        <option value="<?php echo $brandData->brand_id; ?>" <?php if ($this->arrayData['brand_id'] == $brandData->brand_id) echo 'selected'; ?>><?php echo $brandData->brand_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                            foreach ($this->catalogFields as $objFields) {

                                if($objFields->multilanguage==1) {
                                    foreach ($this->activeLanguages as $objLang) {
                                        $fieldValue = $this->getAttributeValue($this->editProductId, $objFields->code, $objLang->lang_id);
                                        ?>
                                        <div class="form-group">
                                            <label><?php echo $objFields->label; ?> (<?php echo $objLang->language; ?>)</label>
                                            <?php ISP :: drawField($objFields, $objLang, $fieldValue); ?>
                                        </div>
                                        <?php
                                    }
                                }
                                else {
                                    $fieldValue = $this->getAttributeValue($this->editProductId, $objFields->code, 0);
                                    $langArray = array('lang_id'=>0);
                                    $objLang = (object)$langArray;
                                        ?>
                                        <div class="form-group">
                                            <label><?php echo $objFields->label; ?></label>
                                            <?php ISP :: drawField($objFields, $objLang, $fieldValue); ?>
                                        </div>
                            <?php
                                }
                            }
                            ?>   

                            <div class="form-group">
                                <label><?php echo $this->__aT('SKU'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['sku'])) echo $this->arrayData['sku']; ?>" name="db_sku" required  type="text"> 
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Weight'); ?> (lbs.)</label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['weight'])) echo $this->arrayData['weight']; ?>" name="md_weight" required  type="text"> 
                            </div>

                            
                            <div class="form-group">
                                <label><?php echo $this->__aT('Product URL'); ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo SITE_URL; ?></span>
                                    <input class="form-control" value="<?php if (!empty($this->arrayData['seo_url'])) echo $this->arrayData['seo_url']; ?>" name="seo_url" type="text"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Is Featured?'); ?></label>
                                <select name="md_is_featured">
                                    <option value="0" <?php if (intval($this->arrayData['is_featured']) == 0) echo 'selected'; ?>><?php echo $this->__aT('No'); ?></option>
                                    <option value="1" <?php if (intval($this->arrayData['is_featured']) == 1) echo 'selected'; ?>><?php echo $this->__aT('Yes'); ?></option>
                                </select>
                            </div>

                        </fieldset>
                    </div>

                    <div class="tab-pane fade" id="2" role='tabpanel' aria-labelledby="">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Product Price'); ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo DEFAULT_CURRENCY; ?></span>
                                    <input class="form-control" value="<?php if (!empty($this->arrayData['price'])) echo $this->arrayData['price']; ?>" name="md_price" type="text" required>
                                </div>
                            </div>

                            <div class="form-group form-inline">
                                <label><?php echo $this->__aT('Group Price'); ?></label>
                                <input value="1" <?php if ($this->arrayData['group_price']) echo 'checked'; ?> name="db_group_price" type="checkbox" onclick="jQuery('.group_price_box').toggle(); jQuery('.special_price_box').toggle();">
                            </div>
                            <div class="form-group group_price_box" <?php
                            if ($this->arrayData['group_price'])
                                echo 'style="display:block"';
                            else
                                echo 'style="display:none"';
                            ?>>
                                     <?php
                                     foreach ($this->customerGroups as $cgData) {
                                         ?>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:150px;"><?php echo $cgData->customer_group; ?></span>
                                        <span class="input-group-addon"><?php echo DEFAULT_CURRENCY; ?></span>
                                        <input class="form-control" value="<?php if (!empty($this->groupPrice[$cgData->id]['price'])) echo $this->groupPrice[$cgData->id]['price']; ?>" name="group_price[<?php echo $cgData->id; ?>]" type="text">

                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="form-group special_price_box" <?php
                            if ($this->arrayData['group_price'])
                                echo 'style="display:none"';
                            else
                                echo 'style="display:block"';
                            ?>>
                                <label><?php echo $this->__aT('Special Price'); ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo DEFAULT_CURRENCY; ?></span>
                                    <input class="form-control" value="<?php if (!empty($this->arrayData['special_price']) && $this->arrayData['special_price'] > 0) echo $this->arrayData['special_price']; ?>" name="db_special_price" type="text">
                                </div>
                            </div>
                            <div class="form-group special_price_box" <?php
                            if ($this->arrayData['group_price'])
                                echo 'style="display:none"';
                            else
                                echo 'style="display:block"';
                            ?>>
                                <label><?php echo $this->__aT('Special Price Start Date'); ?></label>
                                <input class="form-control datepicker hasDatepicker" value="<?php if ($this->arrayData['special_price_start_date'] != '0000-00-00') echo $this->arrayData['special_price_start_date']; ?>" name="db_special_price_start_date" type="text">
                            </div>
                            <div class="form-group special_price_box" <?php
                                 if ($this->arrayData['group_price'])
                                     echo 'style="display:none"';
                                 else
                                     echo 'style="display:block"';
                                 ?>>
                                <label><?php echo $this->__aT('Special Price End Date'); ?></label>
                                <input class="form-control datepicker hasDatepicker" value="<?php if ($this->arrayData['special_price_end_date'] != '0000-00-00') echo $this->arrayData['special_price_end_date']; ?>" name="db_special_price_end_date" type="text">
                            </div>

                            <div class="form-group form-inline">
                                <label><?php echo $this->__aT('Show price with tax'); ?></label>
                                <input value="1" <?php if ($this->arrayData['show_price_with_tax'] == '1') echo 'checked'; ?> name="db_show_price_with_tax" type="checkbox" >
                            </div>
                        </fieldset>
                    </div>

                    <div class="tab-pane fade" id="3" role='tabpanel' aria-labelledby="">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Qty in Stock'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['inventory'])) echo $this->arrayData['inventory']; ?>" name="md_inventory" type="text" required>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Manage Inventory'); ?></label>
                                <input class="form-control" value="1" <?php if ($this->arrayData['manage_inventory']) echo 'checked'; ?> name="db_manage_inventory" type="checkbox">
                            </div>

                        </fieldset>
                    </div>

                    <div class="tab-pane fade" id="4" role='tabpanel' aria-labelledby="">
                        <fieldset>		
                            <div class="form-group">
                                <label><?php echo $this->__aT('Categories'); ?></label>
                            </div>
                            <div class="form-group">
                                <?php echo $this->categoryBuild; ?>
                            </div>
                        </fieldset>
                    </div>

                    <div class="tab-pane fade" id="5" role='tabpanel' aria-labelledby="">
                        <fieldset>		
                            <div class="form-group">
                                <label class="col-md-2 nopadding control-label"><?php echo $this->__aT('Product Image'); ?></label> 
                                <div class="col-md-10"><input type="file" data-style="fileinput" name="db_image" accept="image/*">
                                    <?php if (!empty($this->arrayData['image'])) { ?>
                                        <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $this->arrayData['image']; ?>" width="70" height="70">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <ul style="list-style:none;padding-left: 0px" id="product_gallery_image">

                                    <?php
                                    if (!empty($this->arrayData['gallery_images'])) :
                                        $gallery_images_string = rtrim($this->arrayData['gallery_images'], ',');
                                        $gallery_images = explode(',', $gallery_images_string);
                                        foreach ($gallery_images as $image):
                                            ?>
                                            <li style="padding-bottom: 5px; padding-left: 0px" class="col-md-12">
                                                <label class="col-md-2 nopadding control-label"><?php echo $this->__aT('Product Gallery Images'); ?></label> 
                                                <div class="col-md-10">
                                                    <div class="col-md-4" style="padding-left:0px">
                                                        <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $image; ?>" width="70" height="70">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:void(0)" style="font-size:20px;color:#ff6666" onclick=" if (deletePrompt())
                                                                    removeRow(this);"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php
                                    endforeach;
                                endif;
                                ?>

                                    <li>
                                        <label class="col-md-2 nopadding control-label"><?php echo $this->__aT('Product Gallery Images'); ?></label> 
                                        <div class="col-md-10">
                                            <input type="file"  name="gallery_images[]" multiple="true" accept="image/*">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <a style="" href="javascript:void(0);" onclick="addMore();" class="btn btn-primary">&plus; More</a>
                        </fieldset>
                    </div>

                    <!-- Custom options -->
                    <div class="tab-pane fade" id="6" role='tabpanel' aria-labelledby="">
                        <div class="col-xs-12 nopadding widget box">
                            <div class="col-xs-12 nopadding alert-info alert">
                                <div class="col-xs-8">
                                    <h5><?php echo $this->__aT('Custom Options'); ?></h5>
                                </div>
                                <div class="col-xs-4 pull-right text-right">
                                    <button type="button" class="appendOption btn btn-info"><i class="fa fa-plus"></i> <?php echo $this->__aT('Add New Option'); ?></button>
                                </div>
                            </div>
                            <div class="option_container col-xs-12">
                                <?php
                                if (intval($this->editProductId) > 0) {
                                    $customOptions = $this->loadCustomOptions($this->editProductId);
                                    if ($customOptions) {
                                        ?>
                <?php
                $iCount = 0;
                foreach ($customOptions as $optionObj) {
                    $optionValues = json_decode($optionObj->option_values);
                    ?>
                                            <div class="option-box" id="option_<?php echo $iCount; ?>">
                                                <a href="javascript:void(0);" style="color:#ff6666; font-size: 18px;" title="Remove Option" onclick="removeOption(this)">
                                                    <i class="fa fa-trash pull-right"></i>
                                                </a>
                                                <table width="100%" class="option-header">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Type</th>
                                                            <th>Required</th>
                                                            <th>Sort Order</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td><input type="text" name="option_title[<?php echo $iCount; ?>]" required="" class="form-control" value="<?php echo $optionObj->option_title; ?>"></td>
                                                            <td>
                                                                <select data-attr="<?php echo $iCount; ?>" name="option_type[<?php echo $iCount; ?>]" required="" class="form-control select-product-option-type">
                                                                    <option value="">--Please Select--</option>
                                                                    <optgroup label="Text">
                                                                        <option value="text" <?php if ($optionObj->option_type == 'text') echo 'selected'; ?>>Field</option>
                                                                        <option value="textarea" <?php if ($optionObj->option_type == 'textarea') echo 'selected'; ?>>Area</option>
                                                                    </optgroup>
                                                                    <optgroup label="File">
                                                                        <option value="file" <?php if ($optionObj->option_type == 'file') echo 'selected'; ?>>File</option>
                                                                    </optgroup>
                                                                    <optgroup label="Select">
                                                                        <option value="select" <?php if ($optionObj->option_type == 'select') echo 'selected'; ?>>Drop-down</option>
                                                                        <option value="checkbox" <?php if ($optionObj->option_type == 'checkbox') echo 'selected'; ?>>Checkbox</option>
                                                                        <option value="radio" <?php if ($optionObj->option_type == 'radio') echo 'selected'; ?>>Radio Butotn</option>
                                                                    </optgroup>
                                                                    <optgroup label="Date">
                                                                        <option value="date" <?php if ($optionObj->option_type == 'date') echo 'selected'; ?>>Date</option>
                                                                        <option value="datetime" <?php if ($optionObj->option_type == 'datetime') echo 'selected'; ?>>Date &amp; Time</option>
                                                                        <option value="swatch" <?php if ($optionObj->option_type == 'swatch') echo 'selected'; ?>>Swatch</option>
                                                                    </optgroup>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="option_required[<?php echo $iCount; ?>]" required="" class="form-control select-product-option-type">
                                                                    <option value="0" <?php if ($optionObj->is_required == 0) echo 'selected'; ?>>No</option>
                                                                    <option value="1" <?php if ($optionObj->is_required == 1) echo 'selected'; ?>>Yes</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="option_sort_order[<?php echo $iCount; ?>]" value="<?php echo $optionObj->sort_order; ?>" required="" class="form-control"></td>

                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="option-box" id="option_fields<?php echo $iCount; ?>">
                                                    <div class="option-box-value">
                                                        <table width="100%" class="option-value-header" id="option_Table_<?php echo $iCount; ?>">
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Sku</th>
                                                                    <th>Price</th>
                                                                    <th>Price Type</th>
                    <?php if ($optionObj->option_type == 'swatch'): ?>
                                                                        <th>Image</th>
                                                                <?php endif; ?>
                                                                    <th>Sort Order</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $iValCount = 0;
                                                                $optionValues = (array) $optionValues;
                                                                
                                                                foreach ($optionValues['value_title'] as $key => $optionVal) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><input type="text" name="value_title[<?php echo $iCount; ?>][<?php echo $iValCount; ?>]" value="<?php echo $optionVal; ?>" required="" class="form-control"></td>
                                                                        <td><input type="text" name="value_sku[<?php echo $iCount; ?>][<?php echo $iValCount; ?>]" value="<?php echo $optionValues['value_sku'][$key]; ?>" required="" class="form-control"></td>
                                                                        <td><input type="text" name="value_price[<?php echo $iCount; ?>][<?php echo $iValCount; ?>]" value="<?php echo $optionValues['value_price'][$key]; ?>" required="" class="form-control"></td>
                                                                        <td>
                                                                            <select name="value_price_type[<?php echo $iCount; ?>][<?php echo $iValCount; ?>]" required="" class="form-control">
                                                                                <option value="fixed" <?php if ($optionValues['value_price_type'][$key]=='fixed') echo 'selected';?>>Fixed</option>
                                                                                <option valur="Percentage" <?php if ($optionValues['value_price_type'][$key]=='Percentage') echo 'selected';?>>Percentage</option>
                                                                            </select>
                                                                        </td>
                                                            <?php if ($optionObj->option_type == 'swatch'): ?>
                                                                            <td><input type="file" name="custom_image[<?php echo $iCount; ?>][<?php echo $iValCount; ?>]" class="form-control" accept="image/*"></td>
                                                                    <?php endif; ?>
                                                                        <td><input type="text" name="value_sort_order[<?php echo $iCount; ?>][<?php echo $iValCount; ?>]" value="<?php echo $optionValues['value_sort_order'][$key]; ?>" required="" class="form-control"></td>
                                                                        <td><a href="javascript:void(0);" style="color:#ff6666; font-size: 12px;" title="Remove Option value" onclick="removeOptionValues(this)"><i class="fa fa-remove pull-right"></i></a></td>
                                                                    </tr>

                        <?php
                        $iValCount++;
                    }
                    ?>
                                                            </tbody>
                                                        </table>
                                                        <br><a href="javascript:void(0);" onclick="appendFields(<?php echo $iCount; ?>);" class="btn btn-primary">+More</a>
                                                        <input type="hidden" id="index_counter_<?php echo $iCount; ?>" value="1">
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $iCount++;
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- end custom options -->
                    <div class="tab-pane" id="7">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Title'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['upload_file_title'])) echo $this->arrayData['upload_file_title']; ?>" name="db_upload_file_title" type="text">
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 nopadding control-label"><?php echo $this->__aT('Upload file'); ?></label> 
                                <div class="col-md-10">
                                    <input type="file" data-style="fileinput" name="db_upload_filename">
                                    <?php if (!empty($this->arrayData['upload_filename'])): ?>
                                        <i class="fa fa-file text-info" style="font-size: 20px; margin-top: 20px;"></i>
            <?php echo $this->arrayData['upload_filename']; ?>
                                        <span style="margin-left: 40px;"><a href="<?php echo mainframe::__adminBuildUrl('catalog/deleteProductFile/id/' . $this->arrayData['catalog_id']); ?>" title="delete"><i class="fa fa-trash delete_file"></i></a></span>
        <?php endif; ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <!--Related products-->
                    <div class="tab-pane" id="8">
                        <fieldset>
                            <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="check_all" id="check_all"> <?php echo $this->__aT('All'); ?></th>
                                    <th>&nbsp;</th>
                                    <th><?php echo $this->__aT('Product Name'); ?></th>
                                    <th><?php echo $this->__aT('Product Categoty'); ?></th>
                                    <th><?php echo $this->__aT('Artical No'); ?></th>
                                    <th><?php echo $this->__aT('Product Type'); ?></th>
                                    <th><?php echo $this->__aT('Price'); ?></th>
                                    <th><?php echo $this->__aT('Status'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                            <?php 
                                $related_products =[];
                                if(!empty($this->relatedProductData)){
                                    $relatedProductsArr = explode(',',$this->relatedProductData->related_product_id);
                                }
                                foreach($this->productData as $relatedProduct):?>
                                    <?php                        
                                        $selected ='';
                                        if(!empty($relatedProductsArr)){
                                            if(in_array($relatedProduct->catalog_id, $relatedProductsArr))
                                                    $selected = 'checked'; 
                                        } 
                                    ?>
                                <tr>  
                                    <td><input type="checkbox" name="relatedProducts[]" class="product_check" value="<?php echo $relatedProduct->catalog_id?>" <?php echo $selected?>></td>
                                    <td style="text-align: center;width:100px;"><img src="<?php echo SITE_URL . SITE_UPLOADPATH .$relatedProduct->image; ?>" style="width:90px;"></td>
                                    <td><?php echo $this->getAttributeValue($relatedProduct->catalog_id, 'name'); ?></td>
                                    <td><?php echo $this->getCategoryAttributeValueModel($relatedProduct->category_id, 'cat_name'); ?></td>
                                    <td><?php echo $relatedProduct->sku; ?></td>
                                    <td>
                                    <?php   switch ($relatedProduct->product_type) {
                                                case 1:
                                                    echo 'Simple Product';
                                                    break;
                                                case 2:
                                                    echo 'Subscription Products';
                                                    break;
                                                case 3:
                                                    echo 'Downloadable Products';
                                                    break;
                                                default:
                                                     echo 'other';
                                                    break;
                                            }
                                    ?>        
                                    </td>
                                    <td><?php echo $relatedProduct->price; ?></td>
                                    <td><?php echo ($relatedProduct->status == '1')? 'Active' : 'Inactive'; ?></td>
                                </tr>
                                 <?php endforeach;?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

            <div class="form-actions fluid zero-botom-margin">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
                        </div>
                    </div>
                </div> 
            </div>
        
        <input type="hidden" name="id" value="<?php echo $this->editProductId; ?>">

    </div>
</form>


<script type="text/javascript">
    var optionCounter = <?php echo intval($iCount); ?>;

    function addMore() {
        var list = '<li>'
                + '<label class="col-md-2 nopadding control-label"><?php echo $this->__aT('Product Gallery Images'); ?></label>'
                + '<div class="col-md-10">'
                + '<div class="col-md-4" style="padding-left:0px">'
                + '<input type="file"  name="gallery_images[]" multiple="true" accept="image/*">'
                + '</div>'
                + '<div class="col-md-2">'
                + '<a href="javascript:void(0)" style="font-size:20px;" onclick="removeRow(this);"><i class="fa fa-close"></i></a>'
                + '</div>'
                + '</div>'
                + '</li>'
        $('#product_gallery_image').append(list);
    }

    function removeRow(ev) {
        $(ev).parent().parent().parent().remove();
    }

    function removeOption(ev) {
        $(ev).parent().remove();
    }
    function removeOptionValues(ev) {
        $(ev).parent().parent().remove();
    }
       
    $("#check_all").change(function(){  //"select all" change 
        var status = this.checked; // "select all" checked status
        $('.product_check').each(function(){ //iterate all listed checkbox items
            this.checked = status; //change ".checkbox" checked status
        });
    });

</script>    