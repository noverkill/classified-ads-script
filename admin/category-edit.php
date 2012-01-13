<?php

include("./include/common.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$g_id   = isset( $_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

$category = Category::get_one( $g_id );

$exists = isset( $category['id'] );

if( $g_id > 0 && ! $exists ) {
	$success = false;
	$errors = array( $current_group_page['name'] . " not exist." );	
}

if( $exists ) {
	
	$p_parent = $category['parent'];
	$p_name   = $category['name'];
	$p_slug   = $category['slug'];
	
	$current_sub_page['name'] .= " ( id: $g_id )"; 
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['category_edit'] ) ) {

    $p_parent = isset( $_POST['parent'] ) ? (int) $_POST['parent'] : 0;
    $p_name   = trim($_POST['name']);
	$p_slug   = trim($_POST['slug']);
	
    $success = true;
    $errors = array();

    if ($p_name != '' && ! preg_match ('/^[\w- ]*$/u', $p_name)) {
        $success = false;
        array_push($errors, "Invalid name!");
    }

    if ($p_name == '') {
        $success = false;
        array_push($errors, "The name field is required !");
    }

    if ($p_slug != '' && ! preg_match ('/^[a-zA-Z0-9_-]*$/', $p_slug)) {
        $success = false;
        array_push($errors, "Invalid slug!");
    }

    if ($p_slug == '') {
        $success = false;
        array_push($errors, "The slug field is required !");
    }

    if ($success) {
						
		$update = array( 'name' => $p_name, 'slug' => $p_slug );
		
		if( $category['parent'] > 0 && $p_parent > 0) $update['parent'] = $p_parent; 
				 
		Category::update( $g_id, $update );

		$category = Category::get_one( $g_id );
    }
}

$categories = Category::get_all( array( 'parent' => 0 ) );

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
			
		<form name="form_category_edit" id="form_category_edit" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print 'Edit ' . $current_group_page['name'] . ($exists ? "<span class='note'>( id: $g_id )</span>" : ''); ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Category modified succesfuly.</p>";;
			}
			?>			

			<?php if( ! $exists ) { ?>

				<label for='id' class="required">Id</label>
				<input name='id' type='text' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				<br />

				<label for="category_get"></label>
				<input type="submit" name="category_get" value="Edit"/>
							
			<?php } else { ?>

				<input name='id' type='hidden' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
						
				<?php if( $p_parent > 0 ) { ?>
					<label for='parent'>Parent</label>
					<select name='parent'>
						<?php foreach ( $categories as $row ) print "<option value='" . $row['id'] . "' " . ( $row['id'] == $p_parent ? "selected='selected'" : '') . ">" . $row['name'] . "</option>"; ?>
					</select>
					<br />
				<?php } ?>

				<label for='name'>Name</label>
				<input name='name' type='text' value='<?php print $p_name; ?>' />
				<p class='note'>Required</p>
				<br />

				<label for='slug'>Slug</label>
				<input type='text' name='slug' size='50' maxlength='50' value='<?php print $p_slug; ?>' />
				<p class='note'>Required</p>
				<br />
				
				<label for='category_edit'></label>
				<input type='submit' name='category_edit' value='Modify'/>
				<span><input type="submit" name="reset" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /></span>
			
			<?php } ?>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
