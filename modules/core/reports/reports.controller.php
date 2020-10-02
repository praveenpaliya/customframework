<?php

/**
 * @author Praveen Paliya 05/June/2017
 * @uses This controller class is used for mange the Reports module
 */
class reports extends reportsModel {

    private $objIsp;
    private $orderData;
    private $productData;
    private $customerData;
    private $paymentData;

    public function __Construct() {
        parent :: __Construct();
        $this->objIsp = new ISP();
        $this->activeLanguages = $this->objIsp->listLanguages();
    }

    public static function adminMenuItems() {
    $menu_array = array(
        '<i class="icon icon-bar-chart"></i> Reports' => array(
            'Orders Report' => 'reports/orderReport',
            'Products Report' => 'reports/productReport',
            'Cutomers Report' => 'reports/customerReport'
        )
    );
    return $menu_array;
  }

    public function index() {
        
    }

    public function orderReport() {

        if (!empty($_POST['start_date']) || !empty($_POST['end_date']) || !empty($_POST['shorPeriod'])) {
            $objOrders = new orders();
            $startDate = '';
            $endDate = '';
            if (empty($_POST['shorPeriod'])) {
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
            } else {
                switch ($_POST['shorPeriod']) {
                    case 'Y':
                        $startDate = date('Y') . '-01-01';
                        $endDate = date('Y-m-d');
                        break;
                    case 'H':
                        $startDate = date("Y-m-d", strtotime("-6 months"));
                        ;
                        $endDate = date('Y-m-d');
                        break;
                    case 'M':
                        $startDate = date('Y-m') . '-01';
                        $endDate = date('Y-m') . '-31';
                        break;
                    case 'W':
                        $startDate = date("Y-m-d", strtotime("-7 days"));
                        $endDate = date('Y-m-d');
                        break;

                    default:
                        $startDate = date("Y-m-d");
                        $endDate = date("Y-m-d");
                        break;
                }
            }

            $this->orderData = $objOrders->listOrdersReport($startDate, $endDate);
        }

        if ($_POST['export']) {
            $this->generateOrderReport($this->orderData);
            die();
        } else {
            $this->loadView('admin/listorders');
        }
    }

    public function generateOrderReport($data) {
        $index = 0;
        foreach ($data as $objData) {
            #order data
            $arrayReoprtData[$index]['Order Number'] = $objData->order_id;
            $arrayReoprtData[$index]['Order Total Amount'] = $objData->order_total;
            $arrayReoprtData[$index]['Order Date'] = $objData->order_date;
            $arrayReoprtData[$index]['Payment Method'] = $objData->paid_by;
            $arrayReoprtData[$index]['Order Status'] = $objData->order_status;
            $arrayReoprtData[$index]['Transaction Id'] = $objData->transaction_id;
            $arrayReoprtData[$index]['Billing Cutomer Name'] = $objData->billing_first_name . ' ' . $objData->billing_lastt_name;

            #biling address
            $arrayReoprtData[$index]['Billing Cutomer Name'] = $objData->billing_first_name . ' ' . $objData->billing_lastt_name;
            $arrayReoprtData[$index]['Billing Email'] = $objData->billing_email;
            $arrayReoprtData[$index]['Billing Address'] = $objData->billing_address;
            $arrayReoprtData[$index]['Billing City'] = $objData->billing_city;
            $arrayReoprtData[$index]['Billing State'] = $objData->billing_state;
            $arrayReoprtData[$index]['Billing Country'] = $objData->billing_country;

            #shipping address
            $arrayReoprtData[$index]['Shipping Cutomer Name'] = $objData->shipping_first_name . ' ' . $objData->shipping_lastt_name;
            $arrayReoprtData[$index]['Shipping Email'] = $objData->shipping_email;
            $arrayReoprtData[$index]['Shipping Address'] = $objData->shipping_address;
            $arrayReoprtData[$index]['Shipping City'] = $objData->shipping_city;
            $arrayReoprtData[$index]['Shipping State'] = $objData->shipping_state;
            $arrayReoprtData[$index]['Shipping Country'] = $objData->shipping_country;

            $index++;
        }
        $reportHeadings = array_keys($arrayReoprtData[0]);
        $reportPath = $this->write2excel($reportHeadings, $arrayReoprtData, 'Orders-Report-' . date('Y-m-d') . '.csv');
        $this->downloadFile($reportPath);
    }

