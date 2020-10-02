<?php
class mainframe extends ISP {
  private  $outputBuffer;
  public static  $title;
  public static  $keywords;
  public static  $description;
  public static  $pageTitle;

  public static  $breadcrumTitle = array();
  public static $pageBanner = 'templates/front/default/img/slider1.jpg';
  public static $og_meta = array();
  public  $incRight;
  private $incTop;
  public  $incLeft;
  private $incFooter;
  private $cssFiles = array();
  private $jsFiles = array();
  private $customCss = array();
  private $customJs = array();
  private $controller;
  private $action;
  public static $header = 1;
  public static $footer = 1;
  public static $menu = 1;
  public static $isHome = 0;
  public static $errorMessage;  
  public static $successMessage;
  private $themeCss = array();
  private $themeJs = array();
  public static $adminMenuItems = array();
  private $dbconn;

  public function __construct($dbconnection) {
    $this->dbconn = $dbconnection;
    parent ::__construct();
    $this->incRight = '';
    $this->incLeft  = '';
    $this->incTop   = '';
    $this->cssFiles[] = 'assets/bootstrap/bootstrap.css';
  }

  public static function buildAdminMenu($objDbConn) {
    $active_modules = $objDbConn->iFindAll(TABLE_PREFIX.'modules','','','status=1');
      foreach($active_modules as $module) {
          if (method_exists($module->module_name, 'adminMenuItems')) {
             $classModule = $module->module_name;
             $moduleAdminItems = $classModule::adminMenuItems();
             self::$adminMenuItems = array_merge(self::$adminMenuItems, $moduleAdminItems); 
          }
      }
  }
  
  public static function showAdminMenuUlList($menuItems, $ul_attrib='', $data_toggle_id='') {
      if (!empty($ul_attrib)) {
          foreach ($ul_attrib as $key=>$val) {
              $attribues .= $key.'="'.$val.'"';
          }
      }
      
      echo '<ul '.$attribues.'>';
      foreach ($menuItems as $key=>$item) {
          if (is_array($item)) {
              $toggle_id = rand(0, 100000);
              $child_ul = array('class'=>'sub-menu collapse', 'id'=>$toggle_id);
              echo '<li><a href="javascript: void(0);" data-toggle="collapse" data-target="#'.$toggle_id.'"><span class="nav-label">'.$key.'</span></a>';
              self :: showAdminMenuUlList($item, $child_ul, $toggle_id);
              echo '</li>';
          }
          else {
              echo '<li><a href="'.self::__adminBuildUrl($item).'"><span class="nav-label">'.$key.'</span></a></li>';
          }
      }
      echo '</ul>';
  }
      


  public function setController($controller) {
      $this->controller = $controller;
  }

  public function setAction($action) {
    if($action=='')
      $action='index';

    $this->action = $action;
  }

  public static function showHeader($setHeader=1) {
      self::$header = $setHeader;
  }

  public static function setError($message) {
      $_SESSION['errorMessage'] = $message;
      self :: $errorMessage = $message;
  }

  public static function showError() {
    if (!empty($_SESSION['errorMessage'])) {
      echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$_SESSION['errorMessage'].'</div>';

      unset($_SESSION['errorMessage']);
    }
    
  }

  public static function setSuccess($message) {
      $_SESSION['successMessage'] = $message;
      self :: $successMessage = $message;
  }

  public static function setHomePage($istrue) {
    self :: $isHome = $istrue;
  }

  public static function isHome() {
    return self :: $isHome;
  }

  public static function setPageBanner($banner) {
    if ($banner <> '')
      self :: $pageBanner = SITE_UPLOADPATH.$banner;
  }

  public static function getPageBanner() {
    return self :: $pageBanner;
  }

  public static function showSuccess() {
    if (!empty($_SESSION['successMessage']))
      echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$_SESSION['successMessage'].'</div>';
      unset($_SESSION['successMessage']);
  }

  public static function showFooter($setFooter=1) {
      self::$footer = $setFooter;
  }

  public static function showMenu($setMenu=1) {
      self::$menu = $setMenu;
  }

  public function getController() {
    return $this->controller;
  }

  public function getAction() {
    return $this->action;
  }

  public static  function setPageTitle( $strTitle = '' ) {
    self::$title = $strTitle;
  }

  public static  function setPageHeading( $strTitle = '' ) {
    self::$pageTitle = $strTitle;
  }

