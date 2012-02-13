<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php");
include( "Pager/Pager.php");

$r_id     = isset( $_REQUEST['id'] )    ? (int) $_REQUEST['id'] : 0; 
$r_remove = isset( $_REQUEST['remove'] ) ? 1 : 0; 

if( USER::is_logged_in() ) {

	$user_id = USER::get_id();

	if( $r_id > 0 && Ad::exists( $r_id, array( 'active' => 1 ) ) ) {

		if( ! Favourite::exists( $user_id, $r_id ) ) {					

			Favourite::add( $user_id, $r_id ); 
			
		} else if( $r_remove > 0 ) {
			
			Favourite::delete( $user_id, $r_id );
		}		
	}

	$rpp = 15; 								
	$tct = Favourite::count( $user_id );

	if ($tct > 0) {
		
		$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct,);
		$pager = @Pager::factory($pager_options);		
		
		list( $from, $to ) = $pager->getOffsetByPageId();
		
		$ads = Favourite::get_all ( $user_id, ( $from - 1 ) . ", $rpp" );
	}
}

include( "./templates/user-favourites.php" ); 

?>
