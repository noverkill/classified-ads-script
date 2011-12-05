<?php include ("page-top.php"); ?>
							
<div id="middle">

<?php

if( ! $ad_exists ) {
	
	$panels = array( array(
		'legend' => 'Error',
		'body'    => "<ul class='errors'>The requested Ad is not exist or inactive!</ul>"
	));
		
} else {
	
	$panels = array( array( 
		'legend' => 'Ad extension',
		'body'    => '',
	));
	
	if( isset( $_POST['extension'] ) ) {
		
		if( ! $success ) {

			$body  = "<ul class='errors'>";
			foreach( $errors as $err ) $body .= "<li>$err</li>";
			$body  .= "</ul>";

			$error_panel = array (
				'legend' => 'Please correct the following errors',
				'body'    => $body
			);

			array_unshift( $panels, $error_panel );
			
		} else {
			
			$panels = array( array(
				'legend' => 'Information',
				'body'   => "<p class='success'>Your ad's expiry has been succesfuly extended!<br /><a href='javascript:history.back()'>Back</a> &nbsp; | &nbsp; <a href='ad-list.php?sorszam=$g_id'>See Ad</a></p>"
			));
		}
	}
}

$expiries = Expiry::get_all(); 

foreach( $panels as $panel ) { 
	
?>
	
	<div class="form-panel">		

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
								
			<?php if ($panel['body'] != '') print $panel['body']; else { ?>
					
					<form name="form_ad_extension" id="form_ad_extension" method="post" enctype='multipart/form-data' accept-charset="utf-8">										

						<div class="fleft">
							<div class="input-block">						
								<label for='id' class="required">Id</label>
								<input name='id' type='text' disabled='disabled' value='<?php print $g_id; ?>' />
							</div>
							<div class="input-block">								
								<label for='expiry'>Expiry</label>
								<input name='expiry' type='text' disabled='disabled' value='<?php print $ad['expiry']; ?>' />
							</div>
						</div>	
						
						<br />
							
						<div class="fleft">
							<div class="input-block">								
								<label for='extension' class="required">Extension</label>
								<select name='extension'>  
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
								<label for='see-the-ad'>&nbsp;</label>
								<span class='note'><a href='ad-list.php?id=<?php print $g_id; ?>' target='_blank'>See the Ad &gt;&gt;</a></span>
							</div>
						</div>
						
						<br />

						<div class="fleft">
							<div class="input-block">
								<input name="extend" type="submit" value="Extend"/>				
							</div>
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
