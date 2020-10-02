<?php

class pagesModel extends ISP {

    public $userData;

    public function __construct() {
        parent :: __construct();
    }

    public function LoadAllPages() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "pages order by title";
        return $this->dbFetch($sql);
    }

    public function getPageDetails($pId) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "pages where page_id='" . $pId . "'";
        return (array) $this->fetchRows($sql);
    }

    public function savepage() {
        if (intval($_POST['id']) == 0) {
            $id = $this->insertForm(TABLE_PREFIX . "pages");
            $this->updateRouter('pages/pagedetails/pageid/'.$id, $_POST['md_url']);
        } else {
            $this->updateForm(TABLE_PREFIX . "pages", $_POST['id'], 'page_id');
            $this->updateRouter('pages/pagedetails/pageid/'.$_POST['id'], $_POST['md_url']);
        }
    }

    /**
     * @uses Method use to delete pages
     * $date 03.07.2017
     * @author Santos Pal <santosh@w4consult.com>
     */
    protected function deletPage($pageid) {
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "pages WHERE page_id = '" . $pageid . "'");
    }

    public function saveContactusDetails() {
        $this->insertForm(TABLE_PREFIX . "contact_us");
    }

}
