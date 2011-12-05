<?php 

include ("page-top.php"); 

$panels = array( array(
	'legend' => 'Registration',
	'body'    => ''
) );

if( isset( $_POST['register'] ) ) {
	                  
    if ($success) {

		$panels = array( array(
			'legend' => 'Information',
			'body'    => "<p class='success'>Your registration has been successful! <br />We have sent an email with the details of how you can activate your account.</p>",
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
} else {

	if( isset( $_GET['id'] ) && isset( $_GET['code'] ) ) {
		
		if ($success) {

			$panels = array( array(
				'legend' => 'Information',
				'body'    => "<p class='success'>Your account has been succesfuly activated!<br />Now you can log in to the system!</p>"
			) );
		} else {

			$panels = array ();
					
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
}

?>
								
<div id="middle">

<?php foreach( $panels as $panel) { ?>
	
	<div class="form-panel">

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
								
			<?php if ($panel['body'] != '') print $panel['body']; else { ?>			
				
				<form name="form_user_registration" id="form_user_registration" method="post" enctype='multipart/form-data' accept-charset="utf-8">
																						
					<div class="fleft">
						<div class="input-block">					
							<label for='email' class="required">Email</label>
							<input name='email' type='text' <?php if( isset( $p_email ) && ! $success ) print "value='$p_email'"; ?> />					
						</div>					
					</div>

					<br />
																						
					<div class="fleft">
						<div class="input-block">					
							<label for='username' class="required">Username</label>
							<input name='username' type='text' <?php if( isset( $p_username ) && ! $success ) print "value='$p_username'"; ?> />					
						</div>					
					</div>

					<br />
																						
					<div class="fleft">
						<div class="input-block">					
							<label for='password' class="required">Password</label>
							<input name='password' type='password' <?php if( isset( $p_password ) && ! $success ) print "value='$p_password'"; ?> />					
						</div>					
					</div>

					<br />
																						
					<div class="fleft">
						<div class="input-block">														
							<label for="register">&nbsp;</label>
							<input name="register" type="submit" value="Register"/>						
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
