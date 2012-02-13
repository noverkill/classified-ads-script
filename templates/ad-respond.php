<?include('./templates/parts/page-top.php')?>

<?

$panels = array();

if(! USER::is_logged_in()):
	$panels = array(array(
		'legend'=>'Information',
		'body'=>"<p><b>Please log in to use this function <a href='user-registration.php'>or click here to register</a>.</b></p>",
	));										
else:		

	if(! $exists):
		$panels = array(array(
			'legend'=>'Error',
			'body'=>"<ul class='errors'>The requested Ad is not exist or inactive!</ul>"
		));
	else:
		if(isset($success)):
			
			if($success):

				$panels = array(array(
					'legend'=>'Information',
					'body'=>"<p class='success'>Your response has been successfuly sent!<br /><a href='ad.php?id=$r_id'>Back to the Ad</a></p>"
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

?>

<div id="middle">

	<?include('./templates/parts/panels.php')?>
	
	<?php if(USER::is_logged_in()):include('./templates/parts/ad-respond-form.php');endif?>
	
	<br />

</div>

<?include ('./templates/parts/page-right.php')?>

<?include ('./templates/parts/page-footer.php')?>
