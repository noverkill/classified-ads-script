<?php

class Table {
	
	static $table_name;
	static $table_columns;
	static $default_order;

	/*
	 * This function provide high security against mysql injection if the following criteria are met before it called:
	 * 1, the key values in the $fields array must not come from unsafe user input or should be checked properly
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
							
	static public function get_one ( $id, $filters = array()) {
		
		$filter = array_merge( $filters, array( 'id' => $id ) );
		$all = static::get_all( $filter, '', '1' );
		$all = isset( $all[0] ) ? $all[0] : array();
		return $all;
	} 
	
	/*
	 * This function provide high security against mysql injection if the following criteria are met before it called:
	 * 1, the keys in the $filter array must not come from user input or should be checked properly
	 * 2, the $text_filter, $limit, $order_by parameters should be escaped
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

	/*
	 * This function provide high security against mysql injection if the following criteria are met before it called:
	 * 1, the keys in the $filter array must not come from user input or should be checked properly
	 * 2, the $text_filter parameters should be escaped
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

class TreeTable extends Table {

	/*
	 * This function provide high security against mysql injection if the following criteria are met before it called:
	 * 1, the key values in the $fields array must not come from unsafe user input or should be checked properly
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

	/*
	 * This function provide high security against mysql injection if the following criteria are met before it called:
	 * 1, the keys in the $filter array must not come from user input or should be checked properly
	 * 2, the $text_filter, $limit, $order_by parameters should be escaped
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

	/*
	 * This function provide high security against mysql injection if the following criteria are met before it called:
	 * 1, the key values in the $fields array must not come from unsafe user input or should be checked properly
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
