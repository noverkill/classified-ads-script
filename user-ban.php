<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;

$exists = User::exists( 0, array( 'id' => $id ) );

if( $exists ) {
	
	$user = User::get_one( $id );

	UserBanned::create( $user, $id );
	
	Ad::delete( 0, array( 'user_id' => $id ) );

	User::delete( $id );
}

include( "./templates/user-ban.php" ); 

?>
