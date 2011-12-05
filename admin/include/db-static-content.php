<?php

class StaticContent extends Table {
	
	static $table_name    = '`static-content`';
	static $table_columns = 'title,slug,content';
	static $default_order = 'ORDER BY id';
	     
	static public function get_content ( $slug ) {
		$record = self::get_all( array( 'slug' => $slug ), '', '1' );
		return $record[0]['content'];
	}
}

?>
