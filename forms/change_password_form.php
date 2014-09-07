<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title> Simple Login System </title>
        <meta charset="utf-8"/>
    </head>
    <body>
    
     <?php include_once 'header.php';?>
     
	<div id="wrap">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr> 
                    <td align="right"><label for="CurrentPassword">Current Password</label></td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordCurrent"/></td>
                </tr>
                <tr>
                    <td align="right"><label for="NewPassword">New Password</label></td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordNew"/></td>
                </tr>
                <tr>
                    <td align="right"><label for="RepeatPassword">Repeat Password</label></td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordNewAgain"/></td>
                </tr>
            </table>
					<p><input type="submit" name="resetPassword" value="Change Password"/></p>
        </form>
		<p><a href="index.php">Go to Index</a></p>
		<p>Once the password has been change you'll have to log in again!</p>
	</div>
    </body>
</html>