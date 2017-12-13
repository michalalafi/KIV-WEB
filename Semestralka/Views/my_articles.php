<?php

require_once('Controllers/ArticlesController.php');
require_once('Controllers/ReviewsController.php');
require_once('Controllers/LoginController.php'); 


$user_ID = $_SESSION['user']['ID'];

//Pro všechny uživatele, kteří jsou Autoři
if(LoginController::getUserInfo('ROLE')=="Author"){
        //Smazání článku
        if(isset($_POST['remove_MyArticle']))
        {   
           //Smazání článku
           ArticlesController::removeArticle($_POST['id_MyArticle']);
           //Smazání recenzí k tomuto článku
           ReviewsController::removeReviewsByArticleID($_POST['id_MyArticle']);
        }
        //Tabulka článků Autora
        echo "
            <div class='container'>
              <h2>Moje články</h2>                                                                                   
              <div class='table-responsive'>          
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Název</th>
                    <th>Autoři</th>
                    <th>Téma</th>
                    <th>Originalita</th>
                    <th>Jazyk</th>
                    <th>Ohodnocení </th>
                    <th>Stav </th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>";

                    // Číslování řádek
                    $index = 0;
                    // Načtení článků daného uživatele
                    $articles = ArticlesController::getArticlesByUserID($user_ID);
                    foreach ($articles as $article) {
                        $review = ReviewsController::getAvarageOfReviewsToArticle($article['ID']);
                        $avarage = ReviewsController::getAvarage($review['ORIGINALITY'],$review['THEME'],$review['LANGUAGE']);
                        $index++;
                        echo "<tr>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<td>" . $index . "</td>";
                            echo "<td>" .  htmlspecialchars($article['NAME'], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . $article['AUTHORS'] . "</td>";
                            echo "<td>" . $review['THEME'] . "</td>";
                            echo "<td>" . $review['ORIGINALITY'] . "</td>";
                            echo "<td>" . $review['LANGUAGE'] . "</td>";
                            echo "<td>" . $avarage . "</td>";
                            echo "<td>" . $article['STATE'] . "</td>";
                            echo "<input type='hidden' class='form-control' name = 'id_MyArticle' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-danger' name = 'remove_MyArticle' value = 'Smazat'></td>";
                            echo "</form>";
                            echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=change_MyArticle'>";
                            echo "<input type='hidden' class='form-control' name = 'id_MyArticle' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-warning' name = 'change_MyArticle' value = 'Upravit'></td>";
                            echo "</form>";
                        echo "</tr>";
                    }
                    echo "
                </tbody>
            </table>
            </div>
        </div>";

}