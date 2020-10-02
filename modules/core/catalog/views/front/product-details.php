
<style>
.detailsoption select {
    width: 250px;
    margin: 0px;
}
</style>
<section class="single-product-area sit">
    <div class="container nopadding">
        <div class="row">
            <div class="col-md-6 productimagesleder">
                <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                     <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $this->arrayData->image; ?>" alt="..." class="img-responsive">
                        </div>
                    <?php
                    $gallery_images = rtrim($this->arrayData->gallery_images, ',');
                    if (!empty($gallery_images)):
                        $image = explode(',', $gallery_images);
                        foreach ($image as $imageName):
                    ?>
                        <div class="item"> 
                            <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $imageName ?>" class="img-responsive">
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    </div>
                     <!-- Controls -->
                     <a class="left carousel-control" href="#carousel-custom" role="button" data-slide="prev">
                        <i class="fa fa-chevron-left"></i>
                        <span class="sr-only">Previous</span>
                     </a>
                     <a class="right carousel-control" href="#carousel-custom" role="button" data-slide="next">
                        <i class="fa fa-chevron-right"></i>
                        <span class="sr-only">Next</span>
                     </a>
                     <!-- Indicators -->

                    <ol class="carousel-indicators visible-sm-block hidden-xs-block visible-md-block visible-lg-block">
                        <li data-target="#carousel-custom" data-slide-to="0" class="active">
                            <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $this->arrayData->image; ?>" alt="..." class="img-responsive">
                        </li>
                    <?php
                    $gallery_images = rtrim($this->arrayData->gallery_images, ',');
                    if (!empty($gallery_images)):
                        $image = explode(',', $gallery_images);
                        $imgCount = 0;
                        foreach ($image as $imageName):
                            $imgCount++;
                    ?>
                        <li data-target="#carousel-custom" data-slide-to="<?php echo $imgCount;?>">
                            <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $imageName ?>" class="img-responsive">
                        </li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    </ol>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <form method="post" action="<?php echo SITE_URL . 'catalog/addtocart'; ?>" id="frmcart">
                <div class="row">
                    <div class="col-xs-12 pull-left">
                        <h1><?php echo $this->getAttribute($this->arrayData->catalog_id, 'name'); ?></h1>

                        <div class="brand">
                            <ul>
                            <!--                                
                                <li>
                                    <span>Availability  </span>
                                    <span>
                                        <?php
                                        if ($this->arrayData->manage_inventory == 0) {
                                            echo 'In Stock';
                                        } else {
                                            if ($this->arrayData->inventory == 0) {
                                                echo $this->__t('Out of Stock');
                                            } else {
                                                echo $this->__t('In Stock');
                                            }
                                        }
                                        ?>
                                    </span>
                                </li>-->
                                 
                            </ul>
                        </div>

                        <div class="clearfix"></div>

                        <div class="short-description" style="text-align: justify">
                        <?php echo $this->getAttribute($this->arrayData->catalog_id, 'short_desc'); ?>
                        </div>
                        <?php if (empty($this->subsciptionProductData)) { ?>
                            <?php if (empty($this->pageType)): ?>
                            <div class="pricedetails">
                                <h3 title="Price excluding VAT"><?php echo $this->showProductWithTax($this->arrayData->catalog_id, true, 0); ?></h3>
                            </div>
                            <?php endif; ?> 
                        <?php }?>

                        <?php if (!empty($this->arrayData->upload_filename)): ?>
                        <div style="margin-top:20px">
                            <a class="btn btn-primary" href="<?php echo mainframe::__BuildUrl('catalog/downloadProductFile/id/' . $this->arrayData->catalog_id); ?>" title="<?php echo $this->arrayData->upload_file_title ?>">
                                <i class="fa fa-download"></i> &nbsp;&nbsp; <?php echo (strlen($this->arrayData->upload_file_title) > 20)? substr($this->arrayData->upload_file_title, 0,20).'..':$this->arrayData->upload_file_title; ?></a>
                        </div>
                        <?php endif; ?>

                        <?php if (empty($this->pageType)): ?>
                            <?php foreach ($this->customOptions as $customOptions): ?>        
                                <div class="detailsoption">
                                    <span><?php echo $customOptions->option_title; ?>  </span>
                                    <p>
                                        <span>
                                            <?php echo $customOptions->option_values; ?>
                                        </span>
                                    </p>
                                </div>
                            <?php endforeach; ?> 

                            <?php
                            if (!isset($_SESSION['uid']) || $_SESSION['customer_group'] <> 4) {
                            ?>
                                <div class="show_to_customer detailsoption">
                                    <h4><?php echo $this->__t('Custom Letter Service (Optional)');?></h4>
                                    <table width="100%" cellpadding="3">
                                        <tr>
                                            <td colspan="4" style="padding-bottom:10px;">
                                                <input type="hidden" name="custom_option[letter_type][title]" value="Letter Type">
                                                <select name="custom_option[letter_type][value]" id="letter_type" onchange="updateLetterType();">
                                                    <option value="">--Select Letter Type--</option>
                                                    <option value="12.95|Handwritten Letter">Handwritten Letter (+$12.95)</option>
                                                    <option value="4.95|Printed Letter">Printed Letter (+$4.95)</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr style="display: none;" id="letter_font_row">
                                            <td colspan="4" class="font_radio_button"  style="padding-bottom:10px;">
                                                <input type="hidden" name="custom_option[letter_font][title]" value="Font">
                                                <input type="radio" id="font_times" value="0|Times New Roman  Size 12" name="custom_option[letter_font][value]" onclick="setCharacterLimit('1760');">
                                                <label for="font_times" class="roman">Times New Roman</label>

                                                <input type="radio" id="font_script" value="0|Script MT Bold Size 12" name="custom_option[letter_font][value]" onclick="setCharacterLimit('1760');">
                                                <label for="font_script" class="script_mt">Script MT</label>

                                                <input type="radio" id="font_book" value="0|Book Antiqua (ITALIC) Size 12" name="custom_option[letter_font][value]" onclick="setCharacterLimit('1760');">
                                                <label for="font_book" class="book_antiqua">Book (Italic)</label>

                                                <input type="radio" id="font_papyrus" value="0|Papyrus (ITALIC) Size 11" name="custom_option[letter_font][value]" onclick="setCharacterLimit('1800');">
                                                <label for="font_papyrus" class="papyrus">Papyrus (Italic)</label>
                                            </td>
                                        </tr>

                                        <tr style="display: none;" class="letter_msg_box">
                                            <td colspan="4">
                                                <input type="hidden" name="custom_option[customer_comments][title]" value="Message">
                                                <textarea placeholder="<?php echo $this->__t('Message');?>" id="customer_comments" name="custom_option[customer_comments][value]" style="width:100%; height: 100px; padding:5px;"></textarea>
                                                Character Count <span class="cc_count"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                        <?php 
                            }
                            endif;
                        ?>    

                        <?php if (empty($this->pageType)): ?>
                            <div class="add-to-box1">
                                <?php if (empty($this->subsciptionProductData)) { ?>
                                <div class="add-to-box add-to-box2">
                                    
                                        <input type="hidden" name="catalog_id" value="<?php echo $this->arrayData->catalog_id; ?>">
                                        <input type="hidden" name="qty" value="1">
                                    
                                        <div class="add-to-cart" style="margin-top:20px;">
                                            <div class="quantity_box">
                                                <label for="qty"><?php echo $this->__t('Quantity'); ?>:</label>
                                               
                                                <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                                <input type="number" name="qty" id="number" value="1">
                                                <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>

                                            </div>
                                        
                                            <div class="product-icon">
                                            <?php if (empty($this->pageType)): ?>
                                                <div class="shopnowbtndes">
                                                    <button type="submit" class="addtocart_btn">Add To Cart</button>
                                                
                                                    <a href="<?php echo SITE_URL; ?>catalog/addwishlist/id/<?php echo $this->arrayData->catalog_id; ?>" class="wishlist" title="" data-original-title="Add to wish List">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>

                                            </div>
                                        </div>
                                </div>
                              <?php }?>  

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 pull-left productdetails">
                        <div class="addthis_inline_share_toolbox_setn"></div>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ppaliya"></script>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>
