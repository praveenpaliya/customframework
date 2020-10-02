<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo $this->__aT('Coupons');?></h1>
  </div> 
</div>

<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

    <form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('coupons/save'); ?>" class="col-md-12 box-padding">
        <ul class="nav tabs">
            <li>
                <a class="active"  href="#1" data-toggle="tab" title="<?php echo $this->__aT('Basic Details'); ?>">
                    <i class="fa fa-info-circle" ></i>
                </a>
            </li>

            <li>
                <a href="#2" data-toggle="tab" title="<?php echo $this->__aT('Discount'); ?>">
                    <i class="fa fa-money" ></i>
                </a>
            </li>
        </ul>
        <div class="card border-top-0 mb-4">
            <div class="card-body">
                <div class="tab-content" style="padding-top:20px;">
                    <div class="tab-pane active" id="1">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Coupon Title'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['title'])) echo $this->arrayData['title']; ?>" name="md_title" type="text" required>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Coupon Code'); ?></label>
                                <input class="form-control" name="md_coupon_code" required value="<?php if (!empty($this->arrayData['coupon_code'])) echo $this->arrayData['coupon_code']; ?>">
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Description'); ?></label>
                                <textarea name="md_description" required class="form-control editor" rows="6" cols="55"><?php echo $this->arrayData['description'] ?></textarea>
                            </div>

                        </fieldset>
                    </div>

                    <div class="tab-pane" id="2">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Discount Type'); ?></label>
                                <select name="md_disc_type">
                                    <option value="fixed" <?php if ($this->arrayData['disc_type'] == 'fixed') echo 'selected'; ?>>Fixed</option>
                                    <option value="percentage" <?php if ($this->arrayData['disc_type'] == 'percentage') echo 'selected'; ?>>Percentage</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Discount'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['discount'])) echo $this->arrayData['discount']; ?>" name="md_discount" type="text" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Min Cart Subtotal to apply discount'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['min_subtotal'])) echo $this->arrayData['min_subtotal']; ?>" name="md_min_subtotal" type="text" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Max Cart Subtotal to apply discount'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['max_subtotal'])) echo $this->arrayData['max_subtotal']; ?>" name="md_max_subtotal" type="text" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Coupon Code Validity Start Date'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['start_date'])) echo $this->arrayData['start_date']; ?>" name="db_start_date" type="date" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Coupon Code Validity End Date'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['expiry_date'])) echo $this->arrayData['expiry_date']; ?>" name="db_expiry_date" type="date" required>
                            </div>

                        </fieldset>
                    </div>

                    <div class="form-actions fluid zero-botom-margin">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                                    <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>	
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="<?php echo $this->couponId; ?>">
    </form>
</div>
