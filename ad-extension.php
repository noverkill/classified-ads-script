<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

$g_id   = isset( $_GET['id']) ? (int) $_GET['id'] : 0;
$g_code = isset( $_GET['code']) ? trim( strip_tags( $_GET['code'])) : '';

$ad = Ad::get_one( $g_id, array( 'code' => $g_code, 'active' => 1 ) );

$ad_exists = isset( $ad['id'] ); 
 
if( $ad_exists && isset( $_POST['extension'] ) ) {

	$success = true;
	$errors  = array();
	
	$p_extension = (int) $_POST['extension'];

	if ($p_extension < 1) {
		$success = false;
		array_push( $errors, "Please enter extension." );
	}
	
	if( $p_extension != '' && ! preg_match( '/^[0-9]{0,10}$/', $p_extension ) ) {
		$success = false;
		array_push( $errors, "The format of extension is incorrect." );
	}
		
	if( $success ) Ad::update( $g_id, array( 'extend' => $p_extension ), $g_code );
}

include( "./templates/ad-extension.php" ); 

?>
