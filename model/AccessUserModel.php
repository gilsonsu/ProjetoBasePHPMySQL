<?php
class AccessUserModel { 

	 public $arr; 

	 function setAccessUser($value){ $this->arr = $value ; }
	 function getAccessUser(){ return $this->arr; }

	 function setId($value){ $this->arr["cl_id"] = $value; }
	 function getId(){ return !empty($this->arr["cl_id"])?$this->arr["cl_id"]:null; }

	 function setIdAccessProfile($value){ $this->arr["cl_id_access_profile"] = $value; }
	 function getIdAccessProfile(){ return !empty($this->arr["cl_id_access_profile"])?$this->arr["cl_id_access_profile"]:null; }

	 function setIdSoptAttActive($value){ $this->arr["cl_id_sopt_att_active"] = $value; }
	 function getIdSoptAttActive(){ return !empty($this->arr["cl_id_sopt_att_active"])?$this->arr["cl_id_sopt_att_active"]:null; }

	 function setName($value){ $this->arr["cl_name"] = $value; }
	 function getName(){ return !empty($this->arr["cl_name"])?$this->arr["cl_name"]:null; }

	 function setEmail($value){ $this->arr["cl_email"] = $value; }
	 function getEmail(){ return !empty($this->arr["cl_email"])?$this->arr["cl_email"]:null; }
	 
	 function setPwd($value){ $this->arr["cl_pwd"] = $value; }
	 function getPwd(){ return !empty($this->arr["cl_pwd"])?$this->arr["cl_pwd"]:null; }

	 function setDateInsert($value){ $this->arr["cl_date_insert"] = $value; }
	 function getDateInsert(){ return !empty($this->arr["cl_date_inert"])?$this->arr["cl_date_inert"]:null; }

	 function setDateUpdate($value){ $this->arr["cl_date_update"] = $value; }
	 function getDateUpdate(){ return !empty($this->arr["cl_date_update"])?$this->arr["cl_date_update"]:null; }

}
?>