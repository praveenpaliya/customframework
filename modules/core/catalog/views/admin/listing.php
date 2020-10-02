<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title">Products List </h1>
  </div> 
  <div class="col controls-wrapper mt-3 mt-md-0 d-none d-md-block ">
    <div class="controls d-flex justify-content-center justify-content-md-end">
        <a href="<?php echo mainframe::__adminBuildUrl('catalog/addproduct');?>">
        <button type="button" class="btn btn-secondary py-1 px-2">
            <i class="fa fa-plus"></i> <?php echo $this->__aT('New Product');?>
        </button>
        </a>
    </div>
  </div>
</div>

<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Product ID');?></th>
	            <th><?php echo $this->__aT('Product Name');?></th>
	            <th><?php echo $this->__aT('Category');?></th>
	            <th><?php echo $this->__aT('Price');?></th>
	            <th class="noExl"><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	    $intNo=1;
            
	    foreach($this->arrayData as $objData) {  
	    ?>
	        <tr>
	            <td><?php echo $objData->catalog_id;?></td>
	            <td><?php echo $this->getAttributeValue($objData->catalog_id, 'name');?></td>
	            <td><?php echo $this->getCategoryAttributeValueModel($objData->category_id, 'cat_name');?></td>
	            <td><?php echo DEFAULT_CURRENCY.' '.$objData->price;?></td>
              
              <td class="noExl">
              	<a href="" class="text-muted" id="actionDropdown" data-toggle="dropdown"><span class="material-icons md-20 align-middle">more_vert</span></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
                  <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('catalog/editproduct/?id='.$objData->catalog_id);?>">Edit</a>
                  <a class="dropdown-item" onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('catalog/removeproduct/?id='.$objData->catalog_id);?>">Delete</a>
                  <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('catalog/copyproduct/?id='.$objData->catalog_id);?>">Copy</a>
                </div>
	            </td>
	        </tr>
	    <?php
		}
	    ?>
	    </tbody>
	</table>
</div>
