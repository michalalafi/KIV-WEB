<?php   
    
    require_once('Controllers/LoginController.php'); 

    // Pokud není přihlášen bude přesměrován
    if (LoginController::isLoggedIn()) {
        
        echo "<div class = 'container'>";
            echo "<div class= 'jumbotron well'>";
                $username = LoginController::getUserInfo('NAME');
                echo "<h1> Username: " . $username . "</h1>";
                $role = LoginController::getUserInfo('ROLE');
                
                if ($role == 'Admin') {
                     echo "<h2> Role: ADMIN</h2>";
                }
                else if ($role == 'Author') {
                     echo "<h2> Role: AUTOR</h2>";
                }
                else if ($role = 'Reviewer') {
                     echo "<h2> Role: RECENZENT</h2>";
                }
            echo "</div>";
         echo "</div>";
    }
    else {
        header("Location: /WWW");
    }