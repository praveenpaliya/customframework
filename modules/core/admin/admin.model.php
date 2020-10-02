<?php

/**
 * @author Praveen Paliya 4/7/2017
 * @uses This is the business logic class of admin module
 */
class adminModel extends ISP {

    protected $adminData;
    protected $moduleData;
    protected $permissionData;
   

    public function __construct() {
        parent :: __construct();
    }

    /**
     * @uses Method is used to get all Admin users
     */
    protected function getAllAdmin() {
        $this->adminData = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "admin WHERE id <> 1");
    }
    
    /**
     * @uses Method is used for add a admin
     */
    protected function saveAdminRecord() {
        $insertId = $this->insertForm(TABLE_PREFIX . "admin");
        
        $docArr = $this->uploadAdminDocuments($_FILES['doc']);
        $doc = json_encode($docArr);
        
        $sql = "UPDATE " . TABLE_PREFIX . "admin SET doc='{$doc}' where id='{$insertId}' "; 
        $this->dbQuery($sql);
        
    }
    
    protected function uploadAdminDocuments($FILE){
        $files=[];
        $path = SITE_UPLOADPATH; // Upload directory
        foreach ($FILE['tmp_name'] as $key => $tmp_name) {
            if (!empty($FILE['name'][$key])) {
                $file_name = mktime() . $FILE['name'][$key];
                $file_tmp = $FILE['tmp_name'][$key];
                
                move_uploaded_file($file_tmp, $path . $file_name);
                $files[] = $file_name;
            }
        }
        return $files;
    }
    
    /**
     * @uses Method is used for add a admin
     */
    protected function updateAdminRecord($id) {
        $allDoc =[];
        $doc=[];
        $oldDoc = $_POST['oldDoc'];
        
        if (!empty($_FILES['doc'])) {
            $doc = $this->uploadAdminDocuments($_FILES['doc']);
        }
        if(!empty($doc)){
            $allDoc = array_merge($oldDoc,$doc);
        }else{
           $allDoc = $oldDoc; 
        }
        
        $this->updateForm(TABLE_PREFIX . "admin", $id);
        
        $allDoc = json_encode($allDoc);
        $sql = "UPDATE " . TABLE_PREFIX . "admin SET doc='{$allDoc}' where id='{$id}' "; 
        $this->dbQuery($sql);
    }
    
    /**
     * @uses Method is used to get individual admin details
     */
    protected function getAdminDetails($id) {
        $this->adminData = $this->fetchRows("SELECT * from " . TABLE_PREFIX . "admin where id= '{$id}'");
    }
    
    /**
     * @uses Method is used to Delete individual admin details
     */
    protected function deleteAdminDetails($id) {
        $this->dbQuery("Delete FROM " . TABLE_PREFIX . "admin where id= '{$id}'");
    }
    
    /**
     * @uses Method is used to get All  Modules
     */
    protected function getAllModules() {
        $this->moduleData = $this->dbFetch("SELECT * from " . TABLE_PREFIX . "modules WHERE status='1' order by module_name asc");
    }
    
    /**
     * @uses Method is used to get All  Modules
     */
    protected function getThisAdminPermissions($adminId) {
        $this->permissionData = $this->dbFetch("SELECT * from " . TABLE_PREFIX . "permissions WHERE admin_id = '{$adminId}'");
    }
    
    /**
     * @uses Method is used to save the admin user permission
     */
    protected function savePermissionDetails($adminId, $mudulesArr) {
        $this->dbQuery("DELETE from ".TABLE_PREFIX."permissions where admin_id='".$adminId."'");
        foreach ($mudulesArr as $moduleName){
            $sql = "INSERT INTO ".TABLE_PREFIX."permissions (admin_id, module_name) VALUES('{$adminId}','{$moduleName}')";
            $this->dbQuery($sql);
        }
    }
    
}
