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

$current_group_page['name'] = 'Static Content';
$current_sub_page['name']   = 'Edit';

$g_id   = isset( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$static = StaticContent::get_one( $g_id );

$exists = isset( $static['id'] );

if( $g_id > 0 && ! $exists ) {
	$success = false;
	$errors = array( $current_group_page['name'] . " not exist." );	
}

if( $exists ) {
	
	$p_title   = $static['title'];
	$p_slug    = $static['slug'];
	$p_content = $static['content'];

	$current_sub_page['name'] .= " ( id: $g_id )"; 
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['static_edit'] ) ) {

    $p_title   = trim($_POST['title']);
    $p_content = $_POST['content'];
	$p_slug   = trim($_POST['slug']);	
	
    $success = true;
    $errors = array();

    if ($p_title != '' && !preg_match('/^[\\w ]{0,20}$/u', $p_title)) {
        $success = false;
        array_push($errors, "Invalid title!");
    }
    if ($p_title == '') {
        $success = false;
        array_push($errors, "The title field is required !");
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
						
		$update = array( 'title' => $p_title, 'slug' => $p_slug, 'content' => $p_content );
		
		StaticContent::update( $g_id, $update);

		$static = StaticContent::get_one( $g_id );
    }
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
			
		<form name="form_static_edit" id="form_static_edit" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print 'Edit ' . $current_group_page['name'] . ($exists ? "<span class='note'>( id: $g_id )</span>" : ''); ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Static Content modified succesfuly.</p>";;
			}
			?>			

			<?php if( ! $exists ) { ?>

				<label for='id' class="required">Id</label>
				<input name='id' id='id' type='text' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				<br />

				<label for="static_content_get"></label>
				<input type="submit" name="static_content_get" value="Edit"/>
							
			<?php } else { ?>

				<input name='id' type='hidden' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
							
				<label for='title'>Title</label>
				<input name='title' type='text' <?php print "value='$p_title'"; ?> />
				<p class='note'>Required</p>
				<br />

				<label for='slug'>Slug</label>
				<input type='text' name='slug' size='50' maxlength='50' value='<?php print $p_slug; ?>' />
				<p class='note'>Required</p>
				<br />
				
				<label for='content' class="required">Content</label>
				<textarea rows="20" cols="56" name='content'><?php print $p_content; ?></textarea>
				<br />
				<br />
				
				<label for='static_edit'></label>
				<input type='submit' name='static_edit' value='Modify'/>
				<span><input type="submit" name="reset" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /></span>

			<?php } ?>
			
		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
