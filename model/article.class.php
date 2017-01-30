<?php

/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 20. 12. 2016
 * Time: 10:18
 */

require_once ('db_pdo.class.php');

class Article extends db_pdo
{
    // Načte příspěvek, dle daného paramtru
    public function loadArticle($idrecenze)
    {
        $columns = "*";
        $where = array();
        $where[] = array("column" => "idrecenze", "value" => $idrecenze, "symbol" => "=");

        $info = $this->DBSelectAll("articles", $columns, $where);

        return $info;
    }
    public function loadArticleByID($idArticle)
    {
            $columns = "*";
            $where = array();
            $where[] = array("column" => "idArticle", "value" => $idArticle, "symbol" => "=");
            $articles = $this->DBSelectAll("articles", $columns, $where);

            // Obecně vrací pole, ale víme, že ID je jedinečné
            return $articles[0];
    }

    public function loadArticleUserID($userID)
    {
        $columns = "*";
        $where = array();
        $where[] = array("column" => "User_idUser", "value" => $userID, "symbol" => "=");

        $info = $this->DBSelectAll("articles", $columns, $where);

        return $info;
    }


    public function addArticle($title, $abstract, $datetime, $userID, $file) {

            $table_name = "articles";
            $item = array();
            $item['title'] = $title;
            $item['abstract'] = $abstract;
            $item['dateAdd'] = $datetime;
            $item['User_idUser'] = $userID;
            $item['file'] = $file;
            $item['opinion'] = 'N';
            $item['type'] = "PDF";
            $this->DBInsert($table_name, $item);
        }
    public function updateArticle($idArticle, $title, $abstract, $datetime, $file) {

            $table_name = "articles";
            $where = array();
            $where[] = array("column" => "idArticle", "value" => $idArticle, "symbol" => "=");

            $item = array();
            $item['title'] = $title;
            $item['abstract'] = $abstract;
            $item['dateAdd'] = $datetime;
            $item['file'] = $file;
            $item['opinion'] = "N";
            $this->DBUpdate($table_name, $where, $item);
        }
     public function removeArticle($idArticle) {

            $table_name = "articles";
            $item = array();
            $item[] = array("column"=> "idArticle", "value" => $idArticle, "symbol" => "=");
            $this->DBDelete($table_name, $item, "LIMIT 8");
        }

    public function articleExists($title){
        $usr = $this->articleInfo($title);
        if($usr == null) { // prispevek neni v DB
            return false;
        }
        else {
            return true;
        }
    }
    public function articleInfo($name){
        $sth = $this->connection->prepare("SELECT * FROM articles
               WHERE title LIKE :title");
        $sth->bindParam(':title', $name);
        $sth->execute();
        $row = $sth->fetch();
        return $row;
    }

    // Načte všechny příspěvky
    public function loadAllArticles()
    {   $columns = "*";
        $where = array();
        $articles = $this->DBSelectAll("articles",  $columns, null);
        return $articles;
    }

     public function updateArticleOpinion($idArticle, $opinion) {

            $table_name = "articles";
            $where = array();
            $where[] = array("column" => "idArticle", "value" => $idArticle, "symbol" => "=");

            $item = array();
            $item['opinion'] = $opinion;
            $this->DBUpdate($table_name, $where, $item);
        }



}
