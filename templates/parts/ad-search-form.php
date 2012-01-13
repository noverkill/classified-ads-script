
<a id="hide-form" onclick="shform('form_search_fields')" href="#"></a>
	
<div class="form-panel" id="form_search_fields">
		
	<form name="form_search" id="form_search" method="get" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">
		
		<div class="fleft">

			<div class="input-block">
				<label for='description'>Search phrase</label>
				<input name='description' type='text' value="<?=$g_description?>" />
			</div>
			
			<div class="input-block">
				<label for='mezok'>Search in fields</label>
				<div id="search-fileds">
					<p><input name='in_description' type='checkbox' <?if($g_in_description)print "checked='true'"?> />Description</p>
					<p><input name='in_id'          type='checkbox' <?if($g_in_id)         print "checked='true'"?> />Id</p>
					<p><input name='in_title'       type='checkbox' <?if($g_in_title)      print "checked='true'"?> />Title</p>
					<p><input name='in_name'        type='checkbox' <?if($g_in_name)       print "checked='true'"?> />Name</p>
					<p><input name='in_webpage'     type='checkbox' <?if($g_in_webpage)    print "checked='true'"?> />Webpage</p>
					<p><input name='in_city'        type='checkbox' <?if($g_in_city)       print "checked='true'"?> />City</p>
					<p><input name='in_email'       type='checkbox' <?if($g_in_email)      print "checked='true'"?> />Email</p>
				</div>
			</div>

			<br />
			
			<div class="input-block">					
				<label for='region'>Region</label>
				<select name='region'>  
					<?
					if(count($regions)<1): print "<option value='any'>Create a Regions first!</option>";
					else:
						print "<option value='any'" . ($g_region == 'any' ? "selected='selected'" : '') . ">Any</option>";
						foreach( $regions as $region):
							print "<option value='" . $region['slug'] . "' " . ($g_region == $region['slug'] ? "selected='selected'" : '') . ">" . $region['name'] . "</option>";
							if( isset( $region['childs'])):
								foreach ($region['childs'] as $sub_region):
									print "<option value='" . $sub_region['slug'] . "' " . ($g_region == $sub_region['slug'] ? "selected='selected'" : '') . ">&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
								endforeach;
							endif;
						endforeach;
					endif;
					?>                
				</select>
			</div>

			<div class="input-block">																	
				<label for='category'>Category</label>
				<select name='category'>  
					<?php
					if(count($categories )<1): print "<option value='any'>Create a category first!</option>";
					else:
						print "<option value='any' " . ($g_category == 'any' ? "selected='selected'" : '') . ">Any</option>";
						foreach( $categories as $category):
							print "<option value='" . $category['slug'] . "' " . ($g_category == $category['slug'] ? "selected='selected'" : '') . ">" . $category['name'] . "</option>";
							if( isset( $category['childs'])):
								foreach( $category['childs'] as $sub_category):
									print "<option value='" . $sub_category['slug'] . "' " . ($g_category == $sub_category['slug'] ? "selected='selected'" : '') . ">&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
								endforeach;
							endif;
						endforeach;
					endif;
					?>                  
				</select>					
			</div>
													
			<br />

			<div class="input-block">									
				<label for='min_price'>Minimum Price</label>
				<input name='min_price' type='text' value="<?=$g_min_price?>" />
			</div>
			
			<div class="input-block">											
				<label for='max_price'>Maximum Price</label>
				<input name='max_price' type='text' value="<?=$g_max_price?>" />
			</div>					
								
		</div>
		
		<div class="form-right">				
			<h4><?=$tct?> ads found</h4>																				
			<p><a href="ad-list.php?list=all" title="reset search">Reset Search</a></p>			
			<p><a onclick="shform('form_search_fields')" href="#">Hide Form</a></p>
			<input id="search-button" name="search" type="submit" value="Search" />														
		</div>				
		
	</form>
			
</div>
	
<br class="clear" />
