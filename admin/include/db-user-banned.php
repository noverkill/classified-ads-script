<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-user.php
 */

/**
 * The MySQL table interface for the User table
 */
class UserBanned extends Table {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'user_ban';
	
	/**
	 * The MySQL table's column names e.g. 'name,slug'
	 *
	 * @var string
	 */
	protected static $table_columns = 'name, username, email, telephone, city, region, category, webpage, createdon, password, code, active, ipaddr';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY id DESC';
	
}

?>
