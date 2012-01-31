<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-favourite.php
 */

/**
 * The MySQL table interface for the Favourite table
 */
class Favourite extends Table {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'favourite';
	
	/**
	 * The MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'user_id, ad_id';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY f.id DESC';
	

	/**
	 * Get user's all favourite ads
	 *
	 * @param 	int 	$user_id	The user's id.
	 * @param 	int 	$limit		Number of rows needs to be returned.
	 * @return 	array 				The result rows as array.
	 */
	static public function get_all ( $user_id, $limit) {
		
		global $db;

		$filter = sprintf( "h.active=1 AND h.id IN (SELECT f.ad_id FROM ".static::$table_name." f WHERE f.user_id=%d)", $user_id );
				
		return Ad::get_all( array(), $filter, $limit);
		
	}

	/**
	 * Returns the count of the user's favourite ads 
	 *
	 * @param 	int 	$user_id	The user's id.
	 * @return 	int					Count of the favourite ads.
	 */
	static public function count ( $user_id ) {
		
		global $db;
		
		$filter = sprintf( "active=1 AND id IN (SELECT f.ad_id FROM ".static::$table_name." f WHERE f.user_id=%d)", $user_id );
		
		return Ad::count( array(), $filter );
		
	}

	/**
	 * Add the ad to the user's favourite ads
	 *
	 * @param 	int 	$user_id	The user's id.
	 * @param 	int 	$ad_id		The ad's id.
	 */
	static public function add ( $user_id, $ad_id ) {
		
		global $db;

		$db->sql = sprintf( "INSERT INTO ".static::$table_name." (id,user_id,ad_id) VALUES ('0',%d,%d)", $user_id, $ad_id );	
		$db->query();
	}

	/**
	 * Check if the given ad is one of the user's favourite.
	 *
	 * @param 	int 	$user_id	The user's id.
	 * @param 	int 	$ad_id		The ad's id.
	 * @return	int					1 if favourite, 0 otherwise.
	 */
	static public function exists( $user_id, $ad_id ) {

		global $db;
		
		$db->sql = sprintf( "SELECT id 
							 FROM ".static::$table_name." 
							 WHERE user_id=%d AND ad_id=%d
							 LIMIT 1",
							 $user_id, $ad_id );
		$db->query();
                 		
		return mysqli_num_rows( $db->rs );
	}

	/**
	 * Remove ad from the user's favourites.
	 *
	 * @param 	int 	$user_id	The user's id.
	 * @param 	int 	$ad_id		The ad's id.
	 */
	static public function delete ( $user_id, $ad_id ) {
		
		global $db;

		$db->sql = sprintf( "DELETE FROM ".static::$table_name." WHERE user_id=%d AND ad_id=%d", $user_id, $ad_id ); 
		$db->query();		
	}

}

?>
