<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	
<head>
	
	<meta http-equiv="charset" content="UTF-8" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />	

    <title>Classified Ad Script</title>    

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />	

	<link rel='stylesheet' href='css/print.css' type='text/css' media='screen' />

</head>

<body>

	<?if($exists): 

		$fields = array(
			array('name','Posted by'),
			array('email','Email'),
			array('title','Title'),
			array('description','Description'),
			array('price','Price'),
			array('telephone','Telephone'),
			array('webpage','Webpage'),
			array('city','City'),
			array('postedon','Posted on'),
			array('expiry','Exipiry'),
			array(isset($row['sub_category_name'])? 'sub_category' : 'main_category','Category'),
			array(isset($row['sub_region_name'])? 'sub_region' : 'main_region','Region')
		);

		$row = array();

		foreach($fields as $field):
			if($ad[$field[0]] != '')
				$row[] = array('title'=>$field[1],'value'=>$ad[$field[0]]);
		endforeach;
	?>
	
	<table cellpadding='5px' cellspacing='1px'>
		<tr>
			<td>		
				<a href='#' onclick='window.print();'>
					<img src='./images/print.gif' />Print
				</a>		
			</td>
			<td align='center'>
				<?=$site_url?>
			</td>
		</tr>	
		<tr>
			<td >
				Picture
			</td>
			<td >
				<img src='<?=$ad['thumb']?>' />
			</td>
		</tr>	
		<?foreach($row as $r):?>
			<tr>
				<td ><?=$r['title']?></td>
				<td width='500px' ><?=$r['value']?></td>
			</tr>
		<?endforeach?>
		
		<tr>
			<td colspan=2 align='center'>
				<?=$site_url?>
			</td>
		</tr>
	</table>
	
	<?else:?>
	
		<p class='error'>The requested Ad is inactive or not exist!</p>

	<?endif?>
	
</body>
</html>
