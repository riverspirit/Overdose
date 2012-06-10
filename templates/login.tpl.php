<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login to manage Intellwiz</title>
    </head>
    <body>
        <div><?php Utils::show_message('login'); ?></div>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" name="loginForm">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" /></td>
            </tr>
            <tr>
                <td>
                    <?php if (isset($_GET['return'])) { ?>
                    <input type="hidden" name="return" value="<?php echo $_GET['return']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="action" value="loginSubmit" />
                    <input type="submit" name="Login" value="Login" />
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>
