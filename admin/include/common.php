<?php 

$docroot = realpath( dirname( __FILE__ ) );

include( "$docroot/config.php");
include( "$docroot/db.php");
include( "$docroot/db-table.php");
include( "$docroot/db-ad.php");
include( "$docroot/db-region.php");
include( "$docroot/db-category.php");
include( "$docroot/db-expiry.php");
include( "$docroot/db-static-content.php");
include( "$docroot/db-user.php");
include( "$docroot/db-favourite.php");

$db = new db();
if ( ! $db->connect() ) exit( mysql_error() );
	
$categories = Category::get_tree();
$regions    = Region::get_tree();
$statics    = StaticContent::get_all( array(), 'id>4' );

//counters	
$today = date( "Y-m-d", time() );
$ct_fresh   = Ad::count( array( 'active' => 1), "lastmodified>='$today'" );
$ct_all     = Ad::count( array( 'active' => 1) );
$ct_expirys = Ad::count( array( 'active' => 1, "DATEDIFF(expiry,'$today')" => 0 ) );

//menu and breadcumb
$menu = User::get_menu();
	
$current_script_name = basename( $_SERVER['SCRIPT_NAME'] );

if( strpos( $current_script_name, '-' ) > 0 ) {
	
	$current_page = explode( '-', $current_script_name, 2 );
	if( isset ( $current_page[2] ) ) $current_page[1] .= '-' . $current_page[2]; //php 5.3.5 bug?? workaround
	$subpage_name = explode( '.', $current_page[1] );
	$subpage_name = str_replace( '-', ' ', $subpage_name[0] );
	if( $current_page[0] == 'static' ) $current_page[0] = 'static content';
	$current_group_page = array ( 'name' => ucwords( $current_page[0] ), 'script' => $menu[ucwords($current_page[0])][reset(array_keys($menu[ucwords($current_page[0])]))] );
	$current_sub_page   = array ( 'name' => ucfirst( $subpage_name ), 'script' => $current_page[0].'-'.$current_page[1] );  
} else {
	$current_group_page = array ( 'name' => '', 'script' => '' );
	$current_sub_page   = array ( 'name' => '', 'script' => '' ); 	
}

/**
 * Function for build and modify the query string.
 * 
 * The function build the query string based on the contents of the $_GET superglobal array 
 * and it can be modified with the content of the input array by the following rules:
 * Every element in the input array
 * 1, (ADD) which has non-existent key in the query string and has no -1 value will be added to the query string.
 * 2, (MODIFY) whose key is already in the query string and has no -1 value will be overwritten with its value in the query string. 
 * 3, (DELETE) whose key is already in the query string and has -1 value will be deleted from the query string.
 *
 * @since version 1.0.0.
 *
 * @param    array    $values    The array which the query string will be based on
 * @return   string              The created query string
 */
function build_query_string( $values ) {
	
	$get = array ();
	
	if( isset( $_GET ) ) $get = $_GET;
	 
	foreach( $values as $key => $value ) {
		if( $value > -1 ) $get[$key] = $value;
		else unset( $get[$key] );
	}
	
	$query_string = http_build_query( $get, '', '&amp;');
		
	return $query_string;
	
}

/**
 * Function to create a html link 
 *
 * @since version 1.0.0.
 *
 * 
 * @param    string    $url       The url of the link
 * @param    string    $target    The target of the link
 * @param    string    $title     The title of the link
 * @return   string               String contains the html mailto link
 */
function create_web_link( $url, $target = '', $title = '' ) {

 $target = $target == '' ? '' : "target='$target'";
 
 $title = $title == '' ? $url : $title;
 
 return "<a href='$url' $target>$title</a>";

}

/**
 * Function to create a html mailto link 
 *
 *
 * @since version 1.0.0.
 *
 * @param    string    $mail_address	The url of the link
 * @param    string    $title     		The title of the link
 * @return   string               		String contains the html mailto link
 */
function create_mail_link( $mail_address, $title = '' ) {

 $title = $title == '' ? $mail_address : $title;
 
 return "<a href='mailto:$mail_address'>$title</a>";

}

/**
 * Get host name from the url
 *
 *
 * @since version 1.0.0.
 *
 * @param    string    $url			
 * @return   string               host name
 */ 		
function get_host_from_url ($url) {
	
	$url = preg_replace( '/^[\\w]{0,10}?:\/\//', '', $url);

	$url = str_replace( "www.", "", $url);

	$url = rtrim( $url, "/");

	$url = substr( $url, 0, 20);

	$url = str_replace( "?", "", $url);
		
	while(( $nurl = dirname( $url)) != $url && $nurl != '.') {
		$url = $nurl;
	}

	return $url;
} 

/**
 * Create slug
 *
 *
 * @since version 1.0.0.
 *
 * @param    string    $str			The string which we need to make a slug from-	
 * @param    string    $delimiter	The delimitier we need to use between words. Optional. Default: -		
 * @return   string                 The created slug.
 */ 
function slug ($str, $delimiter='-') {
	
	$replace = array ("'");	//spec characters need to be replace to a delimiter  e.g. I'll be back -> i-ll-be-back
	
	$str = str_replace ($replace, ' ', $str);

	$clean = iconv ('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace ("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower (trim ($clean, $delimiter));
	$clean = preg_replace ("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

/**
 * Formate a number as currency
 *
 * The function takes the number provided in the input parameter
 * format it as a currency using the $currency configuration constant
 * from the config.php and return as a string  
 *
 * @since version 1.0.0.
 *
 * @param    string    $str			The number which we need to format as a currency		
 * @return   string                 The formatted string.
 */ 
function str_to_currency ($str) {
	
	global $currency;
	
	if( $str == '') return $str;
	
	$curr = $str[strlen($str)-1];
	  
	$j = 1;

	for ($i = strlen( $str) - 2; $i >= 0; $i--){
	  if (($i - strlen( $str) - 2) % 3 == 0) {
		 $curr[$j] = ".";
		 $j++;
	  }
	  
	  $curr[$j] = $str[$i];
	  $j++;  
	}

	$rcurr = $curr;

	for ($i = 1; $i <= strlen( $curr); $i++) $rcurr [$i-1] = $curr[strlen( $curr) - $i];

	return "$currency $rcurr";
}

/**
 * the function can print out the contents of a variable or an 
 * object for debbuging purpose.
 * 
 * 
 * The purpose of this function is to make a formatted, transparent
 * appearance for the output of the print_r function.
 * So this function put the neccesary html tags around the output and 
 * it also possible to add a title for it.
 * 
 * 
 * @since version 1.0.0.
 *
 * @param    string    $var			The var needs to be debugged
 * @param    string    $title       The optional title for the debug
 */ 
function debug( $var, $title='' ) {	
	if( $title != '' ) print $title.'<br />';
	print '<pre>';
	print_r( $var );
	print '</pre>';
	print '<br /><br />';
}

?>
