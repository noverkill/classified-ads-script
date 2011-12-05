<?php 

include( "page-top.php" ); 

$panels = array( array(
	'legend' => 'Ad sending by email',
	'body'   => ''
) );

if( ! $exists ) {

	$panels = array( array(
		'legend' => 'Error',
		'body'    => "<ul class='errors'>The requested Ad is not exist or inactive!</ul>"
	) );
}

if( isset( $success ) ) {
	
	if( $success ) {

		$panels = array( array(
			'legend' => 'Information',
			'body'    => "<p class='success'>Your ad's  has been succesfuly sent!<br /><a href='javascript:history.back()'>Back</a> &nbsp; | &nbsp; <a href='ad-list.php?id=$r_id'>See Ad</a></p>"
		) );
				
	} else {

		$body    = "<ul class='errors'>";
		foreach ($errors as $err) $body .= "<li>$err</li>";
		$body   .= "</ul>";
		
		$panel = array(
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
				
					<form name="form_ad_sending" id="form_ad_sending" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

						<input name="id" type="hidden" value="<?php print $r_id; ?>" />

						<div class="fleft">
							<div class="input-block">							
								<label for='sender_email' class="required">Your email</label>
								<input name='sender_email' type='text' value="<?php if (isset( $p_sender_email)) print $p_sender_email; ?>" />
							</div>
							<div class="input-block">													
								<label for='sender_name'>Your name</label>
								<input name='sender_name' type='text' value="<?php if (isset( $p_sender_name)) print $p_sender_name; ?>" />
							</div>						
						</div>
						
						<br />

						<div class="fleft">					
							<div class="input-block">							
								<label for='recipient_email' class="required">Recipient email</label>
								<input name='recipient_email' type='text' value="<?php if (isset( $p_recipient_email)) print $p_recipient_email; ?>" />
							</div>	
							<div class="input-block">							
								<label for='recipient_name'>Recipient name</label>
								<input name='recipient_name' type='text' value="<?php if (isset( $p_recipient_name)) print $p_recipient_name; ?>" />
							</div>											
						</div>

						<br />
						
						<div class="fleft">												
							<div class="input-block">												
								<label for="send">&nbsp;</label>
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
