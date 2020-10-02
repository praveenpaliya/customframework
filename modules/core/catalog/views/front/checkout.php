<form method="post" action="<?php echo SITE_URL.'orders/saveorder'?>">
    <section class="collapse_area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="check">
                        <h2><?php echo $this->__t('Checkout');?></h2>
                    </div>
                    <?php
                    $arrCustomer = array();
                    if (empty($_SESSION['uid'])) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="<?php echo SITE_URL.'customer/login/redirect_to/'.base64_encode('catalog/checkout')?>"><?php echo $this->__t('Already have account or want to Register to Contine? Click here');?></a>
                        </div>
                    </div>
                    <?php
                    }
                    else {
                        $objCustomer = new customer();
                        $objCustomer->getCustomer($_SESSION['uid']);
                        $arrCustomer = $objCustomer->arrayData;
                    }
                    ?>
                    
                        <div class="col-xs-12 col-sm-7">
                        <div class="row">
                            <!--- Billing Address Container ---->
                            <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="check">
                                    <h3><?php echo $this->__t('Billing Address');?></h3>
                                    <h6>&nbsp;</h6>
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_fname" required name="billing_fname" value="<?php echo $arrCustomer['first_name'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('First Name');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_lname" required name="billing_lname" value="<?php echo $arrCustomer['last_name'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('Last Name');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_email" required name="billing_email" value="<?php echo $arrCustomer['email'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('Email');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_phone" required name="billing_phone" value="<?php echo $arrCustomer['phone'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('Phone Number');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_address" required name="billing_address" value="<?php echo $arrCustomer['address1'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('Address');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_city" required name="billing_city" value="<?php echo $arrCustomer['city'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('City');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_zipcode" required name="billing_zipcode" value="<?php echo $arrCustomer['zip_code'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('Zip Code');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" data-attr="shipping_state" id="billing_state" required name="billing_state" value="<?php echo $arrCustomer['state'];?>" class="form-control billingprofile" placeholder="<?php echo $this->__t('State');?>">
                                </div>
                                <div class="form-group">
                                    <select name="billing_country" id="billing_country" data-attr="shipping_country" required class="form-control billingprofile">
                                        <option value="">-- <?php echo $this->__t('Country'); ?> --</option>
                                        <?php foreach ($this->countries as $objcountries): ?>
                                            <option value="<?php echo $objcountries->country_name; ?>" <?php echo ($arrCustomer['country']==$objcountries->country_name)?'selected':'';?>><?php echo $objcountries->country_name; ?></option> 
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            </div>

                            <!--- Shipping Address Container -->
                            <div class="col-sm-6 col-xs-12 nopadding">
                                <div class="check">
                                    <h3><?php echo $this->__t('Shipping Address');?></h3>
                                    <h6><?php echo $this->__t('Same as Billing Address');?> <input type="checkbox" onclick="sameashipping(this);" style="position: inherit"></h6>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_fname" required id="shipping_fname" class="form-control" placeholder="<?php echo $this->__t('First Name');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_lname" required id="shipping_lname" class="form-control" placeholder="<?php echo $this->__t('Last Name');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_email" required id="shipping_email" class="form-control" placeholder="<?php echo $this->__t('Email');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_phone" required id="shipping_phone" class="form-control" placeholder="<?php echo $this->__t('Phone Number');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_address" required id="shipping_address" class="form-control" placeholder="<?php echo $this->__t('Address');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_city" required id="shipping_city" class="form-control" placeholder="<?php echo $this->__t('City');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_zipcode" required id="shipping_zipcode" class="form-control" placeholder="<?php echo $this->__t('Zip Code');?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="shipping_state" required id="shipping_state" class="form-control" placeholder="<?php echo $this->__t('State');?>">
                                </div>
                                <div class="form-group">
                                    <select name="shipping_country" id="shipping_country" required class="form-control">
                                        <option value="">-- <?php echo $this->__t('Country'); ?> --</option>
                                        <?php foreach ($this->countries as $objcountries): ?>
                                            <option value="<?php echo $objcountries->country_name; ?>" <?php echo ($arrCustomer['country']==$objcountries->country_name)?'selected':'';?>><?php echo $objcountries->country_name; ?></option> 
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>


                              <!--Shipping options-->
                            <div class="shipping_box_wrapper">
                                <h4><?php echo $this->__t('Shipping Method');?></h4>
                                
                            </div>
                            
                            <!--Payment options-->
                            <div>
                                <h4><?php echo $this->__t('Payment Methods');?></h4>
                                <div class="form-group">
                                    <ul style="list-style: none;padding-left: 0px " class="payment_list">
                                        <?php foreach($this->paymentMethod as $paymentMethod): ?>
                                        <li>
                                            <input type="radio" class="paymentMethod" name="paymentMethod" required value="<?php echo $paymentMethod->code.','.$paymentMethod->method_id?>" onclick="jQuery('.metainfo').hide(); jQuery('#meta_info_<?php echo $paymentMethod->method_id;?>').show();">
                                            &nbsp;&nbsp;<label><?php echo $paymentMethod->method_title?></label>
                                            <div class="metainfo" style="display:none;" id="meta_info_<?php echo $paymentMethod->method_id;?>">
                                            <?php
                                                if($paymentMethod->show_meta==1) {
                                                    $this->objPayment->getPaymentMetas($paymentMethod->method_id);
                                                    foreach($this->objPayment->paymentMeta as $objMeta) {
                                                ?>
                                                        <label><?php echo $objMeta->meta_key;?>:</label> <?php echo $objMeta->meta_value;?>
                                                        <br>
                                                <?php
                                                    }
                                                }
                                            ?>
                                            </div>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>

                            <div style="display: none;">
                                <h4><?php echo $this->__t('Letter Message');?></h4>
                                <table width="100%" cellpadding="3">
                                    <tr>
                                        <td colspan="4" style="padding-bottom:10px;">
                                            <select name="letter_type" id="letter_type" onchange="updateLetterType();">
                                                <option value="">--Select Letter Format</option>
                                                <option value="12.95|Handwritten Letter">Handwritten Letter (+$12.95)</option>
                                                <option value="4.95|Printed Letter">Printed Letter (+$4.95)</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr style="display: none;" id="letter_font_row">
                                        <td colspan="4" class="font_radio_button"  style="padding-bottom:10px;">
                                            <input type="radio" id="font_times" value="Times New Roman  Size 12" name="letter_font" onclick="setCharacterLimit('1760');">
                                            <label for="font_times">Times New Roman</label>

                                            <input type="radio" id="font_script" value="Script MT Bold Size 12" name="letter_font" onclick="setCharacterLimit('1760');">
                                            <label for="font_script">Script MT Bold</label>

                                            <input type="radio" id="font_book" value="Book Antiqua (ITALIC) Size 12" name="letter_font" onclick="setCharacterLimit('1760');">
                                            <label for="font_book">Book Antiqua (ITALIC)</label>

                                            <input type="radio" id="font_papyrus" value="Papyrus (ITALIC) Size 11" name="letter_font" onclick="setCharacterLimit('1800');">
                                            <label for="font_papyrus">Papyrus (ITALIC)</label>
                                        </td>
                                    </tr>

                                    <tr style="display: none;" class="letter_msg_box">
                                        <td colspan="4" style="padding-bottom:10px;">
                                            <select name="savedmessages" onchange="FilledMessage(this.value);">
                                                <option value="">--Select Saved Messages--</option>
                                            <?php
                                            $messages = $this->loadCustomerMessages();
                                            $msg_arr = array();
                                            foreach($messages as $msg) {
                                                $msg_arr[$msg->id] = addslashes(strip_tags(html_entity_decode($msg->message)));
                                            ?>
                                                <option value="<?php echo $msg->id;?>"><?php echo $msg->title;?></option>
                                            <?php
                                            }
                                            $json_messages = json_encode($msg_arr);
                                            ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr style="display: none;" class="letter_msg_box">
                                        <td colspan="4">
                                            <textarea placeholder="<?php echo $this->__t('Message');?>" id="customer_comments" name="customer_comments" style="width:100%; height: 100px; padding:5px;"></textarea>
                                            Character Count <span class="cc_count"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </div>

                        <div class="col-xs-12 col-sm-5 pull-right">
                            <div class="check">
                                 <h3><?php echo $this->__t('Cart Details');?></h3>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="width-1"><?php echo $this->__t('Product Name');?></th>
                                                    <th class="width-2"><?php echo $this->__t('Price');?></th>
                                                    <th class="width-3"><?php echo $this->__t('Qty');?></th>
                                                    <th class="width-4"><?php echo $this->__t('Subtotal');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $cartItemPrice =0;
                                                $custom_price = 0;
                                                foreach($this->arrayData as $objCart) {
                                                    $objProduct = $this->getProductDetails($objCart->pid);
                                                        $unitPrice = $this->showProductWithTax($objCart->pid, false, 0);
                                                        
                                                        $custom_option = json_decode($objCart->custom_option);
        //                                                echo "<pre>";print_r($custom_option);
                                                        foreach($custom_option as $option){
                                                            $optionArr = explode('|', $option->value, 2);
                                                            $custom_price += $optionArr[0];
                                                        }
                                                        
                                                        //$unitPrice = ($unitPrice+$custom_price);
                                                        $unitPrice = $objCart->price;
                                                        $cartItemPrice = $cartItemPrice + $unitPrice*$objCart->qty;
                                                        $taxRate = $this->varifyTaxes($objCart);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="o-pro-dec">
                                                            <p><?php echo $this->getAttribute($objProduct->catalog_id, 'name');?></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="o-pro-price">
                                                            <p><?php echo CURRENCY.$unitPrice;?></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="o-pro-qty">
                                                            <p><?php echo $objCart->qty;?></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="o-pro-subtotal">
                                                            <p><?php echo CURRENCY.($unitPrice*$objCart->qty);?></p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                                }
                                            ?>    
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"><?php echo $this->__t('Subtotal');?> </td>
                                                    <td colspan="1"><?php echo CURRENCY.' '.$cartItemPrice;?></td>
                                                </tr>
                                                <!-- Edited by Praveen Paliya -->
                                                <?php if(!empty($_SESSION['couponCode'])): 
                                                        $objDiscount = $this->checkCoupon($cartItemPrice);
                                                        //$totalPrice = ceil($cartItemPrice - $objDiscount->discount);
                                                    ?>
                                                <tr>
                                                    <td  colspan="3"> 
                                                       <strong><?php echo $this->__t('Coupon Discount');?>:</strong> 
                                                    </td> 
                                                    <td class="text-center"><?php echo CURRENCY.' '.round($objDiscount->discount, 2) ?></td>
                                                </tr>
                                                <?php endif;?>
                                                
                                                <tr>
                                                    <td colspan="3" id="tax_rate"><?php echo $this->__t('Applicable Taxes'). ' ('.$taxRate. "%)";?> </td>
                                                    <td colspan="1" id="tax_value">
                                                        <?php
                                                        $taxAmount = round($cartItemPrice * $taxRate / 100, 2);
                                                        echo CURRENCY .' '. $taxAmount;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr class="tr-f">
                                                    <td colspan="3"><?php echo $this->__t('Shipping & Handling');?> </td>
                                                    <td colspan="1" class="shiptext"><?php echo CURRENCY.' 0';?></td>
                                                </tr>
                                                <tr class="tr-letter">
                                                    <td colspan="3" id="price-letter-type"></td>
                                                    <td colspan="1" class="letter-price"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><?php echo $this->__t('Grand Total');?></td>
                                                    <td colspan="1" class="ordertotaltext"><?php echo CURRENCY.' '.(($cartItemPrice + $taxAmount) - $objDiscount->discount);?></td>
                                                </tr>

                                                

                                                <input type="hidden" id="order_total" name="order_total" value="<?php echo (($cartItemPrice + $taxAmount) - $objDiscount->discount);?>">
                                               
                                                <input type="hidden" id="subtotal" name="subtotal" value="<?php echo $cartItemPrice;?>">
                                                
                                                <input type="hidden" id="tax_amount" name="tax_amount" value="<?php echo $taxAmount;?>">
                                               
                                                <input type="hidden" id="discount_amount" name="discount_amount" value="<?php echo round($objDiscount->discount, 2);?>">
                                                
                                                <input type="hidden" name="coupon_code" value="<?php echo $_SESSION['couponCode'];?>">
                                                
                                                <input type="hidden" class="shiping_method_name" name="shipping_method" value="">
                                                
                                                <input type="hidden" class="shiping_method_price" name="shipping_cost" value="0">
                                                
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="block-right">
                                <button class="button2 get paynowbutton" type="submit" title="">
                                    <span><?php echo $this->__t('Pay Now');?></span>
                                </button>
                            </div>

                        </div>
                   
                </div>
            </div>
        </div>
    </section>
</form>
<script type="text/javascript">
var draft_messages = '';
function jsonEscape(str)  {
    return str.replace(/\n/g, "\\\\n").replace(/\r/g, "").replace(/\t/g, "\\\\t");
}
jQuery(document).ready(function() {
    var draft_messages_json = '<?php echo $json_messages;?>';
    
    draft_messages = JSON.parse(jsonEscape(draft_messages_json));
    console.log(draft_messages);

    jQuery(".shipping_list input:radio:first").prop("checked", true).trigger("click");
    jQuery(".payment_list input:radio:first").prop("checked", true).trigger("click");

    jQuery('#customer_comments').on("input", function(){
        var maxlength = jQuery(this).attr("maxlength");
        var currentLength = jQuery(this).val().length;
        jQuery(".cc_count").text(maxlength-currentLength);
    });
});

function FilledMessage(msgId) {
    if (msgId != "") {
        jQuery.ajax({url: "<?php echo SITE_URL;?>message/getmessage/id/"+msgId, success: function(result){
            jQuery('#customer_comments').val(result.data);
        }});

        //jQuery('#customer_comments').val(draft_messages[msgId]);
    }
    else {
        jQuery('#customer_comments').val('');
    }
}

function setCharacterLimit(cclimit) {
    jQuery(".cc_count").text(cclimit);
    jQuery("#customer_comments").attr('maxlength', cclimit);
}

function sameashipping(shipObj) {
    jQuery(".billingprofile").each(function() {
        var billingVal = jQuery(this).val();
        var shipAttr = jQuery(this).attr("data-attr");

        if(shipObj.checked == true) {
            jQuery("#"+shipAttr).val(billingVal);
        }
        else {
            jQuery("#"+shipAttr).val("");
        }
    });

    updateShippingBox();
}

function updateLetterType() {
    var letter_price = 0 ;

    if ($('#letter_type option:selected').index()==2) { 
        $('#letter_font_row').show();
        $(".letter_msg_box").show();
        $("#font_times").click();
        letter_price = 4.95;
    }
    else { 

        if ($('#letter_type option:selected').index()==1) { 
            $(".letter_msg_box").show();
            jQuery(".cc_count").text(1450);
            jQuery("#customer_comments").attr('maxlength', 1450);
            letter_price = 12.95;
        }
        else {
            $(".letter_msg_box").hide();
        }
        $('#letter_font_row').hide();
    }

    $("#price-letter-type").html('Letter Price');
    $(".letter-price").html('<?php echo CURRENCY;?>'+letter_price);

    var updatedOrderTotal = parseFloat(jQuery('#subtotal').val())+parseFloat(jQuery('#tax_amount').val())-parseFloat(jQuery('#discount_amount').val())+parseFloat(jQuery('.shiping_method_price').val())+parseFloat(letter_price);
    updatedOrderTotal = updatedOrderTotal.toFixed(2);
    jQuery('#order_total').val(updatedOrderTotal);

    $(".ordertotaltext").html('<?php echo CURRENCY;?>'+updatedOrderTotal);
}

function updateShipping(tmpObj) {
    var ship_price = jQuery(tmpObj).attr('data-price');
    if (ship_price == '' || ship_price == null || ship_price == undefined)
        ship_price = 0;

    jQuery('.shiping_method_name').val(jQuery(tmpObj).attr('data-title')); 
    jQuery('.shiping_method_price').val(ship_price); 
    jQuery('.shiptext').html('<?php echo CURRENCY.' ';?>'+jQuery(tmpObj).attr('data-price'));

    var updatedOrderTotal = parseFloat(jQuery('#subtotal').val())+parseFloat(jQuery('#tax_amount').val())-parseFloat(jQuery('#discount_amount').val())+parseFloat(ship_price);
    
    updatedOrderTotal = updatedOrderTotal.toFixed(2);

    jQuery('#order_total').val(updatedOrderTotal);

    jQuery('.ordertotaltext').html('<?php echo CURRENCY.' ';?>'+updatedOrderTotal);
}

function updateShippingBox() {
    var zipcode = jQuery("#shipping_zipcode").val();

    jQuery.ajax({url: "<?php echo SITE_URL;?>catalog/shippingDetails/is_ajax/1/zipcode/"+zipcode, success: function(result){
        jQuery('.shipping_box_wrapper').html(result.data);

        var shippingMethodList = jQuery('.shipping_box_wrapper').html();

        jQuery( 'ul.shipping_list input[name="shippingMethod"]:radio:first' ).click();
    }});

    var billing_country = jQuery("#billing_country").val();
    var billing_state = jQuery("#billing_state").val();
    //console.log(billing_country+"--"+billing_state);

    jQuery.ajax({url: "<?php echo SITE_URL;?>catalog/varifyTaxes/is_ajax/1/country/"+billing_country+"/state/"+billing_state, success: function(result){
        var ship_price = jQuery(".shiping_method_price").val();
        var taxCalculate = parseFloat(jQuery('#subtotal').val())*parseFloat(result)/100;

        if (!isNaN(taxCalculate.toFixed(2)) ) {

            jQuery('#tax_rate').html('Applicable Taxes ('+result+'%)');
            jQuery('#tax_value').html('<?php echo CURRENCY.' ';?>'+taxCalculate.toFixed(2));
            jQuery("#tax_amount").val(taxCalculate.toFixed(2));

            var updatedOrderTotal = parseFloat(jQuery('#subtotal').val())+parseFloat(jQuery('#tax_amount').val())-parseFloat(jQuery('#discount_amount').val())+parseFloat(ship_price);
            //console.log(parseFloat(jQuery('#subtotal').val())+"--"+parseFloat(jQuery('#tax_amount').val())+"--"+parseFloat(jQuery('#discount_amount').val())+"--"+parseFloat(ship_price));
        
            updatedOrderTotal = updatedOrderTotal.toFixed(2);

            jQuery('#order_total').val(updatedOrderTotal);

            jQuery('.ordertotaltext').html('<?php echo CURRENCY.' ';?>'+updatedOrderTotal);
        }

    }});
    
}

jQuery('#shipping_zipcode').blur(function(){
    updateShippingBox();
});

updateShippingBox();
</script>
