<?php

	require_once('Data/DatabasePDO.php');

	class Users extends db_pdo
	{
        /******************************************************
        /
        / Komunikace s databazi Users
        /
        /
        /******************************************************/
        public function getUserByUserName($USERNAME)
        {
            $table_name = "USERS";
            $columns = "*";
            $where = array();
            $where[] = array("column" => "USERNAME", "value" => $USERNAME, "symbol" => "=");

            $info = $this->DBSelectAll($table_name, $columns, $where);

            return $info;
        }
        
        public function selectUserByID($ID)
        {
            $table_name = "USERS";
            $columns = "*";
            $where = array();
            $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

            $info = $this->DBSelectOne($table_name, $columns, $where);

            return $info;
        }

        public function selectAll()
        {
            $table_name = "USERS";
            $columns = "*";
            $users = $this->DBSelectAll($table_name,  $columns, null);

            return $users;
        }

        public function createUser($USERNAME,$PASSWORD)
        {
            $table_name = "USERS";

            $item['USERNAME'] = htmlspecialchars($USERNAME);
            $item['PASSWORD'] = htmlspecialchars($PASSWORD);
            $item['ROLE'] = "Author";

            $this->DBInsert($table_name, $item);

        }

        public function getUsersByRole($ROLE)
        {
            $table_name = "USERS";
            $columns = "*";
            $where = array();
            $where[] = array("column" => "ROLE", "value" => $ROLE, "symbol" => "=");

            $users = $this->DBSelectAll($table_name, $columns, $where);

            return $users;
        }

        public function updateUser($ID,$USERNAME,$ROLE)
        {
            $table_name = "USERS";

            $set['USERNAME'] = htmlspecialchars($USERNAME);
            $set['ROLE'] = $ROLE;

            $where = array();
            $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

            $this->DBUpdate($table_name, $where, $set);
        }

        public function removeUser($ID)
        {
            $table_name = "USERS";

            $where = array();
            $where[] = array("column" => "ID", "value" => $ID, "symbol" => "=");

            $this->DBDelete($table_name, $where,"LIMIT 8");
        }
	}