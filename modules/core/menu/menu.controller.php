<?php

/**
 * @author Praveen Paliya 08/June/2017
 * @uses This controller class is used for mange the Menu module
 */
class menu extends menuModel {

    private $objIsp;
    public  $menuTypeId;
    private $menuItemsData;
    public  $parentMenuData;

    public function __Construct() {
        parent :: __Construct();
        $this->objIsp = new ISP();
        $this->activeLanguages = $this->objIsp->listLanguages();
    }

    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-ticket"></i> Menus' => array(
                'All Menus' => 'menu/allMenuType'
            )
        );
        return $menu_array;
    }

    public function index() {
        $this->allMenuType();
    }

    /**
     * @uses Method is used to load view from theme
     */
    private function loadTheme($tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/menu/front/views/" . $tpl . ".php")) {
            include("modules/vendor/menu/front/views/" . $tpl . ".php");
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
     * @uses Method is used to load add a menu form view
     */
    public function addNewMenuType() {
        $this->loadView('admin/addMenuTypeForm');
    }

    /**
     * @uses Method is used for add new/edit a menu type
     */
    public function saveMenuType() {
        $this->saveMenuTypeRecord();
        mainframe :: setSuccess('Menu type added sucessfully.');
        $this->allMenuType();
    }

    /**
     * @uses Method is used for load view all menu type 
     */
    public function allMenuType() {
        $this->getAllMenuType();
        $this->loadView('admin/allMenuType');
    }

    /**
     * @uses Method is used to delete the  menu type record
     */
    public function deleteMenuType() {
        $menuId = $_GET['id'];
        $this->deleteMenuTypeRecord($menuId);
        mainframe :: setSuccess('Deleted sucessfully.');
        $this->allMenuType();
    }

    /**
     * @uses Method is used to load manage menu 
     */
    public function manageMenu() {

        if(!empty($_POST)) {
            $this->updateMenuOrder();
        }
        $this->menuTypeId = $_GET['id'];
        $this->menuItemsData = $this->getAllMenus($this->menuTypeId);
        $this->loadView('admin/manageMenu');
    }

    /**
     * @uses Method is used to load manage menu 
     */
    public function addMenu() {
        $this->menuTypeId = $_GET['id'];
        $parentMenuData = $this->getParentMenuItem();
        $this->parentMenuData = $this->generateParentMenu($parentMenuData);
        $this->loadView('admin/addMenuForm');
    }
    
    
    /**
     * @uses Method is used to generate parent selection 
     */
    public function generateParentMenu($parentMenuData, $indent='') {
        $options = '';
        $selected = '';

        if (!empty($parentMenuData)) {
            foreach ($parentMenuData as $parentData){
                $value = $parentData->menu_item_id;
                $title = $this->__aT(trim($parentData->menu_title));
                
                if (!empty($this->menuData)) {
                    $selected = ($this->menuData[0]->parent == $value) ? 'selected' : '';
                }

                $options .= "<option value='{$value}' {$selected}>".$indent.$title."</option>";

                $childMenuItem = $this->getChildMenuItem($parentData->menu_item_id);
                $options .= $this->generateParentMenu($childMenuItem, $indent.'&mdash;');
            }
        }
        return $options;
    }
    
    /**
     * @uses Method is used to get sub menu category record
     */
    public function getSubMenuCategory() {
        $menuCategoryName = trim($_POST['menuCategoryName']);
        $callFunction = 'useAsMenu';
        
        if($menuCategoryName=='categories') {
            $menuCategoryName ='catalog';
            $callFunction = 'categoryMenu';
        }
            
        if($menuCategoryName=='products') {
            $menuCategoryName ='catalog';
            $callFunction = 'productMenu';
        }
        
        $menuTypeId = $_POST['menuTypeId'];
        $subCategoryObj = new $menuCategoryName();
        echo json_encode($subCategoryObj->$callFunction());
        die;
    }

    /**
     * @uses Method is used to add menu
     */
    public function saveMenu() {
        
        if(!empty($_POST['editId'])){
            $this->updateMenuRecord($_POST['editId']);
            mainframe :: setSuccess('Menu Updated sucessfully.');
        }else{
            $this->saveMenuRecord();
            mainframe :: setSuccess('Menu added sucessfully.');
        }
        $this->__doRedirect(mainframe::__adminBuildUrl('menu/manageMenu/id/'.$_POST['md_menu_id'])); // redirect to view
    }
    
    /**
     * @uses Method is used to edit menu
     */
    public function editMenu() {
        $menuId = $_GET['item_id'];
        $this->getMenuRecord($menuId);
        
        $parentMenuData = $this->getParentMenuItem();
        $this->parentMenuData = $this->generateParentMenu($parentMenuData);
        
        $this->menuTypeId = $this->menuData[0]->menu_id;
        $this->loadView('admin/addMenuForm');
    }
    /**
     * @uses Method is used to delete menu
     */
    public function deleteMenu() {
        $menuId = $_GET['id'];
        $menuTypeId = $_GET['mTId'];
        $this->deleteMenuRecord($menuId);
        mainframe :: setSuccess('deleted sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('menu/manageMenu/id/'.$menuTypeId)); // redirect to view
    }
    
    /**
     * @uses Method is used to set menu in web page
     */
    public function setMenu($menuCode, $topUlClass='', $subUlClass='') {
        $menuType = $this->getMenuCode($menuCode);
        $menuTypeId = $menuType[0]->menu_id;
        $menuItems = $this->getMenus($menuTypeId);
        return $this->generateMenu($menuTypeId,$menuItems,$topUlClass, $subUlClass);       
    }
    
    public function generateMenu($menuTypeId, $menuData,$topUlClass='', $subUlClass='') {
       
        if (!empty($menuData)) {
             $list = '<ul class="'.$topUlClass.'" aria-expanded="false">';
            foreach ($menuData as $data) {
                $menuUrl = $this->buildMenuUrl($data->menu_url);
                
                $subMenu = $this->getMenus($menuTypeId, $data->menu_item_id);
                $subMenuItems = $this->generateMenu($menuTypeId, $subMenu, $subUlClass, $subUlClass);
                $subMenuAdditional = '';
                $subMenuLi = '';
                if($subMenuItems != "") {
                    $subMenuAdditional = 'aria-expanded="false" data-toggle="dropdown"';
                    $subMenuLi = 'class="dropdown"';
                }
                
                $list .= '<li '.$subMenuLi.'> <a class="' . $topUlClass . '" href="' . $menuUrl . '" '.$subMenuAdditional.'>' . $data->menu_title . '</a>';
               
                $list .= $subMenuItems;
                $list .= '</li>';
            }
            $list.= '</ul>';
        }
        return $list;
    }
    
    private function buildMenuUrl($url) {
        switch($url) {
            case '#':
                return '#';
            break;
        
            case 'void(0)':
            case 'void(0);':
            case 'javascript: void(0)':
            case 'javascript: void(0);':
            case 'javascript:void(0)':
            case 'javascript:void(0);':
                return 'javascript:void(0);';
            break;
            case '':
            case '/':
                return SITE_URL;
            break;
            default:
               return $this->getUrl($url);
            break;
        }
    }

} 
