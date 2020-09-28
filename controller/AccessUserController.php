<?php
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "HtmlSelectOption.php"; 
require_once "HtmlRadioButton.php"; 
require_once "HtmlCheckbox.php"; 
require_once "MessageSystem.php"; 
// Model and Dao 
require_once "AttributeModel.php";
require_once "AttributeDao.php";
require_once "AccessUserModel.php";
require_once "AccessUserDao.php";
require_once "AccessProfileModel.php";
require_once "AccessProfileDao.php";

class AccessUserController {

	private $clsAccessPermission;
	private $objAccessUser;
	private $objAccessProfile;
	private $objAttribute;
	private $sopt;
	private $msg;
	
	public $fieldValue;

	function __construct(){

		// Access.
		$this->clsAccessPermission = new AccessPermission();
		// Dao and Model.
		$this->objAccessUser = new AccessUserDao();
		$this->objAccessProfile = new AccessProfileDao();
		$this->objAttribute = new AttributeDao();
		// Libraries.
		$this->sopt = new HtmlSelectOption();
		$this->msg = new MessageSystem();
		// Inicialization.
		if ($_GET) {
			$this->requestGet();
		} elseif ($_POST) {
			$this->requestPost();
		}

		// Execute read if exist the id on session.
		$this->read();
		$this->selectOption();

		$this->msg->setInfo('All fields must be filled!');

		define('MSG',$this->msg->getMessageSystem());
	 }

	private function requestGet() {

		if (! empty ( $_GET ['action'] )) {
			$_SESSION ['PK'] = null;
			unset($_SESSION ['PK']);
			$_SESSION ['REDIRECTION'] = null;
			unset($_SESSION ['REDIRECTION']);
		}
		
		if(!empty($_GET['gUser'])){
			 $_SESSION['PK']['ACCESSUSER'] = $id = $_GET['gUser'];
		}
		
		return;
	}

	private function requestPost(){
		// Get form data.
 		$this->getForm();
 		// Check if all form data going to informed.
		$this->validation ();
		if (! $this->msg->confirmeErro ()) {return;}
		// Command save.
		if(!empty ( $_POST ['btnSave'])) {
			// Execute delete if was going to checked by user.
			// Obs: Won't delete if register have some relation with another one.
			if(!empty($_POST['ckbDelete']) and $_POST['ckbDelete'] == true 
				and !empty($_POST['ckbConfirmDelete']) and $_POST['ckbConfirmDelete'] == true){
				$this->delete();
				return;
			}else{
				// Execute update if exist the id on session.
				$this->update();
				// Execute create if don't exist the id on session.
				$this->create();
			}
		}
	}

