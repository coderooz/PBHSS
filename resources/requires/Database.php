<?php

class Database {
	private $host;	private $user;	private $pwd;	private $dbName;	private $pdo;

	/**
	 * @param string $host
	 * @param string $user
	 * @param string $dbName
	 * @param string $pwd
	 * @param bool $create_table
	 */
	public function __construct($dbName, $pwd, $host = 'sql305.epizy.com', $user = 'epiz_31902692') {
		$this->host=$host;	$this->user = $user;
		$this->pwd = $pwd;	$this->dbName = $dbName;
		$this->pdo = new PDO('mysql:host='.$this->host.';', $this->user, $this->pwd);
	}

	/**
	 * @param bool(true|false) creat_db
	 */
	public function connect_db($creat_db=false){
		try{
			$this->pdo->query("use $this->dbName");
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $this->pdo;
		} catch (PDOException $e){
			die('Sorry! A problem occured. Problem-> '.$e->getMessage());
		}
	}

	/**
	 * function DbExists() checks if the database exists or not.
	 * @return bool(true|false)
	 */
	public function DbExists() {
		return in_array($this->dbName, $this->db_List());
	}

	/**
	 * function db_List() gets the list of all the databases available by the user.
	 * @return array
	 */
	public function db_List() {
		return $this->pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
	}

	/**
	 * function createDb creates database only if the database do not exists.
	 * @return null
	 */
	public function createDb(){
		try{if ($this->DbExists()==false){
				$this->pdo->query("CREATE DATABASE `$this->dbName`");
			}}catch(PDOException $e){die('Sorry! A problem occured. Problem-> '.$e->getMessage());
		}
	}

	/**
	 * function delete_db deletes the database if it exists.
	 * @return null
	*/
	public function delete_db(){
		try{if($this->DbExists()){$this->pdo->query("DROP DATABASE `$this->dbName`");}}catch (PDOException $e){die('Sorry! A problem occured. Problem-> '.$e->getMessage());}
	}

}