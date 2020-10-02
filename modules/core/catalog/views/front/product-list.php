<style>
.catdesc p, .catdesc div {
    line-height: 23px;
}
</style>
<section class="productslisting">
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-xs">
                <?php include('category.sidebar.php');?>
            </div>
            <div class="col-md-9 col-xs-12">
                <h1 id="cat-<?php echo $this->editCategoryId;?>"><?php echo $this->pageTitle;?></h1>
                <div class="row catdesc">
                    <div class="col-xs-12">
                        <?php
                        $catImage = $this->getCategoryDetails($this->editCategoryId)->cat_image;
                        if ($catImage <> '') {
                        ?>
                            <img src="<?php echo SITE_URL.SITE_UPLOADPATH.$catImage;?>" align="left" hspace="5" vspace="5" style="max-width: 350px; margin: 0px 10px 7px 0px">
                            <?php 
                        }
                        echo $shortDesc = $this->getCategoryAttributeValueModel($this->editCategoryId, 'short_description');
                        if (strip_tags($shortDesc) <> '') {
                        ?>
                        <a href="<?php echo SITE_URL.'world-of-eternity-letter#cat-'.$this->editCategoryId;?>" class="readmore rm-<?php echo $this->editCategoryId;?>">Read More</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            if (count($this->arrayData) > 0) {
                foreach ($this->arrayData as $objProduct) {
            ?>
                <div class="col-sm-4 col-xs-12">
                    <div class="prdoctls">
                        <a href="<?php echo $this->getUrl($this->product_url.$objProduct->catalog_id);?>"><img src="<?php echo SITE_URL.'show-thumb.php?file='.SITE_UPLOADPATH.$objProduct->image.'&w=270&h=375';?>"></a>
                        <div class="producttitle">
                            <h2><?php echo $this->getAttributeValue($objProduct->catalog_id, 'name');?></h2>
                        </div>
                        <div class="prosuamount">
                            <p><?php echo $this->showProductWithTax($objProduct->catalog_id, true, 0); ?></p>
                        </div>
                        <div class="btnstyle">
                            <div class="quickviewbtn">
                                <button data-toggle="modal" data-target="#myModal1"><a href="<?php echo $this->getUrl($this->product_url.$objProduct->catalog_id);?>">Quick View</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                }
            }
            ?>
            </div>
        </div>
    </div>
</section>
