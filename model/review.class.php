<?php
require_once('db_pdo.class.php');
// třída pracující s tabulkou review pomocí PDO
    class Review extends db_pdo {
        // Přidává hodnocení s danými parametry
        public function addReview($reviewer, $idArticle) {
            $table_name = "review";
            $item = array();
            $item['User_idUser'] = $reviewer;
            $item['Article_idArticle'] = $idArticle;
            $item['dateAdd'] = date("Y-m-d G:i:s");
            $this->DBInsert($table_name, $item);
        }
        public function loadReviewUserID($userID) {
            $table_name = "review";
            $columns = "*";
            $where = array();
            $where[] = array("column" => "User_idUser", "value" => $userID, "symbol" => "=");

            $info = $this->DBSelectAll($table_name, $columns, $where);

            return $info;
        }
        public function loadReview($article_id) {
            $table_name = "review";
            $columns = "*";
            $where = array();
            $where[] = array("column" => "Article_idArticle", "value" => $article_id, "symbol" => "=");

            $reviews = $this->DBSelectAll($table_name, $columns, $where);

            return $reviews;
        }

        public static function loadReviewers($idArticle) {

        $reviews_db = new review();
        $reviews_db->Connect();
        $reviews = $reviews_db->loadReview($idArticle);
        $reviewers = "";

        foreach ($reviews as $review) {
            if ($review['User_idUser'] != null) {
                if ($reviewers == "") {
                    $reviewers .= $review['User_idUser'];
                }
                else {
                    $reviewers .= ", " . $review['User_idUser'];
                }
            }
        }

        if ($reviewers == "" ) {
            return "NONE";
        }
        return $reviewers;
    }



      /*  public function reviewExists($login){
          $usr = $this->userInfo($login);
          if($usr == null) { // uzivatel neni v DB
              return false;
          }
          else {
              return true;
          }
      }
        public function reviewInfo($login){
            $sth = $this->connection->prepare("SELECT * FROM review
               WHERE username LIKE :username");
            $sth->bindParam(':username', $login);
            $sth->execute();
            $row = $sth->fetch();
            return $row;
    }*/
}
