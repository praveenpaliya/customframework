<?php
session_start();
ob_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
ini_set("display_errors", 1); 
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/assests/classes/dbmodel.php";
require_once __DIR__ . "/assests/classes/functions.php";
include_once __DIR__ . '/assests/classes/class.thumbnail.php';
include_once __DIR__ . '/modules/vendor/stripe-php/init.php';

require __DIR__.'/assests/phpmailer/Exception.php';
require __DIR__.'/assests/phpmailer/PHPMailer.php';
require __DIR__.'/assests/phpmailer/SMTP.php';

$objDatabase = new dbModel();
$objFunctions = new ISP();

define("TABLE_PREFIX", "tbl_");

$configData = $objDatabase->iFindAll(TABLE_PREFIX.'config','','','config_value<>""');
foreach($configData as $configValues) {
  if($configValues->config_key == "default_lang") {
    define("PRE_LANG", $configValues->config_value);
  }
  else {
      if($configValues->config_key == "site_url") {
        $site_url = $configValues->config_value;
      }
      else if($configValues->config_key == "site_theme") {
        $site_theme = $configValues->config_value;
      }
      else {
        define(strtoupper($configValues->config_key), $configValues->config_value);
      }
  }
}
$objFunctions->currencyRateUpdate();

define("SITE_ABSPATH", __DIR__);
define("SUBDOMAIN_SETUP", "messageboard.eternityletter.com");

if ($_SERVER['HTTP_HOST'] == SUBDOMAIN_SETUP) {
  define('SITE_THEME', SUBDOMAIN_THEME);
  define('MAIN_URL', $site_url);
  define('SITE_URL', 'https://'.SUBDOMAIN_SETUP.'/');
  define("SITE_UPLOADPATH", "var/default/images/");
}
else {
  define('SITE_URL', $site_url);
  define('SITE_THEME', $site_theme);
  define("SITE_UPLOADPATH", "var/".SITE_THEME."/images/");
}

define("SITE_ADMINURL", SITE_URL .ADMIN_PATH . '/');
define("SITE_ADMIN_DEFAULT_LOGO", SITE_URL."var/default/logo.png");
define("VC_SEF", 1);
define("SEND_EMAIL", "smtp");

define("MAIL_SMTPHOST", "email-smtp.us-east-1.amazonaws.com");
define("SMTP_USER", "AKIA5DK75FIM6CWMW6M2");
define("SMTP_PASSWORD", "BPHdF/XXItD2tKST40v9kN9lQcl8xq1dWx6pUmET5QkO");
define("SMTP_PORT", 587);


if(!is_dir("var/".SITE_THEME)){
  mkdir("var/".SITE_THEME, 0777);
  mkdir("var/".SITE_THEME."/css", 0777);
  mkdir("var/".SITE_THEME."/images", 0777);
  mkdir("var/".SITE_THEME."/images/admin", 0777);
  mkdir("var/".SITE_THEME."/export", 0777);
  mkdir("var/".SITE_THEME."/js", 0777);
  mkdir("var/".SITE_THEME."/invoices", 0777);
}

$actLang = $objFunctions->listLanguages();

if(!empty($_GET['lang'])) {
  foreach($actLang as $lang) {
    if($lang->lang_id==$_GET['lang']) {
      $_SESSION['lang'] = $lang;
    }
  }
  $objFunctions->__doRedirect(base64_decode($_GET['ref']));
}
else {
    foreach($actLang as $lang) {
        if(empty($_SESSION['lang'])) {
            if($lang->lang_id == PRE_LANG) {
                $_SESSION['lang'] =  $lang;   
            }
        }
    }
}

define('DEFAULT_LANG', $_SESSION['lang']->lang_id);

$actCurrency = $objFunctions->listCurrency();

if(!empty($_GET['curr'])) { 
  foreach($actCurrency as $curr) {
    if($curr->currency_code==$_GET['curr']) {
      $_SESSION['currency'] = $curr;
    }
  }
  $objFunctions->__doRedirect(base64_decode($_GET['ref']));
}
else {
  foreach($actCurrency as $curr) {
    if(empty($_SESSION['currency'])) {
      if($curr->currency_code == DEFAULT_CURRENCY) {
        $_SESSION['currency'] =  $curr;
      }
    }
  }
}

include_once __DIR__ . '/assests/classes/mainframe.php';
$objMainframe = new mainframe($objDatabase);

define("CURRENCY", '$ ');
define("CURRENCY_CODE", $_SESSION['currency']->currency_code.' ');

require_once( 'modules/router.php' );
require_once('bootstrap.php');
