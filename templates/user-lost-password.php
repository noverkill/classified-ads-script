<?php 

include ("page-top.php"); 

$panels = array( array(
	'legend' => 'Lost password',
	'body'    => ''
) );

if( isset( $_POST['send'] ) ) {
	                  
    if ($success) {

		$panels = array( array(
			'legend' => 'Information',
			'body'    => "<p class='success'>Your password has been sent to your email address.</p>"
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
									
					<form name="form_lost_password" id="form_lost_password" method="post" enctype='multipart/form-data' accept-charset="utf-8">										

						<div class="fleft">
							<div class="input-block">						
								<label for='email' class="required">Your email</label>
								<input name='email' type='text' <?php if (isset($p_email) && !$success) print "value='$p_email'"; ?> />
							</div>
						</div>
						
						<br />				

						<div class="fleft">
							<div class="input-block">
								<input name="send" type="submit" value="Send"/>				
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
