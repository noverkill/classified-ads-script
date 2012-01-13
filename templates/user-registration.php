<?include('./templates/parts/page-top.php')?>

<?
if(isset($_POST['register'])):	                  
    if($success):
		$panels = array(array(
			'legend'=>'Information',
			'body'=>"<p class='success'>Your registration has been successful! <br />We have sent an email with the details of how you can activate your account.</p>",
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
else:
	if(isset($_GET['id'])&& isset($_GET['code'])):		
		if($success):
			$panels = array(array(
				'legend'=>'Information',
				'body'=>"<p class='success'>Your account has been succesfuly activated!<br />Now you can log in to the system!</p>"
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
endif;
?>

<div id="middle">

	<?include('./templates/parts/panels.php')?>

	<?include('./templates/parts/user-registration-form.php')?>

	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
