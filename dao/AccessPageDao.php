<?php
class AccessPageDao extends AccessPageModel {
     
	private $cnn;

	function __construct(){
		$this->cnn = new CnnMySqli();
	}

	// INSERT
	function create(){
		return $this->cnn->insert($this->getAccessPage(),"tb_access_page","cl_id");
	}

	// UPDATE
	function update(){
		return $this->cnn->update($this->getAccessPage(),"tb_access_page","cl_id");
	}

	// DELETE
	function delete($id){
		return $this->cnn->delete("tb_access_page","cl_id", $id );
	}
	 
	// SELECT
	function readOne($id){
		 $sql =  "select * from tb_access_page where cl_id = '$id' ";
		 $result = $this->cnn->select($sql);
		 $this->setAccessPage($result);
		 return ($result)?true:false;
	}

	function readAll(){
		$sql = "select * from tb_access_page ";
		$result = $this->cnn->selectArr($sql);
		$this->setAccessPage($result);
		return ($result)?true:false;
	}

	function readByPageName($pageName){
		$sql = "select * from tb_access_page where cl_name = '$pageName' ";
		$result = $this->cnn->select($sql);
		$this->setAccessPage($result);
		return ($result)?true:false;
	}

}
?>