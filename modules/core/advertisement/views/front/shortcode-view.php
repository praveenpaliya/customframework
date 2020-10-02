<section>
    <div class="container">
        <div class="row">
            <?php
            foreach ($this->arrayData as $objProduct) {
                ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-md-3">
                    <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $objProduct->image; ?>" class="img-responsive">
                    <h2 class="product-name"><?php echo $this->getAttributeValue($objProduct->catalog_id, 'name'); ?></h2>
                    <h3 class="price"><?php echo $objProduct->price; ?></h3>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>