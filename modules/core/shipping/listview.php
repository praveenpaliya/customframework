<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('Shipping Methods');?></h3>
    </div>
</div>


<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Name');?></th>
	            <th><?php echo $this->__aT('Status');?></th>
                    <th class="noExl"><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	    $intNo=1;
	    foreach($this->arrayData as $objData) {
	    ?>
	        <tr>
	            <td><?php echo $objData->method_title;?></td>
	            <td><?php echo ($objData->enabled==1)?'Enabled':'Disabled';?></td>
                <td class="noExl">
                    <a href="" class="text-muted" id="actionDropdown" data-toggle="dropdown"><span class="material-icons md-20 align-middle">more_vert</span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
                      <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('shipping/edit/id/'.$objData->shipping_id);?>">Edit</a>
                      <a class="dropdown-item" onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('shipping/delete/id/'.$objData->shipping_id);?>" title="Delete">Delete</a>
                    </div>
                </td>
	        </tr>
	    <?php
		}
	    ?>
	    </tbody>
	</table>
<div class="col-sm-12 row panel">
    <a href="javascript:void(0);" class="btn btn-primary" name="export" onclick="tableToExcel()">
        <i style="font-size: 16px"class="fa fa-file-excel-o"></i> <?php echo $this->__aT('Export'); ?>
    </a>
</div>
</div>

<script>
    function tableToExcel() {
        $(".table").table2excel({
            exclude: ".noExl",
            name: "Warehouses report",
            filename: "warehouses" + new Date().toISOString().replace(/[\-\:\.]/g, ""),
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    }

</script>