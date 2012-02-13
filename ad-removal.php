<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");
include( "./admin/include/thumb.php");

$panels = array ();

$g_id   = isset( $_GET['id'])   ? (int) $_GET['id'] : 0;
$g_code = isset( $_GET['code']) ? trim( strip_tags( $_GET['code'])) : '';

$exists = Ad::exists( $g_id, array( "code" => $g_code, "active" => 1 ) );

if( $exists ) Ad::delete( $g_id, array( "code" => $g_code ) );	

include( "./templates/ad-removal.php" ); 

?>
