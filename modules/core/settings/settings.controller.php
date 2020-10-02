<?php
class settings extends settingsModel {
  private $couponId;
  public $socialMediaData;
  private $editThemeTranslateId=0;
  private $objTrans;
  private $admin_templates;
        
	public function __Construct() {
		parent :: __Construct();
	}

	public static function adminMenuItems() {
    $menu_array = array(
        '<i class="icon icon-gear"></i> Settings' => array(
            'Basic Settings' => 'settings',
            'Email Settings' => 'settings/mail',
            'Admin Translation' => 'settings/translation',
            'Store Settings' => 'settings/store',
            'Social Media' => 'settings/socialmedia',
            'Admin Theme' => 'settings/theme',
            'Website Theme' => 'settings/websitetheme'
        )
    );
    return $menu_array;
  }

	public function index() {
		$this->listSystemConfig();
		$this->loadView('settings.tpl');
	}

	public function translation() {
		$this->labelsTranlation();
		$this->loadView('translation.tpl');
	}

	public function frontThemeTranslation() {
		$lang_id = intval($_REQUEST['lang_id']);
		$this->labelsFrontEndTranlation($lang_id);

		$this->loadView('front-translation.tpl');
	}

	public function editThemeTranslation() {
		$this->editThemeTranslateId = $_GET['translate_id'];
		$this->objTrans = $this->editThemelabel($this->editThemeTranslateId);
		$this->loadView('edit-translation.tpl');
	}

	public function savetranslation() {
		$this->saveLabelTranslation();
		 $this->__doRedirect(mainframe::__adminBuildUrl('settings/translation'));
	}

	public function saveFrontTranslation() {
		$this->saveFrontTranslationModel();
		$this->__doRedirect(mainframe::__adminBuildUrl('settings/frontThemeTranslation/lang_id/'.$_POST['lang_id']));
	}
    
  public function site() {
    $this->listSystemConfig();
		$this->loadView('settings.tpl');
	}
    
  public function mail() {
    $this->listSystemConfig();
		$this->loadView('mail.tpl');
	}
    
  public function store() {
    $this->listSystemConfig();
    $this->loadView('store.tpl');
	}

	public function theme() {
    $this->listSystemColorConfig();
    $template_dirs = scandir('templates/admin', 1);

    foreach ($template_dirs as $dir) {
    	if ($dir != './') {
	    	$file_lines = file('templates/admin/'.$dir.'/'.$dir.'.info');
	    	$this->admin_template[$dir] = [];
				foreach ($file_lines as $line) {
				  $name = $this->objFunction->get_string_between($line, 'name: ');
				  if (!empty($name)) {
				  	$this->admin_templates[$dir]['name'] = $name;
				  }

				  $preview = $this->objFunction->get_string_between($line, 'preview: ');
				  if (!empty($preview)) {
				  	$this->admin_templates[$dir]['preview'] = $preview;
				  }

				  $author = $this->objFunction->get_string_between($line, 'author: ');
				  if (!empty($author)) {
				  	$this->admin_templates[$dir]['author'] = $author;
				  }

				  $date = $this->objFunction->get_string_between($line, 'date: ');
				  if (!empty($date)) {
				  	$this->admin_templates[$dir]['date'] = $date;
				  }
				}
			}
    }
   	$this->loadView('admin-theme.tpl');
	}

	public function menus() {
		$this->loadView('menus.tpl');
	}

	public function websitetheme() {
		$this->listSystemConfig();
		$this->loadView('website-theme.tpl');
	}

	public function savewebsitetheme() {
    $this->saveSiteSettings();
    $this->__doRedirect(mainframe::__adminBuildUrl('settings/websitetheme'));
	}

	public function save() {
        $admin_logo = 'logo.png';
        if (!empty($_FILES['admin_logo']['tmp_name'])) {
            $admin_logo = $_FILES['admin_logo']['name'];
           move_uploaded_file($_FILES['admin_logo']['tmp_name'], SITE_UPLOADPATH.'admin/'.$admin_logo); 
           $_POST['config']['admin_logo'] = $admin_logo;
        }
        $this->saveSettings();
        $action = $_POST['method'];
        $this->__doRedirect(mainframe::__adminBuildUrl('settings/'.$action));
	}

	private function loadView($template = 'listview') {
		include('views/'.$template.'.php');
	}
        
  public function socialMedia(){
    $this->socialMediaData = $this->getAllSocialMedia();
    $this->loadView('socialMedia.tpl');
  }
  public function saveSocialMedia(){
    $this->saveSocialMediaDetails();
    $this->__doRedirect(mainframe::__adminBuildUrl('settings/socialMedia'));
      
  }
  public function deleteSocialMedia(){
    $id = $_GET['id'];
    $this->deleteSocialMediaRecord($id);
    $this->__doRedirect(mainframe::__adminBuildUrl('settings/socialMedia'));
  }
}
