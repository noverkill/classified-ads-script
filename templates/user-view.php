<?include('./templates/layout/page-top.php')?>

<?

$panels = array(); 
	
if($exists):	

	$fields = array(
		array('name'     ,'Name'),
		array('telephone','Phone'),
		array('city'     ,'City'),
		array('webpage'  ,'Webpage'),
		array('createdon','Member since')
	);

	$row = array();

	foreach($fields as $field):
		if($user[$field[0]]!='') $row[] = array('title'=>$field[1],'value'=>$user[$field[0]]);
	endforeach;

endif;
?>
							
<div id="middle">

	<?if($exists):?>

		<div id='ad-view'>
			
			<p>Profile page of <h3><?=$user['username']?></h3></p>
			
			<div class='ad-data'>
				
				<div class="fleft">

					<table>	
						<?foreach ($row as $r):?>
						<tr>
							<td><?=$r['title']?></td>
							<td><?=$r['value']?></td>
						</tr>
						<?endforeach?>
					</table>
					
					<br />
					
					<div class="usertools">	
						<a href="user-review.php?id=<?=$user['id']?>">Review this user</a>
						<a href="ad-list.php?in_email=1&description=<?=$user['email']?>">User's ads</a>
					</div>
							
				</div>
							
			</div><!-- end of user-data -->
						
		</div><!-- end of user-view -->

		<br class="clear" />

		<?php include('./templates/parts/reviews.php') ?>
		
					
	<?else:
			
		$panels = array(array(
			'legend' => 'Error',
			'body'   => "<ul class='errors'>The requested user is inactive or not exist.</ul>",
		) );
		
		include('./templates/parts/panels.php');
		
	endif?>
		
	<br />

</div>


<?include('./templates/layout/page-right.php')?>

<?include('./templates/layout/page-footer.php')?>
