<!DOCTYPE html>
<html>
<!--Yes, yes, using tables is so last 10 years. HTML is not the purpose here. PHP is.-->
    <head>
        <title> Recover Password </title>
    </head>
    <body>
        <form action="lost_password.php" method="post">
            <table>
                <tr>
                    <td>Please enter email address:</td>
                    <td><input type="text" name="email"/>
                    <td><input type="submit" name="recoverPassword" value="Recover password"/>
                </tr>
            </table>
            <p><a href="index.php">Login</a></p>
        </form>
    </body>
</html>
