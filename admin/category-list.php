<?php

include("./include/common.php");
include ("Pager/Pager.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

$parent = isset( $_GET['parent'] ) ? (int) $_GET['parent'] : 0;

if (isset($_GET['d'])) {	
    $d = (int)$_GET['d'];
    if ($d > 0) {
        Category::delete( $d );
    }
}

if (isset($_GET['o'])) {	
	$o = (int)$_GET['o'];
	$r = (int)$_GET['r'];
	if ($r != 0) $r = 1;
	Category::set_order( $o, $parent, $r );
}

$tct = Category::count( array( 'parent' => $parent ) );	//total count
$rpp = 10; 												//row per page

$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct, 'urlVar' => "pageID$parent", 'excludeVars' => array( 'o', 'r', 'd', 't', 'e' ) );
$pager = @Pager::factory($pager_options);
list($from, $to) = $pager->getOffsetByPageId();

$categories = Category::get_all( array( 'r.parent' => $parent ), '', ( $from - 1 ) . ", $rpp" );

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
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				if( $tct < 1) print "<tr><td colspan='3'>No records.</td></tr>";
				foreach( $categories as $row ) {
				?>
				<tr>
					<?php
						print "<td>" . $row['id'] . "</td>";
						print "<td>" . $row['name'] . "</td>";
					?>	
					<td>
						<a href=<?php print 'category-edit.php?' . build_query_string( array( 'id' => $row[0] ) ); ?>>Edit</a>		
						<?php print "<a href='" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'd' => $row[0], 't' => time() ) ) . "#table' onclick='return confirm (\"Are you sure to delete?\")'>Delete</a>"; ?>
						<?php print "<a href='" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'o' => $row[0], 'r' => 0, 't' => time() ) ) . "#table'>Up</a>"; ?>
						<?php print "<a href='" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'o' => $row[0], 'r' => 1, 't' => time() ) ) . "#table'>Down</a>"; ?>
						<?php if( $row['parent'] == 0 ) print "<a href='" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'parent' => $row['id'] ) ) . "#table'>Subcategories(" . $row['childcount'] . ")</a>"; ?>
					</td>	
				</tr>
				<?php
				}
				?>
			</tbody>

		</table>
				
		<?php if( $parent > 0 ) print "<br /><a class='up-one-level' href='" . $_SERVER['SCRIPT_NAME'] . '?' . build_query_string( array( 'parent' => 0, 't' => time(), 'o' => -1, 'r' => -1, 'd' => -1, "pageID$parent" => -1 ) ) . "'>Up</a><br />"; ?>

		<br />
		
		<?php echo $pager->links; ?>

		<br />
					
	</div>

</div>

<br />

<?php include ("page-footer.php"); ?>
