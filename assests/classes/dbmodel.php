<?php
/* **************************************************
@Project        : W4C-Framework
@Author         : Praveen Paliya
@Created        : 22/02/2019
@Doc Role        : Database class, responsible for database connection and database intraction(Fetch/Update).
************************************************** */

class dbModel
{
    private $host;
    private $user;
    private $pwd;
    public $db;
    private $port;
    public $sql;
    private $res;
    public $objFunctions;
    public $con;
    public $countRec;
    public $insertId;
    public $affectedRows;
    public $objFunction;
    public $objThumb;
    private $arrayData;
    protected $postedData;
    private static $instance = null;
    
  public function __construct()
    {                        
        if(is_null(DB_HOST)) {
            die('Set the Database server in conf.php please');
        }
        
        if(is_null(DB_USER)) {
            die('Set the Database User Id in conf.php please');
        }
        
        if(is_null(DB_NAME)) {
            die('Set the Database Name in conf.php please');
        }
        
        $this->host    = DB_HOST;
        $this->user    = DB_USER;
        $this->pwd     = DB_PASSWORD;
        $this->db      = DB_NAME;    
        $this->port    = DB_PORT;    

        $this->objThumb = new Thumbnail();
        //$this->con = self :: getInstance();
        $this->con = new mysqli($this->host, $this->user, $this->pwd, $this->db,$this->port);
        $this->postedData();
    }
    
    public static function buildAdminMenu($dnconn) {
        //override in child classes
    }
    
    public static function getInstance(){
        if(!self::$instance){
          self::$instance = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
        }
        return self::$instance;
    }
    
    public function checkAdminPermission($moduleId) {
        $adminId = $_SESSION['adminLogin'][0]->id;
        if($adminId ==1) {
            return true;
        }
        else {
            $objPermission = $this->fetchRows("SELECT * FROM ".TABLE_PREFIX."permissions where module_name='".$moduleId."' and admin_id='".$adminId."'");
            if(intval($objPermission->permission_id)>0)
                return true;
            else
                return false;
        }
        
    }

    protected function __t($label, $lang="") {
        if($lang == "")
            $lang = $_SESSION['lang']->lang_id;

        $langTranslation = $this->fetchRows("SELECT * FROM ".TABLE_PREFIX."lang_translation where lang_id='".$lang."' and label='".$label."'");
        if (intval($langTranslation->id)==0) {
            $this->dbQuery("INSERT INTO ".TABLE_PREFIX."lang_translation(lang_id, label, translation) values('".$lang."', '".$label."', '')");

            return $label;
        }
        else {
           if($langTranslation->translation == "")
                return $label;
            else
                return $langTranslation->translation;
        }
    }

    protected function __aT($label) {
        $adminLang = $this->fetchRows("SELECT config_value FROM ".TABLE_PREFIX."config where config_key='admin_language'");
        $lang = $adminLang->config_value;

        $langTranslation = $this->fetchRows("SELECT * FROM ".TABLE_PREFIX."translation where lang_id='".$lang."' and label='".$label."'");
        if (intval($langTranslation->id)==0) {
            $this->dbQuery("INSERT INTO ".TABLE_PREFIX."translation(lang_id, label, translation) values('".$lang."', '".$label."', '')");

            return $label;
        }
        else {
            if($langTranslation->translation == "")
                return $label;
            else
                return $langTranslation->translation;
        }
    }


    protected function setAdminLogin($data) {
      $_SESSION['adminLogin'] = $data;
    }
 
    protected function adminLogout() {
      unset($_SESSION['adminLogin']);

    }

    protected function isAdminLogin() {
      if(!isset($_SESSION['adminLogin'])) {
           ISP :: __doRedirect(SITE_URL.ADMIN_PATH.'/login'); 
           die();
       }    
    }


    protected function getAdminLogin() {
      return $_SESSION['adminLogin'];
    }
    
    /* **************************************************        
    Purpose: Return database connection object.        
    *************************************************** */
    public function sqlCon()
    {
        return $this->con;
    } 

