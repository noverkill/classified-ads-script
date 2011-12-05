<?php

include( "./include/common.php");
include( "./include/thumb.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$g_id = isset( $_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

$ad = Ad::get_one( $g_id );

$exists = isset( $ad['id'] );

if( $g_id > 0 && ! $exists ) {
	$success = false;
	$errors = array( $current_group_page['name'] . " not exist." );	
}

if( $exists && isset( $_POST['ad_edit'] ) ) {
	
	$p_name        = trim( strip_tags( $_POST['name'] ) );
	$p_telephone   = trim( strip_tags( $_POST['telephone'] ) );
	$p_title       = trim( strip_tags( $_POST['title'] ) );
	$p_extend      = (int) $_POST['extend'];
	$p_description = strip_tags( $_POST['description'] );
	$p_category    = (int) $_POST['category'];
	$p_price       = trim( strip_tags( $_POST['price'] ) );
	$p_city        = trim( strip_tags( $_POST['city'] ) );
	$p_region      = (int) $_POST['region'];
	$p_webpage     = trim( strip_tags( $_POST['webpage'] ) );

	$p_picture     = @$_FILES['picture'];
	$p_del_picture = isset( $_POST['del_picture'] ) ? 1 : 0;	
	
	$success = true;
	$errors = array();
	
	if( $p_name == '' ) {
		$success = false;
		array_push( $errors, "Please enter your name." );
	}

	if( $p_title == '' ) {
		$success = false;
		array_push( $errors, "Please enter a title." );
	}   

	if( $p_description == '' ) {
		$success = false;
		array_push( $errors, "Please enter a description." );
	} 
		   
	if( $p_description != '' && ! preg_match( '/^[\s\S]{0,500}$/u', $p_description ) ) {
		$success = false;
		array_push( $errors, "The description should be no more than 500 character." );
	}

	if( $p_category < 1 ) {
		$success = false;
		array_push( $errors, "No category selected." );
	}
		   
	if( $p_category != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_category ) ) {
		$success = false;
		array_push( $errors, "The category is incorrect." );
	}
	
	if( $p_region < 1 ) {
		$success = false;
		array_push( $errors, "No region selected." );
	}
	   
	if( $p_region != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_region ) ) {
		$success = false;
		array_push( $errors, "The region is incorrect." );
	}
  
	if( '' != $p_webpage && 0 !== strpos( $p_webpage, 'http://' ) ) $p_webpage = 'http://' . $p_webpage;
	  
	if( $p_webpage != '' && ! preg_match( '/^((http|https):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $p_webpage ) ) {
		$success = false;
		array_push( $errors, "The format of webpage address is incorrect." );
	}
	
	if( isset( $p_picture ) && isset( $p_picture['name'] ) && $p_picture['name'] != '' ) {
		
		list( $postedon_year, $postedon_month, $postedon_day) = explode( '-', $ad['postedon'] );
		
		$picture_path = ".$upload_path/$postedon_year/$postedon_month/$postedon_day/picture";
		$thumb_path   = ".$upload_path/$postedon_year/$postedon_month/$postedon_day/thumb";	
		
		include( "./include/picture-upload.php" );
		
	} else {
		
		$p_picture = '';
	}
					  
	if( $success ) {
		
		$fields = array( 'name' => $p_name, 'telephone' => $p_telephone, 'title' => $p_title, 'extend' => $p_extend, 'description' => $p_description, 'category' => $p_category, 'price' => $p_price, 'city' => $p_city, 'region' => $p_region, 'webpage' => $p_webpage );
		
		if( $p_picture != '' || $p_del_picture > 0 ) $fields['picture'] = $p_picture;
		
		Ad::update( $g_id, $fields );
		
		$ad = Ad::get_one( $g_id );
	}
}

if( $exists ) {
		
	$p_name        = $ad['name'];
	$p_telephone   = $ad['telephone'];
	$p_title       = $ad['title'];
	$p_description = $ad['description'];
	$p_category    = isset( $ad['sub_category_id'] ) ? $ad['sub_category_id'] : $ad['main_category_id'];
	$p_price       = $ad['price'];
	$p_city        = $ad['city'];
	$p_region      = isset( $ad['sub_region_id'] ) ? $ad['sub_region_id'] : $ad['main_region_id'];
	$p_webpage     = $ad['webpage'];
	$p_expiry      = $ad['expiry'];	
	$p_del_picture = 0;

	$current_sub_page['name'] .= " ( id: $g_id )"; 
}
					
