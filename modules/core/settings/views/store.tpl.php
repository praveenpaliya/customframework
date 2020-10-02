<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/save'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Store Settings'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save'); ?> <i class="icon-angle-right"></i></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-10 box-padding">

            <input type="hidden" name="method" value="store">
            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Admin Interface Language'); ?></label>
                            <select name="config[admin_language]" required class="form-control">
                                <?php
                                foreach ($this->languages as $objLang) {
                                    ?>
                                    <option value="<?php echo $objLang->lang_id ?>" <?php if ($this->arrayData['admin_language']->config_value == $objLang->lang_id) echo 'selected'; ?>><?php echo $objLang->language ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Default Language'); ?></label>
                            <select name="config[default_lang]" required class="form-control">
                                <?php
                                foreach ($this->languages as $objLang) {
                                    ?>
                                    <option value="<?php echo $objLang->lang_id ?>" <?php if ($this->arrayData['default_lang']->config_value == $objLang->lang_id) echo 'selected'; ?>><?php echo $objLang->language ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Active Languages'); ?></label>

                            <select name="languages[]" required class="form-control multiselect" multiple size="20">
                                <?php
                                foreach ($this->languages as $objLang) {
                                    ?>
                                    <option value="<?php echo $objLang->lang_id ?>" <?php if ($objLang->active == 1) echo 'selected'; ?>><?php echo $objLang->language ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Default Currency'); ?></label>
                            <select name="config[default_currency]" required class="form-control">
                                <?php
                                foreach ($this->currencies as $objCurrency) {
                                    ?>
                                    <option value="<?php echo $objCurrency->currency_code ?>" <?php if ($this->arrayData['default_currency']->config_value == $objCurrency->currency_code) echo 'selected'; ?>><?php echo $objCurrency->currency_name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->__aT('Allowed Currency'); ?></label>

                            <select name="currency[]" required class="form-control multiselect" multiple size="20">
                                <?php
                                foreach ($this->currencies as $objCurrency) {
                                    ?>
                                    <option value="<?php echo $objCurrency->currency_code ?>" <?php if ($objCurrency->active == 1) echo 'selected'; ?>><?php echo $objCurrency->currency_name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                    </fieldset>
                </div>	
                <div class="form-actions fluid zero-botom-margin">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>