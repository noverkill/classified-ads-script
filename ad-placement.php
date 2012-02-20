<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");
include( "./admin/include/thumb.php");

if( isset( $_POST['post'] ) ) {
	
    $p_name        = trim( strip_tags( $_POST['name'] ) );
    $p_email       = trim( strip_tags( $_POST['email'] ) );
    $p_telephone   = trim( strip_tags( $_POST['telephone'] ) );
    $p_title       = trim( strip_tags( $_POST['title'] ) );
    $p_description = strip_tags( $_POST['description'] );
    $p_picture     = @$_FILES['picture'];
    $p_category    = (int) $_POST['category'];
    $p_price       = trim( strip_tags( $_POST['price'] ) );
    $p_city        = trim( strip_tags( $_POST['city'] ) );
    $p_region      = (int) $_POST['region'];
    $p_expiry      = (int) $_POST['expiry'];
    $p_webpage     = trim( strip_tags( $_POST['webpage'] ) );	
	$p_terms       = isset( $_POST['terms'] ) ? 1 : 0;
       
    $success = true;
    $errors  = array();

    if( $p_name == '' ) {
        $success = false;
        array_push( $errors, "Please enter your name." );
    }

	/* 
    if ($p_name != '' && ! preg_match ('/^[[:alnum:]]{1,60}/u', $p_name)) {
        $success = false;
        array_push($errors, "The format of your name is incorrect.");
    }
	*/
 
    if( $p_email == '' ) {
        $success = false;
        array_push( $errors, "Please enter your email." );
    }
       
    if( $p_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_email ) ) {
        $success = false;
        array_push( $errors, "The format of your email is incorrect." );
    }

    if( $p_title == '' ) {
        $success = false;
        array_push( $errors, "Please enter the title." );
    }
    
	/*
    if (($p_title) != '' && !preg_match('/^[\w ]{0,60}$/u', $p_title)) {
        $success = false;
        array_push($errors, "Format of the title is incorrect.");
    }
	*/  

    if( $p_description == '' ) {
        $success = false;
        array_push( $errors, "Please enter the description." );
    } 
       
    if( $p_description != '' && ! preg_match( '/^[\s\S]{0,500}$/u', $p_description ) ) {
        $success = false;
        array_push( $errors, "The description must be max 500 character long." );
    }
    
    if( $p_category < 1 ) {
        $success = false;
        array_push( $errors, "Please select category." );
    }
       
    if( $p_category != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_category ) ) {
        $success = false;
        array_push( $errors, "Incorrect category." );
    }

	/*       
    if ($p_price != '' && ! preg_match ('/^[\w ]{0,20}$/u', $p_price)) {
        $success = false;
        array_push($errors, "The price should be no more than 20 characters.");
    }                                                           
	*/

	/*       
    if ($p_city != '' && ! preg_match ('/^[\w ]{0,50}$/u', $p_city)) {
        $success = false;
        array_push( $errors, "The city should be no more than 50 characters." );
    }
	*/

    if( $p_region < 1 ) {
        $success = false;
        array_push( $errors, "Please select region." );
    }
           
    if( $p_region != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_region ) ) {
        $success = false;
        array_push( $errors, "Incorrect region." );
    }

    if( $p_expiry < 1 ) {
        $success = false;
        array_push( $errors, "Please enter the expiry" );
    }
        
    if( $p_expiry != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_expiry ) ) {
        $success = false;
        array_push( $errors, "Incorrect expiry." );
    }

	if( '' != $p_webpage && 0 !== strpos( $p_webpage, 'http://' ) ) $p_webpage = 'http://' . $p_webpage;
	   
    if( $p_webpage != '' && ! preg_match( '/^((http|https):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $p_webpage ) ) {
        $success = false;
        array_push( $errors, "The format of webpage is incorrect." );
    }
 
 	if( isset( $p_picture ) && isset( $p_picture['name'] ) && $p_picture['name'] != '' ) {
		
		list( $postedon_year, $postedon_month, $postedon_day) = explode( '-', $today );
		
		$picture_path = "$upload_path/$postedon_year/$postedon_month/$postedon_day/picture";
		$thumb_path   = "$upload_path/$postedon_year/$postedon_month/$postedon_day/thumb";	
		
		include( "./admin/include/picture-upload.php" );
		
	} else {
		
		$p_picture = '';
	}
	  	
	if ($p_terms < 1) {
		$success = false;
		array_push( $errors, "You should agree with the Terms and Conditions." );
	}
	                  
    if( $success ) {

		$ipaddr   = $_SERVER['REMOTE_ADDR'];
		
		if( UserBanned::exists( 0, array(), "(email='$p_email' OR ipaddr='$ipaddr')" ) ) {
			
			$last = 666666;
		
		} else {

			$postedon = date( "Y-m-d H:i:s", time () );   
			$expiry   = date( "Y-m-d"      , time () + $p_expiry * 24 * 60 * 60 );   
			$code  = md5( uniqid( rand(), true ) ); 

			if( User::is_logged_in() ) {
				$p_name  = User::get_name();
				$p_email = User::get_email(); 
			}
			
			$last = Ad::create( array(  
				'user_id'	   => User::get_id(),
				'name'         => $p_name, 
				'email'        => $p_email, 
				'telephone'    => $p_telephone, 
				'title'        => $p_title, 
				'description'  => $p_description, 
				'picture'      => $p_picture, 
				'category'     => $p_category, 
				'price'        => $p_price, 
				'city'         => $p_city, 
				'region'       => $p_region, 
				'expiry'       => $expiry, 
				'webpage'      => $p_webpage,
				'code'         => $code,
				'ipaddr'       => $ipaddr,
				'postedon'     => $postedon,
				'lastmodified' => $postedon
			 ) );

			if( User::is_logged_in() ) {
				
				Ad::activate( $last );        			
			
			} else {
				
				if( ! $user_exists = User::exists( 0, array( 'email' => $p_email ) ) ) {
					
					$p_em      = explode( '@', $p_email ); 
					$username  = substr ( $p_em[0], 0, 6 );	
					$active    = 0;
					$createdon = date( "Y-m-d H:i:s", time () );
					$password  = substr( $code, 0, 6 );
										
					$userid = User::create (
						array (	
							'email'     => $p_email,
							'username'  => $username,
							'password'  => $password,
							'name'      => $p_name,	
							'active'   	=> $active,
							'createdon' => $createdon,
							'ipaddr'    => $ipaddr,
							'code'   	=> $code,
					) );

					$registration_message = StaticContent::get_content('user-registration-email');		
					eval( "\$registration_message = \"$registration_message\";" );

				} else {
					$user = User::get_one( 0, array( 'email' => $p_email ) );
					$username = $user['username'];
					 
				}
				
				$ad_activation_message = StaticContent::get_content( 'ad-activation-email' );			
				eval( "\$ad_activation_message = \"$ad_activation_message\";" );

				mail( $p_email, "Ad activation (Id: $last)", $ad_activation_message, "From: ".$noreply ); 

				debug($ad_activation_message);
								
				if( ! $user_exists ) {
					mail( $p_email, "Registration", $registration_message, "From: ".$noreply );
					debug($registration_message);
				} 
			}
		}
    }
}
								
$curr_page = "post-an-ad";

include( "./templates/ad-placement.php" ); 

?>
