<?php
require_once('settings_db.inc.php');
require_once('model/login.class.php');
require_once('model/db_pdo.class.php');
require_once('model/article.class.php');
require_once('model/review.class.php');
require_once('model/users.class.php');

if(Login::isLog() && Login::getUserInfo("POWERS") == 'reviewer'&& isset($_POST["rating"])) {
    $reviews_db = new review();
    $reviews_db->Connect();
    $connection = $reviews_db->GetPDOConnection();

    $articles_db = new article();
    $articles_db->SetPDOConnection($connection);

    //Nacteme vsechny clanky daneho uzivatele
    $articles = $reviews_db->loadReviewUserID(Login::getUserInfo("ID"));

    echo "
             <div class='container'>
                  <h2>Články k hodnocení</h2>
                  <div class='table-responsive'>
                  <table class='table'>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Název</th>
                        <th>Pridal</th>
                        <th>Téma</th>
                        <th>Pravopis</th>
                        <th>Spolehlivost</th>
                      </tr>
                    </thead>
                    <tbody>
        ";
                        // Číslování řádek
                        $index = 0;

                        foreach ($articles as $article) {
                            $index++;
                            // Načteme si článek s daným ID, abych o něm mohli hodnotiteli vypsat základní informace
                            $art = $articles_db->loadArticleByID($article['Article_idArticle']);

                            if ($art['opinion'] === 'P') {
                                echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=rating'>";
                                $name = $art['title'];
                                echo "<tr><td>" . $index . "</td>";
                                echo "<td>" . $name . "</td>";
                                echo "<td>" . $article['User_idUser'] . "</td>";
                                echo "<td>" . $article['crit1'] . "</td>";
                                echo "<td>" . $article['crit2'] . "</td>";
                                echo "<td>" . $article['crit3'] . "</td>";
                                echo "<input type = 'hidden' name = 'articleid' value = '" . $article['Article_idArticle'] . "'>";
                                echo "<input type = 'hidden' name = 'resultid' value = '" . $article['idReview'] . "'>";
                                echo "<td><input class = 'form-control' type = 'submit' value = 'Ohodnotit' name = 'rate'></td> </tr>";
                                echo "</form>";
                            }
                        }

         echo "
                    </tbody>
                  </table>
                  </div>
                </div>
        ";
}
else {
        header("Location: /sem_web/");
    }
