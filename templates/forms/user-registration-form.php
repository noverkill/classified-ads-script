<div class="form-panel">

	<fieldset>
		
		<legend>Registration</legend>			
			
		<form name="form_user_registration" id="form_user_registration" method="post" enctype='multipart/form-data' accept-charset="utf-8">
																				
			<div class="fleft">
				<div class="input-block">					
					<label for='email' class="required">Email</label>
					<input name='email' type='text' <?if(isset($p_email)&& !$success) print "value='$p_email'"?> />					
				</div>					
			</div>

			<br />
																				
			<div class="fleft">
				<div class="input-block">					
					<label for='username' class="required">Username</label>
					<input name='username' type='text' <?if(isset($p_username)&& !$success) print "value='$p_username'"?> />					
				</div>					
			</div>

			<br />
																				
			<div class="fleft">
				<div class="input-block">					
					<label for='password' class="required">Password</label>
					<input name='password' type='password' <?if(isset($p_password)&& !$success) print "value='$p_password'"?> />					
				</div>					
			</div>
			
			<br />

			<div class="fleft">
				<div class="input-block">
					<label for='newsletter'>&nbsp;</label>
					<span><a href="#">You'll receive our email newsletters and account updates.</a></span>
				</div>	
			</div>	
			
			<br />

			<div class="fleft">
				<div class="input-block">
					<label for='terms'>&nbsp;</label>
					<input name='terms' type='checkbox' <?if(! isset($p_terms)||($p_terms > 0 && ! $success)) print 'checked="checked"'?> />
					<span><a href="#" onclick="return(makePopup(this,'<?=$site_url?>/terms-of-use.php'))">I agree with the Terms &amp; Conditions</a></span>
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

	</fieldset>
			
</div>
