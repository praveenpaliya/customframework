<?php

class customer extends customerModel {

    private $customerId;
    private $allInvoices;
    private $countries;
    private $orderData;
    private $subscriptionData;
    private $subsciptionProductData;
    private $limit = 1;
    private $objMainframe;

    public function __Construct() {
        global $objMainframe;
        $this->objMainframe = $objMainframe;
        parent :: __Construct();
        $this->customerId = 0;
        $this->countries = $this->getAllCountries();
    }
    
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-user"></i> Customers' => array(
                'All Customers' => 'customer',
                'Add New Customer' => 'customer/addnew'
            )
        );
        return $menu_array;
    }

    public function index() {
        $this->isAdminLogin();
        $this->listCustomers();
        $this->loadView();
    }

    public function activate() {
        $objProfile = $this->customerStatusUpdate(1, $_GET['id']);
        if ($objProfile->password == "") {
            $newPassword = $this->randomPassowrd(6);
            $receipent = $objProfile->email;
            $subject = "EternityLetter :: Distributor account activated";
            $message = "<p>Welcome ".$objProfile->first_name."</p><p>We'd like to welcome you to the Eternity Letter Distribution Program.</p><p>You now have access to our Distributor Portal and can access special pricing for our Eternity Letter products.</p><p>Please see your login information below.<br>Link:&nbsp;<a href='https://www.eternityletter.com' target='_blank'>https://www.eternityletter.com</a> <br>Login:&nbsp;".$receipent."<br>Password: ".$newPassword."</p><p>If you have any questions or concerns don't hesitate to reach out to us and we will follow up promptly.</p><p>Thank you for your interest in Eternity Letter and our family of special products.</p>";

            $this->changeCustomerPassword($newPassword, $receipent);
            $this->mosMail($receipent, $subject, $message);
        }
        mainframe :: setSuccess('Customer Profile has been activated successfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('customer'));
    }

    public function deactivate() {
        $this->customerStatusUpdate(0, $_GET['id']);
        mainframe :: setSuccess('Customer Profile has been deactivated successfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('customer'));
    }

    private function reviewswidget() {
        $this->arrayData = $this->getReviews($this->limit);
        $this->codeTitle = '';
        $this->loadTheme('reviews-widget');
    }

    public function callShortCode($args) {
        $this->args = $args;

        $func = $args['call'];
        $id = $args['id'];
        $this->limit = $args['limit'];

        if ($func <> "") {
            $this->$func();
        }
    }

    public function getAttribute($pid, $code) {
        return $this->getAttributeValue($pid, $code);
    }

    public static function getCustomerId() {
        if (!empty($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
        } else {
            $uid = session_id();
        }
        return $uid;
    }

    public function addnew() {
        $this->isAdminLogin();
        $this->loadView('customerform');
    }

    public function edit() {
        $this->isAdminLogin();

        $cId = intval($_GET['id']);
        if ($cId > 0) {
            $this->customerId = $cId;
            $this->getCustomer($cId);
            $this->getCustomerShippingAdd($this->customerId);
            $this->loadView('customerform');
        } else {
            $this->__doRedirect(mainframe::__adminBuildUrl('customer'));
        }
    }

    public function editprofile() {
        $this->checkCustomerSession();

        $this->customerId = $_SESSION['uid'];
        $this->getCustomer($this->customerId);
        //$this->objMainframe->setPageHeading('My Account');
        $this->loadTheme('customerprofile');
    }

    public function invoices() {
        $this->checkCustomerSession();

        $this->customerId = $_SESSION['uid'];
        $orderObj = new orders();
        $orderObj->getAllInvoices($this->customerId);
        $this->allInvoices = $orderObj->allInvoices;
        $this->loadTheme('customerinvoice');
    }

    public function login() {
        //$this->objMainframe->setPageHeading('Customer Login/Register');
        if ($_SESSION['customer_group'] != 1) {
            $this->loadTheme('customer-login');
        }

        if($_SESSION['customer_group'] == 4 ||  $_SESSION['customer_group'] == 1) {
            $this->__doRedirect(SITE_URL . 'customer/editprofile');
        }
    }

    public function distributor() {
        //$this->objMainframe->setPageHeading('Distributor Login/Register');
        if ($_SESSION['customer_group'] != 4 ) {
            $this->loadTheme('distributor-login');
        }
    }

    public function dologin() {
        $objUser = $this->userLogin();
        if (intval($objUser->id) == 0) {
            mainframe::setError("Invalid Login Information.");
            $this->loadTheme('customer-login');
        } else {
            $_SESSION['uid'] = $objUser->id;
            $_SESSION['customer_group'] = $objUser->customer_group;

            if ($_POST['redirect_to'] == "")
                $this->__doRedirect(SITE_URL . 'customer/editprofile');
            else
                $this->__doRedirect(SITE_URL . ltrim(base64_decode($_POST['redirect_to']), "/"));
        }
    }

    public function dodistributorlogin() {
        $objUser = $this->userLogin();
        if (intval($objUser->id) == 0) {
            mainframe::setError("Invalid Login Information.");
            $this->loadTheme('distributor-login');
        } else {
            $_SESSION['uid'] = $objUser->id;
            $_SESSION['customer_group'] = $objUser->customer_group;

            if ($_POST['redirect_to'] == "")
                $this->__doRedirect(SITE_URL . 'customer/editprofile');
            else
                $this->__doRedirect(SITE_URL . ltrim(base64_decode($_POST['redirect_to']), "/"));
        }
    }
    
    public function logout() {
        session_destroy();
        $this->__doRedirect(SITE_URL . 'customer/login');
    }
    
    public function doforgot() {
        if ($this->checkUserEmail()) {
            $newPassword = $this->randomPassowrd(6);
            $receipent = trim($_POST['email']);
            $subject = "Eternityletter :: Reset Password";

            $message = "<p>Dear ".$this->arrayData['first_name']."</p><p>You recently requested to reset your password of www.Eternityletter.com</p><p>Your new password is <b>".$newPassword."</b></p>";

            $this->changeCustomerPassword($newPassword, $receipent);
            $this->mosMail($receipent, $subject, $message);

            mainframe :: setSuccess('New Pasword has been sent to your email address.');
            $this->__doRedirect(SITE_URL . 'customer/login');
        } else {
           mainframe::setError("Email is not registerd!.");
           $this->__doRedirect(SITE_URL . 'customer/login');
        }
    }


    public function orderhistory() {
        $this->checkCustomerSession();
        //$this->objMainframe->setPageHeading('My Orders');
        $this->loadTheme('orderhistory');
    }

    public function changepassword() {
        $this->checkCustomerSession();
        //$this->objMainframe->setPageHeading('Change Password');
        $this->loadTheme('changepassword');
    }

    public function updatepass() {
        $this->checkCustomerSession();

        $bol = $this->updateAccountPassword();
        if ($bol == false) {
            mainframe::setError("Old Password is not correct. Please try again!");
            $this->changepassword();
        } else {
            mainframe::setSuccess("Your Password has been changed successfully.");
            $this->changepassword();
        }
    }

    public function myaccount() {
        $this->checkCustomerSession();

        $this->editprofile();
    }
    
    public function getMySubscriptionDetails(){
        $objSubscription = new subscription();
        $objSubscription->viewSubscriptionDetails();
    }
    
    public function unsubscribeProduct(){
        $id = $_GET['id'];
        $objSubscription = new subscription();
        $objSubscription->unsubscribeProduct($id);

        $this->__doRedirect(SITE_URL . 'customer/myaccount');
    }
    

    public function doregister() {
        $customerGroup = $_POST['md_customer_group'];
        $customerId = $this->saveCustomer();
        if (intval($customerId) == 0) {
            mainframe::setError("Email already exists in system. Please enter any other email or reset your password.");

            if ($customerGroup == 4) {
                $this->__doRedirect('/customer/distributor/sreg/1');
            }
            else {
                $this->__doRedirect('/customer/login/sreg/1');
            }
        } else {

            $receipent = trim($_REQUEST['md_email']);

            if ($customerGroup == 4) {

                /* Send Email to Admin*/
                $dist_reg_email = $this->loadEmailTemplate('modules/core/customer/views/email/distributor_registration_admin');
                $admin_dis_link = $this->AdminUrl('customer/edit/id/'.$customerId);
                $admin_dist_profile_link = '<a href="'.$admin_dis_link.'" target="_blank">'.$admin_dis_link.'</a>';
                $dist_reg_email = str_replace("[admin_distributor_profile_link]", $admin_dist_profile_link , $dist_reg_email);

                $this->mosMail(MAIL_ADMIN, 'New Distributor Registered', $dist_reg_email);

                //Send Email to Distributor
                $emailBody ='<p>Dear '.$_REQUEST["md_first_name"].' '.$_REQUEST["md_last_name"]. '</p><p>Thank you for taking the time to register as Authorized Distributor with Eternity Letter, LLC.</p><p>We will review your registration shortly and if approved, you will receive your individual login credentials and instructions on how to access our Distribution Portal.</p><p>We generally review applications within 24 hours and will keep you updated.<br>Again, we greatly appreciate your interest in our uniquely positive products and we\'ll be back shortly with an update.</p>';
                $this->mosMail($receipent, 'Welcome to Eternityletter', $emailBody);

                $this->__doRedirect(SITE_URL . 'distributor-account-pending');
            }
            else {

                $subject = "Welcome to Eternityletter";
                $message = "Dear ".$_REQUEST['md_first_name']." ".$_REQUEST['md_last_name']."<br><br>You have been successfully registered with Eternity Letter.<br><br>Enjoy Shopping with us!<br><br><br>Regards<br>Eternity Letter<br><br>";
                $this->mosMail($receipent, $subject, $message);

                $_SESSION['uid'] = $customerId;
                mainframe :: setSuccess('You have successfully registered with us!');

                if ($_POST['redirect_to'] == "")
                    $this->__doRedirect(SITE_URL . 'customer/myaccount');
                else
                    $this->__doRedirect(SITE_URL . ltrim(base64_decode($_POST['redirect_to']), "/"));
            }
        }
    }

    public function save() {
        $this->isAdminLogin();

        if ($this->postedData['id'] > 0) {
            $this->updateCustomer($this->postedData['id'], $this->postedData['address_id']);

            mainframe :: setSuccess('Customer information saved sucessfully.');
            $this->__doRedirect(mainframe::__adminBuildUrl('customer'));
        }
        else {
            $_POST['email'] = $_POST['md_email'];
            if (! $this->checkUserEmail()) {
                $this->saveCustomer();
                $this->__doRedirect(mainframe::__adminBuildUrl('customer'));
            }
            else {
                mainframe :: setSuccess('Customer Email or MPIN already exists.');
                $this->arrayData = $this->filterPostedData();
                $this->loadView('customerform');
            }
        }
    }
    public function saveCustProfile() {
//        echo '<pre>';print_r($this->postedData);die;
        if ($this->postedData['id'] > 0) {
            $this->updateCustomer($this->postedData['id'], $this->postedData['address_id']);
            mainframe :: setSuccess('Customer information saved sucessfully.');
            $this->__doRedirect(SITE_URL . 'customer/editprofile');
            
        }
    }

    private function loadView($template = 'listview') {
        $this->checkAdminSession();
        include('views/admin/' . $template . '.php');
    }

    private function loadTheme($tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/customer/front/views/" . $tpl . ".php")) {
            include("modules/vendor/customer/front/views/" . $tpl . ".php");
        } else {
            include('modules/core/customer/views/front/' . $tpl . '.php');
        }
    }

    /**
     * @uses Method used to delete customer data
     * @author Praveen Paliya
     * @date 28.6.2017
     */
    public function delcustomer() {
        $custId = $_GET['id'];
        $this->deleteCustomer($custId);
        mainframe :: setSuccess('Customer deleted sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('customer'));
    }

}
