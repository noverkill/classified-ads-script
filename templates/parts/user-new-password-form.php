<div class="form-panel">

	<fieldset>
		
		<legend>New password</legend>
													
		<form name="form_new_password" id="form_new_password" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

			<div class="input-set">
				<div class="input-block">
					<label for='old_password' class='required'>Current password</label>
					<input name='old_password' type='password' value="<?=isset($p_old_password)? $p_old_password : ''?>" />
				</div>
			</div>
			
			<br />

			<div class="input-set">
				<div class="input-block">
					<label for='new_password' class='required'>New password</label>
					<input name='new_password' type='password' value="<?=isset($p_new_password)? $p_new_password : ''?>" />
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

	</fieldset>
			
</div>
