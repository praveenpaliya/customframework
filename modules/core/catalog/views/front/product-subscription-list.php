<div class="top-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="p-none">
                        <a href="<?php echo SITE_URL; ?>">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>

                    <li>
                        <a class="current" href="#"><?php echo $this->__t('Subscription Products'); ?></a>
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
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="features-tab fe-again">
                            <!-- Nav tabs -->
                            <div class="shop-all-tab top-shop-n">
                                <div class="two-part an-tw">
                                    <ul class="nav tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-th-large"></i> <?php echo $this->__t('Grid'); ?></a></li>
                                        <li role="presentation" class=""><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-align-justify"></i> <?php echo $this->__t('List'); ?></a></li>
                                    </ul>
                                    <div class="shop5">
                                        <label><?php echo $this->__t('Show'); ?></label>
                                        <select>
                                            <option value="">12</option>
                                            <option value="">24</option>
                                            <option value="">36</option>
                                        </select>
                                        <?php echo $this->__t('Per Page'); ?>        
                                    </div>
                                </div>
                                <div class="sort-by an-short">
                                    <div class="shop6">
                                        <label><?php echo $this->__t('Sort By'); ?></label>
                                        <select>
                                            <option value="">Name</option>
                                            <option value="">Price</option>
                                        </select>
                                        <a href="#"><i class="fa fa-long-arrow-up"></i></a> 
                                    </div>
                                </div>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <div class="row">
                                        <div class="shop-tab">
                                            <?php
                                            foreach ($this->arrayData as $objProduct) {
                                                ?>
                                                <div class="col-md-3 col-sm-4 col-xs-12">
                                                    <div class="slider-one">
                                                        <div class="single-product">
                                                            <form method="post" id="frm-cart-<?php echo $objProduct->catalog_id; ?>" action="<?php echo SITE_URL . 'catalog/addtocart'; ?>">
                                                                <input type="hidden" name="qty" value="1">
                                                                <input type="hidden" name="catalog_id" value="<?php echo $objProduct->catalog_id; ?>">
                                                                <div class="products-top">
                                                                    <?php
                                                                        $productUrl =SITE_URL.'catalog/viewdetails/id/'.$objProduct->catalog_id.'/ptyp/'.$objProduct->product_type;
                                                                        if(empty($_SESSION["uid"])){
                                                                            $productUrl = SITE_URL.'customer/login';
                                                                        }
                                                                    ?>

                                                                    <div class="product-img">
                                                                        <a href="<?php echo  $productUrl?>">
                                                                            <img class="primary-image" alt="" src="<?php echo SITE_URL . SITE_UPLOADPATH . $objProduct->image; ?>">
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                                <div class="content-box again">
                                                                    <h2 class="name">
                                                                        <a href="<?php $productUrl ?>"><?php echo $this->getAttribute($objProduct->catalog_id, 'name'); ?></a>
                                                                    </h2>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <div class="row sho">

                                        <?php
                                        foreach ($this->arrayData as $objProduct) {
                                            ?>
                                            <div class="li-item">
                                                <form method="post" id="frm-cart-<?php echo $objProduct->catalog_id; ?>" action="<?php echo SITE_URL . 'catalog/addtocart'; ?>">
                                                    <input type="hidden" name="qty" value="1">
                                                    <input type="hidden" name="catalog_id" value="<?php echo $objProduct->catalog_id; ?>">
                                                    <div class="col-md-4 col-sm-4 col-xs-12 col-shop">
                                                        <div class="single-product shop6">
                                                            <div class="products-top shop7">
                                                                <div class="product-img">
                                                                    <a href="#">
                                                                        <img class="primary-image" alt="" src="<?php echo SITE_URL . SITE_UPLOADPATH . $objProduct->image; ?>">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 col-shop">
                                                        <div class="f-fix">
                                                            <div class="content-box pro2">
                                                                <h2 class="product-name feil">
                                                                    <a href="<?php echo SITE_URL; ?>catalog/viewdetails/id/<?php echo $objProduct->catalog_id; ?>"><?php echo $this->getAttribute($objProduct->catalog_id, 'name'); ?></a>
                                                                </h2>
                                                            </div>
                                                            <p class="desc">
                                                                <?php echo $this->getAttribute($objProduct->catalog_id, 'short_desc'); ?>
                                                            </p>
                                                            <div class="p-box">
                                                                <span class="special-price">
                                                                    <?php echo $this->showPrice($objProduct->catalog_id); ?>
                                                                </span>
                                                            </div>
                                                            <div class="product-icon">
                                                                <a href="#">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                                <a href="#">
                                                                    <i class="fa fa-heart"></i>
                                                                </a>
                                                                <a href="#">
                                                                    <i class="fa fa-retweet"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </form>
                                            </div>        
                                            <?php
                                        }
                                        ?>
                                    </div>
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