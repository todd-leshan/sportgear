<?php

require_once __DIR__."/DB.php";

class CRUD
{
	private $_conn;

	//connect to DB
	public function __construct()
	{
		$this->_conn = DB::getConnection();
	}

	public function __destruct()
	{
		DB::disconnect();
	}


	/*
	*return an array
	*/
	public function executeSQL($prepareSQL, $param = [])
	{
		try 
		{
			$sql = $this->_conn->prepare($prepareSQL);
			$sql->execute($param);

			$rows = $sql->fetchAll();
			return $rows;
		} 
		catch (PDOException $e) 
		{
			echo $e->getMessage();
		}	
	}

	public function select($table)
	{
		$sql = "SELECT *
				FROM $table";

		$rows = $this->executeSQL($sql);

		return $rows;
	}

	/*
	*insert into CRUD and return the last insert ID
	*@param: $conn, $prepareSQL, $param
	*/
	public function insert($table, $data)
	{
		$columns = array();
		$values  = array();
		$q       = array();
		foreach ($data as $key => $value) {
			array_push($columns, $key);
			array_push($values, $value);
			array_push($q,'?');
		}

		$column = implode(',', $columns);
		$qs     = implode(',', $q);

		$prepare = "INSERT INTO $table($column) VALUES($qs)";

		$query = $this->_conn->prepare($prepare);

		$query->execute($values);

		$newID = $this->_conn->lastInsertId();

		return $newID;		
	}

	/*
	*return total number of records of a table
	*/
	public function total($table, $data = [])
	{
		$i = 1;
		$j = sizeof($data);
		$param = array();
		$sql = "SELECT COUNT(*)
				FROM $table";

		if($j > 0)
		{
			$sql .= " WHERE ";

			foreach ($data as $key => $value) {
				$sql .= $key.'=:'.$key;

				$param[":$key"] = $value;

				if($i < $j)
				{
					$sql .= ' AND ';
				}
				$i++;
			}	
		}

		$total = $this->executeSQL($sql, $param);

		return (int)$total[0][0];
	}

	/*
	*check sth's existence
	*/
	
	/*
	public function isExist($conn, $table, $data)
	{
		$columns = array();
		$values  = array();
		foreach ($data as $key => $value) {
			array_push($columns, $key);
			array_push($values, $value);
			array_push($q,'?');
		}

		$column = implode('	AND ', $columns);
		$qs     = implode(',', $q);

		$prepare = "SELECT * FROM {$table} WHERE {}";
	}
	*/

	/*
More functions need to be defined here
sql query maker, query execute, different types
	*/
}//end of class
