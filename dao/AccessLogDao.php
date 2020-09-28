<?php

class AccessLogDao extends AccessLogModel {

	 private $cnn;

	 function __construct(){
		$this->cnn = new CnnMySqli();
	 }

	// INSERT

	 function insert(){
		 return $this->cnn->insert($this->getAccessLog(),"tb_access_log","cl_id");
	 }

	// UPDATE

	 function update(){
		 return $this->cnn->update($this->getAccessLog(),"tb_access_log","cl_id");
	 }

	// DELETE

	 function delete($id){
		 $result = $this->cnn->delete("tb_access_log","cl_id", $id );
		 return ($result)?true:false;
	 }

	// SELECT

	 function selectOne($id){
		 $sql =  "select * from tb_access_log where cl_id = '$id' ";
		 $result = $this->cnn->select($sql);
		 $this->setAccessLog($result);
		 return ($result)?true:false;
	 }

	 function selectAll(){
		 $sql = "select * from tb_access_log";
		 $result = $this->cnn->selectArr($sql);
		 $this->setAccessLog($result);
		 return ($result)?true:false;
	 }


}
?>