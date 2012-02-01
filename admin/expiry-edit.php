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

$g_id   = isset( $_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

$expiry = Expiry::get_one( $g_id );

$exists = isset( $expiry['id'] );

if( $g_id > 0 && ! $exists ) {
	$success = false;
	$errors = array( $current_group_page['name'] . " not exist." );	
}

if( $exists ) {
	
	$p_name   = $expiry['name'];
	$p_period = $expiry['period'];

	$current_sub_page['name'] .= " ( id: $g_id )"; 
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['expiry_edit'] ) ) {

    $p_name   = trim($_POST['name']);
	$p_period = (int)$_POST['period'];
	
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

    if ($success) {
						
		$update = array( 'name' => $p_name, 'period' => $p_period );
				 
		Expiry::update( $g_id,  $update);

		$expiry = Expiry::get_one( $g_id );
    }
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
			
		<form name="form_expiry_edit" id="form_expiry_edit" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print 'Edit ' . $current_group_page['name'] . ($exists ? "<span class='note'>( id: $g_id )</span>" : ''); ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Expiry modified succesfuly.</p>";;
			}
			?>			

			<?php if( ! $exists ) { ?>

				<label for='id' class="required">Id</label>
				<input name='id' type='text' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				<br />

				<label for="expiry_get"></label>
				<input type="submit" name="expiry_get" value="Edit"/>
							
			<?php } else { ?>

				<input name='id' type='hidden' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
			
				<label for='name'>Name</label>
				<input name='name' type='text' value='<?php print $p_name; ?>' />
				<p class='note'>Required</p>
				<br />

				<label for='period'>Period</label>
				<input type='text' name='period' size='50' maxlength='50' value='<?php print $p_period; ?>' />
				<p class='note'>Required, in days</p>
				<br />
				
				<label for='expiry_edit'></label>
				<input type='submit' name='expiry_edit' value='Modify'/>
				<span><input type="submit" name="reset" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /></span>

			<?php } ?>
			
		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
