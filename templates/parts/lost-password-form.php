<div class="form-panel">

	<fieldset>
		
		<legend>Lost password</legend>
							
		<form name="form_lost_password" id="form_lost_password" method="post" enctype='multipart/form-data' accept-charset="utf-8">										

			<div class="fleft">
				<div class="input-block">						
					<label for='email' class="required">Your email</label>
					<input name='email' type='text' <?if(isset($p_email)&& !$success) print "value='$p_email'"?> />
				</div>
			</div>
			
			<br />				

			<div class="fleft">
				<div class="input-block">
					<input name="send" type="submit" value="Send"/>				
				</div>
			</div>
			
		</form>	           			

	</fieldset>
			
</div>
