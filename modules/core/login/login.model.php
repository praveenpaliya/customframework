<?php
class loginModel extends ISP {
	public $userData;

	public function __construct() {
		parent :: __construct();
	}

	protected function checkLogin() {
		$username = $this->postedData['username'];
		$password = md5($this->postedData['password']);
		$sql = "SELECT * FROM ".TABLE_PREFIX."admin where email='$username' and password='$password'";
		$this->userData = $this->dbFetch($sql);
    if(count($this->userData)==1)
      $this->setAdminLogin($this->userData);
		return count($this->userData);
	}
        
  /**
  * @uses Method is used for add a admin
  */
  protected function updateAdminRecord($id) {
    $this->updateForm(TABLE_PREFIX . "admin", $id);
  }

  /**
  * @uses Method is used to get individual admin details
  */
  protected function getAdminDetails($id) {
    $this->adminData = $this->fetchRows("SELECT * from " . TABLE_PREFIX . "admin where id= '{$id}'");
  }
}