<?php
require_once('Controllers/LoginController.php'); 
require_once('Controllers/UsersController.php');
//Pro všechny uživatele kteří jsou Admini
if(LoginController::getUserInfo('ROLE')=="Admin"){

    if(isset($_POST['edit_User']))
    {
      //Vytvoříme choicebox s výberem práv uživatele 
      $choicebox = "";
      $choicebox .= "<option value = 'Author'>Author</option>";
      $choicebox .= "<option value = 'Reviewer'>Reviewer</option>";
      $choicebox .= "<option value = 'Admin'>Admin</option>";
      //Získáme uživatele z databáze
    	$user = UsersController::getUserByID($_POST['id_User']);
      echo "
                
          <div class = 'container'>
              <form class='form-horizontal' id = 'naform' method = 'post' action = ''>
                <div class='form-group'>
                  <label class='control-label col-sm-2' for='aname'>Uživatelské jméno</label>
                  <div class='col-sm-10'>
                    <input type='text' class='form-control' id='aname' value = '" . $user['USERNAME']. "' name='changeUserData[username]'>
                  </div>
                </div>
                <div class='form-group'>
                  <label class='control-label col-sm-2' for='authors'>Role:</label>
                  <div class='col-sm-10'> 
                    <select class='form-control' name = 'role'>$choicebox</select>
                  </div>
                </div>
                <div class='form-group'>
                  <div class='col-xs-2'></div>
                  <div class='col-sm-2'> 
                    <input type='submit' class='form-control btn-primary' name = 'do_change' value = 'Změnit'>
                  </div>
                  <div class='col-sm-2'>
                      <input type='submit' class='form-control btn-danger' name = 'exit' value = 'Zrušit'>
                      <input type='hidden' class='form-control' name = 'id_User' value = '" . $user['ID'] . "'>
                  </div>
                </div>
              </form>
          </div>
                
            ";
    }
    // Změna Usera
    if (isset($_POST['do_change'])) {
         
        $data = $_POST['changeUserData'];
        //Změníme uživatele
        UsersController::updateUser($_POST['id_User'],$data['username'],$_POST['role']);
        //Redirect na manage_users_admin
        header('Location: index.php?page=manage_users_admin');
    }
}