<?php
class AccessProfileDao extends AccessProfileModel {
     
	private $cnn;

	function __construct(){
		$this->cnn = new CnnMySqli();
	}

	// INSERT
	function create(){
		return $this->cnn->insert($this->getAccessProfile(),"tb_access_profile","cl_id");
	}

	// UPDATE
	function update(){
		return $this->cnn->update($this->getAccessProfile(),"tb_access_profile","cl_id");
	}

	// DELETE
	function delete($id){
		return $this->cnn->delete("tb_access_profile","cl_id", $id );
	}

	// SELECT
	function readOne($id){
		$sql =  "select * from tb_access_profile where cl_id = '$id' ";
		$result = $this->cnn->select($sql);
		$this->setAccessProfile($result);
		return ($result)?true:false;
	}

	function readAll(){
		$sql = "select * from tb_access_profile ";
		$result = $this->cnn->selectArr($sql);
		$this->setAccessProfile($result);
		return ($result)?true:false;
	}
}
?>