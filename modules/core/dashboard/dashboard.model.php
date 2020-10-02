<?php
class dashboardModel extends ISP {
	protected $userData;
    protected $catalogInventory;
    protected $latestOrders;
    protected $jobsList;
    protected $dashboardData;
    protected $galleryData;
    
	public function __construct() {
		parent :: __construct();
        $this->getCountofRecords();
	}

    protected function getLatestCustomers() {
        $sql = "SELECT c.*, g.customer_group as customer_group_name FROM ".TABLE_PREFIX."customer c inner join  ".TABLE_PREFIX."customer_group g on g.id = c.customer_group order by created_date desc limit 5";
        $this->userData = $this->dbFetch($sql);
    }

    protected function getCountofRecords() {
        $this->dashboardData['catalog'] = $this->fetchRows("SELECT count(catalog_id) as totalProducts from ".TABLE_PREFIX."catalog where status='1'");
        $this->dashboardData['customers'] = $this->fetchRows("SELECT count(id) as totalCustomers from ".TABLE_PREFIX."customer where status='1'");
        $this->dashboardData['sales'] = $this->fetchRows("SELECT sum(order_total) as totalSales from ".TABLE_PREFIX."order");
        
    }
    
    protected function getCatalogLowStock() {
        $sql = "SELECT * FROM ".TABLE_PREFIX."catalog where inventory<=5 and manage_inventory=1 order by name limit 5";
        $this->catalogInventory = $this->dbFetch($sql);
    }
    
    protected function getLatestOrders() {
        $sql = "SELECT * FROM `".TABLE_PREFIX."order` order by order_id limit 5";
        $this->latestOrders = $this->dbFetch($sql);
    }

    protected function getActiveJobs() {
        $sql = "SELECT j.*,jt.job_type as job_type_name FROM `".TABLE_PREFIX."jobs` j inner join ".TABLE_PREFIX."job_types jt on jt.id = j.job_type where j.job_status='Active'  order by date_created desc limit 5";
        $this->jobsList = $this->dbFetch($sql);
    }
    
    protected function getGallery(){
        $sql = "SELECT * FROM ".TABLE_PREFIX."gallery order by gallery_id desc limit 8";
        $this->galleryData =  $this->dbFetch($sql);
        
    }
}