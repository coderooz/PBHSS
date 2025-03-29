<?php

/**
 * DbController is a class that has the ability to handle database related queries and execite them.
 */
class DbController{

	protected $database;
	public function __construct($dbConn){$this->database = $dbConn;}

	/**
	 * CountData is a function that counts the number of data of certain parameter in tha database.
	 * @param string $tableName
	 * @param string $rowsReq
	 * @param string $params
	 * @return int
	 */
	public function CountData($tableName, $rowsReq='*', $params='') {
		return $this->database->query("SELECT $rowsReq FROM $tableName $params")->rowCount();
	}

	/**
	 * Update function updates data in a given table that satifies the query
	 * @param string $tableName
	 * @param string $params
	 * @param string $UpdateOn
	 * @return int 1 for true & 0 for false
	 * -------
	 * Update( string $tableName, string $params , string $UpdateOn ) : int
	 */
	public function Update($tableName, $params, $UpdateOn = '') {
		$Sql = "UPDATE $tableName SET $params $UpdateOn";
		if($this->database->query($Sql)){
			return 1;
		}
		return 0;
	}

	/**
	 * Delete function deletes the data in a specific table that satisfies a given parameter.
	 * @param string $tableName      
	 * @param string $params      
	 * @return null
	 */
	public function Delete($tableName, $params) {
		$SQL = "DELETE FROM $tableName $params";
		$this->database->query($SQL);
	}


	/**
	 * Fetch function queries the database to get data from the given table.
	 * @param string $tableName Takes the name of the table.
	 * @param string $tableRows Takes the coloumns that are to be fetched[default is '*' which gets all the colouns]
	 * @param string $quries Takes the conditional data that is to be fetched by.
	 * @param bool $fetchType 
	 * @return int||array 
	*/

	public function Fetch($tableName, $tableRows='*', $quries='', $fetchType=true) {
		if ($this->CountData($tableName, $tableRows, $quries) > 0) {
			$Sql = "SELECT $tableRows FROM `$tableName` $quries";
			$stmt = $this->database->query($Sql);
			if ($fetchType == true) {
				while ($rows[] = $stmt->fetchAll());
			} elseif($fetchType == false) {
				while ($rows[] = $stmt->fetch());
			}
			return $rows;
		}
		return 0;
	}

	/**
	 * @param string $tableName Takes the name of the table.
	 * @param string $coloums Takes the coloums in which the data is to be inserted.
	 * @param array|string $values Takes the parameters that is to be inserted.
	 * @return bool
	 */
	public function Insert($tableName, $coloums, $values){
		if(is_array($values)){
			$data = implode(',',$values);
			$result = $this->database->query("INSERT INTO `$tableName` ($coloums) VALUES $data;");
		} else {
			$result = $this->database->query("INSERT INTO `$tableName` ($coloums) VALUES $values");
		}
		if ($result) {return true;} else{return false;}
	}

	/**
	 * function TbExists() checks the table exists in the given database.
	 * @param string $tableName
	 * @return bool
	 */
	public function TbExists($tableName){return in_array($tableName, $this->tableList());}

