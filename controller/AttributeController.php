<?php


	private $objAttribute;

	private $radio;
	private $checkbox;
	private $msg;
	private $validation;

	public $fieldValue;


		$this->objAttribute = new DaoAttribute();

		$this->radio = new RadioButton();
		$this->checkBox = new Checkbox();
		$this->msg = new MessageSystem();
		$this->validation = new Validation();

			$this->requestGet();
		} elseif ($_POST) {
			$this->getForm();
			if(!empty ( $_POST ['btnSave'])) { $this->save(); }
		}

		$this->selectOption();
		$this->radioButton();
		$this->checkbox();

	 }


			$_SESSION ['PK'] = null;
			unset($_SESSION ['PK']);
			$_SESSION ['retorno'] = null;
			unset($_SESSION ['retorno']);
		}
		if(!empty($_GET['gAttribute'])){
			 $_SESSION['PK']['ATTRIBUTE'] = $id = $_GET['gAttribute'];
		}		return;
	}


 			$id = $_SESSION ['PK']['ATTRIBUTE'];
			$this->objAttribute->selectOne ( $id );

		}
		$this->fieldValue["cl_description"] = $this->objAttribute->getDescription();
		return;
	 }





			$idCadastro = $this->objAttribute->insert ();
			if (! $idCadastro) {
 				$this->msg->setMessageError ('Houve um erro ao alterar o cadastro!' );
				return;
			}
			$_SESSION ['PK']['ATTRIBUTE'] = $idCadastro;
			$this->attSave();

		} else {
			if (! $this->objAttribute->update ()) {
				$this->msg->setMessageError ('Houve um erro ao alterar o cadastro!' );
			}
			$this->attSave();

		}

	}

		// PK
		$this->objAttribute->setId( !empty( $_SESSION ['PK']['ATTRIBUTE'] ) ? $_SESSION ['PK']['ATTRIBUTE'] : null );
		// FORM
		$this->objAttribute->setDescription( !empty( $_POST ['txtDescription'] ) ? $_POST ['txtDescription'] : null );
	}
	private function validation(){


	 }









}

