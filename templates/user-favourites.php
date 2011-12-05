<?php 

include( "page-top.php" ); 

$panels = array();

if( ! USER::is_logged_in() ) {

	$panels = array( array(
		'legend' => 'Information',
		'body'    => "<p class='success'><b>Please log in to use this function.</b><br />Registered users can save favourite ads.<br /><b>If you are not registered yet, then <a href='user-registration.php'>click here!</a></b></p>",
	) );
										
} else if ($tct < 1) {
		
	$panels = array( array(
		'legend' => 'Information',
		'body'   => "<p class='success'>You have no favourites.</p>",
	) );
}

?>
					
<div id="middle">

<?php foreach( $panels as $panel) { ?>
	
	<div class="form-panel">

		<fieldset>
			
			<legend><?php print $panel['legend']; ?></legend>
								
			<?php print $panel['body']; ?>         			

		</fieldset>
				
	</div>

<?php }	?>

<?php if( isset( $tct ) && $tct > 0 ) foreach ($ads as $row) { 
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
			<p><a href="user-favourites.php?remove=1&amp;<?php print $qry; ?>">Remove from favourites</a></p>
		</div>
	</div>

	<br class="clear" />
	
	<hr />	
			
	<br />
	
<?php } ?>

	<br />

</div>

<?php include ("page-right.php"); ?>

<?php include ("page-footer.php"); ?>