    protected function postedData() {
      $this->postedData = $_POST;
    }

    protected function filterPostedData() {
      $tempArray = array();
      foreach($this->postedData as $key => $value)
        {
            if( (substr($key, 0, 3) == 'db_' || substr($key, 0, 3) == 'md_') )
            {
                $strKeyTmp = substr($key, 3);
                $tempArray[$strKeyTmp] = $value;
            }
            else {
              $tempArray[$key] = $value;
            }
        } 
      return  $tempArray;
    }
    /* **************************************************        
    Purpose: Responsible for data extraction and return resultset.        
    *************************************************** */
    public function dbQuery($s)
    {
        $this->sql = $s;
        $this->res = $this->con->query($this->sql);
        if(mysqli_connect_errno() > 0) {                
            return false;
        }
        $this->countRec = $this->res->num_rows;
        return $this->res;
    } 
    
    /* **************************************************        
    Purpose: Responsible for data extraction, store in the array and return array of resultset.        
    *************************************************** */
    public function dbFetch($s)
    {
        $this->arrayData = array();
        $intCount = 0;
        $this->sql = $s;
        $this->res = $this->con->query($this->sql);
        $this->countRec = $this->res->num_rows;
        if(mysqli_connect_errno() > 0) {                
            die(mysqli_connect_errno());
        }
       if ($this->res) { 
          while ( $row = $this->res->fetch_object())    
          {
              $this->arrayData[$intCount] = $row;
              $intCount++;
          }
        }
        return $this->arrayData;
    }
    
    public function dbFetchObject($s)
    {
        $intCount = 0;
    
        return $s->fetch_object();
    
    }
    
    /* **************************************************        
    Purpose: Responsible for data manupulation and return true/false according to function success.        
    *************************************************** */
    public function updateQuery($s)
    {
        $this->sql = $s;
        $this->con->query($this->sql);
        $this->affectedRows = $this->con->affected_rows;            
                            
        if(mysqli_connect_errno() > 0) {
            return false;
        }
        return $this->affectedRows;
    }
    /* **************************************************        
    Purpose: Responsible for fetch row from latest slecet query.        
    *************************************************** */
    public function fetchRows($s = '')
    {
     
        if($s <> '') 
        {
             if($this->dbQuery($s))
                return $this->res->fetch_object();
    
        }
        
    }
    /* **************************************************        
    Purpose: Responsible for return no of record in a select query.        
    *************************************************** */
    public function countRows()
    {
        return $this->countRec;
    }
    /* **************************************************        
    Purpose: Use for query execution.        
    *************************************************** */
    public function execQuery($s)
    {
        $this->sql = $s;
        $this->con->query($this->sql);
        
        if(mysqli_connect_errno() > 0) {                
            echo (mysqli_connect_errno());
        }
        
        return 2;
        
    }
    /* **************************************************        
    Purpose: Responsible for data insurtion and return insert Id.        
    *************************************************** */
    public function insertQuery($s)
    {
        $this->sql = $s;
        $res = $this->con->query($this->sql);
        $this->affectedRows = $this->con->affected_rows;        
        if($this->affectedRows >0)
          $this->insertId = $this->con->insert_id;
        else
           $this->insertId =0;
        return $this->insertId;
    }
    /* **************************************************        
    Purpose: Return insert Id of last inserted record.        
    *************************************************** */
    public function insertId()
    {
        return $this->insertId;
    }
    
