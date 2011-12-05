<?php 

include( "page-top.php" );

$panels = array( array(
	'legend' => 'New password',
	'body'    => '',
) );

if( isset( $_POST['change'] ) ) {
	
	if( $success ) {
		
		$panels = array( array(
			'legend' => 'Information',
			'body'    => "<p class='success'>Your password has been succesfuly changed!</p>",
		) );
				
	} else {
	
		$body    = "<ul class='errors'>";
		foreach ($errors as $err) $body .= "<li>$err</li>";
		$body   .= "</ul>";

		$panel = array (
			'legend' => 'Please correct the following errors',
			'body'    => $body
		);

		array_unshift( $panels, $panel);
	}
}
		
?>
							
<div id="middle">

	<?php foreach( $panels as $panel) { ?>
		
		<div class="form-panel">

			<fieldset>
				
				<legend><?php print $panel['legend']; ?></legend>
									
				<?php if ($panel['body'] != '') print $panel['body']; else { ?>
						
					<form name="form_new_password" id="form_new_password" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

						<div class="input-set">
							<div class="input-block">
								<label for='old_password' class='required'>Current password</label>
								<input name='old_password' type='password' value="<?php print isset( $p_old_password ) ? $p_old_password : ''; ?>" />
							</div>
						</div>
						
						<br />

						<div class="input-set">
							<div class="input-block">
								<label for='new_password' class='required'>New password</label>
								<input name='new_password' type='password' value="<?php print isset( $p_new_password ) ? $p_new_password : ''; ?>" />
							</div>
						</div>
						
						<br />

						<div class="input-set">
							<div class="input-block">
								<label for='change'>&nbsp;</label>
								<input name="change" type="submit" value="Change"/>						
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