  public static function setBreadCrumTitle($title='', $link='') {
    self::$breadcrumTitle[$link] = $title;
  }

  public static function resetBreadCrum() {
    unset(self::$breadcrumTitle);
  }

  public static function getBreadcrumTitle() {
    return self::$breadcrumTitle;
  }

  public static  function setMetaKeywords( $keywords = '' ) {
    self::$keywords = $keywords;
  }

  public static function setOgMetaTags($og_array) {
    foreach ($og_array as $key=>$value) {
      self :: $og_meta[] = '<meta property="'.$key.'" content="'.$value.'">';
    }
  }

  public static function getOgMetaTags() {
    $metas = self :: $og_meta;
    if (count($metas) > 0) {
      foreach ($metas as $value) {
        echo $value;
      }
    }

  }

  public static  function setMetaDescription( $description = '' ) {
    self::$description = $description;
  }

  public static  function getPageTitle() {
    if ( self::$title == "" )
      self::$title = SITE_NAME;
    
    echo '<title>' . self::$title . '</title>';
  }

  public static  function getMetaKeywords( )
  {
    echo '<meta name="keywords" content="' . self::$keywords . '">';
  }

  public static  function getMetaDescription( )
  {
    if ( self::$description == "" )
      self::$description = META_DESCRIPTION;
    echo '<meta name="description" content="' . self::$description . '">';
  }

  public function mosHead( )
  {
    $this->getPageTitle();
    $this->getMetaKeywords();
    $this->getMetaDescription();
  }

  public function addCss($filename) {
  	if(is_array($filename)) {
  		foreach($filename as $file) {
  			if(file_exists("assets/css/front/".$file)) {
  				$this->cssFiles[] = "assets/css/front/".$file;
  			}

        if(file_exists("assets/".$file)) {
            $this->cssFiles[] = "assets/".$file;
        }

  		}
  	}
  	else {
  		if(file_exists("assets/css/front/".$filename)) {
  			$this->cssFiles[] = "assets/css/front/".$filename;
  		}
  	}
  	
  }

  public function addAdminCss($filename) {
  	if(is_array($filename)) {
  		foreach($filename as $file) {
  			if(file_exists("assets/css/admin/".$file)) {
  				  $this->cssFiles[] = "assets/css/admin/".$file;
  			}

        if(file_exists("assets/".$file)) {
            $this->cssFiles[] = "assets/".$file;
        }

  		}
  	}
  	else {
  		if(file_exists("assets/css/admin/".$filename)) {
  			$this->cssFiles[] = "assets/css/admin/".$filename;
  		}
  	}
  }

  public function addJs($filename, $where='head') {
  	if(is_array($filename)) {
  		foreach($filename as $file) {
  			if(file_exists($file)) {
  				$this->jsFiles[$where][] = $file;
  			}
  		}
  	}
  	else {
  		if(file_exists($filename)) {
  			$this->jsFiles[$where][] = $filename;
  		}
  	}

  }

  public function loadCss($isAdmin=false) {
  	$cssContent = "";
  	$cssName = 'custom.css';
  	if ($isAdmin)
  		$cssName = 'admin.css';
  	
  	if (!empty($this->cssFiles)) {
		    foreach ($this->cssFiles as $cssFile) {
		        $cssContent .= file_get_contents($cssFile);
		    }
	  }

  	if($cssContent<>'') {
  		if (file_exists("var/".SITE_THEME."/css/".$cssName)) {
  			$lastUpdated = filemtime ("var/".SITE_THEME."/css/".$cssName);
  			if (time()-$lastUpdated > 24*3600) {
  				unlink("var/".SITE_THEME."/css/".$cssName);
  				file_put_contents("var/".SITE_THEME."/css/".$cssName,$cssContent);
  			}
  		}
  		else {
  			file_put_contents("var/".SITE_THEME."/css/".$cssName,$cssContent);
  		}
  		echo '<link href="'.SITE_URL.'var/'.SITE_THEME.'/css/'.$cssName.'" rel="stylesheet"/>';
  	}

    if(count($this->customCss) >0) {
      foreach($this->customCss as $cssFile) {
          echo '<link href="'.SITE_URL.$cssFile.'" rel="stylesheet"/>';
      }
    }
  }

