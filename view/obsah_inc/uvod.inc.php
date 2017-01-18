<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 13. 12. 2016
 * Time: 2:05
 */
echo "<h1>
    Vítám Vás na webové konferenci
</h1>
<div class=\"container\">
    <h3>Semestrální práce KIV/WEB</h3>
    <p>Pokud nejste přihlášeny tak můžete pouze prohlížet přidané příspěvky.</p>
    <br>
    
</div>";
include_once ("view/obsah_inc/articles.inc.twig");
require_once('controller/showArticles.inc.php');

