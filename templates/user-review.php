<?include('./templates/parts/page-top.php')?>

<?

$panels = array();

if(! User::is_logged_in()):
	$panels = array(array(
		'legend'=>'Information',
		'body'=>"<p><b>Please log in to use this function <a href='user-registration.php'>or click here to register</a>.</b></p>",
	));										
else:

	if(User::get_id()==$user['id']):
		$panels = array(array(
			'legend'=>'Information',
			'body'=>"<p>You can't review yourself.<br /><a href='user-view.php?id=$r_id'>Go back</a></p>",
		));										
	else:
	
		if(! $exists):
			$panels = array(array(
				'legend'=>'Error',
				'body'=>"<ul class='errors'>The requested User is not exist or inactive.</ul>"
			));
		else:
			if(isset($success)):
				
				if($success):

					$panels = array(array(
						'legend'=>'Information',
						'body'=>"<p class='success'>Your succesfuly reviewed the User.<br /><a href='user-view.php?id=$r_id'>Back to the User's profile</a></p>"
					));
							
				else:

					$body = "<ul class='errors'>";
					foreach($errors as $err)$body .= "<li>$err</li>";
					$body .= "</ul>";
					
					$panel = array(
						'legend'=>'Please correct the following errors',
						'body'=>$body
					);
					
					array_unshift($panels,$panel);	
				endif;
			endif;
		endif;
	endif;
endif;

?>

<div id="middle">

	<?include('./templates/parts/panels.php')?>
	
	<?php if(User::is_logged_in() && User::get_id()!=$user['id']):include('./templates/parts/user-review-form.php');endif?>
	
	<br />

</div>

<?include ('./templates/parts/page-right.php')?>

<?include ('./templates/parts/page-footer.php')?>
