<?php

/**
 * @author Praveen Paliya 05/June/2017
 * @uses This controller class is used for mange the Tax module
 */
class taxes extends taxesModel {

    private $taxId;
    private $objIsp;
    

    public function __Construct() {
        parent :: __Construct();
        $this->objIsp = new ISP();
        $this->activeLanguages = $this->objIsp->listLanguages();
    }

    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon-barcode icon-blue" aria-hidden="true"></i> Taxes' => array(
                'Manage Taxes' => 'taxes/allTaxes'
            )
        );
        return $menu_array;
    }

    public function index() { 
        //$this->distributers();
    }
    
    /**
     * @uses Method is used to load view from theme
     */
    private function loadTheme($tpl) {		
        if(file_exists("templates/front/".SITE_THEME."/views/".$tpl.".php")) {
            include("templates/front/".SITE_THEME."/views/".$tpl.".php");
        }
        elseif(file_exists("modules/vendor/taxes/front/views/".$tpl.".php")) {
            include("modules/vendor/taxes/front/views/".$tpl.".php");
        }
        else {
            include('views/front/'.$tpl.'.php');
        }
    }
    
    /**
     * @uses Method is used to load view from module
     */
    private function loadView($template = 'admin/listing') {
		include('views/'.$template.'.php');
	}

    /**
     * @uses Method is used to load add a tax form view
     */
    public function addNewTax() {
        $this->getCountries();
        $this->loadView('admin/addTaxForm');
    } 

    /**
     * @uses Method is used for add new/edit a tax details
     */
    public function saveTax() {
        if (empty($_POST['taxRecordId'])) {
            $this->saveTaxRecord();
            mainframe :: setSuccess('Tax record added sucessfully.');
            $this->allTaxes();
        } else {
            $this->updateTaxRecord($_POST['taxRecordId']);
            mainframe :: setSuccess('Updated sucessfully.');
            $this->allTaxes();
        }
    }

    /**
     * @uses Method is used for load view all distributors in backend
     */
    public function allTaxes() {
        $this->getAllTaxRecord();
        $this->loadView('admin/allTaxesList');
    }
  
    /**
     * @uses Method is used to edit the tax record
     */
    public function editTax() {
        $this->taxId = $_GET['id'];
        $this->getTaxRecord($this->taxId);
        $this->addNewTax();
    }

    /**
     * @uses Method is used to delete the tax record
     */
    public function deleteTax() {
        $taxRecordId = $_GET['id'];
        $this->deleteTaxRecord($taxRecordId);
        mainframe :: setSuccess('Deleted sucessfully.');
        $this->allTaxes();
    }

}

