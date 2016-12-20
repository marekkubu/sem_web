<?php
require_once('controller/login.class.php');

// Zkusíme se přihlásit
if (isset($_POST['login_out'])) {
    echo "LOGOUT!";

    Login::log_out();
    header("Location: /sem_web/");

}