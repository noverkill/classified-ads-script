<?include('./templates/parts/page-top.php')?>

<?

$panels = array();

if(! $exists):

	$panels = array(array(
		'legend'=>'Error',
		'body'=>"<ul class='errors'>The requested Ad is not exist or inactive!</ul>"
	));
endif;

if(isset($success)):
	
	if($success):

		$panels = array(array(
			'legend'=>'Information',
			'body'=>"<p class='success'>Your ad's  has been succesfuly sent!<br /><a href='javascript:history.back()'>Back</a> &nbsp; | &nbsp; <a href='ad.php?id=$r_id'>See Ad</a></p>"
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

?>
								
<div id="middle">

	<?include('./templates/parts/panels.php')?>
	
	<?include('./templates/parts/ad-sending-form.php')?>
	
	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
