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

function create_web_link( $url, $target = '', $title = '' ) {

 $target = $target == '' ? '' : "target='$target'";
 
 $title = $title == '' ? $url : $title;
 
 return "<a href='$url' $target>$title</a>";

}

function create_mail_link( $mail_address, $title = '' ) {

 $title = $title == '' ? $mail_address : $title;
 
 return "<a href='mailto:$mail_address'>$title</a>";

}
 		
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

function slug ($str, $delimiter='-') {
	
	$replace = array ("'");	//spec characters need to be replace to a delimiter  e.g. I'll be back -> i-ll-be-back
	
	$str = str_replace ($replace, ' ', $str);

	$clean = iconv ('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace ("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower (trim ($clean, $delimiter));
	$clean = preg_replace ("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

function str_to_currency ($str) {
	
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

	return "USD $rcurr";
}

function debug( $var, $cap='' ) {	
	if( $cap != '' ) print $cap.'<br />';
	print '<pre>';
	print_r( $var );
	print '</pre>';
	print '<br /><br />';
}

?>
