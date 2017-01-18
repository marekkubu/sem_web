<?php
require_once('model/login.class.php');

// Zkusíme se přihlásit
if (isset($_POST['login_out'])) {
    Login::log_out();
    header("Location: /sem_web/");

}