<?php

include( "./include/common.php");
include( "./include/thumb.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$g_id = ( isset( $_REQUEST['id'] ) ) ? (int) $_REQUEST['id'] : 0;
    
$user = User::get_one( $g_id );

$exists = ( isset( $user['id'] ) && $g_id > 1 );

if( $g_id > 0 && ! $exists ) {
	$success = false;
	$errors = array_push( $errors, $current_group_page['name'] . " not exist." );	
}

if( $exists ) {
	
	$p_name        = $user['name'];
	$p_username    = $user['username'];
	$p_email       = $user['email'];
	$p_telephone   = $user['telephone'];
	$p_city        = $user['city'];
	$p_region      = $user['region'];
	$p_category    = $user['category'];
	$p_webpage     = $user['webpage'];
	$p_active      = $user['active'];

	$current_sub_page['name'] .= " ( id: $g_id )"; 
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['user_edit'] ) ) {

    $p_name      = trim( strip_tags( $_POST['name'] ) );
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
		
		$fields = array( 
			'name'      => $p_name, 
			'telephone' => $p_telephone, 
			'city'      => $p_city,
			'region'    => $p_region,
			'category'  => $p_category,
			'webpage'   => $p_webpage,
			'active'   	=> $p_active
		);
		
		User::update( $g_id, $fields );
		
		$user = User::get_one( $g_id );

		if( $p_send_activation_email ) {

			$userid    = $user['id'];
			$code      = $user['code'];
			$username  = $user['username'];
			$password  = $user['password'];
					
			$message = StaticContent::get_content('user-registration-email');		
			eval( "\$message = \"$message\";" );

			mail ($user['email'], "Registration", $message, "From: ".$noreply); 		
		}
	}
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_user_edit" id="form_user_edit" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print 'Edit ' . $current_group_page['name'] . ($exists ? "<span class='note'>( id: $g_id )</span>" : ''); ?></h2>

			<br />

			<?php
			if( isset( $success ) ) {
				if( ! $success ) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>User modified succesfuly.</p>";
			}
			?>

			<?php if( ! $exists ) { ?>

				<label for='id' class="required">Id</label>
				<input name='id' type='text' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				<br />

				<label for="user_get"></label>
				<input type="submit" name="user_get" value="Edit"/>
							
			<?php } else { ?>

				<input name='id' type='hidden' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				
				<label for='name' class="required">Name</label>
				<input name='name' type='text' value='<?php print $p_name; ?>' />
				<p class='note'>Required</p>
				<br />
				
				<label for='username' class="required">Username</label>
				<input name='username' type='text' disabled='disabled' value='<?php print $p_username; ?>' />
				<p class='note'>Required</p>
				<br />
				
				<label for='email' class="required">Email</label>
				<input name='email' type='text' disabled='disabled' value='<?php print $p_email; ?>' />
				<p class='note'>Required</p>
				<br />
				
				<label for='telephone'>Telephone</label>
				<input name='telephone' type='text' value='<?php print $p_telephone; ?>' />
				<p class='note'></p>
				<br />

				<label for='city'>City</label>
				<input name='city' type='text' value='<?php print $p_city; ?>' />
				<p class='note'></p>
				<br />
							
				<label for='region' class="required">Region</label>
				<select name='region'>  
					<?php
						if( count( $regions ) < 1 ) print "<option value='0'>Create Regions first!</option>";
						foreach ($regions as $region) {
							$selected = '';
							if( isset( $p_region ) ) { if( $p_region == $region['id'] ) $selected = "selected='selected'"; } 
							else { if( $user['region'] == $region['id'] ) $selected = "selected='selected'"; }
							print "<option value='" . $region['id'] . "' $selected>" . $region['name'] . "</option>";
							$sub_regions = $region['childs'];
							if (is_array ($sub_regions)) {
								foreach ($sub_regions as $sub_region) {
									$selected = '';
									if( isset( $p_region ) ) { if( $p_region == $sub_region['id'] ) $selected = "selected='selected'"; } 
									else { if( $user['region'] == $sub_region['id'] ) $selected = "selected='selected'"; }
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
							else { if( $user['category'] == $category['id'] ) $selected = "selected='selected'"; }
							print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
							$sub_categories = $category['childs'];
							if( is_array( $sub_categories ) ) {
								foreach( $sub_categories as $sub_category ) {
									$selected = '';
									if( isset( $p_category ) ) { if( $p_category == $sub_category['id'] ) $selected = "selected='selected'"; } 
									else { if( $user['category'] == $sub_category['id'] ) $selected = "selected='selected'"; }
									print "<option value='" . $sub_category['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
								}
							}
						}
					?>                 
				</select>
				<p class='note'>Required</p>
				<br />
				
				<label for='webpage'>Webpage</label>
				<input name='webpage' type='text' value='<?php print $p_webpage; ?>' />
				<p class='note'></p>
				<br />

				<label for='active'>&nbsp;</label>
				<input name='active' type='checkbox' <?php if( $p_active ) print 'checked="checked"'; ?> />Active
				<br />

				<label for='send_activation_email'>&nbsp;</label>
				<input name='send_activation_email' type='checkbox' <?php if( isset( $p_send_activation_email ) && $p_send_activation_email && isset( $success ) && ! $success) print 'checked="checked"'; ?> />Send activation email
				<br />
				<br />
									
				<label for="user_edit"></label>
				<input type="submit" name="user_edit" value="Modify"/>
				<span><input type="submit" name="reset" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /></span>

			<?php } ?>
			
		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
