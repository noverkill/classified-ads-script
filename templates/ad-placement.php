<?include('./templates/parts/page-top.php')?>

<?

$panels = array(); 

if(isset($_POST['post'])):

    if($success):

		if(User::is_logged_in()):
			
			$panels = array(array(
				'legend'=>'Information',
				'body'=>"<p class='success'>Your ad has been placed successfuly!<br /><a href='ad.php?id=$last'>See Ad</a></p>",
			));		
		else:
						
			$panels = array(array(
				'legend'=>'Information',
				'body'=>"<p class='success'>Your ad has been placed successfuly!(Id: " . $last . ")<br />We have sent an email with the details of how you can activate your Ad.</p>",
			));		
		endif;		
    else:
		
		$body = "<ul class='errors'>";
		foreach($errors as $err)$body .= "<li>$err</li>";
		$body .= "</ul>";
		
		$error_panel = array(
			'legend'=>'Please correct the following errors',
			'body'=>$body
		);
		
		array_unshift($panels,$error_panel);		
	endif;			
endif;

$expiries = Expiry::get_all();

?>
							
<div id="middle">

	<?include('./templates/parts/panels.php')?>
	
	<?include('./templates/parts/placement-form.php')?>
	
	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
