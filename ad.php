<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php" );
include( "Pager/Pager.php" );

$g_id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;

$exists = Ad::exists( $g_id, array( "active  " => 1 ) );

if( $exists ) {
	
	$ad = Ad::get_one( $g_id );
	
	$is_favourite = Favourite::exists( User::get_id(), $ad['id'] );
	
	$reviews = AdReview::get_all( array( 'ad_id' => $g_id ) );
}

include ("./templates/ad.php");

?>
