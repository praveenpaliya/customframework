<div class="top-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="p-none">
                        <a href="<?php echo SITE_URL;?>">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>

                    <li>
                        <a class="current" href="#"><?php echo $this->__t('Products compare'); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="top-shop-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="row">
                            <h3>Compare List</h3>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                
                                <div class="tab-content" style="display: block;">
                                        <div role="" class="" id="">
                                            <div class="row">
                                                <div class="shop-tab">
                                                  <?php 
                                                    if(!empty($this->arrayData)){
                                                    foreach($this->arrayData as $objProduct) {
                                                      //echo "<pre>"; print_r($objProduct); 
                                                  ?>
                                                    <div class="col-md-3 col-sm-4 col-xs-6">
                                                        <div class="single-product" style="min-height: 150px;">
                                                                <div class="products-top" style="height:150px">
                                                                    <div class="product-img">
                                                                        <a href="<?php echo SITE_URL;?>catalog/<?php echo (!empty($this->pageType))?'productlist':'shopproductlist'?>/id/<?php echo $objProduct[0]->catalog_id;?>">
                                                                            <img class="primary-image" alt="" src="<?php echo SITE_URL.'show-thumb.php?file='.SITE_UPLOADPATH.$objProduct[0]->image.'&w=300&h=400';?>" style="width:60%"> 
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <div class="" style="text-align: left;padding: 10px;">
                                                                    <p>
                                                                        <b><?php echo $objProduct[0]->field_value; ?></b>
                                                                    </p>
                                                                    <p>
                                                                        <span><b><?php echo $this->__t('Article number/ Product code'); ?>:</b></span>
                                                                        <span><?php echo $objProduct[0]->sku; ?></span>
                                                                    </p>

<!--                                                                    <p>
                                                                        <span><b><?php //echo $this->__t('Article number'); ?>:</b></span>
                                                                        <span><?php //echo $objProduct[0]->article_number; ?></span>
                                                                    </p>-->

                                                                    <p>
                                                                        <span><b><?php echo $this->__t('Brand Name'); ?>:</b></span>
                                                                        <span><?php echo $objProduct[0]->brand_name; ?></span>
                                                                    </p>

                                                                    <p>
                                                                        <span><b><?php echo $this->__t('Manufacturer Pdt no'); ?>:</b></span>
                                                                        <span><?php echo $objProduct[0]->manufacturer_pdt_no; ?></span>
                                                                    </p>
                                                                    <p style="text-align: justify">
                                                                        <span><?php echo $this->getAttribute($objProduct[0]->catalog_id, 'short_desc'); ?></span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                    </div>
                                                  <?php
                                                    }
                                                    }else{
                                                    ?>
                                                    <h4 style="text-align: center">Please select products to compare</h4>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>