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
					<label for="register">&nbsp;</label>
					<input name="register" type="submit" value="Register"/>						
				</div>					
			</div>

		</form>         			

	</fieldset>
			
</div>
