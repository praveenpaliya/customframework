<?php
$url = $objFunctions->getCurrentUrl();

if ( VC_SEF == 1 ) {
  if ( strstr( $_SERVER[ 'REQUEST_URI' ], ADMIN_PATH ) ) {
    $arrPageUrl = explode( ADMIN_PATH . "/", $url );
  } 
  else {
    $arrPageUrl = explode( SITE_URL, $url, 2 );
  }
  $arrUrl = explode( "/", $arrPageUrl[ 1 ] );

  
  for ( $i = 0; $i < count( $arrUrl ); ) {
    if ( $i == 0 ) {
      if ( !isset( $_REQUEST[ 'controller' ] ) ) {
        $_GET[ 'controller' ] = $_REQUEST[ 'controller' ] = $arrUrl[ $i ];
      }
      $i++;
    } 
    elseif ( $i == 1 ) {
      if ( !isset( $_REQUEST[ 'action' ] ) ) {
        $_GET[ 'action' ] = $_REQUEST[ 'action' ] = $arrUrl[ $i ];
      }
      $i++;
    } else {
      $_GET[ $arrUrl[ $i ] ] = $_REQUEST[ $arrUrl[ $i ] ] = $arrUrl[ $i + 1 ];
      $i = $i + 2;
    }
  }
  $_SERVER[ 'QUERY_STRING' ] = http_build_query( $_GET );
}

$strController  = !empty( $_REQUEST[ 'controller' ] ) ? $_REQUEST[ 'controller' ] : '';
$strAction = !empty( $_REQUEST[ 'action' ] ) ? $_REQUEST[ 'action' ] : '';
$intId   = !empty( $_REQUEST[ 'id' ] ) ? $_REQUEST[ 'id' ] : '';



if ($_SERVER['HTTP_HOST'] == SUBDOMAIN_SETUP) {
    if ($_GET['controller'] == "" && $_REQUEST['controller'] == "" && $_POST['controller'] == "") {
      $_GET['controller'] = $_REQUEST['controller'] =  $strController = 'message';
    }
}


$objMainframe->setController($strController);
$objMainframe->setAction($strAction);
mainframe :: setHomePage(0);

if ( strstr( $_SERVER[ 'REQUEST_URI' ], ADMIN_PATH ) ) {
  if ($objMainframe->getController() == '') { 
      $objFunctions->__doRedirect(mainframe::__adminBuildUrl('login'));
  }
}
else {
    if($strController=="") {
        $objMainframe->setController('pages');
        $objMainframe->setAction('pagedetails');
        $_GET['pageid'] = $_REQUEST['pageid'] = HOME_PAGE;
        mainframe :: setHomePage(1);
    }
}
