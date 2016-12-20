<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 12. 12. 2016
 * Time: 19:48
 */

// nacteni souboru
include_once("settings_db.inc.php");
include_once("db_pdo.class.php");
//include_once("uzivatele.class.php");
include_once("functions.inc.php");
include_once("controller/users.class.php");
include_once("controller/login.class.php");
include_once("model/login.inc.php");
include_once("model/logout.inc.php");


$action = @$_POST["action"]."";
$user = @$_POST["user"];
$username=@$_POST["username"];
$userPW=@$_POST["password"];
printr($username);
printr($userPW);

// vytvoreni objektu
$users = new Users();
$users->Connect();
//$users->addUser("Marek","passw","emailsd.sda");
$array_users = $users->LoadAllUsers();
// printr($seznam_predmetu);
if ($array_users != null)
    foreach ($array_users as $user)
    {
        echo  "zkratka: $user[username], nazev: $user[password] <br/>";
    }
$parm=$username;
/*
if ($users->userExists($parm)==true){
    echo "Prihlasenz uyivatel existuje:  $parm ";
}
else echo "$parm neexistuje";*/
//Login::log_in("admin","heslo");
//Login::log_out();


//$users->addUser("Ivan","hesloheslo","ivan@gmail.com");


//MVC
function autoloader($class) {
    $fileCont = 'controller/' . $class . '.php';
    $fileView = 'view/' . $class . '.php';
    $fileModel = 'model/' . $class . '.php';

    if(file_exists($fileCont)){
        require_once $fileCont;
    }else if(file_exists($fileView)){
        require_once $fileView;
    }else if(file_exists($fileModel)){
        require_once $fileModel;
    }

}