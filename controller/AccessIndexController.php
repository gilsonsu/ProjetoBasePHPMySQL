<?php
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "Cript.php";
// Model and Dao 
require_once "AccessUserModel.php";
require_once "AccessUserDao.php";
require_once "AccessLogModel.php";
require_once "AccessLogDao.php";

class AccessIndexController {

	private $objAccessUser;
	private $objAccessLog;

	private $msg;

	function __construct() {

		$this->objAccessUser = new AccessUserDao();
		$this->objAccessLog = new AccessLogDao();

		$this->checkout();
		
		if($_POST){
			$this->getForm();
			
			if(!empty ( $_POST ['btnSend'])) { $this->checkin(); }
		}
			
		define('MSG',$this->msg);
	}

	private function getForm() {
		
		$this->objAccessUser->setEmail(!empty($_POST ['txtEmail'])? trim($_POST ['txtEmail']) :null);
		$this->objAccessUser->setPwd(!empty($_POST ["txtPwd"])? trim($_POST ["txtPwd"]) :null);

		return;
	}

	private function checkout() {

		$_SESSION ['APP_SESSION'] = null;
		unset ( $_SESSION ['APP_SESSION'] );

		$_SESSION ['FORM_PK'] = null;
		unset ( $_SESSION ['FORM_PK'] );

		return;
	}

	private function checkin(){

		if (! $this->validation ()) {return;}

		$result  = $this->objAccessUser->selectValidation();
		if(!$result){
			return;
		}

		$id = $this->objAccessUser->getId();

		$cp = new Cript();
		$result = $cp->encript($id);

		$_SESSION["APP_SESSION"] = $result;
		$this->logAcesso($id);

		header("Location: dashboard.php") ;exit;
		
		return ;
	}
	
	private function validation() {

		$email = $this->objAccessUser->getEmail ();
		$pwd = $this->objAccessUser->getPwd ();
		
		if(empty($email)){
			$this->msg = "Access denied!";
			return false;
		}

		if(empty($pwd)){
			$this->msg = "Access denied!";
			return false;
		}
		
		return true;
	}

	private function logAcesso($id){

		$this->objAccessLog->setIdAccessUser($id);
		$this->objAccessLog->setIp($this->getIp());
		$this->objAccessLog->setDateInsert(date("Y-m-d H:i:s"));
		$this->objAccessLog->insert();
		
		return;
	}

	private function getIp(){

		$ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'unknown'; // pegando o endereço remoto ou definindo-o como desconhecido
		$forward = ( isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:false);  // pegando o endereço que foi repassado (se houver)
		$ip=(($ip=='unknown' and $forward and $forward!='unknown' )?$forward:$ip);

		return $ip;
	}
}

$controller = new AccessIndexController ( );

?>
