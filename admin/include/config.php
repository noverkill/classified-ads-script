<?php

ini_set( 'display_errors', '0' ); 										

date_default_timezone_set( 'America/Chicago' );	// set the timezone of the server the script runs on, if not sure, do not touch and do not comment it out!

$site_url         = 'your-site-url';			// the url where your script will be running e.g. http://my-classifieds.com
$upload_path      = './upload';					// the path where the pictures will be uploaded, normally do not have to be modified

$site_title       = 'Classified Ads Script';	// the title of your site, modify as you wish
$site_description = 'classified ads script';	// seo setting, modify as you wish 
$site_keywords    = 'classified ads script';	// seo setting, modify as you wish

$admin_mail       = 'your-admin-email';			// site admin email address, system messages will be sent from this address
$noreply          = 'your-noreply-email';		// noreply email address for your site, system messages will be sent from this address

$db_host          = 'localhost'; 				// the name of the db host, this depend on your hosting provider but usually localhost 
$db_name          = 'your-database-name'; 		// name of the database prepared to use by this script e.g. classified
$db_user          = 'your-database-user';    	// the name of the db user who can acces to the database with all privileges
$db_pass          = 'your-database-password';	// the password of the above db user

$currency         = '$';						// the currency symbol you intend to use e.g. USD, $, EUR etc..

session_start();
header( 'Content-Type: text/html; charset=UTF-8' );
      
?>
