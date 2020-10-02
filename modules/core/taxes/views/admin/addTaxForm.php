<?php //print_r($this->taxData); die; ?>

<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('taxes/saveTax'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo!empty($this->taxId) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Tax'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('taxes/allTaxes'); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="col-xs-12 innerbox">
            <fieldset>
                <div class="form-group">
                    <label><?php echo $this->__aT('Country'); ?></label> 
                    <select name="md_country" required class="form-control">
                        <option value=""><?php echo $this->__aT('-- Select country --'); ?></option>
                        <?php foreach ($this->countriesData as $country): ?>
                            <?php
                            $selected = '';
                            if (!empty($this->taxData->id)) {
                                if ($country->country_name == $this->taxData->country) {
                                    $selected = 'selected';
                                }
                            }
                            ?>
                            <option value="<?php echo $country->country_name ?>" <?php echo $selected ?> ><?php echo $country->country_name . ' (' . $country->country_code . ')' ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('State'); ?></label>
                    <input type="text" class="form-control" name="md_state" required value="<?php echo $this->taxData->state; ?>"/>
                </div>

                <div class="form-group">
                    <label><?php echo $this->__aT('Tax rate'); ?></label>
                    <input type="text" class="form-control" name="md_tax_rate" required placeholder="%" value="<?php echo $this->taxData->tax_rate; ?>"/>
                </div>

            </fieldset>
            <div>
                <input type="hidden" name="taxRecordId" value="<?php echo $this->taxData->id; ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
        </div>	
    </div>
</form>
