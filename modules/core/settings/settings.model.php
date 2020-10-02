<?php

class settingsModel extends ISP {

    protected $arrayData;
    protected $languages;
    public $currencies;
    protected $labelTranslations;
    public $objFunction;

    public function __construct() {
        parent :: __construct();
        $this->languages = $this->listLanguages();
        $this->listCurrencies();

        $this->objFunction = new ISP();
    }

    protected function showActiveLanguages() {
        return $this->languages;
    }

    protected function listSystemConfig() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "config order by config_id asc";
        $configData = $this->dbFetch($sql);
        foreach ($configData as $objConfig) {
            $this->arrayData[$objConfig->config_key] = $objConfig;
        }
    }

    protected function listSystemColorConfig() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "config order by config_id asc";
        $configData = $this->dbFetch($sql);
        foreach ($configData as $objConfig) {
            $this->arrayData[$objConfig->config_key] = $objConfig->config_value;
        }
    }

    protected function labelsTranlation() {
        $adminLang = $this->fetchRows("SELECT config_value FROM " . TABLE_PREFIX . "config where config_key='admin_language'");
        $lang = $adminLang->config_value;

        $this->labelTranslations = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "translation where lang_id='" . $lang . "' order by label");
    }

    protected function labelsFrontEndTranlation($lang) {
        $this->labelTranslations = $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "lang_translation where lang_id='" . $lang . "' order by label ASC");
    }

    protected function saveLabelTranslation() {
        foreach ($_POST['translate'] as $key => $val) {
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "translation set translation='" . $val . "' where id='" . $key . "'");
        }
    }

    protected function editThemelabel($transId) {
        $sql = "SELECT t.*, l.language from " . TABLE_PREFIX . "lang_translation t inner join ".TABLE_PREFIX."languages l on l.lang_id=t.lang_id where t.id='".$transId."'";
        $objRec = $this->fetchRows($sql);
        return $objRec;
    }

    protected function saveFrontTranslationModel() {
        foreach ($_POST['translate'] as $key => $val) {
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "lang_translation set translation='" . $val . "' where id='" . $key . "'");
        }
    }

    public function getCurrencyRate($from, $to, $date='') {
        if($from == $to) {
            return 1;
        }
        else {
            if($date=='')
                $date = date('Y-m-d');
            
            $resultObj = $this->fetchRows("SELECT conversion_rate FROM ".TABLE_PREFIX."currency_conversion where conversion_date='".$date."' and currency_from='".$from."' and currency_to='".$to."' ");
            return $resultObj->conversion_rate;
        }
    }

    public function listCurrencies() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "currency order by currency_id asc";
        $this->currencies = $this->dbFetch($sql);
    }

    protected function saveSiteSettings() {
        if ($_FILES['site_logo']['name'] <> "") {
            move_uploaded_file($_FILES['site_logo']['tmp_name'], SITE_UPLOADPATH . $_FILES['site_logo']['name']);
            $site_logo = $_FILES['site_logo']['name'];
            $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "config where config_key='site_logo'");
            $this->dbQuery("INSERT INTO " . TABLE_PREFIX . "config (config_key, config_value) values ('site_logo', '" . $site_logo . "') ");
        }
        $this->dbQuery("UPDATE " . TABLE_PREFIX . "config set config_value='" . $_POST['home_slider'] . "' where config_key='home_slider'");
    }

    protected function saveSettings() {
        foreach ($_POST['config'] as $key => $val) {
            $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "config where config_key='" . $key . "'");
            $this->dbQuery("INSERT INTO " . TABLE_PREFIX . "config (config_key, config_value) values ('" . $key . "', '" . addslashes($val) . "') ");
        }

        if ($_POST['languages']) {
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "languages set active='0'");
            foreach ($_POST['languages'] as $val) {
                $this->dbQuery("UPDATE " . TABLE_PREFIX . "languages set active='1' where lang_id='" . $val . "'");
            }
        }

        if ($_POST['currency']) {
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "currency set active='0'");
            foreach ($_POST['currency'] as $val) {
                $this->dbQuery("UPDATE " . TABLE_PREFIX . "currency set active='1' where currency_code='" . $val . "'");
            }
        }
    }

    protected function saveSocialMediaDetails() {
        $image = '';
        $url = '';
        $path = SITE_UPLOADPATH.'socialicon/';
        foreach ($_POST['title'] as $k => $v) {
            $title = $v;
            $url = $_POST['url'][$k];

            $file_tmp = $_FILES['fileToUpload']['tmp_name'][$k];
            $file_name = mktime() . $_FILES['fileToUpload']['name'][$k];

            move_uploaded_file($file_tmp, $path . $file_name);
            $this->dbQuery("INSERT INTO " . TABLE_PREFIX . "social_media (title, url, image) values ('{$title}', '{$url}', '{$file_name}') ");
        }
    }
    public function getAllSocialMedia() {
        return $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "social_media");
    }
    protected function deleteSocialMediaRecord($id) {
        $this->dbQuery("DELETE  FROM " . TABLE_PREFIX . "social_media WHERE id= {$id}");
    }

}
