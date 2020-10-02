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
        <h3><?php echo $this->__aT('All Contacts');?></h3>
    </div>
    <div class="page-stats">	
    	<a href="<?php echo mainframe::__adminBuildUrl('distributer/addNewDistributersContact/id/'.$this->distributerId);?>"><button type="button" class="btn btn-danger btn-xs pull-right">
    	<i class="fa fa-plus"></i> <?php echo $this->__aT('New Contact');?></button></a>
    </div>
</div>

<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Contact Name');?></th>
                    <th><?php echo $this->__aT('Email');?></th>
	            <th><?php echo $this->__aT('Phone');?></th>
                    <th style="text-align: center"><?php echo $this->__aT('Image');?></th>
	            <th style="text-align: center"><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	     <?php  foreach ($this->distributersData as $distributersData): ?>
                <tr>
                    <td><?php echo $distributersData->name ?></td>
                    <td><?php echo $distributersData->email ?></td>
                    <td><?php echo $distributersData->number ?></td>
                    <td style="text-align: center"><img src="<?php echo SITE_URL.SITE_UPLOADPATH.$distributersData->person_image ?>" width="100px" /></td>
                    <td style="text-align: center">
                            <a href="<?php echo mainframe::__adminBuildUrl('distributer/editDistributorContact/id/' . $distributersData->id); ?>" title="Edit">
                                <button type="button" class="btn btn-icon btn-circle btn-info">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                            |
                            <a href="<?php echo mainframe::__adminBuildUrl('distributer/deleteDistributersContact/id/' . $distributersData->id); ?>" title="Delete">
                                <button type="button" class="btn btn-icon btn-circle btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </a>
                        </td>
                </tr>
                <?php endforeach;?>
	    </tbody>
	</table>
</div>