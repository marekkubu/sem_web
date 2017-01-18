<?php

include_once("settings_db.inc.php");
include_once("model/db_pdo.class.php");
include_once("functions.inc.php");
include_once("model/users.class.php");
include_once("model/login.class.php");
include_once("model/article.class.php");
include_once("controller/login.inc.php");
include_once("controller/logout.inc.php");
include_once("controller/register.inc.php");

    $articles = new Article();
    $articles->Connect();
    $array_articles = $articles->LoadAllArticles();
    foreach ($array_articles as $article)
    {
        echo  "Prispevek č.$article[idArticle], $article[title] - $article[abstract] <br/>";
    }


    // Číslování řádek
    $index = 0;
/*
    foreach ($articles as $article) {
        $index++;
        // Načteme si článek s daným ID, abych o něm mohli hodnotiteli vypsat základní informace
        $art = $articles_db->loadArticleWithID($article['ARTICLES_ID']);

        if ($art['STATE'] === 'P') {
            echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=rating'>";
            $name = $art['NAME'];
            echo "<tr><td>" . $index . "</td>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $article['ARTICLES_USERS_ID'] . "</td>";
            echo "<td>" . $article['CRIT1'] . "</td>";
            echo "<td>" . $article['CRIT2'] . "</td>";
            echo "<td>" . $article['CRIT3'] . "</td>";
            echo "<input type = 'hidden' name = 'articleid' value = '" . $article['ARTICLES_ID'] . "'>";
            echo "<input type = 'hidden' name = 'resultid' value = '" . $article['ID'] . "'>";
            echo "<td><input class = 'form-control' type = 'submit' value = 'Ohodnotit' name = 'rate'></td> </tr>";
            echo "</form>";
        }
    }*/

    echo "
                    </tbody>
                  </table>
                  </div>
                </div>
        ";
