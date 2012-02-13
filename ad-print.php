<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

$g_id = $_GET['id'];

$ad = Ad::get_one( $g_id, array( "active" => 1 ) );

$exists = isset( $ad['id'] );
		
include( "./templates/ad-print.php" ); 

?>
