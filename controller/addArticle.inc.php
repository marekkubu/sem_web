<?php
require_once('model/login.class.php');
require_once('model/article.class.php');
// Zkusíme se přihlásit
if (Login::isLog() && $page =="prispevky" ){/*
    include_once("view/obsah_inc/addArticleForm.inc.twig");
    if (isset($_POST['upload'])) {
        $title=$_POST['title'];
        $abstract=$_POST['abstract'];
       // $file=$_POST['fileToUpload'];
        $tmpName = $_FILES['userfile']['tmp_name'];

        $fileOpen = fopen($tmpName, 'r');
        $file = fread($fileOpen, filesize($tmpName));
        fclose($fileOpen);

        date_default_timezone_set("Europe/Prague");
        $dateTime = date("Y-m-d G:i:s");
        echo $title, " ", $abstract," ", $tmpName," ", $dateTime;
        $article = new Article();
        $userId=$_SESSION[USER]['ID'];
        //echo $userId;
        $article ->addArticle($title,$abstract,$dateTime,$userId,$file);
        echo "Upload!";
    }*/
include_once("view/obsah_inc/addArticleForm.inc.twig");
$valid = true;
$add = false;
// Pokud je zaslán formulář s novým článkem
if (isset($_POST['upload'])) {


    $userdata = $_POST['userdata'];

    // Pokud je něco nevplněné, musí to uživatel napravit
    if ($userdata['name'] == "" || $userdata['abstract'] == "" || $_FILES['userfile']['tmp_name'] == "") {
        $valid = false;
    }
    // Uložím nový článek
    else {
        $tmpName = $_FILES['userfile']['tmp_name'];
        $file = fopen($tmpName, 'r');
        $content = fread($file, filesize($tmpName));
        fclose($file);

        // Ošetříme vstup proti XSS
        //$content = addslashes($content);
        $abstract = addslashes($userdata['abstract']);
        $name = addslashes($userdata['name']);

        // Připojení k databázi a uložení nového článku
        $articles_db = new Article();
        $articles_db->Connect();

        $userID=$_SESSION[USER]['ID'];
        date_default_timezone_set("Europe/Prague");
        $dateTime = date("Y-m-d G:i:s");
        $articles_db->addArticle($name, $abstract, $dateTime, $userID, $content);

        $add = true;
    }
}

}
/*
if (isset($_POST['register'])) {
    $newUser = $_POST['reg_user'];
    $users = new Users();
    $users->Connect();
    $add=$users->addUser($newUser['username'],$newUser['password'],$newUser['email'],"viewer");
    if($add=='ok'){
        Login::log_in($newUser['username'],$newUser['password']);
        header('Refresh: 0');
    }elseif($add=="obsazeno"){
        echo " OBSAZENO!";
    }

}*/
