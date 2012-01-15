<?php

class Expiry extends Table{

	static $table_name    = 'expiry';
	static $table_columns = 'name, period';
	static $default_order = 'ORDER BY `order`';
		
	static public function create ( $name, $period ) {

		global $db;

        $db->sql = sprintf( "INSERT INTO ".static::$table_name." (id, name, period) 
                             VALUES ('', %s, %d);", 
                             escape( $name ), $period );
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
