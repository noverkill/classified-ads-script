<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-static-content.php
 */

/**
 * The MySQL table interface for the StaticContent table
 */
class StaticContent extends Table {
	
	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = '`static-content`';
	
	/**
	 * The MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'title,slug,content';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY id';

	   
	/**
	 * Get static content by slug.
	 * 
	 * @param 	string $slug	The content's slug.
	 * @return 	string			The content.
	 */
	static public function get_content ( $slug ) {
		$record = self::get_all( array( 'slug' => $slug ), '', '1' );
		return isset($record[0]['content'])?$record[0]['content']:'';
	}
}

?>
