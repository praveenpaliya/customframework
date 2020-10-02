<?php
class brandsModel extends ISP {
	public $arrayData;

	public function __construct() {
		parent :: __construct();
	}

	public function listBrands() {
		$sql = "SELECT * FROM ".TABLE_PREFIX."brands order by brand_name asc";
		$this->arrayData = $this->dbFetch($sql);
	}

	public function getBrands($bId) {
		$sql = "SELECT * FROM ".TABLE_PREFIX."brands  where brand_id='".$bId."'";
		$this->arrayData = (array)$this->fetchRows($sql); 
	}

        protected function deleteBrand($bId) {
            $this->dbQuery("Delete from ".TABLE_PREFIX."brands where brand_id='".$bId."'");
        }

	protected function saveBrands() {
		$intCid = $this->insertForm(TABLE_PREFIX."brands");
		if ($intCid) {
			return $intCid;
		}
		else 
			return false;
	}

	protected function updateBrands($bId) {
		$this->updateForm(TABLE_PREFIX."brands", $bId, 'brand_id');
	}
}