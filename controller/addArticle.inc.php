<?php
require_once('model/login.class.php');
require_once('model/article.class.php');
// Zkusíme se přihlásit
if (Login::isLog() && $page =="prispevky" ){
include_once("view/obsah_inc/addArticleForm.inc.twig");
$valid = true;
$add = false;
// Pokud je zaslán formulář s novým článkem
if (isset($_POST['upload'])) {


    $userdata = $_POST['userdata'];

    // Pokud je něco nevplněné, musí to uživatel napravit
    if ($userdata['name'] == "" || $userdata['abstract'] == "" || $_FILES['userfile']['tmp_name'] == "") {
        $valid = false;

        echo "<div class='alert alert-warning'>  <strong>Pozor!</strong> Zkontolujte, zda máte vyplněny všechny informace a správně zvolenou cestu k PDF souboru!</div>";
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
        if ($add==true){
            echo "<div class='alert alert-success'>  <strong>Nahráno!</strong> Nahrávání přispěvku proběhlo vpořádku!</div>";
        }
        else {
            echo "<div class='alert alert-danger'>  <strong>Chyba!</strong> Nepodařilo se nahrát příspěvek!</div>";
            }
        }
    }
}


