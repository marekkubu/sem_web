<?php
require_once('model/login.class.php');
require_once('model/users.class.php');
// Zkusíme se přihlásit
if (isset($_POST['register'])) {
    $newUser = $_POST['reg_user'];
    $users = new Users();
    $users->Connect();
    $add=$users->addUser($newUser['username'],$newUser['password'],$newUser['email']);
    if($add=='ok'){
        Login::log_in($newUser['username'],$newUser['password']);
        header('Refresh: 0');
    }elseif($add=="obsazeno"){
        echo " OBSAZENO";
    }

}