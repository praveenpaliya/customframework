<?php
class slidersModel extends ISP {
	protected $arrayData;
	protected $slidesData;

	public function __construct() {
		parent :: __construct();
	}

	protected function listSliders() {
		$sql = "SELECT * FROM ".TABLE_PREFIX."sliders order by slider_title asc";
		$this->arrayData = $this->dbFetch($sql);
	}

	protected function getSliders($sId) {
		$sql = "SELECT * FROM ".TABLE_PREFIX."sliders  where slider_id='".$sId."'";
		$this->arrayData = (array)$this->fetchRows($sql); 

		$sql = "SELECT * FROM ".TABLE_PREFIX."slider_slides where slider_id='".$sId."'";
		$this->slidesData = $this->dbFetch($sql);
	}

    protected function deleteSliders($sId) {
        $this->dbQuery("Delete from ".TABLE_PREFIX."sliders where slider_id='".$sId."'");
        $this->dbQuery("Delete from ".TABLE_PREFIX."slider_slides where slider_id='".$sId."'");
    }

	protected function saveSliders() {

		$intSliderId = $this->insertForm(TABLE_PREFIX."sliders");

		if ($intSliderId) {

			for ($i = 0; $i < count($_POST['slide_title']); $i++) {
				if (trim($_POST['slide_title'][$i]) <>"") {
		          	if (move_uploaded_file($_FILES['slide_image']['tmp_name'][$i], SITE_UPLOADPATH.$_FILES['slide_image']['name'][$i])) {
		            	$postedImage = $_FILES['slide_image']['name'][$i]; 
		            	$this->dbQuery("INSERT INTO ".TABLE_PREFIX."slider_slides(slide_title, slide_text, slide_image, slider_id) values('".trim($_POST['slide_title'][$i])."', '".trim($_POST['slide_text'][$i])."', '".$postedImage."', '".$intSliderId."')");         
		          	}
		        }
	        }
	        return true;
		}
		else 
			return false;
	}

	protected function updateSliders($intSliderId) {
		$this->updateForm(TABLE_PREFIX."sliders", $intSliderId, 'slider_id');
                         
    if ($intSliderId) {
      for ($i = 0; $i < count($_POST['slide_title']); $i++) {
        if (trim($_POST['slide_title'][$i]) <>"") {
          if (move_uploaded_file($_FILES['slide_image']['tmp_name'][$i], SITE_UPLOADPATH.$_FILES['slide_image']['name'][$i])) {
            $postedImage = $_FILES['slide_image']['name'][$i]; 
            $this->dbQuery("INSERT INTO ".TABLE_PREFIX."slider_slides(slide_title, slide_text, slide_image, slider_id) values('".trim($_POST['slide_title'][$i])."', '".trim($_POST['slide_text'][$i])."', '".$postedImage."', '".$intSliderId."')");         
          }
        }
      }
        
      /* Update Existing Slides*/
      foreach ($_POST['edit_slide_title'] as $slideId=>$val) {
        if (trim($val) <>"") {
          $strAdditional='';
          if($_FILES['edit_slide_image']['name'][$slideId] <>"") {
            $fileName = $_FILES['edit_slide_image']['name'][$slideId];
            move_uploaded_file($_FILES['edit_slide_image']['tmp_name'][$slideId], SITE_UPLOADPATH.$fileName); 
            $strAdditional = ", slide_image='".$fileName."'";
          }
          $this->dbQuery("UPDATE ".TABLE_PREFIX."slider_slides set slide_title='".$val."', slide_text='".$_POST['edit_slide_text'][$slideId]."' ".$strAdditional." where slide_id='".$slideId."'");
        }
      }
    }
	}
        
  protected function deleteSlideDetails($slideId){
    $this->dbQuery("DELETE from ".TABLE_PREFIX."slider_slides where slide_id='".$slideId."'");
  }
}