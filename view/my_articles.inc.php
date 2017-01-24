<?php

include_once("view/obsah_inc/moje_prispevky.inc.twig")

include_once("settings_db.inc.php");
include_once("model/db_pdo.class.php");
include_once("functions.inc.php");
include_once("model/users.class.php");
include_once("model/login.class.php");
include_once("model/article.class.php");
include_once("controller/login.inc.php");

if (Login::isLog()) {
    echo"JSEM TU";

$articles_db = new Articles();
        $articles_db->SetPDOConnection($connection);;
}

else{
    header("Location: /WWW");
}
