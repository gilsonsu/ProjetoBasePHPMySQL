<?php
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "PageReferer.php";
require_once "Cript.php";
// Model and Dao 
require_once "AccessUserModel.php";
require_once "AccessUserDao.php";
require_once "AccessLogModel.php";
require_once "AccessLogDao.php";
require_once "AccessCrudModel.php";
require_once "AccessCrudDao.php";
require_once "AccessProfileModel.php";
require_once "AccessProfileDao.php";
require_once "AccessPageModel.php";
require_once "AccessPageDao.php";

class AccessPermission{

	private $objAccessUser;
	private $objAccessCrud;
	private $objAccessProfile;
	private $objAccessPage;

	private $currentPage; 

	private $idUser;

	function __construct(){

		$this->objAccessUser = new AccessUserDao();
		$this->objAccessCrud = new AccessCrudDao();
		$this->objAccessProfile = new AccessProfileDao();
		$this->objAccessPage = new AccessPageDao();

		// Get page name requested.
		$pr = new PageReferer();
		$this->currentPage = $pr->current();

		if($this->currentPage != "index"){
			if(!empty($_SESSION["APP_SESSION"])){
				if($this->currentPage != "action"  
					and $this->currentPage != "dashboard"  
						and $this->currentPage != "accessDenied" 
							and $this->currentPage != "modalAccessDenied"){
					
								$this->init();
				}
			}else{
				header("Location: index.php");
				return;
			}
		}	
	}

	private function init(){

		$key = $_SESSION["APP_SESSION"];

		// Description session.
		$cp = new Cript();
		$this->idUser = $cp->decript($key);
				
		// Get page id.
		$this->objAccessPage->readByPageName($this->currentPage.".php");
		$idPage = $this->objAccessPage->getId();

		if(empty($idPage)){
			header("Location: accessDenied.php");
			return;
		}

		// Get User data.
		$this->objAccessUser->readOne ( $this->idUser );

		$idUser = $this->objAccessUser->getId();
		$idProfile = $this->objAccessUser->getIdAccessProfile();
		$idAtive = $this->objAccessUser->getIdSoptAttActive();

		if(empty($idUser)){
			header("Location: index.php");
			return;
		}

		// Check if user are actived.
		if($idAtive == 2){
			header("Location: index.php");
			return;
		}

		$this->objAccessCrud->readByProfileAndPage($idProfile,$idPage);

		$idCrud = $this->objAccessCrud->getId();

		if(empty($idCrud)){
			header("Location: accessDenied.php");
			return;
		}

		return;
	}

	public function toCreat(){

		$result = $this->objAccessCrud->getCreate();
		return ($result == 1)? true : false;
	}

	public function toRead(){

		$result = $this->objAccessCrud->getRead();
		return ($result == 1)? true : false;
	}

	public function toUpdate(){

		$result = $this->objAccessCrud->getUpdate();
		return ($result == 1)? true : false;
	}

	public function toDelete(){

		$result = $this->objAccessCrud->getDelete();
		return ($result == 1)? true : false;
	}

	public function getUser(){
		return $this->idUser;
	}

	public function getName(){

		if(empty($_SESSION["APP_SESSION"])) return "";

		$key = $_SESSION["APP_SESSION"];

		// Description session.
		$cp = new Cript();
		$idUser = $cp->decript($key);

		// Get User data.
		$this->objAccessUser->readOne ( $idUser );
		return $this->objAccessUser->getName();
	}
}

$ac = new AccessPermission();
?>
