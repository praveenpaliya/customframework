<h3 id="cat-<?php echo $this->editCategoryId;?>" style="margin-top:20px; border-top:1px solid #ccc; padding-top:20px;"><?php echo $this->pageTitle;?></h3>
<div class="row catdesc">
    <div class="col-xs-12">
        <?php
        $catImage = $this->getCategoryDetails($this->editCategoryId)->cat_image;
        if ($catImage <> '') {
        ?>
            <img src="<?php echo SITE_URL.SITE_UPLOADPATH.$catImage;?>" align="left" hspace="5" vspace="5" style="max-width: 325px; margin: 0px 10px 7px 0px">
            <?php 
        }
        echo $shortDesc = $this->getCategoryAttributeValueModel($this->editCategoryId, 'short_description');
        echo $this->getCategoryAttributeValueModel($this->editCategoryId, 'cat_desc');
        ?>
    </div>
</div>