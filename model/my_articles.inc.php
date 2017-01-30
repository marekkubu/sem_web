<?php
require_once('model/login.class.php');
require_once('model/article.class.php');
require_once('model/db_pdo.class.php');



if (Login::isLog()) {
    $articles_db = new article();
    $articles_db->Connect();

    if (isset($_POST['removeArticle'])) {
            // Smažu článek z databáze
            $articles_db->removeArticle($_POST['articleID']);
        }

    if (isset($_POST['editArticle'])) {
        include_once ("view/obsah_inc/articleEdit.inc.php");

    }
    if (isset($_POST['saveChange'])) {
        $charticle = $_POST['articleTitle'];

        $idArticle = $_POST["articleIDchange"];

        // Pokud jsem nevybral nové PDF zůstane v databázi to staré
        if (isset($_POST['userfile'])) {
            $file = $_POST['userfile'];
        }
        else {
            $file = $article['file'];
        }
        // Ošetření vstupů proti XSS
        $title = addslashes($_POST['articleTitle']);
        $abstract = addslashes($_POST['articleAbstract']);
        date_default_timezone_set("Europe/Prague");
        $dateTime = date("Y-m-d G:i:s");

        // Provedu Update clanku

        $articles_db->updateArticle($idArticle,$title,$abstract,$dateTime,$file);

    }

    echo "
            <div class='container'>
              <h2>Moje články</h2>
              <div class='table-responsive'>
              <table class='table'>
                <thead >
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Popis</th>
                    <th>Autor</th>
                    <th>Recenze</th>
                    <th>Ohodnocení </th>
                    <th>Stav </th>
                  </tr>
                </thead>
                <tbody>";

                    // Číslování řádek
                    $index = 0;
                    // Načteme články daného uživatele
                    $userID=$_SESSION[USER]['ID'];
                    $articles = $articles_db->loadArticleUserID($userID);

                    // Vypíšeme články do tabulky
                    foreach ($articles as $article) {
                        $index++;
                        echo "<tr>";
                        echo "<form class='form-horizontal' method = 'post'>";
                        echo "<td>" . $index . "</td>";
                        echo "<td>" . $article['title'] . "</td>";
                        echo "<td>" . $article['abstract'] . "</td>";
                        echo "<td>" . $article['User_idUser'] . "</td>";
                        echo "<td>" . "trust" . "</td>";
                        echo "<td>" . "ohodnoceni" . "</td>";
                        echo "<td>" . $article['opinion'] . "</td>";

                        echo "<input type='hidden' class='form-control' name = 'articleID' value = '" . $article['idArticle'] . "'>";
                        echo "<td><button type='submit' id='editBTN' class='btn btn-warning' name = 'editArticle' onclick=\"document.getElementById('edit').style.display='block'\">Upravit</button></td>";
                        echo "<td><button type='submit' class='btn btn-danger' name = 'removeArticle'>Odstranit</button></td>";
                        echo "</form>";
                        echo "</tr>";
                    }


        echo "
                </tbody>
              </table>
              </div>
            </div>
            ";


}
else{
    echo "Nejste prihlasen tady nemate co delat!";
}
?>

