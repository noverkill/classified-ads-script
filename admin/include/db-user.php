<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-user.php
 */

/**
 * The MySQL table interface for the User table
 */
class User extends Table {

	/**
	 * The name of the MySQL table
	 *
	 * @var string
	 */
	protected static $table_name = 'user';
	
	/**
	 * The MySQL table's column names e.g. 'id,name,slug'
	 *
	 * @var string
	 */
	protected static $table_columns = 'name, username, email, telephone, city, region, category, webpage, createdon, password, code, active, ipaddr';
	
	/**
	 * The default order e.g. 'ORDER BY id DESC'
	 *
	 * @var string
	 */
	protected static $default_order = 'ORDER BY id DESC';
	
   
   /**
    * Generate menu for the current user
    * 
    * @return 	array 	The menu.  
    * 
    * Example menu array:
    * <code>
    * Array
    * (
    *     [Category] => Array
    *         (
    *             [List] => category-list.php
    *             [Edit] => category-edit.php
    *             [Create] => category-create.php
    *         )
    *     [User] => Array
    *         (
    *             [List] => user-list.php
    *             [Edit] => user-edit.php
    *             [Create] => user-create.php
    *         )
    *     [Setting] => Array
    *         (
    *             [Profile] => setting-profile.php
    *             [New password] => setting-new-password.php
    *         )
    * )
    * </code>
    */
   static function get_menu () {

		global $db;
				
        $db->sql = "SHOW TABLES FROM `".$db->db."`";                  
        $db->query();

		$menu = array();
		
		while( $table = mysqli_fetch_row( $db->rs ) ) {
			$table_name = $table[0];
			$Table_name = ucwords( str_replace( '-', ' ', $table_name ) );
			$menu[$Table_name] = array ( 'List' => "$table_name-list.php", 'Edit' => "$table_name-edit.php", 'Create' => "$table_name-create.php" );
		}

		$menu['Setting'] = array ('Profile' => 'setting-profile.php','New password' => 'setting-new-password.php');
					
		unset( $menu['Favourite'] );
		unset( $menu['Log'] );

		return $menu;
	}

	
	/**
	 * Identify, authenticate and log in the user 
	 * 
	 * @param 	string 		$username 	The user's name;
	 * @param 	string 		$password	The user's password.
	 * @return 	boolean					True if the user successfuly logged in, false otherwise.
	 */
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

	/**
	 * Check if the user logged in.
	 *
	 * @return 	boolean		True if the user logged in, false otherwise.
	 */
	static public function is_logged_in () {
		
		return isset( $_SESSION['userid'] );
	}

	/**
	 * Get the logged in user's password.
	 *
	 * @return 	string	The user's password.
	 */
	static public function get_password () {

		$user = self::get_one( self::get_id() ); 
		
		return $user['password'];
	}

	/**
	 * Set logged in user's properties.
	 *
	 * The function updates the properties in the
	 * user table and in the session as well.
	 *
	 * @param 	array	Key value pairs for updating.
	 */
	static public function set_props ($prop_names) {

		User::update( self::get_id(), $prop_names ); 
		
		foreach( $prop_names as $prop_name => $prop_value ) $_SESSION[$prop_name] = $prop_value;
	}

	/**
	 * Get logged in user's property.
	 *
	 * @param 	string	$prop_name	The name of the property.
	 * @return  mixed				The value of the property.
	 */
	static public function get_prop ($prop_name) {
		
		return isset( $_SESSION[$prop_name]) ? $_SESSION[$prop_name] : '';
	}

	/**
	 * Get logged in user's id.
	 *
	 * @return  string	The logged in user's is.
	 */
	static public function get_id () {
		
		$user_id = isset( $_SESSION['userid']) ? $_SESSION['userid'] : 0;  
		return $user_id;
	}

	/**
	 * Get logged in user's name.
	 *
	 * @return  string	The logged in user's name.
	 */
	static public function get_name () {
		
		return $_SESSION['name'];
	}

	/**
	 * Get logged in user's username.
	 *
	 * @return  string	The logged in user's username.
	 */
	static public function get_username () {
		
		return $_SESSION['username'];
	}

	/**
	 * Get logged in user's email.
	 *
	 * @return  string	The logged in user's email.
	 */
	static public function get_email () {
		
		return $_SESSION['email'];
	}

	/**
	 * Get error messages related the user's last failed login attempt.
	 *
	 * @return  array	Error messages.
	 */
	static public function login_errors () {
		
		return isset( $_SESSION['login_error'] ) ? $_SESSION['login_error'] : array(); 
	}

	/**
	 * Add error message to the current login error message array.
	 *
	 * @param  string	Error message.
	 */
	static public function login_errors_add ( $error_msg ) {
	
		$_SESSION['login_error'] = isset( $_SESSION['login_error'] ) ? $_SESSION['login_error'] : array();
	
		$_SESSION['login_error'][] = $error_msg;
	}
	
	/**
	 * Clear error messages related the user's last failed login attempt.
	 */
	static public function login_errors_clear () {
		
		unset( $_SESSION['login_error'] );
	}

}

?>
