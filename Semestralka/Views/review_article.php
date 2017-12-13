<?php

require_once('Controllers/ReviewsController.php');
require_once('Controllers/LoginController.php'); 
require_once('Controllers/ArticlesController.php');
//Pro všechny uživatele kteří jsou Recenzenti
if(LoginController::getUserInfo('ROLE')=="Reviewer"){
        //Recenzuj článek
        if(isset($_POST['review']))
        {
           //Pokud byla vypsáno poznámka
           if(isset($_POST['note']))
           {
              //Přidej recenzi
              ReviewsController::changeReview($_POST['review_id'],$_POST['originality'],$_POST['theme'],$_POST['language'],$_POST['note']);
           }
           else
           {
              //Přidej recenzi
              ReviewsController::changeReview($_POST['review_id'],$_POST['originality'],$_POST['theme'],$_POST['language'],"");
           }
           //Redirect na articles_toreview
           header('Location: index.php?page=articles_toreview');
        }
        //Načteme článek podle ID
        $article = ArticlesController::getArticleByArticleID($_POST['article_id']);

        // Vypíšeme článek
        echo "<div class = 'container'>";   
            echo "<h3> Název: " . $article['NAME'] . "</h3><br>";
            echo "<h4> Autoři: " . $article['AUTHORS'] . "</h4><br>";
            echo "<h4> Abstrakt: " . $article['ABSTRAKT'] . "</h4><br>";
            //Pokud bylo přidáno PDF
            if(isset($article['CONTENT']))
            {
              echo "<a href='./Documents/" . $article['CONTENT'] . "' download>Stáhnout článek</a><br>";
            }
            else
            {
              echo "<h4>Nebylo přidáno PDF</h4><br>";
            }
        echo "</div><hr>";
        //Choicebox pro hodnocení
        $choicebox = "<option value=''>Vyberte zde</option>
          <option value='1'>Nedoporučuji</option>
          <option value='2'>Podprůměr</option>
          <option value='3'>Průměr</option>
          <option value='4'>Nadprůměr</option>
          <option value='5'>Výborné</option>";
        // Formulář pro hodnocení
        echo "
        <div class = 'container'>
            <form class='form-horizontal' id = 'naform' method = 'post' action = ''>
              <div class='form-group'>
                <label class='control-label col-sm-2' for='originality'>Originalita</label>
                <div class='col-sm-10'>
                  <select class='form-control' name = 'originality' required>$choicebox</select>
                </div>
              </div>
              <div class='form-group'>
                <label class='control-label col-sm-2' for='theme'>Téma</label>
                <div class='col-sm-10'> 
                  <select class='form-control' name = 'theme' required>$choicebox</select>
                </div>
              </div>
              <div class='form-group'>
                <label class='control-label col-sm-2' for='language'>Jazyk</label>
                <div class='col-sm-10'> 
                  <select class='form-control' name = 'language' required>$choicebox</select>
                </div>
              </div>
              <div class='form-group'>
                <label class='control-label col-sm-2' for='note'>Poznámka</label>
                <div class='col-sm-10'> 
        	        <textarea form='naform'  class='form-control' id='note' placeholder='Zde napište poznámku' name='note'></textarea>
        	       </div>
              </div>
              <div class='col-sm-2'></div>
              <div class='col-sm-2'>
                <div class='form-group'>
                    <input type = 'hidden' name = 'review_id' value = '". $_POST['review_id'] ."' >
                    <input type = 'hidden' name = 'article_id' value = '". $_POST['article_id'] ."' >
                    <input type='submit' class='form-control btn-primary' name = 'review' value='Potvrdit' >
                </div>
              </div>
            </form>
        </div>
        ";
      }