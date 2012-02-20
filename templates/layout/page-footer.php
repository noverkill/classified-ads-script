
<?if(isset($pager)):?>
	
	<div id="pager"><?echo $pager->links?></div></div>
	
<?endif?>

<hr />
		
<div id="footer">
	
	<p>
		<?
		$sep = ''; 
		foreach($statics as $static):
			print "$sep<a href='static-content.php?slug=" . $static['slug'] . "'>" . $static['title'] . "</a>";
			$sep = " &nbsp; | &nbsp; "; 
		endforeach?>
	</p>
	
	<p>&copy;2004-<?=date('Y')?> <a href="<?=$site_url?>"><?=$site_title?></a></p> 
	
</div>
		
</body>

</html>
