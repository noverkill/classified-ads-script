<?php 

include ("page-top.php");

if( $success ) {

	$panels = array( array(
		'legend' => 'Information',
		'body'    => "<p class='success'>Your ad has been succesfuly activated!<br /><a href='ad-list.php?id=$g_id'>See the Ad</a></p>"
	));
	
} else {
	
	$panels = array( array(
		'legend' => 'Error',
		'body'    => "<ul class='errors'>Incorrect activation data!</ul>"
	));
}

?>
								
<div id="middle">

	<?php foreach( $panels as $panel) { ?>
		
		<div class="form-panel">

			<fieldset>
				
				<legend><?php print $panel['legend']; ?></legend>
									
				<?php if ($panel['body'] != '') print $panel['body']; else { ?>				
			
				<?php } ?>           			

			</fieldset>
					
		</div>

		<br />
		<br />

	<?php } ?>

	<br />

</div>

<?php include ("page-right.php"); ?>

<?php include ("page-footer.php"); ?>
