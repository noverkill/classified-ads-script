<?php include( "page-top.php"); ?>
							
<div id="middle">

	<div id="regions">

		<?php 

		if( count($regions) < 1) print "Create Regions first!";

		for( $i = 0; $i < count( $regions ); $i++ ) {
				
			if( ($i % 3) == 0 ) print "<div class='category-block'>\n";

			$region = $regions[$i];
			
			print "<div class='categs'>\n";
			
			$href = 'ad-list.php?' . build_query_string( array( 'region' => $region['slug'], 'pageID' => 0) ); 
			
			print "<p class='main-category'><a href='$href'>" . $region['name'] . "</a></p>\n";

			if( isset( $region['childs'] ) ) {
			
				foreach( $region['childs'] as $sub_region ) {

					$href = 'ad-list.php?' . build_query_string( array( 'region' => $sub_region['slug'], 'pageID' => 0) ); 
						
					print "<p class='sub-category'><a href='$href'>".$sub_region['name']."</a></p>\n";
				
				}
			}
			
			print "</div>\n";
			
			if( ( ( ( $i + 1 ) %  3 ) == 0 ) || ( $i == ( count( $regions ) - 1 ) ) ) {
				
				print "</div>\n";
				
				if( $i != count( $regions ) - 1 ) print "<hr />\n";
			} 
		}

		?>
		
		<br />
		<br />

	</div>


</div>

<?php include ("page-right.php"); ?>

<?php include ("page-footer.php"); ?>