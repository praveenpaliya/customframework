<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title">Categories List </h1>
  </div> 
  <div class="col controls-wrapper mt-3 mt-md-0 d-none d-md-block ">
    <div class="controls d-flex justify-content-center justify-content-md-end">
        <a href="<?php echo mainframe::__adminBuildUrl('catalog/addnewcategory');?>">
        <button type="button" class="btn btn-secondary py-1 px-2">
            <i class="fa fa-plus"></i> <?php echo $this->__aT('New Category');?>
        </button>
        </a>
    </div>
  </div>
</div>

<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Category Name');?></th>
                <th><?php echo $this->__aT('Category ID');?></th>
                <th class="noExl"><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
            echo $this->sortedCategories;
	    ?>
	    </tbody>
	</table>
</div>
