<?php 

include( "page-top.php" ); 

if( $exists ) {

	$panels = array( array(
		'legend' => 'Information',
		'body'    => "<p class='success'>Your ad has been succesfuly deleted!<br />Thank you for using our service.</a></p>"
	) );
		
} else {

	$panels = array( array(
		'legend' => 'Error',
		'body'    => "<ul class='errors'>The requested Ad is not exist or inactive!</ul>"
	) );
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
