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

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_POST['user_create'])) {

    $p_name      = trim( strip_tags( $_POST['name'] ) );
    $p_username  = trim( strip_tags( $_POST['username'] ) );	
    $p_email     = trim( strip_tags( $_POST['email'] ) );
    $p_password  = trim( strip_tags( $_POST['password'] ) );
    $p_telephone = trim( strip_tags( $_POST['telephone'] ) );
    $p_city      = trim( strip_tags( $_POST['city'] ) );
    $p_region    = (int) $_POST['region'];
    $p_category  = (int) $_POST['category'];
    $p_webpage   = trim( strip_tags( $_POST['webpage'] ) );
	$p_active    = isset( $_POST['active'] ) ? 1 : 0;
	
	$p_send_activation_email = isset( $_POST['send_activation_email'] ) ? 1 : 0;
	
    $success = true;
    $errors = array();

    if( $p_name == '' ) {
        $success = false;
        array_push( $errors, "Please enter your name." );
    }
    
    if( $p_username == '' ) {
        $success = false;
        array_push( $errors, "Please enter your username." );
    }
	    
    if( $p_email == '' ) {
        $success = false;
        array_push( $errors, "Please enter your email." );
    }
       
    if( $p_email != '' && ! preg_match( '/^[\.\+_a-z0-9-]+@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+[a-z]{2}[mtgvu]?$/i', $p_email ) ) {
        $success = false;
        array_push( $errors, "Incorrect email format." );
    }
	
    if( $p_password == '' ) {
        $success = false;
        array_push( $errors, "Please enter your password." );
    } 
   
    if( $p_password != '' && ! preg_match( '/^[\s\S]{3,10}$/u', $p_password ) ) {
        $success = false;
        array_push( $errors, "The password must be 3-10 character." );
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
 
     if( $success ) {
		 
		if( User::exists( array( 'username' => $p_username ) ) ) {
			$success = false;
			array_push( $errors, "This username has already registered in our system." );
		}
	
		if( User::exists( array( 'email' => $p_email ) ) ) {
			$success = false;
			array_push( $errors, "This email has already registered in our system." );
		}
	}
	   
    if( $success ) {

		$createdon = date( "Y-m-d H:i:s", time () );
		$ipaddr    = $_SERVER['REMOTE_ADDR'];
		$code      = md5( uniqid( rand(), true ) ); 
							
		$last = User::create (
			array (
				'name'      => $p_name,		
				'username'  => $p_username,
				'email'     => $p_email,
				'password'  => $p_password,
				'telephone' => $p_telephone,
				'city'      => $p_city,
				'region'    => $p_region,
				'category'  => $p_category,
				'webpage'   => $p_webpage,
				'active'   	=> $p_active,
				'createdon' => $createdon,
				'ipaddr'    => $ipaddr,
				'code'   	=> $code,
		) );

		if( $p_send_activation_email ) {
			
			$userid   = $last;
			$email    = $p_email;
			$username = $p_username;
			$password = $p_password;
			
			$message = StaticContent::get_content('user-registration-email');		
			eval( "\$message = \"$message\";" );

			mail ($email, "Registration", $message, "From: ".$noreply); 
			
			print $message;			
		}
	
	}		
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_user_create" id="form_user_create" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_sub_page['name'].' '.$current_group_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>" . $current_group_page['name'] . " created succesfuly.<span class='note'>( id: <a href='user-edit.php?id=$last' target='_blank'>$last</a> )</span></p>";
			}
			?>

			<label for='name' class="required">Name</label>
			<input name='name' type='text' value='<?php if( isset( $p_name ) && ! $success ) print $p_name; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='username' class="required">Username</label>
			<input name='username' type='text' value='<?php if( isset( $p_username ) && ! $success ) print $p_username; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='email' class="required">Email</label>
			<input name='email' type='text' value='<?php if( isset( $p_email ) && ! $success ) print $p_email; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='password' class="required">Password</label>
			<input name='password' type='password' value='<?php if( isset( $p_password ) && ! $success ) print $p_password; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='telephone'>Telephone</label>
			<input name='telephone' type='text' value='<?php if( isset( $p_telephone ) && ! $success ) print $p_telephone; ?>' />
			<p class='note'></p>
			<br />

			<label for='city'>City</label>
			<input name='city' type='text' value='<?php if( isset( $p_city ) && ! $success ) print $p_city; ?>' />
			<p class='note'></p>
			<br />
						
			<label for='region' class="required">Region</label>
			<select name='region'>  
				<?php
					if( count( $regions ) < 1 ) print "<option value='0'>Create Regions first!</option>";
					foreach ($regions as $region) {
						$selected = '';
						if( isset( $p_region ) ) { if( $p_region == $region['id'] ) $selected = "selected='selected'"; } 
						print "<option value='" . $region['id'] . "' $selected>" . $region['name'] . "</option>";
						$sub_regions = $region['childs'];
						if (is_array ($sub_regions)) {
							foreach ($sub_regions as $sub_region) {
								$selected = '';
								if( isset( $p_region ) ) { if( $p_region == $sub_region['id'] ) $selected = "selected='selected'"; } 
								print "<option value='" . $sub_region['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
							}
						}
					}
				?>                 
			</select>
			<p class='note'>Required</p>
			<br />
			
			<label for='category' class="required">Category</label>
			<select name='category'>  
				<?php
					if( count( $categories ) < 1 ) print "<option value='0'>Create categories first!</option>";
					foreach( $categories as $category ) {
						$selected = '';
						if( isset( $p_category ) ) { if( $p_category == $category['id'] ) $selected = "selected='selected'"; } 
						print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
						$sub_categories = $category['childs'];
						if( is_array( $sub_categories ) ) {
							foreach( $sub_categories as $sub_category ) {
								$selected = '';
								if( isset( $p_category ) ) { if( $p_category == $sub_category['id'] ) $selected = "selected='selected'"; } 
								print "<option value='" . $sub_category['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
							}
						}
					}
				?>                
			</select>
			<p class='note'>Required</p>
			<br />
			
			<label for='webpage'>Webpage</label>
			<input name='webpage' type='text' value='<?php if( isset( $p_webpage ) && ! $success ) print $p_webpage; ?>' />
			<p class='note'></p>
			<br />

			<label for='active'>&nbsp;</label>
			<input name='active' type='checkbox' <?php if( isset( $p_active ) && ! $success ) print 'checked="checked"'; ?> />Active
			<br />

			<label for='send_activation_email'>&nbsp;</label>
			<input name='send_activation_email' type='checkbox' <?php if( isset( $p_send_activation_email ) && ! $success ) print 'checked="checked"'; ?> />Send activation email
			<br />
			<br />
								
			<label for="user_create"></label>
			<input type="submit" name="user_create" value="Create"/>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
