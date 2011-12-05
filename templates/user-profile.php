<?php 

include( "page-top.php" ); 

$panels = array( array(
	'legend' => 'User profile',
	'body'    => ''
) );

if( isset( $_POST['modify'] ) ) {
	
	if ( $success ) {

		$panels = array( array(
			'legend' => 'Information',
			'body'    => "<p class='success'>Your profile data has been succesfuly updated!</p>",
		) );
	} else {
		
		$body    = "<ul class='errors'>";
		foreach ($errors as $err) $body .= "<li>$err</li>";
		$body   .= "</ul>";
		
		$panel = array (
			'legend' => 'Please correct the following errors',
			'body'    => $body
		);
		
		array_unshift( $panels, $panel );
	}
}
		
?>
							
<div id="middle">

<?php foreach( $panels as $panel) { ?>
	
	<div class="form-panel">

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
								
			<?php if ($panel['body'] != '') print $panel['body']; else { ?>
			
				<form name="form_user_profile" id="form_user_profile" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

					<div class="fleft">
						<div class="input-block">
							<label for='email' class='required'>Email</label>
							<input name='email' type='text' disabled='disabled' value="<?php print User::get_email(); ?>" />
							<br />
						</div>
						<div class="input-block">
							<label for='username'>Username</label>
							<input name='username' type='text' disabled='disabled'  value="<?php print User::get_username(); ?>" />
						</div>
						<div class="input-block">
							<label for='name'>Name</label>
							<input name='name' type='text' value="<?php print isset( $p_name ) ? $p_name : User::get_name(); ?>" />
						</div>
					</div>
					
					<br />
					
					<div class="fleft">					
						<div class="input-block">							
							<label for='telephone'>Telephone</label>
							<input name='telephone' type='text' value="<?php print isset( $p_telephone ) ? $p_telephone : User::get_prop( 'telephone' ); ?>" />
						</div>
						<div class="input-block">							
							<label for='city'>City</label>
							<input name='city' type='text' value="<?php print isset( $p_city ) ? $p_city : User::get_prop( 'city' ); ?>" />
						</div>	
						<div class="input-block">
							<label for='webpage'>Webpage</label>
							<input name='webpage' type='text' value="<?php print isset( $p_webpage ) ? $p_webpage : User::get_prop( 'webpage' ); ?>" />
						</div>					
					</div>				

					<br />

					<div class="fleft">
						<div class="input-block">
							<label for='regio'>Region</label>
							<select name='region'>  
								<?php
									if( count( $regions ) < 1 ) print "<option value='0'>Create Regions first!</option>";
									foreach ($regions as $region) {
										$selected = '';
										if( isset( $p_regionn ) ) { if( $p_region == $region['id'] ) $selected = "selected='selected'"; } 
										else { if( User::get_prop( 'region' ) == $region['id'] ) $selected = "selected='selected'"; }
										print "<option value='" . $region['id'] . "' $selected>" . $region['name'] . "</option>";
										$sub_regions = $region['childs'];
										if (is_array ($sub_regions)) {
											foreach ($sub_regions as $sub_region) {
												$selected = '';
												if( isset( $p_region ) ) { if( $p_region == $sub_region['id'] ) $selected = "selected='selected'"; } 
												else { if( User::get_prop( 'region' ) == $sub_region['id'] ) $selected = "selected='selected'"; }
												print "<option value='" . $sub_region['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
											}
										}
									}
								?>                 
							</select>
						</div>					
						<div class="input-block">
							<label for='category'>Frequently used category</label>
							<select name='category'>  
								<?php
									if( count( $categories ) < 1 ) print "<option value='0'>Create categories first!</option>";
									foreach( $categories as $category ) {
										$selected = '';
										if( isset( $p_category ) ) { if( $p_category == $category['id'] ) $selected = "selected='selected'"; } 
										else { if( User::get_prop( 'category' ) == $category['id'] ) $selected = "selected='selected'"; }
										print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
										$sub_categories = $category['childs'];
										if( is_array( $sub_categories ) ) {
											foreach( $sub_categories as $sub_category ) {
												$selected = '';
												if( isset( $p_category ) ) { if( $p_category == $sub_category['id'] ) $selected = "selected='selected'"; } 
												else { if( User::get_prop( 'category' ) == $sub_category['id'] ) $selected = "selected='selected'"; }
												print "<option value='" . $sub_category['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
											}
										}
									}
								?>                 
							</select>
						</div>					
					</div>							
					
					<br />
					<br />
					
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
