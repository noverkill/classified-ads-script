<?php

include( "./admin/include/common.php" );

if( User::is_logged_in() ) header( 'Location: index.php' );

if( isset( $_POST['register'] ) ) {
	
    $p_email     = trim( strip_tags( $_POST['email'] ) );
    $p_username  = trim( strip_tags( $_POST['username'] ) );
    $p_password  = trim( strip_tags( $_POST['password'] ) );
       
    $success = true;
    $errors  = array();

    if( $p_email == '' ) {
        $success = false;
        array_push( $errors, "Please enter your email." );
    }
       
    if( $p_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_email ) ) {
        $success = false;
        array_push( $errors, "Incorrect email format." );
    }

    if( $p_username == '' ) {
        $success = false;
        array_push( $errors, "Please enter your username." );
    }
    	
    if( $p_password == '' ) {
        $success = false;
        array_push( $errors, "Please enter your password." );
    } 
   
    if( $p_password != '' && ! preg_match( '/^[\s\S]{3,10}$/u', $p_password ) ) {
        $success = false;
        array_push( $errors, "The password must be 3-10 character." );
    }

    if( $success ) {

		$user = User::get_all( array( 'email' => $p_email ), '', 1 );

		$exists = isset( $user[0]['id'] );
				
		if( $exists ) {
			
			$success = false;
			array_push( $errors, "This email has already registered in our system." );
		
		}
	}

    if( $success ) {

		$user = User::get_all( array( 'username' => $p_username ), '', 1 );

		$exists = isset( $user[0]['id'] );
				
		if( $exists ) {
			
			$success = false;
			array_push( $errors, "This username has already registered in our system." );
		
		}
	}
	
    if( $success ) {

		$name      = ucfirst( $p_username );	
		$active    = 0;
		$createdon = date( "Y-m-d H:i:s", time () );
		$ipaddr    = $_SERVER['REMOTE_ADDR'];
		$code      = md5( uniqid( rand(), true ) ); 
							
		$last = User::create (
			array (	
				'email'     => $p_email,
				'username'  => $p_username,
				'password'  => $p_password,
				'name'      => $name,	
				'active'   	=> $active,
				'createdon' => $createdon,
				'ipaddr'    => $ipaddr,
				'code'   	=> $code,
		) );

		$userid   = $last;
		$email    = $p_email;
		$username = $p_username;
		$password = $p_password;
							
		$message = StaticContent::get_content('user-registration-email');		
		eval( "\$message = \"$message\";" );

		mail( $p_email, "Registration", $message, "From: ".$noreply ); debug($message);
	}
} else {

	if( isset( $_GET['id'] ) && isset( $_GET['code'] ) ) {	

		$p_id   = (int)$_GET['id'];
		$p_code = $_GET['code'];

		$success = true;
		$errors  = array();
		
		if( ! User::exists( $p_id, array( 'code' => $p_code ) ) ) {
			$success = false;
			array_push( $errors, "Incorrect activation data!" );
		}

		if( $success ) {
			
			User::update( $p_id, array( 'active' => 1 ) );
		}	
	}
}

include( "./templates/user-registration.php" ); 

?>
