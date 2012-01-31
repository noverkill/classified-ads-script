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
	
if (isset($_POST['ad_create'])) {

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
        
    $success = true;
    $errors = array();
    
    if( $p_name == '' ) {
        $success = false;
        array_push( $errors, "Please enter your name." );
    }
 
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
		
		$picture_path = "$postedon_year/$postedon_month/$postedon_day/picture";
		$thumb_path   = "$upload_path/$postedon_year/$postedon_month/$postedon_day/thumb";	
		
		include( "upload_picture.php" );
		
	} else {
		
		$p_picture = '';
	} 

    if( $success ) {

		$expiry = date( "Y-m-d H:i:s", time () + $p_expiry * 24 * 60 * 60 );   
		$code   = md5( uniqid( rand(), true ) ); 
			
		$last = Ad::create( array( 
					'name' => $p_name, 'email' => $p_email, 'telephone' => $p_telephone, 'title' => $p_title, 
		            'description' => $p_description, 'picture' => $p_picture, 'category' => $p_category, 'price' => $p_price, 
		            'city' => $p_city, 'region' => $p_region, 'expiry' => $expiry, 'webpage' => $p_webpage, 'code' => $code 
		        ) );

		Ad::activate( $last );
	
	}		
}

$expiries = Expiry::get_all();

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_ad_create" id="form_ad_create" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_sub_page['name'].' '.$current_group_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>" . $current_group_page['name'] . "  created succesfuly.<span class='note'>( id: <a href='ad-edit.php?id=$last' target='_blank'>$last</a> )</span></p>";
			}
			?>

			<label for='name' class="required">Name</label>
			<input name='name' type='text' value='<?php if( isset( $p_name ) && ! $success ) print $p_name; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='email' class="required">Email</label>
			<input name='email' type='text' value='<?php if( isset( $p_email ) && ! $success ) print $p_email; ?>' />
			<p class='note'>Required</p>
			<br />
			
			<label for='telephone'>Telephone</label>
			<input name='telephone' type='text' value='<?php if( isset( $p_telephone ) && ! $success ) print $p_telephone; ?>' />
			<p class='note'></p>
			<br />
			
			<label for='title' class="required">Title</label>
			<input name='title' id='title' type='text' <?php if( isset( $p_title ) && ! $success) print "value='$p_title'"; ?> onKeyDown="textCounter('title',60,'title-counter')" onKeyUp="textCounter('title',60,'title-counter')" />
			<!--div class="note">The title can be <input id="title-counter" type="text" value="60" /> characters more.</span></div>
			<script>textCounter('title',60,'title-counter')</script-->
			<p class='note'>Required</p>
			<br />
			
			<label for='expiry' class="required">Expiry</label>
			<select name='expiry'>  
				<?php
					if( count( $expiries ) < 1 ) print "<option value='0'>Create Expiries first!</option>";
					else {
						foreach( $expiries as $expiry )	
							print "<option value='" . $expiry['period'] . "'>" . $expiry['name'] . "</option>";
					}
				?>                 
			</select>
			<p class='note'>Required</p>
			<br />
			
			<input name='MAX_FILE_SIZE' type='hidden' value='512000' />				
			<label for='picture'>Picture</label>
			<input name='picture' type='file' />
			<p class='note'>max. 500 Kb 800x600 pixel jpg picture</p>
			<br />
			
			<label for='region' class="required">Region</label>
			<select name='region'>  
				<?php
					if( count( $regions ) < 1 ) print "<option value='0'>Create Regions first!</option>";
					foreach ($regions as $regio) {
						$selected = '';
						if (isset( $p_regio) && ! $success) {if ($p_regio == $regio['id']) $selected = "selected='selected'";}
						print "<option value='" . $regio['id'] . "' $selected>" . $regio['name'] . "</option>";
						$sub_regions = $regio['childs'];
						if (is_array ($sub_regions)) {
							foreach ($sub_regions as $sub_region) {
								$selected = '';
								if (isset( $p_regio) && ! $success) {if ($p_regio == $sub_region['id']) $selected = "selected='selected'";}
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
						if (isset( $p_category) && ! $success) {if ($p_category == $category['id']) $selected = "selected='selected'";}
						print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
						$sub_categories = $category['childs'];
						if (is_array ($sub_categories)) {
							foreach ($sub_categories as $sub_category) {
								$selected = '';
								if (isset( $p_category) && ! $success) {if ($p_category == $sub_category['id']) $selected = "selected='selected'";}
								print "<option value='" . $sub_category['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
							}
						}
					}
				?>                 
			</select>
			<p class='note'>Required</p>
			<br />
			
			<label for='city'>City</label>
			<input name='city' type='text' value='<?php if( isset( $p_city ) && ! $success ) print $p_city; ?>' />
			<p class='note'></p>
			<br />
			
			<label for='description' class="required">Description</label>
			<textarea rows="10" cols="56" id='description' name='description' onKeyDown="textCounter('description',500,'description-counter')" onKeyUp="textCounter('description',500,'description-counter')">
				<?php if( isset( $p_description ) && ! $success) print $p_description; ?>
			</textarea>
			<!--div class="note">The Description can be <input id="description-counter" type="text" value="500" /> characters more.</span></div>
			<script>textCounter('description',500,'description-counter')</script-->
			<p class='note'>Required</p>
			<br />
			
			<label for='price'>Price</label>
			<input name='price' type='text' <?php if( isset( $p_price ) && ! $success) print "value='$p_price'"; ?> />
			<p class='note'></p>
			<br />
			
			<label for='webpage'>Webpage</label>
			<input name='webpage' type='text' value='<?php if( isset( $p_webpage ) && ! $success ) print User::get_prop( 'weblap' ); ?>' />
			<p class='note'></p>
			<br />
					
			<label for="ad_create"></label>
			<input type="submit" name="ad_create" value="Create"/>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
