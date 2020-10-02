<style>
.fancybox-desktop {
    max-width: 1060px;
    width: 1060px !important;
    left: 220px !important;
}

.fancybox-desktop .fancybox-inner {
    max-width: 1030px;
    min-width: 1030px !important;
}
.fa-question {
    font-size: 20px;
    background: #000;
    color: #fff;
    width: 28px;
    border-radius: 50%;
    height: 28px;
    text-align: center;
    line-height: 28px;
}
</style>

<div class="shopping-cart-area">
    <div class="container nopadding">
        
        <div class="row" style="margin: 10px 0px 0px 0px;">
            <div class="col-xs-12 pull-right" style="border:1px solid #ccc;padding:10px;background-color: #e1f4ff;margin-bottom: 10px;">
                <div class="col-xs-12 col-sm-2"><h4>Is this a gift?</h4></div>
                <div class="col-xs-12 col-sm-7 nopadding">
                    Purchase a pre-paid mailing label so you can easily write your letter, return the product to the box, affix the label and send to your loved one or friend!
                </div>
                <div class="col-xs-12 col-sm-3 pull-right text-right">
                    <a href="/eternity-letter-gift">
                        <i class="fa fa-question"></i>
                    </a>
                    <a class="various" data-fancybox-type="iframe" href="/stamp.php" style="">
                        <button class="button2 get" style="margin-top:5px;padding: 5px 30px;">
                            <span>
                                <span>Buy a Mailing Label</span>
                            </span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="s-cart-all">
                    <div class="cart-form table-responsive ma">
                        <table id="shopping-cart-table" class="data-table cart-table table">
                            <tbody>
                                <tr>
                                    <th class="col-sm-8 col-md-6"><?php echo $this->__t('Product'); ?></th>
                                    <th class="col-sm-1 col-md-1"><?php echo $this->__t('Qty'); ?></th>
                                    <th class="col-sm-1 col-md-1"><?php echo $this->__t('Unit Price'); ?></th>
                                    <th class="col-sm-1 col-md-1"><?php echo $this->__t('Total'); ?></th>
                                    <th class="col-sm-1 col-md-1"></th>
                                </tr>
                                <?php
                                $cartItemPrice = 0;
                                $taxRate = 0;
                                $custom_price = 0;

                                foreach ($this->arrayData as $objCart) {
                                    $objProduct = $this->getProductDetails($objCart->pid);
                                    //$unitPrice = $this->showProductWithTax($objCart->pid, false, 0);
                                    $unitPrice = $objCart->price;
                                    $taxRate = $this->varifyTaxes($objCart);
                                    ?>
                                    <tr>
                                        <td class="sop-cart">
                                            <div class="media">
                                                <a href="#" class="thumbnail pull-left">
                                                    <img class="primary-image" alt="" src="<?php echo SITE_URL . SITE_UPLOADPATH . $objProduct->image; ?>" style="max-width:80px; max-height:80px;">
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        <a href="#"><?php echo $this->getAttribute($objProduct->catalog_id, 'name'); ?></a>
                                                    </h4>
                                                    <ul style="text-align: left">
                                                    <?php
                                                    $custom_option = json_decode($objCart->custom_option);
  
                                                        foreach ($custom_option as $option) {
                                                            if (!empty($option->value)) {
                                                                $optionArr = explode('|', $option->value, 2);
                                                                $option_val = $optionArr[1];
                                                                
                                                                if ($optionArr[1] == '')
                                                                    $option_val = $optionArr[0];
                                                                echo '<li>' . $option->title . ': ' . $option_val. ' </li>';
                                                                
                                                                $custom_price += $optionArr[0];
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                    SKU: <?php echo $objProduct->sku; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cen">
                                            <input class="input-text qty form-control" type="text" id="itemqty_<?php echo $objCart->id; ?>" name="qty" maxlength="12" value="<?php echo $objCart->qty; ?>" title="Qty">
                                            <div class="tas ce-ta">
                                                <a class="add" title="" data-toggle="tooltip" href="javascript: void(0);" onclick="updateQty(<?php echo $objCart->id; ?>, <?php echo $objProduct->catalog_id; ?>);" data-original-title="<?php echo $this->__t('Update'); ?>">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="sop-cart"><?php echo CURRENCY.round(($unitPrice + $custom_price), 2); ?></td>
                                        <td class="sop-cart"><?php echo CURRENCY . (round(($unitPrice + $custom_price), 2) * $objCart->qty); ?></td>


                                        <td class="sop-icon">
                                            <div class="tas">
                                                <a class="add" title="" data-toggle="tooltip" href="<?php echo SITE_URL . 'catalog/removecart/pid/' . $objCart->pid; ?>" data-original-title="<?php echo $this->__t('Remove'); ?>">
                                                    <i class="fa fa-times-circle"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $cartItemPrice += (round(($unitPrice + $custom_price), 2)* $objCart->qty);
                                }
                                ?>
                            </tbody>
                            <tfoot>
                            <?php
                            if(empty($this->arrayData)) {
                            ?>
                            <tr>
                                <td colspan="7">Cart is Empty!</td>
                            </tr>
                            <?php
                            }
                            ?>    
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(!empty($this->arrayData)) {
?>
<section class="shop-collaps-area">
    <div class="container nopadding">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Added Praveen Paliya -->
                <div id="couponAlert" class="alert alert-danger alert-dismissable fade in" style="display: none;">
                    <span id="couponAlertMsg"></span>
                    <a href="javascript:void(0)" class="close"  aria-label="close" onclick="closeAlert()">&times;</a>
                </div>
                <!-- end -->
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="faq-accordion ced-fag">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default active">
                            <div class="panel-heading active" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <?php echo $this->__t('Use Coupon Code'); ?> <i class="fa fa-caret-down"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="input-group">

                                        <input id="useCoupon" class="form-control" type="text" placeholder="<?php echo $this->__t('Enter coupon code'); ?>">
                                        <span class="input-group-btn">
                                            <input class="btn pet button2 get" type="button" onclick="varifyCoupon()" value="<?php echo $this->__t('Apply Coupon'); ?>">
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12  col-xs-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <strong><?php echo $this->__t('Sub Total'); ?>:</strong>
                            </td>

                            <td class="text-center"><?php echo CURRENCY .' '. $cartItemPrice; ?></td>
                        </tr>

                        <!-- Edited Praveen Paliya -->
                        <?php
                        if (!empty($_SESSION['couponCode'])):
                            $objDiscount = $this->checkCoupon($cartItemPrice);
                            //$totalPrice = ceil($cartItemPrice - $objDiscount->discount);
                            ?>
                            <tr>
                                <td class="text-center"> 
                                    <strong>Coupon Discount:</strong> 
                                </td> 
                                <td class="text-center"><?php echo CURRENCY . ceil($objDiscount->discount) ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr id="couponDiscount"></tr>
                        <!-- End Praveen Paliya -->    

                        <?php if (!empty($_SESSION['uid'])): ?>
                            <tr>
                                <td class="text-center"> <?php echo $this->__t('Applicable Taxes') . ' (' . $taxRate . "%)"; ?></td>
                                <td class="text-center">
                                    <?php
                                    $taxAmount = ceil(($cartItemPrice) * $taxRate / 100);
                                    echo CURRENCY . $taxAmount;
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>                                      


                        <tr>
                            <td class="text-center">
                                <strong><?php echo $this->__t('Total'); ?>:</strong>
                            </td>

                            <td class="text-center"><?php echo CURRENCY . (($cartItemPrice + $taxAmount) - $objDiscount->discount); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="buttons">
                    <div class="col-xs-6">
					<div class="row">
                        <a href="<?php echo ISP :: FrontendUrl('catalog'); ?>">
                            <button class="button2 get">
                                <span>
                                    <span><?php echo $this->__t('Continue Shopping'); ?></span>
                                </span>
                            </button>
                        </a>
						</div>
                    </div>
                    <div class="pull-right col-xs-6">
					<div class="row">
                        <a href="<?php echo SITE_URL . 'catalog/checkout'; ?>">
                            <button class="button2 get" style="float: right;">
                                <span>
                                    <span><?php echo $this->__t('Checkout'); ?></span>
                                </span>
                            </button>
                        </a>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
?>

<script type="text/javascript">

    /**
     * @author Praveen Paliya 23/05/2017
     * @use Method is used for close Coupon alert box
     * @return  
     */
    function closeAlert() {
        $('#couponAlert').css('display', 'none');
    }

    /**
     * @author Praveen Paliya 23/05/2017
     * @use Method is used for varify Coupon code
     * @return  
     */
    function varifyCoupon() {
        var val = $('#useCoupon').val();
        if (val != '') {
            var cartItemPrice = '';
            var total = '';
            $('#useCoupon').val('');
            $.ajax({
                url: "<?php echo SITE_URL . 'catalog/varifyCoupon'; ?>",
                datatype: 'json',
                method: 'post',
                data: {couponCode: val, subTotal:<?php echo $cartItemPrice; ?>},
                success: function (result) {
                    result = JSON.parse(result);

                    if (result != null) {
                        cartItemPrice = '<?php echo $cartItemPrice ?>';
                        total = cartItemPrice - result.discount;
                        $('#couponDiscount').html(
                                '<td class="text-center">\n\
                                    <strong>Coupon Discount:</strong>\n\
                                 </td>\n\
                                 <td class="text-center"><?php echo CURRENCY ?>' + Math.ceil(result.discount) + '</td>'
                                );

                        $('#total').html('<?php echo CURRENCY ?>' + total);
                    } else {
                        $('#couponAlertMsg').html('<strong>Caution!</strong> Invailid coupon code OR currently using the same coupon');
                        $('#couponAlert').css('display', 'block');
                    }
                }
            });
        } else {
            $('#couponAlertMsg').html('<strong>Caution!</strong> Please enter the coupon code');
            $('#couponAlert').css('display', 'block');
        }
    }


    /**
     * function used to update cart item qty
     * @returns
     */
    function updateQty(cartid, pid) {
        var cartId = cartid;
        var pid = pid;
        var item_qty = $('#itemqty_' + cartId).val();
        var url = "<?php echo SITE_URL . 'catalog/updateQuantity'; ?>";
        if (item_qty > 0) {
            $.ajax({
                url: url,
                datatype: 'json',
                method: 'post',
                data: {itemqty: item_qty, catalog_id: pid, cart_id: cartId},
                success: function (result) {
                    result = jQuery.parseJSON(result);
                    $('#itemqty_' + cartId).html(result);
                    location.reload(true);
                }
            });
        }
    }
</script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".various").fancybox();
    });
</script>
