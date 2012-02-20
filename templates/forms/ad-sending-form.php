<div class="form-panel">

	<fieldset>
		
		<legend>Ad sending by email</legend>	
		
		<form name="form_ad_sending" id="form_ad_sending" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

			<input name="id" type="hidden" value="<?=$r_id?>" />

			<div class="fleft">
				<div class="input-block">							
					<label for='sender_email' class="required">Your email</label>
					<input name='sender_email' type='text' value="<?if(isset($p_sender_email)) print $p_sender_email?>" />
				</div>
				<div class="input-block">													
					<label for='sender_name'>Your name</label>
					<input name='sender_name' type='text' value="<?if(isset($p_sender_name)) print $p_sender_name?>" />
				</div>						
			</div>
			
			<br />

			<div class="fleft">					
				<div class="input-block">							
					<label for='recipient_email' class="required">Recipient email</label>
					<input name='recipient_email' type='text' value="<?if(isset($p_recipient_email)) print $p_recipient_email?>" />
				</div>	
				<div class="input-block">							
					<label for='recipient_name'>Recipient name</label>
					<input name='recipient_name' type='text' value="<?if(isset($p_recipient_name)) print $p_recipient_name?>" />
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

	</fieldset>
			
</div>
