<?include('./templates/parts/page-top.php')?>

<?
if(! USER::is_logged_in()):
	$panels = array(array(
		'legend'=>'Information',
		'body'=>"<p class='success'><b>Please log in to use this function.</b><br />Registered users can save favourite ads.<br /><b>If you are not registered yet,then <a href='user-registration.php'>click here!</a></b></p>",
	));										
elseif($tct < 1):		
	$panels = array(array(
		'legend'=>'Information',
		'body'  =>"<p class='success'>You have no favourites.</p>",
	));
endif;
?>
					
<div id="middle">

	<?include('./templates/parts/panels.php')?>

	<?include('./templates/parts/ad-list.php')?>

	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
