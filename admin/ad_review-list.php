<?php 
/**
 * Classified-ads-script
 * 
 * Admin area
 * 
 * @copyright  Copyright (c) Szilard Szabo
 * @license    GPL v3
 * @package    Admin
 */

include("./include/common.php");
include ("Pager/Pager.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_GET['d'])) {
    $d = (int)$_GET['d'];
    AdReview::delete( $d );  
}

$tct = AdReview::count(); 	//total count
$rpp = 10; 					//row per page

$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct, 'excludeVars' => array( 'o', 'r', 'd', 't', 'e' ) );
$pager = @Pager::factory($pager_options);
list($from, $to) = $pager->getOffsetByPageId();

$reviews = AdReview::get_all( array(), '', ( $from - 1 ) . ", $rpp" );

include ("page-header.php"); 

?>

<div id="wrapper">
	
	<?php include( "page-left.php" ); ?>

	<div id="content">

		<?php if( $tct > $rpp ) echo $pager->links . '<br /><br />'; ?>

		<a name="table"></a>
				
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Ad id</th>
					<th>User id</th>
					<th>Rate</th>
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				if ($tct < 1) print "<tr><td colspan='5'>No records.</td></tr>";
				foreach( $reviews as $row ) {
				?>
					<tr>
						<?php
							print "<td>" . $row['id'] . "</td>";
							print "<td><a href='ad-edit.php?id=" . $row['ad_id'] . "'>" . $row['ad_id'] . "</a></td>";
							print "<td><a href='user-edit.php?id=" . $row['user_id'] . "'>" . $row['user_id'] . "</a></td>";
							print "<td>" . $row['rate'] . "</td>";
						?>	
						<td>
							<a href=<?php print 'ad_review-edit.php?' . build_query_string( array( 'id' => $row['id'] ) ); ?>>Edit</a>		
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . "?d=" . $row['id'] . "&t=" . time() . "#table'"; ?> onclick="return confirm ('Are you sure to delete?')">Delete</a>
						</td>	
					</tr>
				<?php
				}
				?>
			</tbody>

		</table>
		
		<br />

		<?php echo $pager->links; ?>
				
	</div>

</div>

<br />

<?php include ("page-footer.php"); ?>
