<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('All Sliders');?></h3>
    </div>
    <div class="page-stats">    
        <a href="<?php echo mainframe::__adminBuildUrl('sliders/addnew');?>"><button type="button" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus"></i>  <?php echo $this->__aT('New Slider');?></button></a>
    </div>
</div>

<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Slider Title');?></th>
	            <th><?php echo $this->__aT('Slider Code');?></th>
	            <th><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	    $intNo=1;
	    foreach($this->arrayData as $objData) {
	    ?>
	        <tr>
	            <td><?php echo $objData->slider_title;?></td>
	           
	            <td>[sliders id=<?php echo $objData->slider_id;?>]</td>
	            <td><a href="<?php echo mainframe::__adminBuildUrl('sliders/edit/id/'.$objData->slider_id);?>"><button type="button" class="btn btn-icon btn-circle btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></button></a> | 
<a onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('sliders/delete/id/'.$objData->slider_id);?>"><button type="button" class="btn btn-icon btn-circle btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                    </td>
	        </tr>
	    <?php
		}
	    ?>
	    </tbody>
	</table>
</div>