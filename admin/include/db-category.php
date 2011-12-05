<?php

class Category extends TreeTable {

	static $table_name    = 'category';
	static $table_columns = 'name,slug,parent';
	static $default_order = 'ORDER BY `order`';	

}

?>
