<?php

require_once('Controllers/ReviewsController.php');
require_once('Controllers/LoginController.php'); 
require_once('Controllers/ArticlesController.php');
//Pro uživatele kteří jsou recenzenti
if(LoginController::getUserInfo('ROLE')=="Reviewer"){
    //ID uživatele
    $user_ID = LoginController::getUserInfo("ID");
    //Vezmeme všechny recenze ve kterých je označen tento uživatel jako recenzent
    $reviews = ReviewsController::getUserReviewsByUserID($user_ID);


    echo "
             <div class='container'>
                  <h2>Články k hodnocení</h2>                                                                                       
                  <table class='table'>
                    <thead>
                      <th>#</th>
                      <th>Název</th>
                      <th>Pridal</th>
                      <th>Téma</th>
	                    <th>Originalita</th>
	                    <th>Jazyk</th>
                      <th></th>
                    </thead>
                    <tbody>
        ";  
                        // Číslování řádek
                        $index = 0;
        
                        foreach ($reviews as $review) {
                            $index++;
                            // Načteme článek podle ID článku, které víme z recenze
                            $article = ArticlesController::getArticleByArticleID($review['ARTICLE_ID']);
                            
                            //if ($art['STATE'] === 'P') {
                                echo "<tr>";
                                  echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=review_article'>";
                                  echo "<td>" . $index . "</td>";
                                  echo "<td>" . $article['NAME'] . "</td>";
                                  echo "<td>" . $article['AUTHOR_ID'] . "</td>";
                                  echo "<td>" . $review['ORIGINALITY'] . "</td>";
                                  echo "<td>" . $review['THEME'] . "</td>";
                                  echo "<td>" . $review['LANGUAGE'] . "</td>";
                                  echo "<input type = 'hidden' name = 'article_id' value = '" . $article['ID'] . "'>";
                                  echo "<input type = 'hidden' name = 'review_id' value = '" . $review['ID'] . "'>";
                                  echo "<td><input class = 'form-control btn-primary' type = 'submit' value = 'Ohodnotit' name = 'rate'></td>";
                                  echo "</form>";
                                echo "</tr>";
                            //}
                        }

         echo "
                    </tbody>
                  </table>
                </div>
        ";
}
