<?php

/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 20. 12. 2016
 * Time: 10:18
 */

require_once ('model/db_pdo.class.php');

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

   /* public function addArticle($title, $abstact,$datetime,$userID,$file){*/
       /* if($this->articleExists($title)){
            return "obsazeno";
        }*/
      /*  try {
            $sth = $this->connection->prepare("INSERT INTO articles(title, abstract, dateAdd,User_idUser, file, opinion, type) VALUES (:title, :abstract, :dateAdd, :file, :opinion, :type)");

            $sth->bindParam(':title', $title);
            $sth->bindParam(':abstract', $abstact);
            $sth->bindParam(':dateAdd', $datetime);
            $sth->bindParam(':User_idUser', $userID);
            $sth->bindParam(':file', $file);
            $sth->bindParam(':opinion', "N");
            $sth->bindParam(':type', "PDF");
            $sth->execute();
            if($this->articleExists($title)){
                return "ok";
            }
            else {
                return "chyba";
            }
        } catch (Exception $e) {
            return "chyba"; //chyba v pozadavku
        }
    }*/
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

}
