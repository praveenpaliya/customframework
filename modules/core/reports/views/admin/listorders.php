
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('Order report'); ?></h3>
    </div>

</div>
<form method="post" action="<?php echo mainframe::__adminBuildUrl('reports/orderReport');?>">
<div class="col-sm-12 row panel">
    <select class="form-control" style="width: 300px;" name="shorPeriod">
        <option value="">--Select--</option>
        <option value="Y" <?php echo ($_POST['shorPeriod'] == 'Y')?'selected':'';?>>Yearly</option>
        <option value="H" <?php echo ($_POST['shorPeriod'] == 'H')?'selected':'';?>>Half Yearly</option>
        <option value="M" <?php echo ($_POST['shorPeriod'] == 'M')?'selected':'';?>>This month</option>
        <option value="W" <?php echo ($_POST['shorPeriod'] == 'W')?'selected':'';?>>This week</option>
    </select>
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
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable" >
        <thead>
            <tr>
                <th><?php echo $this->__aT('Order ID'); ?></th>
                <th><?php echo $this->__aT('Order Amount'); ?></th>
                <th><?php echo $this->__aT('Order Date'); ?></th>
                <th><?php echo $this->__aT('Payment Mode'); ?></th>
                <th><?php echo $this->__aT('Order Status'); ?></th>
                <th><?php echo $this->__aT('Billing address'); ?></th>
                <th><?php echo $this->__aT('Shipping address'); ?></th>
                <th><?php echo $this->__aT('Treansection id'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 0;
            $billingAdd =""; 
            foreach ($this->orderData as $objData) {
                
                $billingAdd = $objData->billing_address.', '.$objData->billing_city.', '.$objData->billing_state.', '.$objData->billing_country.', '.$objData->billing_zip_code;
                $shippingAdd = $objData->shipping_address.', '.$objData->shipping_city.', '.$objData->shipping_state.', '.$objData->shipping_country.', '.$objData->shipping_zip_code;
                ?>
                <tr>
                    <td><?php echo $objData->order_id; ?></td>
                    <td><?php echo CURRENCY . ' ' . $objData->order_total; ?></td>
                    <td><?php echo $objData->order_date; ?></td>
                    <td><?php echo $objData->paid_by; ?></td>
                    <td><?php echo $objData->order_status; ?></td>
                    <td><?php echo $billingAdd; ?></td>
                    <td><?php echo $shippingAdd; ?></td>
                    <td><?php echo $objData->transaction_id; ?></td>
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

