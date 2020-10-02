<?php
class shippingModel extends ISP {
	protected $arrayData;
	public $shippingMeta;

	public function __construct() {
		parent :: __construct();
	}

	protected function listShipping() {
		$sql = "SELECT * FROM ".TABLE_PREFIX."shipping order by method_title asc";
		$this->arrayData = $this->dbFetch($sql);
	}

	protected function getShipping($sId) {
		$sql = "SELECT * FROM ".TABLE_PREFIX."shipping  where shipping_id='".$sId."'";
		$this->arrayData = (array)$this->fetchRows($sql); 
		$this->getShippingMetas($sId);
	}

	public function activeShipping() {
		$sql = "SELECT * FROM ".TABLE_PREFIX."shipping where enabled='1' order by method_title asc";
		return $this->dbFetch($sql);
	}

	protected function getCartWeight() {
		$uid = customer ::getCustomerId();
    $sql = "SELECT sum(catalog.weight) as cart_weight FROM " . TABLE_PREFIX . "catalog as catalog inner join " . TABLE_PREFIX . "cart as cart on cart.pid=catalog.catalog_id where cart.user_id='$uid'";
    $row = $this->fetchRows($sql);
    
    return $row->cart_weight;
	}

	public function getShippingMetas($sId) {
		$sql = "SELECT * FROM ".TABLE_PREFIX."shipping_meta where shipping_id='".$sId."'";
		$this->shippingMeta = $this->dbFetch($sql);
	}

    protected function deleteShipping($sId) {
        $this->dbQuery("Delete from ".TABLE_PREFIX."shipping where shipping_id='".$sId."'");
    }

	protected function saveShipping($sId) {
		if($sId>0) {
			$intSid = $this->updateForm(TABLE_PREFIX."shipping", $sId, 'shipping_id');
			$this->dbQuery("Delete from ".TABLE_PREFIX."shipping_meta where shipping_id='".$sId."'");

			foreach($this->postedData['shipping_meta'] as $key=>$val) {
				$this->dbQuery("INSERT INTO ".TABLE_PREFIX."shipping_meta (shipping_id, meta_key, meta_value) values('".$sId."','".$key."','".$val."')");
			}
		}
		else {
			$intSid = $this->insertForm(TABLE_PREFIX."shipping");
			$this->dbQuery("INSERT INTO ".TABLE_PREFIX."shipping_meta (shipping_id, meta_key, meta_value) values('".$intSid."','price','".$_POST['shipping_meta']['price']."')");
		}

	}

}