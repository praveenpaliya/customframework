
<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('menu/saveMenu'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3><?php echo !empty($this->menuData) ? 'Edit' : 'Add '; ?> <?php echo $this->__aT('Menu'); ?></h3>
        </div>
        <div class="pull-right">
            <h3>
                <button type="button" onclick="window.location = '<?php echo mainframe::__adminBuildUrl('menu/manageMenu/id/'.$this->menuTypeId); ?>';" value="new" name="exit" class="btn btn-warning"><i class="icon-angle-left"></i> <?php echo $this->__aT('Back'); ?></button>
            </h3>	
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-xs-12 innerbox">
            <fieldset>
                
                 <div class="form-group">
                    <label><?php echo $this->__aT('Parent Menu category'); ?></label> 
                    <select id="parent_menu" name="md_parent" required class="form-control">
                        <option value="0"><?php echo $this->__aT('Top'); ?></option>
                        <?php
                            echo $this->parentMenuData;
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label><?php echo $this->__aT('Menu tilte'); ?></label>
                    <input type="text" class="form-control" name="md_menu_title" value="<?php echo $this->menuData[0]->menu_title;?>"/>
                </div>
                
                <div class="form-group">
                    <label><?php echo $this->__aT('Menu category'); ?></label> 
                    <select id="menu_type" name="md_menu_type" required class="form-control" onchange="getSubMenuCategory();">
                        <option value=""><?php echo $this->__aT('-- Select --'); ?></option>
                        <option value="pages" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'pages') ? 'selected' : ''; ?> ><?php echo $this->__aT('CMS Pages'); ?></option>
                        <option value="blog" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'blog') ? 'selected' : ''; ?> ><?php echo $this->__aT('Blog Posts'); ?></option>
                        <option value="categories" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'categories') ? 'selected' : ''; ?>><?php echo $this->__aT('Categories'); ?></option>
                        <option value="products" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'products') ? 'selected' : ''; ?>><?php echo $this->__aT('Products'); ?></option>
                        <option value="advertisement" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'advertisement') ? 'selected' : ''; ?>><?php echo $this->__aT('Advertisement'); ?></option>
                        <option value="brands" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'brands') ? 'selected' : ''; ?>><?php echo $this->__aT('Brand'); ?></option>
                        <option value="gallery" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'gallery') ? 'selected' : ''; ?>><?php echo $this->__aT('Gallery'); ?></option>
                        <option value="events" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'events') ? 'selected' : ''; ?>><?php echo $this->__aT('Events'); ?></option>
                        <option value="jobs" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'jobs') ? 'selected' : ''; ?>><?php echo $this->__aT('Jobs'); ?></option>
                        <option value="distributer" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'distributer') ? 'selected' : ''; ?>><?php echo $this->__aT('Distributers'); ?></option>
                        <option value="reseller" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'reseller') ? 'selected' : ''; ?>><?php echo $this->__aT('Resallers'); ?></option>
                        <option value="custom" <?php if(!empty($this->menuData))echo ($this->menuData[0]->menu_type == 'custom') ? 'selected' : ''; ?>><?php echo $this->__aT('Custom'); ?></option>
                    </select>
                </div>
                <div class="form-group" id="sub_menu_div">
                    <label><?php echo $this->__aT('Sub menu'); ?></label> 
                    <select id="sub_menu" name="db_menu_url" class="form-control menuurl_dropdown">
                    </select>
                    <input type="text" name="url_text" value="<?php echo $this->menuData[0]->menu_url;?>"  class="form-control menuurl_text" style="display:none;">
                </div>
                
                
            </fieldset>
            <br><br>
            <div>
                <input type="hidden" name="md_menu_id" value="<?php echo $this->menuTypeId; ?>">
                <input type="hidden" name="editId" value="<?php if(!empty($this->menuData)) echo $this->menuData[0]->menu_item_id ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
        </div>	
    </div>
</form>

<script type="text/javascript">
   
    var menuTypeId = <?php echo $this->menuTypeId ?>;
    var menuCategoryName = '';
    var options = '';
    
    function getSubMenuCategory(){
        
        menuCategoryName = $('#menu_type').val(); 
        if(menuCategoryName =='custom') {
            $('#sub_menu_div').show();
            jQuery(".menuurl_dropdown").hide();
            jQuery(".menuurl_dropdown").attr("name", "url_drpodown");
            jQuery(".menuurl_text").show();
            jQuery(".menuurl_text").attr("name", "db_menu_url");
        }
        else {
            jQuery(".menuurl_dropdown").show();
            jQuery(".menuurl_dropdown").attr("name", "db_menu_url");
            jQuery(".menuurl_text").hide();
            jQuery(".menuurl_text").attr("name", "url_text");
            
            $.ajax({
                url: "<?php echo SITE_URL . 'menu/getSubMenuCategory'; ?>",
                datatype: 'json',
                method: 'post',
                data: {menuCategoryName: menuCategoryName, menuTypeId:menuTypeId},
                success: function (result) {
                    if (result != null) {
                        result = JSON.parse(result);            
                        $('#sub_menu_div').show();
                        options = '<option value=""> -- Select -- </option>';
                       var i=0;
                       var itemSelected ='';
                        $.each(result.title, function(key, val) { 
                            <?php
                            if(!empty($this->menuData)) {
                            ?>
                                if (result.value[i] == '<?php echo $this->menuData[0]->menu_url;?>')
                                    itemSelected = 'selected';
                                else
                                    itemSelected = '';
                           <?php
                           }
                            ?>
                            options   += '<option value="'+result.value[i]+'" '+itemSelected+'>'+val+'</option>';
                            i++;
                        });
                        $('#sub_menu').html(options);
                    } else {
                        $('#sub_menu').html('');
                        $('.sub_menu_div').hide();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                        $('#sub_menu').html('');
                        $('#sub_menu_div').hide();
                        
                        console.log(xhr.status);
                        console.log(thrownError);
                }
            });
        }
    }
    
<?php if(!empty($this->menuData)):?>
    getSubMenuCategory();
<?php endif;?>
    
</script>