<?php 

include ("page-top.php"); 

$panels = array( array(
	'legend'   => 'Ad modification',
	'body'    => ''
) );

	
if( ! $exists ) {
	
	$panel = array (
		'legend' => 'Error',
		'body'    => "<ul class='errors'>The requested Ad is not exist or inactive!</ul>",
		'height'  => 20
	);
	
	array_unshift( $panels, $panel );
		
} else {

	if( isset( $_POST['modify'] ) ) {
		
		if( $success ) {
			
			$panel = array( array(
				'legend' => 'Information',
				'body'    => "<p class='success'>Your ad has been succesfuly modified!<br /><a href='javascript:history.back()'>Back</a> &nbsp; | &nbsp; <a href='ad-list.php?sorszam=$g_id'>See Ad</a></p>"
			) );
					
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
}

$expiries = Expiry::get_all();

?>
							
<div id="middle">

<?php foreach( $panels as $panel) { ?>
	
	<div class="form-panel">

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
													
			<?php if ($panel['body'] != '') print $panel['body']; else { ?>
								
				<form name="form_ad_modification" id="form_ad_modification" method="post" enctype='multipart/form-data' accept-charset="utf-8">										

					<div class="fleft">
						<div class="input-block">
							<label for='current-picture'>Current picture</label>
							<a class='current-picture' href="<?php print $ad['picture']; ?>">
								<img src="<?php print $ad['thumb']; ?>" />
							</a>
						</div>
						<div class="input-block" id="del-current-pic">						
							<label for='del_picture'>&nbsp;</label>
							<input name='del_picture' type='checkbox' <?php if ( $p_del_picture > 0 ) print 'checked="checked"'; ?> />
							<span>Delete picture</span>
						</div>
					</div>
					
					<br />

					<div class="fleft">
						<div class="input-block">																							
							<label for='name' class="required">Name</label>
							<input name='name' type='text' value='<?php if( isset( $p_name ) ) print $p_name; ?>' />
						</div>
						<div class="input-block">						
							<label for='email' class="required">Email</label>
							<input name='email' type='text' disabled='disabled' value='<?php print $ad['email']; ?>' />
						</div>
						<div class="input-block">						
							<label for='telephone'>Telephone</label>
							<input name='telephone' type='text' value='<?php if( isset( $p_telephone ) ) print $p_telephone; ?>' />
						</div>
					</div>

					<br />

					<div class="fleft">
						<div class="input-block">
							<label for='title' class="required">Title</label>
							<input name='title' id='title' type='text' <?php if( isset( $p_title ) ) print "value='$p_title'"; ?> onKeyDown="textCounter('title',60,'title-counter')" onKeyUp="textCounter('title',60,'title-counter')" />
							<div class="note">The title can be <input id="title-counter" type="text" value="60" /> charaters more.</div>
							<script>textCounter('title',60,'title-counter')</script>
						</div>
						<div class="input-block">
							<label for='expiry' class="required">Expiry</label>
							<input name='expiry' disabled="disabled" value="<?php print $p_expiry; ?>" /> 
							<a href='ad-extension.php?<?php print 'id=' . $g_id . '&code=' . $g_code; ?>'>Extend &gt; &gt;</a> 
						</div>						
						<div class="input-block">								
							<label for='picture'>New picture</label>
							<input name='MAX_FILE_SIZE' type='hidden' value='512000' />
							<input name='picture' type='file' />
							<div class='note'>max. 500 Kb 800x600 pixel jpg picture</div>
						</div>
					</div>
					<div class="fleft">
						<div class="input-block">
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
						</div>
						<div class="input-block">
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
						</div>														
						<div class="input-block">
							<label for='city'>City</label>
							<input name='city' type='text' value='<?php if(isset( $p_city ) ) print $p_city; else if (User::is_logged_in()) print User::get_prop('city'); ?>' />
						</div>					
					</div>

					<br />
																						
					<div class="fleft">
						<div class="input-block">								
							<label for='description' class="required">Description</label>
							<textarea rows="10" cols="56" id='description' name='description' cols='39' rows='14' onKeyDown="textCounter('description',500,'description-counter')" onKeyUp="textCounter('description',500,'description-counter')"><?php if( isset( $p_description ) ) print $p_description; ?></textarea>
							<div class="note">The description can be <input id="description-counter" type="text" value="500" /> charaters more.</div>
							<script>textCounter('description',500,'description-counter')</script>
						</div>
						<div class="input-block">						
							<label for='price'>Price</label>
							<input name='price' type='text' value='<?php if (isset($p_price)) print $p_price; ?>' />
						</div>	
						<div class="input-block">
							<label for='webpage'>Webpage</label>
							<input name='webpage' type='text' value='<?php if (isset( $p_webpage)) print $p_webpage; ?>' />
						</div>
					</div>
															
					<div style="width:100%;text-align:center;">
						<input name="modify" type="submit" value="Modify"/>				
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
