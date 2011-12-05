<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="charset" content="UTF-8" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />	
		
	<link rel='stylesheet' href='css/general.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/breadcrumb.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/nav.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/form.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/table.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/custom.css' type='text/css' media='screen' />	
	<link rel='stylesheet' href='css/form_ad.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/form_static.css' type='text/css' media='screen' />

</head>

<body>

<div id="container">
	
	<div id="top">	
		
		<h1>Classified Ad Admin</h1>
	
		<?php if( User::is_logged_in() && User::get_id() == 1 ) { ?>

			<span class="form">Welcome: <a href="setting-profile.php"><?php print User::get_username(); ?></a> | <a href='index.php?logout'>Logout</a></span>

		<?php } ?>
		
	</div>
	
	<br />

	<div>

		<ul id='breadcrumb'>
			<li><a href='index.php' title='Home'><img src='images/home.png' alt='Home' class='home' /></a></li>
			<?php if( $current_group_page['name'] != '' && $current_sub_page['name'] != 'Lost password' ) { ?>
				<li><a href='<?php print $current_group_page['script']; ?>' title='<?php print $current_group_page['name']; ?>'><?php print $current_group_page['name']; ?></a></li>
				<li><a href='<?php print $current_sub_page['script']; ?>' title='<?php print $current_group_page['name'].'-'.$current_sub_page['name']; ?>'><?php print $current_sub_page['name']; ?></a></li>
			<?php } ?>
		</ul>
	
	</div>

	<br />
