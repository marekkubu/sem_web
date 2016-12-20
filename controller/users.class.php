<?php

require_once('db_pdo.class.php');
require_once('settings_db.inc.php');


// Třída pracující s tabulkou USERS pomocí PDO
class Users extends db_pdo {

    // Načte uživatele s daným username
    public function loadUser($username)
    {
        $table_name = "uzivatel";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "username", "value" => $username, "symbol" => "=");

        $info = $this->DBSelectAll($table_name, $columns, $where);

        return $info;
    }
    public function addUser($username, $password, $email){
        if($this->userExists($username)){
            return "obsazeno";
        }
        try {
            $sth = $this->db->prepare("INSERT INTO uzivatel(username, password, email)
                VALUES (:username,:password,:email)");
            $sth->bindParam(':username', $username);
            $sth->bindParam(':password', $password);
            $sth->bindParam(':email', $email);
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

    // Načte všechny uživatele
    public function loadAllUsers()
    {
        $table_name = "uzivatel";
        $columns = "*";
        $where = array();

        $users = $this->DBSelectAll($table_name,  $columns, null);

        return $users;
    }

    // Přidá uživatele s danými parametry
   /* public function addUser($username, $password, $email) {

        $table_name = "uzivatel";
        $item = array();

        $item['username'] = $username;
        $item['password'] = $password;
        $item['email'] = $email;
        $this->DBInsert($table_name, $item);

    }

    // Odstraní uživatele s daným ID
    public function removeUser($id) {

        $table_name = "uzivatel";
        $where = array();
        $where[] = array("column" => "ID", "value" => $id, "symbol" => "=");

        $this->DBDelete($table_name, $where, "LIMIT 5");

    }

    // Upraví dané informace o uživateli s daným ID
    public function updateUser($value, $data) {
        $table_name = "uzivatel";
        $where = array();
        $where[] = array("column" => "ID", "value" => $value, "symbol" => "=");

        $item = array();
        $item['ROLE'] = $data[0];
        $item['EMAIL'] = $data[1];

        $this->DBUpdate($table_name, $where, $item);
    }*/


}