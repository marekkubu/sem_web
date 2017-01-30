<?php
define("USER", 'users');
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
            $_SESSION[USER]['POWERS'] = $info[0]['powers'];
        }

    }
    public static function log_out() {
        session_destroy();
    }



    public static function isLog() {
        if (isset($_SESSION[USER]['LOGIN']) && $_SESSION[USER]['LOGIN']) {
            return true;
        }
        else {
            return false;
        }

    }
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
