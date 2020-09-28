<?php

class AttributeDao extends AttributeModel {

	 private $cnn;

	 function __construct(){
		$this->cnn = new CnnMySqli();
	 }

	// INSERT

	 function create(){
		 return $this->cnn->insert($this->getAttribute(),"tb_attribute","cl_id");
	 }

	// UPDATE

	 function update(){
		 return $this->cnn->update($this->getAttribute(),"tb_attribute","cl_id");
	 }

	// DELETE

	 function delete($id){
		 $result = $this->cnn->delete("tb_attribute","cl_id", $id );
		 return ($result)?true:false;
	 }

	// SELECT

	 function readOne($id){
		 $sql =  "select * from tb_attribute where cl_id = '$id' ";
		 $result = $this->cnn->select($sql);
		 $this->setAttribute($result);
		 return ($result)?true:false;
	 }

	 function readByTable($table,$fk){
		 $sql = "select * from tb_attribute where cl_table = '$table' and cl_table_fk = '$fk' ";
		 $result = $this->cnn->selectArr($sql);
		 $this->setAttribute($result);
		 return ($result)?true:false;
	 }


}
?>