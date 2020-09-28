<?php

class CnnMySqli {

    private $dbUrl  = DB_URL;
    private $dbUser = DB_USER;
    private $dbPwd  = DB_PWD;
    private $dbName = DB_NAME;
	private $dbPort = DB_PORT;

	private $mysqli;
	
	function connection() {
	    $this->mysqli = new mysqli($this->dbUrl, $this->dbUser,  $this->dbPwd, $this->dbName, $this->dbPort);
	    if ($this->mysqli->connect_errno) {
	        echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;exit;
	    }
	    $this->mysqli->set_charset("utf8");
	    return;
	}
	
	public function getIdConection() {
		$this->connection ();
		return $this->mysqli;
	}

	private function resultQuery($result) {

		$list = array();
		$i = 0;

		while ( $dados = $result->fetch_assoc ( ) ) {
				foreach ( $dados as $key => $value ) {
					if ($value !== '' and $value != null ) {
						$list [$key] [$i] = $value;
					}
				}
				$i ++;
			}
		return $list;
	}

	private function createOneInsert($arr, $table, $primaryKey) {

		$i = 0;
		foreach ( $arr as $key => $value ) {
			if (! empty ( $key ) and ! empty ( $value )) {
				if ($primaryKey != $key) {
					$string_columns [$i] = $key;
					$string_value [$i] = "'" . @addslashes($value) . "'";
				}
			}
			$i ++;
		}

		$string_columns = implode ( ',', $string_columns );
		$string_value = implode ( ',', $string_value );
		$query = "insert into " . $table . " (" . $string_columns . ") values (" . $string_value . ")";

		return $query;
	}
	
	private function createUpdateQuery($arr, $table, $primaryKey) {

		$condition = null;
		$i = 0;

		foreach ( $arr as $key => $value ) {
			if ($primaryKey == $key and ! empty ( $key ) and ($value !== '') and ($value !== null) ) {
				$value = addslashes($value);
				$condition = $key . " = '" . $value . "'";
			} else {
				if(($value !== '') and ($value !== null) ){
					$value = addslashes($value);
					$string_update [$i] = $key . " = '" . $value . "'";
				}
			}
			$i ++;
		}

		$string_update = implode ( ',', $string_update );

		if(empty($condition)){
			return null;
		}

		$sql = "update " . $table . " set " . $string_update . " where " . $condition;
		return $sql;
	}

	// FUNCTIONS PUBLICS
	
	public function insert($arr, $table, $primaryKey) {

		if(empty($table)) return 0;
		if(empty($primaryKey)) return 0;

		$sql = $this->createOneInsert($arr, $table, $primaryKey);

		if(empty($sql)) return 0;
	
		$this->connection ();
		$idInsert = $this->insertQuery($sql);
		
		return $idInsert;
	}

	public function insertQuery($sql){
		$result = $this->mysqli->query ( $sql );
		if ($result) {
			$result_insert_id = $this->mysqli->insert_id;
			$idInsert =  $result_insert_id;
			return $idInsert;
		}else{	
			return 0;
		}
	}
	
	public function update($arr, $table, $primaryKey = null, $codicao = null) {
		$sql = $this->createUpdateQuery ( $arr, $table, $primaryKey );
		return $this->updateQuery ($sql);
	}

	public function updateQuery($sql){
		$this->connection ();
		$result = $this->mysqli->query ( $sql );
		if ($this->mysqli->affected_rows > 0) {
			
			return true;
		}
	}

	public function delete($table, $primaryKey, $id){
		
		if(empty($table)) return null;
		if(empty($primaryKey)) return null;
		if(empty($id)) return null;

		$this->connection ();
		$sql = " DELETE FROM $table WHERE $primaryKey =  $id ";

		return $this->mysqli->query ( $sql );
	}

	public function select($sql){
		$this->connection ();
		 $result = $this->mysqli->query ( $sql );
	    if ($this->mysqli->affected_rows > 0) {
			return $result->fetch_assoc();
		}
		return null;
	}

	public function selectArr($sql){
		$this->connection ();
		$result = $this->mysqli->query ( $sql );
		if ($this->mysqli->affected_rows > 0) {
			$result = $this->resultQuery ( $result );
			return $result;
		}
		return null;
	}
}
?>
