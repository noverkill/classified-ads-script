<?php 
/**
 * Classified-ads-script
 * 
 * Admin area
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Admin
 */

include( "./include/common.php");
include( "./include/thumb.php");
	
if ( User::is_logged_in() ) {
	header( 'Location: index.php' );
	exit();
}
	
if( isset( $_POST['user_lost_password'] ) ) {
	
    $p_email = trim( strip_tags( $_POST['email'] ) );
       
    $success = true;
    $errors = array();

    if( $p_email == '' ) {
        $success = false;
        array_push( $errors, "Please enter your email" );
    }
       
    if( $p_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_email ) ) {
        $success = false;
        array_push( $errors, "Your email is formated incorrectly." );
    }

    if( $success ) {		    

		$user = User::get_one( 1 );
				
		if( $user['email'] != $p_email ) {
			$success = false;
			array_push( $errors, "Incorrect email." );
		}
	}
		
	if( $success ) {
				
		$message = StaticContent::get_content( 'user-lost-pasword-email' );	
		eval( "\$message = \"$message\";" );

		mail( $p_email, "Password reminder", $message, "From: ".$noreply ); 
	}
}

include ("page-header.php");

?>

<div id="wrapper">

	<form name="form_login" id="form_login" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

		<h2>Lost Password</h2>

		<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Your password has been sent to your email address.</p>";
			}
			?>

		<label>Email</label>
		<input type='text' name="email" value='<?php if( isset( $p_email ) && ! $success ) print $p_email; ?>' />
		<br />																												
			
			<label>&nbsp;</label>
			<a href='index.php'>Login</a>																												
			<br />
				
		<label for="user_lost_password"></label>
		<input type="submit" name="user_lost_password" value="Send"/>

	</form> 

</div>

<br />

<?php include ("page-footer.php"); ?>