	private function create() {
		// Check if data saved.
		$id = $this->objAccessUser->getId();
		if (!empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toCreat();
		if(!$result){
			$this->msg->setWarn("You don't have permission to create!");
			return;
		}
		// Execute insert.
		$this->objAccessUser->setDateInsert(date("Y-m-d H:i:s"));
		$id = $this->objAccessUser->create ();
		// Check result.
		if ($id == 0) {
 			$this->msg->setError ('There were issues on creating ther record!');
				return;
		}
		// Save the id in the session to be used in the update.
		$_SESSION ['PK']['ACCESSUSER'] = $id;
		$this->msg->setSuccess ( 'Created the record with success!' );
		return;
	}

	private function read(){
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toRead();
		if(!$result){
			$this->msg->setWarn("You don't have permission to reade!");
			return;
		}
		// Take the id from session.
		if(!empty($_SESSION ['PK']['ACCESSUSER'])){
			 $id = $_SESSION ['PK']['ACCESSUSER'];
			$this->objAccessUser->readOne ( $id );
		}

		$this->fieldValue["cl_id_access_profile"] = $this->objAccessUser->getIdAccessProfile();
		$this->fieldValue["cl_id_sopt_att_active"] = $this->objAccessUser->getIdSoptAttActive();

		$this->fieldValue["cl_name"] = $this->objAccessUser->getName();
		$this->fieldValue["cl_email"] = $this->objAccessUser->getEmail();
		$this->fieldValue["cl_pwd"] = $this->objAccessUser->getPwd();

		$this->fieldValue["cl_date_insert"] = $this->objAccessUser->getDateInsert();
		$this->fieldValue["cl_date_update"] = $this->objAccessUser->getDateUpdate();

		return;
	}

	private function update(){
		// Check if data saved.
		$id = $this->objAccessUser->getId();
		if (empty ( $id )) return;
		// Check permission to update.
		$result = $this->clsAccessPermission->toUpdate();
		if(!$result){
			$this->msg->setWarn("You don't have permission to update!");
			return;
		}
		// Execute Update.
		if (! $this->objAccessUser->update ()) {
			$this->msg->setError ("There were issues on update the record!");
			return;
		}
		$this->msg->setSuccess ("Updated the record with success!");
		return;
	}

	private function delete(){
		// Check if data saved.
		$id = $this->objAccessUser->getId();
		if (empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toDelete();
		if(!$result){
			$this->msg->setWarn("You don't have permission to delete!");
			return;
		}
		if(!$this->objAccessUser->delete($id)){
			$this->msg->setError ("There was an issue to delete, because this register has some relation with another one!");
			return;
		}
		// Cleaner all class values.
		$this->objAccessUser->setAccessUser(null);
		// Cleaner session primary key.
		$_SESSION['PK']['ACCESSUSER'] = null;

		$this->msg->setSuccess ("Delete the record with success!");
		return;
	}

	private function getForm(){
		// PK
		$this->objAccessUser->setId( !empty( $_SESSION ['PK']['ACCESSUSER'] ) ? $_SESSION ['PK']['ACCESSUSER'] : null );
		// FK	
		$this->objAccessUser->setIdAccessProfile( !empty( $_POST ['soptIdAccessProfile'] ) ? $_POST ['soptIdAccessProfile'] : null );
		$this->objAccessUser->setIdSoptAttActive( !empty( $_POST ['soptIdAttActive'] ) ? $_POST ['soptIdAttActive'] : null );
		// FORM
		$this->objAccessUser->setName( !empty( $_POST ['txtName'] ) ? $_POST ['txtName'] : null );
		$this->objAccessUser->setEmail( !empty( $_POST ['txtEmail'] ) ? $_POST ['txtEmail'] : null );
		$this->objAccessUser->setPwd( !empty( $_POST ['txtPwd'] ) ? $_POST ['txtPwd'] : null );
	}

	private function validation(){

		$this->msg->setError ( empty($this->objAccessUser->getIdAccessProfile ())? 'PROFILE not information!': null);
		$this->msg->setError ( empty($this->objAccessUser->getIdSoptAttActive ())? 'ACTIVE not information! ': null);
		$this->msg->setError ( empty($this->objAccessUser->getName ())? 'NAME not information! ': null);
		$this->msg->setError ( empty($this->objAccessUser->getEmail ())? 'E-MAIL not information! ': null);
		$this->msg->setError ( empty($this->objAccessUser->getPwd ())? 'PASSWORD not information! ': null);

	}

	private function selectOption(){

		// ACCESS PROFILE

		$this->objAccessProfile->readAll ();

		$this->sopt->start ();
		$this->sopt->setName ( "soptIdAccessProfile" );
		$this->sopt->setFields ( $this->objAccessProfile->getName () );
		$this->sopt->setValues ( $this->objAccessProfile->getId() );
		$this->sopt->setWidth ( );
		$this->sopt->setSelected ( !empty($this->fieldValue["cl_id_access_profile"])? $this->fieldValue["cl_id_access_profile"] :null );
		$this->sopt->setOnChange ( true );
		
		define ( 'SOPT_ACCESSPROFILE', $this->sopt->show () );

		// ATTRIBUTE ACTIVE

		$this->objAttribute->readByTable ('tb_access_user','cl_id_sopt_att_active');

		$this->sopt->start ();
		$this->sopt->setName ( "soptIdAttActive" );
		$this->sopt->setFields ( $this->objAttribute->getDescription () );
		$this->sopt->setValues ( $this->objAttribute->getId() );
		$this->sopt->setWidth ( );
		$this->sopt->setSelected ( !empty($this->fieldValue["cl_id_sopt_att_active"])? $this->fieldValue["cl_id_sopt_att_active"] :null );
		$this->sopt->setOnChange ( true );
		
		define ( 'SOPT_ATT_ACTIVE', $this->sopt->show () );
	 }
}

 $controller = new AccessUserController();

 ?>
