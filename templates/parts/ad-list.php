<?if(isset($ads) && is_array($ads) && count($ads)>0):?>

	<?foreach($ads as $row):?>
	 
		<?$qry = build_query_string(array('id'=>$row['id']))?>
		
		<div class="ad-panel">		
			<a class='picture' title="<?=$row['title']?>" href="ad.php?<?=$qry?>" name="<?=$row['id']?>">
				<img alt="<?=$row['title']?>" src="<?=$row['thumb']?>" />
			</a>
			<div class="details">
				<h3 class='subject'><a href="ad.php?<?=$qry?>"><?=$row['title']?></a></h3>
				<p><?=substr( $row['description'], 0, 150)?> <a href="ad.php?<?=$qry?>">[...]</a></p>
				<p><?php if ($row['price'] != '') print str_to_currency($row['price'])?></p>		
				<p><a href="ad.php?<?=$qry?>">More &gt;&gt;</a></p>	
			</div>
		</div>
		
		<br class='clear' />	
		
		<hr class='separator' />	
		
	<?endforeach?>
	
<?endif?>