  public function loadJs($key, $isAdmin=false) {
  	$jsContent = "";
  	$jsName = $key.'.js';
  	
    if ($isAdmin)
  		$jsName = 'admin_'.$key.'.js';

    	if (!empty($this->jsFiles[$key])) {
  		  foreach ($this->jsFiles[$key] as $jsFile) {
  	    	$jsContent .= file_get_contents($jsFile);
  		  }
  	  }

    	if(trim($jsContent)<>'') {
    		if (file_exists("var/".SITE_THEME."/js/".$jsName)) {
    			$lastUpdated = filemtime ("var/".SITE_THEME."/js/".$jsName);
    			//if (time()-$lastUpdated > 24*3600) {
    				unlink("var/".SITE_THEME."/js/".$jsName);
    				file_put_contents("var/".SITE_THEME."/js/".$jsName,$jsContent);
    			//}
    		}
    		else {
    			file_put_contents("var/".SITE_THEME."/js/".$jsName,$jsContent);
    		}
    		echo '<script src="'.SITE_URL.'var/'.SITE_THEME.'/js/'.$jsName.'?t='.mktime().'" type="text/javascript"></script>';
    	}

      if ($key == 'footer') {
        if(count($this->customJs) >0) {
          foreach($this->customJs as $jsFile) {
             echo '<script src="'.SITE_URL.$jsFile.'?t='.mktime().'" type="text/javascript"></script>';
          }
        }
     }
  }

  public function mosBody( ){
    echo $this->outputBuffer;
  }
  

  public function loadSection($strPosition, $isAdmin=0) {
      $path = 'templates/';

      if($isAdmin==1) {
          $path = 'templates/admin/'.ADMIN_THEME.'/';
      }

      if (self::$$strPosition == 1)
          include($path.$strPosition.'.inc.php');
  }

  public function loadBody() {
    return $this->outputBuffer;
  }

  public function setPage($htmlBody) {
    $this->outputBuffer = $htmlBody;
  }

  public static function __adminBuildUrl($tmpLink) {
      //if ( VC_SEF == 1 ):
        //return SITE_ADMINURL . $tmpLink;
    //else:
        return SITE_URL.'index.php/'.ADMIN_PATH.'/'.$tmpLink;
    //endif;
  }
  
  public static function __BuildUrl($tmpLink) {
      if ( VC_SEF == 1 ):
        return SITE_URL . $tmpLink;
    else:
        return SITE_URL.'index.php/'.$tmpLink;
    endif;
  }

  public function addThemeCss($cssFile) {
      if(file_exists('templates/front/'.SITE_THEME.'/'.$cssFile)) {
          $this->themeCss[] = 'templates/front/'.SITE_THEME.'/'.$cssFile;
      }
  }

  public function loadThemeCss() {
      $cssName = 'theme.css';

        if (!empty($this->themeCss)) {
            foreach ($this->themeCss as $cssFile) {
                $cssContent .= file_get_contents($cssFile);
            }
        }

        if($cssContent<>'') {
          if (file_exists("var/".SITE_THEME."/css/".$cssName)) {

            $lastUpdated = filemtime ("var/".SITE_THEME."/css/".$cssName);

            if (time()-$lastUpdated > 24*3600) {
              unlink("var/".SITE_THEME."/css/".$cssName);
              file_put_contents("var/".SITE_THEME."/css/".$cssName,$cssContent);
            }
          }
          else {
            file_put_contents("var/".SITE_THEME."/css/".$cssName,$cssContent);
          }
          echo '<link href="'.SITE_URL.'var/'.SITE_THEME.'/css/'.$cssName.'" rel="stylesheet"/>';
        }   

      $this->themeCss = array();
  }

  public function addThemeJs($jsFile) {
      if(file_exists('templates/front/'.SITE_THEME.'/'.$jsFile)) {
          $this->themeJs[] = 'templates/front/'.SITE_THEME.'/'.$jsFile;
      }
  }

    public function loadThemeJs($prefix='') {
        $jsName = $prefix.'theme.js';

        if (!empty($this->themeJs)) {
            foreach ($this->themeJs as $jsFile) {
                $jsContent .= file_get_contents($jsFile);
            }
        }

        if($jsContent<>'') {
          if (file_exists("var/".SITE_THEME."/js/".$jsName)) {

            $lastUpdated = filemtime ("var/".SITE_THEME."/js/".$jsName);

            if (time()-$lastUpdated > 24*3600) {
              unlink("var/".SITE_THEME."/js/".$jsName);
              file_put_contents("var/".SITE_THEME."/js/".$jsName,$jsContent);
            }
          }
          else {
            file_put_contents("var/".SITE_THEME."/js/".$jsName,$jsContent);
          }
          echo '<script type="text/javascript" src="'.SITE_URL.'var/'.SITE_THEME.'/js/'.$jsName.'"></script>';
        }   

        $this->themeJs = array();
    }


    
    private function requestIsAjax() {
        $headers = getallheaders();
        foreach ($headers as $header => $value) {
            if ($header == 'ajax-process' && $value == true) {
                return true;
            }
        }
    }
    
