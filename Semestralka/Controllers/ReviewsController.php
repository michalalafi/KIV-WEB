<?php

require_once('Data/Reviews.php');
require_once('Data/ConnectionSettings.php');

class ReviewsController
{
	/******************************************************
	/
	/ GETS REVIEWS
	/
	/
	/******************************************************/
	public static function getUserReviewsByUserID($ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$reviews = $db_reviews->getReviewsByUserID($ID);

		return $reviews;
	}

	public static function getReviewByArticleID($ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$review = $db_reviews->getArticleReviewByID($ID);

		return $review;
	}
	/******************************************************
	/
	/ REMOVES REVIEWS
	/
	/
	/******************************************************/
	public static function removeReviewByID($ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$db_reviews->removeReviewByID($ID);
	}

	public static function removeReviewsByArticleID($ID)
	{

		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$db_reviews->removeArticleReviewsByArticleID($ID);
		
	}

	public static function removeReviewsByReviewerID($ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$db_reviews->removeArticleReviewsByReviewerID($ID);
	}
	/******************************************************
	/
	/ SETS REVIEWS
	/
	/
	/******************************************************/
	public static function changeReview($ID,$ORIGINALITY,$THEME,$LANGUAGE,$NOTE)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$db_reviews->updateReview($ID,$ORIGINALITY,$THEME,$LANGUAGE,$NOTE);
	}

	public static function changeRewiewReviewerToDefault($ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$db_reviews->updateReviewByReviewerID($ID);
	}
	/******************************************************
	/
	/ ADDS REVIEWS
	/
	/
	/******************************************************/
	public static function AddEmptyReview($ID,$REVIEWER_ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();

		$db_reviews->inserEmptyReview($ID,$REVIEWER_ID);
	}
	/******************************************************
	/
	/ Pomocné metody
	/
	/
	/******************************************************/
	public static function getAvarage($ORIGINALITY,$THEME,$LANGUAGE)
	{
		//Podle vstupních hodnot vypočítá celkovou hodnotu recenze
		$sum = (float)$ORIGINALITY + (float)$THEME + (float)$LANGUAGE;
		$avarage =(float)$sum / (float)3;
		$precision = 2;
		//Zarovnaní na setiny
		return number_format((float) $avarage, $precision, '.', '');
	}

	public static function getAvarageOfReviewsToArticle($ID)
	{
		$db_reviews = new Reviews();

		$db_reviews->Connect();
		//Nalenezeni vsech rencenzi k určitemu článku 
		$reviews = $db_reviews->getArticleReviewByID($ID);

		//Nastaveni pole na nuly, pokud nebudou žádné recenze 0 zustane
		$avarageReview['ORIGINALITY'] = 0;
		$avarageReview['THEME'] = 0;
		$avarageReview['LANGUAGE'] = 0;
		$i = 0;
		if(isset($reviews) && isset($reviews[0]))
		{
			//Pro každou recenzi pricti hodnotu
			foreach ($reviews as $review) {
				$i++;
				$avarageReview['ORIGINALITY'] += (float)$review['ORIGINALITY'];
				$avarageReview['THEME'] += (float)$review['THEME'];
				$avarageReview['LANGUAGE'] += (float)$review['LANGUAGE'];
			}
			//Vyděl počtem recenzi
			$avarageReview['ORIGINALITY'] /= (float)$i;
			$avarageReview['THEME'] /= (float)$i;
			$avarageReview['LANGUAGE'] /= (float)$i;


			$precision = 2;
			//Zarovnani na setiny
			$avarageReview['ORIGINALITY'] = number_format((float) $avarageReview['ORIGINALITY'], $precision, '.', '');
			$avarageReview['THEME'] = number_format((float) $avarageReview['THEME'], $precision, '.', '');
			$avarageReview['LANGUAGE'] = number_format((float) $avarageReview['LANGUAGE'], $precision, '.', '');
		}
		return $avarageReview;
	}
	
	public static function getDefaultReview()
	{
			//Vrati pole hodnot s "-" pro článek, který je již vypublikovaný
			$avarageReview['ORIGINALITY'] = "-";
			$avarageReview['THEME'] = "-";
			$avarageReview['LANGUAGE'] = "-";

			return $avarageReview;
	}
}