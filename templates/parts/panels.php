<?if(isset($panels) && is_array($panels) && count($panels)>0):?>

	<?foreach($panels as $panel):?>
		
		<div class="form-panel">

			<fieldset>
				
				<legend><?=$panel['legend']?></legend>
									
				<?=$panel['body']?>         			

			</fieldset>
					
		</div>

	<?endforeach?>
	
<?endif?>