    /* **************************************************        
    Purpose: Insert entire HTML form data in to database  table, only those HTML entiry will be consider which have name start with `db_`.
             And return insert id.
    *************************************************** */
    protected function insertForm($tmpTableName)
    {
        $arrKey = array();
        $arrValue = array();
        $arrTblFields = array();
        $strMessage = '';
        
         $strQuery = "Select * from ".$tmpTableName;
         $result = $this->dbQuery($strQuery);
         $finfo = $result->fetch_fields();
         foreach ($finfo as $tblCol) 
          {
            $arrTblFields[] = $tblCol->name;
          }
        foreach($_POST as $key => $value)
        {
            if((substr($key, 0, 3) == 'db_' || substr($key, 0, 3) == 'md_') && in_array(substr($key, 3),$arrTblFields) )
            {
            
               if( substr($key, 0, 3) == 'md_')
               {
                 if(trim($value)=="")
                   $strMessage= '<li>Required fields can not be left blank</li>';
               }
            
                $strKeyTmp = substr($key, 3);
                $arrKey[] = $strKeyTmp;
                if($strKeyTmp == 'password') 
                {
                    $arrValue[] = "'".md5($value)."'";
                }
                else 
                {
                    $arrValue[] = "'".$this->con->real_escape_string(htmlentities(trim($value)))."'";
                }
            }
        }
        foreach($_FILES as $key=>$val)
        {
            if($val['name']<>"")
            {
               $strDirectory = SITE_UPLOADPATH;
               
               @chmod($strDirectory,0777);
               
               $val['name'] = time().$this->removeSpace($val['name']); 
               
               move_uploaded_file($val['tmp_name'], $strDirectory.$val['name']);
               
               if (isset($_POST['optimize']))                     
               {                        
                    $this->objThumb->create_thumbnail($strDirectory.$val['name'], $strDirectory.'mobile/'.$val['name'], 450, 450);                        $this->objThumb->create_thumbnail($strDirectory.$val['name'], $strDirectory.'tablet/'.$val['name'], 800, 800);  
                         
               } 
               
               if((substr($key, 0, 3) == 'db_' || substr($key, 0, 3) == 'md_') && in_array(substr($key, 3),$arrTblFields) )
                {
                    $strKeyTmp = substr($key, 3);
                    $arrKey[] = $strKeyTmp;
                    $arrValue[] = "'".$val['name']."'";
                }
               
            }      
        }    
        
        foreach($arrKey as $val)
        {
           $Keyarr[]="`".$val."`";
        }
        
        $strKey = implode(', ', $arrKey);
        $strValue = implode(', ', $arrValue);
        
        if( $strMessage=='')
        {
            $strQuery = "INSERT INTO ".$tmpTableName." (".$strKey.") VALUES (".$strValue.")";
             return $this->insertQuery($strQuery);
        }    
        else
        {
           return $this->showServerValidationMessage( $strMessage);
          }        
    }
    
    public function removeSpace($text)
    {
       $code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
    
      $code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','');
    
      $text = str_replace($code_entities_match, $code_entities_replace, $text); 
      return $text;
    }

    protected function updateForm($tmpTableName,$tmpId='', $primaryId='')
    {
       if($tmpId=='') $tmpId= $_REQUEST['id'];
       if($primaryId=='') $primaryId= 'id';
    
        $arrQueryValue = array();
        $arrTblFields = array();
        $strMessage = '';
        
         $strQuery = "Select * from ".$tmpTableName;
         $result = $this->dbQuery($strQuery);
         $finfo = $result->fetch_fields();
         foreach ($finfo as $tblCol) 
          {
            $arrTblFields[] = $tblCol->name;
          }

        foreach($_POST as $key => $value)
        {
          //if($value<>'')
          //{      
            if((substr($key, 0, 3) == 'db_' || substr($key, 0, 3) == 'md_') && in_array(substr($key, 3),$arrTblFields) )
            {
              if( substr($key, 0, 3) == 'md_')
               {
                 if(trim($value)=="")
                   $strMessage.= '<li>'.sprintf(PLEASE_ENTER,substr($key, 3))."</li>";
               }
               
               
                $strDBKey =  substr($key, 3);
                if($strDBKey == 'password' ) {
                  if($value<>'')
                    $arrQueryValue[] = $strDBKey." = '".md5($value)."'";
                }        
                
                else {
                    $arrQueryValue[] = $strDBKey." = '".$this->con->real_escape_string(trim($value))."'";
                }
            }
          //}    
        }
    
        foreach($_FILES as $key=>$val)
        {
          if($val['name']<>"")
          {
              $strDirectory=$_POST['dir_'.substr($key,3)];
              if($strDirectory=="")
                 $strDirectory = SITE_UPLOADPATH;
               
              @chmod($strDirectory,0777);

               $val['name'] = time().$this->removeSpace($val['name']);
              move_uploaded_file($val['tmp_name'],$strDirectory.$val['name']);

              if((stripos($key, "db_")!==false || stripos($key, "md_")!==false) && in_array(substr($key, 3),$arrTblFields) )
                {
                    $arrQueryValue[]='`'.substr($key,3).'`=\''.$val['name'].'\'';     
                } 
          }      
        }    
         $strQueryValue = implode(', ', $arrQueryValue);
        if( $strMessage=='')
        {
              $strQuery = "UPDATE ".$tmpTableName." SET ".$strQueryValue." WHERE $primaryId = '".$tmpId."'";
              return $this->updateQuery($strQuery);
        }    
        else
        {
           return $this->showServerValidationMessage( $strMessage);
        }     
    }
    
  
    public function setOrder($tmpTableName,$intId)
    {
       $sql= $this->dbQuery("Select id  from $tmpTableName");
       $intMorder= $this->countRows()+1;
       $this->updateQuery("UPDATE $tmpTableName set order=$intMorder where id=".$intId);
       
    }    


