<form method="post" class="col-md-12 nopadding" action="<?php echo mainframe::__adminBuildUrl('pages/save'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo intval($this->pageId) ? 'Edit' : 'Add New'; ?> <?php echo $this->__aT('Page'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('pages'); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>

            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">

        <div class="tab-content" style="padding-top:20px;">
            <div class="tab-pane active" id="1">
                <fieldset>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Page Title'); ?></label>
                        <input class="form-control" value="<?php echo $this->postedData['title']; ?>" name="md_title" required type="text">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Page Identifier'); ?></label>
                        <input class="form-control"  value="<?php echo $this->postedData['url']; ?>" name="md_url" required type="text">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Page Content'); ?></label>
                        <textarea class="form-control editor" name="md_content" required placeholder="" rows="10"><?php echo $this->postedData['content']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Meta Title'); ?></label>
                        <input class="form-control" name="db_meta_title" required type="text"  value="<?php echo $this->postedData['meta_title']; ?>">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Meta Keywords'); ?></label>
                        <textarea class="form-control" name="db_meta_keywords" placeholder="" rows="3"><?php echo $this->postedData['meta_keywords']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->__aT('Meta Description'); ?></label>
                        <textarea class="form-control" name="db_meta_description" required placeholder="" rows="3"><?php echo $this->postedData['meta_description']; ?></textarea>
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
            <input type="hidden" name="id" value="<?php echo $this->pageId; ?>">
        </div>
</form>
 <script>
    CKEDITOR.replace( 'md_content', {extraAllowedContent: 'section(*);style(*)'} );
</script>