$expiries = Expiry::get_all();

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_ad_edit" id="form_ad_edit" method="post" enctype='multipart/form-data' accept-charset="UTF-8" class="form">

			<h2><?php print 'Edit ' . $current_group_page['name'] . ($exists ? "<span class='note'>( id: $g_id )</span>" : ''); ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>The Ad succesfuly modified.</p>";
			}
			?>

			<?php if( ! $exists ) { ?>

				<label for='id' class="required">Id</label>
				<input name='id' type='text' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				<br />

				<label for="ad_get"></label>
				<input type="submit" name="ad_get" value="Edit"/>
							
			<?php } else { ?>

				<input name='id' type='hidden' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
							
				<label for='current-picture'>Current picture</label>
				<a class='current-picture' href=".<?php print $ad['picture']; ?>">
					<img src=".<?php print $ad['thumb']; ?>" />
				</a>
				<br />
						
				<label for='del_picture'>&nbsp;</label>
				<input name='del_picture' type='checkbox' <?php if ( $p_del_picture > 0 ) print 'checked="checked"'; ?> />
				<span>Delete picture</span>
				<br />
																							
				<label for='name' class="required">Name</label>
				<input name='name' type='text' value='<?php if( isset( $p_name ) ) print $p_name; ?>' />
				<br />
						
				<label for='email' class="required">Email</label>
				<input name='email' type='text' disabled='disabled' value='<?php print $ad['email']; ?>' />
				<br />
					
				<label for='telephone'>Telephone</label>
				<input name='telephone' type='text' value='<?php if( isset( $p_telephone ) ) print $p_telephone; ?>' />
				<br />
					
				<label for='title' class="required">Title</label>
				<input name='title' id='title' type='text' <?php if( isset( $p_title ) ) print "value='$p_title'"; ?> onKeyDown="textCounter('title',60,'title-counter')" onKeyUp="textCounter('title',60,'title-counter')" />
				<div class="note">The title can be <input id="title-counter" type="text" value="60" /> charaters more.</div>
				<script>textCounter('title',60,'title-counter')</script>
				<br />
					
				<label for='expiry' class="required">Expiry</label>
				<input name='expiry' type='text' disabled="disabled" value="<?php print $p_expiry; ?>" /> 
				<br />

				<label for='extend' class="required">Extend</label>
				<select name='extend'>  
					<option value='0'>0</option>
					<?php
						if( count( $expiries ) < 1 ) print "<option value='0'>Create Expiries first!</option>";
						else {
							foreach( $expiries as $expiry )	
								print "<option value='" . $expiry['period'] . "'>" . $expiry['name'] . "</option>";
						}
					?>                 
				</select>
				<br />
											
				<label for='picture'>New picture</label>
				<input name='MAX_FILE_SIZE' type='hidden' value='512000' />
				<input name='picture' type='file' />
				<p class='note'>max. 500 Kb 800x600 pixel jpg picture</p>
				<br />
					
				<label for='region' class="required">Region</label>
				<select name='region'>  
					<?php
						if( count( $regions ) < 1 ) print "<option value='0'>Create a Régió first!</option>";
						foreach ($regions as $region) {
							$selected = '';
							if(isset( $p_region ) ) {if( $p_region == $region['id'] ) $selected = "selected='selected'";}
							else if (User::is_logged_in() && User::get_prop( 'region' ) == $region['id']) $selected = "selected='selected'";
							print "<option value='" . $region['id'] . "' $selected>" . $region['name'] . "</option>";
							$sub_regions = $region['childs'];
							if (is_array ($sub_regions)) {
								foreach ($sub_regions as $sub_region) {
									$selected = '';
									if( isset( $p_region ) ) {if( $p_region == $sub_region['id']) $selected = "selected='selected'";}
									else if (User::is_logged_in() && User::get_prop( 'regio') == $sub_region['id']) $selected = "selected='selected'";										
									print "<option value='" . $sub_region['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
								}
							}
						}
					?>                 
				</select>
				<br />
					
				<label for='category' class="required">Category</label>
				<select name='category'>  
					<?php
						if (count($categories) < 1) print "<option value='0'>Create a category first!</option>";
						foreach ($categories as $category) {
							$selected = '';
							if (isset( $p_category)) {if ($p_category == $category['id']) $selected = "selected='selected'";}
							else if (User::is_logged_in() && User::get_prop( 'category' ) == $category['id']) $selected = "selected='selected'";
							print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
							$sub_categories = $category['childs'];
							if (is_array ($sub_categories)) {
								foreach ($sub_categories as $sub_category) {
									$selected = '';
									if (isset( $p_category)) {if ($p_category == $sub_category['id']) $selected = "selected='selected'";}
									else if (User::is_logged_in() && User::get_prop( 'category') == $sub_category['id']) $selected = "selected='selected'";
									print "<option value='" . $sub_category['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
								}
							}
						}
					?>                 
				</select>
				<br />
					
				<label for='city'>City</label>
				<input name='city' type='text' value='<?php if(isset( $p_city ) ) print $p_city; else if (User::is_logged_in()) print User::get_prop('city'); ?>' />
				<br />
									
				<label for='description' class="required">Description</label>
				<textarea rows="10" cols="56" id='description' name='description' cols='39' rows='14' onKeyDown="textCounter('description',500,'description-counter')" onKeyUp="textCounter('description',500,'description-counter')"><?php if( isset( $p_description ) ) print $p_description; ?></textarea>
				<div class="note">The description can be <input id="description-counter" type="text" value="500" /> charaters more.</div>
				<script>textCounter('description',500,'description-counter')</script>
				<br />
							
				<label for='price'>Price</label>
				<input name='price' type='text' value='<?php if (isset($p_price)) print $p_price; ?>' />
				<br />
					
				<label for='webpage'>Webpage</label>
				<input name='webpage' type='text' value='<?php if (isset( $p_webpage)) print $p_webpage; ?>' />
				<br />
																
				<label for="ad_edit"></label>
				<input type="submit" name="ad_edit" value="Modify"/>	
			
			<?php } ?>		
														
		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
