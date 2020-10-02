<?php
class advertisementSetup  extends dbModel {

	public function __construct() {
		parent :: __construct();
	}

	public function installModule() {
		$tableSQL = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."advertisements` (
                            `id` int(11) NOT NULL auto_increment,
                            `type` varchar(255) NOT NULL,
                            `title` varchar(255) NOT NULL,
                            `description` text NOT NULL,
                            `start_date` date NOT NULL,
                            `end_date` date NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB";
		$this->dbQuery($tableSQL);

		$tableSQL = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."advertisement_items` (
                                `id` int(11) NOT NULL auto_increment,
                                `advertisement_id` int(11) NOT NULL,
                                `file_type` enum('1','2') NOT NULL COMMENT '1-files, 2-videos',
                                `file_name` varchar(255) NOT NULL,
                                 PRIMARY KEY (`id`)
                              ) ENGINE=InnoDB";

		$this->dbQuery($tableSQL);
	}
}

?>