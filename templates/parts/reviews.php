<div id="review">
	<h4>Reviews:</h4>
	<?php if(count($reviews)<1): ?>
		<td>No reviews yet.</td>
	<?php else: ?>
		<?php foreach($reviews as $rev): ?>		
			<div class="rev">
				<div>Rate: <?=$rev['rate']?> from 5 by <a href="user-view.php?id=<?=$rev['user_id']?>"><?=$rev['username']?></a></div>
				<?php if($rev['comment']!=''):?><div class="rev-comment"><?=$rev['comment']?></div><?php endif ?>
			</div>
			<br />
		<?php endforeach ?>
	<?php endif ?>
</div>
