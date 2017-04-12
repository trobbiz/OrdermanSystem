<?php
    error_reporting(E_ALL);  // 2 Befehle sodass alle fehlermeldungen angezeigt werden

    ini_set('display_errors', 1); 
?>
<html>
    <head>
    </head>
    <body>
        <form method="post" action="menu.php">
            <legend>Bitte loggen Sie sich ein:</legend>
            <input type="text" placeholder="Username" name="user" required><br><br>
            <input type="password" placeholder="Password" name="pwd" required><hr>
            <input type="submit" value="Login">
            <input type="button" onclick="window.location.href='http://ubuntuserver16/~stleitob/Transaktion/mitarbeiterLogin.php'" value="Als Mitarbeiter anmelden">
        </form>
    </body>
</html>