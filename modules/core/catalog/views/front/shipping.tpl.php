<h4><?php echo $this->__t('Shipping Method');?></h4>
<div class="form-group">
    <ul style="list-style: none;padding-left: 0px " class="shipping_list">
    <?php 
        foreach($this->shippingMethod as $shipMethod): 
            $this->objShipping->getShippingMetas($shipMethod->shipping_id);
            foreach($this->objShipping->shippingMeta as $objMeta) {
                if($objMeta->meta_key=='price') {
                    $shipPrice = $this->showPriceConverted($objMeta->meta_value);
                }
            }
        ?>
        <li>
            <input required type="radio" onclick="updateShipping(this);" class="paymentMethod default" name="shippingMethod" required value="<?php echo $shipMethod->shipping_id?>" data-title="<?php echo $shipMethod->method_title?>" data-price="<?php echo ($shipPrice)?$shipPrice:0;?>">
            &nbsp;&nbsp;<label><?php echo $shipMethod->method_title?></label>
           <?php if ($shipPrice>0)echo CURRENCY.' '.$shipPrice;?>
        </li>
        <?php 
        endforeach;

        $methodExists = false;

        $uspsMethods = $this->objShipping->listUSPSMethods();
        foreach($uspsMethods['Package'] as $objUSPS) {
            if ($objUSPS['Postage']['MailService'] <> '') {
                $methodExists = true;
    ?>
        <li>
            <input required type="radio" onclick="updateShipping(this);" class="paymentMethod usps" name="shippingMethod" required value="<?php echo $objUSPS['Postage']['MailService']?>" data-title="<?php echo $objUSPS['Postage']['MailService']?>" data-price="<?php echo $objUSPS['Postage']['Rate']?>">
            &nbsp;&nbsp;<label><?php echo html_entity_decode($objUSPS['Postage']['MailService'])?></label>
           <?php if ($objUSPS['Postage']['Rate'] > 0)echo CURRENCY.' '.$objUSPS['Postage']['Rate'];?>
        </li>
    <?php
            }

        }
    ?>
    </ul>
</div>