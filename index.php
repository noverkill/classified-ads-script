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

$qs = ( isset( $_SERVER['QUERY_STRING'] ) && count( $_SERVER['QUERY_STRING'] ) > 0 ) ? $_SERVER['QUERY_STRING'] : 'list=all';

header( "Location: ad-list.php?$qs" );

?>
