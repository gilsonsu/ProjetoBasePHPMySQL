<?php
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "HtmlSelectOption.php"; 
require_once "HtmlRadioButton.php"; 
require_once "HtmlCheckbox.php"; 
require_once "MessageSystem.php"; 
// Model and Dao 
require_once "AccessProfileModel.php";
require_once "AccessProfileDao.php";

class AccessProfileController {

	private $clsAccessPermission;
	private $objAccessProfile;
	private $msg;

	public $fieldValue;

	function __construct(){

		// Access.
		$this->clsAccessPermission = new AccessPermission();
		// Dao and Model.
		$this->objAccessProfile = new AccessProfileDao();
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
		if(!empty($_GET['gProfile'])){
			 $_SESSION['PK']['PROFILE'] = $id = $_GET['gProfile'];
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
		$id = $this->objAccessProfile->getId();
		if (!empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toCreat();
		if(!$result){
			$this->msg->setWarn("You don't have permission to create!");
			return;
		}
		// Execute insert.
		$this->objAccessProfile->setDateInsert(date("Y-m-d H:i:s"));
		$id = $this->objAccessProfile->create ();
		// Check result.
		if ($id == 0) {
 			$this->msg->setError ('There were issues on creating ther record!');
				return;
		}
		// Save the id in the session to be used in the update.
		$_SESSION ['PK']['PROFILE'] = $id;
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
		if(!empty($_SESSION ['PK']['PROFILE'])){
			 $id = $_SESSION ['PK']['PROFILE'];			 
			$this->objAccessProfile->readOne ( $id );
		}

		$this->fieldValue["cl_name"] = $this->objAccessProfile->getName();
		$this->fieldValue["cl_description"] = $this->objAccessProfile->getDescription();

		$this->fieldValue["cl_date_insert"] = $this->objAccessProfile->getDateInsert();
		$this->fieldValue["cl_date_update"] = $this->objAccessProfile->getDateUpdate();

		return;
	}

	private function update(){
		// Check if data saved.
		$id = $this->objAccessProfile->getId();
		if (empty ( $id )) return;
		// Check permission to update.
		$result = $this->clsAccessPermission->toUpdate();
		if(!$result){
			$this->msg->setWarn("You don't have permission to update!");
			return;
		}
		// Execute Update.
		if (! $this->objAccessProfile->update ()) {
			$this->msg->setError ("There were issues on update the record!");
			return;
		}
		$this->msg->setSuccess ("Updated the record with success!");
		return;
	}

	private function delete(){
		// Check if data saved.
		$id = $this->objAccessProfile->getId();
		if (empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toDelete();
		if(!$result){
			$this->msg->setWarn("You don't have permission to delete!");
			return;
		}
		if(!$this->objAccessProfile->delete($id)){
			$this->msg->setError ("There was an issue to delete, because this register has some relation with another one!");
			return;
		}
		// Cleaner all class values.
		$this->objAccessProfile->setAccessProfile(null);
		// Cleaner session primary key.
		$_SESSION['PK']['PROFILE'] = null;

		$this->msg->setSuccess ("Delete the record with success!");
		return;
	}
	
	private function getForm(){
		// PK
		$this->objAccessProfile->setId( !empty( $_SESSION ['PK']['PROFILE'] ) ? $_SESSION ['PK']['PROFILE'] : null );
		// FORM
		$this->objAccessProfile->setName( !empty( $_POST ['txtName'] ) ? $_POST ['txtName'] : null );
		$this->objAccessProfile->setDescription( !empty( $_POST ['txtDescription'] ) ? $_POST ['txtDescription'] : null );
		// Date update
		$this->objAccessProfile->setDateUpdate(date("Y-m-d H:i:s"));
	}
	
	private function validation(){

		$this->msg->setError ( empty($this->objAccessProfile->getName ())? 'NAME not information!': null);
		$this->msg->setError ( empty($this->objAccessProfile->getDescription ())? 'E-MAIL not information!': null);
	}
}

 $controller = new AccessProfileController();

 ?>
