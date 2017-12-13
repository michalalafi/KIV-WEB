<?php

require_once('Data/Users.php');
require_once('Data/ConnectionSettings.php');


class UsersController
{
	/******************************************************
	/
	/ ADDS USERS
	/
	/
	/******************************************************/
	public static function registerUser($username,$password)
	{
		$db_users = new Users();
 		$db_users->Connect();

 		$db_users->createUser($username,$password);
	}
	/******************************************************
	/
	/ GETS USERS
	/
	/
	/******************************************************/
	public static function getUserByID($ID)
	{
		$db_users = new Users();

 		$db_users->Connect();

 		$user = $db_users->selectUserByID($ID);

 		return $user;
	}
	public static function getAllUsers()
	{
		$db_users = new Users();
 		$db_users->Connect();

 		$users = $db_users->selectAll();

 		return $users;
	}
	public static function getAllReviewers()
	{
		$db_users = new Users();

 		$db_users->Connect();

 		$users = $db_users->getUsersByRole("Reviewer");

 		return $users;
	}
	/******************************************************
	/
	/ SETS USERS
	/
	/
	/******************************************************/
	public static function updateUser($ID,$USERNAME,$ROLE)
	{
		$db_users = new Users();

 		$db_users->Connect();

 		$users = $db_users->updateUser($ID,$USERNAME,$ROLE);

	}
	/******************************************************
	/
	/ REMOVES USERS
	/
	/
	/******************************************************/
	public static function removeUser($ID)
	{
		$db_users = new Users();

 		$db_users->Connect();

 		$users = $db_users->removeUser($ID);
	}
	/******************************************************
	/
	/ Pomocné metody
	/
	/
	/******************************************************/
	public static function isUserNameAvaible($USERNAME,$USERS)
	{
		$found = 0;
		foreach ($USERS as $record) {
			if($record['USERNAME']==$USERNAME)
			{
				$found = 1;
			}
		}
		return $found;
	}

}