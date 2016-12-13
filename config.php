<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 12. 12. 2016
 * Time: 19:48
 */
//SESSION
session_start();

// nacteni souboru
include_once("settings_db.inc.php");
include_once("db_pdo.class.php");
include_once("uzivatele.class.php");
include_once("functions.inc.php");

$key_my_user = "username";
if (isset($_SESSION[$key_my_user]))
{
    // muzu provest
}
else $_SESSION[$key_my_user] = array();
$prihlasen = false;
if (isset($_SESSION[$key_my_user]["login"]))
    $prihlasen = true;
//printr($_POST);

$action = @$_POST["action"]."";
$user = @$_POST["user"];
$username=@$_POST["username"];
printr($username);
if ($action == "login_go")
{
    echo "uzivatel: ";
    printr($user);
    if (trim($user["login"]) == "admin" && trim($user["heslo"]) == "heslo")
    {
        $_SESSION[$key_my_user]["login"] = $user["login"];
        printr($key_my_user);
        $prihlasen = true;
    }
}
if ($action == "login_out")
{
    $prihlasen = false;
    echo"JUPI";
}

// konec prihlasovani
if ($prihlasen)
{
    echo "<h1>Přihlášený uživatel</h1>";
    echo "<form method=\"post\">
                    <input type='hidden' name='action' value='login_out'/>
                    <input type='submit' value='Odhlásit'>
                </form>";
}
else
{
    echo "<h1>Nepřihlášený uživatel</h1>";
    echo "<form method=\"post\">
                    <input type='hidden' name='action' value='login_go'/>
                    Login: <input type='text' name='user[login]'/>
                    Username: <input type='text' name='username2'/>
                    Heslo: <input type='text' name='user[heslo]'/>
                    <input type='submit' value='Přihlásit'>
                </form>";
}
// vytvoreni objektu
$users = new uzivatele();
$users->Connect();
//$users->addUser("ivan","hesloheslo","Mail");
$array_users = $users->LoadAllUsers();
// printr($seznam_predmetu);
if ($array_users != null)
    foreach ($array_users as $user)
    {
        echo  "zkratka: $user[username], nazev: $user[password] <br/>";
    }
$parm="karel";
if ($users->userExists($parm));
    echo "Je to taaaam:  $parm ";

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