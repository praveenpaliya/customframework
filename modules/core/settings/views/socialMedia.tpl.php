<form method="post" enctype="multipart/form-data" action="<?php echo mainframe::__adminBuildUrl('settings/saveSocialMedia'); ?>">
    <div class="page-header">
        <div class="page-title">
            <h3>Manage social media</h3>
        </div>
        <div class="pull-right">
        </div>
    </div>

    <div class="panel panel-info col-xs-12 col-sm-12 col-md-12 nopadding">
        <div class="col-md-12 box-padding">

            <div class="tab-content" style="padding-top:20px;">
                <div class="tab-pane active" id="1">
                    <fieldset> 
                        <table style="width: 100%" id="socialList">
                            
                            <tbody>
                                <?php foreach ($this->socialMediaData as $socialMediaData):?>
                                    <tr>  
                                        <td style="padding-right: 10px; width: 25%">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" value="<?php echo $socialMediaData->title?>" name="" type="text" disabled="">
                                            </div>
                                        </td>
                                        <td style="padding-right: 10px; width: 45%">
                                            <div class="form-group">
                                                <label>Url</label>
                                                <input class="form-control" value="<?php echo $socialMediaData->url?>" name="" type="text" disabled="">
                                            </div>
                                        </td>
                                        <td style="width: 25%">
                                            <div class="form-group">
                                                <label>Icon</label><br/>
                                                <img src="<?php echo SITE_URL.SITE_UPLOADPATH.'socialicon/'.$socialMediaData->image ?>"/>
                                            </div>    
                                        </td>
                                        <td  style="width: 10%">
                                            <a href="<?php echo mainframe::__adminBuildUrl('settings/deleteSocialMedia/id/'.$socialMediaData->id); ?>" onclick="return confirm('Do you really want to delete this ?');" title='Delete'> 
                                                    <i class="fa fa-trash" style="font-size: 20px; color: #ff6666"></i>
                                                </a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <a href="javascript:void(0);" onclick="addMore();" class="btn btn-primary">&plus; Add Social media</a>
                    </fieldset>
                </div>	
                <div class="form-actions fluid zero-botom-margin">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" value="exit" name="saveexit" class="btn btn-danger">Save & Exit <i class="icon-angle-right"></i></button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</form>

<script>

    function removeRow(ev){
        $(ev).parent().parent().remove();
    }

    function addMore() {
        var row = ''
                    +'<tr>'  
                        +'<td style="padding-right: 10px; width: 25%">'
                            +'<div class="form-group">'
                                +'<label>Title</label>'
                                +'<input class="form-control" value="" name="title[]" type="text" required>'
                            +'</div>'
                        +'</td>'
                        +'<td style="padding-right: 10px; width: 45%">'
                            +'<div class="form-group">'
                                +'<label>Url</label>'
                                +'<input class="form-control" value="" name="url[]" type="text" required placeholder="http://" required>'
                            +'</div>'
                        +'</td>'
                        +'<td style="width: 25%">'
                            +'<div class="form-group">'
                                +'<label>Icon</label>'
                                +'<ul style="list-style: none; padding-left: 0px;" >'
                                    +'<li><input type="file" data-style="fileinput" name="fileToUpload[]" multiple="multiple" accept="image/*" required></li>'
                                +'</ul>'
                           +'</div>'
                        +'</td>'
                        +'<td style="">'
                               +'<a href="javascript:void(0)" style="font-size:20px;" onclick="removeRow(this);"><i class="fa fa-trash"></i></a>'
                        +'</td>'
                    +'</tr>'
                  
        $('#socialList tbody').append(row);
    }

</script>
