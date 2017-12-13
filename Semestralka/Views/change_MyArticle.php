<?php
require_once('Controllers/ArticlesController.php');
require_once('Controllers/ReviewsController.php');
require_once('Controllers/LoginController.php');

//Pro uživatele kteří jsou Autoři
if(LoginController::getUserInfo('ROLE')=="Author"){
        if(isset($_POST['change_MyArticle']))
        {
                    //Načtu si upravovaný článek a předvyplním formulář získanýma údajema
                    $article = ArticlesController::getArticleByArticleID($_POST['id_MyArticle']);
                    echo "
                    
                    <div class = 'container'>
                        <form class='form-horizontal' id = 'naform' method = 'post' enctype='multipart/form-data'>
                          <div class='form-group'>
                            <label class='control-label col-sm-2' for='aname'>Název</label>
                            <div class='col-sm-10'>
                              <input type='text' class='form-control' id='aname' value = '" . $article['NAME']. "' name='changeArticleData[name]'>
                            </div>
                          </div>
                          <div class='form-group'>
                            <label class='control-label col-sm-2' for='authors'>Autoři:</label>
                            <div class='col-sm-10'> 
                              <input type='text' class='form-control' id='authors' value='" . $article['AUTHORS'] . "' name='changeArticleData[authors]'>
                            </div>
                          </div>
                          <div class='form-group'>
                            <label class='control-label col-sm-2' for='abstract'>Abstrakt:</label>
                            <div class='col-sm-10'> 
                              <textarea form='naform'  class='form-control' id='abstract' name='changeArticleData[abstrakt]'>" . $article['ABSTRAKT'] ."</textarea>
                            </div>
                          </div>
                          ";

                          echo"
                          <div class='form-group'>
                            <label class='control-label col-sm-2' for='file'>PDF soubor:</label>
        			              <div class='col-sm-10'>";
                                //Pokud bylo přidáno PDF
                                if(isset($article['CONTENT']))
                                {
                                  echo "<p>Aktualni soubor:" . $article['CONTENT'] . "</p>";
                                }
                           echo"     
        			                 <input type='file' class='form-control' id='file' name ='file' value='Documents/" . $article['CONTENT'] ."'>
        			               </div>
                          </div>
                          <div class='form-group'>
                            <div class='col-sm-2'></div>
                            <div class='col-sm-2'> 
                              <input type='submit' class='form-control btn-primary' name = 'do_change' value = 'Změnit'>
                            </div>
                            <div class='col-sm-2'>
                                <input type='submit' class='form-control btn-warning' name = 'exit' value = 'Zrušit'>
                                <input type='hidden' class='form-control' name = 'id_MyArticle' value = '" . $article['ID'] . "'>
                            </div>
                          </div>
                        </form>
                    </div>
                    
                ";
        }
        // Pokud chci změnit článek
        if (isset($_POST['do_change'])) {
             
            $data = $_POST['changeArticleData'];
            //Vymažu vsechny recenze vztahujici se k tomuto clanku
           	ReviewsController::removeReviewsByArticleID($_POST['id_MyArticle']);
            ArticlesController::removeArticle($_POST['id_MyArticle']);
            
        	  $user_ID = LoginController::getUserInfo("ID");
            //Změním článek
            ArticlesController::changeArticle($_POST['id_MyArticle'],$user_ID,$data['name'],$data['abstrakt'],$data['authors']);
            //Redirect na my_articles
            header('Location: index.php?page=my_articles');
        }
}