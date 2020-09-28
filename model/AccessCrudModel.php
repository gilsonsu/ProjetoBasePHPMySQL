<?php
class AccessCrudModel { 

	 public $arr; 

	 function setAccessCrud($value){ $this->arr = $value ; }
	 function getAccessCrud(){ return $this->arr; }

	 function setId($value){ $this->arr["cl_id"] = $value; }
	 function getId(){ return !empty($this->arr["cl_id"])?$this->arr["cl_id"]:null; }

	 function setIdAccessProfile($value){ $this->arr["cl_id_access_profile"] = $value; }
	 function getIdAccessProfile(){ return !empty($this->arr["cl_id_access_profile"])?$this->arr["cl_id_access_profile"]:null; }

	 function setIdAccessPage($value){ $this->arr["cl_id_access_page"] = $value; }
	 function getIdAccessPage(){ return !empty($this->arr["cl_id_access_page"])?$this->arr["cl_id_access_page"]:null; }

	 function setCread($value){ $this->arr["cl_create"] = $value; }
	 function getCread(){ return isset($this->arr["cl_create"])?$this->arr["cl_create"]:null; }

	 function setCreate($value){ $this->arr["cl_create"] = $value; }
	 function getCreate(){ return isset($this->arr["cl_create"])?$this->arr["cl_create"]:null; }

	 function setRead($value){ $this->arr["cl_read"] = $value; }
	 function getRead(){ return isset($this->arr["cl_read"])?$this->arr["cl_read"]:null; }

	 function setUpdate($value){ $this->arr["cl_update"] = $value; }
	 function getUpdate(){ return isset($this->arr["cl_update"])?$this->arr["cl_update"]:null; }

	 function setDelete($value){ $this->arr["cl_delete"] = $value; }
	 function getDelete(){ return isset($this->arr["cl_delete"])?$this->arr["cl_delete"]:null; }

	 function setDateInsert($value){ $this->arr["cl_date_insert"] = $value; }
	 function getDateInsert(){ return !empty($this->arr["cl_date_insert"])?$this->arr["cl_date_insert"]:null; }

	 function setDateUpdate($value){ $this->arr["cl_date_update"] = $value; }
	 function getDateUpdate(){ return !empty($this->arr["cl_date_update"])?$this->arr["cl_date_update"]:null; }

}
?>