<div class="form-panel">

	<fieldset>
		
		<legend>Ad modification</legend>
							
		<form name="form_ad_modification" id="form_ad_modification" method="post" enctype='multipart/form-data' accept-charset="utf-8">										

			<div class="fleft">
				<div class="input-block">
					<label for='current-picture'>Current picture</label>
					<a class='current-picture' href="<?=$ad['picture']?>">
						<img src="<?=$ad['thumb']?>" />
					</a>
				</div>
				<div class="input-block" id="del-current-pic">						
					<label for='del_picture'>&nbsp;</label>
					<input name='del_picture' type='checkbox' <?if($p_del_picture > 0) print 'checked="checked"'?> />
					<span>Delete picture</span>
				</div>
			</div>
			
			<br />

			<div class="fleft">
				<div class="input-block">																							
					<label for='name' class="required">Name</label>
					<input name='name' type='text' value='<?if(isset($p_name)) print $p_name?>' />
				</div>
				<div class="input-block">						
					<label for='email' class="required">Email</label>
					<input name='email' type='text' disabled='disabled' value='<?=$ad['email']?>' />
				</div>
				<div class="input-block">						
					<label for='telephone'>Telephone</label>
					<input name='telephone' type='text' value='<?if(isset($p_telephone)) print $p_telephone?>' />
				</div>
			</div>

			<br />

			<div class="fleft">
				<div class="input-block">
					<label for='title' class="required">Title</label>
					<input name='title' id='title' type='text' <?if(isset($p_title)) print "value='$p_title'"?> onKeyDown="textCounter('title',60,'title-counter')" onKeyUp="textCounter('title',60,'title-counter')" />
					<div class="note">The title can be <input id="title-counter" type="text" value="60" /> charaters more.</div>
					<script>textCounter('title',60,'title-counter')</script>
				</div>
				<div class="input-block">
					<label for='expiry' class="required">Expiry</label>
					<input name='expiry' disabled="disabled" value="<?=$p_expiry?>" /> 
					<a href='ad-extension.php?<?='id=' . $g_id . '&code=' . $g_code?>'>Extend &gt; &gt;</a> 
				</div>						
				<div class="input-block">								
					<label for='picture'>New picture</label>
					<input name='MAX_FILE_SIZE' type='hidden' value='512000' />
					<input name='picture' type='file' />
					<div class='note'>max. 500 Kb 800x600 pixel jpg picture</div>
				</div>
			</div>
			<div class="fleft">
				<div class="input-block">
					<label for='region' class="required">Region</label>
					<?include('./templates/parts/region-selector.php')?>  
				</div>
				<div class="input-block">
					<label for='category' class="required">Category</label>
					<?include('./templates/parts/category-selector.php')?> 
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
					<textarea rows="10" cols="56" id='description' name='description' cols='39' rows='14' onKeyDown="textCounter('description',500,'description-counter')" onKeyUp="textCounter('description',500,'description-counter')"><?if(isset($p_description)) print $p_description?></textarea>
					<div class="note">The description can be <input id="description-counter" type="text" value="500" /> charaters more.</div>
					<script>textCounter('description',500,'description-counter')</script>
				</div>
				<div class="input-block">						
					<label for='price'>Price</label>
					<input name='price' type='text' value='<?if(isset($p_price)) print $p_price?>' />
				</div>	
				<div class="input-block">
					<label for='webpage'>Webpage</label>
					<input name='webpage' type='text' value='<?if(isset($p_webpage)) print $p_webpage?>' />
				</div>
			</div>
													
			<div style="width:100%;text-align:center;">
				<input name="modify" type="submit" value="Modify" />	 
				&nbsp; &nbsp; 
				<input name="reset" type="submit" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /> 			
			</div>
												
		</form>					          			

	</fieldset>
			
</div>
