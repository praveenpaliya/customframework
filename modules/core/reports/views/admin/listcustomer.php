
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('Customer report'); ?></h3>
    </div>

</div>
<form method="post" action="<?php echo mainframe::__adminBuildUrl('reports/customerReport');?>">
<div class="col-sm-12 row panel">
    <select class="form-control" style="width: 300px;" name="shorPeriod">
        <option value="">--Select--</option>
        <option value="Y" <?php echo ($_POST['shorPeriod'] == 'Y')?'selected':'';?>>Yearly</option>
        <option value="H" <?php echo ($_POST['shorPeriod'] == 'H')?'selected':'';?>>Half Yearly</option>
        <option value="M" <?php echo ($_POST['shorPeriod'] == 'M')?'selected':'';?>>This month</option>
        <option value="W" <?php echo ($_POST['shorPeriod'] == 'W')?'selected':'';?>>This week</option>
    </select>
</div>
<div class="col-sm-12 row panel">
    <div class="col-sm-4" style="padding-left: 0px">
        <label>Start date:</label>
        <input type="text" name="start_date" id="start_date" class="form-control  datepicker hasDatepicker picker__input" value="<?php echo $_POST['start_date']?>">
    </div>
    <div class="col-sm-4">
         <label>End date:</label>
         <input type="text" name="end_date" id="end_date" class="form-control  datepicker hasDatepicker picker__input" value="<?php echo $_POST['end_date']?>">
    </div>
</div>
<div class="col-sm-12 row panel">
    <input type="submit" class="btn btn-primary" value="<?php echo $this->__aT('Filter');?>" name="search">
    <input type="submit" class="btn btn-primary" value="<?php echo $this->__aT('Export');?>" name="export">
</div>
</form>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive " >
        <thead>
            <tr>
                <th><?php echo $this->__aT('Customer Name'); ?></th>
                <th><?php echo $this->__aT('Email'); ?></th>
                <th><?php echo $this->__aT('Phone'); ?></th>
                <th><?php echo $this->__aT('Address'); ?></th>
                <th><?php echo $this->__aT('City'); ?></th>
                <th><?php echo $this->__aT('State'); ?></th>
                <th><?php echo $this->__aT('Country'); ?></th>
                <th><?php echo $this->__aT('Zip'); ?></th>
                <th><?php echo $this->__aT('Total Amount'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 0;
            foreach ($this->customerData as $objData) {
                ?>
                <tr>
                    <td><?php echo $objData->cutomer_name; ?></td>
                    <td><?php echo $objData->email; ?></td>
                    <td><?php echo $objData->phone; ?></td>
                    <td><?php echo $objData->address1; ?></td>
                    <td><?php echo $objData->city; ?></td>
                    <td><?php echo $objData->state; ?></td>
                    <td><?php echo $objData->country; ?></td>
                    <td><?php echo $objData->zip_code; ?></td>
                    <td><?php echo CURRENCY . ' ' . $objData->total; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    
    
</div>


<script type="text/javascript">

    /**
     * @author Praveen Paliya 11/07/2017
     * @use Method is used to generate report
     */
    function generateReport(arraydata, fileName) {
        $.ajax({
                url: "<?php echo SITE_URL . 'reports/generateReport'; ?>",
                datatype: 'json',
                method: 'post',
                data: {arraydata: arraydata, fileName: fileName},
                success: function (result) {
                    console.log('Report generated successfuly');
                }
            });
    }
</script>

