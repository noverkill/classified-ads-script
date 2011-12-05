<?

class db {

   var $host;
   var $user;
   var $pass;
   var $db;
   var $conn;
   var $sql;
   var $rs;

   function db () {
	  
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
   
      $this->conn = mysql_connect ($this->host, $this->user, $this->pass);
      
      if (! $this->conn) return false;

	  mysql_query('SET NAMES utf8');
	  mysql_query('SET COLLATION_CONNECTION=utf8_unicode_ci');
      
      mysql_select_db ($this->db);
      
      return true;
   }
   
   function sql ($sql) {
      
      $this->sql = $sql;
   }
   
   function query () {
   
      $this->rs = mysql_query ($this->sql, $this->conn);
      
      if (! $this->rs) {
      
         mysql_error ();
         return false;
      }
      
      return true;
   }
 
   function close () { 

         //mysql_free_result($this->rs);
         mysql_close ($this->conn);
         $this->sql = null;
         $this->conn = null;
   }

}

?>