    private function loadTemplate() {
        if(strstr($_SERVER['REQUEST_URI'],ADMIN_PATH)) { 
            require_once('templates/admin/'.ADMIN_THEME.'/adminindex.php');
        }
        else {
            require_once('templates/front/'.SITE_THEME.'/index.php');
        }
    }

  private function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
  }
  
  public function buildTheme() {
    if (ISP::is_ajax()) {
      $body_data = $this->loadBody();
      @header('Content-Type: application/json; charset=UTF-8');
      if ($this->isJson($body_data)) {
        echo $body_data;
      }
      else {
        $json_data = json_encode(array(
          'type' => 'body',
          'data' => $body_data 
        ));
        echo $json_data;
      }
    }
    else {
        if (strstr($_SERVER['REQUEST_URI'],ADMIN_PATH)) { 
            $this->addAdminCss(array('button.css', 'forms.css', 'styles.css'));
            //$this->customCss[] = 'assets/js/trumbowyg/dist/ui/trumbowyg.min.css';

            $this->addJs("assets/js/libs/jquery-1.10.2.min.js", 'head');
            $this->jsFiles['footer'][] = "bootstrap/js/bootstrap.min.js"; 
            /*
            $this->addJs("assets/js/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js", 'head');
            $this->jsFiles['footer'][] = "assets/js/jquery.bxslider.js";  
             
            $this->jsFiles['footer'][] = "assets/js/libs/lodash.compat.min.js"; 
            $this->jsFiles['footer'][] = "assets/js/libs/breakpoints.js"; 
            $this->jsFiles['footer'][] = "assets/js/plugins/respond/respond.min.js"; 
            $this->jsFiles['footer'][] = "assets/js/plugins/cookie/jquery.cookie.min.js";  
            $this->jsFiles['footer'][] = "assets/js/plugins/fullcalendar/fullcalendar.min.js";   
            $this->jsFiles['footer'][] = "assets/js/plugins/daterangepicker/moment.min.js";
            $this->jsFiles['footer'][] = "assets/js/plugins/daterangepicker/daterangepicker.js"; 
            $this->jsFiles['footer'][] = "assets/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js";  
            $this->jsFiles['footer'][] = "assets/js/plugins/blockui/jquery.blockUI.min.js"; 
            $this->jsFiles['footer'][] = "assets/js/plugins/pickadate/picker.js";
            $this->jsFiles['footer'][] = "assets/js/plugins/pickadate/picker.date.js"; 

            $this->jsFiles['footer'][] = "assets/js/plugins/uniform/jquery.uniform.min.js";  
            $this->jsFiles['footer'][] = "assets/js/plugins/select2/select2.min.js";  
            $this->jsFiles['footer'][] = "assets/js/plugins/datatables/jquery.dataTables.min.js";          
            $this->jsFiles['footer'][] = "assets/js/plugins/datatables/DT_bootstrap.js";   
            $this->jsFiles['footer'][] = "assets/js/plugins/datatables/responsive/datatables.responsive.js";  
            $this->jsFiles['footer'][] = "assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.min.js";   

            $this->jsFiles['footer'][] = "assets/js/app.js";   
            $this->jsFiles['footer'][] = "assets/js/plugins.js";   
            $this->jsFiles['footer'][] = "assets/js/plugins.form-components.js";   

            $this->jsFiles['footer'][] = "assets/js/plugins/validation/jquery.validate.min.js";  

            $this->jsFiles['footer'][] = "assets/js/login.js";     
            $this->jsFiles['footer'][] = "assets/js/plugins/fileinput/fileinput.js";
            $this->jsFiles['footer'][] = "assets/js/plugins/touchpunch/jquery.ui.touch-punch.min.js";

            $this->customJs[] = 'assets/js/jquery.table2excel.js';
            
            $this->customJs[] = 'assets/js/admin.js';
            */
        }
        $this->loadTemplate();
    }
  }
}
?>