  public function iFind( $table, $find, $match )
  {
    $strSQL = '1=1';
    if ( count( $match ) > 0 ):
      foreach ( $match as $key => $val ) {
        $strSQL .= " AND " . $key . "='" . $val . "' ";
      }
    endif;
    $row = $this->fetchRows( "SELECT " . $find . " from " . $table . " where " . $strSQL );
    return $row->$find;
  }
  
  public function iFindAll( $table, $match, $orderby = '', $customMatch = '' )
  {
    $strSQL = '1=1';
    if ( count( $match ) > 0 && $match <> '' ):
      foreach ( $match as $key => $val ) {
        $strSQL .= " AND " . $key . "='" . $val . "' ";
      }
    endif;
    if ( $customMatch <> '' ) {
      $strSQL .= ' AND ' . $customMatch;
    }
    $row = $this->dbFetch( "SELECT * from " . $table . " where " . $strSQL . $orderby );
    return $row;
  }

  public function iShowAll( $table )
  {
    $strSQL       = '1=1';
    $this->objSet = $this->dbFetch( "SELECT * from " . $table . " where " . $strSQL . " order by id asc  " );
    return $this->objSet;
  }

  public function iFindAllCount( $table, $match, $count )
  {
    if ( count( $match ) > 0 ):
      foreach ( $match as $key => $val ) {
        $strSQL .= " AND " . $key . "='" . $val . "' ";
      }
    endif;
    $row = $this->dbQuery( "SELECT * from " . $table . " where 1=1 " . $strSQL . " limit 0, " . $count );
    if ( $row ) {
      return $row;
    }
    return false;
  }

  protected function updateRouter($absUrl, $seoUrl) {
    $this->dbQuery("DELETE from ".TABLE_PREFIX."router where route_url='".$absUrl."'");
    $this->dbQuery("INSERT INTO ".TABLE_PREFIX."router (route_url, sef_url) values('".$absUrl."', '".$seoUrl."')");
  }

  protected function getUrl($absurl) {
    $row = $this->fetchRows( "SELECT sef_url from " . TABLE_PREFIX . "router where route_url='".$absurl."'");
    if ($row) {
      return SITE_URL.$row->sef_url;
    }
    else {
      if(strpos($absurl, 'http://') !== 0 && strpos($absurl, 'https://') !== 0) {
        return SITE_URL.$absurl;
      }
      else {
        return $absurl;
      }
      
    }
  }
    
        
  function showServerValidationMessage($strMessage)
    {
       echo '<div style="padding-left:10px; width:auto; border: 1px solid #cc0000; background-color:#ffffcc; color:#C21834; font-weight: bold; font-family:verdana; font-size:11px; padding-top:10px; padding-bottom:10px;">
           '.$strMessage.'
       </div>';
       
       return false;
    }

    public function __destruct() {
        $this->con->close();
    }
    private function __clone() { }
}
?>