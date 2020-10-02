<?php
class shipping extends shippingModel {
    private $shippingId;
    public function __Construct() {
            parent :: __Construct();
            $this->shippingId = 0;
    }
    
    public static function adminMenuItems() {
        $menu_array = array(
            '<i class="icon icon-truck"></i> Shipping' => 'shipping'
        );
        return $menu_array;
    }

    public function index() {
            $this->listShipping();
            $this->loadView();
    }

    public function listUSPSMethods() {
      return [];
      
        $destination = $_GET['zipcode'];
        $cart_weight = $this->getCartWeight();

        $xml_data = "<RateV4Request USERID='750ETERN6953'>
                        <Revision>2</Revision>     
                        <Package ID='0'>   
                          <Service>EXPRESS</Service>
                          <FirstClassMailType></FirstClassMailType>  
                          <ZipOrigination>33556</ZipOrigination>   
                          <ZipDestination>".$destination."</ZipDestination>   
                          <Pounds>".$cart_weight."</Pounds>   
                          <Ounces>0</Ounces>   
                          <Container>VARIABLE</Container>   
                          <Width>0</Width>
                          <Length>0</Length>
                          <Height>0</Height>
                          <Girth>0</Girth>
                            
                          <Machinable>TRUE</Machinable>   
                        </Package>
                        <Package ID='1'>   
                          <Service>PRIORITY</Service>
                          <FirstClassMailType></FirstClassMailType>  
                          <ZipOrigination>33556</ZipOrigination>   
                          <ZipDestination>".$destination."</ZipDestination>   
                          <Pounds>".$cart_weight."</Pounds>   
                          <Ounces>0</Ounces>   
                          <Container>VARIABLE</Container>   
                          <Width>0</Width>
                          <Length>0</Length>
                          <Height>0</Height>
                          <Girth>0</Girth>
                          
                          <Machinable>TRUE</Machinable>   
                        </Package>
                        <Package ID='2'>   
                          <Service>FIRST CLASS</Service>
                          <FirstClassMailType>LETTER</FirstClassMailType>  
                          <ZipOrigination>33556</ZipOrigination>   
                          <ZipDestination>".$destination."</ZipDestination>   
                          <Pounds>".$cart_weight."</Pounds>   
                          <Ounces>0</Ounces>   
                          <Container>VARIABLE</Container>   
                          <Width>0</Width>
                          <Length>0</Length>
                          <Height>0</Height>
                          <Girth>0</Girth> 
                          <Machinable>TRUE</Machinable>   
                        </Package>
                        
                        </RateV4Request>";
        $url = "http://production.shippingapis.com/ShippingAPI.dll?API=RateV4";
        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    'XML=' . $xml_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $output = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        $array_data = json_decode(json_encode(simplexml_load_string($output)), true);
        return $array_data;
    }

    public function addnew() {
            $this->loadView('shippingform');
    }

    public function edit() {
            $sId = intval($_GET['id']);
            if($sId >0) {
                    $this->shippingId = $sId;
                    $this->getShipping($sId);
                    $this->loadView('shippingform');
            }
            else {
                    $this->__doRedirect(mainframe::__adminBuildUrl('shipping'));	
            }
    }

    public function delete() {
        $sId = intval($_GET['id']);
        $this->deleteShipping($sId);
        mainframe :: setSuccess('Shipping Deleted successfully.');
     	$this->__doRedirect(mainframe::__adminBuildUrl('shipping'));
    }

	public function save() {
		$this->saveShipping($this->postedData['id']);
		mainframe :: setSuccess('Shipping information saved successfully.');
		if($_POST['saveexit'])
			$this->__doRedirect(mainframe::__adminBuildUrl('shipping'));
		else
			$this->__doRedirect(mainframe::__adminBuildUrl('shipping/addnew'));
	}

	private function loadView($template = 'listview') {
		include($template.'.php');
	}
}
