<?php 

    require_once('Controllers/LoginController.php'); 
    // Pole společných věcí pro všechny
    $pages = array();
    $pages['home'] = "Články";
    $pages['contact'] = "Kontakt";

    echo "<ul class='nav navbar-nav'>";

        foreach ($pages as $key => $title) {
            echo "<li class='active'><a href='index.php?page=$key'>$title</a></li>";
        }
         // Získáme roli přihlášeného uživatele
        $role = LoginController::getUserInfo("ROLE");
        // Podle role přihlášeného uživatele zobrazíme dané položky v menu
        if ($role == "Author") {
            echo "<li class='active'><a href='index.php?page=new_article'>Nový článek</a></li>";
            echo "<li class='active'><a href='index.php?page=my_articles'>Moje články</a></li>";
        }

        if ($role == "Admin") {
            echo "<li class='active'><a href='index.php?page=manage_articles_admin'>Správa článků</a></li>";
            echo "<li class='active'><a href='index.php?page=manage_users_admin'>Správa uživatelů</a></li>";
        }

        if ($role == "Reviewer") {
            echo "<li class='active'><a href='index.php?page=articles_toreview'>K hodnocení</a></li>";
        }


    echo "</ul>";
    
    echo "<ul class='nav navbar-nav navbar-right'>";
        
        // Zobrazení podle stavu uživatele - přihlášen/nepřihlášen
        if (LoginController::isLoggedIn()) {
            echo "<li><a href='index.php?page=logout'><span class='glyphicon glyphicon-log-in'></span> Odhlášení</a></li>";
            $name = LoginController::getUserInfo("NAME");
            echo "<li><a href='index.php?page=profile'><span class='glyphicon glyphicon-user'></span> $name</a></li>";
        }
        else {
            echo "<li><a href='index.php?page=login'><span class='glyphicon glyphicon-log-in'></span> Přihlášení</a></li>";
            echo "<li><a href='index.php?page=register'><span class='glyphicon glyphicon-user'></span> Registrace</a></li>";
        }
        
    echo "</ul>"; 