<?php

	define("USER", 'user');

    require_once('Data/Users.php');
    require_once('Data/ConnectionSettings.php');
    
 	class LoginController
 	{
        /******************************************************
        /
        / LOGIN
        /
        /
        /******************************************************/

     	public static function login($username,$password)
     	{
     		$db_users = new Users();
     		$db_users->Connect();
            //Podle prihlasovacich údajů najdeme uživatele v databázi
     		$info = $db_users->getUserByUserName($username);
            //Pokud byl uživatel nalezen v databázi a jeho heslo se shoduje se zadaným, nastavíme Session
     		if(!empty($info) && $password == $info[0]['PASSWORD']) {   
                    $_SESSION[USER] = array();
                    $_SESSION[USER]['LOGIN'] = true;
                    $_SESSION[USER]['NAME'] = $username;
                    $_SESSION[USER]['ROLE'] = $info[0]['ROLE'];
                    $_SESSION[USER]['ID'] = $info[0]['ID'];
                }
     	}
 	    
        public static function isLoggedIn() {
            //Vrátí true pokud je SESSION nastaveno, jinak false
            if (isset($_SESSION[USER]['LOGIN']) && $_SESSION[USER]['LOGIN']) {
                return true;
            }
            else {
                return false;
            }

        }
        // Podle parametru what vrátí $_SESSION[USER][$what]
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
        // Odhlásí uživatele
        public static function logout() {
            session_destroy();
        }
 }   