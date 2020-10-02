<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->__aT('All Pages'); ?></h3>
    </div>
    <div class="page-stats">    
        <a href="<?php echo mainframe::__adminBuildUrl('pages/addpage'); ?>">
            <button type="button" class="btn btn-secondary btn-xs pull-right">
                <i class="fa fa-plus"></i>  <?php echo $this->__aT('New Page'); ?>
            </button>
        </a>
    </div>
</div>

<div class="panel panel-info">
    <table class="table table-striped table-bordered table-hover table-checkable table-responsive datatable dataTable">
        <thead>
            <tr>
                <th><?php echo $this->__aT('Page ID'); ?></th>
                <th><?php echo $this->__aT('Page Title'); ?></th>
                <th><?php echo $this->__aT('Page Identifier'); ?></th>
                <th><?php echo $this->__aT('Action'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $intNo = 1;
            foreach ($this->pageData as $objData) {
                ?>
                <tr>
                    <td><?php echo $objData->page_id; ?></td>
                    <td><?php echo $objData->title; ?></td>
                    <td><?php echo $objData->url; ?></td>
                    <td class="noExl">
                        <a href="" class="text-muted" id="actionDropdown" data-toggle="dropdown"><span class="material-icons md-20 align-middle">more_vert</span></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">
                          <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('pages/addpage/id/' . $objData->page_id); ?>">Edit</a>
                          <a class="dropdown-item" onclick="return deletePrompt();" href="<?php echo mainframe::__adminBuildUrl('pages/delete/id/' . $objData->page_id); ?>" title="Delete">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php
                $intNo++;
            }
            ?>
        </tbody>
    </table>
</div>