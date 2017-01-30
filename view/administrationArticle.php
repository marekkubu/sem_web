<?php
require_once('settings_db.inc.php');
require_once('model/login.class.php');
require_once('model/db_pdo.class.php');
require_once('model/article.class.php');
require_once('model/review.class.php');
require_once('model/users.class.php');

if (Login::isLog() && Login::getUserInfo("POWERS") == 'admin') {
    $reviews_db = new review();
    $reviews_db->Connect();
    $connection = $reviews_db->GetPDOConnection();

    $articles_db = new article();
    $articles_db->SetPDOConnection($connection);

    $users_db = new users();
    $users_db->SetPDOConnection($connection);

    $reviewers = $users_db->loadReviewers();
    $choicebox = "";
    foreach ($reviewers as $user) {
        $choicebox .= "<option value = " . $user['idUser'] . ">" . $user['username'] . "</option>";
    }

    if (isset($_POST['article_rev'])) {
        // Jeli přiřazen recenzent je stav změněn na Proces
        $articles_db->updateArticleOpinion($_POST['art_id'], 'P');
        // Přidáme daného recenzenta

        $reviews_db->addReview($_POST['reviewer'], $_POST['art_id']);
    }


    echo "
            <div class='container'>
              <h2>Články</h2>
              <div class='table-responsive'>
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Pridal</th>
                    <th>Recenzenti</th>
                    <th>PDF</th>
                    <th>Pravopis</th>
                    <th>Spolehlivost</th>
                    <th>Ohodnocení </th>
                    <th>Stav </th>
                    <th>Publikovat </th>
                    <th>Smazat</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>";

                    // Načteme články z databáze
                    $array_articles = $articles_db->LoadAllArticles();
                    // Číslování řádků
                    $index = 0;

                    foreach ($array_articles as $article) {
                        $index++;
                        $users= $users_db->loadUserById($article["User_idUser"]);
                        $reviewers = $reviews_db->loadReviewers($article['idArticle']);
                            echo "<tr>";
                            echo "<form method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            echo "<td>" . $article['title'] . "</td>";
                            foreach($users as $user){
                            echo "<td>" . $user['username'] . "</td>";}


                             echo "<td>$reviewers</td>";
                            echo "<td><a href='model/downloadPDF.class.php?download=" . $article['idArticle'] . "' target='_blank'>PDF</a><br></td>";
                            echo "<td>spelling</td>";
                            echo "<td>trustw</td>";
                            echo "<td>total</td>";
                            echo "<td>" . $article['opinion'] . "</td>";
                            echo "<td> <input type = 'submit' name = 'adm_art_conf' class = 'btn btn-success' value = 'Publikovat'></td>";
                            echo "<td> <input type = 'submit' class='btn btn-danger' name = 'adm_art_delete' class = 'form-control' value = 'Smazat'></td>";

                            echo "<input type = 'hidden' name = 'art_id' value = '" . $article['idArticle'] . "'>";
                            echo "</form>";
                            echo "</tr>";
                    }

        echo      "</tr>
                </tbody>
              </table>
              </div>
            </div>
            ";

    //Dalsi tabulka
    echo "
              <div class='container'>
              <h2> Přiřazení článků k hodnocení</h2>
              <div class='table-responsive'>
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Pridal</th>
                    <th>Recenzent</th>
                  </tr>
                </thead>
                <tbody>
                ";
                    $art_in_process = array();
                    $n_art = $articles_db->loadAllArticles();
                    $index = 0;
                    // Pro každý nový nebo upravený článek přidáme řádek s výběrem hodnotitelů
                    foreach ($n_art as $article) {
                        if ($article['opinion'] == 'N' || $article['opinion'] == 'P') {
                            $index++;
                            echo "<tr>";
                            echo "<form method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            echo "<td>" . $article['title'] . "</td>";
                            echo "<td>" . $article['User_idUser'] . "</td>";
                            echo "<td><select name = 'reviewer' class = 'form-control'>" . $choicebox . " </select></td>";
                            echo "<td> <input type = 'submit' name = 'article_rev' class ='btn btn-info' 'form-control' value = 'Přiřadit'></td>";
                            echo "<input type = 'hidden' name = 'art_id' value = '" . $article['idArticle'] . "'>";
                            echo "<input type = 'hidden' name = 'art_user_id' value = '" . $article['User_idUser'] . "'>";
                            echo "</form>";
                            echo "</tr>";
                            $art_in_process[$index - 1] = array($article['idArticle'], $article['title']);
                        }
                    }

    echo "
                </tbody>
              </table>
              </div>
            </div>
        ";

    // Clanky, ktere maji prirazeneho recenzenta
   echo " <div class='container'>
              <h2> Články s recenzenty</h2>
              <div class='table-responsive'>
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Recenzent</th>
                  </tr>
                </thead>
                <tbody>
                ";
                    $top = $index;
                    for ($i = 0; $i < $top; $i++) {
                        $reviews = $reviews_db->loadReview($art_in_process[$i][0]);

                            foreach ($reviews as $review) {
                                    $index++;
                                    echo "<tr>";
                                    echo "<form method = 'post'>";
                                    echo "<td>" . $index . "</td>";
                                    echo "<td>" . $art_in_process[$i][1] . "</td>";
                                    echo "<td>" . $review['User_idUser'] . "</td>";
                                    echo "<td> <input type = 'submit' name = 'j_remove' class = 'btn btn-danger' value = 'Smazat'></td>";
                                    echo "<input type = 'hidden' name = 'res_id' value = '" . $review['idReview'] . "'>";
                                    echo "</form>";
                                    echo "</tr>";
                            }

                    }

}
else {
        header("Location: /sem_web/");
    }
