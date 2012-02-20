<div class="form-panel">

	<fieldset>
		
		<legend>Rate this ad</legend>	
		
		<form name="form_rate_to_ad" id="form_rate_to_ad" method="post" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">

			<input name="id" type="hidden" value="<?=$ad['id']?>" />

			<div class="fleft">
				<div class="input-block">				
					<label for='rate' class="required">Your rate</label>
					<input name='rate' type='radio' value="1" <?if(isset($p_rate)&& $p_rate==1 && ! $success) print "checked='checked'"?> />1
					<input name='rate' type='radio' value="2" <?if(isset($p_rate)&& $p_rate==2 && ! $success) print "checked='checked'"?> />2
					<input name='rate' type='radio' value="3" <?if(isset($p_rate)&& $p_rate==3 && ! $success) print "checked='checked'"?> />3
					<input name='rate' type='radio' value="4" <?if(isset($p_rate)&& $p_rate==4 && ! $success) print "checked='checked'"?> />4
					<input name='rate' type='radio' value="5" <?if(isset($p_rate)&& $p_rate==5 && ! $success) print "checked='checked'"?> />5
				</div>				
			</div>

			<div class="fleft">
				<div class="input-block">				
					<label for='message'>Your comment</label>
					<textarea rows="10" cols="56" id='comment' name='comment' onKeyDown="textCounter('comment',200,'comment-counter')" onKeyUp="textCounter('comment',200,'comment-counter')"><?if(isset($p_comment)&& ! $success) print $p_comment?></textarea>
					<div class="note">The comment can be <input id="comment-counter" type="text" value="200" /> characters more.</span></div>
					<script>textCounter('comment',200,'comment-counter')</script>
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
