<?php

require_once('Data/Articles.php');
require_once('Data/ConnectionSettings.php');

class ArticlesController
{
	/******************************************************
	/
	/ ADDS ARTICLES
	/
	/
	/******************************************************/
	public static function addArticle($AUTHOR_ID,$NAME,$ABSTRAKT,$AUTHORS)
	{
		$db_articles = new Articles();

		$db_articles->Connect();

        $actionResult = 1;
        //Pokud nebyl zvolen pdf soubor
		if(($_FILES['file']['name']) == "")
		{
			return "<script>alert('Nebylo zvoleno žádné pdf, nahrajte článek znovu!');</script>";
		}
		else
		{
			//Nastav jmeno souboru k clanku a vlož soubor do složky
			$CONTENT = basename( $_FILES['file']['name']);
			$result = $db_articles->insertFile($_FILES);
			if($result == 0)
			{
				return "<script>alert('Během nahrávání souboru došlo k chybě, zkuste to, prosím, znovu!');</script>";
			}
		}


		$db_articles->addArticle($AUTHOR_ID,$NAME,$ABSTRAKT,$AUTHORS,$CONTENT);

		return $actionResult;

	}
	/******************************************************
	/
	/ GETS ARTICLES
	/
	/
	/******************************************************/
	public static function getAllArticles()
	{
		$db_articles = new Articles();

		$db_articles->Connect();

		$articles = $db_articles->selectAll();

		return $articles;
	}

	public static function getArticlesByState($STATE)
	{
		$db_articles = new Articles();

		$db_articles->Connect();

		$articles = $db_articles->getAllArticlesByState($STATE);

		return $articles;
	}

	public static function getArticleByArticleID($ID)
	{
		$db_articles = new Articles();

		$db_articles->Connect();

		$article = $db_articles->getArticleByArticleID($ID);

		return $article; 
	}

	public static function getArticlesByUserID($ID)
	{

		$db_articles = new Articles();

		$db_articles->Connect();

		$articles = $db_articles->findArticlesByUserID($ID);

		return $articles;
	}
	/******************************************************
	/
	/ SETS ARTICLES
	/
	/
	/******************************************************/
	public static function setArticleState($ID,$STATE)
	{
		$db_articles = new Articles();

		$db_articles->Connect();

		$articles = $db_articles->updateArticleState($ID,$STATE);
	}
	public static function changeArticle($ARTICLE_ID,$AUTHOR_ID,$NAME,$ABSTRAKT,$AUTHORS)
	{

	  $db_articles = new Articles();

	  $db_articles->Connect();

	  $actionResult = "Článek byl úspěšně změněn <br /> <a href='index.php?page=my_articles'>Zpět na seznam</a>";
      $CONTENT = "";
      //Byl změněn i článek?
      if(($_FILES['file']['name']) != "")
      {
      		$CONTENT = basename( $_FILES['file']['name']);

      		$result = $db_articles->insertFile($_FILES);
			if($result == 0)
			{
				return "Během nahrávání souboru došlo k chybě, zkuste to, prosím, znovu!";
			}
      }
	  $db_articles->addArticle($AUTHOR_ID,$NAME,$ABSTRAKT,$AUTHORS,$CONTENT);

	  return $actionResult;
	}
	/******************************************************
	/
	/ REMOVE ARTICLES
	/
	/
	/******************************************************/
	public static function removeArticle($ID)
	{
		$db_articles = new Articles();

		$db_articles->Connect();

		$db_articles->removeArticleByID($ID);

	}


}