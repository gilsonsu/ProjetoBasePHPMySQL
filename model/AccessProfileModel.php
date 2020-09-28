<?php
class AccessProfileModel { 

	 public $arr; 

	 function setAccessProfile($value){ $this->arr = $value ; }
	 function getAccessProfile(){ return $this->arr; }

	 function setId($value){ $this->arr["cl_id"] = $value; }
	 function getId(){ return !empty($this->arr["cl_id"])?$this->arr["cl_id"]:null; }

	 function setName($value){ $this->arr["cl_name"] = $value; }
	 function getName(){ return !empty($this->arr["cl_name"])?$this->arr["cl_name"]:null; }

	 function setDescription($value){ $this->arr["cl_description"] = $value; }
	 function getDescription(){ return !empty($this->arr["cl_description"])?$this->arr["cl_description"]:null; }

	 function setDateInsert($value){ $this->arr["cl_date_insert"] = $value; }
	 function getDateInsert(){ return !empty($this->arr["cl_date_inert"])?$this->arr["cl_date_inert"]:null; }

	 function setDateUpdate($value){ $this->arr["cl_date_update"] = $value; }
	 function getDateUpdate(){ return !empty($this->arr["cl_date_update"])?$this->arr["cl_date_update"]:null; }

}
?>