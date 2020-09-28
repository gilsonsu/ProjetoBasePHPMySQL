<?php

class HtmlSelectOption {
	
	private $name;
	private $fields;
	private $values;
	private $width;
	private $selected;
	private $onchange;
	private $valueOnchange;
	private $disabled;
	
	public function start() {
		
		$this->name = null;
		$this->fields = null;
		$this->values = null;
		$this->width = null;
		$this->selected = null;
		$this->onchange = null;
		$this->valueOnchange = null;
		$this->disabled = null;
		
		return;
	}
		
	public function setName($name = null) {
		$this->name = $name;
		return;
	}
		
	public function setFields($fields = null) {
		$this->fields = $fields;
		return;
	}

	public function setValues($value = null) {
		$this->values = $value;
		return;
	}
	
	public function setWidth($width = null) {	
		$this->width = $width;
		return;
	}

	public function setSelected($selected = null) {		
		$this->selected = $selected;
		return;
	}
	
	public function setDisabled($disabled = null) {
		$this->disabled = $disabled;
		return;
	}
	
	public function setOnChange($onchange = null) {	
		$this->onchange = $onchange;
		return;
	}
	
	public function setValueOnChange($valueOnchange = null) {	
		$this->valueOnchange = $valueOnchange;
		return;
	}
	
	function show() {
			
		$tag = null;
		$option = null;
		
		if (empty ( $this->values ))  return "NOT FOULD REGISTERS!";

		$total = sizeof ( $this->values );
		
		for($i = 0; $i < $total; $i ++) {			
			$value = !empty($this->values [$i])?$this->values [$i]:null;
			$label = !empty($this->fields [$i])?$this->fields [$i]:null;
			$selected = (($this->selected == $value) and ! empty ( $this->selected ))? " selected " : null; 
			$option .= "<option value=\"".$value."\"".$selected.">" . $label . "</option>\n";
			$selected = $value = $label = null;
		}
		
		$onchange = ($this->onchange)? " onchange=\"" . $this->valueOnchange . "\" " : null; 
		$disabled = ($this->disabled == true)? $disabled = " disabled=\"disabled\" ": null;
		
		$tag = "\n<select name=\"" . $this->name . "\"" ;
		$tag .= " id=\"".$this->name."\"";
		$tag .= (!empty($this->width )? " style=\"width:" . $this->width . "px;\"" : null);
		$tag .= " $onchange $disabled >\n";
		$tag .= "<option value=\"\"></option>\n";
		$tag .= $option;
		$tag .= "</select>\n";
		
		return $tag;
	}
}
?>
