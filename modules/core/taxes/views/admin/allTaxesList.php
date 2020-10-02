<style type="text/css">
    .action-icon{
        padding: 0px 10px;
    } 
    .glyphicon-pencil:hover{
        color: dodgerblue;
    } 
    .glyphicon-trash:hover{
        color: red;
    } 
</style>

<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('All Taxes'); ?></h3>
    </div>
    <div class="page-stats">	
        <a href="<?php echo mainframe::__adminBuildUrl('taxes/addNewTax'); ?>"><button type="button" class="btn btn-danger btn-xs pull-right">
                <i class="fa fa-plus"></i> <?php echo $this->__aT('New Tax'); ?></button></a>
    </div>
</div>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
        <thead>
            <tr>
                <th><?php echo $this->__aT('Country'); ?></th>
                <th><?php echo $this->__aT('State'); ?></th>
                <th style="text-align: center"><?php echo $this->__aT('Tax rate (%)'); ?></th>
                <th style="text-align: center" class="noExl"><?php echo $this->__aT('Action'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($this->taxData as $tax): ?>
                <tr>
                    <td><?php echo $tax->country ?></td>
                    <td><?php echo $tax->state ?></td>
                    <td style="text-align: center"><?php echo $tax->tax_rate ?></td>
                    
                    <td style="text-align: center" class="noExl">
                        <span class="action-icon">
                            <a href="<?php echo mainframe::__adminBuildUrl('taxes/editTax/id/' . $tax->id); ?>" title="Edit">
                                <button type="button" class="btn btn-icon btn-circle btn-info">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                        </span>
                        |
                        <span class="action-icon">
                            <a onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('taxes/deleteTax/id/' . $tax->id); ?>" title="Delete">
                                <button type="button" class="btn btn-icon btn-circle btn-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </a>
                        </span>

                    </td>
                </tr>
            <?php endforeach; ?>
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
            name: "tax report",
            filename: "taxes" + new Date().toISOString().replace(/[\-\:\.]/g, ""),
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });
    }

</script>