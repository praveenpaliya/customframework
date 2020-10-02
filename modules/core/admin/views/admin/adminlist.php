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
        <h3><?php echo $this->__aT('All Admin users '); ?></h3>
    </div>
    <div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('admin/addNewAdmin'); ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-plus"></i> <?php echo $this->__aT('New Addmin'); ?></button></a>
    </div>
</div>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
        <thead>
            <tr>
                <th><?php echo $this->__aT('Name'); ?></th>
                <th><?php echo $this->__aT('email'); ?></th>
                <th><?php echo $this->__aT('phone'); ?></th>
                <th><?php echo $this->__aT('webmail'); ?></th>
                <th ><?php echo $this->__aT('Role'); ?></th>
                <th ><?php echo $this->__aT('Status'); ?></th>
                <th style="text-align: center"><?php echo $this->__aT('Image'); ?></th>
                <th style="text-align: center"><?php echo $this->__aT('Permissions'); ?></th>
                <th style="text-align: center"><?php echo $this->__aT('Action'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($this->adminData as $adminData): ?>
                <tr>
                    <td><?php echo $adminData->name ?></td>
                    <td ><?php echo $adminData->email ?></td>
                    <td ><?php echo $adminData->phone ?></td>
                    <td ><a href="<?php echo $adminData->webmail_link ?>" target="_blank">Check Email</a></td>
                    <td ><?php echo ($adminData->role == '1')? 'Super Administrator': 'Admin' ?></td>
                    <td ><a href="javascript:void(0)"><?php echo ($adminData->status == '1'? 'Active' : 'Deactive') ?></a></td>
                    <td style="text-align: center"><img src="<?php echo SITE_URL . SITE_UPLOADPATH . $adminData->image ?>" width="50px" /></td>
                    <td style="text-align: center">
                        <a href="<?php echo mainframe::__adminBuildUrl('admin/adminPermision/id/' . $adminData->id); ?>" title="Manage Permission" style="font-size: 30px;">
                            <i class="fa fa-users  text-info"></i>
                        </a>
                    </td>
                    
                    <td style="text-align: center">
                        <span class="action-icon">
                            <a href="<?php echo mainframe::__adminBuildUrl('admin/editAdmin/id/' . $adminData->id); ?>" title="Edit">
                                <button type="button" class="btn btn-icon btn-circle btn-info">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                        </span>
                        |
                        <span class="action-icon">
                            <a onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('admin/deleteAdmin/id/' . $adminData->id); ?>" title="Delete">
                                <button type="button" class="btn btn-icon btn-circle btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </a>
                        </span>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>