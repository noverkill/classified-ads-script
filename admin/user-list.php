<?php

include("./include/common.php");
include ("Pager/Pager.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_GET['d'])) {
    $d = (int)$_GET['d'];
    if ($d > 1) {
        User::delete( $d );
    }
}

$tct = User::count();	//total count
$rpp = 10; 				//row per page

$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct, 'excludeVars' => array( 'o', 'r', 'd', 't', 'e' ) );
$pager = @Pager::factory($pager_options);
list($from, $to) = $pager->getOffsetByPageId();

$users = User::get_all( array(), 'id>1', ( $from - 1 ) . ", $rpp" );

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
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Created</th>
					<th>Active</th>
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				if ($tct < 1) print "<tr><td colspan='10'>No records.</td></tr>";
				foreach( $users as $row ) {
				?>
					<tr>
						<?php
							print "<td>" . $row['id'] . "</td>";
							print "<td>" . $row['name'] . "</td>";
							print "<td>" . $row['username'] . "</td>";
							print "<td>" . $row['email'] . "</td>";
							print "<td>" . $row['createdon'] . "</td>";
							print "<td>" . $row['active'] . "</td>";
						?>	
						<td>
							<a href=<?php print 'user-edit.php?' . build_query_string( array( 'id' => $row[0] ) ); ?>>Edit</a>
							<a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'd' => $row[0], 't' => time() ) ) . "#table'"; ?> onclick="return confirm ('Are you sure to delete?')">Delete</a>
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
