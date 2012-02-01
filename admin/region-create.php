<?php 
/**
 * Classified-ads-script
 * 
 * Admin area
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Admin
 */

include("./include/common.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_POST['region_create'])) {

    $p_parent = (int)$_POST['parent'];
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

        $last = Region::create( array( 'name' => $p_name, 'slug' => $p_slug ), $p_parent );
    }
}

if (isset ($_POST['region_slug_generate'])) {

    $p_parent = (int)$_POST['parent'];	
	$p_name   = trim($_POST['name']);

    $success = false;
    $errors = array();
    	
    if (($p_name == '') || ($p_name != '' && ! preg_match ('/^[\w- ]*$/u', $p_name))) {
        $success = false;
        array_push($errors, "Invalid name!");
    } else {
		$p_slug = slug ($p_name);
	}
	
}

$regions = Region::get_all( array( 'parent' => 0 ) );

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
			
		<form name="form_region_create" id="form_region_create" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_sub_page['name'].' '.$current_group_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>" . $current_group_page['name'] . " created succesfuly.<span class='note'>( id: <a href='region-edit.php?id=$last' target='_blank'>$last</a> )</span></p>";
			}
			?>

			<label for='parent'>Parent</label>

			<select name='parent'>
				<option value='0'>None</option>
				<?php foreach( $regions as $row ) print "<option value='" . $row['id'] . "' " . ( ( isset( $p_parent ) && ! $success && $row['id'] == $p_parent) ? "selected='true'" : '') . ">" . $row['name'] . "</option>"; ?>
			</select>
			<br />

			<label for='name'>Name</label>
			<input name='name' type='text' <?php if (isset($p_name) && !$success) print "value='$p_name'"; ?> />
			<p class='note'>Required</p>
			<br />

			<label for='slug'>Slug</label>
			<input type='text' name='slug' size='50' maxlength='50' <?php if (isset ($p_slug) && ! $success) print "value='$p_slug'"; ?> />
			<span><input type='submit' name='region_slug_generate' value='Generate'/></span>
			<p class='note'>Required</p>
			<br />

			<label for='region_create'></label>
			<input type='submit' name='region_create' value='Create'/>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
