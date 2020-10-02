<?php

class blogModel extends ISP {

    public $userData;
    protected $blogUrl;

    public function __construct() {
        parent :: __construct();
        $this->blogUrl = 'blog/';
    }

    public function LoadAllPages($status='') {
        if ($status <> '') {
            $cond = " and status='".$status."'";
        }
        $sql = "SELECT * FROM " . TABLE_PREFIX . "blog where 1=1 ".$cond." order by title";
        return $this->dbFetch($sql);
    }

    protected function listBlogs($cid=0, $limit) {
        $cond = '';
        if ($cid >0) {
            $cond = " and category='".$cid."'";
        }
        $sql = "SELECT * FROM " . TABLE_PREFIX . "blog where 1=1 ".$cond." and status=1 order by blog_id desc limit $limit";
        return $this->dbFetch($sql);
    }

    public function getPageDetails($pId) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "blog where blog_id='" . $pId . "'";
        return (array) $this->fetchRows($sql);
    }

    public function savepage() {
        if (intval($_POST['id']) == 0) {
            $blog_id = $this->insertForm(TABLE_PREFIX . "blog");

            $this->updateRouter($this->blogUrl.'pagedetails/postid/'.$blog_id, $this->blogUrl.$_POST['md_url']);
        } else {
            $this->updateForm(TABLE_PREFIX . "blog", $_POST['id'], 'blog_id');
            $this->updateRouter($this->blogUrl.'pagedetails/postid/'.$_POST['id'], $this->blogUrl.$_POST['md_url']);
        }
    }

    protected function deletPage($pageid) {
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "blog WHERE blog_id = '" . $pageid . "'");
    }

    public function saveContactusDetails() {
        $this->insertForm(TABLE_PREFIX . "contact_us");
    }

}
