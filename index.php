<?php

$qs = ( isset( $_SERVER['QUERY_STRING'] ) && count( $_SERVER['QUERY_STRING'] ) > 0 ) ? $_SERVER['QUERY_STRING'] : 'list=all';

header( "Location: ad-list.php?$qs" );

?>
