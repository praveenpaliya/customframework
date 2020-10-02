<div class="row page-tilte align-items-center">
  <div class="col-md-auto">
    <h1 class="weight-300 h3 title"><?php echo $this->__aT('Customers List');?></h1>
  </div> 
  <div class="col controls-wrapper mt-3 mt-md-0 d-none d-md-block ">
    <div class="controls d-flex justify-content-center justify-content-md-end">
        <a href="<?php echo mainframe::__adminBuildUrl('customer/addnew');?>">
        <button type="button" class="btn btn-secondary py-1 px-2">
            <i class="fa fa-plus"></i> <?php echo $this->__aT('New Customer');?>
        </button>
        </a>
    </div>
  </div>
</div>

<div class="panel panel-info">
	<table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
	    <thead>
	        <tr>
	            <th><?php echo $this->__aT('Customer Name');?></th>
	            <th><?php echo $this->__aT('Email');?></th>
	            <th><?php echo $this->__aT('Phone');?></th>
	            <th><?php echo $this->__aT('Customer Group');?></th>
	            <th><?php echo $this->__aT('Status');?></th>
	            <th><?php echo $this->__aT('Registered On');?></th>
              <th class="noExl"><?php echo $this->__aT('Action');?></th>
	        </tr>
	    </thead>
	    <tbody>
	    <?php
	    $intNo=1;
	    foreach($this->userData as $objData) {
	    ?>
	        <tr>
	            <td><?php echo $objData->first_name.' '.$objData->last_name;?></td>
	            <td><?php echo $objData->email;?></td>
	            <td><?php echo $objData->phone;?></td>
	            <td><?php echo $objData->customer_group_name;?></td>
	            <td><?php if ($objData->status==1) echo 'Active'; else echo 'Inactive';?></td>
	            <td><?php echo $objData->created_date;?></td>
                <td class="noExl">
                    <a href="" class="text-muted" id="actionDropdown" data-toggle="dropdown"><span class="material-icons md-20 align-middle">more_vert</span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
                    <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('customer/edit/id/'.$objData->id);?>">Edit</a>
                    <a class="dropdown-item" onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('customer/delcustomer/id/'.$objData->id);?>" title="Delete">Delete</a>

                    <?php
                      if ($objData->status == 0) {
                    ?>
                        <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('customer/activate/id/'.$objData->id);?>" onclick="return confirm('Are you sure to activate the profile?');">Activate Profile</a>
                    <?php
                    }
                    else {
                    ?>
                        <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('customer/deactivate/id/'.$objData->id);?>" onclick="return confirm('Are you sure to Deactivate the profile?\n\nCustomer will not be able to login once account will be deactivated.');">De-Activate Profile</a>
                    <?php
                    }
                    ?>
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
                                <i style="font-size: 16px"class="fa fa-file-excel-o"></i> <?php echo $this->__aT('Export');?>
                            </a>
            </div>
</div>

<script>
            function tableToExcel(){
                $(".table").table2excel({
                        exclude: ".noExl",
                        name: "Customer report",
                        filename: "customer" + new Date().toISOString().replace(/[\-\:\.]/g, ""),
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true
                });
            }
        
</script>