<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title> Register </title>
		<link href="css/style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
	<div id="header">
        <h3>Register</h3>
    </div>
	<div id="wrap">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<table>
			<tr>
				<td align="right"><label for="username">Username:</label></td>
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<td align="right"><label for="password">Password:</label></td>
				<td><input type="text" name="password" /></td>
			</tr>
			<tr>
				<td align="right"><label for="passwordAgain">Repeat Password:</label></td>
				<td><input type="text" name="passwordAgain" /></td>
			</tr>
			<tr>
				<td align="right"><label for="email">Email:</label></td>
				<td><input type="text" name="email" /></td>
			</tr>
		</table>
			<p><input type="submit" class="submit_button" value="Register" name="register"/></p>
        </form>

        <p><a href="index.php">Login</a></p>
	</div>
    </body>
</html>