<?php

include( "./admin/include/common.php");
include( "Pager/Pager.php");

$g_id   = isset( $_GET['id']) ? (int) $_GET['id'] : 0;

$ad = Ad::get_one( $g_id );

$exists = isset( $ad['id'] );

if( $exists ) $is_favourite = Favourite::exists( User::get_id(), $ad['id'] );

include ("./templates/ad.php");

?>
