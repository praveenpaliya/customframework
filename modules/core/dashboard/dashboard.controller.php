<?php
class dashboard extends dashboardModel {
    
        private $bestProducts;
	public function __Construct() {
		parent :: __Construct();
	}
        public static function adminMenuItems() {
            $menu_array = array(
                '<i class="icon-dashboard icon-green"></i> Dashboard' => 'dashboard'
            );
            return $menu_array;
        }
	public function index() {
            $this->getLatestCustomers();
            $this->getCatalogLowStock();
            $this->getLatestOrders();
            $this->getActiveJobs();
            $this->loadView();
	}

	private function loadView() {
                $this->getGallery();
                $objcatalog = new catalog(); 
                $this->bestProducts = $objcatalog->bestProducts();
		include('view.php');
	}
}
