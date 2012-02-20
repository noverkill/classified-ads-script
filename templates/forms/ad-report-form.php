<div class="form-panel">

	<fieldset>
		
		<legend>Report abuse</legend>	
		
		<form name="form_report_ad" id="form_report_ad" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">
			
			<div class="fleft">
				<div class="input-block">				
					<label for='id' class="required">Ad id</label>
					<input name="id" type="text" readonly="readonly" value="<?=$ad['id']?>" />
				</div>				
			</div>

			<br />
					
			<div class="fleft">
				<div class="input-block">				
					<label for='message' class="required">Your message</label>
					<textarea rows="10" cols="56" id='message' name='message' onKeyDown="textCounter('message',200,'message-counter')" onKeyUp="textCounter('message',200,'message-counter')"><?if(isset($p_message)&& ! $success) print $p_message?></textarea>
					<div class="note">The message can be <input id="message-counter" type="text" value="200" /> characters more.</span></div>
					<script>textCounter('message',200,'message-counter')</script>
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
