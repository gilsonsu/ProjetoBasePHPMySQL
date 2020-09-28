<?php
class AccessUserDao extends AccessUserModel {
     
	private $cnn;

	function __construct(){
		$this->cnn = new CnnMySqli();
	}

	// INSERT
	function create(){
		return $this->cnn->insert($this->getAccessUser(),"tb_access_user","cl_id");
	}

	// UPDATE
	function update(){
		return $this->cnn->update($this->getAccessUser(),"tb_access_user","cl_id");
	}

	// DELETE
	function delete($id){
		return $this->cnn->delete("tb_access_user","cl_id", $id );
	}
	 
	// SELECT
	function readOne($id){
		$sql =  "select * from tb_access_user where cl_id = '$id' ";
		$result = $this->cnn->select($sql);
		$this->setAccessUser($result);
		return ($result)?true:false;
	}

	function readAll(){
		$sql = "select * from tb_access_user ";
		$result = $this->cnn->selectArr($sql);
		$this->setAccessUser($result);
		return ($result)?true:false;
	}

	function selectValidation(){

		$email = $this->getEmail();
		$pwd = $this->getPwd();
	 	
	 	$sql =  "select * from tb_access_user where cl_email = '$email' and cl_pwd = '$pwd' ";
	 	$result = $this->cnn->select($sql);
		$this->setAccessUser($result);
		print_r($result);
	 	return ($result)?true:false;
	}
}
?>