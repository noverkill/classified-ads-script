<?php 
/**
 * Classified-ads-script
 * 
 * Admin area
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");
include( "./admin/include/thumb.php");

$g_id   = isset( $_GET['id'])   ? (int) $_GET['id'] : 0;
$g_code = isset( $_GET['code']) ? trim( strip_tags( $_GET['code'])) : '';

$ad = Ad::get_one( $g_id, array( 'code' => $g_code ) );

$exists = isset( $ad['id'] );

if( $exists ) {
	
	$p_name        = $ad['name'];
	$p_telephone   = $ad['telephone'];
	$p_title       = $ad['title'];
	$p_description = $ad['description'];
	$p_category    = isset( $ad['sub_category_id'] ) ? $ad['sub_category_id'] : $ad['main_category_id'];
	$p_price       = $ad['price'];
	$p_city        = $ad['city'];
	$p_region      = isset( $ad['sub_region_id'] ) ? $ad['sub_region_id'] : $ad['main_region_id'];
	$p_webpage     = $ad['webpage'];
	$p_expiry      = $ad['expiry'];	
	$p_del_picture = 0;
}

if( isset( $_POST['reset'] ) ) unset( $_POST );

if( $exists && isset( $_POST['modify'] ) ) {
	
	$p_name        = trim( strip_tags( $_POST['name'] ) );
	$p_telephone   = trim( strip_tags( $_POST['telephone'] ) );
	$p_title       = trim( strip_tags( $_POST['title'] ) );
	$p_description = strip_tags( $_POST['description'] );
	$p_category    = (int) $_POST['category'];
	$p_price       = trim( strip_tags( $_POST['price'] ) );
	$p_city        = trim( strip_tags( $_POST['city'] ) );
	$p_region      = (int) $_POST['region'];
	$p_webpage     = trim( strip_tags( $_POST['webpage'] ) );

	$p_picture     = @$_FILES['picture'];
	$p_del_picture = isset( $_POST['del_picture'] ) ? 1 : 0;	
					
	$success = true;
	$errors  = array();
	
	if( $p_name == '' ) {
		$success = false;
		array_push( $errors, "Please enter your name." );
	}

	if( $p_title == '' ) {
		$success = false;
		array_push( $errors, "Please enter a title." );
	}   

	if( $p_description == '' ) {
		$success = false;
		array_push( $errors, "Please enter a description." );
	} 
		   
	if( $p_description != '' && ! preg_match( '/^[\s\S]{0,500}$/u', $p_description ) ) {
		$success = false;
		array_push( $errors, "The description should be no more than 500 character." );
	}

	if( $p_category < 1 ) {
		$success = false;
		array_push( $errors, "No category selected." );
	}
		   
	if( $p_category != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_category ) ) {
		$success = false;
		array_push( $errors, "The category is incorrect." );
	}
	
	if( $p_region < 1 ) {
		$success = false;
		array_push( $errors, "No region selected." );
	}
	   
	if( $p_region != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_region ) ) {
		$success = false;
		array_push( $errors, "The region is incorrect." );
	}
  
	if( '' != $p_webpage && 0 !== strpos( $p_webpage, 'http://' ) ) $p_webpage = 'http://' . $p_webpage;
	  
	if( $p_webpage != '' && ! preg_match( '/^((http|https):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $p_webpage ) ) {
		$success = false;
		array_push( $errors, "The format of webpage address is incorrect." );
	}
	
	if( isset( $p_picture ) && isset( $p_picture['name'] ) && $p_picture['name'] != '' ) {
		
		list( $postedon_year, $postedon_month, $postedon_day) = explode( '-', $ad['postedon'] );
		
		$picture_path = "$upload_path/$postedon_year/$postedon_month/$postedon_day/picture";
		$thumb_path   = "$upload_path/$postedon_year/$postedon_month/$postedon_day/thumb";	
		
		include( "./admin/include/picture-upload.php" );
		
	} else {
		
		$p_picture = '';
	}
							  
	if( $success ) {
		
		$fields = array( 'name' => $p_name, 'telephone' => $p_telephone, 'title' => $p_title, 'description' => $p_description, 'category' => $p_category, 'price' => $p_price, 'city' => $p_city, 'region' => $p_region, 'webpage' => $p_webpage, $g_code );
		
		if( $p_picture != '' || $p_del_picture > 0 ) $fields['picture'] = $p_picture;
		
		Ad::update( $g_id, $fields );
		
		$ad = Ad::get_one( $g_id );
	}
}

include( "./templates/ad-modification.php" ); 

?>
