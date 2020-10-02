<?php

class catalogModel extends ISP {

    public $userData;
    protected $categoryArray;
    protected $brandOptions;
    protected $customerGroups;
    protected $groupPrice;
    protected $catalogFields;
    protected $categoryFields;
    protected $wishListItems;
    private $fieldAttributes;
    private $category_url;
    private $product_url;

    public function __construct($caturl, $producturl) {
        parent :: __construct();
        $this->category_url = $caturl;
        $this->product_url = $producturl;

        $this->getBrandsList();
        $this->getCustomerGroups();
        $this->catalogFields = $this->listCatalogAttributes('catalog');
        $this->categoryFields = $this->listCatalogAttributes('category');
    }

    protected function loadCustomerMessages() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "messages where created_by='".$_SESSION['uid']."' order by created_date desc";
        return $this->dbFetch($sql);
    }

    protected function addToWishlist($pid, $cid) {
        $this->dbQuery("INSERT INTO ".TABLE_PREFIX."wishlist (product_id, customer_id) values('".$pid."', '".$cid."')");
        
    }

    protected function removeProductfromWishList($id) {
        $this->dbQuery("DELETE from ".TABLE_PREFIX."wishlist where wishlist_id='".$id."'");
    }

    protected function getWishListItems($cid) {
        $this->wishListItems = $this->dbFetch("SELECT w.wishlist_id,w.product_id,c.* FROM ".TABLE_PREFIX."wishlist w inner join ".TABLE_PREFIX."catalog c on w.product_id=c.catalog_id where w.customer_id='".$cid."'");
    }

    private function listCatalogAttributes($mod = 'catalog') {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "attribute_fields where module='" . $mod . "' order by field_id asc";
        return $this->dbFetch($sql);
    }

    protected function loadCustomOptions($pid) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "custom_option where catalog_id='".$pid."'";
        return $this->dbFetch($sql);
    }

    protected function loadFeatured($limit) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "catalog where is_featured='1' order by catalog_id desc limit $limit";
        return $this->dbFetch($sql);
    }

    protected function loadNewProducts($limit) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "catalog where status=1 order by created_date desc limit $limit";
        return $this->dbFetch($sql);
    }

    protected function loadFilteredProducts($text) {
        $sql = "(SELECT cen.catalog_id as catalog_id, c.image from ".TABLE_PREFIX."catalog c inner join ".TABLE_PREFIX."catalog_entry cen on c.catalog_id = cen.catalog_id where cen.field_code='name' and cen.field_value like '%".$text."%') UNION (SELECT cen.catalog_id as catalog_id, c.image from ".TABLE_PREFIX."catalog c inner join ".TABLE_PREFIX."catalog_entry cen on c.catalog_id = cen.catalog_id where cen.field_code='description' and cen.field_value like '%".$text."%')";
        return $this->dbFetch($sql);
    }

    private function getCustomerGroups() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "customer_group order by customer_group asc";
        $this->customerGroups = $this->dbFetch($sql);
    }

    protected function getBrandsList() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "brands order by brand_name asc";
        $this->brandOptions = $this->dbFetch($sql);
    }

    public function LoadAllProducts() {
        //$sql = "SELECT c.*, GROUP_CONCAT(cat.category_id SEPARATOR ',') as category FROM ".TABLE_PREFIX."catalog c left join ".TABLE_PREFIX."catalog_category  cc on cc.catalog_id=c.catalog_id inner join ".TABLE_PREFIX."categories cat on cat.category_id=cc.category_id group by c.catalog_id order by c.catalog_id desc";
        //$sql = "SELECT c.* FROM " . TABLE_PREFIX . "catalog c where product_type in (1,3)  order by c.catalog_id desc";
        $sql = "
                SELECT 
                cc.`category_id`,
                  c.* 
                FROM
                  " . TABLE_PREFIX . "catalog c 

                LEFT JOIN " . TABLE_PREFIX . "catalog_category cc
                ON cc.catalog_id =  c.catalog_id

                WHERE product_type IN (1, 3)
                ORDER BY c.catalog_id DESC 
                ";
        return $this->dbFetch($sql);
    }

    public function getAttributeValue($catalogId, $code, $lang = DEFAULT_LANG) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "catalog_entry where lang_id='" . $lang . "' and catalog_id='" . $catalogId . "' and field_code='" . $code . "'";
        $rows = $this->fetchRows($sql);
        return $rows->field_value;
    }
