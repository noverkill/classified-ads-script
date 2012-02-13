<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

if( ! User::is_logged_in() ) header( 'Location: index.php' );

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( isset( $_POST['modify'] ) ) {
	
    $p_name      = trim( strip_tags( $_POST['name'] ) );
    $p_telephone = trim( strip_tags( $_POST['telephone'] ) );
    $p_city      = trim( strip_tags( $_POST['city'] ) );
    $p_region    = (int) $_POST['region'];
    $p_category  = (int) $_POST['category'];
    $p_webpage   = trim( strip_tags( $_POST['webpage'] ) );

    $success = true;
    $errors  = array();

    if( $p_name == '' ) {
        $success = false;
        array_push( $errors, "Please enter your name." );
    }
    
    if( $p_region != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_region ) ) {
        $success = false;
        array_push( $errors, "Incorrect region." );
    }

    if ( $p_category != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_category ) ) {
        $success = false;
        array_push( $errors, "Incorrect Category." );
    }

	if( '' != $p_webpage && 0 !== strpos( $p_webpage, 'http://' ) ) $p_webpage = 'http://' . $p_webpage;
		
    if( $p_webpage != '' && ! preg_match( '/^((http|https):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $p_webpage ) ) {
        $success = false;
        array_push($errors, "The format of webpage is incorrect.");
    }
       
    if ( $success) {

		User::set_props (
			array (		
				'name'      => $p_name,
				'telephone' => $p_telephone,
				'city'      => $p_city,
				'region'    => $p_region,
				'category'  => $p_category,
				'webpage'   => $p_webpage
			) 
		);
	}
}

include( "./templates/user-profile.php" ); 

?>
