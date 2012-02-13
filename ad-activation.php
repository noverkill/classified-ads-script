 <?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");

$g_id   = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
$g_code = isset( $_GET['code'] ) ? trim( strip_tags( $_GET['code'] ) ) : '';
      
$success = true;
$errors  = array();

if($g_id < 1 ) $success = false;

if($g_code == '' ) $success = false;

if( $success ) if( ! Ad::activate( $g_id, $g_code ) ) $success = false;

include( "./templates/ad-activation.php" ); 

?>
