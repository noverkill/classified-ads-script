<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-table.php
 */

/**
 * The absctract base class for MySQL table interface.
 * 
 * Note:	Although the class designed to provide maximum security against sql injection, 
 * 			some of its method having any of the following parameters needs further check
 * 			before calling: $fields, $filters, $text_filter, $order_by.  
 *  		These parameters needs to be properly checked/escaped before method call. 
 *  		In the case of $fields/$filters parameter the above only apply to the keys 
 *  		of the array.
 * 
 */
abstract class Table {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name;

	/**
	 * The MySQL table's column names e.g. 'name,slug'
	 * 
	 * Note: All table must have a primary key named 'id' and
	 *       that must be excluded from $table_columns! 
	 *
	 * @var string
	 */
	protected static $table_columns;
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */	
	protected static $default_order;

	
	/**
	 * Insert new record to the db table
	 * 
	 * @param array 	$fields		Column-name => value pairs to create insert query.
	 * @return int					The id of the newly created record.
	 */
	static public function create ( $fields, $id = 0 ) {

		global $db;
		
		$keys   = ''; 
		$values = '';
		$sep    = '';
		
		if( $id == 0 ) {
			$keys   = 'id';
			$values = "''";
			$sep    = ',';
		}
		
		foreach( $fields as $key => $value ) {
			$keys   .= "$sep$key";
			$values .= "$sep'" . escape( $value ) . "'";
			$sep     = ',';
		}

        $db->sql = "INSERT INTO ".static::$table_name." ($keys) VALUES ($values);";
        $db->query();

        $db->sql = "SELECT last_insert_id()";
        $db->query();
        $rs = mysqli_fetch_row($db->rs);
        $last = (int)$rs[0];
               
        return $last;
	}
	
	/**
	 * Get one record from the table 
	 * 
	 * @param 	int 	$id							The record's id.
	 * @param 	array 	$filters[optional]			Key value pairs for filtering the result. e.g. array('price'=>100) means 'AND price=100'.
	 * @return 	array								The result row as array.
	 */
	static public function get_one ( $id, $filters = array()) {

		$id = (int) $id;
		
		if( $id > 0 ) $filters['id'] = $id;
		
		$all = static::get_all( $filters, '', '1' );
		$all = isset( $all[0] ) ? $all[0] : array();
		return $all;
	} 
		
	/**
	 * Get all records from the table regarding the given filters
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
		foreach( $filters as $key => $value ) $filter .= " AND $key='" . escape( $value ) . "'";
				
		if( $text_filter != '' ) $text_filter = " AND $text_filter";
				
		if( $limit != '' ) $limit = "LIMIT $limit";

		if ($order_by == '' ) $order_by = static::$default_order;
		
		$db->sql = "SELECT id,".static::$table_columns."
					FROM ".static::$table_name."
					WHERE 1=1 $filter $text_filter
					$order_by 
					$limit";
		$db->query();

		$records = array ();	
		while( $row = mysqli_fetch_assoc( $db->rs ) ) $records[] = $row;

		return $records;
	}
		
	/**
	 * Returns the count of records match to the given filters
	 * 
	 * @param 	array 	$filters[optional]			Key value pairs for filtering the result.
	 * @param 	string 	$text_filter[optional]		Sql expression needs to be inserted to the WHERE clause of the query.
	 * @return 	int									Record count.
	 */
	static public function count( $filters = array(), $text_filter = '' ) {

		global $db;
				
		$filter = '';		
		foreach( $filters as $key => $value ) $filter .= " AND $key='" . escape( $value ) . "'";
				
		if( $text_filter != '' ) $text_filter = "AND $text_filter";
		
		$db->sql = "SELECT COUNT(id) 
					FROM ".static::$table_name." 
					WHERE 1=1 $filter $text_filter";
		$db->query();

		$rs = mysqli_fetch_row( $db->rs );
		
		return $rs[0];	
	}

	/**
	 * Update record in the table
	 * 
	 * @param int 		$id			The record's id.
	 * @param array 	$fields		Column name => value pairs for updating.
	 */
	static public function update( $id, $fields ) {

		global $db;
				
		$update = '';
		$sep = '';
		foreach( $fields as $key => $value ) {
			$update .= "$sep$key='" . escape( $value ) . "'";
			$sep = ',';
		}
		
		if ($update != '') {				

			$db->sql = sprintf( "UPDATE ".static::$table_name."
						         SET $update
						         WHERE id=%d",
						         $id );					   
			$db->query();
		}
	}	
		
	/**
	 * Check if the record exists in the table
	 *
	 * @param 	int 	$id						Record's id.
	 * @param 	array 	$filters[optional]		Key value pairs for filtering the result.
	 * @return	int								1 if the record exists, 0 otherwise.
	 */
	static public function exists( $id, $filters = array(), $text_filter = '' ) {

		global $db;
		
		$id = (int) $id;
		
		if( $id > 0 ) $filters['id'] = $id;
				
		$filter = '';		
		foreach( $filters as $key => $value ) $filter .= " AND $key='" . escape( $value ) . "'";

		if( $text_filter != '' ) $text_filter = " AND $text_filter";

		$db->sql = "SELECT id 
					FROM ".static::$table_name." 
				    WHERE 1=1 $filter $text_filter
					LIMIT 1";
		$db->query();
		
		return mysqli_num_rows( $db->rs );	
	}

	/**
	 * Delete record from the table
	 *
	 * @param 	int 	$id						Record's id
	 * @param 	array 	$filters[optional]		Key value pairs for filtering the result.
	 */
	static public function delete( $id, $filters = array(), $limit = 1 ) {

		global $db;

		$id = (int) $id;
	
		if( $id > 0 ) $filters['id'] = $id;

		$limit = (int) $limit;
				
		if( $limit > -1 ) $limit = " LIMIT $limit";
		else $limit = ''; 
		
		$filter = '';		
		foreach( $filters as $key => $value ) $filter .= " AND $key='" . escape( $value ) . "'";
		
		$db->sql = "DELETE FROM ".static::$table_name." 
					WHERE 1=1 $filter
					$limit";
		$db->query();				   
	}

}

?>
