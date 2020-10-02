<?php

class brands extends brandsModel {

    private $brandId;

    public function __Construct() {
        parent :: __Construct();
        $this->brandId = 0;
    }
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-building"></i> Brands' => array(
                'All Brands' => 'brands',
                'Add New Brand' => 'brands/addnew'
            )
        );
        return $menu_array;
    }

    public function index() {
        $this->listBrands();
        $this->loadView();
    }

    public function listing() {
        $this->listBrands();
        $this->loadTheme('viewBrands');
    }

    public function addnew() {
        $this->checkAdminSession();
        $this->loadView('brandsform');
    }

    public function edit() {
        $this->checkAdminSession();
        $bId = intval($_GET['id']);
        if ($bId > 0) {
            $this->brandId = $bId;
            $this->getBrands($bId);
            $this->loadView('brandsform');
        } else {
            $this->__doRedirect(mainframe::__adminBuildUrl('brands'));
        }
    }

    public function delete() {
        $this->checkAdminSession();
        $bId = intval($_GET['id']);
        $this->deleteBrand($bId);
        mainframe :: setSuccess('Brand Deleted successfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('brands'));
    }

    public function save() {
        $this->checkAdminSession();
        if ($this->postedData['id'] > 0) {
            $this->updateBrands($this->postedData['id']);
            mainframe :: setSuccess('Brand information saved successfully.');
            if ($_POST['saveexit'])
                $this->__doRedirect(mainframe::__adminBuildUrl('brands'));
            else
                $this->__doRedirect(mainframe::__adminBuildUrl('brands/addnew'));
        }
        else {
            if ($this->saveBrands()) {
                mainframe :: setSuccess('Brand information saved successfully.');
                if ($_POST['saveexit'])
                    $this->__doRedirect(mainframe::__adminBuildUrl('brands'));
                else
                    $this->__doRedirect(mainframe::__adminBuildUrl('brands/addnew'));
            }
            else {
                mainframe :: setError('Brand information could not saved. Please try again.');
                $this->arrayData = $this->filterPostedData();
                $this->loadView('brandsform');
            }
        }
    }

    private function loadView($template = 'listview') {
        include($template . '.php');
    }

    /**
     * @uses Method is used to load view from theme
     */
    private function loadTheme($tpl) {
        if (file_exists("templates/front/".SITE_THEME."/views/" . $tpl . ".php")) {
            include("templates/front/".SITE_THEME."/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/brands/front/views/" . $tpl . ".php")) {
            include("modules/vendor/brands/front/views/" . $tpl . ".php");
        } else {
            include('views/front/' . $tpl . '.php');
        }
    }

    /**
     * @author Praveen Paliya 8/june/2017
     * @uses Method is used to get record for creating menu
     */
    public function useAsMenu() {
        $this->listBrands();
        $result = [];
        $i = 0;
        
        $result['value'][$i] = 'brands/listing';
        $result['title'][$i] = 'All Brands';
        $i++;
        
        foreach ($this->arrayData as $data) {
//            $result['value'][$i] = $data->brand_id;
            $result['value'][$i] = 'brands/listing';
            $result['title'][$i] = $data->brand_name;
            $i++;
        }
        return $result;
    }

}
