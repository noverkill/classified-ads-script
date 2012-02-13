<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-ad-review.php
 */

/**
 * The MySQL table interface for the Response table
 */
class AdReview extends Table {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'ad_review';
	
	/**
	 * The MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'ad_id, user_id, rate, comment';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY id DESC';

	/**
	 * Check if the user already have reviewed the ad
	 *
	 * @param 	int 	$id						Record's id.
	 * @param 	array 	$filters[optional]		Key value pairs for filtering the result.
	 * @return	int								1 if the record exists, 0 otherwise.
	 */
	static public function exists( $ad_id, $user_id ) {

		global $db;
				
		$db->sql = sprintf( "SELECT id 
					         FROM ".static::$table_name." 
					         WHERE ad_id='%d' AND user_id='%d'
					         LIMIT 1",
					         $ad_id, $user_id );
		$db->query();

		return mysqli_num_rows( $db->rs );	
	}

	/**
	 * Get all records from the ad_review table regarding the given filters
	 * 
	 * Note: the ad_review table alias r in the query!
	 * 
	 * @param 	array 	$filters[optional]			Key value pairs for filtering the result.
	 * @param 	string 	$text_filter[optional]		Sql expression needs to be inserted to the WHERE clause of the query.
	 * @param 	int 	$limit[optional]			Number of rows needs to be returned.
	 * @param 	string 	$order_by[optional]			The designated row order. If not given then the table's default order vill be used.
	 * @return 	array 								The result rows as array.
	 */
	static public function get_all ( $filters = array(), $text_filter = '', $limit = '', $order_by = '' ) {

		global $db;
						
		$filter = '';	
		foreach( $filters as $key => $value )  $filter .= " AND r.$key='" . escape( $value ) . "'";
				
		if( $text_filter != '' ) $text_filter = "AND $text_filter";
				
		if( $limit != '' ) $limit = "LIMIT $limit";

		if ($order_by == '' ) $order_by = static::$default_order;
		
		$db->sql = "SELECT r.id,".static::$table_columns.",u.username
					FROM ".static::$table_name." r
					LEFT JOIN user u ON u.id=r.user_id
					WHERE 1=1 $filter $text_filter
					$order_by 
					$limit";
		$db->query();

		$records = array ();	
		while( $row = mysqli_fetch_array( $db->rs ) ) $records[] = $row;

		return $records;
	}
}

?>
