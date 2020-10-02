<?php

class coupons extends couponsModel {

    private $couponId;

    public function __Construct() {
        parent :: __Construct();
        $this->couponId = 0;
    }
    
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-ticket"></i> Coupons' => array(
                'All Coupons' => 'coupons',
                'Add New Coupon' => 'coupons/addnew'
            )
        );
        return $menu_array;
    }

    public function index() {
        $this->listCoupons();
        $this->loadView();
    }

    public function addnew() {
        $this->loadView('couponsform');
    }

    public function edit() {
        $bId = intval($_GET['id']);
        if ($bId > 0) {
            $this->couponId = $bId;
            $this->getCoupons($bId);
            $this->loadView('couponsform');
        } else {
            $this->__doRedirect(mainframe::__adminBuildUrl('coupons'));
        }
    }

    public function delete() {
        $bId = intval($_GET['id']);
        $this->deleteCoupons($bId);
        mainframe :: setSuccess('Coupon Deleted successfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('coupons'));
    }

    public function save() {
        if ($this->postedData['id'] > 0) {
            $this->updateCoupons($this->postedData['id']);
            mainframe :: setSuccess('Coupon information saved successfully.');

            if ($_POST['saveexit'])
                $this->__doRedirect(mainframe::__adminBuildUrl('coupons'));
            else
                $this->__doRedirect(mainframe::__adminBuildUrl('coupons/addnew'));
        }
        else {
            if ($this->saveCoupons()) {
                mainframe :: setSuccess('Coupon information saved successfully.');
                if ($_POST['saveexit'])
                    $this->__doRedirect(mainframe::__adminBuildUrl('coupons'));
                else
                    $this->__doRedirect(mainframe::__adminBuildUrl('coupons/addnew'));
            }
            else {
                mainframe :: setError('Coupon information could not saved. Please try again.');
                $this->arrayData = $this->filterPostedData();
                $this->loadView('couponsform');
            }
        }
    }

    private function loadView($template = 'listview') {
        include($template . '.php');
    }

}
