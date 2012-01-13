<?include('./templates/parts/page-top.php')?>

<?

$panels = array();

if(! $exists):
	
	$panels = array(
		'legend'=>'Error',
		'body'=>"<ul class='errors'>The requested Ad is not exist or inactive!</ul>",
	);
		
else:

	if(isset($_POST['modify'])):
		
		if($success):
			
			$panels = array(array(
				'legend'=>'Information',
				'body'=>"<p class='success'>Your ad has been succesfuly modified!<br /><a target='_blank' href='ad.php?id=$g_id'>See the Ad</a></p>"
			));
						
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
endif;

$expiries = Expiry::get_all();

?>
							
<div id="middle">

	<?include('./templates/parts/panels.php')?>
	
	<?include('./templates/parts/modification-form.php')?>
	
	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
