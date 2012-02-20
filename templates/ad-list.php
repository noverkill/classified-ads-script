<?include ('./templates/layout/page-top.php')?>

<?
if($tct < 1):
	$panels = array(array(
		'legend' => 'Information',
		'body'   => "<p class='success'>No result.</p>",
	) );
endif
?>
					
<div id="middle">

	<?include('./templates/forms/ad-search-form.php')?>

	<?include('./templates/parts/panels.php')?>

	<?include('./templates/parts/ad-list.php')?>

	<br />

</div>

<?include('./templates/layout/page-right.php')?>

<script type="text/javascript">window.onload = lform('form_search_fields')</script>	
	
<?include('./templates/layout/page-footer.php')?>
