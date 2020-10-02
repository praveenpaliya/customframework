<?php

class pages extends pagesModel {

    private $pageId;
    private $pageData;
    private $objMainframe;

     public function __Construct($objMainframe = '') {
        if (!is_object($objMainframe)) {
            global $objMainframe;
        }
        $this->objMainframe = $objMainframe;
        parent :: __Construct();
    }

    
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-file-text-alt"></i> Pages' => array(
                'All Pages' => 'pages',
                'Add New Page' => 'pages/addpage'
            )
        );
        return $menu_array;
    }

    public function index() {
        $this->pageData = $this->LoadAllPages();
        $this->loadView('admin/listing');
    }

    private function pagewidget() {
        $this->pageData = $this->getPageDetails($this->pageId);
        $this->codeTitle = '';
        $this->loadTheme('', 'page-widget');
    }

    public function callShortCode($args) {
        $this->args = $args;

        $func = $args['call'];
        $this->pageId = $args['id'];
        $this->limit = $args['limit'];

        if ($func <> "") {
            $this->$func();
        }
    }

    public function save() {
        if (!empty($_POST)) {
            $this->savepage();
            mainframe :: setSuccess('Page added sucessfully.');
            $this->__doRedirect(mainframe::__adminBuildUrl('pages'));
        }
    }

    public function addpage() {
        if ($_GET['id'] != '') {
            $this->pageId = intval($_GET['id']);
            $this->postedData = $this->getPageDetails($this->pageId);
        }
        $this->loadView('admin/pageform');
    }

    public function pagedetails() {
        $this->pageId = intval($_GET['pageid']);
        $this->postedData = $this->getPageDetails($this->pageId);
        $this->objMainframe->setBreadCrumTitle($this->postedData['title']);

        /* Set Product Meta */
        $metaTitle = $this->postedData['meta_title'];
        $metaKeywords = $this->postedData['meta_keywords'];
        $metaDesc = $this->postedData['meta_description'];

        $this->objMainframe->setPageHeading($this->postedData['title']);

        $this->objMainframe->setPageTitle($metaTitle);
        $this->objMainframe->setMetaKeywords($metaKeywords);
        $this->objMainframe->setMetaDescription($metaDesc);

        /* End of Meta */

        $this->loadTheme('pageview-' . $this->pageId, 'pageview');
    }

    private function loadTheme($specifictpl, $tpl='') {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $specifictpl . ".php") || file_exists("modules/vendor/pages/front/views/" . $specifictpl . ".php") || file_exists('modules/core/pages/views/front/' . $specifictpl . '.php')) {
            $tpl = $specifictpl;
        }


        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/pages/front/views/" . $tpl . ".php")) {
            include("modules/vendor/pages/pages/views/" . $tpl . ".php");
        } else {
            include('modules/core/pages/views/front/' . $tpl . '.php');
        }
    }

    private function loadView($template = 'listing') {
        include('views/' . $template . '.php');
    }

    /**
     * @author Praveen Paliya 8/june/2017
     * @uses Method is used to record for creating menu
     */
    public function useAsMenu() {
        $allPagesData = $this->LoadAllPages();
        $result = [];
        $i = 0;
        foreach ($allPagesData as $data) {
            $result['value'][$i] = 'pages/pagedetails/pageid/' . $data->page_id;
            $result['title'][$i] = $data->title;
            $i++;
        }
        return $result;
    }

    /**
     * @uses Method use to delete pages
     * $date 03.07.2017
     * @author Santos Pal <santosh@w4consult.com>
     */
    public function delete() {
        if ($_GET['id'] != '') {
            $this->pageId = intval($_GET['id']);
            $this->deletPage($this->pageId);
            mainframe :: setSuccess('Page deleted sucessfully.');
        }
        $this->__doRedirect(mainframe::__adminBuildUrl('pages'));
    }

    public function saveContactus() {
        if ($_SESSION['captcha_code'] <> $_POST['captcha']) {
            mainframe :: setError('Invalid Captcha Code.');
            $this->__doRedirect(SITE_URL.'contact-us');
        }
        $contact_name = $_POST['md_contact_name'];
        $contact_email = $_POST['md_contact_email'];
        $contact_number = $_POST['md_contact_number'];
        $contact_message = nl2br($_POST['md_contact_message']);
        
        $this->saveContactusDetails();
        
            $to = MAIL_ADMIN;
            $subject = 'Contact Message';
            $message = "
                        Hi,
                        <p>Name: $contact_name</p>
                        <p>Email: $contact_email</p>
                        <p>Phone: $contact_number</p>
                        <p>Message: $contact_message</p>
                        ";
                    
        $this->mosMail($to, $subject, $message, 1);
        
        mainframe :: setSuccess('Form submitted successfully.');
        
        $this->__doRedirect(SITE_URL.'contact-us');
        
    }

}
