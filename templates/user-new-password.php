<?include('./templates/layout/page-top.php')?>

<?
if(isset($_POST['change'])):	
	if($success):
		$panels = array(array(
			'legend'=>'Information',
			'body'=>"<p class='success'>Your password has been succesfuly changed!</p>",
		));				
	else:
		$body = "<ul class='errors'>";
		foreach($errors as $err)$body .= "<li>$err</li>";
		$body .= "</ul>";

		$panels = array(array(
			'legend'=>'Please correct the following errors',
			'body'=>$body
		));
	endif;
endif;
?>
							
<div id="middle">

	<?include('./templates/parts/panels.php')?>

	<?include('./templates/forms/user-new-password-form.php')?>

	<br />

</div>

<?include('./templates/layout/page-right.php')?>

<?include('./templates/layout/page-footer.php')?>
