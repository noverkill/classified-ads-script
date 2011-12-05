<?php

include("./include/common.php");
include ("Pager/Pager.php");

if ( ! User::is_logged_in() || User::get_id() != 1) {
	header( 'Location: index.php' );
	exit();
}

if (isset($_GET['d'])) {
    $d = (int)$_GET['d'];
    if ($d > 4) StaticContent::delete( $d );  
}

$tct = StaticContent::count(); 	//total count
$rpp = 10; 						//row per page

$pager_options = array('mode' => 'Sliding', 'perPage' => $rpp, 'delta' => 2, 'totalItems' => $tct, 'excludeVars' => array( 'o', 'r', 'd', 't', 'e' ) );
$pager = @Pager::factory($pager_options);
list($from, $to) = $pager->getOffsetByPageId();

$statics = StaticContent::get_all( array(), '', ( $from - 1 ) . ", $rpp" );

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
					<th>Title</th>
					<th>Slug</th>
					<th>Operations</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				if ($tct < 1) print "<tr><td colspan='4'>No records.</td></tr>";
				foreach( $statics as $row ) {
				?>
					<tr>
						<?php
							print "<td>" . $row['id'] . "</td>";
							print "<td>" . $row['title'] . "</td>";
							print "<td>" . $row['slug'] . "</td>";
						?>	
						<td>
							<a href=<?php print 'static-content-edit.php?' . build_query_string( array( 'id' => $row[0] ) ); ?>>Edit</a>		
							<?php if( $row[0] > 4 ) { ?><a href=<?php print "'" . $_SERVER['SCRIPT_NAME'] . "?d=" . $row[0] . "&t=" . time() . "#table'"; ?> onclick="return confirm ('Are you sure to delete?')">Delete</a><?php } ?>
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