    public function productReport() {

        if (!empty($_POST['start_date']) || !empty($_POST['end_date']) || !empty($_POST['shorPeriod'])) {
            $objOrders = new orders();
            $startDate = '';
            $endDate = '';
            if (empty($_POST['shorPeriod'])) {
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
            } else {
                switch ($_POST['shorPeriod']) {
                    case 'Y':
                        $startDate = date('Y') . '-01-01';
                        $endDate = date('Y-m-d');
                        break;
                    case 'H':
                        $startDate = date("Y-m-d", strtotime("-6 months"));
                        ;
                        $endDate = date('Y-m-d');
                        break;
                    case 'M':
                        $startDate = date('Y-m') . '-01';
                        $endDate = date('Y-m') . '-31';
                        break;
                    case 'W':
                        $startDate = date("Y-m-d", strtotime("-7 days"));
                        $endDate = date('Y-m-d');
                        break;

                    default:
                        $startDate = date("Y-m-d");
                        $endDate = date("Y-m-d");
                        break;
                }
            }

            $this->productData = $objOrders->listProductReport($startDate, $endDate);
//            echo "<pre>";
//            print_r($this->productData);die;
        }

        if ($_POST['export']) {
            $this->generateProductReport($this->productData);
            die();
        } else {
            $this->loadView('admin/listproducts');
        }
    }

    public function generateProductReport($data) {

        $index = 0;
        foreach ($data as $objData) {
            #order data

            $arrayReoprtData[$index]['Product Name'] = $objData->product_name;
            $arrayReoprtData[$index]['Brand Name'] = $objData->brand_name;
            $arrayReoprtData[$index]['Category Name'] = $objData->category_name;
            $arrayReoprtData[$index]['Artical No/SKU'] = $objData->sku;
//            $arrayReoprtData[$index]['Artical No.'] = $objData->article_number;
            $arrayReoprtData[$index]['Manufacturer PDT No'] = $objData->manufacturer_pdt_no;
            $arrayReoprtData[$index]['Sold Quantity'] = $objData->quantity;
            $arrayReoprtData[$index]['Unit Price'] = $objData->special_price;
            $arrayReoprtData[$index]['Total Amount'] = CURRENCY . ' ' . $objData->total_price;

            $index++;
        }
        $reportHeadings = array_keys($arrayReoprtData[0]);
        $reportPath = $this->write2excel($reportHeadings, $arrayReoprtData, 'Product-Report-' . date('Y-m-d') . '.csv');
        $this->downloadFile($reportPath);
    }

    public function customerReport() {
        $startDate = '';
        $endDate = '';
        $objOrders = new orders();
        if (!empty($_POST['start_date']) || !empty($_POST['end_date']) || !empty($_POST['shorPeriod'])) {

            if (empty($_POST['shorPeriod'])) {
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
            } else {
                switch ($_POST['shorPeriod']) {
                    case 'Y':
                        $startDate = date('Y') . '-01-01';
                        $endDate = date('Y-m-d');
                        break;
                    case 'H':
                        $startDate = date("Y-m-d", strtotime("-6 months"));
                        ;
                        $endDate = date('Y-m-d');
                        break;
                    case 'M':
                        $startDate = date('Y-m') . '-01';
                        $endDate = date('Y-m') . '-31';
                        break;
                    case 'W':
                        $startDate = date("Y-m-d", strtotime("-7 days"));
                        $endDate = date('Y-m-d');
                        break;

                    default:
                        $startDate = date("Y-m-d");
                        $endDate = date("Y-m-d");
                        break;
                }
            }
            $this->customerData = $objOrders->listCustomerReport($startDate, $endDate, true);
        } else {
            $this->customerData = $objOrders->listCustomerReport($startDate, $endDate);
        }

//            echo "<pre>";
//            print_r($this->customerData);die;

        if ($_POST['export']) {
            $this->generateCustomerReport($this->customerData);
            die();
        } else {
            $this->loadView('admin/listcustomer');
        }
    }

