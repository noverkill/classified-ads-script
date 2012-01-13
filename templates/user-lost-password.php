<?include('./templates/parts/page-top.php')?>

<?
if(isset($_POST['send'])):	                  
    if($success):

		$panels = array(array(
			'legend'=>'Information',
			'body'=>"<p class='success'>Your password has been sent to your email address.</p>"
		));
    else:		
		$body    = "<ul class='errors'>";
		foreach($errors as $err)$body .= "<li>$err</li>";
		$body   .= "</ul>";
		
		$panels = array(array(
			'legend'=>'Please correct the following errors',
			'body'=>$body
		));
	endif;
endif;	
?>

<div id="middle">

	<?include('./templates/parts/panels.php')?>

	<?include('./templates/parts/user-lost-password-form.php')?>

	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
