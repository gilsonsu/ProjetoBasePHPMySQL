<?php
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "HtmlSelectOption.php"; 
require_once "HtmlRadioButton.php"; 
require_once "HtmlCheckbox.php"; 
require_once "MessageSystem.php"; 
// Model and Dao 
require_once "AccessCrudModel.php";
require_once "AccessCrudDao.php";
require_once "AccessProfileModel.php";
require_once "AccessProfileDao.php";
require_once "AccessPageModel.php";
require_once "AccessPageDao.php";

class AccessCrudController {

	private $clsAccessPermission;
	private $objAccessCrud;
	private $objAccessProfile;
	private $objAccessPage;
	private $sopt;
	private $radio;
	private $msg;

	public $fieldValue;

	function __construct(){

		// Access.
		$this->clsAccessPermission = new AccessPermission();
		// Dao and Model.
		$this->objAccessCrud = new AccessCrudDao();
		$this->objAccessProfile = new AccessProfileDao();
		$this->objAccessPage = new AccessPageDao();
		// Libraries.
		$this->sopt = new HtmlSelectOption();
		$this->radio = new HtmlRadioButton();
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
		$this->radioButton();

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
		if(!empty($_GET['gCrud'])){
			 $_SESSION['PK']['ACCESSCRUD'] = $id = $_GET['gCrud'];
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
		$id = $this->objAccessCrud->getId();
		if (!empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toCreat();
		if(!$result){
			$this->msg->setWarn("You don't have permission to create!");
			return;
		}
		// Execute insert.
		$this->objAccessCrud->setDateInsert(date("Y-m-d H:i:s"));
		$id = $this->objAccessCrud->create ();
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
		if(!empty($_SESSION ['PK']['ACCESSCRUD'])){
			$id = $_SESSION ['PK']['ACCESSCRUD'];
			$this->objAccessCrud->readOne ( $id );
		}

		$this->fieldValue["cl_id_access_profile"] = $this->objAccessCrud->getIdAccessProfile();
		$this->fieldValue["cl_id_access_page"] = $this->objAccessCrud->getIdAccessPage();

		$this->fieldValue["cl_crud"] = $this->objAccessCrud->getCread();
		$this->fieldValue["cl_read"] = $this->objAccessCrud->getRead();
		$this->fieldValue["cl_update"] = $this->objAccessCrud->getUpdate();
		$this->fieldValue["cl_delete"] = $this->objAccessCrud->getDelete();

		$this->fieldValue["cl_date_insert"] = $this->objAccessCrud->getDateInsert();
		$this->fieldValue["cl_date_update"] = $this->objAccessCrud->getDateUpdate();

		return;
	 }

	private function update(){
		// Check if data saved.
		$id = $this->objAccessCrud->getId();
		if (empty ( $id )) return;
		// Check permission to update.
		$result = $this->clsAccessPermission->toUpdate();
		if(!$result){
			$this->msg->setWarn("You don't have permission to update!");
			return;
		}
		// Execute Update.
		if (! $this->objAccessCrud->update ()) {
			$this->msg->setError ("There were issues on update the record!");
			return;
		}
		$this->msg->setSuccess ("Updated the record with success!");
		return;
	}

	private function delete(){
		// Check if data saved.
		$id = $this->objAccessCrud->getId();
		if (empty ( $id )) return;
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toDelete();
		if(!$result){
			$this->msg->setWarn("You don't have permission to delete!");
			return;
		}
		if(!$this->objAccessCrud->delete($id)){
			$this->msg->setError ("There was an issue to delete, because this register has some relation with another one!");
			return;
		}
		// Cleaner all class values.
		$this->objAccessCrud->setAccessCrud(null);
		// Cleaner session primary key.
		$_SESSION['PK']['ACCESSCRUD'] = null;

		$this->msg->setSuccess ("Delete the record with success!");
		return;
	}
	
	private function getForm(){
		// PK
		$this->objAccessCrud->setId( !empty( $_SESSION ['PK']['ACCESSCRUD'] ) ? $_SESSION ['PK']['ACCESSCRUD'] : null );
		// FK	
		$this->objAccessCrud->setIdAccessProfile( !empty( $_POST ['soptIdAccessProfile'] ) ? $_POST ['soptIdAccessProfile'] : null );
		$this->objAccessCrud->setIdAccessPage( !empty( $_POST ['soptIdAccessPage'] ) ? $_POST ['soptIdAccessPage'] : null );
		// FORM
		$this->objAccessCrud->setCread( isset( $_POST ['rbtCreate'] ) ? $_POST ['rbtCreate'] : 0 );
		$this->objAccessCrud->setRead( isset( $_POST ['rbtRead'] ) ? $_POST ['rbtRead'] : 0 );
		$this->objAccessCrud->setUpdate( isset( $_POST ['rbtUpdate'] ) ? $_POST ['rbtUpdate'] : 0 );
		$this->objAccessCrud->setDelete( isset( $_POST ['rbtDelete'] ) ? $_POST ['rbtDelete'] : 0 );
		
		// Date update
		$this->objAccessCrud->setDateUpdate(date("Y-m-d H:i:s"));
	}
	private function validation(){

		$this->msg->setError ( empty($this->objAccessCrud->getIdAccessProfile())? 'PROFILE not information!': null);
		$this->msg->setError ( empty($this->objAccessCrud->getIdAccessPage())? 'PAGE not information!': null);

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

		// ACCESS PAGE

		$this->objAccessPage->readAll ();
		
		$this->sopt->start ();
		$this->sopt->setName ( "soptIdAccessPage" );
		$this->sopt->setFields ( $this->objAccessPage->getDescription() );
		$this->sopt->setValues ( $this->objAccessPage->getId() );
		$this->sopt->setWidth ( );
		$this->sopt->setSelected ( !empty($this->fieldValue["cl_id_access_page"])? $this->fieldValue["cl_id_access_page"] :null );
		$this->sopt->setOnChange ( true );
		
		define ( 'SOPT_ACCESSPAGE', $this->sopt->show () );

	 }

	 private function radioButton(){

		// CREATE
		$this->radio->start ();
		$this->radio->name ( "rbtCreate" );
		$this->radio->fields ( array("AVALIBLE", "UNAVALIBLE")  );
		$this->radio->values ( array(1,0) );
		$this->radio->checked ( !empty($this->fieldValue["cl_crud"])? $this->fieldValue["cl_crud"] :null );
		
		define ( 'RBT_CREATE', $this->radio->show());

		// READ
		$this->radio->start ();
		$this->radio->name ( "rbtRead" );
		$this->radio->fields ( array("AVALIBLE", "UNAVALIBLE")  );
		$this->radio->values ( array(1,0) );
		$this->radio->checked ( !empty($this->fieldValue["cl_read"])? $this->fieldValue["cl_read"] :null );
		
		define ( 'RBT_READ', $this->radio->show());

		// UPDATE
		$this->radio->start ();
		$this->radio->name ( "rbtUpdate" );
		$this->radio->fields ( array("AVALIBLE", "UNAVALIBLE")  );
		$this->radio->values ( array(1,0) );
		$this->radio->checked ( !empty($this->fieldValue["cl_update"])? $this->fieldValue["cl_update"] :null );
						
		define ( 'RBT_UPDATE',  $this->radio->show());

		// DELETE
		$this->radio->start ();
		$this->radio->name ( "rbtDelete" );
		$this->radio->fields ( array("AVALIBLE", "UNAVALIBLE")  );
		$this->radio->values ( array(1,0) );
		$this->radio->checked ( !empty($this->fieldValue["cl_delete"])? $this->fieldValue["cl_delete"] :null );
						
		define ( 'RBT_DELETE',  $this->radio->show());

	 }

}

 $controller = new AccessCrudController();

 ?>