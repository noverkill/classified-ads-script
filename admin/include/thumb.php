<?php
/**
 * Classified-ads-script
 *
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Thumbnail_generation
 * @version    $Id: thumb.php
 */

/**
 * The function creates a thumbnail from the given image.
 * The thumbnail will fit into the box defined by the thumb_with and thumb_height parameters.
 * The function needs a blank jpg file in its directory.
 * The function has support for jpg images.
 * This function needs the php GD library.
 *  
 * Todo: this function should be replaced asap due to its very limited nature.
 * 
 * @param 	string 		$image_file_name				The image file which we need a thumbnail of.
 * @param 	string 		$thumb_file_name				The designated thumb file name.
 * @param 	int 		$thumb_width					The designated thumb width.
 * @param 	int 		$thumb_height					The designated thumb height.
 * @param 	int 		$max_width[optional]			Max. thumb width, default 150px
 * @param 	int 		$max_height[optional]			Max. thumb height, default 150px
 * @param 	int 		$sleeping_minisec[optional]		Process delay in minisecond, default 500.
 */
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

/**
 * The function calculates the dimensions of a possibly thumbnail image based on the original image's dimensions.
 * The thumbnail should be fit into the box defined by the $max_width and $max_height parameter while it's
 * must maintains the original image's ratio. 
 * The calculated dimensions are written back to the two variable references given by the $thumb_with and
 * $thumb_height parameters.
 *
 * @param 	string 		$image_file_name				The image file which we need a thumbnail of.
 * @param 	int 		&$thumb_width					Reference to the variable where we need the result width.
 * @param 	int 		&$thumb_height					Reference to the variable where we need the result height.
 * @param 	int 		$max_width[optional]			Max. thumb width, default 150px
 * @param 	int 		$max_height[optional]			Max. thumb height, default 150px
 */
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
