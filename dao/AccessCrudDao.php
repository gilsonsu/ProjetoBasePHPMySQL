<?php
class AccessCrudDao extends AccessCrudModel {
     
	private $cnn;

	function __construct(){
	$this->cnn = new CnnMySqli();
	}

	// INSERT
	function create(){
		return $this->cnn->insert($this->getAccessCrud(),"tb_access_crud","cl_id");
	}

	// UPDATE
	function update(){
		return $this->cnn->update($this->getAccessCrud(),"tb_access_crud","cl_id");
	}

	// DELETE
	function delete($id){
		return $this->cnn->delete("tb_access_crud","cl_id", $id );
		
	}

	// SELECT
	function readOne($id){
		$sql =  "select * from tb_access_crud where cl_id = '$id' ";
		$result = $this->cnn->select($sql);
		$this->setAccessCrud($result);
		return ($result)?true:false;
	}

	function readAll(){
		$sql = "select * from tb_access_crud ";
		$result = $this->cnn->selectArr($sql);
		$this->setAccessCrud($result);
		return ($result)?true:false;
	}

	function readByProfileAndPage($idProfile, $idPage){
		$sql =  "select * from tb_access_crud where cl_id_access_profile = '$idProfile' and cl_id_access_page = '$idPage' ";
		$result = $this->cnn->select($sql);
		$this->setAccessCrud($result);
		return ($result)?true:false;
	}

}
?>