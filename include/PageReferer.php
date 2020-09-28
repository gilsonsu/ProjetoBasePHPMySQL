<?php

class PageReferer{
	
	function from(){

		$url = $_SERVER['HTTP_REFERER'];
		
		$newUrl = substr(strrchr($url, "/"),1);
		$newUrl = strrev($newUrl);
		$newUrl = substr(strrchr($newUrl, "."),1);
		$urlOrigem =  strrev($newUrl);

		return $urlOrigem;
	}

	function current(){
		
		$url = $_SERVER ['SCRIPT_NAME'];
		
		$newUrl = substr(strrchr($url, "/"),1);
		$newUrl = strrev($newUrl);
		$newUrl = substr(strrchr($newUrl, "."),1);
		$urlOrigem =  strrev($newUrl);

		return $urlOrigem;
	}
}

?>
