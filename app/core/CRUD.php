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
			//echo 'Error:'.$prepareSQL.' '.$e->getMessage();
			echo "System Error!code - 1123";
		}	
	}

	public function select($table, $data = [])
	{
		$sql = "SELECT *
				FROM $table";

		$i = 1;
		$j = sizeof($data);
		$param = array();

		if($j > 0)
		{
			$sql .= " WHERE ";

			foreach ($data as $key => $value) {
				$sql .= $key.'=:'.$key;

				//$param[":$key"] = $value;


				if($i < $j)
				{
					$sql .= ' AND ';
				}
				$i++;
			}	
		}

		try
		{
			$stmt = $this->_conn->prepare($sql);
			$i = 1;
			$j = sizeof($data);
			$param = array();

			if($j > 0)
			{
				foreach ($data as $key => $value) {
					$stmt->bindValue(":$key", $value);
				}	
			}

			$stmt->execute();
			$rows = $stmt->fetchAll();

			return $rows;
		}
		catch (PDOException $e) 
		{
			echo 'Error:'.$sql.' '.$e->getMessage();
		}	
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

		$prepare = "INSERT INTO $table ($column) VALUES ($qs)";

		try
		{
			$query = $this->_conn->prepare($prepare);

			$query->execute($values);

			$newID = $this->_conn->lastInsertId();

			return $newID;	
		}
		catch(PDOException $e)
		{
			echo 'Insert Error:'.$e->getMessage();
		}		
	}

	/*
	public function insert($table, $data)
	{
		$columns = array();
		$values  = array();
		$q       = array();
		foreach ($data as $key => $value) {
			array_push($columns, $key);
			array_push($values, $value);
			array_push($q,":$key");
		}

		$column = implode(',', $columns);
		$qs     = implode(',', $q);

		$prepare = "INSERT INTO $table ($column) VALUES ($qs)";

		try
		{
			$stmt = $this->_conn->prepare($prepare);

			foreach ($data as $key => $value) 
			{
				$stmt->bindValue(":$key", $value);
			}
			$stmt->execute($values);

			$newID = $this->_conn->lastInsertId();

			return $newID;	
		}
		catch(PDOException $e)
		{
			echo 'Insert Error:'.$e->getMessage();
		}

			
	}
*/
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

	public function update($table, $columns, $limits)
	{
		$sql = "UPDATE $table
				SET ";

		$i = 1;
		$j = sizeof($columns);
		$param = array();

		if($j > 0)
		{
			foreach ($columns as $key => $value) {
				$sql .= $key.'=:'.$key;

				$param[":$key"] = $value;

				if($i < $j)
				{
					$sql .= ' , ';
				}
				$i++;
			}	
		}

		$i = 1;
		$j = sizeof($limits);

		if($j > 0)
		{
			$sql .= ' WHERE ';
			foreach ($limits as $key => $value) {
				$sql .= $key.'=:'.$key;

				$param[":$key"] = $value;

				if($i < $j)
				{
					$sql .= ' , ';
				}
				$i++;
			}	
		}

		$stmt = $this->_conn->prepare($sql);

		$stmt->execute($param);

		$rowAffected = $stmt->rowCount();

		return $rowAffected;
	}

	/*
	*
	*/
	public function delete($table, $param)
	{
		$sql = "DELETE FROM $table
				WHERE id=:id";

		$stmt = $this->_conn->prepare($sql);

		$stmt->execute($param);

		$rowAffected = $stmt->rowCount();

		return $rowAffected;
	}


	/*
More functions need to be defined here
sql query maker, query execute, different types
	*/
}//end of class
