<?php
class customerSetup  extends dbModel {

	public function __construct() {
		parent :: __construct();
	}

	public function installModule() {
		
                $tableSQL = "CREATE TABLE `".TABLE_PREFIX."customer` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `username` varchar(30) NOT NULL,
                              `password` varchar(32) NOT NULL,
                              `first_name` varchar(50) CHARACTER SET utf8 NOT NULL,
                              `middle_name` varchar(255) NOT NULL,
                              `last_name` varchar(50) NOT NULL,
                              `dob` date NOT NULL,
                              `email` varchar(200) NOT NULL,
                              `phone` varchar(20) NOT NULL,
                              `customer_group` int(1) NOT NULL DEFAULT '1',
                              `web_address` varchar(255) NOT NULL,
                              `reference_information` varchar(255) NOT NULL,
                              `admin_note` text NOT NULL,
                              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                              `status` int(1) NOT NULL DEFAULT '1',
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `email` (`email`)
                            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
                
		$this->dbQuery($tableSQL);

		$tableSQL = "CREATE TABLE `".TABLE_PREFIX."customer_entry` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `customer_id` int(11) NOT NULL,
                              `field_code` varchar(100) NOT NULL,
                              `field_value` longtext NOT NULL,
                              UNIQUE KEY `lang_id` (`id`,`customer_id`,`field_code`),
                              KEY `lang_id_2` (`id`),
                              KEY `catalog_id` (`customer_id`),
                              KEY `field_code` (`field_code`)
                            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

		$this->dbQuery($tableSQL);
                
		$tableSQL = "CREATE TABLE `".TABLE_PREFIX."customer_group` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `customer_group` varchar(200) NOT NULL,
                              PRIMARY KEY (`id`)
                            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

		$this->dbQuery($tableSQL);
	}
}

?>