<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

$r_id = isset( $_REQUEST['id']) ? (int) $_REQUEST['id'] : 0; 

$exists = Ad::exists( $r_id, array( "active" => 1 ) );
    
if ( $exists && isset( $_POST['send'])) {

	$success = true;
	$errors  = array();

	$p_sender_email    = $_POST['sender_email'];	
	$p_sender_name     = $_POST['sender_name'];

	$p_recipient_email = $_POST['recipient_email'];
	$p_recipient_name  = $_POST['recipient_name'];

    if( $p_sender_email == '' ) {
        $success = false;
        array_push( $errors, "Please enter your email." );
    }
        	
    if( $p_sender_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_sender_email ) ) {
        $success = false;
        array_push( $errors, "Your email is not valid." );
    }

    if( $p_recipient_email == '' ) {
        $success = false;
        array_push( $errors, "Please enter the recipient email." );
    }
    
    if( $p_recipient_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_recipient_email ) ) {
        $success = false;
        array_push( $errors, "The recipient email is not valid." );
    }

    if( $success ) {
		
		$recipient = "$p_recipient_name ($p_recipient_email)";
		if ($p_recipient_name == '') $recipient = $p_recipient_email;
		
		$sender = "$p_sender_name ($p_sender_email)";
		if ($p_sender_name == '') $felado = $p_sender_email;
		 
		$message = StaticContent::get_content('ad-sending-email');	
		eval( "\$message = \"$message\";" );

		mail( $p_recipient_email, "Forwarded ad", $message, "From: ".$noreply);  
	}
}

include( "./templates/ad-sending.php" ); 

?>
