<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo intval($this->customerId) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Customer'); ?></h1>
  </div> 
</div>

<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

    <form method="post" action="<?php echo mainframe::__adminBuildUrl('customer/save'); ?>" class="col-md-12 box-padding">
        <ul class="nav tabs">
            <li>
                <a class="active" href="#1" data-toggle="tab" title="<?php echo $this->__aT('Basic Details'); ?>">
                    <i class="fa fa-info-circle" ></i>
                </a>
            </li>

            <li>
                <a href="#2" data-toggle="tab" title="<?php echo $this->__aT('Billing Address'); ?>">
                    <i class="fa fa-user" ></i>
                </a>
            </li>
            <li>
                <a href="#3" data-toggle="tab" title="<?php echo $this->__aT('Shipping Address'); ?>">
                    <i class="fa fa-user" ></i>
                </a>
            </li>
        </ul>
        <div class="card border-top-0 mb-4">
            <div class="card-body">
                <div class="tab-content" style="padding-top:20px;">
                    <div class="tab-pane active" id="1">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Customer Group'); ?></label>
                                <select name="md_customer_group" class="form-control" id="select_customer_group" onchange="setForm();">
                                    <option value="">--Select--</option>
                                    <?php
                                    $selected = '';

                                    foreach ($this->customerGroup as $cgroupData) {
                                        if (!empty($this->arrayData['customer_group'])) {
                                            $selected = ($this->arrayData['customer_group'] == $cgroupData->id) ? 'selected' : '';
                                        }
                                        ?>
                                        <option value="<?php echo $cgroupData->id; ?>" <?php echo $selected ?>><?php echo $cgroupData->customer_group; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div id="business_fields">
                            <?php
                            foreach ($this->customerFields as $objFields) {
                                $fieldValue = $this->getAttributeValue($this->customerId, $objFields->code);
                                ?>
                                <div class="form-group">
                                    <label><?php echo $objFields->label; ?></label>
                                    <?php ISP :: drawCustomerField($objFields, $fieldValue); ?>
                                </div>
                                <?php
                            }
                            ?>   
                            </div>    
                            <div class="form-group">
                                <label><?php echo $this->__aT('First Name'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['first_name'])) echo $this->arrayData['first_name']; ?>" name="md_first_name" type="text" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?php echo $this->__aT('Last Name'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['last_name'])) echo $this->arrayData['last_name']; ?>" name="md_last_name" type="text" required>
                            </div>
                           
                            <div class="form-group">
                                <label><?php echo $this->__aT('Email'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['email'])) echo $this->arrayData['email']; ?>" name="md_email" type="text" required>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Phone'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['phone'])) echo $this->arrayData['phone']; ?>" name="md_phone" type="text" required>
                            </div>
                            <div class="form-group">
                                
                                <?php if (intval($this->customerId) == 0){?>
                                <label><?php echo $this->__aT('Password'); ?></label>
                                    <input class="form-control" value="" name="md_password" type="password" required>
                                <?php }else{?>
                                    <label><?php echo $this->__aT('Reset Password'); ?></label>
                                    <input class="form-control" value="" name="new_password" type="password">
                                <?php }?>    
                            </div>
                            <!--<div class="form-group">
                                <label><?php echo $this->__aT('Web address'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['web_address'])) echo $this->arrayData['web_address']; ?>" name="db_web_address" type="text" placeholder="http://">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Reference information '); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['reference_information'])) echo $this->arrayData['reference_information']; ?>" name="db_reference_information" type="text">
                            </div>-->
                            <div class="form-group">
                                <label><?php echo $this->__aT('Admin Note'); ?></label>
                                <textarea class="form-control editor"  name="db_admin_note"><?php if (!empty($this->arrayData['admin_note'])) echo $this->arrayData['admin_note']; ?></textarea>
                            </div>

                        </fieldset>
                    </div>
                    <div class="tab-pane" id="2">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Address1'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['address1'])) echo $this->arrayData['address1']; ?>" name="billing[db_address1]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Address2'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['address2'])) echo $this->arrayData['address2']; ?>" name="billing[db_address2]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('City'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['city'])) echo $this->arrayData['city']; ?>" name="billing[db_city]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('State'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['state'])) echo $this->arrayData['state']; ?>" name="billing[db_state]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Country'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['country'])) echo $this->arrayData['country']; ?>" name="billing[db_country]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Postal Code'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['zip_code'])) echo $this->arrayData['zip_code']; ?>" name="billing[db_zip_code]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Landmark'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['landmark'])) echo $this->arrayData['landmark']; ?>" name="billing[db_landmark]" type="text">
                            </div>
                            <input class="form-control"  name="billing[type]" value="billing" type="hidden">

                        </fieldset>
                    </div>

                    <div class="tab-pane" id="3">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Address1'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['address1'])) echo $this->customerShippingAdd['address1']; ?>" name="shipping[db_address1]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Address2'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['address2'])) echo $this->customerShippingAdd['address2']; ?>" name="shipping[db_address2]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('City'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['city'])) echo $this->customerShippingAdd['city']; ?>" name="shipping[db_city]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('State'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['state'])) echo $this->customerShippingAdd['state']; ?>" name="shipping[db_state]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Country'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['country'])) echo $this->customerShippingAdd['country']; ?>" name="shipping[db_country]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Postal Code'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['zip_code'])) echo $this->customerShippingAdd['zip_code']; ?>" name="shipping[db_zip_code]" type="text">
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Landmark'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->customerShippingAdd['landmark'])) echo $this->customerShippingAdd['landmark']; ?>" name="shipping[db_landmark]" type="text">
                            </div>
                            <input class="form-control"  name="shipping[type]" value="shipping" type="hidden">

                        </fieldset>
                    </div>

                    <div class="form-actions fluid zero-botom-margin">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" value="exit" name="saveexit" class="btn btn-success"><?php echo $this->__aT('Save Customer'); ?> <i class="icon-angle-right"></i></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <?php
                                    if (intval($this->customerId) >0) {
                                        if ($this->arrayData['status'] == 0) {
                                    ?>
                                            <a href="<?php echo mainframe::__adminBuildUrl('customer/activate/id/'.$this->customerId);?>" onclick="return confirm('Are you sure to activate the profile?');"><button type="button" value="Activate Profile" name="activate" class="btn btn-primary"><?php echo $this->__aT('Activate Profile'); ?></button></a>
                                    <?php
                                        }
                                        else {
                                    ?>
                                            <a href="<?php echo mainframe::__adminBuildUrl('customer/deactivate/id/'.$this->customerId);?>" onclick="return confirm('Are you sure to Deactivate the profile?\n\nCustomer will not be able to login once account will be deactivated.');"><button type="button" value="De-Activate Profile" name="activate" class="btn btn-secondary" ><?php echo $this->__aT('De-Activate Profile'); ?></button></a>
                                    <?php       
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="<?php echo $this->customerId; ?>">
        <input type="hidden" name="address_id" value="<?php echo intval($this->arrayData['address_id']); ?>">
    </form>
</div>


<script>
    $(function(){
       setForm();
    });
    
    function setForm(){
        var customer_group = $('#select_customer_group').val();
        switch (customer_group) {
    case '1':
            $('#business_fields').hide();
        break;
    case '2':
            $('#business_fields').show();
        break;
    case '3':
            $('#business_fields').show();
        break;
    case '4':
            $('#business_fields').show();
        break;

    default:
        
        break;
}
    }
</script>