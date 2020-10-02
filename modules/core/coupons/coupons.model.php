<?php
class couponsModel extends ISP {
	public $arrayData;

	public function __construct() {
		parent :: __construct();
	}

	protected function listCoupons() {
		$sql = "SELECT * FROM ".TABLE_PREFIX."coupons order by title asc";
		$this->arrayData = $this->dbFetch($sql);
	}

	protected function getCoupons($bId) {
		$sql = "SELECT * FROM ".TABLE_PREFIX."coupons  where coupon_id='".$bId."'";
		$this->arrayData = (array)$this->fetchRows($sql); 
	}

        protected function deleteCoupons($bId) {
            $this->dbQuery("Delete from ".TABLE_PREFIX."coupons where coupon_id='".$bId."'");
        }

	protected function saveCoupons() {
		$intCid = $this->insertForm(TABLE_PREFIX."coupons");
		if ($intCid) {
			return $intCid;
		}
		else 
			return false;
	}

	protected function updateCoupons($bId) {
		$this->updateForm(TABLE_PREFIX."coupons", $bId, 'coupon_id');
	}
}