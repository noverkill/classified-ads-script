<?php

include("./include/common.php");

$current_group_page['name'] = 'Static Content';
$current_sub_page['name']   = 'Create';

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_POST['static_create'])) {
	
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
	
		$last = StaticContent::create( array( 'title' => $p_title, 'slug' => $p_slug, 'content' => $p_content ) );
    }
}

if (isset ($_POST['static_slug_generate'])) {
	
	$p_title = trim ($_POST['title']);

    $success = false;
    $errors = array();
    	
    if (($p_title == '') || ($p_title != '' && ! preg_match ('/^[\w- ]*$/u', $p_title))) {
        $success = false;
        array_push($errors, "Invalid title!");
    } else {
		$p_slug = slug ($p_title);
	}
	
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_static_create" id="form_static_create" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_sub_page['name'].' '.$current_group_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>" . $current_group_page['name'] . " created succesfuly.<span class='note'>( id: <a href='static-content-edit.php?id=$last' target='_blank'>$last</a> )</span></p>";
			}
			?>

			<label for='title'>Title</label>
			<input name='title' type='text' <?php if (isset($p_title) && ! $success) print "value='$p_title'"; ?> />
			<p class='note'>Required</p>
			<br />

			<label for='slug'>Slug</label>
			<input type='text' name='slug' size='50' maxlength='50' <?php if (isset ($p_slug) && ! $success) print "value='$p_slug'"; ?> />
			<span><input type='submit' name='static_slug_generate' value='Generate'/></span>
			<p class='note'>Required</p>
			<br />
			
			<label for='content' class="required">Content</label>
			<textarea rows="20" cols="56" name='content'><?php if( isset( $p_content ) && ! $success) print $p_content; ?></textarea>
			<br />
			<br />
			
			<label for="ststic_create"></label>
			<input type="submit" name="static_create" value="Create"/>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
