<?php

function create_thumb ( 

	$image_file_name,
	$thumb_file_name,  
	&$thumb_width, 
	&$thumb_height,	
	$max_width 			= 150, 
	$max_height			= 150, 
	$sleeping_minisec	= 500
	
) {

	$blank_image_name = dirname (__FILE__) . "/blank150x150.jpg";
	
	if ( ! list ( $width_orig, $height_orig) = getimagesize ( $image_file_name)) {
		return throww ( "Nem muxik a getimagesize a kov. kepre.", $image_file_name, __FILE__, __LINE__);
	}
	
	$thumb_width  = $width_orig;
	$thumb_height = $height_orig;	
	
	$image   = imagecreatefromjpeg ( $image_file_name);	
	
	if ( ! $image) {
		return throww ( "Nem muxik a imagecreatefromjpeg a kov. kepre.", $image_file_name, __FILE__, __LINE__);
	}	
        	
	if ( ! file_exists ( $thumb_file_name)) touch ( $thumb_file_name);
	
	$image_p = imagecreatefromjpeg ( $blank_image_name);

	if( ! $image_p ) {
		trigger_error ( "imagecreatefromjpeg not working for the following file:" . $blank_image_name . __FILE__ . __LINE__);
	}		

	if ( $width_orig > $max_width || $height_orig > $max_height) {			

		$width_new  = $max_width;
		$height_new = $max_height;

		if ( $width_orig < $height_orig) {
			$width_new  = (int) ( ( $max_height / $height_orig) * $width_orig);
		} else {
			$height_new = (int) ( ( $max_width  / $width_orig)  * $height_orig);
		}

		$thumb_width  = $width_new;
		$thumb_height = $height_new;		

		imagecopyresampled ( $image_p, $image, 0, 0, 0, 0, $width_new, $height_new, $width_orig, $height_orig);

		imagejpeg ( $image_p, $thumb_file_name);
		
	} else {
		
		imagejpeg( $image, $thumb_file_name );
	}

	usleep( $sleeping_minisec );

	imagedestroy( $image_p );
	imagedestroy( $image );
}

function get_thumb_size (
 
	$image_file_name,
	&$width_new,
	&$height_new,
	$max_width 	= 150, 
	$max_height	= 150 
		
) {
	
	if ( ! list ( $width_orig, $height_orig) = getimagesize ( $image_file_name)) {
		trigger_error ( "imagecreatefromjpeg not working for the following file:" . $image_file_name . __FILE__ . __LINE__);
	}
			
	if ( $width_orig > $max_width || $height_orig > $max_height) {
							
		$width_new  = $max_width;
		$height_new = $max_height;
	
		if ( $width_orig < $height_orig) {
			$width_new  = (int) ( ( $max_height / $height_orig) * $width_orig);
		} else {
			$height_new = (int) ( ( $max_width  / $width_orig)  * $height_orig);
		}
		
	} else {
		
		$width_new  = $width_orig;
		$height_new = $height_orig;	
	}
}

?>
