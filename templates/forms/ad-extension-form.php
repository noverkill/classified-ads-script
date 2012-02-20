<div class="form-panel">
	
	<fieldset>
		
		<legend>Ad extension</legend>
				
		<form name="form_ad_extension" id="form_ad_extension" method="post" enctype='multipart/form-data' accept-charset="utf-8">										

			<div class="fleft">
				<div class="input-block">						
					<label for='id' class="required">Id</label>
					<input name='id' type='text' disabled='disabled' value='<?=$g_id?>' />
				</div>
				<div class="input-block">								
					<label for='expiry'>Expiry</label>
					<input name='expiry' type='text' disabled='disabled' value='<?=$ad['expiry']?>' />
				</div>
			</div>	
			
			<br />
				
			<div class="fleft">
				<div class="input-block">								
					<label for='extension' class="required">Extension</label>
					<select name='extension'>  
						<?
							if(count($expiries)< 1): print "<option value='0'>Create Expiries first!</option>";
							else:
								foreach($expiries as $expiry)	
									print "<option value='" . $expiry['period'] . "'>" . $expiry['name'] . "</option>";
							endif;
						?>                 
					</select>
				</div>
				<div class="input-block">						
					<label for='see-the-ad'>&nbsp;</label>
					<span class='note'><a href='ad.php?id=<?=$g_id?>' target='_blank'>See the Ad &gt;&gt;</a></span>
				</div>
			</div>
			
			<br />

			<div class="fleft">
				<div class="input-block">
					<input name="extend" type="submit" value="Extend"/>				
				</div>
			</div>			

		</form>         			

	</fieldset>

</div>
