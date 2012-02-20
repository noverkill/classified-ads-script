<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-report.php
 */

/**
 * The MySQL table interface for the Response table
 */
class Report extends Table {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'report';
	
	/**
	 * The MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'ad_id, user_id, message';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY id DESC';

}

?>
