
<? if (isset( $pager)) { ?>
	
	<div id="pager"><?php echo $pager->links; ?></div></div>
	
<? } ?>

<hr />
		
<div id="footer">
	
	<p>
		<?php
		$sep = ''; 
		foreach( $statics as $static ) {
			print "$sep<a href='static-content.php?slug=" . $static['slug'] . "'>" . $static['title'] . "</a>";
			$sep = " &nbsp; | &nbsp; "; 
		} ?>
	</p>
	
	<p>&copy;2004-<?php print date('Y') ?> <a href="<?php print $site_url; ?>"><?php print $site_title; ?></a></p> 
	
</div>
		
</body>

</html>