</section>

<div class="container">
    <div class="addisionalinfr">
        <div class="tab">
            <button class="tablinks" onclick="tabinfo(event, 'description')" id="defaultOpen">
                <?php echo $this->__t('Description '); ?>
            </button>
            <button class="tablinks" onclick="tabinfo(event, 'additionalinformation')">
                <?php echo $this->__t('Reviews '); ?>
            </button>
        </div>
        <div id="description" class="tabcontent">
            <?php echo $this->getAttribute($this->arrayData->catalog_id, 'description'); ?>
        </div>
        <div id="additionalinformation" class="tabcontent">
            <form class="form-horizontal" action="<?php echo mainframe::__adminBuildUrl('catalog/productReview') ?>" method="POST">
                <div id="review">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <?php foreach ($this->productReview as $productReview): ?>
                                <tr>
                                    <td style="width: 50%;">
                                        <strong><?php echo $productReview->customer_name ?></strong>
                                    </td>
                                    <td class="text-right"><?php echo date('Y-m-d', strtotime($productReview->added_at)) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p class="text an-text"><?php echo $productReview->review ?></p>
                                        <span class="fa fa-stack">
                                            <?php $class = ($productReview->rating > 0) ? 'fa fa-star fa-stack-2x' : 'fa fa-star-o fa-stack-2x'; ?>
                                            <i class="<?php echo $class ?>"></i>
                                        </span>
                                        <span class="fa fa-stack">
                                            <?php $class = ($productReview->rating > 1) ? 'fa fa-star fa-stack-2x' : 'fa fa-star-o fa-stack-2x'; ?>
                                            <i class="<?php echo $class ?>"></i>
                                        </span>
                                        <span class="fa fa-stack">
                                            <?php $class = ($productReview->rating > 2) ? 'fa fa-star fa-stack-2x' : 'fa fa-star-o fa-stack-2x'; ?>
                                            <i class="<?php echo $class ?>"></i>
                                        </span>
                                        <span class="fa fa-stack">
                                            <?php $class = ($productReview->rating > 3) ? 'fa fa-star fa-stack-2x' : 'fa fa-star-o fa-stack-2x'; ?>
                                            <i class="<?php echo $class ?>"></i>
                                        </span>
                                        <span class="fa fa-stack">
                                            <?php $class = ($productReview->rating > 4) ? 'fa fa-star fa-stack-2x' : 'fa fa-star-o fa-stack-2x'; ?>
                                            <i class="<?php echo $class ?>"></i>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>    
                        </tbody>
                    </table>
                    <div class="text-right"></div>
                </div>
                <h2 class="write"><?php echo $this->__t('Write a review'); ?></h2>

                <?php
                if (empty($_SESSION['uid'])):
                    ?>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <label class="" for="input-name"><font style="color: #ff0000">* </font><?php echo $this->__t('Your Name'); ?></label>
                            <input id="input-name" class="form-control" type="text" value="" name="db_customer_name" <?php echo (empty($_SESSION['uid'])) ? 'required' : '' ?>>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <label class="" for="input-email"><font style="color: #ff0000">* </font><?php echo $this->__t('Your Email'); ?></label>
                            <input id="input-name" class="form-control" type="text" value="" name="db_customer_email" <?php echo (empty($_SESSION['uid'])) ? 'required' : '' ?>>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group ">
                    <div class="col-sm-12">
                        <label class="" for="input-title"><?php echo $this->__t('Review title'); ?></label>
                        <input id="input-name" class="form-control" type="text" value="" name="db_title">
                    </div>
                </div>
                <div class="form-group required">
                    <div class="col-sm-12">
                        <label class="" for="input-review"><font style="color: #ff0000">* </font><?php echo $this->__t('Your Review'); ?></label>
                        <textarea id="input-review" class="form-control" rows="5" name="db_review"></textarea>
                        <div class="help-block">
                            <span class="text-danger"><?php echo $this->__t('Note'); ?>:</span>
                            HTML is not translated!
                        </div>
                    </div>
                </div>
                <div class="form-group required">
                    <div class="col-sm-12">
                        <label class=""><font style="color: #ff0000">* </font><?php echo $this->__t('Rating'); ?></label>
                        <span class="fa fa-stack">
                        <input type="radio" value="1" name="md_rating" class1="fa fa-star-o fa-stack-2x">
                        </span>
                        <span class="fa fa-stack">
                        <input type="radio" value="2" name="md_rating" class1="fa fa-star-o fa-stack-2x">
                        </span>
                        <span class="fa fa-stack">
                        <input type="radio" value="3" name="md_rating" class1="fa fa-star-o fa-stack-2x">
                        </span>
                        <span class="fa fa-stack">
                        <input type="radio" value="4" name="md_rating" class1="fa fa-star-o fa-stack-2x">
                        </span>
                        <span class="fa fa-stack">
                        <input type="radio" value="5" name="md_rating" class1="fa fa-star-o fa-stack-2x">
                        </span>
                        

                    </div>
                </div>
                
                <div class="form-group">
                    <input  hidden="hidden" type="text" value="<?php echo $this->arrayData->catalog_id ?>" name="md_product_id">
                </div>
                <div class="buttons form-group">
                    <div class="pull-right">
                        <button id="button-review" class="button2 get" data-loading-text="Loading..." type="submit">Continue</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function tabinfo(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

function updateLetterType() {
    var letter_price = 0 ;

    if ($('#letter_type option:selected').index()==2) { 
        $('#letter_font_row').show();
        $(".letter_msg_box").show();
        $("#font_times").click();
        $(".letter_msg_box textarea#customer_comments").attr("required", "true");
        letter_price = 4.95;
    }
    else { 

        if ($('#letter_type option:selected').index()==1) { 
            $(".letter_msg_box").show();
            jQuery(".cc_count").text(1450);
            jQuery("#customer_comments").attr('maxlength', 1450);
            $(".letter_msg_box textarea#customer_comments").attr("required", "true");
            letter_price = 12.95;
        }
        else {
            $(".letter_msg_box").hide();
            $(".letter_msg_box textarea#customer_comments").removeAttr("required");
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

function setCharacterLimit(cclimit) {
    jQuery(".cc_count").text(cclimit);
    jQuery("#customer_comments").attr('maxlength', cclimit);
}
document.getElementById("defaultOpen").click();

jQuery(document).ready(function() {

    jQuery('#customer_comments').on("input", function(){
        var maxlength = jQuery(this).attr("maxlength");
        var currentLength = jQuery(this).val().length;
        jQuery(".cc_count").text(maxlength-currentLength);
    });
});
</script>
