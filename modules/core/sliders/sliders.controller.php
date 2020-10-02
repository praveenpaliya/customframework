<?php
class sliders extends slidersModel {
	private $slidersId;
	public function __Construct() {
		parent :: __Construct();
		$this->slidersId = 0;
	}

    public static function adminMenuItems() {
    $menu_array = array(
        '<i class="icon icon-film"></i> Sliders' => array(
            'All Sliders' => 'sliders',
            'Add New Slider' => 'sliders/addnew'
        )
    );
    return $menu_array;
  }

	public function index() {
		$this->listSliders();
		$this->loadView();
	}

	public function addnew() {
		$this->loadView('admin/slidersform');
	}

	public function edit() {
		$gId = intval($_GET['id']);
		if($gId >0) {
			$this->slidersId = $gId;
			$this->getSliders($gId);
			$this->loadView('admin/slidersform');
		}
		else {
			$this->__doRedirect(mainframe::__adminBuildUrl('sliders'));	
		}
	}

	public function callShortCode($args) {
		$func = $args['call'];
		$id = $args['id'];
		$limit = $args['limit'];

		if ($func <>"") {
			$this->$func();
		}
		else {
			$this->getSliders($id);
		}
		
		$this->loadTheme('slideshow');
	}

    public function delete() {
        $gId = intval($_GET['id']);
        $this->deleteSliders($gId);
        mainframe :: setSuccess('Sliders Deleted successfully.');
     	$this->__doRedirect(mainframe::__adminBuildUrl('sliders'));
    }

	public function save() {
        
        if ($this->postedData['id']>0) {
                $this->updateSliders($this->postedData['id']);
                mainframe :: setSuccess('Sliders information saved successfully.');
                if($_POST['saveexit'])
                        $this->__doRedirect(mainframe::__adminBuildUrl('sliders'));
                else
                        $this->__doRedirect(mainframe::__adminBuildUrl('sliders/addnew'));
        }
        else {
                if ($this->saveSliders()) {
                        mainframe :: setSuccess('Sliders information saved successfully.');
                        if($_POST['saveexit'])
                                $this->__doRedirect(mainframe::__adminBuildUrl('sliders'));
                        else
                                $this->__doRedirect(mainframe::__adminBuildUrl('sliders/addnew'));
                }
                else {
                        mainframe :: setError('Sliders information could not saved. Please try again.');
                        $this->arrayData = $this->filterPostedData();
                        $this->loadView('admin/slidersform');
                }
        }
	}
        
        public function deleteSlide(){
            $this->deleteSlideDetails($_POST['slide_id']);
            die;
        }

        private function loadView($template = 'admin/listview') {
		include('views/'.$template.'.php');
	}

	private function loadTheme($tpl) {		
        if(file_exists("templates/front/".SITE_THEME."/views/".$tpl.".php")) {
            include("templates/front/".SITE_THEME."/views/".$tpl.".php");
        }
        elseif(file_exists("modules/vendor/sliders/front/views/".$tpl.".php")) {
            include("modules/vendor/sliders/front/views/".$tpl.".php");
        }
        else {
            include('views/front/'.$tpl.'.php');
        }
    }
}
