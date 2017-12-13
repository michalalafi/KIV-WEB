<?php

require_once('Data/DatabasePDO.php');

class Articles extends db_pdo
{
    /******************************************************
    /
    / Komunikace s databazi Articles
    /
    /
    /******************************************************/
    public function selectAll()
    {
        $table_name = "ARTICLES";
        $columns = "*";

        $articles = $this->DBSelectAll($table_name, $columns, null);

        return $articles;
    }

    public function updateArticleState($ID,$STATE)
    {
        $table_name = "ARTICLES";

        $set['STATE'] = $STATE;

        $where = array();
        $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

        $this->DBUpdate($table_name, $where, $set);
    }
	public function findArticlesByUserID($userID)
	{

	    $table_name = "ARTICLES";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "AUTHOR_ID", "value" => $userID, "symbol" => "=");

        $articles = $this->DBSelectAll($table_name, $columns, $where);

        return $articles;

	}

	public function getAllArticlesByState($state)
	{
	   $table_name = "ARTICLES";
        $columns = "*";
        $where = array();
        $where[] = array("column" => "STATE", "value" => $state, "symbol" => "=");

        $articles = $this->DBSelectAll($table_name, $columns, $where);

        return $articles;
	}

    public function addArticle($AUTHOR_ID,$NAME,$ABSTRAKT,$AUTHORS,$CONTENT)
    {

        $table_name = "ARTICLES";

        $item['NAME'] = htmlspecialchars($NAME);
        $item['ABSTRAKT'] = htmlspecialchars($ABSTRAKT);
        if($CONTENT != ""){$item['CONTENT'] = htmlspecialchars($CONTENT);}
        $item['AUTHORS'] = htmlspecialchars($AUTHORS);
        $item['AUTHOR_ID'] = $AUTHOR_ID;
        $item['STATE'] = 'V procesu';

        $this->DBInsert($table_name, $item);

    }

    public function getArticleByArticleID($ID)
    {
        $table_name = "ARTICLES";   

        $columns = "*";
        $where = array();
        $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

        $article = $this->DBSelectOne($table_name, $columns, $where);

        return $article;
    }

    public function removeArticleByID($ID)
    {
        $table_name = "ARTICLES";
        $where = array();
        $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

        $this->DBDelete($table_name, $where,"LIMIT 8");
    }
    /******************************************************
    /
    / Pomocne metody
    /
    /
    /******************************************************/
    public function insertFile($FILE)
    {
        //Složka kam se ukládají soubory
        $target_path = "Documents/";

        $target_path = $target_path . basename( $FILE['file']['name']);

        $CONTENT = basename( $FILE['file']['name']);
        //1 je uspech, 0 neuspech nahraní souboru
        if(move_uploaded_file($FILE['file']['tmp_name'], $target_path)) {
                $actionResult = 1;
        } 
        else{
                $actionResult = 0;
        }
        return $actionResult;
    }
}