	/** 
	 * function tableList() gets the list of all the table available in the specified database.
	 * @return array
	 */
	public function tableList(){return $this->database->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);}

	/**
	 * 
	 * @param string $tableName
	 * @param string $tableRows
	 * @return array
	 */
	public function getFullData($tableName, $tableRows = '*') {return $this->database->query("EXPLAIN SELECT $tableRows FROM `$tableName`");}

	/**
	 * function createTables creates tables in the provided database.
	 * 
	 * @param string $tableName
	 * @param string $tableColoumes
	 * @param bool $addId
	 * @param string $CHARSET
	 * @param string $COLLATE
	 * @param string $engine
	 * @param string $comment
	 * @return null
	 * 
	 * How to add id:-
	 * - To add id add [`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)] in the coloums sections.
	 * - Or add pass value true in '$addId' paramenter and it will automaically added; 
	 * 
	 * How to write the tableColoumes OR add coloums:-
	 * - Add coloum `Name`-> `ColoumName`;
	 * - Add type (TEXT/INT/VARCHAR/TIMESTAMP)
	 * 	  1. (If TEXT) == `ColoumName` TEXT;(If the coloum contains text, string, or somthing else whose length is unknowwn to you.Recommended `TEXT` as it can take very long strings and even numbers like 123456789.)
	 * 	  2. (If INT) == `ColoumName` INT;
	 *    3. (If VARCHAR) == `ColoumName` VARCHAR; 
	 * 	  4. (If TIMESTAMP)	== `ColoumName` VARCHAR; 
	 * 	Note:- To add specify the number of charecters tahat each row will store add (Number) behind the type like TEXT(12). If you select `VARCHAR` then you need  to specify the number of text charecters(MAX:-255);
	 * - Add [NOT NULL] or [NULL]
	 * - For adding default value like the time when the data is entered, specify [DEFAULT CURRENT_TIMESTAMP]. This will automatically fill the box if empty with the current timestamp.
	 * - For add in comment to the coloum add [COMMENT >YOUR_COMMENT_HERE<]  	
	 * 	- After adding all the required contents, add comma(,) to seperate one coloum form one another and then repeate the same process for the other coloum.
	 * 
	 * 
	 * 
	 * Example Table:-
	 * CREATE TABLE `DataBase Name`.`TableName`(
	 *  	`id` INT NOT NULL AUTO_INCREMENT,
	 *  	`table_coloumn_1_name` TEXT NOT NULL COMMENT 'table coloumn comment', 
	 * 		`table_coloumn_2_name` TEXT NOT NULL COMMENT 'table coloumn comment', 
	 * 		`table_coloumn_3_name` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'table coloumn comment', 
	 * 		PRIMARY KEY (`id`)
	 * ) ENGINE = InnoDB CHARSET=utf32 COLLATE utf32_unicode_ci
	 *  COMMENT = 'Your Comment';
	 * 
	 */

	public function createTables($tableName, $tableColoumes, $addId=true, $comment='', $CHARSET='utf32', $COLLATE='utf32_unicode_ci', $engine='InnoDB') {
		if ($this->TbExists($tableName)===false) {
			$sqlString='';
			if ($addId){$sqlString.= "`id` INT NOT NULL AUTO_INCREMENT,PRIMARY KEY (`id`),";}
			$sqlString.=$tableColoumes;
			$this->database->query("CREATE TABLE `$tableName`($sqlString)ENGINE=$engine CHARSET=$CHARSET COLLATE $COLLATE COMMENT='$comment';");
		}
	}


	/**
	 * This function 'alterTable use is to add coloums in the table.'
	 * @param string $tableName Takes the table name
	 * @param string $type Takes values 'ADD|DROP'.
	 * @param string $addColoum 
	 * @return null
	 * - If $type is add the value passed should be [`>COLOUM_NAME_TO_ADD<` TEXT NOT NULL AFTER `>WHICH_TABLE_NAME<`] OR [`>COLOUM_NAME_TO_ADD<` TEXT NOT NULL FIRST] and if the selected drop then the value passed should be only the coloum name.
	 * - If the type is add then the complete query should be like [ALTER TABLE `TABLENAME` ADD `>COLOUM_NAME_TO_ADD<` TEXT NOT NULL AFTER `>WHICH_TABLE_NAME<`] OR [ALTER TABLE `TABLENAME` ADD `>COLOUM_NAME_TO_ADD<` TEXT NOT NULL FIRST] if you need to add to coloumn at the beggining of the table.
	 * - if the type is drop then the complete query should be like [ALTER TABLE `TABLENAME` DROP `>COLOUM_NAME<`].
	*/
	public function alterTable($tableName, $type, $addColoum){$this->database->query("ALTER TABLE `$tableName` ".strtoupper($type)." $addColoum");}

	/**
	 * This function cleanTable cleans the table and deletes all the data in the table.
	 * @param string $tableName Takes the name of the table.
	 * @return null  
	 */
	public function cleanTable($tableName){$this->database->query("TRUNCATE `$tableName`");}

	/**
	 * This function deleteTable deletes the table from the database.
	 * @param string $tableName Takes the name of the table that is to be removed.
	 * @return null
	 */
	public function deleteTable($tableName){$this->database->query("DROP TABLE `$tableName`");}

	/**
	 * This function gets the list of index in a given table
	 * @param string $tableName Takes the name of the table.
	 * @return array
	 */
	public function indexList($tableName){return $this->database->query("SHOW INDEX FROM $tableName")->fetchAll(PDO::FETCH_COLUMN);}

	/**
	 * This function gets looks if the index specified exists in the table or not.
	 * @param string $tableName Takes the name of the table.
	 * @param string $indexName Takes the name of the index.
	 * @return bool
	 */
	public function indexExist($tableName, $indexName){
		# code...
	}

	/**
	 * This function gets the creates indexes in the specified table
	 * @param string $tableName Takes the name of the table.
	 * @param string $index Takes the name of the table.
	 * @param string $indexName Takes the name of the table.
	 * @return bool
	 */
	public function createIndex($tableName, $index, $indexName){
		# code...
	}
}