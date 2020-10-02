<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('Stock');?></h3>
    </div>
   
</div>

<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Product Name');?></th>
	            <th><?php echo $this->__aT('Price');?></th>
	            <th><?php echo $this->__aT('Stock');?></th>
                    <th class="noExl"><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	    $intNo=1;
	    foreach($this->arrayData as $objData) {
	    ?>
	        <tr>
	            <td><?php echo $this->getAttributeValue($objData->catalog_id, 'name');?></td>
	            <td><?php echo DEFAULT_CURRENCY.' '.$objData->price;?></td>
	            <td><?php echo $objData->inventory;?></td>
                    <td class="noExl">
	            <a href="<?php echo mainframe::__adminBuildUrl('catalog/editproduct/?id='.$objData->catalog_id);?>" title="Edit Product">
                <button type="button" class="btn btn-icon btn-circle btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </a>
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
            name: "Stock report",
            filename: "stock" + new Date().toISOString().replace(/[\-\:\.]/g, ""),
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    }

</script>