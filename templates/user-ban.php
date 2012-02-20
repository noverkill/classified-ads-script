<?include('./templates/layout/page-top.php')?>

<?
if($exists):
	$panels = array(array(
		'legend' => 'Information',
		'body'   => "<p class='success'>The user has been banned succesfuly.</p>"
	));	
else:	
	$panels = array(array(
		'legend' => 'Error',
		'body'   => "<ul class='errors'>User not exists.</ul>"
	));
endif;
?>
								
<div id="middle">

	<?include('./templates/parts/panels.php')?>

	<br />

</div>

<?include ('./templates/layout/page-right.php')?>

<?include ('./templates/layout/page-footer.php')?>
