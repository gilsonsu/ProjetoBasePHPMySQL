<?php
 class AttributeController {
	private $objAttribute;
	private $objAttribute;
	private $sopt;
	private $radio;
	private $checkbox;
	private $msg;
	private $validation;
	public $attribute;
	public $fieldValue;
	function __construct(){
		$this->objAttribute = new DaoAttribute();
		$this->objAttribute = new DaoAttribute();
		$this->sopt = new SelectOption();
		$this->radio = new RadioButton();
		$this->checkBox = new Checkbox();
		$this->msg = new MessageSystem();
		$this->validation = new Validation();
		if ($_GET) {
			$this->requestGet();
		} elseif ($_POST) {
			$this->getForm();
			if(!empty ( $_POST ['btnSave'])) { $this->save(); }
		}
		$this->setForm();
		$this->selectOption();
		$this->radioButton();
		$this->checkbox();
		define('MSG',$this->msg->getMessageSystem());
	 }
	private function requestGet() {
		if (! empty ( $_GET ['action'] )) {
			$_SESSION ['PK'] = null;
			unset($_SESSION ['PK']);
			$_SESSION ['retorno'] = null;
			unset($_SESSION ['retorno']);
		}
		if(!empty($_GET['gAttribute'])){
			 $_SESSION['PK']['ATTRIBUTE'] = $id = $_GET['gAttribute'];
		}		return;
	}
	private function setForm(){
		if(!empty($_SESSION ['PK']['ATTRIBUTE'])){
 			$id = $_SESSION ['PK']['ATTRIBUTE'];
			$this->objAttribute->selectOne ( $id );

		}
		$this->fieldValue["cl_description"] = $this->objAttribute->getDescription();
		return;
	 }
	private function save() {
		$this->validation ();
		if (! $this->msg->confirmeErro ()) {return;}
		$idCadastro = $this->objAttribute->getId();
		if (empty ( $idCadastro )) {
			$idCadastro = $this->objAttribute->insert ();
			if (! $idCadastro) {
 				$this->msg->setMessageError ('Houve um erro ao alterar o cadastro!' );
				return;
			}
			$_SESSION ['PK']['ATTRIBUTE'] = $idCadastro;
			$this->attSave();
			$this->msg->setMessageSucess ( 'Cadastro realizado com sucesso' );
		} else {
			if (! $this->objAttribute->update ()) {
				$this->msg->setMessageError ('Houve um erro ao alterar o cadastro!' );
			}
			$this->attSave();
			$this->msg->setMessageSucess ( 'Alteração realizada com sucesso' );
		}
		return;
	}
	private function getForm(){
		// PK
		$this->objAttribute->setId( !empty( $_SESSION ['PK']['ATTRIBUTE'] ) ? $_SESSION ['PK']['ATTRIBUTE'] : null );
		// FORM
		$this->objAttribute->setDescription( !empty( $_POST ['txtDescription'] ) ? $_POST ['txtDescription'] : null );
	}
	private function validation(){
		$this->msg->setMessageError ( $this->validation->notNull ($this->objAttribute->getDescription (), 'DESCRIPTION not information! ' ) );

	 }
	private function selectOption(){
		$sopt = new SelectOption();
	 }
	private function radioButton(){
	 }
	private function checkbox(){
	 }


}
 $controller = new AttributeController();
 ?>