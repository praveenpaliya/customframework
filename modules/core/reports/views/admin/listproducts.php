
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('Order report'); ?></h3>
    </div>

</div>
<form method="post" action="<?php echo mainframe::__adminBuildUrl('reports/productReport');?>">
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
                <th><?php echo $this->__aT('Product Name'); ?></th>
                <th><?php echo $this->__aT('Brand Name'); ?></th>
                <th><?php echo $this->__aT('Category Name'); ?></th>
                <th><?php echo $this->__aT('Artical No/ SKU'); ?></th>
                <!--<th><?php //echo $this->__aT('Artical No.'); ?></th>-->
                <th><?php echo $this->__aT('Manufacturer PDT No'); ?></th>
                <th><?php echo $this->__aT('Sold Quantity'); ?></th>
                <th><?php echo $this->__aT('Unit Price'); ?></th>
                <th><?php echo $this->__aT('Total Amount'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 0;
            foreach ($this->productData as $objData) {
                ?>
                <tr>
                    <td><?php echo $objData->product_name; ?></td>
                    <td><?php echo $objData->brand_name; ?></td>
                    <td><?php echo $objData->category_name; ?></td>
                    <td><?php echo $objData->sku; ?></td>
                    <!--<td><?php //echo $objData->article_number; ?></td>-->
                    <td><?php echo $objData->manufacturer_pdt_no; ?></td>
                    <td><?php echo $objData->quantity; ?></td>
                    <td><?php echo $objData->special_price; ?></td>
                    <td><?php echo CURRENCY . ' ' . $objData->total_price; ?></td>
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

