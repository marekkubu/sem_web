<?php
define("USER", 'user');
require_once('model/users.class.php');
require_once('settings_db.inc.php');

class Login {

    public static function log_in($username, $password) {
        $db_users = new users();
        $db_users->Connect();
        $info = $db_users->loadUser($username);
        if(!empty($info) && $password == $info[0]['password']) {
            $_SESSION[USER] = array();
            $_SESSION[USER]['LOGIN'] = true;
            $_SESSION[USER]['NAME'] = $username;
            $_SESSION[USER]['ID'] = $info[0]['idUser'];
        }

    }
    public static function log_out() {
        session_destroy();
    }


   /* public function addUser($username, $password, $email){
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
    }*/
  /*  public function userExists($login){
        $usr = $this->userInfo($login);
        if($usr == null) { // uzivatel neni v DB
            return false;
        }
        else {
            return true;
        }
    }*/
    public static function isLog() {
        if (isset($_SESSION[USER]['LOGIN']) && $_SESSION[USER]['LOGIN']) {
            return true;
        }
        else {
            return false;
        }

    }/*
    public function userInfo($login){
        $sth = $this->db->prepare("SELECT * FROM uzivatel
               WHERE username LIKE :username");
        $sth->bindParam(':username', $login);
        $sth->execute();
        $row = $sth->fetch();
        return $row;
    }*/
    public static function getUserInfo($what) {

        if (isset($_SESSION[USER])) {
            if (isset($_SESSION[USER][$what])) {
                return $_SESSION[USER][$what];
            }
            else {
                return null;
            }
        }

        return null;
    }

    public function isLoginPasswordCorrect($login, $pass){
        $usr = $this->userInfo($login);
        if($usr==null){ // uzivatel neni v DB
            return false;
        }
        return $usr["password"] == $pass; // je heslo stejne?
    }

}