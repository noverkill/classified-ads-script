<?php 

if( $exists ) {
	
	$fields = array (
		array ('id'       ,'Id'),
		array ('pricec'   ,'Price'),
		array ('name'     ,'Posted by'),
		array ('emailto'  ,'Email'),
		array ('telephone','Telephone'),
		array ('weblink'  ,'Webpage'),
		array ('postedon' ,'Posted on'),
		array ('expiry'   ,'Expires on')
	);

	$row = array();

	foreach( $fields as $field ) {
		if( $ad[$field[0]] != '' ) {
			$row[] = array( 'title' => $field[1], 'value' => $ad[$field[0]] );
		}
	}
}

include( "page-top.php" ); 

?>

<div id="middle">

<?php if( $exists ) { ?>

	<div id='ad-view'>
		<p>
			<?php if( $ad['sub_region'] == '' ) { ?><a href="ad-list.php?<?php print build_query_string( array( 'region' => $ad['main_region_slug'], 'id' => -1 ) ); ?>"><?php print $ad['main_region']; ?></a> &gt; <?php } ?>
			<?php if( $ad['sub_region'] != '' ) print '<a href="ad-list.php?region=' . build_query_string( array( 'region' => $ad['sub_region_slug'], 'id' => -1 ) ) . '">' . substr( $ad['sub_region'],0,50 ) . '</a> &gt; '; ?>
			<a href="ad-list.php?<?php print build_query_string( array( 'category' => $ad['main_category_slug'], 'id' => -1 ) ); ?>"><?php print $ad['main_category']; ?></a>
			<?php if( $ad['sub_category'] != '' ) print ' &gt <a href="ad-list.php?' . build_query_string( array( 'category' => $ad['sub_category_slug'], 'id' => -1 ) ) . '">' . substr( $ad['sub_category'],0,50 ) . '</a>'; ?>
		</p>
		
		<h3><?php print $ad['title']; ?></h3>
			
		<div class='ad-data'>
			
			<div class='current-picture'>

				<a href="<?php print $ad['picture']; ?>">
					<img src="<?php print $ad['thumb']; ?>" />
					<p>(click on image for original size)</p>
				</a>

			</div>

			<div class='description'>
				
				<?php print nl2br( $ad['description'] ); ?>
				
			</div>
						
		</div>
		
		<div class='ad-data'>
			
			<div class="fleft">

				<table>	
					<?php foreach ($row as $r) { ?>
					<tr>
						<td><?php print $r['title']; ?></td>
						<td><?php print $r['value']; ?></td>
					</tr>
					<?php } ?>
				</table>
		
			</div>
			
			<?php $qry = build_query_string( array( 'id' => $ad['id'] ) ); ?>	
			<div class="usertools">	
				<?php if( ! $is_favourite ) { ?>
					<a href="user-favourites.php?<?php print $qry; ?>">Add to favourites</a>
				<?php } else { ?>
					<a href="user-favourites.php?remove=1&amp;<?php print $qry; ?>">Remove from favourites</a>		
				<?php } ?>
				<a href="ad-sending.php?<?php print $qry; ?>">Send by Email</a>
				<a href="ad-print.php?<?php print $qry; ?>">Print</a>
				<?php if (User::is_logged_in() && (User::get_email() == $ad['email'] || User::get_id() == 1)) { 
					$qry = build_query_string( array( 'id' => $ad['id'], 'code' => $ad['code']  ) );
				?>
					<p>
						<a href="ad-modification.php?<?php print $qry; ?>">Modify</a>
						<a href="ad-extension.php?<?php print $qry; ?>">Extend</a>
						<a onclick="return confirm('Are you sure you want to remove?')" href="ad-removal.php?<?php print $qry; ?>">Remove</a>				
					</p>
				<?php } ?>	
			</div>
						
		</div>
	
	</div>						
					
<?php } else { ?>

	<p class='error'>The requested Ad is inactive or not exist!</p>

<?php } ?>
	
	<br />

</div>

<?php include ("page-right.php"); ?>

<?php include ("page-footer.php"); ?>