//    public function getAttributeValue($catalogId, $code, $lang = DEFAULT_LANG) {
//        
//        if (empty($this->fieldAttributes)) {
//            $sql = "SELECT * FROM " . TABLE_PREFIX . "catalog_entry where lang_id='" . $lang . "' and catalog_id='" . $catalogId . "'"; //and field_code='" . $code . "'";
//            $rows = $this->dbFetch($sql);
//            foreach($rows as $row) {
//                $this->fieldAttributes[$row->field_code] = $row->field_value;
//            }
//        }
//        return $this->fieldAttributes[$code];
//    }

    protected function getCategoryAttributeValueModel($catId, $code, $lang = DEFAULT_LANG) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "category_entry where lang_id='" . $lang . "' and category_id='" . $catId . "' and field_code='" . $code . "'";
        $rows = $this->fetchRows($sql);
        return $rows->field_value;
    }
//    protected function getCategoryAttributeValueModel($catId, $code, $lang = DEFAULT_LANG) {
//         if (empty($this->fieldAttributes)) {
//            $sql = "SELECT * FROM " . TABLE_PREFIX . "category_entry where lang_id='" . $lang . "' and category_id='" . $catId . "'";// and field_code='" . $code . "'";
//            $rows = $this->dbFetch($sql);
//            foreach($rows as $row) {
//                $this->fieldAttributes[$row->field_code] = $row->field_value;
//            }
//        }
//        return $this->fieldAttributes[$code];
//    }

    protected function loadCategoryProducts($cid) {
        if ($cid >0) {
            $condwhere = " and cc.category_id='" . $cid . "'";
        }
        $sql = "SELECT c.* FROM " . TABLE_PREFIX . "catalog c inner join " . TABLE_PREFIX . "catalog_category cc on cc.catalog_id=c.catalog_id where 1=1 ".$condwhere." order by c.created_date desc";
        return $this->dbFetch($sql);
    }

    protected function getCategories() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "categories where status=1";
        $objRecord = $this->dbFetch($sql);
        return $objRecord;
    }
    protected function getParentCategories() {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "categories WHERE status=1 AND parent_cat=0";
        $objRecord = $this->dbFetch($sql);
        return $objRecord;
    }

    protected function getChildCategories($parent) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "categories where parent_cat='" . $parent . "'";
        $objRecord = $this->dbFetch($sql);
        return $objRecord;
    }

    protected function listAllCategories($cid='', $limit=100) {
        if ($cid <> '') {
            $cond_where = ' and category_id in ('.$cid.')';
        }

        $sql = "SELECT * FROM " . TABLE_PREFIX . "categories where 1=1 ".$cond_where." order by parent_cat limit 0,".$limit;
        $objRecord = $this->dbFetch($sql);
        return $objRecord;
    }

    protected function getProductDetails($intId) {
        $priceData = $this->dbFetch("SELECT * from " . TABLE_PREFIX . "catalog_price where catalog_id= '$intId'");
        $this->groupPrice = [];
        foreach ($priceData as $dataObj) {
            $this->groupPrice[$dataObj->customer_group]['price'] = $dataObj->price;
        }
        $sql = "SELECT * from " . TABLE_PREFIX . "catalog where catalog_id= '$intId'";
        return $this->fetchRows($sql);
    }

    protected function duplicateProduct($pid) {
        $sql = "INSERT INTO " . TABLE_PREFIX . "catalog (product_type,brand_id,sku,weight,seo_url,image,price,group_price,tier_price,special_price,special_price_start_date,special_price_end_date,inventory,manage_inventory,subscription_type,status,is_featured) SELECT product_type,brand_id,sku,weight,seo_url,image,price,group_price,tier_price,special_price,special_price_start_date,special_price_end_date,inventory,manage_inventory,subscription_type,status,is_featured FROM " . TABLE_PREFIX . "catalog where catalog_id='" . $pid . "'";

        $intId = $this->insertQuery($sql);

        $this->dbQuery("update " . TABLE_PREFIX . "catalog set seo_url= CONCAT(seo_url, '-', '" . $intId . "') where catalog_id='" . $intId . "'");

        $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_entry (catalog_id, lang_id, field_code, field_value) select " . $intId . ", lang_id, field_code, field_value from " . TABLE_PREFIX . "catalog_entry where catalog_id='" . $pid . "'");
    }

    protected function saveProduct() {

        $intPid = $this->insertForm(TABLE_PREFIX . "catalog");
        if ($intPid) {

            /* Save Product Fields */
            foreach ($_POST['field'] as $lang => $fieldArray) {
                foreach ($fieldArray as $code => $value) {
                    $isMultilanguage = $this->iFind(TABLE_PREFIX."attribute_fields", "multilanguage", array('code'=>$code));

                    if($isMultilanguage==0)
                        $lang = 0;

                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_entry (catalog_id, lang_id, field_code, field_value) VALUES('" . $intPid . "', '" . $lang . "', '" . $code . "', '" . addslashes($value) . "')");

                }
            }
            /* End of Fields Save */

            /* Save Product SEO URL */
            if (trim($_POST['seo_url']) == "")
                $seoUrl = $this->cleanURL(trim($_POST['field'][DEFAULT_LANG]['name']));
            else
                $seoUrl = $this->cleanURL(trim($_POST['seo_url']));


            $catalogDs = $this->fetchRows("SELECT catalog_id from " . TABLE_PREFIX . "catalog where seo_url='" . $seoUrl . "' ");
            if ($catalogDs) {
                $seoUrl = $seoUrl . '-' . $intPid;
            }
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "catalog set seo_url='" . $seoUrl . "' where catalog_id='" . $intPid . "'");
            /* End of Product SEO URL save */

            /* Add SEO URL to Router */
            $productUrl = $this->product_url . $intPid;
            $this->updateRouter($productUrl, $seoUrl);
            /* End of Router update */

            /* Check for Group Price and Save */
            if ($_POST['db_group_price'] == 1) {
                foreach ($_POST['group_price'] as $groupId => $gPrice) {
                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_price (catalog_id, customer_group, price) VALUES('" . $intPid . "', '" . $groupId . "', '" . $gPrice . "')");
                }
            }
            /* Group Price */

            if ($this->postedData['cat']) {
                foreach ($this->postedData['cat'] as $cId) {
                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_category (catalog_id, category_id) VALUES('" . $intPid . "', '" . $cId . "')");
                }
            }

            //Added by Praveen Paliya 22/june/2017

            if (!empty($_FILES['gallery_images'])) {
                $this->saveProductGalleryImages($intPid, $_FILES['gallery_images']);
            }

            //Added by Praveen Paliya 23/june/2017
            if (!empty($_POST['option_title'])) {
                $this->saveCustomOptions($intPid, $_POST, $_FILES['custom_image']);
            }
            
            #for save related products
            if (!empty($_POST['relatedProducts'])) {
                $this->addRelatedProducts($_POST['relatedProducts'] , $intPid, true);
            }

            return true;
        } else
            return false;
    }

    /**
     * @author Praveen Paliya 22/june/2017
     * @use this method is used for add gallery images of product 
     * @param type $intPid
     * @param type $gallery_images
     */
    protected function saveProductGalleryImages($intPid, $gallery_images) {
        $imageData = '';
        $path = SITE_UPLOADPATH;

        foreach ($gallery_images['tmp_name'] as $key => $tmp_name) {
            if (!empty($gallery_images['name'][$key])) {
                $file_name = mktime() . $gallery_images['name'][$key];
                $file_tmp = $gallery_images['tmp_name'][$key];

                move_uploaded_file($file_tmp, $path . $file_name);

                $imageData .= $file_name . ',';
            }
        }

        $this->dbQuery("UPDATE " . TABLE_PREFIX . "catalog SET gallery_images = '$imageData' where catalog_id='$intPid'");
    }
    
    /**
     * @author Praveen Paliya 3/July/2017
     * @use this method is used to upload images
     * @param type $file
     */
    protected function uploadFile($file) {
        $imageData = '';
        $path = SITE_UPLOADPATH;
        $file_name = mktime() . $file['name'];
        $file_tmp = $file['tmp_name'];
        move_uploaded_file($file_tmp, $path . $file_name);
        return  $file_name;
    }

    /**
     * @author Praveen Paliya 22/june/2017
     * @use this method is used to add custom options of product
     * @param type $intPid
     * @param type $POST
     */
    protected function saveCustomOptions($intPid, $POST, $FILES='') {

        $values = [];
        foreach ($POST['option_title'] as $k => $option_title) {

            $option_title = $option_title;
            $option_type = $POST['option_type'][$k];
            $option_required = $POST['option_required'][$k];
            $option_sort_order = $POST['option_sort_order'][$k];

            foreach ($POST['value_title'][$k] as $value_title) {
                $values[$k]['value_title'][] = $value_title;
            }
            foreach ($POST['value_sku'][$k] as $value_sku) {
                $values[$k]['value_sku'][] = $value_sku;
            }
            foreach ($POST['value_price'][$k] as $value_price) {
                $values[$k]['value_price'][] = $value_price;
            }
            foreach ($POST['value_price_type'][$k] as $value_price_type) {
                $values[$k]['value_price_type'][] = $value_price_type;
            }
            foreach ($POST['value_required'][$k] as $value_required) {
                $values[$k]['value_required'][] = $value_required;
            }
            foreach ($POST['value_sort_order'][$k] as $value_sort_order) {
                $values[$k]['value_sort_order'][] = $value_sort_order;
            }

            $option_values = json_encode($values[$k]);
            $this->insertQuery("
                     INSERT INTO " . TABLE_PREFIX . "custom_option 
                     (option_title, option_type, is_required, sort_order, option_values, catalog_id) 
                     VALUES('{$option_title}','{$option_type}','{$option_required}','{$option_sort_order}','{$option_values}','$intPid')"
            );
        }
    }

    protected function getProductCategories($intPid) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "catalog_category where catalog_id='$intPid'";
        $arrayRecord = $this->dbFetch($sql);
        $catId = array();
        foreach ($arrayRecord as $objRecord) {
            $catId[] = $objRecord->category_id;
        }
        return $catId;
    }

    protected function updateProduct($intPid) {
        if (!isset($_POST['db_show_price_with_tax']))
            $_POST['db_show_price_with_tax'] = 0;

        $this->updateForm(TABLE_PREFIX . "catalog", $intPid, 'catalog_id');

        /* Save Product Fields */
        $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "catalog_entry where catalog_id='" . $intPid . "'");
        foreach ($_POST['field'] as $lang => $fieldArray) {
            foreach ($fieldArray as $code => $value) {
                $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_entry (catalog_id, lang_id, field_code, field_value) VALUES('" . $intPid . "', '" . $lang . "', '" . $code . "', '" . $value . "')");
            }
        }
        /* End of Fields Save */

        /* Update Product SEO URL */
        if (trim($_POST['seo_url']) == "")
            $seoUrl = $this->cleanURL(trim($_POST['field'][DEFAULT_LANG]['name']));
        else
            $seoUrl = $this->cleanURL(trim($_POST['seo_url']));

        $catalogDs = $this->fetchRows("SELECT catalog_id from " . TABLE_PREFIX . "catalog where seo_url='" . $seoUrl . "' and catalog_id!='" . $intPid . "'");
        if ($catalogDs) {
            $seoUrl = $seoUrl . '-' . $intPid;
        }
        $this->dbQuery("UPDATE " . TABLE_PREFIX . "catalog set seo_url='" . $seoUrl . "' where catalog_id='" . $intPid . "' ");
        /* End of Product SEO URL Update */

        /* Add SEO URL to Router */
        $productUrl = $this->product_url . $intPid;
        $this->updateRouter($productUrl, $seoUrl);
        /* End of Router update */


        /* Check for Group Price and Save */
        if ($_POST['db_group_price'] == 1) {
            $this->dbQuery("DELETE FROM " . TABLE_PREFIX . "catalog_price where catalog_id='" . $intPid . "'");

            foreach ($_POST['group_price'] as $groupId => $gPrice) {
                $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_price (catalog_id, customer_group, price) VALUES('" . $intPid . "', '" . $groupId . "', '" . $gPrice . "')");
            }
        }
        /* Group Price */

        if ($this->postedData['cat']) {
            $this->dbQuery("DELETE from " . TABLE_PREFIX . "catalog_category where catalog_id='" . $intPid . "'");
            foreach ($this->postedData['cat'] as $cId) {
                $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "catalog_category (catalog_id, category_id) VALUES('" . $intPid . "', '" . $cId . "')");
            }
        }
        
        
        //Added by Praveen Paliya 23/june/2017
        
        if (!empty($_FILES['gallery_images'])) {
            $this->saveProductGalleryImages($intPid, $_FILES['gallery_images']);
        }

        #delete old custom option   
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "custom_option where catalog_id='" . $intPid . "'");
        
        #insert new custom options
        if (!empty($_POST['option_title'])) {
            $this->saveCustomOptions($intPid, $_POST, $_FILES['custom_image']);
        }
        
        #update related products
        if(!empty($_POST['relatedProducts'])){
            $this->addRelatedProducts($_POST['relatedProducts'] , $intPid);
        }
    }
    
    protected function getCategoryDetails($cid) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "categories where category_id='$cid'";
        return $this->fetchRows($sql);
    }

    protected function updateCategory($cid) {
        if ($_POST['rm_image'] == 1)
            $_POST['db_cat_image'] = '';
        $this->updateForm(TABLE_PREFIX . "categories", $cid, 'category_id');

        /* Save Category Fields */
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "category_entry where category_id='" . $cid . "'");
        foreach ($_POST['field'] as $lang => $fieldArray) {
            foreach ($fieldArray as $code => $value) {
                $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "category_entry (category_id, lang_id, field_code, field_value) VALUES('" . $cid . "', '" . $lang . "', '" . $code . "', '" . addslashes($value) . "')");
            }
        }

        foreach($_FILES as $fieldArray) {
            
            foreach ($fieldArray['name'] as $code => $value) {
                if ($value <> '') {
                    move_uploaded_file($fieldArray['tmp_name'][$code], SITE_UPLOADPATH.$value);
                    
                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "category_entry (category_id, lang_id, field_code, field_value) VALUES('" . $cid . "', '1', '" . $code . "', '" . addslashes($value) . "')");
                }
            }
        }

        $this->updateRouter('catalog/showcategory/id/'.$cid, $_POST['md_seo_url']);
        /* End of Fields Save */
    }

    protected function addCategory() {
        $intCatId = $this->insertForm(TABLE_PREFIX . "categories");
        /* Save Category Fields */
        foreach ($_POST['field'] as $fieldArray) {
            foreach ($fieldArray['name'] as $code => $value) {
                if ($value <> '') {
                    move_uploaded_file($fieldArray['tmp_name'], SITE_UPLOADPATH.$value);
                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "category_entry (category_id, lang_id, field_code, field_value) VALUES('" . $intCatId . "', '1', '" . $code . "', '" . addslashes($value) . "')");
                }
            }
        }

        foreach($_FILES as $fieldArray) {
            
            foreach ($fieldArray['name'] as $code => $value) {
                if ($value <> '') {
                    move_uploaded_file($fieldArray['tmp_name'], SITE_UPLOADPATH.$value);
                    
                    $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "category_entry (category_id, lang_id, field_code, field_value) VALUES('" . $cid . "', '1', '" . $code . "', '" . addslashes($value) . "')");
                }
            }
        }

        $this->updateRouter('catalog/showcategory/id/'.$intCatId, $_POST['md_seo_url']);
        /* End of Fields Save */
    }

    protected function deleteCategories($cid) {
        $sql = "DELETE from " . TABLE_PREFIX . "categories where category_id = '$cid'";
        $this->dbQuery($sql);
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "category_entry where category_id='" . $cid . "'");
    }

    protected function deleteProduct($pid) {
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "catalog where catalog_id = '$pid'");
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "catalog_entry where catalog_id = '$pid'");
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "catalog_related_product where catalog_id = '$pid'");
    }

    protected function recursiveCategories($parent) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "categories where parent_cat='$parent'";
        $objRecord = $this->dbFetch($sql);
        if ($this->countRows() > 0) {
            foreach ($objRecord as $objData) {
                $this->categoryArray[$parent][] = $objData;
                $this->recursiveCategories($objData->category_id);
            }
        }
    }

    public function loadShoppingCart() {
        $uid = customer ::getCustomerId();
        $sql = "SELECT * FROM " . TABLE_PREFIX . "cart where user_id='$uid'";
        return $this->dbFetch($sql);
    }

    protected function addProductinCart($catalogId, $qty=1, $price,$custom_option='') {
        $uid = customer ::getCustomerId();
        $price = round($price, 2);
        $this->insertQuery("INSERT INTO " . TABLE_PREFIX . "cart (user_id,pid,qty,price,custom_option) VALUES('" . $uid . "','" . $catalogId . "','" . $qty . "','" . $price . "','".$custom_option."') ON DUPLICATE KEY UPDATE qty= qty+" . $qty . "");
    }

    protected function totalItemsinCart() {
        $uid = customer ::getCustomerId();
        $sql = "SELECT count(qty) as totalItems FROM " . TABLE_PREFIX . "cart where user_id='$uid'";
        $objCart = $this->fetchRows($sql);
        return $objCart->totalItems;
    }

    protected function removeProductfromCart($catalogId) {
        $uid = customer ::getCustomerId();
        $this->dbQuery("DELETE from " . TABLE_PREFIX . "cart where user_id='" . $uid . "' and pid='" . $catalogId . "'");
    }


    /**
     * @author Praveen Paliya 31/5/2017
     * @uses Method is used to delete Product File Details
     */
    protected function deleteProductFileDetails($catalog_id) {
        $this->dbQuery("UPDATE " . TABLE_PREFIX . "catalog SET upload_file_title='', upload_filename=''  WHERE catalog_id ='" . $catalog_id . "'");
    }

    /**
     * @author Praveen Paliya
     * @uses Method is used for validate the coupon code in DB
     * @param Array $postData  Posted data
     * @return Object Coupon code details
     */
    protected function varifyCouponValue($couponCode, $subTotal) {
        $currentDate = date('Y-m-d');
        $sql = "
                SELECT * FROM " . TABLE_PREFIX . "coupons 
                    WHERE coupon_code='{$couponCode}' AND ('{$currentDate}' BETWEEN start_date AND expiry_date)
                    AND ( '{$subTotal}' BETWEEN min_subtotal AND max_subtotal  )
                ";
        $objCouponDetails = $this->fetchRows($sql);

        return $objCouponDetails;
    }

    protected function getUserCountry($uid) {
        return $this->dbFetch("SELECT * FROM " . TABLE_PREFIX . "addresses WHERE customer_id = {$uid}");
    }

    protected function getTaxDetails($countryId, $userState) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "taxes WHERE country = '".$countryId."' AND state LIKE '%{$userState}%' ";
        return $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya 13/june/2017
     * @uses Method is used to record for creating menu
     */
    public function menuProductRecord() {
        $sql = "SELECT c.catalog_id, ce.field_value FROM " . TABLE_PREFIX . "catalog c
                LEFT JOIN " . TABLE_PREFIX . "catalog_entry ce
                ON c.catalog_id = ce.catalog_id
                WHERE ce.field_code = 'name' AND ce.lang_id = '" . DEFAULT_LANG . "'
                ";

        return $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya
     * @uses Method is used to record for creating menu
     */
    public function menuCategoryRecord() {
        $sql = "SELECT c.category_id, ce.field_value FROM " . TABLE_PREFIX . "categories c
                LEFT JOIN " . TABLE_PREFIX . "category_entry ce
                ON c.category_id = ce.category_id
                WHERE ce.field_code = 'cat_name' AND ce.lang_id = '" . DEFAULT_LANG . "'
                ";

        return $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya 15/June/2017
     * @uses Method is used to view subscription products
     */
    public function getAllSubscriptionProducts() {
        $sql = "SELECT c.* FROM " . TABLE_PREFIX . "catalog c where product_type = '2'  order by c.catalog_id desc";
        return $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya
     * @uses Method is used to get subscription product
     */
    public function getSubscriptionProduct($productId, $subscriptionType='') {
        $where = '';
        if(!empty($subscriptionType))
            $where = " AND subscription_type = '{$subscriptionType}'";
       
        
        $sql = "SELECT * FROM " . TABLE_PREFIX . "subscription_price WHERE product_id = {$productId} $where";
        return $this->dbFetch($sql);
    }
    
    /*
     * @author Praveen Paliya 6/July/2017
     * @uses Method is used to save subscription
     */
    public function saveSubscription() {
        
        #Save subscription details
        $_POST['db_customer_id'] = $_SESSION['uid']; //set customer id
        $_POST['db_is_subscribed'] = '1'; //set is_subscribed      
        
        $subscription_start_date = strtotime($_POST['db_start_date']);
       
        switch ($_POST['db_subscription_type']) {
            case '1':
                        $end_date = strtotime("+1 week", $subscription_start_date);
                break;
            case '2':
                        $end_date = strtotime("+1 month", $subscription_start_date);
                break;
            case '3':
                        $end_date = strtotime("+3 month", $subscription_start_date);
                break;
            case '4':
                        $end_date = strtotime("+6 month", $subscription_start_date);
                break;
            case '5':
                        $end_date = strtotime("+1 year", $subscription_start_date);
                break;

            default:
                $end_date = date('Y-m-d');
                break;
        }
      
        $_POST['db_end_date'] = date('Y-m-d', $end_date); 
        
        $subscriptionId = $this->insertForm(TABLE_PREFIX . "subscriptions");
        
        #save Subscriber details
        $posted = (object) $_POST;
        $this->dbQuery("insert into " . TABLE_PREFIX . "subscription_customer 
                            (subscription_id
                            ,address_type,
                            phone,email, 
                            first_name, 
                            last_name, 
                            address,city,
                            state, 
                            country,
                            zip_code) 
                        values(
                            '{$subscriptionId}', 
                            'billing', 
                            '{$posted->billing_phone}',
                            '{$posted->billing_email}',
                            '{$posted->billing_fname}',
                            '{$posted->billing_lname}', 
                            '{$posted->billing_address}',
                            '{$posted->billing_city}',
                            '{$posted->billing_state}',
                            '{$posted->billing_country}',
                            '{$posted->billing_zipcode}'
                            )");

        $this->dbQuery("insert into " . TABLE_PREFIX . "subscription_customer 
                            (subscription_id,
                            address_type,
                            phone,
                            email, 
                            first_name, 
                            last_name, 
                            address,
                            city,
                            state, 
                            country,
                            zip_code) 
                        values(
                            '{$subscriptionId}', 
                            'shipping', 
                            '{$posted->shipping_phone}',
                            '{$posted->shipping_email}',
                            '{$posted->shipping_fname}',
                            '{$posted->shipping_lname}', 
                            '{$posted->shipping_address}',
                            '{$posted->shipping_city}',
                            '{$posted->shipping_state}',
                            '{$posted->shipping_country}',
                            '{$posted->shipping_zipcode}'
                            )");
        
        return $subscriptionId;
    }
    
    /**
     * Method is used for update subscriptions status
     * @param int $orderId
     * @param string $orderStatus
     */
    
    public function updateSubscriptionStatus($subscriptionId, $subscriptionStatus='Pending') {
        $this->dbQuery("update " . TABLE_PREFIX . "subscriptions set status='" . $subscriptionStatus . "' where id='" . $subscriptionId . "'");
    }
    
    /**
     * Method is used for update subscriptions status of payment method
     * @param int $orderId
     * @param string $paidBy
     */
    public function updateSubscriptionPaidBy($subscriptionId, $paymentMethod='') {
        $this->dbQuery("update " . TABLE_PREFIX . "subscriptions set payment_method='" . $paymentMethod . "' where id='" . $subscriptionId . "'");
    }
    
    
    /**
     * Method is used to get subscription details
     * @param int $subscriptionId 
     */
    public function getSubscriptionDetails($subscriptionId){
        $sql = "SELECT * FROM " . TABLE_PREFIX . "subscriptions where id='{$subscriptionId}'";
        return $this->fetchRows($sql);
    }
    
    /**
     * Method is used to get subscription customer details
     * @param int $subscriptionId 
     */
    public function getSubscriptionCustomer($subscriptionId){
        $sql = "SELECT * FROM " . TABLE_PREFIX . "subscription_customer where subscription_id='{$subscriptionId}' AND address_type='billing'";
        return $this->fetchRows($sql);
    }
    
     
    
    /**
     * Method is used to update paypal response
     * @param int $subscriptionId 
     * @param string $txn_id 
     */
    protected function updatePaypalReturn($subscriptionId, $txn_id){
        $sql = "update " . TABLE_PREFIX . "subscriptions  SET status='paid', transaction_id='{$txn_id}' where id='{$subscriptionId}' ";
        $this->dbQuery($sql);
    }

    /**
     * @author Praveen Paliya 22/June/2017
     * @use Method is used for save product review
     */
    public function saveProductReview() {
        $this->insertForm(TABLE_PREFIX . "product_reviews");
    }

    /**
     * @author Praveen Paliya 22/June/2017
     * @use Method is used for get product review
     */
    public function getProductReview($product_id) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "product_reviews WHERE product_id = {$product_id}";
        return $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya 23/June/2017
     * @use Method is used for get product review
     */
    public function getCustomOptions($product_id) {
        $sql = "SELECT * FROM " . TABLE_PREFIX . "custom_option WHERE catalog_id = {$product_id} ORDER BY sort_order ASC";
        return $this->dbFetch($sql);
    }

    /**
     * @author Praveen Paliya 13/june/2017
     * @uses Method is used to record for creating menu
     */
    public function getCatlogEntryRecord($product_id) {
       $sql = "SELECT c.*, ce.*, b.brand_name FROM " . TABLE_PREFIX . "catalog c
                LEFT JOIN " . TABLE_PREFIX . "catalog_entry ce
                ON c.catalog_id = ce.catalog_id
                LEFT JOIN " . TABLE_PREFIX . "brands b
                ON c.brand_id = b.brand_id
                WHERE ce.field_code = 'name' AND ce.lang_id = '" . DEFAULT_LANG . "' AND c.catalog_id = '{$product_id}'
                ";

        return $this->dbFetch($sql);
    }
    
    
    public function bestProducts(){
        $sql = "SELECT * FROM tbl_catalog  ORDER BY catalog_id DESC LIMIT 4 
                ";     
        return $this->dbFetch($sql);        
    }

    
    /**
     * @uses Method used to update cart qty
     */
    public function varifyProductValue($pid) {
        $sql = "SELECT inventory,manage_inventory FROM " . TABLE_PREFIX . "catalog WHERE catalog_id = '" . $pid . "'";
        return $this->dbFetch($sql);
    }

    public function updateCart($cartid, $qty, $pid) {
        $sql = "UPDATE " . TABLE_PREFIX . "cart SET qty = '" . $qty . "' WHERE id = '" . $cartid . "' AND pid = '" . $pid . "' ";
        return $this->dbQuery($sql);
    }
    
    
    protected function addRelatedProducts($relatedProductArray, $catalogId, $isInsert=false){
        $relatedProduct = implode(',', $relatedProductArray);
        $isExist = $this->getAllRelatedProducts($catalogId);
       
        if(empty($isExist)){
            $isInsert = true;
        }
        
        if($isInsert){
           $sql = "INSERT INTO " . TABLE_PREFIX . "catalog_related_product (catalog_id, related_product_id) VALUES('{$catalogId}', '{$relatedProduct}')";
           $this->insertQuery($sql);
        }else{
            $this->dbQuery("UPDATE " . TABLE_PREFIX . "catalog_related_product set related_product_id='" . $relatedProduct . "' WHERE catalog_id='" . $catalogId . "' ");
        }
    }
    
    public function getAllProducts($fieldsArray='', $catalogId=''){
        $fieldsList = '';
        $where = '';
        if(!empty($fieldsArray)){
            foreach($fieldsArray as $field){
                $fieldsList .= 'c.'.$field.',';
            }
            $fieldsList = rtrim($fieldsList, ',');
        }else{
            $fieldsList = 'c.*';
        }
        
        if(!empty($catalogId)){
            $where = " WHERE c.catalog_id = '{$catalogId}'";
        }
        
           $sql = "SELECT {$fieldsList}, cc.`category_id` 
                        FROM " . TABLE_PREFIX . "catalog c

                        LEFT JOIN " . TABLE_PREFIX . "catalog_category cc
                        ON cc.catalog_id =  c.catalog_id
                        
                        $where

                        ORDER BY c.catalog_id DESC 
                       "; 
           return $this->dbFetch($sql);
    }
    public function getAllRelatedProducts($catalogId){
            $sql = "SELECT *
                    FROM " . TABLE_PREFIX . "catalog_related_product 
                        WHERE catalog_id = {$catalogId}
                       "; 
           return $this->fetchRows($sql);
    }
    
}
