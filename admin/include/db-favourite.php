<?php

class Favourite extends Table {

	static $table_name = 'favourite';
	static $table_columns = 'user_id, ad_id';
	static $default_order = 'ORDER BY f.id DESC';
	
	static public function get_all ( $user_id, $limit) {
		
		global $db;

		$filter = "h.active=1 AND h.id IN (SELECT f.ad_id FROM ".static::$table_name." f WHERE f.user_id='$user_id')";
				
		return Ad::get_all( array(), $filter, $limit);
		
	}

	static public function count ( $user_id ) {
		
		global $db;
		
		$filter = "active=1 AND id IN (SELECT f.ad_id FROM ".static::$table_name." f WHERE f.user_id='$user_id')";
		
		return Ad::count( array(), $filter );
		
	}
	
	static public function add ( $user_id, $ad_id ) {
		
		global $db;

		$db->sql = "INSERT INTO ".static::$table_name." (id,user_id,ad_id) 
		            VALUES ('0','$user_id','$ad_id')";				
		$db->query();	
	}

	static public function exists( $user_id, $ad_id ) {

		global $db;

		$db->sql = "SELECT id 
					FROM ".static::$table_name." 
					WHERE user_id='$user_id' AND ad_id='$ad_id'
					LIMIT 1";
		$db->query();
		
		return mysql_num_rows( $db->rs );	
	}
		
	static public function delete ( $user_id, $ad_id ) {
		
		global $db;

		$db->sql = "DELETE FROM ".static::$table_name." 
		            WHERE user_id='$user_id' AND ad_id='$ad_id'"; 
		$db->query();		
	}

}

?>
