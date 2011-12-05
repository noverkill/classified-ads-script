<?php 

include ("page-top.php");  

$panels = array( array(
	'legend' => 'Post an Ad',
	'body'    => ''
));

if( isset( $_POST['post'] ) ) {

    if ($success) {

		if( User::is_logged_in() ) {
			
			$panels = array( array(
				'legend' => 'Information',
				'body'    => "<p class='success'>Your ad has been placed successfuly!<br /><a href='ad-list.php?id=$last'>See Ad</a></p>",
			));		
		} else {
						
			$panels = array( array(
				'legend' => 'Information',
				'body'    => "<p class='success'>Your ad has been placed successfuly! (Id: " . $last . ")<br />We have sent an email with the details of how you can activate your Ad.</p>",
			));		
		}		
    } else {
		
		$body    = "<ul class='errors'>";
		foreach ($errors as $err) $body .= "<li>$err</li>";
		$body   .= "</ul>";
		
		$error_panel = array (
			'legend' => 'Please correct the following errors',
			'body'    => $body
		);
		
		array_unshift( $panels, $error_panel);		
	}
			
}

$expiries = Expiry::get_all();

?>
							
<div id="middle">

<?php foreach( $panels as $panel) { ?>
	
	<div class="form-panel">

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
								
			<?php if( $panel['body'] != '' ) print $panel['body']; else { ?>
			
				<form name="form_ad_placement" id="form_ad_placement" method="post" enctype='multipart/form-data' accept-charset="utf-8">
						
					<div class="fleft">

						<div class="input-block">
							<label for='name' class="required">Name</label>
							<input name='name' type='text' value='<?php if( isset( $p_name ) ) print $p_name; else if( User::is_logged_in() ) print User::get_name(); ?>' />
						</div>
						
						<div class="input-block">
							<label for='email' class="required">Email</label>
							<input name='email' type='text' value='<?php if( isset( $p_email ) ) print $p_email; else if( User::is_logged_in() ) print User::get_email(); ?>' />
						</div>

						<div class="input-block">
							<label for='telephone'>Telephone</label>
							<input name='telephone' type='text' value='<?php if( isset( $p_telephone ) ) print $p_telephone; else if( User::is_logged_in() ) print User::get_prop( 'telephone' ); ?>' />
						</div>
											
					</div>				

					<br />

					<div class="fleft">
						
						<div class="input-block">
							<label for='title' class="required">Title</label>
							<input name='title' id='title' type='text' <?php if( isset( $p_title ) && ! $success) print "value='$p_title'"; ?> onKeyDown="textCounter('title',60,'title-counter')" onKeyUp="textCounter('title',60,'title-counter')" />
							<div class="note">The title can be <input id="title-counter" type="text" value="60" /> characters more.</span></div>
							<script>textCounter('title',60,'title-counter')</script>
						</div>

						<div class="input-block">
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
						</div>
					
						<div class="input-block">
							<input name='MAX_FILE_SIZE' type='hidden' value='512000' />				
							<label for='picture'>Picture</label>
							<input name='picture' type='file' />
							<div class='note'>max. 500 Kb 800x600 pixel jpg picture</div>
						</div>
														
					</div>				

					<br />

					<div class="fleft">

						<div class="input-block">
							<label for='region' class="required">Region</label>
							<select name='region'>  
								<?php
									if( count( $regions ) < 1 ) print "<option value='0'>Create Regions first!</option>";
									foreach ($regions as $regio) {
										$selected = '';
										if (isset( $p_regio)) {if ($p_regio == $regio['id']) $selected = "selected='selected'";}
										else if (User::is_logged_in() && User::get_prop( 'region') == $regio['id']) $selected = "selected='selected'";
										print "<option value='" . $regio['id'] . "' $selected>" . $regio['name'] . "</option>";
										$sub_regions = $regio['childs'];
										if (is_array ($sub_regions)) {
											foreach ($sub_regions as $sub_region) {
												$selected = '';
												if (isset( $p_regio)) {if ($p_regio == $sub_region['id']) $selected = "selected='selected'";}
												else if (User::is_logged_in() && User::get_prop( 'region') == $sub_region['id']) $selected = "selected='selected'";										
												print "<option value='" . $sub_region['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
											}
										}
									}
								?>                 
							</select>
						</div>
						
						<div class="input-block">
							<label for='category' class="required">Category</label>
							<select name='category'>  
								<?php
									if (count($categories) < 1) print "<option value='0'>Create a category first!</option>";
									foreach ($categories as $category) {
										$selected = '';
										if (isset( $p_category)) {if ($p_category == $category['id']) $selected = "selected='selected'";}
										else if (User::is_logged_in() && User::get_prop( 'category') == $category['id']) $selected = "selected='selected'";
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
						</div>														
						<div class="input-block">
							<label for='city'>City</label>
							<input name='city' type='text' value='<?php if( isset( $p_city ) ) print $p_city; else if( User::is_logged_in() ) print User::get_prop( 'city' ); ?>' />
						</div>					
					</div>				

					<br />

					<div class="fleft">
						<div class="input-block">				
							<label for='description' class="required">Description</label>
							<textarea rows="10" cols="56" id='description' name='description' onKeyDown="textCounter('description',500,'description-counter')" onKeyUp="textCounter('description',500,'description-counter')"><?php if( isset( $p_description ) && ! $success) print $p_description; ?></textarea>
							<div class="note">The Description can be <input id="description-counter" type="text" value="500" /> characters more.</span></div>
							<script>textCounter('description',500,'description-counter')</script>
						</div>
						<div class="input-block">
							<label for='price'>Price</label>
							<input name='price' type='text' <?php if( isset( $p_price ) && ! $success) print "value='$p_price'"; ?> />
						</div>
						<div class="input-block">
							<label for='webpage'>Webpage</label>
							<input name='webpage' type='text' value='<?php if( isset( $p_webpage ) ) print $p_webpage; else if( User::is_logged_in() ) print User::get_prop( 'weblap' ); ?>' />
						</div>
						<div class="input-block">
							<label for='terms'>&nbsp;</label>
							<input name='terms' type='checkbox' <?php if( ! isset( $p_terms ) || ( $p_terms > 0 && ! $success ) ) print 'checked="checked"'; ?> />
							<span><a href="#" onclick="return(makePopup(this,'<?php print $site_url; ?>/terms-of-use.php'))">I agree with the Terms &amp; Conditions</a></span>
						</div>	
					</div>
								
					<div style="width:100%;text-align:center;">
						<input name="post" type="submit" value="Post"/>				
					</div>									
				</form>					
		
			<?php } ?>           			

			</fieldset>
				
	</div>

	<br />
	<br />

<?php } ?>

<br />

</div>

<?php include ("page-right.php"); ?>

<?php include ("page-footer.php"); ?>
