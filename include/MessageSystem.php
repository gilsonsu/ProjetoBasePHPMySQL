<?php

class MessageSystem {
	
	private $error; 
	private $success; 
	private $warn;
	private $info;

	public function setSuccess($value) {
		$this->success [] = $value;
		return;
	}
	
	public function setError($value) {
		if (! empty ( $value )) {
			$this->error [] = $value;
		
		}
		return;
	}

	public function setWarn($value) {
		if (! empty ( $value )) {
			$this->warn [] = $value;
		}
		return;
	}

	public function setInfo($value) {
		if (! empty ( $value )) {
			$this->info [] = $value;
		}
		return;
	}
	
	public function confirmeErro() {
		if (! empty ( $this->error )) {	
			return false;
		}	
		return true;
	}
	
	public function getMessageSystem() {
		
		$message = null;
		
		if (empty ( $this->error ) and empty ( $this->success ) and empty ( $this->warn ) and empty ( $this->info )) {
			return null;
		}	

		if (! empty ( $this->info )) {
				
				$total4 = sizeof ( $this->info );
							
				for($c = 0; $c < $total4; $c ++) {
					
					$message .= "<li style=\"list-style-type:none;list-style-position: inside;
					background-color: #B0E2FF;
  					
					padding:5px;
					border-radius: 5px;
					margin-bottom:5px;
					\">";
					
					$message .= "<span style=\"
								width:30px;
								height:30px;
								margin:0;
								font-weight:bold;
								color:#FFF;
								display: block;
								background: #4682B4;
								border-radius: 30px;
								font-size:24px;\
								display:block;
								text-align:center;
								\">&#x00456;</span>";
					$message .= "<span style=\"position: absolute;margin-left:40px;margin-top:-28px;font-size:16px;color:#104E8B;\">".$this->info [$c] . "</span>";
					$message .= "</li>";
				}
				
			}
			
		if (! empty ( $this->success )) {
				
				$total = sizeof ( $this->success );
							
				for($a = 0; $a < $total; $a ++) {
					
					$message .= "<li style=\"list-style-type:none;list-style-position: inside;
					background-color: #cae8ca;
  					
					padding:5px;
					border-radius: 5px;
					margin-bottom:5px;
					\">";
					
					$message .= "<span style=\"
								width:30px;
								height:30px;
								margin:0;
								font-weight:bold;
								color:#FFF;
								display: block;
								background: #4CAF50;
								border-radius: 30px;
								font-size:24px;\
								display:block;
								text-align:center;
								\">&#x02713</span>";
					$message .= "<span style=\"position: absolute;margin-left:40px;margin-top:-28px;font-size:16px;color:#008B45;\">".$this->success [$a] . "</span>";
					$message .= "</li>";
				}
				
			}
			
			if (! empty ( $this->error )) {
				
				$total2 = sizeof ( $this->error );
							
				for($b = 0; $b < $total2; $b ++) {
					
					$message .= "<li style=\"list-style-type:none;list-style-position: inside;
					background-color: #FA8072;
  					
					padding:5px;
					border-radius: 5px;
					margin-bottom:5px;
					\">";
					
					$message .= "<span style=\"
								width:30px;
								height:30px;
								margin:0;
								font-weight:bold;
								color:#FFF;
								display: block;
								background: #CD3333;
								border-radius: 30px;
								font-size:24px;\
								display:block;
								text-align:center;
								\">&#x00021;</span>";
					$message .= "<span style=\"position: absolute;margin-left:40px;margin-top:-28px;font-size:16px;color:#8B2323;\">".$this->error [$b] . "</span>";
					$message .= "</li>";
				}
				
			}

			if (! empty ( $this->warn )) {
				
				$total3 = sizeof ( $this->warn );
							
				for($c = 0; $c < $total3; $c ++) {
					
					$message .= "<li style=\"list-style-type:none;list-style-position: inside;
					background-color: #F9E79F;
  					
					padding:5px;
					border-radius: 5px;
					margin-bottom:5px;
					\">";
					
					$message .= "<span style=\"
								width:30px;
								height:30px;
								margin:0;
								font-weight:bold;
								color:#FFF;
								display: block;
								background: #DAA520;
								border-radius: 30px;
								font-size:24px;\
								display:block;
								text-align:center;
								\">&#x025EC;</span>";
					$message .= "<span style=\"position: absolute;margin-left:40px;margin-top:-28px;font-size:16px;color:#8B6914;\">".$this->warn [$c] . "</span>";
					$message .= "</li>";
				}
				
			}

			
			
			// Massage layout

			$result  = "\n<ul style=\"";
			$result .= "list-style-position:inside;";
			$result .= "vertical-align: middle;";
			$result .= "line-height: 2.3em;";  
			$result .= "font-family:Arial, Helvetica, sans-serif;";
			$result .= "font-size:12px;";
			$result .= "color:#003366;";
			$result .= "padding-top:5px;";
			$result .= "padding-left:0;";
			$result .= "padding-bottom:1px;";
			$result .= "margin:10px 0px\"";
			$result .= ">" . $message . "</ul>";
		
		return ! empty ( $result ) ? $result : null;
	}

}
?>