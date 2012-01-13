<div class="form-panel">

	<fieldset>
		
		<legend>Post an Ad</legend>
		
		<form name="form_ad_placement" id="form_ad_placement" method="post" enctype='multipart/form-data' accept-charset="utf-8">
				
			<div class="fleft">

				<div class="input-block">
					<label for='name' class="required">Name</label>
					<input name='name' type='text' value='<?if(isset($p_name)) print $p_name; else if(User::is_logged_in()) print User::get_name()?>' />
				</div>
				
				<div class="input-block">
					<label for='email' class="required">Email</label>
					<input name='email' type='text' value='<?if(isset($p_email)) print $p_email; else if(User::is_logged_in()) print User::get_email()?>' />
				</div>

				<div class="input-block">
					<label for='telephone'>Telephone</label>
					<input name='telephone' type='text' value='<?if(isset($p_telephone)) print $p_telephone; else if(User::is_logged_in()) print User::get_prop('telephone')?>' />
				</div>
									
			</div>				

			<br />

			<div class="fleft">
				
				<div class="input-block">
					<label for='title' class="required">Title</label>
					<input name='title' id='title' type='text' <?if(isset($p_title)&& ! $success) print "value='$p_title'"?> onKeyDown="textCounter('title',60,'title-counter')" onKeyUp="textCounter('title',60,'title-counter')" />
					<div class="note">The title can be <input id="title-counter" type="text" value="60" /> characters more.</span></div>
					<script>textCounter('title',60,'title-counter')</script>
				</div>

				<div class="input-block">
					<label for='expiry' class="required">Expiry</label>
					<select name='expiry'>  
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
					<input name='MAX_FILE_SIZE' type='hidden' value='512000' />				
					<label for='picture'>Picture</label>
					<input name='picture' type='file' />
					<div class='note'>max. 500 Kb 800x600 pixel jpg picture</div>
				</div>
												
			</div>				

			<br />

			<div class="fleft">

				<div class="input-block">
					<label for='region' class="required">Region</label>
					<?include('./templates/parts/select-region.php')?>  
				</div>
				<div class="input-block">
					<label for='category' class="required">Category</label>
					<?include('./templates/parts/select-category.php')?> 
				</div>	
																	
				<div class="input-block">
					<label for='city'>City</label>
					<input name='city' type='text' value='<?if(isset($p_city)) print $p_city; else if(User::is_logged_in()) print User::get_prop('city')?>' />
				</div>					
			</div>				

			<br />

			<div class="fleft">
				<div class="input-block">				
					<label for='description' class="required">Description</label>
					<textarea rows="10" cols="56" id='description' name='description' onKeyDown="textCounter('description',500,'description-counter')" onKeyUp="textCounter('description',500,'description-counter')"><?if(isset($p_description)&& ! $success) print $p_description?></textarea>
					<div class="note">The Description can be <input id="description-counter" type="text" value="500" /> characters more.</span></div>
					<script>textCounter('description',500,'description-counter')</script>
				</div>
				<div class="input-block">
					<label for='price'>Price</label>
					<input name='price' type='text' <?if(isset($p_price)&& ! $success) print "value='$p_price'"?> />
				</div>
				<div class="input-block">
					<label for='webpage'>Webpage</label>
					<input name='webpage' type='text' value='<?if(isset($p_webpage)) print $p_webpage; else if(User::is_logged_in()) print User::get_prop('weblap')?>' />
				</div>
				<div class="input-block">
					<label for='terms'>&nbsp;</label>
					<input name='terms' type='checkbox' <?if(! isset($p_terms)||($p_terms > 0 && ! $success)) print 'checked="checked"'?> />
					<span><a href="#" onclick="return(makePopup(this,'<?=$site_url?>/terms-of-use.php'))">I agree with the Terms &amp; Conditions</a></span>
				</div>	
			</div>
						
			<div style="width:100%;text-align:center;">
				<input name="post" type="submit" value="Post"/>				
			</div>									
		</form>					        			

	</fieldset>
			
</div>
