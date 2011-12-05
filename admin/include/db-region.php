<?php

class Region extends TreeTable {

	static $table_name    = 'region';
	static $table_columns = 'name,slug,parent';
	static $default_order = 'ORDER BY `order`'; 
	
}

?>
