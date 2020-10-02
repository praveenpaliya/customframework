<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('All Menu Type'); ?></h3>
    </div>
    <div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('menu/addNewMenuType'); ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-plus"></i> <?php echo $this->__aT('New Menu Type'); ?></button></a>
    </div>
</div>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
        <thead>
            <tr>
                <th><?php echo $this->__aT('Menu Type'); ?></th>
                <th><?php echo $this->__aT('Menu code'); ?></th>
                <th class="text-center"><?php echo $this->__aT('Action'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($this->menuTypeData as $menuTypeData): ?>
                <tr>
                    <td><?php echo $menuTypeData->menu_title ?></td>
                    <td><?php echo $menuTypeData->menu_code ?></td>
                    
                    <td class="noExl">
                        <a href="" class="text-muted" id="actionDropdown" data-toggle="dropdown"><span class="material-icons md-20 align-middle">more_vert</span></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
                          <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('menu/manageMenu/id/' . $menuTypeData->menu_id); ?>">Manage Menu</a>
                          <a class="dropdown-item" onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('menu/deleteMenuType/id/' . $menuTypeData->menu_id); ?>" title="Delete">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>