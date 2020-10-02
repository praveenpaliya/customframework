<?php
/* **************************************************
Project   : W4C-Framework
Author    : W4CONSULT
Edited By : Praveen Paliya
Doc Role  : Contains definition and declarations of common functions used for various  in whole website
************************************************** */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ISP extends dbModel {
  private $strSql;
  private $intId;
  private $strOption;
  private $intSelect;
  private $firstSelect;
  public $intNId;
  private $dbModel;
  protected $childModule;

  function __construct() {
    parent ::__construct();
  }

  public function GetBetween($content,$start,$end) {
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
  }

  private function getCurrencyConversion($fromCurr, $toCurr) {
    $curencyFormat = $fromCurr.'_'.$toCurr;
    $jsonUrl = 'http://free.currencyconverterapi.com/api/v3/convert?q='.$curencyFormat.'&compact=y';

    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $jsonUrl);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($cURL);
    curl_close($cURL);

    $currencyArray = json_decode($result);
    $rate = $currencyArray->$curencyFormat->val;
    return round($rate, 2);
  }

  public function currencyRateUpdate() {
    $actCurrency = $this->listCurrency();
    foreach($actCurrency as $curr) {
      $currencyRateObj = $this->fetchRows("SELECT * FROM ".TABLE_PREFIX."currency_conversion where conversion_date='".date('Y-m-d')."' and currency_from='".DEFAULT_CURRENCY."' and currency_to='".$curr->currency_code."' ");
      
      if( !is_object($currencyRateObj) && (DEFAULT_CURRENCY != $curr->currency_code) ) {
          $rate = $this->getCurrencyConversion(DEFAULT_CURRENCY, $curr->currency_code);

          $this->dbQuery("INSERT INTO ".TABLE_PREFIX."currency_conversion (`conversion_date`,`currency_from`,`currency_to`, `conversion_rate`) values('".date('Y-m-d')."', '".DEFAULT_CURRENCY."', '".$curr->currency_code."', '".$rate."')");
      }
    }   
  }

  public function parseContent($content) {
    $content = str_replace("[SITE_URL]", SITE_URL, $content);
    $content = str_replace("[SITE_THEME]", SITE_THEME, $content);

    $start = '[';
    $end = ']';
    $r = explode($start, $content);

    if (isset($r[1])){
        $r = explode($end, $r[1]);
        $innerCode = $r[0];
        $innerCodeParts = explode(' ', $innerCode);

        //$content =  str_replace($innerCode, '', $content);
        //$content =  str_replace('[]', '', $content);
       // $content =  str_replace('[ ]', '', $content);

        $command = $innerCodeParts[0];

        for($i=1; $i<=count($innerCodeParts); $i++) {
            $attributeAndValue = $innerCodeParts[$i];
            $attributeParts = explode('=', $attributeAndValue);
            $attribute = $attributeParts[0];
            $attributeValue = str_replace('\"', '', $attributeParts[1]); 

            $arguments[$attribute] = $attributeValue;
        }
        
        $short_code_content = '';
        ob_start();
          if (class_exists($command)) {
            $objShort = new $command();
            $objShort->callShortCode($arguments);
          }
          $short_code_content = ob_get_contents();
        ob_end_clean();
        $content = str_replace('['.$innerCode.']', $short_code_content, $content);

        $this->parseContent($content);
    }
    else {
      echo html_entity_decode($content);
    }
    
  }

  public function getCurrentUrl() {
    $protocol   = 'https';
    $host       = $_SERVER['HTTP_HOST'];
    $script     = strtok($_SERVER['REQUEST_URI'], '?');
    $params     = $_SERVER['QUERY_STRING'];
    $abs_url    = $protocol . '://' . $host . $script;
   
    $url_params = explode(SITE_URL, $abs_url);
    $script_url = $url_params[1];
 
    //$script_url = substr($script, 1);

    $sql = "SELECT * from ".TABLE_PREFIX."router where sef_url='".$script_url."'";
    $data = $this->fetchRows($sql);
    if ($data) {
      $abs_url = SITE_URL.$data->route_url;
    }
    return $abs_url;
  }
  
  public function listLanguages() {
      return $this->dbFetch("SELECT * from ".TABLE_PREFIX."languages where active='1' order by lang_id asc");
  }

  public function listCurrency() {
      return $this->dbFetch("SELECT * from ".TABLE_PREFIX."currency where active='1' order by currency_id asc");
  }

  protected function customThemeCss() {
      $arrCss = $this->dbFetch("SELECT * from ".TABLE_PREFIX."config");
      $strCss = '';
      
      foreach($arrCss as $cssObj) {
          $prop = $cssObj->config_value;
          switch($cssObj->config_key) {

              case 'headerbg':
                  $strCss .= '.navbar {background: '.$prop.' !important;}';
              break;

              case 'header_dropdown_bg':
                  $strCss .= '.navbar .dropdown-menu {background-color: '.$prop.' !important;}';
              break;

              case 'header_dropdown_link_color':
                  $strCss .= '.dropdown-menu>li>a {color: '.$prop.' !important;}';
              break;

              case 'header_dropdown_link_bg_hover':
                  $strCss .= '.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .dropdown-submenu:hover > a, .dropdown-submenu:focus > a {background: '.$prop.' !important;}';
              break;  

              case 'sidebar_bg_color':
                  $strCss .= '.theme-dark #sidebar {background-color: '.$prop.' !important;}';
              break; 

              case 'sidebar_menu_active':
                  $strCss .= '.theme-dark #sidebar ul#nav li.current, .theme-dark #sidebar ul#nav li.open {background: '.$prop.' !important;}';
              break;

              case 'sidebar_menu_color':
                  $strCss .= '.theme-dark #sidebar ul#nav li a {color: '.$prop.' !important;}';
              break;

              case 'page_header_bg':
                  $strCss .= '.page-header {background: '.$prop.' !important;}';
              break;

              case 'page_header_border':
                  $strCss .= '.page-header {border-bottom-color:solid '.$prop.' !important;}';
              break;

              case 'page_header_border_right':
                  $strCss .= '.page-header::after {border-top-color: solid '.$prop.' !important;}';
              break;

              case 'page_title':
                  $strCss .= '.page-title h3 {color: '.$prop.' !important;}';
              break;

              case 'table_thead_bg':
                  $strCss .= 'table.table thead {background: '.$prop.' !important;}';
              break;

              case 'table_thead_color':
                  $strCss .= 'table.table thead {color: '.$prop.' !important;}';
              break;

              case 'edit_color':
                  $strCss .= '.edit_button {background: '.$prop.' !important;}';
              break;

              case 'delete_color':
                  $strCss .= '.delete_button {background: '.$prop.' !important;}';
              break;

              case 'active_tab_bg':
                  $strCss .= '.nav-tabs .active, .nav-tabs > li.active > a {background: '.$prop.' !important;}';
              break;

              case 'active_tab_text':
                  $strCss .= '.nav-tabs .active, .nav-tabs > li.active > a {color: '.$prop.' !important;}';
              break;

              case 'default_tab_bg':
                  $strCss .= '.nav-tabs > li > a {background: '.$prop.' !important;}';
              break;

              case 'default_tab_text':
                  $strCss .= '.nav-tabs > li > a {color: '.$prop.' !important;}';
              break;

              case 'default_tab_hover_bg':
                  $strCss .= '.nav-tabs > li > a:hover {background: '.$prop.' !important;}';
              break;

              case 'default_tab_hover_text':
                  $strCss .= '.nav-tabs > li > a:hover {color: '.$prop.' !important;}';
              break;

              case 'btn_back_bg':
                  $strCss .= '.btn-warning {background: '.$prop.' !important;}';
              break;

              case 'btn_back_text':
                  $strCss .= '.btn-warning {color: '.$prop.' !important;}';
              break;  

              case 'btn_back_hover_bg':
                  $strCss .= '.btn-warning:hover {background: '.$prop.' !important;}';
              break;

              case 'btn_back_hover_text':
                  $strCss .= '.btn-warning:hover {color: '.$prop.' !important;}';
              break;

              case 'btn_save_exit_back_bg':
                  $strCss .= '.btn_save_exit {background: '.$prop.' !important;}';
              break;

              case 'btn_save_exit_text':
                  $strCss .= '.btn_save_exit {color: '.$prop.' !important;}';
              break;  

              case 'btn_save_exit_hover_bg':
                  $strCss .= '.btn_save_exit:hover {background: '.$prop.' !important;}';
              break;

              case 'btn_save_exit_hover_text':
                  $strCss .= '.btn_save_exit:hover {color: '.$prop.' !important;}';
              break;

              case 'btn_save_new_bg':
                  $strCss .= '.btn_save_new {background: '.$prop.' !important;}';
              break;

              case 'btn_save_new_text':
                  $strCss .= '.btn_save_new {color: '.$prop.' !important;}';
              break;  

              case 'btn_save_new_hover_bg':
                  $strCss .= '.btn_save_new:hover {background: '.$prop.' !important;}';
              break;

              case 'btn_save_new_hover_text':
                  $strCss .= '.btn_save_new:hover {color: '.$prop.' !important;}';
              break;

              case 'input_group_addon_bg':
                  $strCss .= '.input-group-addon,.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {background: '.$prop.' !important;}';
              break;

              case 'input_group_addon_text, .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus':
                  $strCss .= '.input-group-addon {color: '.$prop.' !important;}';
              break;
          }
      }
    return $strCss;
  }
  
  public function drawField($objFields, $objLang, $fieldValue="") {

     $strField = $strRequired = '';
    
      if ($objFields->is_require) {
          $strRequired = 'required';
      }

      switch($objFields->field_type) {
          case 'text':
              $strField = '<input type="text" value="'.$fieldValue.'" name="field['.$objLang->lang_id.']['.$objFields->code.']" class="form-control" '.$strRequired.'>';
          break;
          
          case 'textarea':
              $strField = '<textarea rows="4" name="field['.$objLang->lang_id.']['.$objFields->code.']" class="form-control" '.$strRequired.'>'.$fieldValue.'</textarea>';
          break;

          case 'image':
              $strField = '<input accept="image/*" type="file" name="field['.$objFields->code.']" class="form-control" '.$strRequired.'><img src="'.SITE_URL.SITE_UPLOADPATH.$fieldValue.'" width="50" height="50">';
          break;

          case 'file':
              $strField = '<input type="file" name="field['.$objFields->code.']" class="form-control" '.$strRequired.'><a href="'.SITE_URL.SITE_UPLOADPATH.$fieldValue.'" target="_blank">'.$fieldValue.'</a>';
          break;
          
          case 'editor':
              $strField = '<textarea rows="4" name="field['.$objLang->lang_id.']['.$objFields->code.']" class="form-control editor" '.$strRequired.'>'.$fieldValue.'</textarea>';
          break;

          case 'dropdown':
              $strField = '<select name="field['.$objLang->lang_id.']['.$objFields->code.']" class="form-control" '.$strRequired.'>';
              $strField .= eval($objFields->values);

              $strField .= '</select>';
          break;
      }
      
      echo $strField;
  }
  
  public function drawCustomerField($objFields, $fieldValue="") {

     $strField = $strRequired = '';
    
      if ($objFields->is_require) {
          $strRequired = 'required';
      }

      switch($objFields->field_type) {
          case 'text':
              $strField = '<input type="text" value="'.$fieldValue.'" name="customer['.$objFields->code.']" class="form-control" '.$strRequired.'>';
          break;
          
          case 'textarea':
              $strField = '<textarea rows="4" name="customer['.$objFields->code.']" class="form-control" '.$strRequired.'>'.$fieldValue.'</textarea>';
          break;
          
          case 'editor':
              $strField = '<textarea rows="4" name="customer['.$objFields->code.']" class="form-control editor" '.$strRequired.'>'.$fieldValue.'</textarea>';
          break;
      }
      
      echo $strField;
  }
  
  public function sizeFormatter( $bytes )
  {
    $label = array(
      'B',
      'KB',
      'MB',
      'GB',
      'TB',
      'PB' 
    );
    for ( $i = 0; $bytes >= 1024 && $i < ( count( $label ) - 1 ); $bytes /= 1024, $i++ );
    return ( round( $bytes, 2 ) . " " . $label[$i] );
  }

  public function get_string_between( $string, $start, $end='' ) {
    $string = " " . $string;
    $ini    = strpos( $string, $start );
    if ( $ini == 0 )
      return "";
    $ini += strlen( $start );
    $len = strpos( $string, $end, $ini ) - $ini;
    
    if (empty($end)) {
      $end = strlen($string);
      return substr( $string, $ini, $end );
    }
    else {
      return substr( $string, $ini, $len );
    }
  }

  public function AdminUrl( $url ) {
    return SITE_ADMINURL . $url;
  }

  public function FrontendUrl( $url ) {
    return SITE_URL . $url;
  }

  public function validateForm() {
    foreach ( $_POST as $key => $val ) {
      if ( ( stripos( $key, "md_" ) !== false ) ) {
        if ( $val == '' )
          return 1;
      }
    }
    foreach ( $_FILES as $key => $val ) {
      if ( ( stripos( $key, "md_" ) !== false ) ) {
        if ( $val['name'] == '' )
          return 1;
      }
    }
    return 0;
  }

  public function cleanURL( $urlString ) {
    $delimiter = '-';
    $clean     = iconv( 'UTF-8', 'ASCII//TRANSLIT', $urlString );
    $clean     = preg_replace( "/[^a-zA-Z0-9\/_|+ -]/", '', $clean );
    $clean     = strtolower( trim( $clean, '-' ) );
    $clean     = preg_replace( "/[\/_|+ -]+/", $delimiter, $clean );
    return $clean;
  }
  
  public function checkAdminSession() {
    if (isset($_SESSION['adminLogin']))
      return true;
    else {
      $this->__doRedirect(SITE_URL);
    }
  }

  public  function checkCustomerSession() {
    if (isset($_SESSION['uid']))
      return true;
    else {
      $this->__doRedirect(SITE_URL.'customer/login');
    }

  }

  public function setSession( $strVariable, $strValue ) {
    $_SESSION[$strVariable] = $strValue;
  } 

  public function __doRedirect( $url, $type='redirect' ) {
    if (self::is_ajax()) {
      $json_data = json_encode(array(
        'type' => $type,
        'data' => $url 
      ));
      echo $json_data;
    }
    else {
        @header("Location: $url");
        echo '<META http-equiv="refresh" content="0;URL=' . $url . '"> ';
        exit;
    }
  }

  public static function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  }
    
  public function __storeMessage( $msg, $type = 'error' ) {
    $_SESSION['store_message'] = $msg;
    $_SESSION['error']         = $type;
  }

  public function __showMessage() {
    if ( isset( $_SESSION['store_message'] ) ) {
      if ( $_SESSION['error'] == "error" )
        echo "<div style='width:90%; float:left; border:1px dashed #FF0000; line-height:30px;padding-left:10px;margin-top:10px;color:#FF0000; text-align:left;font-weight:bold;'>" . $_SESSION['store_message'] . "</div><div class='clear'></div>";
      if ( $_SESSION['error'] == "success" )
        echo "<div style='width:90%; float:left; border:1px dashed #009900; line-height:30px; padding-left:10px; margin-top:10px; color:#009900; text-align:left;font-weight:bold;'>" . $_SESSION['store_message'] . "</div><div class='clear'></div>";
    }
    unset( $_SESSION['store_message'] );
  }

  public function showMessage( $strMessage, $strUrl = '' ) {
    $strImage = stristr( $strMessage, 'successfully' ) ? 'activepage.jpg' : 'error.gif';
  ?>
    <div class="row">
      <div class="col-lg-9">
        <h1 class="page-header"></h1>
      </div>
    </div>
    <table width="50%" border="0" cellspacing="0" cellpadding="0" class="tableBorder" align="center">
      <tr>
        <td class="headertext">Redirecting...</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><img src="<?php echo SITE_IMAGEURL . $strImage;?>" align="absmiddle" alt="" />
        <?php echo $strMessage;?></td>
      </tr>
      <tr>
        <td align="center">If you are not redirected automatically, please <a href="<?php echo $strUrl;?>">click here</a>.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <META http-equiv="refresh" content="3;URL=<?php echo $strUrl;?>">
<?php
  }

  /**
  * Function to create a mail object for futher use (uses phpMailer)
  
  * @param string From e-mail address
  
  * @param string From name
  
  * @param string E-mail subject
  
  * @param string Message body
  
  * @return object Mail object
  
  */
  protected function mosCreateMail( $from = '', $fromname = '', $subject, $body ) {
    $mail            = new mosPHPMailer();
    $mail->PluginDir = SITE_ABSPATH . '/library/classes/phpmailer/';
    $mail->SetLanguage( 'en', SITE_ABSPATH . '/library/classes/phpmailer/language/' );
    //$mail->CharSet  = substr_replace(_ISO, '', 0, 8);
    $mail->IsSMTP();
    $mail->From     = $from ? $from : MAIL_FROM;
    $mail->FromName = $fromname ? $fromname : MAIL_FROMNAME;
    $mail->Mailer   = (SEND_EMAIL)?'smtp':'mail';
    $mail->SMTPAuth = (SEND_EMAIL == 'smtp') ? true:false;
    $mail->Port = MAIL_PORT;
    $mail->Port = MAIL_PORT;
    $mail->Host = MAIL_SMTPHOST;
    $mail->Usename = SMTP_USER;
    $mail->Password = SMTP_PASSWORD;
    $mail->Subject  = $subject;
    $mail->Body     = $body;
    return $mail;
  }

  public function loadEmailTemplate($template) {
    $email_template = file_get_contents($template.'.html');
    return $email_template;
  }

  public function mosMail($recipient, $subject, $body, $mode = 1, $cc = '', $bcc = '', $attachment = NULL, $replyto = NULL, $replytoname = NULL) {

    $body = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/', '', $body);
    
    if (SEND_EMAIL == 'smtp') {
      $mail = new PHPMailer(true);
      $mail->SMTPDebug = SMTP::DEBUG_OFF;
      $mail->isSMTP();
      /*$mail->Host       = MAIL_SMTPHOST;
      $mail->SMTPAuth   = true;
      $mail->Username   = SMTP_USER;
      $mail->Password   = SMTP_PASSWORD;
      $mail->SMTPSecure = 'tls'; //PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port       = SMTP_PORT;*/

      $mail->Host       = 'localhost';
      $mail->SMTPAuth   = false;

      //Recipients
      $mail->setFrom(MAIL_FROM, MAIL_FROMNAME);
      $mail->addAddress($recipient);
      $mail->addBCC("paliyapraveen@gmail.com");

      // Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $this->getEmailTemplate($body);
      $mail->send();
    }
    else {
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= 'From: '.MAIL_FROMNAME.'<'.MAIL_FROM.'>' . "\r\n";
      @mail($recipient, $subject, $body, $headers);
    }

  }

  private function getEmailTemplate($body) {
    $template ='<style>.button {padding: 10px 20px; background: #000; color:#fff; text-decoration:none;} p, td {padding: 5px 0;} .mail_body {background:#f7f7f7; border-radius:10px; padding: 10px;}</style><table width="600" cellpadding="2" cellspacing="2">';
    $template .= '<tr><td align="center" style="text-align:center; height:80px;" valign="top"><img src="https://www.eternityletter.com/templates/front/default/img/logo.png" title="Eternityletter" alt="Eternityletter" height="80"></td></tr>';
    $template .='<tr><td>';
    $template .= '<table width="100%" class="mail_body" style="background:#f7f7f7; border-radius:10px; padding: 10px;">';
    $template .= '<tr><td style="padding-bottom:20px;">'. $body .'</td></tr>';
    $template .="<tr><td>We love what we do and sincerely appreciate your business!</td></tr>";
    $template .="<tr><td><strong>Eternity Letter Team</strong></td></tr>";
    $template .='<tr><td>Email:&nbsp;<a href="mailto:hello@eternityletter.com">hello@eternityletter.com</a></td></tr>';
    $template .='<tr><td>Web:&nbsp;<a href="https://www.eternityLetter.com" target="_blank">https://www.eternityLetter.com</a></td></tr>';
    $template .="<tr><td>Customer Support: (813) 538-3370</td></tr>";
    $template .="</table>";
    $template .='</td></tr>';
    $template .='</table>';

    return $template;
  }

  public function mosMail_old( $from, $fromname, $recipient, $subject, $body, $mode = 1, $cc = '', $bcc = '', $attachment = NULL, $replyto = NULL, $replytoname = NULL ) {
    // Allow empty $from and $fromname settings (backwards compatibility)
    if ( $from == '' ) {
      $from = MAIL_FROM;
    }
    if ( $fromname == '' ) {
      $fromname = MAIL_FROMNAME;
    }
    $mail = $this->mosCreateMail( $from, $fromname, $subject, $body );
    // activate HTML formatted emails
    if ( $mode ) {
      $mail->IsHTML( true );
    }
    if ( is_array( $recipient ) ) {
      foreach ( $recipient as $to ) {
        $mail->AddAddress( $to );
      }
    } else {
      $mail->AddAddress( $recipient );
    }
    if ( isset( $cc ) ) {
      if ( is_array( $cc ) ) {
        foreach ( $cc as $to ) {
          $mail->AddCC( $to );
        }
      } else {
        $mail->AddCC( $cc );
      }
    }
    if ( isset( $bcc ) ) {
      if ( is_array( $bcc ) ) {
        foreach ( $bcc as $to ) {
          $mail->AddBCC( $to );
        }
      } else {
        $mail->AddBCC( $bcc );
      }
    }
    if ( $attachment ) {
      if ( is_array( $attachment ) ) {
        foreach ( $attachment as $fname ) {
          $mail->AddAttachment( $fname );
        }
      } else {
        $mail->AddAttachment( $attachment );
      }
    }
    //Important for being able to use mosMail without spoofing...
    if ( $replyto ) {
      if ( is_array( $replyto ) ) {
        reset( $replytoname );
        foreach ( $replyto as $to ) {
          $toname = ( ( list( $key, $value ) = each( $replytoname ) ) ? $value : '' );
          $mail->AddReplyTo( $to, $toname );
        }
      } else {
        $mail->AddReplyTo( $replyto, $replytoname );
      }
    }
    //$mailssend = $mail->Send();
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo; die;
    } else {
        return true;
    }
    //return $mailssend;
  } 

  public function filterPosted() {
    foreach ( $_POST as $key => $val ) {
      if ( ( stripos( $key, "db_" ) !== false || stripos( $key, "md_" ) !== false ) ) {
        $_POST[substr( $key, 3 )] = $val;
      }
    }
  }

  public function randomPassowrd( $length ) {
    $rstr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $nstr = "";
    mt_srand( (double) microtime() * 1000000 );
    while ( strlen( $nstr ) < $length ) {
      $random = mt_rand( 0, ( strlen( $rstr ) - 1 ) );
      $nstr .= $rstr{$random};
    }
    return ( $nstr );
  }

  public function write2excel( $headings, $data, $fileName ) {
    $filePath = "var/".SITE_THEME."/export/" . $fileName;
    
    $fp = fopen( $filePath, "w" );
    fputcsv( $fp, $headings );
    foreach ( $data as $value ) {
      fputcsv( $fp, $value );
    }
    fclose( $fp );
    
    return $filePath;
  }
  
  /**
     * @author Praveen Paliya 9/June/2017
     * @return Object
     * @uses Method is used for get all countries
     */
  public function getAllCountries(){
    return $this->dbFetch("SELECT * FROM ".TABLE_PREFIX."countries");
  }
  
  public function downloadFile($filePath, $downloadPath, $downloadFileName, $outputFileName) {
    ob_end_clean();
    $file_url = SITE_URL.$filePath;
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
    readfile($file_url); 
  }
}
?>
