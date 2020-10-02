<?php

class advertisement extends advertisementModel {

    private $objIsp;
    private $activeLanguages;
    private $subsciptionProductData;

    public function __Construct() {
        parent :: __Construct();
        $this->objIsp = new ISP();
        $this->activeLanguages = $this->objIsp->listLanguages();
    }

    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon fa fa-ad"></i> Advertises' => array(
                'All Advertises' => 'advertisement/advertisements',
                'Add New Advertise' => 'advertisement/addAdvertisements'
            )
        );
        return $menu_array;
    }

    public function index() {
        $this->viewAdvertisements();
    }

    private function loadTheme($tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/advertisement/front/views/" . $tpl . ".php")) {
            include("modules/vendor/advertisement/front/views/" . $tpl . ".php");
        } else {
            include('views/front/' . $tpl . '.php');
        }
    }

    private function loadView($template = 'admin/listing') {
        include('views/' . $template . '.php');
    }

    public function advertisements() {
        $this->getAllAdvertisements();
        $this->loadView('admin/advertisementslist');
    }

    public function addAdvertisements() {
        $this->loadView('admin/advertisementsform');
    }

    public function saveAdvertisements() {
        $advertisementId = $_POST['id']; // advertisement id
        if (!empty($advertisementId)) {
            $this->updateAdvertisementRecord($advertisementId); //update advertisement detail 
            mainframe :: setSuccess('updated sucessfully.');
        } else {
            $this->addAdvertisementsDetails();
            mainframe :: setSuccess('Added sucessfully.');
        }
        $this->__doRedirect(mainframe::__adminBuildUrl('advertisement/advertisements')); // redirect to view
    }

    public function viewAdvertisements() {
        $curDate = date('Y-m-d');
        $this->getAllAdvertisements($curDate);
        $this->loadTheme('viewAdvertisements');
    }

    public function viewAdvertisementDetails() {
        $advertisementId = $_GET['id'];
        $this->getAdvertisement($advertisementId);
        $this->getAdvertisementItems($advertisementId);
        $this->loadTheme('viewAdvertisementDetails');
    }

    public function downloadAdvertisements() {
        $advertisementItemId = $_GET['id']; // advertisement id
        $this->getAdvertisementItem($advertisementItemId); // advertisement detail result
        $downloadFileName = $this->advertisementItem[0]->file_name; // file name

        $this->getAdvertisement($this->advertisementItem[0]->advertisement_id); // advertisement detail result
        $outputFileName = 'download_' . $this->advertisementsData[0]->title; // output file name

        $downloadPath = SITE_UPLOADPATH; // dir path from file download 
        $this->downloadFile($downloadPath, $downloadFileName, $outputFileName); //Download file method call

        $this->__doRedirect(mainframe::__adminBuildUrl('advertisement/viewAdvertisementDetails/id/' . $this->advertisementsData[0]->id)); // redirect to view
        $this->viewAdvertisements(); // redirect to view
    }

    public function deleteAdvertisement() {
        $advertisementId = $_GET['id']; // advertisement id
        $this->deleteAdvertisementRecord($advertisementId); // advertisement detail result
        mainframe :: setSuccess('Deleted sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('advertisement/advertisements')); // redirect to view
    }

    public function deleteAdItem() {
        $advertisementItemId = $_GET['id']; // advertisement id
        $this->getAdvertisementItem($advertisementItemId);

        $this->deleteAdItemRecord($advertisementItemId); // advertisement detail result
        mainframe :: setSuccess('Deleted sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('advertisement/editAdvertisements/id/' . $this->advertisementItem[0]->advertisement_id)); // redirect to view
    }

    public function editAdvertisements() {
        $this->advertisementsId = $_GET['id']; // advertisement id
        $this->getAdvertisement($this->advertisementsId);
        $this->getAdvertisementItems($this->advertisementsId);
        $this->loadView('admin/advertisementsform');
    }

    /**
     * @use Method is used for download File 
     * @param string $downloadPath Path where the file is located 
     * @param string $downloadFileName Name of the file 
     * @param string $outputFileName Name of the output file 
     */
    private function downloadFile($downloadPath, $downloadFileName, $outputFileName) {
        ignore_user_abort(true);
        set_time_limit(0);
        $fullPath = $downloadPath . $downloadFileName; // full file path from download 

        if ($fd = fopen($fullPath, "r")) {
            $path_parts = pathinfo($fullPath);
            $fsize = filesize($fullPath);
            $ext = strtolower($path_parts["extension"]); //file extenction 

            $known_mime_types = array(
                "pdf" => "application/pdf",
                "txt" => "text/plain",
                "html" => "text/html",
                "htm" => "text/html",
                "exe" => "application/octet-stream",
                "zip" => "application/zip",
                "doc" => "application/msword",
                "docx" => "application/msword",
                "xls" => "application/vnd.ms-excel",
                "ppt" => "application/vnd.ms-powerpoint",
                "gif" => "image/gif",
                "png" => "image/png",
                "jpeg" => "image/jpg",
                "jpg" => "image/jpg",
                "php" => "text/plain"
            );

            foreach ($known_mime_types as $k => $v) {
                if ($ext == $k) {
                    $contentType = $v;
                }
            }

            header("Content-type: $contentType");
            header("Content-Disposition: attachment; filename=\"" . $outputFileName . "." . $ext . "\""); // use 'attachment' to force a file download
            header("Content-length: $fsize");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            ob_clean();
            flush();
            readfile($fullPath);
            fclose($fd);
            exit();
        }
    }

    /**
     * @uses Method is used to record for creating menu
     */
    public function useAsMenu() {
        $this->getAllAdvertisements();
        $result = [];
        $i = 0;

        $result['value'][$i] = 'advertisement/viewAdvertisements';
        $result['title'][$i] = 'All Advertisements';
        $i++;

        foreach ($this->advertisementsData as $data) {
            $result['value'][$i] = 'advertisement/downloadAdvertisements/id/' . $data->id;
            $result['title'][$i] = $data->title;
            $i++;
        }
        return $result;
    }

}
