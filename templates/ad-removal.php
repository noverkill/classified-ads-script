<?include('./templates/parts/page-top.php')?>

<?

if($exists):
	$panels = array(array(
		'legend'=>'Information',
		'body'=>"<p class='success'>Your ad has been succesfuly deleted!<br />Thank you for using our service.</a></p>"
	));		
else:
	$panels = array(array(
		'legend'=>'Error',
		'body'=>"<ul class='errors'>The requested Ad is not exist or inactive!</ul>"
	));
endif;

?>
								
<div id="middle">

	<?include('./templates/parts/panels.php')?>
	
	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
