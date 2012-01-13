<?include('./templates/parts/page-top.php')?>
							
<div id="middle">

	<div id="categories">

		<?

		if(count($categories)< 1) print "Create Categories first!";

		for($i = 0; $i < count($categories); $i++):
				
			if(($i % 3)==0) print "<div class='category-block'>\n";

			$category = $categories[$i];
			
			print "<div class='categs'>\n";

			$href = 'ad-list.php?' .  build_query_string(array('category'=>$category['slug'],'pageID'=>0)); 
				
			print "<p class='main-category'><a href='$href'>".$category['name']."</a></p>\n";
			
			if(isset($category['childs'])):	
				
				foreach($category['childs'] as $sub_category):

					$href = 'ad-list.php?' . build_query_string(array('category'=>$sub_category['slug'],'pageID'=>0)); 
						
					print "<p class='sub-category'><a href='$href'>".$sub_category['name']."</a></p>\n";
				
				endforeach;
			endif;
			
			print "</div>\n";
			
			if(((($i + 1)% 3)==0)||($i==(count($categories)- 1))):
				
				print "</div>\n";
				
				if($i !=(count($categories)- 1)) print "<hr />\n";
			endif; 
		endfor;

		?>

		<br />
		<br />
		
	</div>
		
</div>

<?include('./templates/parts/page-right.php')?>

<?include('./templates/parts/page-footer.php')?>
