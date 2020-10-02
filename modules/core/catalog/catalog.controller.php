<?php
class catalog extends catalogModel {
    public $arrayData;
    private $editProductId = 0;
    private $editCategoryId = 0;
    private $categoryBuild;
    private $productCategories;
    private $catObject;
    private $objIsp;
    private $activeLanguages;
    private $sortedCategories;
    private $limit = 0;
    private $codeTitle;
    private $customerObj;
    private $productType;
    private $subsciptionProductData;
    public $productReview;
    private $captchaText;
    private $brand;
    private $objPayment;
    private $objMainframe;
    private $countries;
    private $subscriptionPrice;
    public $pageType;
    public $categoryId;
    public $childCategory;
    public $shippingMethod;
    private $objShipping;
    private $objSettings;
    private $productData;
    private $relatedProductData;
    private $cart_count;
    private $args;
    private $category_url;
    private $product_url;
    private $stripe_session;
    private $pageTitle;

    public function __Construct($objMainframe = '') {
        if (!is_object($objMainframe)) {
            global $objMainframe;
        }
        $this->category_url = 'catalog/showcategory/id/';
        $this->product_url = 'catalog/viewProductDetails/id/';

        parent :: __Construct($this->category_url, $this->product_url);
        $this->recursiveCategories(0);
        $this->objIsp = new ISP();
        $this->activeLanguages = $this->objIsp->listLanguages();
        $this->customerObj = new customer();
        $this->objMainframe = $objMainframe;
        $this->countries = $this->getAllCountries();
        $this->objSettings = new settings();
    }

