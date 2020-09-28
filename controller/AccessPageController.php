<?php
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "HtmlSelectOption.php"; 
require_once "HtmlRadioButton.php"; 
require_once "HtmlCheckbox.php"; 
require_once "MessageSystem.php"; 
// Model and Dao 
require_once "AccessPageModel.php";
require_once "AccessPageDao.php";

class AccessPageController {

	private $clsAccessPermission;
	private $objAccessPage;
	private $msg;

	public $fieldValue;

	function __construct(){
		
		// Access.
		$this->clsAccessPermission = new AccessPermission();
		// Dao and Model.
		$this->objAccessPage = new AccessPageDao();
		// Libraries.
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
		if(!empty($_GET['gPage'])){
			 $_SESSION['PK']['PAGE'] = $id = $_GET['gPage'];
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
		$id = $this->objAccessPage->getId();
		if (!empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toCreat();
		if(!$result){
			$this->msg->setWarn("You don't have permission to create!");
			return;
		}
		// Execute insert.
		$this->objAccessPage->setDateInsert(date("Y-m-d H:i:s"));
		$id = $this->objAccessPage->create ();
		// Check result.
		if ($id == 0) {
 			$this->msg->setError ('There were issues on creating ther record!');
				return;
		}
		// Save the id in the session to be used in the update.
		$_SESSION ['PK']['ACCESSCRUD'] = $id;
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
		if(!empty($_SESSION ['PK']['PAGE'])){
			 $id = $_SESSION ['PK']['PAGE'];
			 
			$this->objAccessPage->readOne ( $id );
		}

		$this->fieldValue["cl_name"] = $this->objAccessPage->getName();
		$this->fieldValue["cl_description"] = $this->objAccessPage->getDescription();
		
		$this->fieldValue["cl_date_insert"] = $this->objAccessPage->getDateInsert();
		$this->fieldValue["cl_date_update"] = $this->objAccessPage->getDateUpdate();

		return;
	}

	private function update(){
		// Check if data saved.
		$id = $this->objAccessPage->getId();
		if (empty ( $id )) return;
		// Check permission to update.
		$result = $this->clsAccessPermission->toUpdate();
		if(!$result){
			$this->msg->setWarn("You don't have permission to update!");
			return;
		}
		// Execute Update.
		if (! $this->objAccessPage->update ()) {
			$this->msg->setError ("There were issues on update the record!");
			return;
		}
		$this->msg->setSuccess ("Updated the record with success!");
		return;
	}

	private function delete(){
		// Check if data saved.
		$id = $this->objAccessPage->getId();
		if (empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toDelete();
		if(!$result){
			$this->msg->setWarn("You don't have permission to delete!");
			return;
		}
		if(!$this->objAccessPage->delete($id)){
			$this->msg->setError ("There was an issue to delete, because this register has some relation with another one!");
			return;
		}
		// Cleaner all class values.
		$this->objAccessPage->setAccessPage(null);
		// Cleaner session primary key.
		$_SESSION['PK']['PAGE'] = null;

		$this->msg->setSuccess ("Delete the record with success!");
		return;
	}

	private function getForm(){
		// PK
		$this->objAccessPage->setId( !empty( $_SESSION ['PK']['PAGE'] ) ? $_SESSION ['PK']['PAGE'] : null );
		// FORM
		$this->objAccessPage->setName( !empty( $_POST ['txtName'] ) ? $_POST ['txtName'] : null );
		$this->objAccessPage->setDescription( !empty( $_POST ['txtDescription'] ) ? $_POST ['txtDescription'] : null );
		// Date update
		$this->objAccessPage->setDateUpdate(date("Y-m-d H:i:s"));
	}

	private function validation(){

		$this->msg->setError ( empty($this->objAccessPage->getName ())? 'NAME not information! ': null);
		$this->msg->setError ( empty($this->objAccessPage->getDescription ())? 'E-MAIL not information! ': null);
	}
}

 $controller = new AccessPageController();

 ?>