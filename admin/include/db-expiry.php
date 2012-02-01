<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-expiry.php
 */

/**
 * The MySQL table interface for the Expiry table
 */
class Expiry extends Table{

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'expiry';
	
	/**
	 * The MySQL table's column names
	 *
	 * @var string
	 */
	protected static $table_columns = 'name, period';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY `order`';
	

	/**
	 * Insert new record to the expiry table
	 *
	 * Todo: rename the period column to length in the 
	 * 	     expiry table would be more meaningful
	 *
	 * @param 	string 		$name		Period's name.
	 * @param 	int 		$length		Period's length in days.
	 * @return int						The id of the newly created record.
	 */
	static public function create ( $name, $length ) {

		global $db;

        $db->sql = sprintf( "INSERT INTO ".static::$table_name." (id, name, period) 
                             VALUES ('', %s, %d);", 
                             escape( $name ), $length );
        $db->query();

        $db->sql = "SELECT last_insert_id()";
        $db->query();
        $rs = mysqli_fetch_row($db->rs);
        $last = (int)$rs[0];
        
		$db->sql = "SELECT MAX(`order`) FROM ".static::$table_name;
        $db->query();
        $rs = mysqli_fetch_row($db->rs);
        $max = (int)$rs[0];	
        	 
        $db->sql = "UPDATE ".static::$table_name." SET `order`='" . ( $max + 1 ) . "' WHERE id='$last'";
        $db->query();
        
        return $last;
	} 	
}

?>