    public function index() {
        $this->productList(); 
    }
    
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon-barcode icon-blue" aria-hidden="true"></i> Catalog' => array(
                'Manage Categories' => 'catalog/categories',
                'Manage Products' => 'catalog/listing'
            )
        );
        return $menu_array;
    }

    public function listAllActiveCategories($parent) {
        return $this->getChildCategories($parent);
    }

    public function allcategorylist() {
        $categories = $this->listAllActiveCategories(0);
        ?>
        <ul>
        <?php
        foreach ($categories as $objcategory) {
        ?>
         <li><a href="#cat-<?php echo $objcategory->category_id;?>"><?php echo $this->getCategoryAttributeValueModel($objcategory->category_id, 'cat_name');?></a></li>
        <?php
        }
        ?>

        </ul>
        <?php
        foreach ($categories as $cobj) {
            $this->editCategoryId = $cobj->category_id;
            $this->pageTitle = $this->getCategoryAttributeValueModel($this->editCategoryId, 'cat_name');
            $this->loadTheme('category-info');
        }
    }

    public function showPrice($catalogId, $showCurrency = true) {
        $objProduct = $this->getProductDetails($catalogId);
        $today = date('Y-m-d');
        $productPrice = 0;
        if ($objProduct->special_price > 0) {
            if ($objProduct->special_price_start_date == '0000-00-00' && $objProduct->special_price_end_date == '0000-00-00') {
                $productPrice = $objProduct->special_price;
            } elseif ($objProduct->special_price_end_date == '0000-00-00' && $objProduct->special_price_start_date != '0000-00-00' && $objProduct->special_price_start_date <= $today) {
                $productPrice = $objProduct->special_price;
            } elseif ($objProduct->special_price_end_date != '0000-00-00' && ($objProduct->special_price_start_date == '0000-00-00' || $objProduct->special_price_start_date <= $today) && $objProduct->special_price_end_date >= $today) {
                $productPrice = $objProduct->special_price;
            }
        } else {
            if (!empty($_SESSION['uid'])) {
                $this->customerObj->getCustomer($_SESSION['uid']);
                $arrCustomer = $this->customerObj->arrayData;
                $productPrice = $this->groupPrice[$arrCustomer['customer_group']]['price'];
            } else
                $productPrice = $objProduct->price;
        }

        $taxRate = $this->varifyTaxes($objProduct);

        if (!empty($taxRate) && $objProduct->show_price_with_tax == '1') {
            $tax = ($productPrice * $taxRate) / 100;
            $productPrice = $productPrice + $tax;
        }

        $productPrice = $this->showPriceConverted($productPrice);

        if ($showCurrency == true)
            return CURRENCY . $productPrice;
        else
            return $productPrice;
    }

    public function showProductWithTax($catalogId, $showCurrency = true, $addTax = 1) {
        $objProduct = $this->getProductDetails($catalogId);
        $today = date('Y-m-d');
        $productPrice = 0;

        if ($objProduct->special_price > 0) {
            if ($objProduct->special_price_start_date == '0000-00-00' && $objProduct->special_price_end_date == '0000-00-00') {
                $productPrice = $objProduct->special_price;
            } elseif ($objProduct->special_price_end_date == '0000-00-00' && $objProduct->special_price_start_date != '0000-00-00' && $objProduct->special_price_start_date <= $today) {
                $productPrice = $objProduct->special_price;
            } elseif ($objProduct->special_price_end_date != '0000-00-00' && ($objProduct->special_price_start_date == '0000-00-00' || $objProduct->special_price_start_date <= $today) && $objProduct->special_price_end_date >= $today) {
                $productPrice = $objProduct->special_price;
            }
        } else {
            if (!empty($_SESSION['uid'])) {
                $this->customerObj->getCustomer($_SESSION['uid']);
                $arrCustomer = $this->customerObj->arrayData;
                $productPrice = $this->groupPrice[$arrCustomer['customer_group']]['price'];
            } else
                $productPrice = $objProduct->price;
        }

        if ($productPrice == '') {
            $productPrice = $objProduct->price;
        }

        $taxRate = $this->varifyTaxes($objProduct);

        if (!empty($taxRate) && $addTax == 1) {

            $tax = ($productPrice * $taxRate) / 100;
            $productPrice = $productPrice + $tax;
        }

        $productPrice = $this->showPriceConverted($productPrice);

        if ($showCurrency == true)
            return CURRENCY . $productPrice;
        else
            return $productPrice;
    }

    private function showPriceConverted($price) {
        if(trim(DEFAULT_CURRENCY) != trim(CURRENCY_CODE)) {
            $priceConversionRate = $this->objSettings->getCurrencyRate(DEFAULT_CURRENCY, CURRENCY);
            $updatedPrice = round($price*$priceConversionRate, 2);
            return $updatedPrice;
        }
        else {
            return $price;
        }
    }

    public function varifyTaxes($objProduct=null) {
        $taxRate = '';

        if ($_REQUEST['country'] <>'' && $_REQUEST['state'] <> '' && $_REQUEST['is_ajax']==1) {

            $taxDetails = $this->getTaxDetails(urldecode($_REQUEST['country']), urldecode($_REQUEST['state']));
            $taxRate = $taxDetails[0]->tax_rate;
            echo $taxRate;
        }
        if (!empty($_SESSION['uid'])) {

            $userDetail = $this->getUserCountry($_SESSION['uid']);

            $userCountryId = $userDetail[0]->country;
            $userState = $userDetail[0]->state;

            $taxDetails = $this->getTaxDetails($userCountryId, $userState);

            $taxRate = $taxDetails[0]->tax_rate;
            return $taxRate;
        }

    }

    public function search() {
        $text = trim($_GET['search']);
        $this->arrayData = $this->loadFilteredProducts($text);
        $this->objMainframe->setPageTitle('Search Result');
        $this->pageTitle = "Search Results for '".$text."'";
        $this->objMainframe->setPageHeading('Search Result(s)');
        $this->loadTheme('product-list');

    }

    public function showcategory() {
        $cid = $_GET['id'];
        $this->editCategoryId = $cid;
        $this->arrayData = $this->loadCategoryProducts($cid);

        /* Set Product Meta */
        $metaTitle = $this->getCategoryAttributeValue($cid, 'meta_title', $_SESSION['lang']->lang_id);
        $metaKeywords = $this->getCategoryAttributeValue($cid, 'meta_keywords', $_SESSION['lang']->lang_id);
        $metaDesc = $this->getCategoryAttributeValue($cid, 'meta_desc', $_SESSION['lang']->lang_id);

        $this->objMainframe->setPageTitle($metaTitle);
        $this->objMainframe->setMetaKeywords($metaKeywords);
        $this->objMainframe->setMetaDescription($metaDesc);
        //$this->objMainframe->setPageHeading($this->getCategoryAttributeValueModel($cid, 'cat_name'));

        $bannerImg = $this->getCategoryAttributeValueModel($cid, 'cat_banner');
        mainframe :: setPageBanner($bannerImg);

        /* End of Meta */

        $this->pageTitle = $this->getCategoryAttributeValueModel($this->editCategoryId, 'cat_name');

        $this->loadTheme('product-list');
    }
    
    public function productList() {
        $this->objMainframe->setBreadCrumTitle('Shop');
        
        $this->categoryId = intval($_GET['id']);
        $this->arrayData = $this->loadCategoryProducts($this->categoryId);
        $this->childCategory = $this->getChildCategories($this->categoryId);
        $this->pageType = 'product';

        $this->pageTitle = $this->getCategoryAttributeValueModel($this->categoryId, 'cat_name');
        $this->loadTheme('product-list');
    } 
    
    public function onlineShop() {
        $this->categoryBuild = $this->getParentCategories();
        unset($this->pageType);
        $this->loadTheme('product-categories'); 
    }
      
    public function shopProductList() {
        $this->categoryId = $_GET['id'];
        $this->arrayData = $this->loadCategoryProducts($this->categoryId);
        $this->childCategory = $this->getChildCategories($this->categoryId);
        unset($this->pageType);

        $this->pageTitle = $this->getCategoryAttributeValueModel($this->categoryId, 'cat_name');
        $this->loadTheme('product-list');
    } 

    private function loadTheme($tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/catalog/front/views/" . $tpl . ".php")) {
            include("modules/vendor/catalog/front/views/" . $tpl . ".php");
        } else {
            include('views/front/' . $tpl . '.php');
        }
    }

    public function listing() {
        $this->arrayData = $this->getAllProducts();
        $this->loadView();
    }

    public function callShortCode($args) {
        $this->args = $args;

        $func = $args['call'];
        $id = $args['id'];
        $this->limit = $args['limit'];

        if ($func <> "") {
            $this->$func();
        }
    }

    private function featured() {
        $this->arrayData = $this->loadFeatured($this->limit);
        $this->codeTitle = 'Featured Letters';
        $this->loadTheme('shortcode-view');
    }

    private function newproducts() {
        $this->arrayData = $this->loadNewProducts($this->limit);
        $this->codeTitle = 'New Products';
        $this->loadTheme('shortcode-view');
    }

    private function categorywidget() {
        $cid = $this->args['cid'];
        if ($cid == 'all')
            unset($cid);
        $this->arrayData = $this->listAllCategories($cid);
        $this->codeTitle = '';
        $this->loadTheme('shortcode-category');
    }

    public function categories() {
        $this->recusiveCategoriesTreeHtml($this->categoryArray[0]);
        $this->loadView('admin/cat-listing');
    }

    public function addnewcategory() {
        $this->recusiveCategoriesTreeHtml($this->categoryArray[0]);
        $this->loadView('admin/categoryform');
    }

    public function editcategory() {
        if ($_GET['cid'] > 0) {
            $this->editCategoryId = $_GET['cid'];
            $this->catObject = $this->getCategoryDetails($this->editCategoryId);
            $this->recusiveCategoriesTreeHtml($this->categoryArray[0]);
        }
        $this->loadView('admin/categoryform');
    }

    public function copyproduct() {
        $pid = $_GET['id'];
        $this->duplicateProduct($pid);
        $this->__doRedirect(mainframe::__adminBuildUrl('catalog/listing'));
    }

    public function savecategory() {
        if ($this->postedData['id'] > 0) {
            $this->updateCategory($this->postedData['id']);
            mainframe :: setSuccess('Category updated sucessfully.');
        } else {
            $this->addCategory();
            mainframe :: setSuccess('Category added sucessfully.');
        }

        $this->__doRedirect(mainframe::__adminBuildUrl('catalog/categories'));
    }

    public function deletecategory() {
        $cid = $_GET['cid'];
        $this->deleteCategories($cid);
        mainframe :: setSuccess('Category deleted sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('catalog/categories'));
    }

    public function removeproduct() {
        $pid = $_GET['id'];
        $this->deleteProduct($pid);
        mainframe :: setSuccess('Product deleted sucessfully.');
        $this->__doRedirect(mainframe::__adminBuildUrl('catalog/listing'));
    }

    public function addproduct() {
        
        #for save related products
        if (!empty($this->postedData)) {
            if ($this->saveProduct()) {
                mainframe :: setSuccess('Product added sucessfully.');
                if ($this->postedData['saveexit'])
                    $this->__doRedirect(mainframe::__adminBuildUrl('catalog/listing'));
                else
                    $this->__doRedirect(mainframe::__adminBuildUrl('catalog/addproduct'));
            }
            else {
                mainframe :: setError('Oops! Product could not add. Please try again');
                $this->arrayData = $this->filterPostedData();
            }
        }
        $this->recusiveCategoriesHtml($this->categoryArray[0]);
        
        #for realeted products
        $fieldsList = ['catalog_id','sku','image', 'price'];
        $this->productData = $this->getAllProducts($fieldsList);
        
        $this->loadView('admin/catalogform');
    }

    public function editproduct() {

        $this->editProductId = $_REQUEST['id'];
        
        #for realeted products
        $fieldsList = ['catalog_id','sku','image', 'price'];
        $this->productData = $this->getAllProducts($fieldsList);
        $this->relatedProductData = $this->getAllRelatedProducts($this->editProductId);
        
        
        if (!empty($this->postedData)) {
            $this->updateProduct($this->editProductId);
            mainframe :: setSuccess('Product updated sucessfully.');
            if ($this->postedData['saveexit'])
                $this->__doRedirect(mainframe::__adminBuildUrl('catalog/listing'));
            else
                $this->__doRedirect(mainframe::__adminBuildUrl('catalog/addproduct'));
        }
        else {
            if (!filter_var($this->editProductId, FILTER_VALIDATE_INT) === false) {
                $dataObject = $this->getProductDetails($this->editProductId);
                $this->arrayData = (array) $dataObject;
                $this->productCategories = $this->getProductCategories($this->editProductId);
                $this->recusiveCategoriesHtml($this->categoryArray[0]);
                $this->categoryBuild;
                $this->loadView('admin/catalogform');
            } else {
                mainframe :: setError('There is some issue in edit. Please try again.');
                $this->__doRedirect(mainframe::__adminBuildUrl('catalog/listing'));
            }
        }
    }

    public function getCategoryAttributeValue($category_id, $field) {
        return $this->getCategoryAttributeValueModel($category_id, $field);
    }

    private function recusiveCategoriesHtml($categoryDataArray) {
        $this->categoryBuild .= '<ul class="cathiererchy">';
        foreach ($categoryDataArray as $parent => $child) {
            $sel = '';

            $this->categoryBuild .= '<li>';
            if (in_array($child->category_id, $this->productCategories))
                $sel = 'checked';

            $catName = $this->getCategoryAttributeValue($child->category_id, 'cat_name');
            $this->categoryBuild .= '<input type="checkbox" value="' . $child->category_id . '" ' . $sel . ' name="cat[]"> <label>' . $catName . '</label>';
            if ($this->categoryArray[$child->category_id])
                $this->recusiveCategoriesHtml($this->categoryArray[$child->category_id]);
            $this->categoryBuild .= '</li>';
        }
        $this->categoryBuild .= '</ul>';
    }

    private function recusiveCategoriesTreeHtml($categoryDataArray, $indent = '') {

        foreach ($categoryDataArray as $parent => $child) {
            $sel = '';

            $this->categoryBuild .= '<option ';
            if ($child->category_id == $this->catObject->parent_cat)
                $sel = 'selected';

            $catUrl = mainframe::__adminBuildUrl('catalog/categories/cid/' . $child->category_id);

            $catName = $this->getCategoryAttributeValue($child->category_id, 'cat_name');

            $this->categoryBuild .= $sel . ' value="' . $child->category_id . '">' . $indent . $catName . '</option>';
            $editUrl = mainframe::__adminBuildUrl('catalog/editcategory/cid/' . $child->category_id);
            $removeUrl = mainframe::__adminBuildUrl('catalog/deletecategory/cid/' . $child->category_id);

            $this->sortedCategories .= '<tr>';
            $this->sortedCategories .= '<td>' . $indent . $catName . '</td>';
            $this->sortedCategories .= '<td>' . $child->category_id . '</td>';
            $this->sortedCategories .= '<td class="noExl"><a href="" class="text-muted" id="actionDropdown" data-toggle="dropdown"><span class="material-icons md-20 align-middle">more_vert</span></a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown">';

            $this->sortedCategories .= '<a href="' . $editUrl . '" class="dropdown-item">Edit</a>';

            $this->sortedCategories .= '<a href="' . $removeUrl . '" class="dropdown-item">Delete</a></div>';

            $this->sortedCategories .= '</td>';
            $this->sortedCategories .= '</tr>';

            if ($this->categoryArray[$child->category_id])
                $this->recusiveCategoriesTreeHtml($this->categoryArray[$child->category_id], $indent . ' &mdash;');
        }
    }

    public function getAttribute($pid, $code) {
        return $this->getAttributeValue($pid, $code);
    }

    public function viewdetails() {
        #get product id
        $pid = $_REQUEST['id'];
        $this->pageType = 'product';

        if (!empty($_REQUEST['ptyp'])) {  // Added by Praveen Paliya 15/June/2017
            $this->productType = $_REQUEST['ptyp'];
            
            unset($this->pageType);
              
            #get subscription price
            $subscriptionPrice = $this->getSubscriptionProduct($pid);

            #set subscription type
            foreach ($subscriptionPrice as $productPrice) {
                switch ($productPrice->subscription_type) {
                    case 1: $productPrice->subscription_title = 'Weekly Subscription';
                        break;
                    case 2: $productPrice->subscription_title = 'Monthly Subscription';
                        break;
                    case 3: $productPrice->subscription_title = 'Quarterly Subscription';
                        break;
                    case 4: $productPrice->subscription_title = 'Half Yearly Subscription';
                        break;
                    case 5: $productPrice->subscription_title = 'Yearly Subscription';
                        break;
                    default:
                        $productPrice->subscription_title = 'Other Subscription';
                        break;
                }
            }

            #get Subscription products
            $this->subsciptionProductData = $subscriptionPrice;
        }

        #product details
        $this->arrayData = $this->getProductDetails($pid);

        $this->customOptions = $this->getCustomOptions($pid);

        #generate view of custom options  
        $this->genrateCustomOption($this->customOptions, $this->showProductWithTax($pid, false, 0));

        #product review: Added by Praveen Paliya 28/June/2017
        $this->productReview = $this->getProductReview($pid);

        #get brand: Added by Praveen Paliya 28/June/2017
        $brandObj = new brands();
        $brandObj->getBrands($this->arrayData->brand_id);
        $this->brand = $brandObj->arrayData;

        /* Set Product Meta */
        $metaTitle = $this->getAttributeValue($pid, 'meta_title', $_SESSION['lang']->lang_id);
        $metaKeywords = $this->getAttributeValue($pid, 'meta_keywords', $_SESSION['lang']->lang_id);
        $metaDesc = $this->getAttributeValue($pid, 'meta_desc', $_SESSION['lang']->lang_id);

        $this->objMainframe->setPageTitle($metaTitle);
        $this->objMainframe->setMetaKeywords($metaKeywords);
        $this->objMainframe->setMetaDescription($metaDesc);
        $this->relatedProductData = $this->getAllRelatedProducts($pid);
        /* End of Meta */

        #load theme
        $this->loadTheme('product-details');
        
        if(!empty($_GET['qv'])){
            die;
        }
    }
    
    public function viewProductDetails() {
        #get product id
        $pid = $_REQUEST['id'];

        if (!empty($_REQUEST['ptyp'])) {
            $this->productType = $_REQUEST['ptyp'];

            #get subscription price
            $subscriptionPrice = $this->getSubscriptionProduct($pid);

            #set subscription type
            foreach ($subscriptionPrice as $productPrice) {
                switch ($productPrice->subscription_type) {
                    case 1: $productPrice->subscription_title = 'Weekly Subscription';
                        break;
                    case 2: $productPrice->subscription_title = 'Monthly Subscription';
                        break;
                    case 3: $productPrice->subscription_title = 'Quarterly Subscription';
                        break;
                    case 4: $productPrice->subscription_title = 'Half Yearly Subscription';
                        break;
                    case 5: $productPrice->subscription_title = 'Yearly Subscription';
                        break;
                    default:
                        $productPrice->subscription_title = 'Other Subscription';
                        break;
                }
            }

            #get Subscription products
            $this->subsciptionProductData = $subscriptionPrice;
        }

        #product details
        $this->arrayData = $this->getProductDetails($pid);

        //$this->customOptions = $this->getCustomOptions($pid);
        $this->customOptions = $this->getCustomOptions($pid);

        #generate view of custom options
        $this->genrateCustomOption($this->customOptions, $this->showProductWithTax($pid, false, 0));

        #product review: Added by Praveen Paliya 28/June/2017
        $this->productReview = $this->getProductReview($pid);

        $brandObj = new brands();
        $brandObj->getBrands($this->arrayData->brand_id);
        $this->brand = $brandObj->arrayData;

        /* Set Product Meta */
        $metaTitle = $this->getAttributeValue($pid, 'meta_title', $_SESSION['lang']->lang_id);
        $metaKeywords = $this->getAttributeValue($pid, 'meta_keywords', $_SESSION['lang']->lang_id);
        $metaDesc = $this->getAttributeValue($pid, 'meta_desc', $_SESSION['lang']->lang_id);

        $productCategories = $this->getProductCategories($this->arrayData->catalog_id);
        $cid = $productCategories[0];
        $catDetails = $this->getCategoryDetails($cid);
        $catName = $this->getCategoryAttributeValue($catDetails->category_id, 'cat_name', 1);

        $this->objMainframe->setBreadCrumTitle($catName, SITE_URL.$catDetails->seo_url);

        $this->objMainframe->setBreadCrumTitle($this->getAttribute($this->arrayData->catalog_id, 'name'));
        $this->objMainframe->setPageTitle($metaTitle);
        $this->objMainframe->setMetaKeywords($metaKeywords);
        $this->objMainframe->setMetaDescription($metaDesc);
        $this->objMainframe->setOgMetaTags(
            array(
                'og:title' => $this->getAttribute($this->arrayData->catalog_id, 'name'),
                'og:image' => SITE_URL . SITE_UPLOADPATH . $this->arrayData->image,
                'og:url' => $this->getUrl($this->product_url.$this->arrayData->catalog_id)
            )
        );
        $this->relatedProductData = $this->getAllRelatedProducts($pid);

        /* End of Meta */

        $bannerImg = $this->getCategoryAttributeValueModel($cid, 'cat_banner');
        mainframe :: setPageBanner($bannerImg);
        
        #load theme
        $this->loadTheme('product-details');
        
        if(!empty($_GET['qv'])){
            die;
        }
    }

    public function genrateCustomOption($customOptions, $productPrice=0) {
        foreach ($customOptions as $options):
            $option_values = json_decode($options->option_values);
            $optiondata = '';
            $is_required = ($options->is_required)?'required':'';
            switch ($options->option_type) {
                case "select":
                    $optiondata .= "<select class='sel2' name='custom_option[{$options->option_id}][value]' ".$is_required.">";
                    $optiondata .= "<option value=''>--Select--</option>";
                    foreach ($option_values->value_title as $key => $title) {
                        $optionPrice = $option_values->value_price[$key];

                        if ($option_values->value_price_type[$key] == 'fixed') {
                            $price = $optionPrice;
                        }
                        else {
                            $price_format = ($productPrice*$optionPrice)/100;

                            list($whole, $decimal) = explode('.', $price_format);
                            $decimal = substr($decimal, 0, 2);
                            if ($decimal < 50)
                                $decimal = 0.5;
                            else
                                $decimal = 1;

                            $price = $whole + $decimal;
                        }
                        
                        //if (intval($optionPrice) > 0)
                        $optionProductPrice = CURRENCY . round($productPrice+$price, 2);
                        //else
                        //    $optionPrice = $productPrice;

                        $value = $price . "|" . $title;
                        $optiondata .= "<option value='{$value}'>{$title} " . $optionProductPrice ."</option>";
                    }
                    $optiondata .= "</select>";
                    $optiondata .= "<input type='hidden' name='custom_option[{$options->option_id}][title]' value='{$options->option_title}'>";
                    $options->option_values = $optiondata;
                    break;
                case "radio":
                case "checkbox":
                    foreach ($option_values->value_title as $key => $title) {
                        $optionPrice = $option_values->value_price[$key];
                        $price = $optionPrice;
                        if (intval($optionPrice) > 0)
                            $optionPrice = '+ ' . CURRENCY . $optionPrice;
                        $value = $price . "|" . $title;
                        $optiondata .= "<input type='{$options->option_type}' name='custom_option[{$options->option_id}][value]' value='{$value}'>  " . $title . ' ' . $optionPrice;
                        $optiondata .= "<input type='hidden' name='custom_option[{$options->option_id}][title]' value='{$options->option_title}'>";
                        $optiondata .= "<br>";
                    }
                    $options->option_values = $optiondata;
                    break;

                case "textarea":
                    foreach ($option_values->value_title as $key => $title) {
                        $optionPrice = $option_values->value_price[$key];
                        $price = $optionPrice;
                        if (intval($optionPrice) > 0)
                            $optionPrice = '+ ' . CURRENCY . $optionPrice;
                        $value = $price . "|" . $title;
                        $optiondata .= "<textarea name='custom_option[{$options->option_id}][value]' style='height: 150px; width: 100%;' ".$is_required."></textarea>";
                        $optiondata .= "<input type='hidden' name='custom_option[{$options->option_id}][title]' value='{$options->option_title}'>";
                        $optiondata .= "<br>";
                    }
                    $options->option_values = $optiondata;
                    break;

                default:
                    break;
            }

        endforeach;
    }

    public function addlabelcart() {
        $rates = (array)json_decode(base64_decode($_REQUEST['data']));
        $custom_option['from_zip']['value'] = '0|Shipping Details';

        foreach($rates as $key=>$val) {
            $rateDetails .="<h6>".$key."</h6>";
            $arrval = (array)$val;
            
            foreach ($arrval as $key1 => $val1) {
                $rateDetails .= $key1.":".$val1. "<br>";
            }
            //$rateDetails .= $key.": ".$val.'<br>';
        }

        $custom_option['customer_comments']['value'] = $rateDetails;

        $this->addProductinCart(14, 1, $rates['Package Details']->Amount, json_encode($custom_option));

    ?>
        <script>window.top.location = '/catalog/checkout';</script>
    <?php
    }

    public function addtocart() {
        if ($_POST['custom_option']['customer_comments']['value'] <> '') {
            $_POST['custom_option']['customer_comments']['value'] = nl2br($_POST['custom_option']['customer_comments']['value']);
        }

        $custom_option = json_encode($_POST['custom_option']);
        $custom_price = 0;

        foreach ($_POST['custom_option'] as $option) {
            $optionArr = explode('|', $option['value'], 2);
            $custom_price += $optionArr[0];
        }

        $catalogId = trim($_REQUEST['catalog_id']);
        $qty = trim($_REQUEST['qty']);
        $price = $this->showProductWithTax($catalogId, false, 0);
        $price += $custom_price;
        $price = round($price, 2);

        $this->addProductinCart($catalogId, $qty, $price, $custom_option);
        $this->__doRedirect(SITE_URL . 'catalog/cart');
    }

    public function getCarItems() {
        $this->arrayData = $this->loadShoppingCart();
    }

    public function cart() {
        $this->objMainframe->setPageHeading($this->__t('Shopping Cart'));
        $this->objMainframe->setBreadCrumTitle($this->__t('Shopping Cart'));
        $this->getCarItems();
        $this->loadTheme('shopping-cart');
    }

    public function shippingDetails() {
        $this->objShipping = new shipping();
        $this->shippingMethod = $this->objShipping->activeShipping();
        $this->loadTheme('shipping.tpl');
    }

    public function checkout() {
        //$this->checkCustomerSession();

        $this->getCarItems();

        if(empty($this->arrayData)) {
            $this->__doRedirect(SITE_URL . 'catalog/cart');
        }
	// $this->objMainframe->setPageHeading($this->__t('Checkout'));
        $this->objMainframe->setBreadCrumTitle($this->__t('Checkout'));

        #get payment method: Added by Praveen Paliya 28/June/2017
        $this->objPayment = new payment();
        $this->objPayment->listPayment(1);
        $this->paymentMethod = $this->objPayment->arrayData;

        $this->objShipping = new shipping();
        $this->shippingMethod = $this->objShipping->activeShipping();

        \Stripe\Stripe::setApiKey('sk_test_mPpyyrHygt0WLxjiva2p48jG00Nwtnevi7');
        $this->stripe_session = \Stripe\Checkout\Session::create([
          'payment_method_types' => ['card'],
          'line_items' => [[
            'name' => 'T-shirt',
            'description' => 'Comfortable cotton t-shirt',
            'images' => ['https://example.com/t-shirt.png'],
            'amount' => 200,
            'currency' => 'usd',
            'quantity' => 1,
          ]],
          'success_url' => SITE_URL.'/orders/stripeReturn?session_id={CHECKOUT_SESSION_ID}',
          'cancel_url' => SITE_URL.'/catalog/cart',
        ]);

        $this->loadTheme('checkout');
    }

    public function checkoutSubscription() {

        #get product price details
        $this->subscriptionPrice = $this->getSubscriptionProduct($_POST['productId'], $_POST['subscriptionType']);

        #get product details
        $this->subsciptionProductData = $this->getProductDetails($_POST['productId']);

        #get payment method: Added by Praveen Paliya 28/June/2017
        $this->objPayment = new payment();
        $this->objPayment->listPayment(1);
        $this->paymentMethod = $this->objPayment->arrayData;
        $this->loadTheme('checkoutSubscription');
    }

    public function paySubscription() {

        #save subscription
        $newSubscribedId = $this->saveSubscription();

        #handel paymment
        $objPayment = new payment();
        $objPayment->processSubscriptionPayment($newSubscribedId);

        #redirect
        $this->__doRedirect(mainframe::__BuildUrl('catalog/subscriptionProducts'));
    }

    public function subcriptionPaypalreturn() {
        $this->__doRedirect(mainframe::__BuildUrl('catalog/subscriptionProducts'));
    }

    private function checkPaypalReturn() {
        // Check to see there are posted variables coming into the script
        if ($_SERVER['REQUEST_METHOD'] != "POST")
            die("No Post Variables");
        // Initialize the $req variable and add CMD key value pair
        $req = 'cmd=_notify-validate';
        // Read the post from PayPal
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        // Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
        // We will use CURL instead of PHP for this for a more universally operable script (fsockopen has issues on some environments)
        //$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        $url = "https://www.paypal.com/cgi-bin/webscr";
        $curl_result = $curl_err = '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $curl_result = @curl_exec($ch);
        $curl_err = curl_error($ch);
        curl_close($ch);

        $req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting
        // Check that the result verifies
        if (strpos($curl_result, "VERIFIED") !== false) {
            $req .= "\n\nPaypal Verified OK";
        } else {
            $req .= "\n\nData NOT verified from Paypal!";
            $receiver_email = $_POST['receiver_email'];
            if ($receiver_email != "you@youremail.com") {
                //handle the wrong business url
                exit(); // exit script
            }
        
            if ($_POST['payment_status'] != "Completed") {
                // Handle how you think you should if a payment is not complete yet, a few scenarios can cause a transaction to be incomplete
            }

            // Check number 3 ------------------------------------------------------------------------------------------------------------
            $this_txn = $_POST['txn_id'];
            //check for duplicate txn_ids in the database
            // Check number 4 ------------------------------------------------------------------------------------------------------------
            $product_id_string = $_POST['custom'];
            $product_id_string = rtrim($product_id_string, ","); // remove last comma
            // Explode the string, make it an array, then query all the prices out, add them up, and make sure they match the payment_gross amount
            // END ALL SECURITY CHECKS NOW IN THE DATABASE IT GOES ------------------------------------
            ////////////////////////////////////////////////////
            // Homework - Examples of assigning local variables from the POST variables
            $txn_id = $_POST['txn_id'];
            $payer_email = $_POST['payer_email'];
            $custom = $_POST['custom'];
            // Place the transaction into the database
            // Mail yourself the details
            $subject = __t('Order hase been placed successfully');
            $req = '';
            //mail($payer_email, $subject, $req, "From:" . MAIL_FROM);
            $this->updatePaypalReturn($custom, $txn_id);
            $this->subscriptionMail($payer_email, $subject, "From:" . MAIL_FROM, $custom);
        }
    }
    
    public function subscriptionMail($customrEmail, $subject, $mailFrom, $subscriptionId) {
        #get product details
        $this->subsciptionProductData = $this->getProductDetails($subscriptionId);
        
        $messageBody="
                    <pre>
                     hi,
                     
                     Dear customer you have been subscribed {$this->getAttribute($this->subsciptionProductData->catalog_id, 'name')} on {$this->subsciptionProductData->added_at}.
                     
                    </pre>
                    ";
        mail($customrEmail, $subject, $messageBody, $mailFrom);
    }
    
    public function unsubscriptionMail($customrEmail, $subject, $mailFrom, $subscriptionId) {
        #get product details
     
        $this->subsciptionProductData = $this->getProductDetails($subscriptionId);
        $date = date('Y-m-d h:i a');
        $messageBody="
                    <pre>
                     hi,
                     
                     Dear customer you have been unsubscribed {$this->getAttribute($this->subsciptionProductData->catalog_id, 'name')} on {$date}.
                     
                    </pre>
                    ";
             
        mail($customrEmail, $subject, $messageBody, $mailFrom);
    }

    public function removecart() {
        $pid = $_GET['pid'];
        $this->removeProductfromCart($pid);
        unset($_SESSION['couponCode']);
        $this->__doRedirect(SITE_URL . 'catalog/cart');
    }

    public function clearCustomerCart() {
        $this->clearCart();
    }

    public function cartItemsCount() {
        return $this->totalItemsinCart();
    }

    private function loadView($template = 'admin/listing') {
        $this->checkAdminSession();
        include('views/' . $template . '.php');
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @use Method is used for download Product File in web page
     */
    public function downloadProductFile() {
        $catalog_id = $_GET['id']; // catalog id
        $productDetails = $this->getProductDetails($catalog_id); // product detail result
        $downloadFileName = $productDetails->upload_filename; // file name
        $downloadPath = SITE_UPLOADPATH; // dir path from file download 
        $outputFileName = 'download_' . $productDetails->upload_file_title; // output file name
        $this->downloadProductFileForce($downloadPath, $downloadFileName, $outputFileName); //Download file method call
        $this->viewdetails(); // redirect to view
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @use Method is used for download File 
     * @param string $downloadPath Path where the file is located 
     * @param string $downloadFileName Name of the file 
     * @param string $outputFileName Name of the output file 
     */
    private function downloadProductFileForce($downloadPath, $downloadFileName, $outputFileName) {
        ignore_user_abort(true);
        set_time_limit(0);
        $fullPath = $downloadPath . $downloadFileName; // full file path from download 

        if ($fd = fopen($fullPath, "r")) {
            $path_parts = pathinfo($fullPath);
            $fsize = filesize($fullPath);
            $ext = strtolower($path_parts["extension"]); //file extenction 

            $known_mime_types = array(
                "pdf" => "application/pdf",
                "txt" => "text/plain",
                "html" => "text/html",
                "htm" => "text/html",
                "exe" => "application/octet-stream",
                "zip" => "application/zip",
                "doc" => "application/msword",
                "docx" => "application/msword",
                "xls" => "application/vnd.ms-excel",
                "ppt" => "application/vnd.ms-powerpoint",
                "gif" => "image/gif",
                "png" => "image/png",
                "jpeg" => "image/jpg",
                "jpg" => "image/jpg",
                "php" => "text/plain"
            );

            foreach ($known_mime_types as $k => $v) {
                if ($ext == $k) {
                    $contentType = $v;
                }
            }

            header("Content-type: $contentType");
            header("Content-Disposition: attachment; filename=\"" . $outputFileName . "." . $ext . "\""); // use 'attachment' to force a file download
            header("Content-length: $fsize");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            ob_clean();
            flush();
            readfile($fullPath);
            fclose($fd);
            exit();
        }
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @use Method is used for delete Product File from folder and DB
     */
    public function deleteProductFile() {
        $catalog_id = $_GET['id']; // catalog id
        $productDetails = $this->getProductDetails($catalog_id); // product detail result
        $fileName = $productDetails->upload_filename; // file name
        $deletePath = SITE_UPLOADPATH . $fileName; // Path
        unlink($deletePath); //Delete file
        $this->deleteProductFileDetails($catalog_id); //Delete data frtom DB
        $this->listing(); // Redirect page
    }

    /**
     * @author Praveen Paliya 31/5/2017
     * @use Method is used for view stock in admin
     */
    public function stock() {
        $this->arrayData = $this->LoadAllProducts();
        $this->loadView('admin/viewStock');
    }

    /**
     * @author Praveen Paliya 23/5/2017
     * @uses Method is used for validate the customer's coupon code  
     * @return Json result object
     */
    public function varifyCoupon() {
        $result = null;

        if (empty($_SESSION['couponCode']) && $_POST['subTotal'] > 0) {

            $result = $this->varifyCouponValue($_POST['couponCode'], $_POST['subTotal']);

            if (!empty($result)) { // Check for non empty result
                if ($result->disc_type == 'percentage') { // Check for discount in percentage
                    $result->discount = ( $_POST['subTotal'] * $result->discount) / 100;
                }
                $_SESSION['couponCode'] = $result->coupon_code;
            }
        }
        echo json_encode($result);
        die;
    }

    /**
     * @uses Method is used for validate and calculate the customer's coupon code  
     * @return Json result object
     */
    public function checkCoupon($subTotal = 0) {
        $result = null;

        if (!empty($_SESSION['couponCode']) && $subTotal > 0) {
            $result = $this->varifyCouponValue($_SESSION['couponCode'], $subTotal);
            if (!empty($result)) { // Check for non empty result
                if ($result->disc_type == 'percentage') { // Check for discount in percentage
                    $result->discount = ( $subTotal * $result->discount) / 100;
                }
            }
        }
        return $result;
    }

    /**
     * @author Praveen Paliya 13/june/2017
     * @uses Method is used to record for creating menu
     */
    public function categoryMenu() {
        $allProducts = $this->menuCategoryRecord();
        $result = [];
        $i = 0;

        $result['value'][$i] = 'catalog';
        $result['title'][$i] = 'All Category';
        $i++;

        foreach ($allProducts as $data) {
            $result['value'][$i] = 'catalog/showcategory/id/' . $data->category_id;
            $result['title'][$i] = $data->field_value;
            $i++;
        }
        return $result;
    }

    /**
     * @author Praveen Paliya 13/june/2017
     * @uses Method is used to record for creating menu
     */
    public function productMenu() {
        $allProducts = $this->menuProductRecord();
        $result = [];
        $i = 0;

        $result['value'][$i] = 'catalog';
        $result['title'][$i] = 'All Products';
        $i++;
        foreach ($allProducts as $data) {
            $result['value'][$i] = 'catalog/viewdetails/id/' . $data->catalog_id;
            $result['title'][$i] = $data->field_value;
            $i++;
        }
        return $result;
    }

    /**
     * @author Praveen Paliya 15/June/2017
     * @uses Method is used to view subscription products
     */
    public function subscriptionProducts() {
        $this->arrayData = $this->getAllSubscriptionProducts();
        $this->loadTheme('product-subscription-list');
    }

    /**
     * @author Praveen Paliya 22/June/2017
     * @use Method is used for save product review
     */
    public function productReview() {

        if (!empty($_SESSION['uid'])) {
            $cId = $_SESSION['uid'];
            $this->customerObj->getCustomer($cId);
            $_POST['md_customer_name'] = $this->customerObj->arrayData['first_name'] . ' ' . $this->customerObj->arrayData['last_name'];
            $_POST['md_customer_email'] = $this->customerObj->arrayData['email'];
            $_POST['db_customer_id'] = $cId;
        }
        $this->saveProductReview();
        $this->__doRedirect(mainframe::__BuildUrl('catalog/viewdetails/id/' . $_POST['md_product_id']));
    }

    public function addwishlist() {
        if (!empty($_SESSION['uid'])) {
            $cId = $_SESSION['uid'];
            $pid = $_GET['id'];
            $this->addToWishlist($pid, $cId);
            $this->__doRedirect(mainframe::__BuildUrl('catalog/wishlist'));
        } else {

            $this->__doRedirect(mainframe::__BuildUrl('customer/login/redirect_to/' . base64_encode($_SERVER['SCRIPT_URL'])));
        }
    }

    public function removewishlist() {
        $this->removeProductfromWishList($_GET['id']);
        $this->__doRedirect(mainframe::__BuildUrl('catalog/wishlist'));
    }

    public function wishlist() {
        if (!empty($_SESSION['uid'])) {
            $cId = $_SESSION['uid'];
            $this->getWishListItems($cId);
            $this->loadTheme('wishlist-view');
        } else {

            $this->__doRedirect(mainframe::__BuildUrl('customer/login/redirect_to/' . base64_encode($_SERVER['SCRIPT_URL'])));
        }
    }
    
    /**
     * @uses Method used to update cart qty
     */
    public function updateQuantity() {
        $qty = $_POST['itemqty'];
        $catalog_id = $_POST['catalog_id'];
        $cart_id = $_POST['cart_id'];

        $result = $this->varifyProductValue($catalog_id);
        $magangeInventory = $result['manage_inventory'];
        $inventory = $result['inventory'];

        if ($magangeInventory != '1') {
            $this->updateCart($cart_id, $qty, $catalog_id);
            $result = $qty;
        } else {
            if ($qty > $inventory) {
                $this->updateCart($cart_id, $qty, $catalog_id);
                $result = 'not_update';
            } else if ($qty <= $inventory) {
                $this->updateCart($cart_id, $qty, $catalog_id);
                $result = $qty;
            }
        }

        echo json_encode($result);
        die;
    }
    
    public function setCompareProductList() {
        $response = [];
        if (!in_array($_POST['product_id'], $_SESSION['compare-product-list'])) {
            $_SESSION['compare-product-list'][] = $_POST['product_id'];
            $response['status'] = 'success';
        }else{
            $response['status'] = 'fail';
        }
        echo json_encode($response);
        die;
    }
    
    public function compareProducts() {
        $result = [];
        if(!empty($_SESSION['compare-product-list'])) {
            foreach($_SESSION['compare-product-list'] as $product_id) {
                $result[] = $this->getCatlogEntryRecord($product_id);
            }
        }

        $this->arrayData = $result;
        unset($_SESSION['compare-product-list']);
        $this->loadTheme('product-compare-list');
        //die;
    }
}
