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
    $index = 0;



    foreach ($array_articles as $article)
    {


            echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=rating'>";
            $name = $article['title'];
            echo "<tr><td>" . $index . "</td>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $article['idArticle'] . "</td>";
            echo "<td>" . $article['title'] . "</td>";
            echo "<input type = 'hidden' name = 'articleid' value = '" . $article['idArticle'] . "'>";
            echo "<td><input class = 'form-control' type = 'submit' value = 'Ohodnotit' name = 'rate'></td> </tr>";
            echo "</form>";

    }
    echo "
                    </tbody>
                  </table>
                  </div>
        ";


