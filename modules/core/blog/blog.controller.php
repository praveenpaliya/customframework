<?php
class blog extends blogModel {

    private $pageId;
    private $pageData;
    private $objMainframe;
    private $limit = 1;

     public function __Construct($objMainframe = '') {
        if (!is_object($objMainframe)) {
            global $objMainframe;
        }
        $this->objMainframe = $objMainframe;
        parent :: __Construct();
    }

    
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-file-text-alt"></i> Blog' => array(
                'All Posts' => 'blog/listing',
                'Add New Post' => 'blog/addpost'
            )
        );
        return $menu_array;
    }

    public function listing() {
        $this->checkAdminSession();
        $this->pageData = $this->LoadAllPages();
        $this->loadView('admin/listing');
    }

    public function index() {
        $this->objMainframe->setPageHeading('Blog');
        $this->pageData = $this->LoadAllPages(1);
        $this->loadTheme('', 'listing');
    }

    private function blogListwidget() {
        $this->pageData = $this->listBlogs(0, $this->limit);
        $this->codeTitle = '';
        $this->loadTheme('', 'blog_list_widget');
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
        $this->checkAdminSession();
        if (!empty($_POST)) {
            $this->savepage();
            mainframe :: setSuccess('Post added sucessfully.');
            $this->__doRedirect(mainframe::__adminBuildUrl('blog/listing'));
        }
    }

    public function addpost() {
        $this->checkAdminSession();
        if ($_GET['id'] != '') {
            $this->pageId = intval($_GET['id']);
            $this->postedData = $this->getPageDetails($this->pageId);
        }
        $this->loadView('admin/pageform');
    }

    public function pagedetails() {
        $this->pageId = intval($_GET['postid']);
        $this->objMainframe->setPageHeading('Blog');
        $this->postedData = $this->getPageDetails($this->pageId);
        $this->objMainframe->setBreadCrumTitle('<a href="'.SITE_URL.'blog">Blog</a>');

        /* Set Product Meta */
        $metaTitle = $this->postedData['meta_title'];
        $metaKeywords = $this->postedData['meta_keywords'];
        $metaDesc = $this->postedData['meta_description'];

        $this->objMainframe->setPageTitle($metaTitle);
        $this->objMainframe->setMetaKeywords($metaKeywords);
        $this->objMainframe->setMetaDescription($metaDesc);

        $this->objMainframe->setOgMetaTags(
            array(
                'og:title' => $this->postedData['title'],
                'og:image' => SITE_URL . SITE_UPLOADPATH . $this->postedData['image'],
                'og:url' => $this->getUrl($this->blogUrl.'pagedetails/postid/'.$this->postedData['blog_id'])
            )
        );

        /* End of Meta */

        $this->loadTheme('', 'blog-view');
    }

    private function loadTheme($specifictpl, $tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $specifictpl . ".php") || file_exists("modules/vendor/blog/front/views/" . $specifictpl . ".php") || file_exists('views/front/' . $specifictpl . '.php')) {
            $tpl = $specifictpl;
        }


        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/pages/front/views/" . $tpl . ".php")) {
            include("modules/vendor/blog/views/" . $tpl . ".php");
        } else {
            include('modules/core/blog/views/front/' . $tpl . '.php');
        }
    }

    private function loadView($template = 'listing') {
        include('modules/core/blog/views/' . $template . '.php');
    }

    public function useAsMenu() {
        $this->checkAdminSession();
        $allPagesData = $this->LoadAllPages();
        $result = [];
        $i = 0;
        $result['value'][$i] = 'blog';
        $result['title'][$i] = 'Blog Listing';
        $i++;

        foreach ($allPagesData as $data) {
            $result['value'][$i] = 'blog/pagedetails/pageid/' . $data->blog_id;
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
        $this->checkAdminSession();
        if ($_GET['id'] != '') {
            $this->pageId = intval($_GET['id']);
            $this->deletPage($this->pageId);
            mainframe :: setSuccess('Post deleted sucessfully.');
        }
        $this->__doRedirect(mainframe::__adminBuildUrl('blog/listing'));
    }

    public function saveContactus() {
        
        $contact_name = $_POST['md_contact_name'];
        $business_name = $_POST['md_business_name'];
        $contact_email = $_POST['md_contact_email'];
        $contact_number = $_POST['md_contact_number'];
        $contact_subject = $_POST['md_contact_subject'];
        $contact_message = $_POST['md_contact_message'];
        
        $this->saveContactusDetails();
        
            $to = MAIL_ADMIN;
            $subject = $contact_subject;
            $message = "
                        Hi,
                        <p>Name: $contact_name</p>
                        <p>Business: $business_name</p>
                        <p>Email: $contact_email</p>
                        <p>Phone: $contact_number</p>
                        <p>Message: $contact_message</p>
                        ";
                    
        mail($to, $subject, $message);
        
        mainframe :: setSuccess('sucessfully.');
        
        $this->__doRedirect(mainframe::__doRedirect('pagedetails/pageid/2'));
        
    }

}
