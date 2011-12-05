			
<div id='menu'>
	
<?php 


if ( User::is_logged_in() && User::get_id() == 1) { 

	foreach( $menu as $name => $funcs) { 	
		?>
			<ul class='first-level'>
				<li><a href='<?php print $funcs[reset((array_keys($funcs)))]; ?>'title='<?php print $name; ?>'><?php print $name; ?></a></li>
				<ul class='second-level <?php print $current_group_page['name'] != '' && strpos( $name, $current_group_page['name'] ) === 0 ? 'show' : 'hide'; ?>'>
					<?php foreach( $funcs as $name => $href ) { ?>
						<li><a <?php print "href='$href' title='$name'" . ( $href == $current_script_name ? "class='menu-item-selected'" : '' ) . ">$name"; ?></a></li>
					<?php  } ?>
				</ul>
			</ul>		
		<?php
	}
}

?>

</div>


<!--		
<ul class='first-level'>
	<li><a href='index.php' title='dashboard'>Dashboard</a></li>
</ul>
<ul class='first-level'>
	<li><a href='ad_list.php' title='ad'>Ads</a></li>
	<ul class='second-level'>
		<li><a href='ad_create.php' title='ad-create'>Create</a></li>
		<li><a href='ad_list.php' title='ad-list'>List</a></li>
	</ul>
</ul>
<ul class='first-level'>
	<li><a href='region_list.php' title='regions'>Regions</a></li>
	<ul class='second-level'>
		<li><a href='region_create.php' title='region-create'>Create</a></li>
		<li><a href='region_list.php' title='region-list'>List</a></li>
	</ul>
</ul>
<ul class='first-level'>
	<li><a href='category_list.php' title='categories'>Categories</a></li>
	<ul class='second-level'>
		<li><a href='category_create.php' title='categories-create'>Create</a></li>
		<li><a href='category_list.php' title='categories-list'>List</a></li>
	</ul>
</ul>
<ul class='first-level'>
	<li><a href='expiry_list.php' title='expiries'>Expiries</a></li>
	<ul class='second-level'>
		<li><a href='expiry_create.php' title='expiry-create'>Create</a></li>
		<li><a href='expiry_list.php' title='expiry-list'>List</a></li>
	</ul>
</ul>
<ul class='first-level'>
	<li><a href='static_list.php' title='static-contents'>Static Contents</a></li>
	<ul class='second-level'>
		<li><a href='static_create.php' title='static-contents-create'>Create</a></li>
		<li><a href='static_list.php' title='static-contents-list'>List</a></li>
	</ul>
</ul>
<ul class='first-level'>
	<li><a href='user_list.php' title='users'>Users</a></li>
	<ul class='second-level'>
		<li><a href='user_create.php' title='users-create'>Create</a></li>
		<li><a href='user_list.php' title='users-list'>List</a></li>
	</ul>
</ul>
<ul class='first-level'>
<li><a href='user-profile.php' title='setting-profile'>Settings</a></li>
<ul class='second-level'>
	<li><a href='user-profile.php' title='setting-profile'>My Profile</a></li>
	<li><a href='user-change-password.php' title='setting-password'>Change Password</a></li>
</ul>
-->
