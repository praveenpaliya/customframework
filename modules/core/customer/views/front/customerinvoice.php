
<section class="collapse_area">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 ">
                <div class="check">
                    <h1><?php echo $this->__aT('My Invoices'); ?></h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel col-xs-12 col-sm-12 col-md-12 nopadding ">
                <div class="panel panel-info">
                    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
                        <thead style="background-color: #296A72; color: #fff">
                            <tr>
                                <th><?php echo $this->__aT('Invoice Date'); ?></th>
                                <th><?php echo $this->__aT('Invoice Type'); ?></th>
                                <th><?php echo $this->__aT('Customer Name<'); ?>/th>
                                <th><?php echo $this->__aT('Customer Email'); ?></th>
                                <th><?php echo $this->__aT('Phone'); ?></th>
                                <th><?php echo $this->__aT('Total Cost'); ?></th>
                                <th style="text-align: center"><?php echo $this->__aT('Download'); ?></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php if(!empty($this->allInvoices)){
                            
                            $intNo = 1;
                            foreach ($this->allInvoices as $objData) {
                                $items = json_decode(html_entity_decode($objData->items));
                                foreach ($items->price as $key => $val) {
                                    foreach ($items->qty as $k => $v) {
                                        if ($key == $k) {
                                            $subTotal += $val * $v;
                                        }
                                    }
                                }
                                $total = ($subTotal + $items->tax + $items->shipping) - $items->discount;
                                ?>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime($objData->added_at)); ?></td>
                                    <td><?php echo $objData->invoice_type; ?></td>
                                    <td><?php echo $objData->customer_name ?></td>
                                    <td><?php echo $objData->customer_email; ?></td>
                                    <td><?php echo $objData->phone_no; ?></td>
                                    <td style="text-align: center"><?php echo $total; ?></td>
                                    <td style="text-align: center">
                                        <a href="<?php echo SITE_URL . 'var/'.SITE_THEME.'/invoices/invoice-' . $objData->id; ?>" target="_blank">
                                            <div>
                                                <i class="fa fa-download" style="font-size: 18px;"></i>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            }else{
                          ?>  
                                <tr>
                                    <td colspan="7" style="text-align: center"><span >No record found!</span></td>
                                </tr>    
                          <?php       
                            }
                            ?>
                        </tbody>
                       
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>