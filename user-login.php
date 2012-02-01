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

if( isset( $_POST['login'] ) ) {

    $p_username = trim( strip_tags( $_POST['username']));
    $p_password = trim( strip_tags( $_POST['password']));
       
    $success = true;
    User::login_errors_clear();    
    
    if( $p_username == '' ) {
        $success = false;
        User::login_errors_add( 'Please enter your username or email.' );
    }

    if( $p_password == '' ) {
        $success = false;
        User::login_errors_add( 'Please enter your password.' );
    }
	                  
    if( $success  && ! User::login( $p_username, $p_password) ) {
		
		User::login_errors_add( 'Incorrect username/email or password.' );
	}
}

if( isset( $_GET['logout'])) session_destroy();

header ('Location: ' . $_SERVER['HTTP_REFERER']);

?>
