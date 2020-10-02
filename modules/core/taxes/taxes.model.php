<?php

/**
 * @author Praveen Paliya 6/June/2017
 * @uses This is the business logic class of manage tax module
 */
class taxesModel extends ISP {

    protected $taxData;
    protected $countriesData;
   

    public function __construct() {
        parent :: __construct();
    }

    /**
     * @uses Method is used for get all country names
     */
    protected function getCountries() {
        $this->countriesData = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "countries");
    }
    /**
     * @uses Method is used for add a tax record
     */
    protected function saveTaxRecord() {
        $this->insertForm(TABLE_PREFIX . "taxes");
    }

    /**
     * @uses Method is used to get all tax records
     */
    protected function getAllTaxRecord() {
        $this->taxData = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "taxes");
    }
 
    
    /**
     * @uses Method is used to get individual Tax record
     */
    protected function getTaxRecord($taxRecordId) {
        $this->taxData = $this->fetchRows("SELECT * from " . TABLE_PREFIX . "taxes where id= '$taxRecordId'");
    }

    /**
     * @uses Method is used to delete individual tax record 
     */
    protected function deleteTaxRecord($taxRecordId) {
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "taxes where id = '$taxRecordId'");
    }

    /**
     * @uses Method is used to update individual tax record 
     */
    protected function updateTaxRecord($taxRecordId) {
        $this->updateForm(TABLE_PREFIX . "taxes", $taxRecordId);
    }
    
}
