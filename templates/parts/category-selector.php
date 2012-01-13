<select name='category'>  
	<?
	if(count($categories)< 1) print "<option value='0'>Create a category first!</option>";
	foreach($categories as $category):
		$selected = '';
		if(isset($p_category)){if($p_category == $category['id'])$selected = "selected='selected'";}
		else if(User::is_logged_in()&& User::get_prop('category')==$category['id'])$selected = "selected='selected'";
		print "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
		$sub_categories = $category['childs'];
		if(is_array($sub_categories)):
			foreach($sub_categories as $sub_category):
				$selected = '';
				if(isset($p_category)){if($p_category == $sub_category['id'])$selected = "selected='selected'";}
				else if(User::is_logged_in()&& User::get_prop('category')==$sub_category['id'])$selected = "selected='selected'";
				print "<option value='" . $sub_category['id'] . "' $selected>&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
			endforeach;
		endif;
	endforeach;
	?>                 
</select>
