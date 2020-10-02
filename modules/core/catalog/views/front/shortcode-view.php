<div class="row">
    <div class="letter col-xs-12">
    <?php
    foreach ($this->arrayData as $objProduct) {
    ?>
            <div class="col-xs-6 col-md-3">
                <div class="letter_box">
                    <a href="<?php echo $this->getUrl($this->product_url.$objProduct->catalog_id);?>">
                        <img src="<?php echo SITE_URL.'show-thumb.php?file='.SITE_UPLOADPATH.$objProduct->image.'&w=270&h=375';?>" alt="">
                        <div class="lettercontent">
                            <h3><?php echo $this->getAttributeValue($objProduct->catalog_id, 'name');?></h3>
                            <div class="price">
                                <p><?php echo $this->showProductWithTax($objProduct->catalog_id, true, 0); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
    <?php
    }
    ?>
    </div>
</div>
   