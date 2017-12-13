<?php

require_once('Controllers/ArticlesController.php');
require_once('Controllers/ReviewsController.php');
require_once('Controllers/UsersController.php');
require_once('Controllers/LoginController.php'); 

//Pro všechny uživatele kteří jsou Admini
if(LoginController::getUserInfo('ROLE')=="Admin"){
    //Přidání recenzenta
    if(isset($_POST['addReviewer']))
    {
        //Přidání defaultni recenze
        ReviewsController::AddEmptyReview($_POST['id_Article'],$_POST['reviewer']);
        //reload stránky s ID článku
        header('Location: index.php?page=add_reviewers_toArticle&article=' . $_POST['id_Article'] . '');

    }
    //Nastaveni článku na Schválený
    if(isset($_POST['setApproved']))
    {
        //Nastavení stavu článku
    	ArticlesController::setArticleState($_POST['id_Article'],"Schválen");
        //Smazání přidřazení recenzentů k tomuto článku
    	ReviewsController::changeRewiewReviewerToDefault($_POST['id_Article']);
        //Redirect 
    	header('Location: index.php?page=manage_articles_admin');
    }
    //Nastavený článek na Zamítnutý
    if(isset($_POST['setRejected']))
    {
        //Nastavení stavu článku
        ArticlesController::setArticleState($_POST['id_Article'],"Zamítnut");
        //Smazání přidřazení recenzentů k tomuto článku
        ReviewsController::changeRewiewReviewerToDefault($_POST['id_Article']);
        //Redirect
        header('Location: index.php?page=manage_articles_admin');
    }
    //Smazání recenze
    if(isset($_POST['remove_Review']))
    {
        //Smazání podle ID recenze
    	ReviewsController::removeReviewByID($_POST['id_Review']);
        //Reload stránky s ID článku
    	header('Location: index.php?page=add_reviewers_toArticle&article=' . $_POST['id_Article'] . '');
    }
    //Pokud je nastaven id_Article načti článek
    if(isset($_POST['id_Article']))
    {
    	$article = ArticlesController::getArticleByArticleID($_POST['id_Article']);
    }
    //Jinak zkus vzít id articlu z url 
    else
    {
       $request_article = @$_REQUEST["article"];
       $article = ArticlesController::getArticleByArticleID($request_article);
    }
    //Načtení recenzí podle id articlu
    $reviews = ReviewsController::getReviewByArticleID($article['ID']);
    //Načtení všech recenzentů
    $reviewers = UsersController::getAllReviewers();
    //Vytvoření choiceboxu na výběr recenzentů
    $choicebox = "";
        foreach ($reviewers as $option) {
            $choicebox .= "<option value = " . $option['ID'] . ">" . $option['USERNAME'] . "</option>";
        }
    //Kolik recenzentů je již přiděleno k tomuto článku    
    $sizeOfReviews = 3 - count($reviews);
    
    echo "
            <div class='container'>
	          <h2>Článek: " . $article['NAME'] . "</h2>
        	  <form class='form-horizontal' method = 'post'>
	         		<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>
	        		<input style='margin-top:5px;margin-bottom:5px;' type='submit' class='form-control btn-primary btn' name = 'setApproved' value='Schválit'>
        	  </form>
              <form class='form-horizontal' method = 'post'>
                    <input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>
                    <input style='margin-top:5px;margin-bottom:5px;' type='submit' class='form-control btn-danger btn' name = 'setRejected' value='Zamítnout'>
              </form>                                                                                
              <div class='table-responsive'>          
              <table class='table'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Téma</th>
                    <th>Originalita</th>
                    <th>Jazyk</th>
                    <th>Celkově</th>
                    <th>Recenzent</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>";
                    // Číslování řádek
                    $index = 0;
                    // Vypíšeme přidělené recenze
                    foreach ($reviews as $review) {
                        echo "<tr>";
                            echo "<td>" . $index . "</td>";
                            //Zjisti recenzenta k téhle recenzi
                            $reviewer = UsersController::getUserByID($review['REVIEWER_ID']);
                            //Vrat prumer této recenze
                            $avarage = ReviewsController::getAvarage($review['THEME'],$review['ORIGINALITY'],$review['LANGUAGE']);
                            $index++;
                            echo "<td>" . $review['THEME'] . "</td>";
                            echo "<td>" . $review['ORIGINALITY'] . "</td>";
                            echo "<td>" . $review['LANGUAGE'] . "</td>";
                            echo "<td>" . $avarage . "</td>";
                            echo "<td>" . $reviewer['USERNAME'] . "</td>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<input type='hidden' class='form-control' name = 'id_Review' value = '" . $review['ID'] . "'>";
                            echo "<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-danger' name = 'remove_Review' value = 'Smazat'></td>";
                            echo "</form>";                      
                        echo "</tr>";
                    }
                    //Vypíšeme zbylé řádky na přidání recenzenta
                    for ($i = 0; $i < $sizeOfReviews; $i++) {
                    	echo "<tr>";
                            echo "<td>" . $index . "</td>";
                            $index++;
                            echo "<td>N</td>";
                            echo "<td>N</td>";
                            echo "<td>N</td>";
                            echo "<td>N</td>";
                            echo "<td>N</td>";
                            echo "<form class='form-horizontal' method = 'post'>";
                            echo "<td><select name = 'reviewer' class = 'form-control'>" . $choicebox . " </select></td>";
                            echo "<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-primary' name = 'addReviewer' value='Přidat recenzenta'></td>"; 
                            echo "</form>";                       
                        echo "</tr>";
					}
                     echo "
                </tbody>
            </table>
            </div>
        </div>";  
}