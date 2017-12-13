<?php


require_once('Controllers/ArticlesController.php');
require_once('Controllers/ReviewsController.php');
require_once('Controllers/UsersController.php');
require_once('Controllers/LoginController.php'); 
//Pro uživatele kteří jsou Admini
if(LoginController::getUserInfo('ROLE')=="Admin"){
    //Načteme články v procesu
    $inProcessArticles = ArticlesController::getArticlesByState("V procesu");
    //Načtene schávelené články
    $approvedArticles = ArticlesController::getArticlesByState("Schválen");
    //Načteme zamítnuté články
    $rejectedArticles = ArticlesController::getArticlesByState("Zamítnut");
    //Smazání schváleného článku
    if(isset($_POST['remove_Approved_Article']))
    {
        //Vymažeme článek podle ID
        ArticlesController::removeArticle($_POST['id_Article']);
        //Reload
        header("Refresh:0");
    }
    //Smazání článku v procesu
    if(isset($_POST['remove_Article_inProcess']))
    {
        //Vymažeme článek podle ID
        ArticlesController::removeArticle($_POST['id_Article']);
        //Reload
        header("Refresh:0");
    }
        //Publikované články
        echo "
            <div class='container'>
              <h2>Publikované články</h2>                                                                                   
              <div class='table-responsive'>          
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Autoři</th>
                    <th>PDF</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>";

                    // Číslování řádek
                    $index = 0;
                    foreach ($approvedArticles as $article) {
                        //Získáme recenzi článku
                        $review = ReviewsController::getReviewByArticleID($article['ID']);
                        $index++;
                        echo "<tr>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            echo "<td>" . $article['NAME'] . "</td>";
                            echo "<td>" . $article['AUTHORS'] . "</td>";
                            //Pokud má článek PDF
                            if(isset($article['CONTENT']))
                            {
                            echo "<td><a href='./Documents/" . $article['CONTENT'] . "' download>".$article['CONTENT']."</a></td>";
                            }
                            else
                            {
                            echo "<td>Neni vlozeno PDF!</td>";
                            }
                            echo "<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-danger' name = 'remove_Approved_Article' value = 'Smazat'></td>";
                            echo "</form>";
                        echo "</tr>";
                    }
                     echo "
                </tbody>
            </table>
            </div>
        </div>";
        //Články v procesu
        echo "
            <div class='container'>
              <h2>Články v procesu schvalování</h2>                                                                                   
              <div class='table-responsive'>          
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Autoři</th>
                    <th>Stav </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>";
                    // Číslování řádek
                    $index = 0;
                    foreach ($inProcessArticles as $article) {
                        echo "<tr>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            $index++;
                            echo "<td>" . $article['NAME'] . "</td>";
                            echo "<td>" . $article['AUTHORS'] . "</td>";
                            echo "<td>" . $article['STATE'] . "</td>";
                  
                            echo "<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-danger' name = 'remove_Article_inProcess' value = 'Smazat'></td>"; 
                            echo "</form>";
                            echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=add_reviewers_toArticle'>";
                            echo "<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-primary' name = 'addReviewers' value='Detail recenze'></td>"; 
                            echo "</form>";
                        echo "</tr>";
                    }
                     echo "
                </tbody>
            </table>
            </div>
        </div>";
        //Zamítnuté články
         echo "
            <div class='container'>
              <h2>Zamítnuté články</h2>                                                                                   
              <div class='table-responsive'>          
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Autoři</th>
                    <th>Stav </th>
                  </tr>
                </thead>
                <tbody>";
                    // Číslování řádek
                    $index = 0;
                    foreach ($rejectedArticles as $article) {
                        echo "<tr>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            $index++;
                            echo "<td>" . $article['NAME'] . "</td>";
                            echo "<td>" . $article['AUTHORS'] . "</td>";
                            echo "<td>" . $article['STATE'] . "</td>";
                            echo "</form>";
                        echo "</tr>";
                    }
                     echo "
                </tbody>
            </table>
            </div>
        </div>";
} 