<div class="form-panel">

	<fieldset>
		
		<legend>Respond to this ad</legend>	
		
		<form name="form_respond_to_ad" id="form_respond_to_ad" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

			<input name="id" type="hidden" value="<?=$ad['id']?>" />

			<div class="fleft">
				<div class="input-block">				
					<label for='message' class="required">Your message</label>
					<textarea rows="10" cols="56" id='message' name='message' onKeyDown="textCounter('message',500,'message-counter')" onKeyUp="textCounter('message',500,'message-counter')"><?if(isset($p_message)&& ! $success) print $p_message?></textarea>
					<div class="note">The message can be <input id="message-counter" type="text" value="500" /> characters more.</span></div>
					<script>textCounter('message',500,'message-counter')</script>
				</div>				
			</div>

			<br />
			
			<div class="fleft">												
				<div class="input-block">												
					<label for="send">&nbsp;</label>
					<input name="send" type="submit" value="Send"/>				
				</div>
			</div>

			<br />
			
			<div class="fleft">												
				<div class="input-block">												
					<a href='ad.php?id=<?=$ad['id']?>'>Cancel</a>			
				</div>
			</div>
		
		</form>         			

	</fieldset>
			
</div>
