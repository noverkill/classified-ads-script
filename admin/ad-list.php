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
    if ($d > 0) {
		Ad::delete( $d );
    }
}

if (isset($_GET['o'])) {
    $o = (int)$_GET['o'];
    $r = (int)$_GET['r'];
    if ($r != 0) $r = 1;   
    $a['sponsored'] = $r; 
    $a['sponsoredon'] = $r = 0 ? '' : date( 'Y-m-d', time() );
	Ad::update( $o, $a );
}

$tct = Ad::count();	//total count
$rpp = 10; 			//row per page

$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct, 'excludeVars' => array( 'o', 'r', 'd', 't', 'e' ) );
$pager = @Pager::factory($pager_options);
list($from, $to) = $pager->getOffsetByPageId();

$ads = Ad::get_all( array(), '', ( $from - 1 ) . ", $rpp" );

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
					<th>Picture</th>
					<th>Name</th>
					<th>Title</th>
					<th>Active</th>
					<th>Posted On</th>
					<th>Last Modified On</th>
					<th>Sponsored</th>
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				if ($tct < 1) print "<tr><td colspan='10'>No records.</td></tr>";
				foreach( $ads as $row ) {
				?>
					<tr>
						<?php
							print "<td>" . $row['id'] . "</td>";
							print "<td><img src='." . $row['thumb'] . "' /></td>";
							print "<td>" . $row['name'] . "</td>";
							print "<td>" . substr( $row['title'], 0, 20 ) . "...</td>";
							print "<td>" . $row['active'] . "</td>";
							print "<td>" . $row['postedon'] . "</td>";
							print "<td>" . $row['lastmodified'] . "</td>";
							print "<td>" . $row['sponsored'] . "</td>";
						?>	
						<td>
							<a href=<?php print 'ad-edit.php?' . build_query_string( array( 'id' => $row['id'] ) ); ?>>Edit</a><br />
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'd' => $row['id'], 't' => time() ) ) . "#table'"; ?> onclick="return confirm ('Are you sure to delete?')">Delete</a><br />
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'o' => $row['id'], 'r' => 1, 't' => time() ) ) . "#table'"; ?>>Sponzor</a><br />
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'o' => $row['id'], 'r' => 0, 't' => time() ) ) . "#table'"; ?>>Desponzor</a>
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

<?php include ("page-footer.php"); ?>
