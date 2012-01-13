<?php

include( "./include/common.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$g_id   = 1;

$user = User::get_one( $g_id );

$exists = 1;

if( $exists ) {
	
	$p_name        = $user['name'];
	$p_username    = $user['username'];
	$p_email       = $user['email'];
	$p_telephone   = $user['telephone'];
	$p_city        = $user['city'];
	$p_region      = $user['region'];
	$p_category    = $user['category'];
	$p_webpage     = $user['webpage'];
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['setting_profile'] ) ) {

    $p_name      = trim( strip_tags( $_POST['name'] ) );
    $p_username  = trim( strip_tags( $_POST['username'] ) );
    $p_email     = trim( strip_tags( $_POST['email'] ) );
    $p_telephone = trim( strip_tags( $_POST['telephone'] ) );
    $p_city      = trim( strip_tags( $_POST['city'] ) );
    $p_region    = (int) $_POST['region'];
    $p_category  = (int) $_POST['category'];
    $p_webpage   = trim( strip_tags( $_POST['webpage'] ) );
	
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

		$ex = User::get_all( array( 'username' => $p_username ), 'id > 1' );
		
		$exists = isset( $ex[0]['id'] );

		if( $exists ) {
			$success = false;
			array_push( $errors, "This username has already registered in the system." );
		}
	}

     if( $success ) {

		$ex = User::get_all( array( 'email' => $p_email ), 'id > 1' );
		
		$exists = isset( $ex[0]['id'] );

		if( $exists ) {
			$success = false;
			array_push( $errors, "This email has already registered in the system." );
		}
	}
		   
    if( $success ) {
		
		$fields = array( 
			'name'      => $p_name, 
			'username'  => $p_username, 
			'email'     => $p_email, 
			'telephone' => $p_telephone, 
			'city'      => $p_city,
			'region'    => $p_region,
			'category'  => $p_category,
			'webpage'   => $p_webpage
		);
		
		User::update( $g_id, $fields );
		
		$user = User::get_one( $g_id );
	}
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_setting_profile" id="form_setting_profile" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_group_page['name'].' '.$current_sub_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Admin profile modified succesfuly.</p>";
			}
			?>

			<label for='name' class="required">Name</label>
			<input name='name' type='text' value='<?php print $p_name; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='username' class="required">Username</label>
			<input name='username' type='text' value='<?php print $p_username; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='email' class="required">Email</label>
			<input name='email' type='text' value='<?php print $p_email; ?>' />
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
					foreach ($regions as $regio) {
						$selected = '';
						if ($p_regio == $regio['id']) $selected = "selected='selected'";
						print "<option value='" . $regio['id'] . "' $selected>" . $regio['name'] . "</option>";
						$sub_regions = $regio['childs'];
						if (is_array ($sub_regions)) {
							foreach ($sub_regions as $sub_region) {
								$selected = '';
								if ($p_regio == $sub_region['id']) $selected = "selected='selected'";
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
					if (count($categories) < 1) print "<option value='0'>Create a category first!</option>";
					foreach ($categories as $category) {
						$selected = '';
						if ($p_category == $category['id']) $selected = "selected='selected'";
						print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
						$sub_categories = $category['childs'];
						if (is_array ($sub_categories)) {
							foreach ($sub_categories as $sub_category) {
								$selected = '';
								if ($p_category == $sub_category['id']) $selected = "selected='selected'";
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
								
			<label for="setting_profile"></label>
			<input type="submit" name="setting_profile" value="Modify"/>
			<span><input type="submit" name="reset" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /></span>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
