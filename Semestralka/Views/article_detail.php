<?php
require_once('Controllers/LoginController.php'); 
require_once('Controllers/ArticlesController.php');

if(isset($_POST['id_Article']))
{
	//Podle id Articlu najdeme článek
	$article = ArticlesController::getArticleByArticleID($_POST['id_Article']);

	echo "<div class = 'container'>"; 
		echo "<div class='col-xs-4'>";
			echo "<h3>" . $article['NAME'] . "</h3><br>";
			echo "<h4> <b>Autoři: </b>" . $article['AUTHORS'] . "</h4><br>";
			echo "<h4> <b>Abstrakt: </b> </h4><br>";
			echo "<h5>" . $article['ABSTRAKT'] . "</h5><br>";
		if(isset($article['CONTENT']))
		{
			echo "<a href='./Documents/" . $article['CONTENT'] . "' download>Stáhnout článek</a><br>";
		}
		else
		{
			echo "<p><b>PDF nenalezeno</b></p><br>";
		}
		echo "</div>";

		if(isset($article['CONTENT']))
		{
			echo "<div class='pdf col-xs-8'>";
				echo "<embed src='./Documents/" . $article['CONTENT'] . "' width='100%' height='800px' />";
			echo "</div>";
		}
		else
		{
			echo "<div class='col-xs-8'>";
			echo "</div>";
		}
	echo "</div><hr>";
}