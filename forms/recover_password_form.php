<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title> Recover password </title>
		<link href="css/style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
	<div id="header">
	<?php include_once 'header.php';?>
    </div>
	<div id="wrap">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<p>Enter email address for your account.</p>
            <table>
                <tr>
                    <td><input type="text" name="email"/></td>
                    <td><input type="submit" name="recoverPassword" value="Recover password"/></td>
                </tr>

            </table>
            <p><a href="index.php">Return to Login</a></p>
        </form>
	</div>
    </body>
</html>
