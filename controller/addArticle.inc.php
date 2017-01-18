<?php
require_once('model/login.class.php');
require_once('model/article.class.php');
// Zkusíme se přihlásit
if (Login::isLog() && $page =="prispevky" ){
    include_once("view/obsah_inc/addArticleForm.inc.twig");
    if (isset($_POST['upload'])) {
        $title=$_POST['title'];
        $abstract=$_POST['abstract'];
       // $file=$_POST['fileToUpload'];
        $tmpName = $_FILES['fileToUpload']['tmp_name'];
        date_default_timezone_set("Europe/Prague");
        $dateTime = date("Y-m-d G:i:s");
        echo $title, " ", $abstract," ", $tmpName," ", $dateTime;
        $article = new Article();
        $userId=$_SESSION[USER]['ID'];
        //echo $userId;
        $article ->addArticle($title,$abstract,$dateTime,$userId,$tmpName,"n","pdf");
        echo "Upload!";
    }
}
if (isset($_POST['register'])) {
    $newUser = $_POST['reg_user'];
    $users = new Users();
    $users->Connect();
    $add=$users->addUser($newUser['username'],$newUser['password'],$newUser['email'],"viewer");
    if($add=='ok'){
        Login::log_in($newUser['username'],$newUser['password']);
        header('Refresh: 0');
    }elseif($add=="obsazeno"){
        echo " OBSAZENO";
    }

}