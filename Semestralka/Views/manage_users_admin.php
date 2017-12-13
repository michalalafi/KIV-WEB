<?php
require_once('Controllers/UsersController.php');
require_once('Controllers/ReviewsController.php');
require_once('Controllers/LoginController.php'); 
//Pro uživatele kteří jsou Admini
if(LoginController::getUserInfo('ROLE')=="Admin"){
        //Získáme všechny uživatele
        $users = UsersController::getAllUsers();
        //Smazání uživatele
        if(isset($_POST['remove_User']))
        {
           //Smažeme uživatele
           UsersController::removeUser($_POST['id_User']);
           //Vymažeme všechny stávající recenze tohodle uživatele
           ReviewsController::removeReviewsByReviewerID($_POST['id_User']);
           //Reload
           header("Refresh:0");
        }
        //Tabulka uživatelů
        echo "
            <div class='container'>
              <h2>Uživatelé</h2>                                                                                   
              <div class='table-responsive'>          
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>USERNAME</th>
                    <th>ROLE</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>";

                    // Číslování řádek
                    $index = 0;
                    foreach ($users as $user) {
                        $index++;
                        echo "<tr>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            echo "<td>" . $user['ID'] . "</td>";
                            echo "<td>" . $user['USERNAME'] . "</td>";
                            echo "<td>" . $user['ROLE'] . "</td>";
                            

                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<input type='hidden' class='form-control' name = 'id_User' value = '" . $user['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-danger' name = 'remove_User' value = 'Smazat'></td>";
                            echo "</form>";
                            echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=edit_User_admin'>";
                            echo "<input type='hidden' class='form-control' name = 'id_User' value = '" . $user['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-warning' name = 'edit_User' value = 'Upravit'></td>";
                            echo "</form>";
                        echo "</tr>";
                    }
                      echo "
                </tbody>
            </table>
            </div>
        </div>";
}