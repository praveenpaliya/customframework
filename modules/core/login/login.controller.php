<?php
class login extends loginModel {
	public function __Construct() {
		parent :: __Construct();
	}

	public function index() {
		if (isset($_SESSION['adminLogin'])) {
			$this->__doRedirect(mainframe::__adminBuildUrl('dashboard'));
		}
		
		if (!empty($this->postedData)) {
			if ($this->checkLogin()) {
				$this->__doRedirect(mainframe::__adminBuildUrl('dashboard'));
			}
			else {
				mainframe :: setError('Invalid username/password. Try Again!');
			}
		}

		mainframe :: showHeader(0);
		mainframe :: showFooter(0);
		mainframe :: showMenu(0);
		$this->loadView('admin-login');
	}

  public function logoutadmin() {
    unset($_SESSION['adminLogin']);
    $this->__doRedirect(mainframe::__adminBuildUrl('login'), 'topredirect');
  }

	private function loadView($tpl) {        
		include('views/'.$tpl.'.php');
	}
        
  /**
    * @uses Method is used to the admin profile
  */
  public function MyProfile() {
    $this->getAdminDetails($_SESSION['adminLogin'][0]->id);
    $this->loadView('profileform');
  }

  /**
   * @uses Method is used for Update admin profile
   */
  public function updateProfile(){
    $this->updateAdminRecord($_POST['id']);
    $this->getAdminDetails($_SESSION['adminLogin'][0]->id);
    $_SESSION['adminLogin'][0] = $this->adminData;
    mainframe :: setSuccess('Updated sucessfully.');
    $this->__doRedirect(mainframe::__adminBuildUrl('login/MyProfile'));
  }

	private function loadTheme($tpl) {		
		if(file_exists("templates/admin/".SITE_THEME."/views/".$tpl.".php")) {
		  include("templates/admin/".SITE_THEME."/views/".$tpl.".php");
		}
		elseif(file_exists("modules/vendor/login/views/views/".$tpl.".php")) {
		  include("modules/vendor/login/front/views/".$tpl.".php");
		}
		else {
		  include('views/'.$tpl.'.php');
		}
	}

}
