<?php
require_once('Controllers/ArticlesController.php');
require_once('Controllers/LoginController.php');
//Pro všechny uživatele, kteří jsou Autoři
if(LoginController::getUserInfo('ROLE')=="Author"){
		//Vložení nového článku
		if(isset($_POST['upload']))
		{
			$new_article = $_POST['newArticle'];
			$user_ID = LoginController::getUserInfo("ID");
		  	$name = $new_article['name'];
		  	//Vložení článku
			$result = ArticlesController::addArticle($user_ID,$name,$new_article['abstrakt'],$new_article['authors']);

			if($result == 1)
			{
				//Redirect na my_articles
				header('Location: index.php?page=my_articles');
			}
			else
			{
				echo $result;
			}
		}
		else
		{
			// Výpis formuláře
			echo "

			<div class = 'container'>
			    <h1> Nový článek </h1>
			    <form class='form-horizontal' id = 'naform' method = 'post' enctype='multipart/form-data'>
			      <div class='form-group'>
			        <label class='control-label col-sm-2' for='aname'>Název</label>
			        <div class='col-sm-10'>
			          <input type='text' class='form-control' id='aname' placeholder='Vložte název' name='newArticle[name]' required>
			        </div>
			      </div>
			      <div class='form-group'>
			        <label class='control-label col-sm-2' for='authors'>Autoři:</label>
			        <div class='col-sm-10'> 
			          <input type='text' class='form-control' id='authors' placeholder='Vložte jména autorů' name='newArticle[authors]' required>
			        </div>
			      </div>
			      <div class='form-group'>
			        <label class='control-label col-sm-2' for='abstract'>Abstrakt:</label>
			        <div class='col-sm-10'> 
			          <textarea form='naform'  class='form-control' id='abstract' placeholder='Zde napište abstrakt' name='newArticle[abstrakt]' required></textarea>
			        </div>
			      </div>
			      <div class='form-group'>
			        <label class='control-label col-sm-2' for='file'>PDF soubor:</label>
			        <div class='col-sm-10'> 
			          <input type='file' class='form-control' id='file' name ='file'>
			        </div>
			      </div>
			      <div class='form-group'>
			      	<div class='col-sm-2'></div>
			        <div class='col-sm-2'> 
			          <input type='submit' class='form-control btn-primary' name = 'upload'>
			        </div>
			      </div>
			    </form>
			</div>
			";
		}
}