<?php 
/**
 * Classified-ads-script
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Frontend
 */

include( "./admin/include/common.php" );

$r_id = isset( $_REQUEST['id']) ? (int) $_REQUEST['id'] : 0; 

$exists = Ad::exists( $r_id, array( "active" => 1 ) );

if( $exists ) {
	
	$ad = Ad::get_one( $r_id );

	if ( isset( $_POST['send'] ) && User::is_logged_in() ) {

		$success = true;
		$errors  = array();

		$p_message = strip_tags( $_POST['message'] );

		if( $p_message == '' ) {
			$success = false;
			array_push( $errors, "Please enter your message." );
		} 
		   
		if( $p_message != '' && ! preg_match( '/^[\s\S]{0,200}$/u', $p_message ) ) {
			$success = false;
			array_push( $errors, "The message must be no more than 200 character long." );
		}
		
		if( $success ) {
			
			$userid   = USER::get_id();
			$username = USER::get_name();
			$adid     = $r_id;
			$report   = $p_message;

			Report::create( array( 'ad_id' => $adid, 'user_id' => $userid, 'message' => $report ) );
						
			$content = StaticContent::get_content('abuse-report');	
			eval( "\$content = \"$content\";" );
			print "content: ".$content;
			global $admin_mail;
			
			mail( $admin_mail, 'Abuse report', $content, "From: ".$noreply);  
		}
	}
}

include ("./templates/ad-report.php");

?>
