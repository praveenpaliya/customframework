<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo $this->__aT('Coupons List');?></h1>
  </div> 
  <div class="col controls-wrapper mt-3 mt-md-0 d-none d-md-block ">
    <div class="controls d-flex justify-content-center justify-content-md-end">
        <a href="<?php echo mainframe::__adminBuildUrl('coupons/addnew');?>">
        <button type="button" class="btn btn-secondary py-1 px-2">
            <i class="fa fa-plus"></i> <?php echo $this->__aT('New Coupon');?>
        </button>
        </a>
    </div>
  </div>
</div>


<div class="panel panel-info">

	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Coupon Title');?></th>
	            <th><?php echo $this->__aT('Coupon Code');?></th>
	            <th><?php echo $this->__aT('Cart Subtotal Range');?></th>
	            <th><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	    $intNo=1;
	    foreach($this->arrayData as $objData) {
	    ?>
	        <tr>
	            <td><?php echo $objData->title;?></td>
	            <td><?php echo $objData->coupon_code;?></td>
	            <td><?php echo $objData->min_subtotal;
                 if ($objData->max_subtotal>0) {
                     echo ' - '.$objData->max_subtotal;
                 }
                 ?>
                </td>
	            <td><a href="<?php echo mainframe::__adminBuildUrl('coupons/edit/id/'.$objData->coupon_id);?>">
                <button type="button" class="btn btn-icon btn-circle btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                | 
<a  onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('coupons/delete/id/'.$objData->coupon_id);?>"><button type="button" class="btn btn-icon btn-circle btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                    </td>
	        </tr>
	    <?php
		}
	    ?>
	    </tbody>
	</table>
</div>