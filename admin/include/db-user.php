<?php

class User extends Table {
	
	static $table_name = 'user';
	static $table_columns = 'name, username, email, telephone, city, region, category, webpage, createdon, password, code, active, ipaddr';
	static $default_order = 'ORDER BY id DESC';

   static function get_menu () {

		global $db;
				
        $db->sql = "SHOW TABLES FROM `".$db->db."`";                  
        $db->query();

		$menu = array();
		
		while( $table = mysql_fetch_row( $db->rs ) ) {
			$table_name = $table[0];
			$Table_name = ucwords( str_replace( '-', ' ', $table_name ) );
			$menu[$Table_name] = array ( 'List' => "$table_name-list.php", 'Edit' => "$table_name-edit.php", 'Create' => "$table_name-create.php" );
		}

		$menu['Setting'] = array ('Profile' => 'setting-profile.php','New password' => 'setting-new-password.php');
					
		unset( $menu['Favourite'] );
		unset( $menu['Log'] );
		
		return $menu;
	}

	static public function login ($username, $password) {

		$user = self::get_all( array( 'username' => $username, 'password' => $password ), '', 1 );

		$exists = isset( $user[0]['id'] );
		
		if ( ! $exists ) return false;
		
		$user = $user[0];
		
		$_SESSION['userid']    = $user['id'];
		$_SESSION['name']      = $user['name'];
		$_SESSION['username']  = $user['username'];
		$_SESSION['email']     = $user['email'];	
		$_SESSION['telephone'] = $user['telephone'];	
		$_SESSION['city']      = $user['city'];	
		$_SESSION['region']    = $user['region'];	
		$_SESSION['category']  = $user['category'];	
		$_SESSION['webpage']   = $user['webpage'];	
		
		return true;
	}

	static public function is_logged_in () {
		
		return isset( $_SESSION['userid'] );
	}
	
	static public function get_password () {

		$user = self::get_one( self::get_id() ); 
		
		return $user['password'];
	}
	
	static public function set_props ($prop_names) {

		User::update( self::get_id(), $prop_names ); 
		
		foreach( $prop_names as $prop_name => $prop_value ) $_SESSION[$prop_name] = $prop_value;
	}
		
	static public function get_prop ($prop_name) {
		
		return isset( $_SESSION[$prop_name]) ? $_SESSION[$prop_name] : '';
	}
	
	static public function get_id () {
		
		$user_id = isset( $_SESSION['userid']) ? $_SESSION['userid'] : 0;  
		return $user_id;
	}
	
	static public function get_name () {
		
		return $_SESSION['name'];
	}
		
	static public function get_username () {
		
		return $_SESSION['username'];
	}
	
	static public function get_email () {
		
		return $_SESSION['email'];
	}

	static public function login_errors () {
		
		return isset( $_SESSION['login_error'] ) ? $_SESSION['login_error'] : array(); 
	}
		
	static public function login_errors_clear () {
		
		unset( $_SESSION['login_error'] );
	}
	
	static public function login_errors_add ( $error_msg ) {
		
		$_SESSION['login_error'] = isset( $_SESSION['login_error'] ) ? $_SESSION['login_error'] : array();
		
		$_SESSION['login_error'][] = $error_msg; 
	}
}

?>
