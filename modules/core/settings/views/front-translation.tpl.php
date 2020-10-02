    <div class="page-header">
        <div class="page-title">
            <h3><?php echo $this->__aT('Theme Language Translation'); ?></h3>
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-10 box-padding">
                        <div class="form-group">
                            <label><?php echo $this->__aT("Select Language to Update Translation");?></label>
                            <select name="lang_id" onchange="window.location='<?php echo mainframe::__adminBuildUrl('settings/frontThemeTranslation/lang_id/'); ?>'+this.value">
                            <option value="">--Select--</option>
                            <?php
                            $actLang =  $this->showActiveLanguages();
                            foreach($actLang as $lang) {
                                if($lang->lang_id <> 1) {
                            ?>
                                <option value="<?php echo $lang->lang_id;?>" <?php if($_REQUEST['lang_id']==$lang->lang_id) echo 'selected';?>><?php echo $lang->language;?></option>
                            <?php
                                }
                            }
                            ?>
                            </select>
                        </div>

                        <table width="100%" class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
                         <thead>
                        <tr>
                        <th>Text</th>
                        <th>Translation</th>
                        <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($this->labelTranslations as $objTrans) {
                            ?>
                            <tr>
                                <td><?php echo $objTrans->label; ?></td>
                                <td><?php echo $objTrans->translation; ?></td>
                                <td><a href="<?php echo mainframe::__adminBuildUrl('settings/editThemeTranslation/translate_id/'.$objTrans->id); ?>" title="Edit Translation Text">
                                    <button type="button" class="btn btn-icon btn-circle btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>   
                        </tbody> 
                        </table>

            </div>
        </div>
    </div>
</form>