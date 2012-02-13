<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");
include( "Pager/Pager.php");

$g_id	=   isset( $_GET['id'])    ?  (int) $_GET['id'] : 0; 
$g_list = ( isset( $_GET['list'] ) && in_array( $_GET['list'], array( "all", "fresh", "expirys" ) ) ) ? $_GET['list'] : '';
$g_name =   isset( $_GET['name'])  ?  (int) $_GET['name'] : 0; 


$g_description     =   isset( $_GET['description']) ? strip_tags( $_GET['description']) : ''; 
	 
$g_in_description  =   isset( $_GET['in_description']);
$g_in_title        =   isset( $_GET['in_title']);
$g_in_name         =   isset( $_GET['in_name']);
$g_in_city         =   isset( $_GET['in_city']);
$g_in_email        =   isset( $_GET['in_email']);
$g_in_webpage      =   isset( $_GET['in_webpage']);
$g_in_id           =   isset( $_GET['in_id']);

$g_category        =   isset( $_GET['category'])  ?  strip_tags( $_GET['category']) : 'any';
$g_region          =   isset( $_GET['region'])    ?  strip_tags( $_GET['region']) : 'any';
$g_min_price       = ( isset( $_GET['min_price']) && $_GET['min_price'] != '') ? max( 0, (int) $_GET['min_price']) : '';
$g_max_price       = ( isset( $_GET['max_price']) && $_GET['min_price'] != '') ? min( (int) $_GET['max_price'], 999999999) : '';

$g_showform        =   isset( $_GET['showform'])  ?  (int) $_GET['showform'] : 1;
$g_showtotal       =   isset( $_GET['showtotal']);
$g_showback        =   isset( $_GET['showback']);

//if there is search text but no search field selected then by default search in description
$g_no_field = ! ($g_in_description || $g_in_title || $g_in_name || $g_in_city || $g_in_email || $g_in_webpage || $g_in_id);
if( $g_description != '' && $g_no_field ) $g_in_description = 1;

	
$filter = 'active=1';
	
if( $g_list != '' ) {

	switch( $g_list ) {
		case "all":
			$filter .= " ";
		break;
		case "fresh":
			$filter .= " AND (lastmodified>='$today')";
		break;
		case "expirys":
			$filter .= " AND DATEDIFF(expiry,$today)=0";
		break;
	}
	
} else {

	$or_filter = '';
	
	$gs_description = escape( $g_description . '%' );
	
	if( $g_in_description ) $or_filter .= " OR description LIKE '$gs_description'";

	if( $g_in_title )       $or_filter .= " OR title LIKE '$gs_description'";

	if( $g_in_name )        $or_filter .= " OR name LIKE '$gs_description'";

	if( $g_in_city )        $or_filter .= " OR city LIKE '$gs_description'";

	if( $g_in_email )       $or_filter .= " OR email LIKE '$gs_description'";

	if( $g_in_webpage )     $or_filter .= " OR webpage LIKE '$gs_description'";
							
	if( $g_in_id )          $or_filter .= " OR id LIKE '$gs_description'";

	if( $or_filter != '' ) $filter .= " AND (1=2 $or_filter)";

	   		 
	if ($g_category != "any" && $g_category != '0') $filter .= " AND (category=(SELECT r.id FROM category r WHERE r.slug='$g_category' LIMIT 1) OR category IN (SELECT r.id FROM category r WHERE r.parent=(SELECT s.id FROM category s WHERE s.slug='$g_category' LIMIT 1)))";
	
	if ($g_region   != "any" && $g_region != '0')   $filter .= " AND (region=(SELECT r.id FROM region r WHERE r.slug='$g_region' LIMIT 1) OR region IN (SELECT r.id FROM region r WHERE r.parent=(SELECT s.id FROM region s WHERE s.slug='$g_region' LIMIT 1)))";

	if ($g_min_price != "") $filter .= " AND ar>=$g_min_price";

	if ($g_max_price != "") $filter .= " AND ar<=$g_max_price";
	
	if( $g_id > 0 ) $filter .= " AND id='$g_id'";
}
	
$rpp = 15; 								//row per page
$tct = Ad::count( array(), $filter );   //total count

$pager_options = array( 'mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct );
$pager = @Pager::factory( $pager_options );

list( $from, $to ) = $pager->getOffsetByPageId();

$ads = Ad::get_all( array(), $filter, ( $from - 1 ) . ", $rpp" );

$curr_page = "home";

include ("./templates/ad-list.php");

?>
