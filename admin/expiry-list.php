<?php

include("./include/common.php");
include ("Pager/Pager.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_GET['d'])) {
    $d = (int)$_GET['d'];
    if ($d > 0) {
        Expiry::delete( $d );
    }
}
#sortable#
if (isset($_GET['o'])) {
    $o = (int)$_GET['o'];
    $r = (int)$_GET['r'];
    if ($r != 0) $r = 1;
    $rels = array('<', '>');
    $rel = $rels[$r];
    $db->sql = "SELECT id,`order` FROM expiry WHERE id='$o'";
    $db->query();
    $c = mysql_fetch_row($db->rs);
    $db->sql = "SELECT id,`order` FROM expiry
                WHERE `order`$rel'" . $c[1] . "'
                ORDER BY `order` " . ($rel == '<' ? 'DESC' : 'ASC') . "
                LIMIT 1";
    $db->query();
    if (mysql_num_rows($db->rs) == 1) {
        $n = mysql_fetch_row($db->rs);
        $db->sql = "UPDATE expiry SET `order`='" . $c[1] . "' WHERE id='" . $n[0] . "'";
        $db->query();
        $db->sql = "UPDATE expiry SET `order`='" . $n[1] . "' WHERE id='" . $c[0] . "'";
        $db->query();
    }
}
#/sortable#

$tct = Expiry::count(); //total count
$rpp = 10; 				//row per page

$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct, 'excludeVars' => array( 'o', 'r', 'd', 't', 'e' ) );
$pager = @Pager::factory($pager_options);
list($from, $to) = $pager->getOffsetByPageId();

$expiries = Expiry::get_all( array(), '', ( $from - 1 ) . ", $rpp" );

include ("page-header.php"); 

?>

<div id="wrapper">
	
	<?php include( "page-left.php" ); ?>

	<div id="content">

		<a name="table"></a>

		<?php if( $tct > $rpp ) echo $pager->links . '<br /><br />'; ?>
		
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Period (days)</th>
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				if( $tct < 1 ) print "<tr><td colspan='4'>No records.</td></tr>";
				foreach( $expiries as $row ) {
				?>
					<tr>
						<?php
							print "<td>" . $row['id'] . "</td>";
							print "<td>" . $row['name'] . "</td>";
							print "<td>" . $row['period'] . "</td>";
						?>	
						<td>
							<a href=<?php print 'expiry-edit.php?' . build_query_string( array( 'id' => $row[0] ) ); ?>>Edit</a>		
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . "?d=" . $row[0] . "&t=" . time() . "#table'"; ?> onclick="return confirm ('Are you sure to delete?')">Delete</a>
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . "?o=" . $row[0] . "&r=0&t=" . time() . "#table'"; ?>>Up</a>
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . "?o=" . $row[0] . "&r=1&t=" . time() . "#table'"; ?>>Down</a>
						</td>	
					</tr>
				<?php
				}
				?>
			</tbody>

		</table>
		
		<br />

		<?php echo $pager->links; ?>

		<br />
				
	</div>

</div>

<br />

<?php include ("page-footer.php"); ?>
