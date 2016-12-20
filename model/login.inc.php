<?php
require_once('controller/login.class.php');

// Zkusíme se přihlásit
if (isset($_POST['login_go'])) {
    echo "LOGIN!";

    $user = $_POST['user'];
    Login::log_in($user['username'], $user['password']);
    // Pokud nejsme přihlášeni, bylo zadáno špatné heslo nebo uživ. jméno
    if (!Login::isLog()) {
        echo "<div class = 'error'>Špatné uživatelské jméno nebo heslo!</div>";
    }
    else header('Refresh: 0');
}
