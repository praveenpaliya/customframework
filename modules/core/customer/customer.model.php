<?php

class customerModel extends ISP {

    public $userData;
    public $arrayData;
    public $customerGroup;
    protected $customerFields;
    protected $customerShippingAdd;

    public function __construct() {
        parent :: __construct();
        $this->getCustomerGroup();
        $this->customerFields = $this->listCustomerAttributes('customer');
    }

    protected function getReviews($limit=1) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "reviews order by review_date desc limit $limit";
        return $this->dbFetch($sql);
    }

    private function listCustomerAttributes($mod = 'customer') {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "attribute_fields where module='" . $mod . "' order by field_id asc";
        return $this->dbFetch($sql);
    }

    public function listCustomers($cgroup = 0) {
        $groupFilter = '';
        if ($cgroup > 0)
            $groupFilter = ' and g.id=3';

        $sql = "SELECT c.*, g.customer_group as customer_group_name FROM " . TABLE_PREFIX . "customer c inner join " . TABLE_PREFIX . "customer_group g on g.id=c.customer_group where 1=1 " . $groupFilter . " order by created_date desc";
        $this->userData = $this->dbFetch($sql);
    }

    public function getAttributeValue($customerId, $code) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "customer_entry where customer_id='" . $customerId . "' and field_code='" . $code . "'";
        $rows = $this->fetchRows($sql);
        return $rows->field_value;
    }

    protected function userLogin() {

        $sql = "SELECT u.* FROM " . TABLE_PREFIX . "customer u where u.email='" . trim($_POST['email']) . "' and u.password='" . md5($_POST['pwd']) . "'";
        return $this->fetchRows($sql);
    }
    
    protected function checkUserEmail() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "customer u where u.email='" . trim($_POST['email']) . "'";
        $result = $this->fetchRows($sql);
        $this->arrayData = (array)$result;

        return (!empty($result)) ? true : false;
    }

    public function getCustomerGroup() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "customer_group";
        $this->customerGroup = $this->dbFetch($sql);
    }

    protected function updateAccountPassword() {
        $uid = $_SESSION['uid'];
        $newPassword = $_POST['new_password'];
        $oldPassword = $_POST['current_password'];

        $sql = "SELECT u.* FROM " . TABLE_PREFIX . "customer u where u.id='" . $uid . "' and u.password='" . md5($oldPassword) . "'";
        $objCustomer = $this->fetchRows($sql);

        if ($objCustomer->id > 0) {
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "customer set password='" . md5($newPassword) . "' where id='" . $uid . "'");
            return true;
        } else {
            return false;
        }
    }

    public function getCustomer($cId) {
        $sql = "SELECT u.*, a.* FROM " . TABLE_PREFIX . "customer u inner join " . TABLE_PREFIX . "addresses a on u.id=a.customer_id where u.id='" . $cId . "' AND type='billing'";
        $this->arrayData = (array) $this->fetchRows($sql);
       // print_r( $this->arrayData);die;
    }

    public function getCustomerShippingAdd($cId) {
        $sql = "SELECT u.*, a.* FROM " . TABLE_PREFIX . "customer u inner join " . TABLE_PREFIX . "addresses a on u.id=a.customer_id where u.id='" . $cId . "' AND type='shipping'";
        $this->customerShippingAdd = (array) $this->fetchRows($sql);
    }

    protected function saveCustomer() {        
        $intCid = $this->insertForm(TABLE_PREFIX . "customer");

        if ($intCid) {

            //$this->insertForm(TABLE_PREFIX . "addresses");
            if (!empty($this->postedData['billing'])) {
                $_POST = $this->postedData['billing'];
                $_POST['db_customer_id'] = $intCid;
                $this->insertForm(TABLE_PREFIX . "addresses");
            }

            if (!empty($this->postedData['shipping'])) {
                $_POST = $this->postedData['shipping'];
                $_POST['db_type'] = 'shipping';
                $_POST['db_customer_id'] = $intCid;
                $this->insertForm(TABLE_PREFIX . "addresses");
            }

            if (!empty($this->postedData['customer']['vat_registration'])) {
                foreach ($this->postedData['customer'] as $field_code => $field_value) {
                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "customer_entry (customer_id, field_code, field_value) VALUES('" . $intCid . "', '" . $field_code . "', '" . $field_value . "')");
                }
            }

            return $intCid;
        } else
            return false;
    }

    protected function updateCustomer($cId, $addressId) {
        if(!empty($_POST['new_password'])){
            $_POST['db_password'] = $_POST['new_password'];
        }
        $this->updateForm(TABLE_PREFIX . "customer", $cId, 'id');
        

        if (!empty($this->postedData['billing'])) {
            $_POST = $this->postedData['billing'];
            $_POST['db_customer_id'] = $cId;
            $this->dbQuery("DELETE from " . TABLE_PREFIX . "addresses where type='billing' and customer_id='" . $cId . "'");
            $this->insertForm(TABLE_PREFIX . "addresses");
        }

        if (!empty($this->postedData['shipping'])) {
            $_POST = $this->postedData['shipping'];
            $_POST['db_type'] = 'shipping';
            $_POST['db_customer_id'] = $cId;
            $this->dbQuery("DELETE from " . TABLE_PREFIX . "addresses where type='shipping' and customer_id='" . $cId . "'");
            $this->insertForm(TABLE_PREFIX . "addresses");
        }

        if (!empty($this->postedData['customer'])) {
            foreach ($this->postedData['customer'] as $field_code => $field_value) {
                $this->dbQuery("UPDATE " . TABLE_PREFIX . "customer_entry SET field_value='" . $field_value . "' WHERE customer_id='" . $cId . "' AND field_code='" . $field_code . "'");
            }
        }
    }

    /**
     * @uses Method used to delete customer data
     * @author Praveen Paliya
     * @date 28.6.2017
     */
    protected function deleteCustomer($custId) {
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "customer WHERE id='" . $custId . "'");
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "addresses WHERE customer_id='" . $custId . "'");
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "customer_entry WHERE customer_id='" . $custId . "'");
    }

    protected function customerStatusUpdate($status, $cId) {
        $this->dbQuery("UPDATE " . TABLE_PREFIX . "customer set status='".$status."' WHERE id='" . $cId . "'");
        $sql = "SELECT u.* FROM " . TABLE_PREFIX . "customer u where u.id='" . $cId . "'";
        return $this->fetchRows($sql);
    }

    protected function changeCustomerPassword($password, $email) {
        $this->dbQuery("UPDATE " . TABLE_PREFIX . "customer set password=md5('".$password."') WHERE email='" . $email . "'");
    }

}
