<!DOCTYPE html>
<html>
    <head>
        <title> Simple Login System </title>
    </head>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td>Current Password</td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordCurrent"/></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordNew"/></td>
                </tr>
                <tr>
                    <td>New Password Again</td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordNewAgain"/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="resetPassword" value="Reset Password"/>
                </tr> 
            </table>
        </form>
    </body>
</html>