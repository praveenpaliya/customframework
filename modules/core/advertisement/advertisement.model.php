<?php

class advertisementModel extends ISP {

    protected $advertisementsData;
    protected $advertisementItems;
    protected $advertisementItem;

    public function __construct() {
        parent :: __construct();
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used for add a Advertisements
     */
    protected function addAdvertisementsDetails() {

        $insertId = $this->insertForm(TABLE_PREFIX . 'advertisements');
        if (!empty($_FILES['fileToUpload'])) {
            $this->addAdvertisementsItems($insertId, $_FILES);
        }
    }

    /**
     * @author Praveen Paliya 16/6/2017
     * @uses Method is used for add a Advertisement items and upload files
     */
    protected function addAdvertisementsItems($id, $FILES) {
        $fileType = '';
        $videoTypes = array('mp4', 'avi', 'mov', '3gp', 'mpeg');
        $path = SITE_UPLOADPATH; // Upload directory
        foreach ($FILES['fileToUpload']['tmp_name'] as $key => $tmp_name) {
            if (!empty($FILES['fileToUpload']['name'][$key])) {
                $file_name = mktime() . $FILES['fileToUpload']['name'][$key];
                $file_tmp = $FILES['fileToUpload']['tmp_name'][$key];
                $file_type = $FILES['fileToUpload']['type'][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (in_array($ext, $videoTypes)) {
                    $fileType = '2';
                } else {
                    $fileType = '1';
                }

                move_uploaded_file($file_tmp, $path . $file_name);
                $sql = "INSERT INTO " . TABLE_PREFIX . "advertisement_items (advertisement_id, file_type, file_name) VALUES('{$id}','{$fileType}','{$file_name}')";

                $this->dbQuery($sql);
            }
        }
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to get all Advertisements
     */
    protected function getAllAdvertisements($curDate = '') {
        $where = '';
        if (!empty($curDate)) {
            $where = " WHERE `end_date` >=  '{$curDate}'";
        }

        $sql = "SELECT * FROM " . TABLE_PREFIX . "advertisements {$where} ORDER BY `id`";
        
        $this->advertisementsData = $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to get a Advertisements
     */
    protected function getAdvertisement($advertisementId) {
        $this->advertisementsData = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "advertisements WHERE id = '{$advertisementId}' ");
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to get a Advertisement items
     */
    protected function getAdvertisementItems($advertisementId) {
        $this->advertisementItems = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "advertisement_items WHERE advertisement_id = '{$advertisementId}' ");
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to get a individual advertisement items
     */
    protected function getAdvertisementItem($id) {
        $this->advertisementItem = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "advertisement_items WHERE id = '{$id}' ");
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to delete a Advertisements
     */
    protected function deleteAdvertisementRecord($advertisementId) {
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "advertisements where  id='" . $advertisementId . "'");
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "advertisement_items where  advertisement_id='" . $advertisementId . "'");
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to delete a Advertisements
     */
    protected function deleteAdItemRecord($advertisementItemId) {
        $fileName = $this->advertisementItem[0]->file_name;
        $file = SITE_UPLOADPATH . $fileName;
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "advertisement_items where id='" . $advertisementItemId . "'");
        unlink($file);
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to delete a Advertisements
     */
    protected function updateAdvertisementRecord($advertisementId) {
        $this->updateForm(TABLE_PREFIX . 'advertisements', $advertisementId, 'id');
        if (!empty($_FILES['fileToUpload'])) {
            $this->addAdvertisementsItems($advertisementId, $_FILES);
        }
    }

}
