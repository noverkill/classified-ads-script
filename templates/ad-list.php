<?php 

include ("page-top.php");

$panels = array();

if ($tct < 1) {
		
	$panels = array( array(
		'legend' => 'Information',
		'body'   => "<p class='success'>No result.</p>",
	) );
}

?>
					
<div id="middle">

	<a id="hide-form" onclick="shform('form_search_fields')" href="#"></a>
		
	<div class="form-panel" id="form_search_fields">
			
		<form name="form_search" id="form_search" method="get" enctype='application/x-www-form-urlencoded' accept-charset="utf-8">
			
			<div class="fleft">

				<div class="input-block">
					<label for='description'>Search phrase</label>
					<input name='description' type='text' value="<?php print $g_description; ?>" />
				</div>
				
				<div class="input-block">
					<label for='mezok'>Search in fields</label>
					<div id="search-fileds">
						<p><input name='in_description' type='checkbox' <?php if ($g_in_description) print "checked='true'"; ?> />Description</p>
						<p><input name='in_id'          type='checkbox' <?php if ($g_in_id)          print "checked='true'"; ?> />Id</p>
						<p><input name='in_title'       type='checkbox' <?php if ($g_in_title)       print "checked='true'"; ?> />Title</p>
						<p><input name='in_name'        type='checkbox' <?php if ($g_in_name)        print "checked='true'"; ?> />Name</p>
						<p><input name='in_webpage'     type='checkbox' <?php if ($g_in_webpage)     print "checked='true'"; ?> />Webpage</p>
						<p><input name='in_city'        type='checkbox' <?php if ($g_in_city)        print "checked='true'"; ?> />City</p>
						<p><input name='in_email'       type='checkbox' <?php if ($g_in_email)       print "checked='true'"; ?> />Email</p>
					</div>
				</div>

				<br />
				
				<div class="input-block">
					
					<label for='region'>Region</label>
					<select name='region'>  
						<?php
							if( count( $regions) < 1) print "<option value='any'>Create a Regions first!</option>";
							else {
								print "<option value='any'" . ($g_region == 'any' ? "selected='selected'" : '') . ">Any</option>";
								foreach( $regions as $region) {
									print "<option value='" . $region['slug'] . "' " . ($g_region == $region['slug'] ? "selected='selected'" : '') . ">" . $region['name'] . "</option>";
									if( isset( $region['childs'])) {
										foreach ($region['childs'] as $sub_region) {
											print "<option value='" . $sub_region['slug'] . "' " . ($g_region == $sub_region['slug'] ? "selected='selected'" : '') . ">&nbsp;&nbsp;-&nbsp;" . $sub_region['name'] . "</option>";
										}
									}
								}
							}
						?>                
					</select>

				</div>

				<div class="input-block">
																		
					<label for='category'>Category</label>
					<select name='category'>  
						<?php
							if( count( $categories ) < 1) print "<option value='any'>Create a category first!</option>";
							else {
								print "<option value='any' " . ($g_category == 'any' ? "selected='selected'" : '') . ">Any</option>";
								foreach( $categories as $category) {
									print "<option value='" . $category['slug'] . "' " . ($g_category == $category['slug'] ? "selected='selected'" : '') . ">" . $category['name'] . "</option>";
									if( isset( $category['childs'])) {
										foreach( $category['childs'] as $sub_category) {
											print "<option value='" . $sub_category['slug'] . "' " . ($g_category == $sub_category['slug'] ? "selected='selected'" : '') . ">&nbsp;&nbsp;-&nbsp;" . $sub_category['name'] . "</option>";
										}
									}
								}
							}
						?>                  
					</select>
					
				</div>
														
				<br />

				<div class="input-block">
									
					<label for='min_price'>Minimum Price</label>
					<input name='min_price' type='text' value="<?php print $g_min_price; ?>" />

				</div>
				
				<div class="input-block">
											
					<label for='max_price'>Maximum Price</label>
					<input name='max_price' type='text' value="<?php print $g_max_price; ?>" />

				</div>					
									
			</div>
			
			<div class="form-right">
				
				<h4><?php print $tct; ?> ads found</h4>
																				
				<p><a href="ad-list.php?list=all" title="reset search">Reset Search</a></p>			

				<p><a onclick="shform('form_search_fields')" href="#">Hide Form</a></p>

				<input id="search-button" name="search" type="submit" value="Search" />	
													
			</div>				
			
		</form>
				
	</div>
		
	<br class="clear" />
		
<?php foreach( $panels as $panel) { ?>
	
	<div class="form-panel">

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
								
			<?php print $panel['body']; ?>         			

		</fieldset>
				
	</div>

<?php }	?>

<?php foreach ($ads as $row) { 
	$qry = build_query_string( array( 'id' => $row['id'] ) );	
?>
	<div class="ad-panel">		
		<a class='picture' title="<?php print $row['title']; ?>" href="ad.php?<?php print $qry; ?>" name="<?php print $row['id']; ?>">
			<img alt="<?php print $row['title']; ?>" src="<?php print $row['thumb']; ?>" />
		</a>
		<div class="details">
			<h3 class='subject'><a href="ad.php?<?php print $qry; ?>"><?php print $row['title']; ?></a></h3>
			<p><?php print substr( $row['description'], 0, 150); ?> <a href="ad.php?<?php print $qry; ?>">[...]</a></p>
			<p><?php if ($row['price'] != '') print str_to_currency($row['price']); ?></p>		
			<p><a href="ad.php?<?php print $qry; ?>">More &gt;&gt;</a></p>	
		</div>
	</div>
	
	<br class='clear' />	
	
	<hr class='separator' />	
	
<?php } ?>

<br />

</div>

<?php include ("page-right.php"); ?>

<script type="text/javascript">window.onload = lform('form_search_fields')</script>	
	
<?php include ("page-footer.php"); ?>
