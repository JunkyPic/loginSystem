<!DOCTYPE html>
<html>
<!--Yes, yes, using tables is so last 10 years. HTML is not the purpose here. PHP is.-->
    <head>
        <title> Login </title>
    </head>
    <body>
        <form action="index.php" method="post">
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username"/></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="password"/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="login" value="Login"/></td>
                </tr>
            </table>
            <!--Remember me<input type="checkbox" name="rememberMe" value="rememberMe"/>-->
        </form>
        <p><a href="register.php">Register</a></p>
        <p><a href="lost_password.php">Lost password?</a></p>
    </body>
</html>
