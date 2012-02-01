<?php
/**
 * Classified-ads-script
 * 
 * This file contains reusable code for picture uploading,
 * and should be included where this functionality
 * is needed.
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Thumbnail_generation
 * @version    $Id: picture-upload.php
 */

if( $p_picture['size'] === 0 ) {
	$success = false;
	array_push( $errors, "Bad file." );
}

if( $p_picture['size'] > 512000 ) {
	$success = false;
	array_push( $errors, "The file exceed the limit." );
}

if( $p_picture['error'] != UPLOAD_ERR_OK ) {
	$success = false;
	array_push( $errors, "File upload error." );
}

if( ! is_uploaded_file( $p_picture['tmp_name'] ) ) {
	$success = false;
	array_push( $errors, "File upload error." );
}

/* Check file mime type 
 * (only works if finfo installed on server)
 * 
$finfo = finfo_open(FILEINFO_MIME);
$mime = finfo_file($finfo, $p_picture['tmp_name']);
finfo_close($finfo);
if (!in_array(mime_content_type($p_picture['tmp_name']), array('image/jpeg'))) {
	$success = false;
	array_push($errors, "The file is not jpg.");
}
* 
*/

if( $p_picture['type'] != 'image/jpeg' ) {
	$success = false;
	array_push( $errors, "The file is not jpg." );
}

//Sanitize the filename
$n_picture = iconv( "UTF-8", "ASCII//TRANSLIT", $p_picture['name'] );
$n_picture = preg_replace( "/[^[:alnum:]._-]/", '_', $n_picture );

$n_picture = time() . '-' . $n_picture; //make the filename unique

$n_picture = strtolower( $n_picture );  //make the filename and extension lowercase	

if( ! file_exists( $picture_path ) ) mkdir( $picture_path, 0777, true );

if( ! move_uploaded_file( $p_picture['tmp_name'], $picture_path . '/' . $n_picture ) ) {
	$success = false;
	array_push( $errors, "File upload error." );
}

//create thumb	 

if( ! file_exists( $thumb_path ) ) mkdir( $thumb_path, 0777, true );

$thumb = $thumb_path . '/thumb_' . $n_picture;

$picture = $picture_path . '/' . $n_picture;

if( ! file_exists( $thumb ) ) {			
	if( create_thumb( $picture, $thumb, $twidth, $theight ) === false ) {
		print "Thumb creating failed: " . $n_picture . __FILE__ . __LINE__;
	}
}

$p_picture = $n_picture;

?>
