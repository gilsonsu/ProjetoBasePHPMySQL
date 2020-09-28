<?php

class AccessLogModel {
	
	private $arr;
	
	function setAccessLog($value){ $this->arr = $value; }
	function getAccessLog(){ return $this->arr; }

	function setId($value){ $this->arr["cl_id"] = !empty($value)? $value:null; }
	function getId(){ return !empty($this->arr["cl_id"])? $this->arr["cl_id"]:null; }

	function setIdAccessUser($value){ $this->arr["cl_id_access_user"] = !empty($value)? $value:null; }
	function getIdAccessUser(){ return !empty($this->arr["cl_id_access_user"])? $this->arr["cl_id_access_user"]:null; }

	function setIp($value){ $this->arr["cl_ip"] = !empty($value)?$value:null; }
	function getIp(){ return !empty($this->arr["cl_ip"])? $this->arr["cl_ip"]:null; }

    function setDateInsert($value){ $this->arr["cl_date_insert"] = $value; }
	function getDateInsert(){ return !empty($this->arr["cl_date_inert"])?$this->arr["cl_date_inert"]:null; }

}
?>