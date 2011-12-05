<?php

include( "./admin/include/common.php");

if( User::is_logged_in() ) header( 'Location: index.php' );

if( isset( $_POST['send'] ) ) {
	
    $p_email = trim( strip_tags( $_POST['email'] ) );
       
    $success = true;
    $errors  = array();

    if( $p_email == '' ) {
        $success = false;
        array_push( $errors, "Pleas enter your email" );
    }
       
    if( $p_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_email ) ) {
        $success = false;
        array_push( $errors, "Your email is formated incorrectly." );
    }

    if( $success ) {		    
		
		$user = User::get_all( array( 'email' => $p_email ), '', 1 );
		
		$exists = isset( $user[0]['id'] );
		
		if( ! $exists ) {
			
			$success = false;
			array_push( $errors, "Your email has not been registered in our system.");
			
		} else {
			
			$user = $user[0];
			
			$username = $user['username'];
			$password = $user['password'];
			
			$message = StaticContent::get_content('user-lost-pasword-email');	
			eval( "\$message = \"$message\";" );

			mail( $p_email, "Password reminder", $message, "From: ".$noreply );			
		}
	}
}

include( "./templates/user-lost-password.php" ); 

?>
