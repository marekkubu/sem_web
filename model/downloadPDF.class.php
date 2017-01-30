<?php
require_once('db_pdo.class.php');
require_once('article.class.php');
require_once('settings_db.inc.php');

    if (isset($_GET['download'])) {

        // Připojení k databázi
        $articles_db = new article();
        $articles_db->Connect();
        echo "jsem tu";

        // Načtení daného obsahu z databáze
        $article = $articles_db->loadArticleByID($_GET['download']);

        // Pokud tam takový obsah je
        if ($article != null) {

            $content = $article['CONTENT'];
            $name = $article['NAME'] . ".pdf";

            header('Content-length: ' . strlen($content));
            header("Content-type: application/pdf");
            header("Content-disposition: inline; filename= $name");

            echo $content;

        }
        // Pokud neexistuje PDS s daným ID
        else {
            echo "<div class = 'error'><h2> Soubor, který chcete zobrazit neexistuje.</h2></div>";
        }

    }
