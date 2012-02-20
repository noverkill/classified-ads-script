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

$current_group_page['name'] = 'Report';
$current_sub_page['name']   = 'Edit';

$g_id = isset( $_REQUEST['id'] ) ? (int) $_REQUEST['id'] : 0;

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$report = Report::get_one( 0, array( 'id' => $g_id ) );

$exists = isset( $report['id'] );

if( $g_id > 0 && ! $exists ) {
	$success = false;
	$errors = array( $current_group_page['name'] . " not exist." );	
}

if( $exists ) {
	
	$p_ad_id   = $report['ad_id'];
	$p_user_id = $report['user_id'];
	$p_message = $report['message'];

	$current_sub_page['name'] .= " ( id: $g_id )"; 
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['report_edit'] ) ) {	

	$p_message = trim( strip_tags( $_POST['message'] ) );
		
    $success = true;
    $errors = array();

	if( $p_message == '' ) {
		$success = false;
		array_push( $errors, "The message field is required!" );
	} 
	   
	if( $p_message != '' && ! preg_match( '/^[\s\S]{0,200}$/u', $p_message ) ) {
		$success = false;
		array_push( $errors, "The message must be no more than 200 character long." );
	}
		   
    if ($success) {
						
		$update = array( 'message' => $p_message );
		
		Report::update( $g_id, $update);

		$report = Report::get_one( $g_id );
    }
}

include ("page-header.php"); 

?>

<div id="wrapper">

	<?php include( "page-left.php" ); ?>

	<div id="content">
			
		<form name="form_report_edit" id="form_report_edit" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2><?php print 'Edit ' . $current_group_page['name'] . ($exists ? "<span class='note'>( id: $g_id )</span>" : ''); ?></h2>

			<br />

			<?php
			if (isset($success)) {
				if (!$success) {
					print "<ul class='errors'>";
					foreach ($errors as $err) print "<li>$err</li>";
					print "</ul>";
				} else print "<p class='success'>Report modified succesfuly.</p>";;
			}
			?>			

			<?php if( ! $exists ) { ?>

				<label for='id' class="required">Id</label>
				<input name='id' id='id' type='text' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
				<br />

				<label for="report_get"></label>
				<input type="submit" name="report_get" value="Edit"/>
							
			<?php } else { ?>

				<input name='id' type='hidden' value='<?php if( isset( $g_id ) && $g_id > 0 ) print $g_id; ?>' />
							
				<label for='ad_id'>Ad id</label>
				<a href='ad-edit.php?id=<?=$report['ad_id']?>'><?=$report['ad_id']?></a>
				<br />
							
				<label for='user_id'>User id</label>
				<a href='user-edit.php?id=<?=$report['user_id']?>'><?=$report['user_id']?></a>
				<br />
				
				<label for='message' class="required">Message</label>
				<textarea rows="20" cols="56" name='message'><?php print $p_message; ?></textarea>
				<br />
				<br />
				
				<label for='report_edit'></label>
				<input type='submit' name='report_edit' value='Modify'/>
				<span><input type="submit" name="reset" value="Reset" onclick="return confirm('Do you really want to reset the form?')" /></span>

			<?php } ?>
			
		</form>

	</div>

</div>

<?php include ("page-footer.php"); ?>
