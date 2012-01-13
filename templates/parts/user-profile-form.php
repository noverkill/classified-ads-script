<div class="form-panel">

	<fieldset>
		
		<legend>User profile</legend>
		
		<form name="form_user_profile" id="form_user_profile" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

			<div class="fleft">
				<div class="input-block">
					<label for='email' class='required'>Email</label>
					<input name='email' type='text' disabled='disabled' value="<?=User::get_email()?>" />
					<br />
				</div>
				<div class="input-block">
					<label for='username'>Username</label>
					<input name='username' type='text' disabled='disabled'  value="<?=User::get_username()?>" />
				</div>
				<div class="input-block">
					<label for='name'>Name</label>
					<input name='name' type='text' value="<?=isset($p_name)? $p_name : User::get_name()?>" />
				</div>
			</div>
			
			<br />
			
			<div class="fleft">					
				<div class="input-block">							
					<label for='telephone'>Telephone</label>
					<input name='telephone' type='text' value="<?=isset($p_telephone)? $p_telephone : User::get_prop('telephone')?>" />
				</div>
				<div class="input-block">							
					<label for='city'>City</label>
					<input name='city' type='text' value="<?=isset($p_city)? $p_city : User::get_prop('city')?>" />
				</div>	
				<div class="input-block">
					<label for='webpage'>Webpage</label>
					<input name='webpage' type='text' value="<?=isset($p_webpage)? $p_webpage : User::get_prop('webpage')?>" />
				</div>					
			</div>				

			<br />

			<div class="fleft">
				<div class="input-block">
					<label for='regio'>Region</label> 
					<?include('./templates/parts/region-selector.php')?>                 
				</div>					
				<div class="input-block">
					<label for='category'>Frequently used category</label>
					<?include('./templates/parts/category-selector.php')?>  
				</div>					
			</div>							
			
			<br />
			<br />
			
			<div style="width:100%;text-align:center;">
				<input name="modify" type="submit" value="Modify"/>		
				&nbsp; &nbsp; 
				<input name="reset" type="submit" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /> 			
			</div>											

		</form>					          			

	</fieldset>
			
</div>
