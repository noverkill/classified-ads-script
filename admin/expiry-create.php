<?php

include("./include/common.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_POST['expiry_create'])) {
	
    $p_name   = trim($_POST['name']);
    $p_period = (int)$_POST['period'];
    
    $success = true;
    $errors = array();
    
    if ($p_name != '' && !preg_match('/^[\\w ]{0,20}$/u', $p_name)) {
        $success = false;
        array_push($errors, "Invalid name.");
    }
    if ($p_name == '') {
        $success = false;
        array_push($errors, "The name field is required.");
    }
    if ($p_period < 1) {
        $success = false;
        array_push($errors, "Invalid or no period given.");
    }
    if ($p_period > 999) {
        $success = false;
        array_push($errors, "The max. period is 999.");
    }

    if ($success) {
        
        $last = Expiry::create( $p_name, $p_period );
    }
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
	
		<form name="form_expiry_create" id="form_expiry_create" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print $current_sub_page['name'].' '.$current_group_page['name']; ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>" . $current_group_page['name'] . " created succesfuly.<span class='note'>( id: <a href='expiry-edit.php?id=$last' target='_blank'>$last</a> )</span></p>";
			}
			?>

			<label for='name'>Name</label>
			<input name='name' type='text' <?php if (isset($p_name) && !$success) print "value='$p_name'"; ?> />
			<p class='note'>Required</p>
			<br />

			<label for='period'>Period</label>
			<input name='period' type='text' <?php if (isset($_POST['period']) && !$success) print "value='$_POST[period]'"; ?> />
			<p class='note'>Required, the length of period in days.</p>
			<br />

			<label for="expiry_create"></label>
			<input type="submit" name="expiry_create" value="Create"/>

		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
