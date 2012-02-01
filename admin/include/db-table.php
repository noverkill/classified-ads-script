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
	 * The MySQL table's column names e.g. 'id,name,slug'
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
	static public function create ( $fields ) {

		global $db;

		$keys = 'id';
		$values = "''";
		
		foreach( $fields as $key => $value ) {
			$keys   .= ",$key";
			$values .= ",'" . escape( $value ) . "'";
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
		
		$filter = array_merge( $filters, array( 'id' => $id ) );
		$all = static::get_all( $filter, '', '1' );
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
		foreach( $filters as $key => $value )  $filter .= " AND $key='" . escape( $value ) . "'";
				
		if( $text_filter != '' ) $text_filter = "AND $text_filter";
				
		if( $limit != '' ) $limit = "LIMIT $limit";

		if ($order_by == '' ) $order_by = static::$default_order;
		
		$db->sql = "SELECT id,".static::$table_columns."
					FROM ".static::$table_name."
					WHERE 1=1 $filter $text_filter
					$order_by 
					$limit";
		$db->query();

		$records = array ();	
		while( $row = mysqli_fetch_array( $db->rs ) ) $records[] = $row;

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
	static public function exists( $id, $filters = array() ) {

		global $db;
				
		$filter = '';		
		foreach( $filters as $key => $value ) $filter .= " AND $key='" . escape( $value ) . "'";

		$db->sql = sprintf( "SELECT id 
					         FROM ".static::$table_name." 
					         WHERE id=%d $filter
					         LIMIT 1",
					         $id );
		$db->query();

		return mysqli_num_rows( $db->rs );	
	}

	/**
	 * Delete record from the table
	 *
	 * @param 	int 	$id						Record's id
	 * @param 	array 	$filters[optional]		Key value pairs for filtering the result.
	 */
	static public function delete( $id, $filters = array() ) {

		global $db;

		$filter = '';		
		foreach( $filters as $key => $value ) $filter .= " AND $key='" . escape( $value ) . "'";
						
        $db->sql = sprintf( "DELETE FROM ".static::$table_name." 
                             WHERE id=%d $filter",
                             $id );
        $db->query();					   
	}

}


/**
 * The abstract base class for MySQL hierarchical table interface
 */
abstract class TreeTable extends Table {

	/**
	 * Insert new record to the table
	 *
	 * @param	array 	$fields		Column-name => value pairs to create insert query.
	 * @param 	int		$parent		The id of the parent record.
	 * @return 	int					The id of the newly created record.
	 */
	static public function create ( $fields, $parent ) {

		global $db;
		
		$keys = 'id,parent';
		$values = sprintf( "'', %d", $parent );
		
		foreach( $fields as $key => $value ) {
			$keys   .= ",$key";
			$values .= ",'" . escape( $value ) . "'";
		}
		
        $db->sql = "INSERT INTO ".static::$table_name." ($keys) VALUES ($values);";
        $db->query();

        $db->sql = "SELECT last_insert_id()";
        $db->query();
        $rs = mysqli_fetch_row($db->rs);
        $last = (int)$rs[0];

		$db->sql = sprintf( "SELECT MAX(`order`) FROM ".static::$table_name." WHERE parent=%d", $parent );
        $db->query();
        $rs = mysqli_fetch_row($db->rs);
        $max = (int)$rs[0];	
        	 
        $db->sql = "UPDATE ".static::$table_name." SET `order`='" . ( $max + 1 ) . "' WHERE id='$last'";
        $db->query();
               
        return $last;
	}
	
	/**
	 * Get all records from the table regarding the given filters
	 *
	 * @param 	array 	$filters[optional]			Key value pairs for filtering the result.
	 * @param 	string 	$text_filter[optional]		Sql expression needs to be inserted to the WHERE clause of the query.
	 * @param 	int 	$limit[optional]			The number of rows needs to be returned.
	 * @param 	string 	$order_by[optional]			The designated row order. If not given then the table's default order vill be used.
	 * @return 	array 								The result rows as array. Every row contains its childcount.
	 */
	static public function get_all ( $filters = array(), $text_filter = '', $limit = '', $order_by = '' ) {

		global $db;
						
		$filter = '';	
		foreach( $filters as $key => $value )  $filter .= " AND $key='" . escape( $value ) . "'";
						
		if( $text_filter != '' ) $text_filter = "AND $text_filter";

		if ($order_by == '' ) $order_by = static::$default_order;
				
		if( $limit != '' ) $limit = "LIMIT $limit";

		$db->sql = "SELECT r.id,r.name,r.slug,r.parent,
					(SELECT COUNT(c.id) FROM ".static::$table_name." c WHERE c.parent=r.id) as childcount
					FROM ".static::$table_name." r
					WHERE 1=1 $filter $text_filter
					$order_by 
					$limit";
		$db->query();

		$records = array ();	
		while( $row = mysqli_fetch_array( $db->rs ) ) $records[] = $row;

		return $records;
	}
	
	/**
	 * Get all records from the table as a tree structure
	 * 
	 * @return array	The array contains the tree.
	 * 
	 * Example of return array:
	 * <code>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [id] => 1
	 *             [name] => Root node
	 *             [slug] => root-node
	 *             [parent] => 0
	 *             [childs] => Array
	 *                 (
	 *                     [0] => Array
	 *                         (
	 *                             [id] => 2
	 *                             [name] => Child node
	 *                             [slug] => chld-node
	 *                             [parent] => 1
	 *                         )
	 *                 )
	 *         )
	 * )
	 * </code>
	 */
	static public function get_tree() {
		
		global $db;
		
		$records = array();
		
		$db->query( "SELECT id,name,slug,parent FROM ".static::$table_name." WHERE parent='0' ORDER BY `order`" );
		
		while ($row = mysqli_fetch_assoc($db->rs)) $records[]=$row;
		
		$db->prepare( "SELECT id,name,slug,parent FROM ".static::$table_name." WHERE parent=? ORDER BY `order`" );		
					
		for( $i=0; $i<count( $records ); $i++ ) {
			$db->bind_param( 'i', $records[$i]['id']);			
			$db->execute( GET_RESULT );					
			while( $row = mysqli_fetch_assoc($db->rs) ) $records[$i]['childs'][]=$row;
		}
		
		return $records;
	}  	

	/**
	 * Update record in the table
	 * 
	 * Note: This function is suitable to change the parent of the node.
	 *
	 * @param int 		$id			The record's id.
	 * @param array 	$fields		Column name => value pairs for updating.
	 */
	static public function update( $id, $fields) {

		global $db;
				
		$update = '';
		$sep = '';
		foreach( $fields as $key => $value ) {
			$update .= "$sep$key='" . escape( $value ) . "'";
			$sep = ',';
		}
		
		if ($update != '') {			

			$db->sql = sprintf( "SELECT parent FROM ".static::$table_name." WHERE id=%d", $id );
			$db->query();
			
			$rs = mysqli_fetch_row( $db->rs );
			$current_parent = (int)$rs[0];
						
			$new_order = '';
			
			//if the parent is changing then we should change the order too
			if( isset( $fields['parent'] ) && $fields['parent'] != $current_parent ) {
				
				$new_parent = $fields['parent']; 
				
				$db->sql = sprintf( "SELECT MAX(`order`) FROM ".static::$table_name." WHERE parent=%d", $new_parent );
				$db->query();
				
				$rs = mysqli_fetch_row( $db->rs );
				$max = (int)$rs[0];	
				$new_order = ",`order`='" . ( $max + 1 ) . "'"; 
			}
		
			$db->sql = sprintf( "UPDATE ".static::$table_name."
						         SET $update $new_order
						         WHERE id=%d",
						         $id );					   
			$db->query();
		}
	}

	/**
	 * Move the record up/down by one in the child's sequence
	 * 
	 * Note: This function is not suitable to change the parent of the node.
	 * 
	 * Todo: rename the function to 'move' maybe more meaningful?
 	 *		 the $direction parameter can be a string 'up' or 'down'?
	 * 
	 * @param int 		$id			The record's id.
	 * @param int 		$parent		The parent's id.
	 * @param int 		$direction	The direction: 0 => up, 1 => down.
	 */
	public static function set_order( $id, $parent, $direction ) {

		global $db;
				
		$relations = array( '<', '>' );
		$relation  = $relations[$direction];
		
		$db->sql = sprintf( "SELECT id,`order` FROM ".static::$table_name." 
		                     WHERE id=%d AND parent=%d",
		                     $id, $parent );
		$db->query();
		
		$c = mysqli_fetch_row( $db->rs );
		
		$db->sql = sprintf( "SELECT id,`order` FROM ".static::$table_name."
					         WHERE `order`$relation'" . $c[1] . "' AND parent=%d
					         ORDER BY `order` " . ($relation == '<' ? 'DESC' : 'ASC') . "
					         LIMIT 1",
					         $parent );
		$db->query();
		
		if( mysqli_num_rows( $db->rs ) == 1 ) {
			
			$n = mysqli_fetch_row( $db->rs );
			
			$db->sql = "UPDATE ".static::$table_name." SET `order`='" . $c[1] . "' WHERE id='" . $n[0] . "'";
			$db->query();
			
			$db->sql = "UPDATE ".static::$table_name." SET `order`='" . $n[1] . "' WHERE id='" . $c[0] . "'";
			$db->query();
		}				
	}	
}

?>
