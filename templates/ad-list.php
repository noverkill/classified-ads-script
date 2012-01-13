<?include ('./templates/parts/page-top.php')?>

<?
if($tct < 1):
	$panels = array(array(
		'legend' => 'Information',
		'body'   => "<p class='success'>No result.</p>",
	) );
endif
?>
					
<div id="middle">

	<?include('./templates/parts/ad-search-form.php')?>

	<?include('./templates/parts/panels.php')?>

	<?include('./templates/parts/ad-list.php')?>

	<br />

</div>

<?include('./templates/parts/page-right.php')?>

<script type="text/javascript">window.onload = lform('form_search_fields')</script>	
	
<?include('./templates/parts/page-footer.php')?>
