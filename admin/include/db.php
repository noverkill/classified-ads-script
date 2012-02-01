<?
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @version    $Id: db-table.php

 */

/**
 * Class for connecting to MySQL database
 * and performing common operations
 */
class db {

	/**
	 * Database host
	 *
	 * @var string
	 */
	public $host = '';
	
	/**
	 * Database user
	 *
	 * @var string
	 */
	public $user = '';
	
	/**
	 * Database password
	 *
	 * @var string
	 */
	public $pass = '';
	
	/**
	 * Database name
	 *
	 * @var string
	 */
	public $db = '';

	/**
	 * Database connection
	 *
	 * @var object|resource|null
	 */
	public $conn = null;

	/**
	 * Query string
	 *
	 * @var string
	 */
	public $sql = '';
	
	/**
	 * Query result set
	 *
	 * @var resource|null
	 */
	public $rs = null;
	
	/**
	 * Prepared statement
	 *
	 * @var string
	 */
	public $stmt;

	
	/**
	 * Constructor
	 */
	function __construct() {

		GLOBAL $db_host;
		GLOBAL $db_user;
		GLOBAL $db_pass;
		GLOBAL $db_name;

		$this->host = $db_host;
		$this->user = $db_user;      
		$this->pass = $db_pass; 
		$this->db   = $db_name; 
	}

	/**
	 * Connect to the db server
	 * 
	 * @return boolean	True if successfuly connected, false otherwise.
	 */
	function connect() {

		$this->conn = new mysqli( $this->host, $this->user, $this->pass );

		if( $this->conn->connect_errno ) return false;

		$this->conn->query( 'SET NAMES utf8' );
		$this->conn->query( 'SET COLLATION_CONNECTION=utf8_unicode_ci' );

		$this->conn->select_db( $this->db );

		return true;
	}
   
	/**
	 * Set the query string
	 * 
	 * @param string $sql
	 */
	function sql( $sql ) {

		$this->sql = $sql;
	}
   
	/**
	 * Execute the query string
	 * 
	 * @param 	string 		$sql[optional]	The query string. If not given then the object's sql property will be used.
	 * @return 	boolean 					True if the query was successful, false otherwise.
	 */
	function query( $sql = '') {
		
		if( $sql != '' ) $this->sql = $sql;
		
		$this->rs = $this->conn->query( $this->sql );

		if( ! $this->rs ) return false;

		return true;
	}

	/**
	 * Prepare statement
	 *
	 * @param 	string 		$stmt	The sql statement.
	 */
	function prepare( $stmt ) {

		$this->sql = $stmt;
		
		$this->stmt = $this->conn->prepare( $this->sql );
		
		return $this->stmt;
	}

	/**
	 * Bind params to the prepared statement
	 * 
	 * @param unknown_type $params
	 */
	function bind_param( $params ) {

		call_user_func_array( array( $this->stmt, "bind_param" ), func_get_args() ); 
	}

	/**
	 * Execute the prepared statement
	 *
	 * @param 	int 	$result				The type of the result needed. 
	 * @see 								For result types see NONE,GET_RESULT,GET_NUM_ROWS,GET_AFFECTED_ROWS 
	 * @return  Mysqli::resource|int|bool	Result with the type related to the $result param or false if the execution was unsuccessful. 
	 */
	function execute( $result = NONE ) {
		 
		if( ! $this->stmt->execute() ) return false;
		  
		switch( $result ) {
				case GET_RESULT:					
					$this->rs = $this->stmt->get_result();
					return $this->rs;
				break;
				case GET_NUM_ROWS:					
					return $this->stmt->num_rows;
				break;	
				case GET_AFFECTED_ROWS:					
					return $this->stmt->affected_rows;
				break;							
		}
	}
 
	/**
	 * Close the database connection.
	 */
	function close() { 
		
		//mysqli_free_result($this->rs);
		mysqli_close ($this->conn);
		$this->sql = null;
		$this->conn = null;
	}

}


/**
 * Result type's definition for the db::execute() method
 * 
 * Todo: these constant should be built in the db class
 *
 * NONE 	  		 : returns nothing
 * GET_RESULT        : returns a resource object
 * GET_NUM_ROWS      : returns the number of rows in the result
 * GET_AFFECTED_ROWS : returns the number of affected rows
 *
 * @see db::execute()
 */
define( "NONE"             , 0 );
define( "GET_RESULT"       , 1 );
define( "GET_NUM_ROWS"     , 2 );
define( "GET_AFFECTED_ROWS", 3 );


/**
 * Alias for the built-in mysql_real_escape_string method
 * 
 * @see php manuel
 * @link http://php.net/manual/en/mysqli.real-escape-string.php
 * 
 * @param 	string 	$escapestr
 * @return 	string
 */
function escape( $escapestr ) {	
	return mysql_real_escape_string ( $escapestr );
}

?>
