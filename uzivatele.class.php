<?php

/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 12. 12. 2016
 * Time: 21:55
 */
include_once ("settings_db.inc.php");
class uzivatele extends db_pdo
{
    private $db;
    public function __construct(){
        global $db_server, $db_name, $db_user, $db_pass;
        // informace se berou ze settings
        $conn = new PDO("mysql:host=$db_server;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $conn;
    }

    /**
     * Nacte vsechny uzivatele
     */
    public function LoadAllUsers()
    {
        $table_name = "uzivatel";
        $columns = "*";
        $where = array();
        //$where[] = array("column" => "zkratka", "value" => "KIV/DB1", "symbol" => "=");
        $uzivatele = $this->DBSelectAll($table_name, $columns, $where);
        return $uzivatele;
    }

    public function addUser($login, $heslo, $email){
        if($this->userExists($login)){
            return "obsazeno";
        }
        try {
            $sth = $this->db->prepare("INSERT INTO uzivatel(username, password, email)
                VALUES (:username,:password,:email)");
            $sth->bindParam(':username', $login);
            $sth->bindParam(':password', $heslo);
            $sth->bindParam(':email', $email);
            $sth->execute();
            if($this->userExists($login)){
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
        $sth = $this->db->prepare("SELECT * FROM uzivatel
               WHERE username LIKE :username");
        $sth->bindParam(':username', $login);
        $sth->execute();
        $row = $sth->fetch();
        return $row;
    }

    public function prihlasUzivatele($login, $heslo){
        $infoLog=$this->db->userInfo($login);
        if($infoLog != null && $infoLog["blokovan"] != "n") {
            return "blokovan";
        }
        if($this->db->isLoginPasswordCorrect($login, $heslo)){
            $_SESSION["prihlasen"]=$login; // zahajim session uzivatele
            return true;
        } else {
            return false;//uzivatel s heslem nenalezen neprihlasuji
        }
    }

    public function isLoginPasswordCorrect($login, $pass){
        $usr = $this->userInfo($login);
        if($usr==null){ // uzivatel neni v DB
            return false;
        }
        return $usr["password"] == $pass; // je heslo stejne?
    }

}