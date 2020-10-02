<div class="page-header">
    <div class="page-title">
        <h3><?php echo intval($this->galleryId) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Slider'); ?></h3>
    </div>
    <div class="pull-right">
        <h3>
            <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('sliders'); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
            <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
            <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>

        </h3>	
    </div>
</div>

<div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
    <form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('sliders/save'); ?>" class="col-md-12 box-padding">
        <ul class="nav tabs">
            <li>
                <a class="active" href="#1" data-toggle="tab" title="<?php echo $this->__aT('Slider Details'); ?>">
                    <i class="fa fa-info-circle" ></i>
                </a>
            </li>

            <li>
                <a href="#2" data-toggle="tab" title="<?php echo $this->__aT('Slider Images'); ?>">
                    <i class="icon-picture" ></i>
                </a>
            </li>
        </ul>
        <div class="card border-top-0 mb-4">
            <div class="card-body">
                <div class="tab-content" style="padding-top:20px;">
                    <div class="tab-pane active" id="1">
                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Slider Title'); ?></label>
                                <input class="form-control" value="<?php if (!empty($this->arrayData['slider_title'])) echo $this->arrayData['slider_title']; ?>" name="md_slider_title" type="text" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->__aT('Animation'); ?></label>
                                <select name="md_slider_animation"  class="form-control">
                                    <option value="slide" <?php if ($this->arrayData['slider_animation'] == 'slide') echo 'selected'; ?>><?php echo $this->__aT('Slide to Left'); ?></option>
                                    <option value="slide_right" <?php if ($this->arrayData['slider_animation'] == 'slide_left') echo 'selected'; ?>><?php echo $this->__aT('Slide to Right'); ?></option>
                                    <option value="fadein" <?php if ($this->arrayData['slider_animation'] == 'fadein') echo 'selected'; ?>><?php echo $this->__aT('Fade'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->__aT('Show Pagination'); ?></label>
                                <select class="form-control" name="md_show_pagination" onchange="if (this.value == 1)
                                            $('.pagetype').show();
                                        else
                                            $('.pagetype').hide();">
                                    <option value="">--<?php echo $this->__aT('Select'); ?>--</option>
                                    <option value="1" <?php if ($this->arrayData['show_pagination'] == '1') echo 'selected'; ?>><?php echo $this->__aT('Yes'); ?></option>
                                    <option value="0" <?php if ($this->arrayData['show_pagination'] == '0') echo 'selected'; ?>><?php echo $this->__aT('No'); ?></option>
                                </select>
                            </div>
                            <div class="form-group pagetype" style="display: <?php echo ($this->arrayData['show_pagination'] == '1') ? 'block' : 'none';?>">
                                <label><?php echo $this->__aT('Pagination Type'); ?></label>
                                <select  class="form-control" name="md_pagination_type">
                                    <option value="dots" <?php if ($this->arrayData['md_pagination_type'] == 'dots') echo 'selected'; ?>><?php echo $this->__aT('Dots'); ?></option>
                                    <option value="number" <?php if ($this->arrayData['md_pagination_type'] == 'number') echo 'selected'; ?>><?php echo $this->__aT('Number'); ?></option>
                                </select>
                            </div>

                        </fieldset>
                    </div>

                    <div class="tab-pane" id="2">
                        <fieldset class="fieldset_imggroup">
                            <?php
                            foreach ($this->slidesData as $slideObj) {
                            ?>
                            <fieldset id="slide_<?php echo  $slideObj->slide_id;?>">
                                <legend>Slide - <?php if (!empty($slideObj->slide_title)) echo $slideObj->slide_title; ?></legend>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo $this->__aT('Slide Title'); ?></label>
                                            <textarea class="form-control" name="edit_slide_title[<?php echo  $slideObj->slide_id;?>]" required><?php if (!empty($slideObj->slide_title)) echo $slideObj->slide_title; ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->__aT('Slide Text'); ?></label>
                                            <textarea class="form-control" name="edit_slide_text[<?php echo  $slideObj->slide_id;?>]"><?php echo $slideObj->slide_text; ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->__aT('Slider Image'); ?></label>
                                            <input type="file"  name="edit_slide_image[<?php echo  $slideObj->slide_id;?>]"  class="form-control"/>
                                            <img src="<?php echo SITE_URL . SITE_UPLOADPATH . $slideObj->slide_image; ?>" height="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                            <div class="form-group">
                                                <a class="btn btn-danger" href="javascript:void(0);" onclick="if(deletePrompt()) deleteSlide(<?php echo $slideObj->slide_id;?>);">Delete Slide</a>
                                            </div>
                                    </div> 
                                </div>
                             </fieldset>
                                <?php
                            }
                            if (intval($this->slidersId) == 0) {
                                ?>
                            <fieldset>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo $this->__aT('Slide Title'); ?></label>
                                            <input class="form-control" value="" name="slide_title[]" type="text" required>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->__aT('Slide Text'); ?></label>
                                            <textarea class="form-control" name="slide_text[]"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->__aT('Slider Image'); ?></label>
                                            <input type="file" name="slide_image[]" data-style="fileinput">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <?php
                            }
                            ?>
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="javascript: void(0);" onclick="$('fieldset.toclone div.row').clone().appendTo('.fieldset_imggroup');">
                                        <i class="fa fa-plus"></i> New Slide
                                    </a>

                                </div>
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

        <input type="hidden" name="id" value="<?php echo $this->slidersId; ?>">
    </form>
</div>

<fieldset class="hidden toclone" style="display:none">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label><?php echo $this->__aT('Slide Title'); ?></label>
                <input class="form-control" value="" name="slide_title[]" type="text">
            </div>

            <div class="form-group">
                <label><?php echo $this->__aT('Slide Text'); ?></label>
                <textarea class="form-control" name="slide_text[]"></textarea>
            </div>

            <div class="form-group">
                <label><?php echo $this->__aT('Slider Image'); ?></label>
                <input type="file"  name="slide_image[]"  class="form-control"/>
            </div>
        </div>
    </div>
</fieldset>

<script type="text/javascript">
function deletePrompt() {
    return confirm("Are you sure to Delete?\n\nWarning: If record is deleted then can not be recovered.")
}
function deleteSlide(slide_id){
    jQuery.ajax({
        url: "<?php echo SITE_URL . 'sliders/deleteSlide'; ?>",
        method: 'post',
        data: {slide_id: slide_id},
        success: function (result) {
           jQuery("#slide_"+slide_id).remove();
        }
    });
}        
</script>