    public function generateCustomerReport($data) {

        $index = 0;
        foreach ($data as $objData) {
            #order data

            $arrayReoprtData[$index]['Customer Name'] = $objData->cutomer_name;
            $arrayReoprtData[$index]['Email'] = $objData->email;
            $arrayReoprtData[$index]['Phone'] = $objData->phone;
            $arrayReoprtData[$index]['Address'] = $objData->address1;
            $arrayReoprtData[$index]['City'] = $objData->city;
            $arrayReoprtData[$index]['State'] = $objData->state;
            $arrayReoprtData[$index]['Country'] = $objData->country;
            $arrayReoprtData[$index]['Postal'] = $objData->zip_code;
            $arrayReoprtData[$index]['Total Amount'] = CURRENCY . ' ' . $objData->total;

            $index++;
        }
        $reportHeadings = array_keys($arrayReoprtData[0]);
        $reportPath = $this->write2excel($reportHeadings, $arrayReoprtData, 'Customert-Report-' . date('Y-m-d') . '.csv');
        $this->downloadFile($reportPath);
    }

    public function paymentReport() {
        $startDate = '';
        $endDate = '';
        $objOrders = new orders();
        if (!empty($_POST['start_date']) || !empty($_POST['end_date']) || !empty($_POST['shorPeriod'])) {

            if (empty($_POST['shorPeriod'])) {
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
            } else {
                switch ($_POST['shorPeriod']) {
                    case 'Y':
                        $startDate = date('Y') . '-01-01';
                        $endDate = date('Y-m-d');
                        break;
                    case 'H':
                        $startDate = date("Y-m-d", strtotime("-6 months"));
                        ;
                        $endDate = date('Y-m-d');
                        break;
                    case 'M':
                        $startDate = date('Y-m') . '-01';
                        $endDate = date('Y-m') . '-31';
                        break;
                    case 'W':
                        $startDate = date("Y-m-d", strtotime("-7 days"));
                        $endDate = date('Y-m-d');
                        break;

                    default:
                        $startDate = date("Y-m-d");
                        $endDate = date("Y-m-d");
                        break;
                }
            }
            $this->paymentData = $objOrders->listPaymentReport($startDate, $endDate, true);
        } else {
            $this->paymentData = $objOrders->listPaymentReport($startDate, $endDate);
        }

//            echo "<pre>";
//            print_r($this->paymentData);die;

        if ($_POST['export']) {
            $this->generatePaymentReport($this->paymentData);
            die();
        } else {
            $this->loadView('admin/listpayment');
        }
    }

    public function generatePaymentReport($data) {

        $index = 0;
        foreach ($data as $objData) {
            #order data

            $arrayReoprtData[$index]['Date'] = date('Y-m-d', strtotime($objData->order_date));
            $arrayReoprtData[$index]['Subtotal'] =  CURRENCY . ' ' . ($objData->payment_total-$objData->total_shipping-$objData->payment_tax);
            $arrayReoprtData[$index]['Shipping cost'] = CURRENCY . ' ' . (int)$objData->total_shipping;
            $arrayReoprtData[$index]['Tax Amount'] =  CURRENCY . ' ' .$objData->payment_tax;
            $arrayReoprtData[$index]['Total Amount'] =  CURRENCY . ' ' .$objData->payment_total;
            $index++;
        }
        $reportHeadings = array_keys($arrayReoprtData[0]);
        $reportPath = $this->write2excel($reportHeadings, $arrayReoprtData, 'Payment-Report-' . date('Y-m-d') . '.csv');
        $this->downloadFile($reportPath);
    }

    /**
     * @uses Method is used to load view from theme
     */
    private function loadTheme($tpl) {
        if (file_exists("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php")) {
            include("templates/front/" . SITE_THEME . "/views/" . $tpl . ".php");
        } elseif (file_exists("modules/vendor/reports/front/views/" . $tpl . ".php")) {
            include("modules/vendor/reports/front/views/" . $tpl . ".php");
        } else {
            include('views/front/' . $tpl . '.php');
        }
    }

    /**
     * @uses Method is used to load view from module
     */
    private function loadView($template = 'admin/listing') {
        include('views/' . $template . '.php');
    }

}
