<?php

/**
 * @author Praveen Paliya 4/7/2017
 * @uses This controller class is used for mange the Admin module
 */
class admin extends adminModel {

  
    private $activeLanguages;
    private $objIsp;
    private $userId;
  

    public function __Construct() {
        parent :: __Construct();
        $this->objIsp = new ISP();
        $this->checkAdminSession();
        $this->activeLanguages = $this->objIsp->listLanguages();
    }

    public function index() {
        
    }

    /**
     * @uses Method is used to load view from theme
     */
    private function loadTheme($tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/admin/front/views/" . $tpl . ".php")) {
            include("modules/vendor/admin/front/views/" . $tpl . ".php");
        } else {
            include('views/front/' . $tpl . '.php');
        }
    }

    /**
     * @uses Method is used to load view from module
     */
    private function loadView($template = 'admin/listing') {
        include('views/' . $template . '.php');
    }
    
    
    /**
     * @uses Method is used for load view all Admin in backend
     */
    public function adminList() {
        $this->getAllAdmin();
        $this->loadView('admin/adminlist');
    }
    
    
    /**
     * @uses Method is used to load add a Admin form view
     */
    public function addNewAdmin() {
        $this->loadView('admin/adminform');
    }

    /**
     * @uses Method is used for add/edit a Admin
     */
    public function saveAdmin() {
        if (empty($_POST['id'])) {
            $this->saveAdminRecord();
            mainframe :: setSuccess('Added sucessfully.');
            $this->__doRedirect(mainframe::__adminBuildUrl('admin/adminlist'));
        } else {
            $old_pass = trim($_POST['cng_password']);
            if(!empty($old_pass)){
               $_POST['md_password'] = $_POST['cng_password'];
            }
            $this->updateAdminRecord($_POST['id']);
            mainframe :: setSuccess('Updated sucessfully.');
            $this->__doRedirect(mainframe::__adminBuildUrl('admin/adminlist'));
        }
    }
    
    /**
     * @uses Method is used to edit the admin detail
     */
    public function editAdmin() {
        $this->getAdminDetails($_GET['id']);
        $this->loadView('admin/adminform');
    }
    
    /**
     * @uses Method is used to Delete the admin detail
     */
    public function deleteAdmin() {
        $this->deleteAdminDetails($_GET['id']);
        $this->__doRedirect(mainframe::__adminBuildUrl('admin/adminlist'));
    }
    
    /**
     * @uses Method is used to give the permission
     */
    public function adminPermision() { 
        $this->getAdminDetails($_GET['id']);
        $this->getAllModules();
        $this->getThisAdminPermissions($_GET['id']);
        $this->loadView('admin/adminPermissionList');
    }
    
    /**
     * @uses Method is used to save the permission
     */
    public function savePermission() { 
        $adminId = $_POST['adminId'];
        $mudulesArr = $_POST['modules'];
        $this->savePermissionDetails($adminId, $mudulesArr);
        mainframe :: setSuccess('Permission added sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('admin/adminlist'));
    }
    
    
    
    
    
}
