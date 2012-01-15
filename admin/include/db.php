<?

define( "NONE"             , 0 );
define( "GET_RESULT"       , 1 );
define( "GET_NUM_ROWS"     , 2 );
define( "GET_AFFECTED_ROWS", 3 );

class db {

	var $host;
	var $user;
	var $pass;
	var $db;
	var $conn;
	var $sql;
	var $rs;
	
	var $stmt;

	function db() {

		GLOBAL $db_host;
		GLOBAL $db_user;
		GLOBAL $db_pass;
		GLOBAL $db_name;

		$this->host = $db_host;
		$this->user = $db_user;      
		$this->pass = $db_pass; 
		$this->db   = $db_name; 
	}

	function connect() {

		$this->conn = new mysqli( $this->host, $this->user, $this->pass );

		if( $this->conn->connect_errno ) return false;

		$this->conn->query( 'SET NAMES utf8' );
		$this->conn->query( 'SET COLLATION_CONNECTION=utf8_unicode_ci' );

		$this->conn->select_db( $this->db );

		return true;
	}
   
	function sql( $sql ) {

		$this->sql = $sql;
	}
   
	function query( $sql = '') {
		
		if( $sql != '' ) $this->sql = $sql;
		
		$this->rs = $this->conn->query( $this->sql );

		if( ! $this->rs ) return false;

		return true;
	}
   
	function prepare( $sql ) {

		$this->sql = $sql;
		
		$this->stmt = $this->conn->prepare( $sql );
		
		return $this->stmt;
	}

	function bind_param( $params ) {

		call_user_func_array( array( $this->stmt, "bind_param" ), func_get_args() ); 
	}
	   
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
 
	function close() { 
		
		//mysqli_free_result($this->rs);
		mysqli_close ($this->conn);
		$this->sql = null;
		$this->conn = null;
	}

}

/**
 * short alias for the mysql_real_escape_string
 * built in function
 * 
 * @since v1.0.0-4-ge561ad1
 *
 * @param    string    $string		The string needs to be escaped
 */ 
function escape( $string ) {	
	return mysql_real_escape_string( $string );
}

?>
