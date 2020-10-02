<div class="row">
    <?php
    foreach ($this->arrayData as $objCategory) {
    ?>
    <div class="col-md-3 col-xs-12 col-sm-6" style="margin-bottom:15px;">
        <div class="products">
            <div class="img_holder" style="background: url(<?php echo SITE_URL.'show-thumb.php?file='.SITE_UPLOADPATH.$objCategory->cat_image.'&w=263&h=175&s=0';?>) center center no-repeat;">
                
            </div>
            <div class="producttitle">
                <h3><?php echo $this->getCategoryAttributeValueModel($objCategory->category_id, 'cat_name');?></h3>
            </div>
            <div class="shopnowbtn">
                <p><a href="<?php echo $this->getUrl($this->category_url.$objCategory->category_id);?>">Shop Now</a></p>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>