<?php 
$accessAllow = true;
$active_modules = $objDatabase->iFindAll(TABLE_PREFIX.'modules','','','status=1');
foreach($active_modules as $module) {
   if(is_dir('modules/vendor/'.$module->module_name)) {
      include 'modules/vendor/'.$module->module_name.'/' . $module->module_name . '.model.php';
      include 'modules/vendor/'.$module->module_name.'/' . $module->module_name . '.controller.php';
    }
    else {
      include 'modules/core/'.$module->module_name.'/' . $module->module_name . '.model.php';
      include 'modules/core/'.$module->module_name.'/' . $module->module_name . '.controller.php';
    }
}

if($objMainframe->getController()<>'')
{
  if(strstr($_SERVER['REQUEST_URI'],ADMIN_PATH))
    {
       if(!isset($_SESSION['adminLogin']) && $objMainframe->getController()<>'login') {
           ISP :: __doRedirect(SITE_URL.ADMIN_PATH.'/login'); die();
       }       
       $controller = $objMainframe->getController();
       $action = $objMainframe->getAction();  
       
       if($controller <>'login' && $controller <>'dashboard') {
           $objDB = new dbModel();
            if(!$objDB->checkAdminPermission($controller)){
                $accessAllow = false;
            }
       }
       
        if($accessAllow) {
            $objController = new $controller();
            $objController->$action();
        }
        else {
            echo "<p class='col-xs-12 alert alert-danger text-center'>You are not authorized to access this area!</p>";
        }
    } 
    else  
    {
        $controller = $objMainframe->getController();
        $action = $objMainframe->getAction();
        $objController = new $controller($objMainframe);
        $objController->$action();
    }
}

$outputBuffer = ob_get_contents();
$objMainframe->setPage($outputBuffer);
ob_end_clean();
unset($outputBuffer);
mainframe::buildAdminMenu($objDatabase);
$objMainframe->buildTheme();
