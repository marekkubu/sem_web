<?php

require_once('db_pdo.class.php');


// Třída pracující s tabulkou USERS pomocí PDO
class Users extends db_pdo {

    // Načte uživatele s daným username
    public function loadUser($username)
    {
        $table_name = "users";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "username", "value" => $username, "symbol" => "=");

        $info = $this->DBSelectAll($table_name, $columns, $where);

        return $info;
    }
    public function loadUserById($userID)
    {
        $table_name = "users";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "idUser", "value" => $userID, "symbol" => "=");

        $info = $this->DBSelectAll($table_name, $columns, $where);

        return $info;
    }

     public function loadReviewers()
    {
        $table_name = "users";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "powers", "value" => "reviewer", "symbol" => "=");

        $info = $this->DBSelectAll($table_name, $columns, $where);

        return $info;
    }

     public function addUser($username, $password, $email, $powers){
         //echo "$username, $password, $email, $powers";
         if($this->userExists($username)){
             return "obsazeno";
         }
         try {
             $sth = $this->connection->prepare("INSERT INTO users(username, password, email, powers)
                 VALUES (:username,:password,:email,:powers)");
             $sth->bindParam(':username', $username);
             $sth->bindParam(':password', $password);
             $sth->bindParam(':email', $email);
             $sth->bindParam(':powers', $powers);
             $sth->execute();
             if($this->userExists($username)){
                 return "ok";
             }
             else {
                 return "chyba";
             }
         } catch (Exception $e) {
             return "chyba"; //chyba v pozadavku
         }
     }
      public function userExists($login){
          $usr = $this->userInfo($login);
          if($usr == null) { // uzivatel neni v DB
              return false;
          }
          else {
              return true;
          }
      }
    public function userInfo($login){
        $sth = $this->connection->prepare("SELECT * FROM users
               WHERE username LIKE :username");
        $sth->bindParam(':username', $login);
        $sth->execute();
        $row = $sth->fetch();
        return $row;
    }

    // Načte všechny uživatele
    public function loadAllUsers()
    {
        $table_name = "users";
        $columns = "*";
        $where = array();
        $users = $this->DBSelectAll($table_name,  $columns, null);
        return $users;
    }


}
