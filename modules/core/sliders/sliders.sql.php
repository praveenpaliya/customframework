<?php
class slidersSetup  extends dbModel {

	public function __construct() {
		parent :: __construct();
	}

	public function installModule() {
		$tableSQL = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."sliders` (
			`slider_id` int(11) NOT NULL auto_increment,   
		  	`slider_title` varchar(200) NOT NULL default '0', 
		  	`slider_animation` varchar(20) NOT NULL default 'slide',
		  	`show_pagination` int(1) NOT NULL default '0',
		  	`pagination_type` varchar(20) NOT NULL default 'dots',
		   	PRIMARY KEY  (`slider_id`))";
		$this->dbQuery($tableSQL);

		$tableSQL = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."slider_slides` (
			`slide_id` int(11) NOT NULL auto_increment,   
		  	`slide_title` varchar(200) NOT NULL default '',       
		 	`slide_text` text  NOT NULL default '',     
		  	`slide_image`  text NULL,     
		  	`slider_id` int(11)  NULL,    
		   	PRIMARY KEY  (`slide_id`)
			)";

		$this->dbQuery($tableSQL);
	}
}

?>