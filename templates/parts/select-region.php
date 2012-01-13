<select name='region'>  
	<?
	if(count($regions)< 1) print "<option value='0'>Create a Régió first!</option>";
	foreach($regions as $region):
		$selected = '';
		if(isset($p_region)){if($p_region == $region['id'])$selected = "selected='selected'";}
		else if(User::is_logged_in()&& User::get_prop('region')==$region['id'])$selected = "selected='selected'";
		print "<option value='" . $region['id'] . "' $selected>" . $region['name'] . "</option>";
		$sub_regions = $region['childs'];
		if(is_array($sub_regions)):
			foreach($sub_regions as $sub_region):
				$selected = '';
				if(isset($p_region)){if($p_region == $sub_region['id'])$selected = "selected='selected'";}
				else if(User::is_logged_in()&& User::get_prop('regio')==$sub_region['id'])$selected = "selected='selected'";									
				print "<option value='" . $sub_region['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
			endforeach;
		endif;
	endforeach;
	?>                 
</select>
