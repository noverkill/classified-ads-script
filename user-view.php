<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

$id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;

$exists = User::exists( $id, array( "active  " => 1 ) );

if( $exists ) {
	
	$user = User::get_one( $id );
	
	$reviews = UserReview::get_all( array( 'reviewed_user' => $id ) );
}

include( "./templates/user-view.php" ); 

?>
