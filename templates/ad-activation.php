<?include('./templates/parts/page-top.php')?>

<?
if($success):
	$panels = array(array(
		'legend' => 'Information',
		'body'   => "<p class='success'>Your ad has been succesfuly activated!<br /><a href='ad.php?id=$g_id'>See the Ad</a></p>"
	));	
else:	
	$panels = array(array(
		'legend' => 'Error',
		'body'   => "<ul class='errors'>Incorrect activation data!</ul>"
	));
endif;
?>
								
<div id="middle">

	<?include('./templates/parts/panels.php')?>

	<br />

</div>

<?include ('./templates/parts/page-right.php')?>

<?include ('./templates/parts/page-footer.php')?>
