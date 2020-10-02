<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('Manage menu'); ?></h3>
    </div>
    <div class="pull-right" >
            <a href="<?php echo mainframe::__adminBuildUrl('menu/addMenu').'/id/'.$this->menuTypeId; ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                    <i class="fa fa-plus"></i> <?php echo $this->__aT('New Menu'); ?></button></a>
    </div>
</div>

<div class="panel panel-info">
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
        <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable1 dataTable">
            <thead>
                <tr>
                    <th><?php echo $this->__aT('Menu title'); ?></th>
                    <th><?php echo $this->__aT('Menu category'); ?></th>
                    <th><?php echo $this->__aT('Url'); ?></th>
                    <th class="text-center"><?php echo $this->__aT('Action'); ?></th>
                </tr>
            </thead>

            <tbody class="sortable">
                <?php foreach ($this->menuItemsData as $menuData): ?>
                
                    <tr class="ui-state-default">
                        <td><?php echo $menuData->menu_title ?><input type="hidden" name="menuitems[]" value="<?php echo $menuData->menu_item_id;?>"></td>
                        <td><?php echo $menuData->menu_type ?></td>
                        <td><?php echo $menuData->menu_url ?></td>


                        <td style="text-align: center">


                            <span class="action-icon">
                                <a href="<?php echo mainframe::__adminBuildUrl('menu/editMenu/id/'.$this->menuTypeId.'/item_id/' . $menuData->menu_item_id); ?>" title="Edit">
                                    <button type="button" class="btn btn-icon btn-circle btn-info">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </span>
                            |
                            <span class="action-icon">
                                <a onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('menu/deleteMenu/id/' . $menuData->menu_item_id.'/mTId/'.$this->menuTypeId); ?>" title="Delete">
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
        <input type="submit" value="Save Order">
    </form>
</div>
<script>
  jQuery( function() {
    jQuery( ".sortable" ).sortable();
  } );
</script>