<?php

/**
 * @author Praveen Paliya 8/June/2017
 * @uses This is the business logic class of manage menu module
 */
class menuModel extends ISP {

    protected $menuTypeData;
    protected $menuData;
    protected $subMenuData;

    public function __construct() {
        parent :: __construct();
    }
 
    /**
     * @uses Method is used for add a menu type record
     */
    protected function saveMenuTypeRecord() {
        $this->insertForm(TABLE_PREFIX . "menus");
    }

    /**
     * @uses Method is used to get all menu type records
     */
    protected function getAllMenuType() {
        $this->menuTypeData = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "menus");
    }
    
    /**
     * @uses Method is used to get menu type record
     */
    protected function getMenuCode($menuCode) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "menus WHERE menu_code = '{$menuCode}'";
       
        return $this->dbFetch($sql);
    }
  
    /**
     * @uses Method is used to get all menu records
     */
    protected function getAllMenus($menuTypeId) {
        return  $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "menu_items WHERE menu_id= '{$menuTypeId}' order by `ordering`");
    }
    
    /**
     * @uses Method is used to get individual menu records
     */
    protected function getMenuRecord($menuId) {
        $this->menuData = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "menu_items WHERE menu_item_id= '{$menuId}'");
    }
    
    /**
     * @uses Method is used to get parent/sub menu records
     */
    protected function getMenus($menuTypeId, $parentMenu=0) {
        return  $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "menu_items WHERE menu_id= '{$menuTypeId}' AND parent='".$parentMenu."' order by `ordering`");
    }
    
    /**
     * @uses Method is used to get all parent menu
     */
    protected function getParentMenuItem() {
        return $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "menu_items WHERE parent = '0' and menu_id='".$_GET['id']."'");
    }
  
    /**
     * @uses Method is used to get all parent menu
     */
    protected function getChildMenuItem($parentId) {
        return $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "menu_items WHERE parent = '{$parentId}'");
    }
  
    /**
     * @uses Method is used to delete individual menu type record 
     * @param int $menuTypeId menu type id
     */
    protected function deleteMenuTypeRecord($menuTypeId) {
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "menus WHERE menu_id = '$menuTypeId'");
    }
    /**
     * @uses Method is used to delete individual menu record 
     * @param int $menuTypeId menu type id
     */
    protected function deleteMenuRecord($menuId) {
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "menu_items WHERE parent = '$menuId'");
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "menu_items WHERE menu_item_id = '$menuId'");
    }
    
    /**
     * @uses Method is used to save menu 
     */
    protected function saveMenuRecord() {
        $this->insertForm(TABLE_PREFIX . "menu_items");
    }
    
    /**
     * @uses Method is used to update menu 
     */
    protected function updateMenuRecord($menuId) {
        $this->updateForm(TABLE_PREFIX . "menu_items", $menuId, 'menu_item_id');
    }
    
    
    protected function updateMenuOrder() {
        $menuType = $_POST['menutype'];
        $i=0;
        foreach($_POST['menuitems'] as $menuId) {
            $i++;
            $this->dbQuery("update ".TABLE_PREFIX."menu_items set `ordering`= '".$i."' where menu_item_id='".$menuId."'");
        }
    }

   
    
}
