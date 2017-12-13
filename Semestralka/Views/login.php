<?php
  
  require_once('Controllers/LoginController.php'); 

  if (isset($_POST['login'])) 
    {
        $user = $_POST['user'];
        //Přihlásíme uživatele
        LoginController::login($user['name'], $user['password']);
        
        // Zkouska pokud je opravdu uzivatel prihlasen
        if (!LoginController::isLoggedIn()) {
            echo "<div class = 'error'>Špatné uživatelské jméno nebo heslo!</div>";
        }
        
    }
    // Uspesne prihlaseni 
    if (LoginController::isLoggedIn()) {
        echo " <div class = 'success'><h1>Byli jste úspěšně přihlášeni jako uživatel <b> " . LoginController::getUserInfo('NAME') . "</h1></b></div>";
    }
    //Prihlasovaci formular
    else
    {
        echo "

            <div class = 'container'>
                <form class='form-horizontal' method='post' name = 'login_go'>
                  <div class='form-group'>

                    <label class='control-label col-sm-2' for='uname'>Uživatelské jméno:</label>

                    <div class = 'col-xs-3'>
                      <input type='text' class='form-control' id='uname' placeholder='Vložte uživatelské jméno' name='user[name]' required>
                    </div>

                  </div>

                  <div class='form-group'>

                    <label class='control-label col-sm-2' for='password'>Heslo:</label>

                    <div class='col-xs-3'>
                      <input type='password' class='form-control' id='password' placeholder='Vložte heslo' name='user[password]' required>
                    </div>

                  </div>
                  <div class='form-group'>

                    <div class='col-xs-2'></div>

                    <div class='col-sm-2'>
                      <input type='submit' class='form-control btn btn-primary' name = 'login' value = 'Přihlásit se'>
                    </div>

                  </div>
                </form>

                <div class ='col-xs-2'> </div>
                <a href='index.php?page=register'><span class='glyphicon glyphicon-user'></span> Vytvořit nový účet </a>
            </div>
        ";
    }    