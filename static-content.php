<?php

include( "./admin/include/common.php");

$slug = strip_tags( $_GET['slug'] );

$StaticContent = '';

if( StaticContent::count( array( 'slug' => $slug ) ) > 0 ) {

	$StaticContent = nl2br( StaticContent::get_content($slug) );
}

include( "./templates/static-content.php" ); 

?>
