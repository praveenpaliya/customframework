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
        <h3><?php echo $this->__aT('All Advertise'); ?></h3>
    </div>
    <div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('catalog/addBrochures'); ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-plus"></i> <?php echo $this->__aT('New Advertise'); ?></button></a>
    </div>
</div>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
        <thead>
            <tr>
                <th><?php echo $this->__aT('Tile'); ?></th>
                <th><?php echo $this->__aT('Type'); ?></th>
                <th><?php echo $this->__aT('File'); ?></th>
                <th><?php echo $this->__aT('Description'); ?></th>
                <th><?php echo $this->__aT('Start date'); ?></th>
                <th><?php echo $this->__aT('End date'); ?></th>
                <th style="text-align: center"><?php echo $this->__aT('Action'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($this->brochuresData as $brochuresData): ?>
                <tr>
                    <td><?php echo $brochuresData->title ?></td>
                    <td><?php echo $brochuresData->type ?></td>
                    <td style="width:200px"><?php echo $brochuresData->filename ?></td>
                    <td style="width:250px; text-align: justify"><?php echo html_entity_decode($brochuresData->description) ?></td>
                    <td><?php echo $brochuresData->start_date ?></td>
                    <td><?php echo $brochuresData->end_date ?></td>
                    <td>
                        <span class="action-icon">
                            <a href="<?php echo mainframe::__adminBuildUrl('catalog/editBrochures/id/' . $brochuresData->id); ?>" title="Edit">
                                <button type="button" class="btn btn-icon btn-circle btn-info">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                        </span>
                        |
                        <span class="action-icon">
                            <a href="<?php echo mainframe::__adminBuildUrl('catalog/deleteBrochure/id/' . $brochuresData->id); ?>" title="Delete">
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