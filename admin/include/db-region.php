<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-region.php
 */

/**
 * The MySQL table interface for the Region table
 */
class Region extends TreeTable {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'region';
	
	/**
	 * The MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'name,slug,parent';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY `order`';
	
}

?>
