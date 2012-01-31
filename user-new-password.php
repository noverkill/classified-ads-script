<?php 
/**
 * Classified-ads-script
 * 
 * Admin area
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

if( ! User::is_logged_in() ) header( 'Location: index.php' );

if( isset( $_POST['change'] ) ) {
	
    $p_old_password = trim( strip_tags( $_POST['old_password'] ) );
    $p_new_password = trim( strip_tags( $_POST['new_password'] ) );

    $success = true;
    $errors  = array();
    
    if( $p_old_password == '' ) {
        $success = false;
        array_push( $errors, "Please enter your current password.");
    }
	
    if( $success && $p_old_password != User::get_password() ) {
		$success = false;
		array_push( $errors, "Incorrect current password.");
	}
		   
    if( $p_new_password == '' ) {
        $success = false;
        array_push( $errors, "Please enter your new password." );
    } 
   
    if( $p_new_password != '' && ! preg_match( '/^[\s\S]{3,10}$/u', $p_new_password ) ) {
        $success = false;
        array_push( $errors, "The new password has to be 3-10 character.");
    }
		
    if ( $success) User::update( User::get_id(), array( 'password' => $p_new_password ) );
}

include( "./templates/user-new-password.php" ); 

?>
