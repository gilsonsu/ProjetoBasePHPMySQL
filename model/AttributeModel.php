<?php

class AttributeModel { 

	 private $arr; 

	 function setAttribute($value){ $this->arr = $value; }
	 function getAttribute(){ return $this->arr; }

	 function setId($value){ $this->arr["cl_id"] = !empty($value)? $value:null; }
	 function getId(){ return !empty($this->arr["cl_id"])? $this->arr["cl_id"]:null; }

	 function setTable($value){ $this->arr["cl_table"] = !empty($value)?$value:null; }
	 function getTable(){ return !empty($this->arr["cl_table"])? $this->arr["cl_table"]:null; }

	 function setTableFk($value){ $this->arr["cl_table_fk"] = !empty($value)?$value:null; }
	 function getTableFk(){ return !empty($this->arr["cl_table_fk"])? $this->arr["cl_table_fk"]:null; }

	 function setDescription($value){ $this->arr["cl_description"] = !empty($value)?$value:null; }
	 function getDescription(){ return !empty($this->arr["cl_description"])? $this->arr["cl_description"]:null; }

}
?>