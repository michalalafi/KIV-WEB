<?php

require_once('Controllers/UsersController.php'); 
require_once('Controllers/LoginController.php'); 

if (isset($_POST['register'])) {
	//Pokud je uživatel přihlášený
	if (LoginController::isLoggedIn()) {
        echo " <div class = 'success'><h1>Jste již přihlášeni</h1></div>";
    }
    else
    {

		$user = $_POST['user'];
		//Získáme všechny uživatele
		$users = UsersController::getAllUsers();
		//Vrátí 1 pokud je username obsazené nebo 0 pokud ne
		$found = UsersController::isUserNameAvaible($user['name'],$users);
		//Alert že je obsazené jmeno
		if($found == 1)
		{
			echo "<script>alert('Toto jméno je již obsazeno!');</script>";
		}
		else
		{
			//Je heslo a heslo po druhé stejné?
			if($user['password']!=$user['passwordAgain'])
			{
				echo "<script>alert('Nebyla zadána totožná hesla!');</script>";
			}
			else
			{
				//Registruj uživatele
				UsersController::registerUser($user['name'],$user['password']);
				//Přihlaš ho
				LoginController::login($user['name'], $user['password']);
			}
		}
	}

}
if (!LoginController::isLoggedIn()) 
    {
   	//Registrační formulář
	echo "
	        <div class = 'container'>
	            <form class='form-horizontal' method='post' name = 'registerForm'>  
	              <div class='form-group'>
	                <label class='control-label col-sm-2' for='uname'>Username:</label>
	                <div class='col-sm-10'>
	                  <input type='text' class='form-control' id='uname' placeholder='Vložte uživatelské jméno' name='user[name]' required>
	                </div>
	              </div>
	              <div class='form-group'>
	                <label class='control-label col-sm-2' for='password'>Heslo: </label>
	                <div class='col-sm-10'>
	                  <input type='password' class='form-control' id='password' placeholder= 'Vložte heslo' name='user[password]' required>
	                </div>
	              </div>
	               <div class='form-group'>
	                <label class='control-label col-sm-2' for='password'>Heslo znovu: </label>
	                <div class='col-sm-10'>
	                  <input type='password' class='form-control' id='passwordAgain' placeholder= 'Napište heslo pro kontrolu' name='user[passwordAgain]' required>
	                </div>
	              </div>
	              <div class='form-group'>
	              	<div class='col-xs-2'></div>
	                <div class='col-sm-2'>
	                  <input type='submit' class='form-control btn-primary' name = 'register' value = 'Registrovat' id = 'register'>
	                </div>
	              </div>
	            </form>    
	        </div>
	    ";
	}
else
	{
		echo " <div class = 'success'><h1>Jste již přihlášeni</h1></div>";
	}