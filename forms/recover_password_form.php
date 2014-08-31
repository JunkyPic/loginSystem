<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<!--Yes, yes, using tables is so last 10 years. HTML is not the purpose here. PHP is.-->
    <head>
        <title> Recover password </title>
		<link href="css/style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
	<div id="header">
        <h3>Please enter email address</h3>
    </div>
	<div id="wrap">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td><input type="text" name="email"/>
                    <td><input type="submit" name="recoverPassword" value="Recover password"/>
                </tr>
            </table>
            <p><a href="index.php">Login</a></p>
        </form>
	</div>
    </body>
</html>
