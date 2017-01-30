<?php
require_once('model/article.class.php');
require_once('model/db_pdo.class.php');

    $article_db = new article();
    $article_db->Connect();
    $article = $article_db->loadArticleByID($_POST["articleID"]);
    $userID=$_SESSION[USER]['ID'];
?>


<div class = 'container'>
     <form class="modal-content animate" id="form" method="post">
        <div class="containerLog">
            <br>
            <label><b>Název</b></label>
            <textarea rows="1" class='form-control' id='title' name='articleTitle'><?php  echo $article['title'];?> </textarea>
            <label><b>Popis</b></label>
            <textarea rows="6" class='form-control' id='abstract' name='articleAbstract' ><?php  echo $article['abstract'];?> </textarea>
            <label  for='userfile'>PDF soubor: (pouze pokud chcetě změnit)</label>
            <input type='file' class='form-control' name ='userfile'>
            <input type='hidden' class='form-control' name = 'articleIDchange' value = "<?php echo $_POST["articleID"]?>">
            <button type="submit" class="btn btn-success" name="saveChange" >Upravit</button>
            <button type="submit"  class="btn btn-danger">Zrušit</button>

        </div>
    </form>
</div>
