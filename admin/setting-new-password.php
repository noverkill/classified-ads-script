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

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$user = User::get_one( 1 );	
	
if( isset( $_POST['setting_password'] ) ) {
	
    $p_old_password = trim( strip_tags( $_POST['old_password'] ) );
    $p_new_password = trim( strip_tags( $_POST['new_password'] ) );

    $success = true;
    $errors = array();
    
    if( $p_old_password == '' ) {
        $success = false;
        array_push( $errors, "Please enter your current password.");
    }
	
    if( $success && $p_old_password != $user['password'] ) {
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
		
    if ( $success) User::update( 1, array( 'password' => $p_new_password ) );
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_setting_password" id="form_setting_password" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_group_page['name'].' '.$current_sub_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Your password changed succesfuly.</p>";
			}
			?>

			<label for='old_password' class="required">Current password</label>
			<input name='old_password' type='password' <?php if (isset($p_old_password) && ! $success) print "value='$p_old_password'"; ?> />
			<p class='note'>Required</p>
			<br />
			
			<label for='new_password' class="required">New password</label>
			<input name='new_password' type='password' <?php if (isset($p_new_password) && ! $success) print "value='$p_new_password'"; ?> />
			<p class='note'>Required</p>
			<br />
								
			<label for="setting_password"></label>
			<input type="submit" name="setting_password" value="Change"/>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
