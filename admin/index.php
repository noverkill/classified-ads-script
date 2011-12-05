<?php 

include( "./include/common.php");

if( isset( $_POST['login'] ) ) {
	
    $p_username = trim( strip_tags( $_POST['username']));
    $p_password = trim( strip_tags( $_POST['password']));
       
    $success = true;
    $errors = array();    
    
    if( $p_username == '' ) {
        $success = false;
        array_push( $errors, 'Please enter your username or email.' );
    }

    if( $p_password == '' ) {
        $success = false;
        array_push( $errors, 'Please enter your password.' );
    }
	                  
    if( $success ) {
		 if( ! User::login( $p_username, $p_password) ) {
			 $success = false;
			 array_push( $errors, 'Incorrect username or password.' );
		 } else {
			header( 'Location: index.php' );
			exit();
		}
	}
}

if( isset( $_GET['logout'])) {
	session_destroy();
	header( 'Location: index.php' );
	exit();
}

include ("page-header.php");

?>

<div id="wrapper">

	<?php if( ! ( User::is_logged_in() || User::get_id() == 1 ) ) { ?>

		<form name="form_login" id="form_login" method="post" enctype='application/x-www-form-urlencoded' accept-charset="UTF-8" class="form">

			<h2>Login</h2>

			<br />

			<?php
			if( isset( $success ) && ! $success ) {
				print "<ul class='errors'>";
				foreach( $errors as $err ) print "<li>$err</li>";
				print "</ul>";
			}
			?>

			<label>Username</label>
			<input type='text' name="username" value='<?php if( isset( $p_username ) && ! $success ) print $p_username; ?>' />
			<br />
													
			<label>Password</label>
			<input type='password' name="password" value='<?php if( isset( $p_password ) && ! $success ) print $p_password; ?>' />
			<br />
			
			<label>&nbsp;</label>
			<a href='user-lost-password.php'>Lost password</a>																												
			<br />
					
			<label for="login"></label>
			<input type="submit" name="login" value="Login"/>

		</form>
					
	<?php } else { ?>
		
		<?php include( "page-left.php" ); ?>

		<div id="content">		

			<p>&nbsp;</p>
			
		</div>

	<?php } ?>
	
</div>

<br />

<?php include ("page-footer.php"); ?>
