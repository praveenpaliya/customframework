<section class="collapse_area">
    <div class="container">
    	<div class="row">
            <div class="col-xs-12 col-sm-3">
                <?php $this->loadTheme('customer-sidebar');?>
            </div>

            <div class="col-xs-12 col-sm-9">
                <div class="panel col-xs-12 col-sm-12 col-md-10 nopadding col-md-offset-1">
                    <form method="post" id="savecustomer" action="<?php echo SITE_URL . 'customer/saveCustProfile';?>" class="col-md-10 box-padding">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                        <a  href="#1" data-toggle="tab"><?php echo $this->__t('Profile Details');?></a>
                            </li>
                            <li>
                                <a href="#2" data-toggle="tab"><?php echo $this->__t('Billing Address');?></a>
                            </li>
                        </ul>
                        <div class="tab-content" style="padding: 20px; border: 1px solid #ddd;">
                            <div class="tab-pane active" id="1">
                                <fieldset>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('First Name');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['first_name'])) echo $this->arrayData['first_name'];?>" name="md_first_name" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('Last Name');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['last_name'])) echo $this->arrayData['last_name'];?>" name="md_last_name" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('Email');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['email'])) echo $this->arrayData['email'];?>" name="md_email" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('Phone');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['phone'])) echo $this->arrayData['phone'];?>" name="md_phone" type="text" required>
                                    </div>
                                    
                                </fieldset>
                            </div>
                            <div class="tab-pane" id="2">
                                <fieldset>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('Address');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['address1'])) echo $this->arrayData['address1'];?>" name="billing[md_address1]" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('City');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['city'])) echo $this->arrayData['city'];?>" name="billing[md_city]" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('State');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['state'])) echo $this->arrayData['state'];?>" name="billing[md_state]" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('Country');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['country'])) echo $this->arrayData['country'];?>" name="billing[md_country]" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $this->__t('Postal Code');?></label>
                                        <input class="form-control" value="<?php if(!empty($this->arrayData['zip_code'])) echo $this->arrayData['zip_code'];?>" name="billing[md_zip_code]" type="text" required>
                                    </div>
                                    
                                </fieldset>
                            </div>
                        </div>
                        
                        <div>
                            <input type="submit" value="<?php echo $this->__t('Save');?>"  class="btn btn-primary" onclick="updateProfile();">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $this->customerId;?>">
                        <input type="hidden" name="address_id" value="<?php echo intval($this->arrayData['address_id']);?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>