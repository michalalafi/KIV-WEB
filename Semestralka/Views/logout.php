<?php
    
    require_once('Controllers/LoginController.php'); 
    //Odhlášení uživatele
    LoginController::logout();
    //Redirect na index
    header("Location: index.php");