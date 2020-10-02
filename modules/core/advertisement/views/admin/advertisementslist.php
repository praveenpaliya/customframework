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
        <h3><?php echo $this->__aT('All Advertises'); ?></h3>
    </div>
    <div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('advertisement/addAdvertisements'); ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-plus"></i> <?php echo $this->__aT('New Advertise'); ?></button></a>
    </div>
</div>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
        <thead>
            <tr>
                <th><?php echo $this->__aT('Tile'); ?></th>
                <th><?php echo $this->__aT('Type'); ?></th>
                <th><?php echo $this->__aT('Start date'); ?></th>
                <th><?php echo $this->__aT('End date'); ?></th>
                <th style="text-align: center"><?php echo $this->__aT('Action'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($this->advertisementsData as $advertisementsData): ?>
                <tr>
                    <td><?php echo $advertisementsData->title ?></td>
                    <td><?php echo $advertisementsData->type ?></td>
                    <td><?php echo $advertisementsData->start_date ?></td>
                    <td><?php echo $advertisementsData->end_date ?></td>
                    <td>
                        <span class="action-icon">
                            <a href="<?php echo mainframe::__adminBuildUrl('advertisement/editAdvertisements/id/' . $advertisementsData->id); ?>"  title="Edit">
                                <button type="button" class="btn btn-icon btn-circle btn-info">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                        </span>
                        |
                        <span class="action-icon">
                            <a onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('advertisement/deleteAdvertisement/id/' . $advertisementsData->id); ?>" title="Delete" onclick="return confirm('Are you sure to delete?')">
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