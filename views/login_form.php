<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title> Login </title>
        <meta charset="utf-8"/>
    </head>
    <body>
        
    <?php include_once 'header.php';?>

	<div id="wrap">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<table>
				<tr>
					<td align="right"><label for="username">Username</label></td>
					<td><input type="text" name="username" /></td>
				</tr>
				<tr>
					<td align="right"><label for="password">Password</label></td>
					<td><input type="text" name="password" /></td>
				</tr>
			</table>
			<input type="submit" class="submit_button" value="Login" name="login"/>
        </form>  
        <!--Remember me<input type="checkbox" name="rememberMe" value="rememberMe"/>-->
        <p><a href="register.php">Register</a></p>
        <p><a href="lost_password.php">Lost password?</a></p>
	
	</div>
    </body>
</html>