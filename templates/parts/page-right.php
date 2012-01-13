<div id="right">
	
	<div>
			
		<?if(! User::is_logged_in()):?>

			<p>Login</p> 
						
			<form name='form_user_login' id='form_user_login' action='user-login.php' method='post' enctype='application/x-www-form-urlencoded' accept-charset="utf-8">
					
				<p>
					<label>Username(or email)</label><br />
					<input type='text' name="username" value='' />
				</p>
										
				<p>
					<label>Password</label><br />
					<input type='password' name="password" value='' />
				</p>
																												
				<p>
					<input type='submit' name="login" value='Login' />
				</p>
																												
				<p>
					<a href='user-lost-password.php'>Lost password</a>
				</p>
			
				<?
					
				$login_errors = User::login_errors();
				
				if(count($login_errors)> 0): 
				
				?>

					<hr />
				
					<?foreach($login_errors as $login_error):?>
						
						<p class='error'><?=$login_error?></p>
					
					<?endforeach?>
				
				<?endif?>     

			</form>
						
		<?else:?>
			
			<p>Welcome</p>
			
			<p><?=User::get_username()?></p>
			
			<p><a href='ad-list.php?in_email=1&amp;description=<?=User::get_email()?>'>My Ads</a></p>
			
			<p><a href='user-favourites.php'>Favourites</a></p>
			
			<p><a href='user-profile.php'>Profile</a></p>
			
			<p><a href='user-new-password.php'>New password</a></p>
			
			<p><a href='user-login.php?logout'>Logout</a></p>
		
		<?endif?>
				
	</div>

	<?if(! User::is_logged_in()):?>
		
		<p><a href='user-registration.php'>Registration</a></p>
	
	<?endif?>

	<br />
	
	<div>	
		<p>Counters</p>
		<p><a href="ad-list.php?list=fresh">Fresh <span class="count"><?=$ct_fresh?></span></a></p>
		<p><a href="ad-list.php?list=all">All <span class="count"><?=$ct_all?></span></a></p>
		<p><a href="ad-list.php?list=expirys">Expiries <span class="count"><?=$ct_expirys?></span></a></p>
	</div>	

	<br />
	
	<p>
		<a href="http://validator.w3.org/check?uri=referer" target="_blank">
			<img src="./images/valid-xhtml10.png" alt="Valid XHTML 1.0 Transitional" />
		</a>
	</p>
		
	<p>
		<a href="http://jigsaw.w3.org/css-validator/validator?uri=<?=$site_url?>&amp;profile=css3" target="_blank">
			<img src="./images/vcss-blue.gif" alt="Valid CSS!" />
		</a>
	</p>

</div>
		 
<div class="clearfooter"></div>
