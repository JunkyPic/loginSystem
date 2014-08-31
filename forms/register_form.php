<!DOCTYPE html>
<html>
<!--Yes, yes, using tables is so last 10 years. HTML is not the purpose here. PHP is.-->
    <head>
        <title> Register </title>
    </head>
    <body>
        <form action="register.php" method="post">
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username"/>
                </tr>
                <tr>
                    <td>Password</td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="password"/>
                </tr>
                <tr>
                    <td>Repeat Password</td>
                    <!-- the type of this is text for testing purposes. It should be password -->
                    <td><input type="text" name="passwordAgain"/>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email"/>
                </tr>
                <tr>
                    <td><input type="submit" name="register" value="Register"/>
                </tr>
            </table>
            <p><a href="index.php">Login</a></p>
        </form>
    </body>
</html>
