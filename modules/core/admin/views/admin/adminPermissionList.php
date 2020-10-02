<style type="text/css">
    .action-icon{
        padding: 0px 10px;
    } 
    .glyphicon-pencil:hover{
        color: dodgerblue;
    } 
    .glyphicon-trash:hover{
        color: red;
    } 
</style>

<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT($this->adminData->name); ?></h3>
    </div>
    <div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('admin/adminList'); ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                <i class=""></i> <?php echo $this->__aT('Back'); ?></button></a>
    </div>
</div>
<div class="panel panel-info">
<form method="post" enctype="multipart/form-data" class="" action="<?php echo mainframe::__adminBuildUrl('admin/savePermission'); ?>">    
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive  dataTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="all_module" name="all_module"><?php echo $this->__aT('All'); ?></th>
                <th><?php echo $this->__aT('Module'); ?></th>
                <th><?php echo $this->__aT('Use'); ?></th>
            </tr>
        </thead>

        <tbody>
        
           <?php 
                $permissionArray = json_decode(json_encode($this->permissionData), true);
                foreach($permissionArray as $permission){
                   $permissions[] = $permission['module_name'];
                }
                foreach($this->moduleData as $module):
                    $checked = '';
                    if(in_array($module->module_name, $permissions)){
                        $checked = 'checked';
                    }
             ?>
            <tr>
                <td>
                    <div class="form-group">
                        <input type="checkbox" <?php echo $checked;?> class="module_check" name="modules[]" value="<?php echo $module->module_name?>">   
                    </div>
                </td>
                <td><?php echo $module->title ?></td>
                <td><?php echo $module->description ?></td>
            </tr>
           <?php endforeach;?>
        
        </tbody>
    </table>
    
    <div style="text-align:center">
                <input type="hidden" name="adminId" value="<?php echo $this->adminData->id; ?>">
                <button type="submit" value="exit" name="saveexit" class="btn btn-danger"><?php echo $this->__aT('Save & Exit'); ?> <i class="icon-angle-right"></i></button>
                <button type="submit" value="new" name="savenew" class="btn btn-success"><?php echo $this->__aT('Save & Add New'); ?> <i class="icon-angle-right"></i></button>
            </div>
    
</form
<div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('admin/adminList'); ?>"><button type="button" class="btn btn-danger btn-xs pull-left">
                <i class=""></i> <?php echo $this->__aT('Back'); ?></button></a>
    </div>
</div>


<script>
$("#all_module").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.module_check').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});
</script>