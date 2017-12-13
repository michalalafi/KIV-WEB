<?php

require_once('Data/DatabasePDO.php');

class Reviews extends db_pdo
{
    /******************************************************
    /
    / Komunikace s databazi Reviews
    /
    /
    /******************************************************/
    public function inserEmptyReview($ID,$REVIEWER_ID)
    {
        $table_name = "REVIEWS";

        $item['ARTICLE_ID'] = $ID;
        $item['REVIEWER_ID'] = $REVIEWER_ID;
        $item['ORIGINALITY'] = 0;
        $item['THEME'] = 0;
        $item['LANGUAGE'] = 0;

        $this->DBInsert($table_name, $item);
    }

	public function getReviewsByUserID($ID)
	{
	    $table_name = "REVIEWS";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "REVIEWER_ID", "value" => $ID, "symbol" => "=");

        $info = $this->DBSelectAll($table_name, $columns, $where);

        return $info;
	}

	public function getArticleReviewByID($ID)
	{
	    $table_name = "REVIEWS";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "ARTICLE_ID", "value" => $ID, "symbol" => "=");

        $info = $this->DBSelectAll($table_name, $columns, $where);

        return $info;
	}

    public function removeReviewByID($ID)
    {
        $table_name = "REVIEWS";
        $where = array();
        $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

        $this->DBDelete($table_name, $where,"LIMIT 8");
    }
    
    public function removeArticleReviewsByArticleID($ID)
    {
        $table_name = "REVIEWS";
        $where = array();
        $where[] = array("column" => "ARTICLE_ID", "value" => $ID, "symbol" => "=");

        $this->DBDelete($table_name, $where,"LIMIT 8");
    }

    public function removeArticleReviewsByReviewerID($ID)
    {
        $table_name = "REVIEWS";
        $where = array();
        $where[] = array("column" => "REVIEWER_ID", "value" => $ID, "symbol" => "=");

        $this->DBDelete($table_name, $where,"LIMIT 8");
    }

    public function updateReview($ID,$ORIGINALITY,$THEME,$LANGUAGE,$NOTE)
    {
        $table_name = "REVIEWS";

        $set['ORIGINALITY'] = $ORIGINALITY;
        $set['THEME'] = $THEME;
        $set['LANGUAGE'] = $LANGUAGE;
        $set['NOTE'] = htmlspecialchars($NOTE);

        $where = array();
        $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

        $this->DBUpdate($table_name, $where, $set); 
    }
    public function updateReviewByReviewerID($ID)
    {
        $table_name = "REVIEWS";

        $set['REVIEWER_ID'] = 0;


        $where = array();
        $where[] = array("column" => "ARTICLE_ID", "value" => $ID, "symbol" => "=");

        $this->DBUpdate($table_name, $where, $set); 
    }
}
