<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="charset" content="UTF-8" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />
	
	<meta name="keywords" content="<?=$site_keywords?>" />
	<meta name="description" content="" />
    
    <title><?=$site_title?></title>
    
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	      	
	<link rel='stylesheet' href='css/general.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='css/form.css'    type='text/css' media='screen' />
	<link rel='stylesheet' href='css/panel.css'   type='text/css' media='screen' />
	<link rel='stylesheet' href='css/ad.css'      type='text/css' media='screen' />
	<link rel='stylesheet' href='css/footer.css'  type='text/css' media='screen' />
		
	<script type="text/javascript" src="js-func.js"></script>
	
</head>

<body>

	<div>
		
		<div id='top'>
		
			<h1><?=$site_title?></h1>	
						
			<div id="menu">
				<?$qstr = build_query_string(array_merge($_GET,array('id'=>-1,'code'=>-1)))?>
				<a title="classified-home" href=<?="index.php?$qstr"; if(isset($curr_page)&& $curr_page=="home") print "class='curr-page'"?>>Home</a>
				<a title="classified-regions" href=<?="region-list.php?$qstr"; if(isset($curr_page)&& $curr_page=="regions") print "class='curr-page'"?>>Regions</a>
				<a title="classified-categories" href=<?="category-list.php?$qstr"; if(isset($curr_page)&& $curr_page=="categories") print "class='curr-page'"?>>Categories</a>
				<a title="post-an-ad" href="ad-placement.php" class="fright" <?if(isset($curr_page)&& $curr_page=="post-an-ad") print "class='curr-page'"?>>Post an Ad</a>
			</div>

		</div>
