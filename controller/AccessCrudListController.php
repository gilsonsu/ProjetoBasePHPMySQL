<?php

// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "MessageSystem.php"; 
require_once "DataGridQueryV3.php";
class AccessUserListController {

	private $clsAccessPermission;
	private $cnn;
	private $msg;
	private $sql;
	public $fieldValue;

	function __construct(){

		// Access.
		$this->clsAccessPermission = new AccessPermission();
		// Database connection.
		$this->cnn = new CnnMySqli();
		// Others.
		$this->msg = new MessageSystem();
		$this->request();

		define('DATAGRID',$this->dataGrid());
		define('MSG',$this->msg->getMessageSystem());
	}

	private function request() {

		if (empty($_GET)) return;
		if (! empty ( $_GET ['action'] ) and $_GET ['action'] == 'new' ) {

			$_SESSION ['PK'] = null;
			unset($_SESSION ['PK']);
			$_SESSION ['REDIRECTION'] = null;
			unset($_SESSION ['REDIRECTION']);
		}

		if(!empty( $_GET ['redirection'] )){
			$_SESSION ["REDIRECTION"] = $_GET ['redirection'];
		}

		if(!empty($_GET['btnSearch'])){
			if(!empty($_GET['search'])){
				$this->fieldValue['search'] = $_GET['search'] ;
			}else{
				$this->msg->setError("There was a problem, you need to type something to get a result!");	
			}
		}
	}

	private function query(){
		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toRead();
		if(!$result){
			$this->msg->setWarn("You don't have permission to read!");
			return;
		}
		// Make a condition.
		$cond = null;
		$condLike = array();
		if(!empty($this->fieldValue['search'])){
			$desc = explode(" ",$this->fieldValue['search']);
			$total = sizeof($desc);
			for($i=0;$i<$total;$i++){
				$condLike[$i] = " CONCAT(coalesce(a1.cl_name,''),
				coalesce(a1.cl_email,'')) LIKE '%" . $desc[$i] . "%'";
			}

			$cond .= " AND (".implode(" OR ",$condLike)." )";
		}
		// Render query
		$this->sql  =  " select  ";
		$this->sql .=  " a1.cl_id, ";
		$this->sql .=  " a2.cl_name as profile, ";
		$this->sql .=  " a3.cl_description as page_desc, ";
		$this->sql .=  " a3.cl_name as page_name, ";
		$this->sql .=  " if(a1.cl_create = 1, '<span style=\"color:blue;\">TRUE</span>', '<span style=\"color:red;\">FALSE</span>') as p_create, ";
		$this->sql .=  " if(a1.cl_read = 1, '<span style=\"color:blue;\">TRUE</span>', '<span style=\"color:red;\">FALSE</span>') as p_read, ";
		$this->sql .=  " if(a1.cl_update = 1, '<span style=\"color:blue;\">TRUE</span>', '<span style=\"color:red;\">FALSE</span>') as p_update, ";
		$this->sql .=  " if(a1.cl_delete = 1, '<span style=\"color:blue;\">TRUE</span>', '<span style=\"color:red;\">FALSE</span>') as p_detele, ";
		$this->sql .=  " a1.cl_date_insert, ";  
		$this->sql .=  " a1.cl_date_update ";
		$this->sql .=  " FROM tb_access_crud AS a1" ;
		$this->sql .=  " inner join tb_access_profile as a2 on(a2.cl_id = a1.cl_id_access_profile)";
		$this->sql .=  " inner join tb_access_page as a3 on(a3.cl_id = a1.cl_id_access_page)";
		$this->sql .=  " WHERE 1=1 $cond ";
		$this->sql .=  " ORDER BY 1 DESC " ;

		return;
	 }

	 private function dataGrid() {

		$this->query();

		$dg = new DataGridQueryV3 ();

		// Config DataGrid
		$dg->config->name ( "gCrud" );
		$dg->config->query ( $this->sql );
		$dg->config->refDatabaseId( $this->cnn->getIdConection () );
		$dg->config->refDatabaseTable("tb_access_crud");
		$dg->config->refDataBaseTablePrimarykey("cl_id");
		$dg->config->pageRowLimit ( 5 );

	// Config html table
		$dg->table->borderSize( 0 );
		$dg->table->width( "100%" );
		$dg->table->cssClass( "datagrid" );
		$dg->table->titleAlign( "left" );
		$dg->table->navigator(true);

		// Check if there are permission to execute delete command.
		$result = $this->clsAccessPermission->toUpdate();
		if(!$result){
			$this->msg->setWarn("You don't have permission to update!");
		}else{
			// Config html table column
			$dg->column->start( );
			$dg->column->refDataBaseTableColumn( "cl_id" );
			$dg->column->title( "&nbsp;" );
			$dg->column->type("imagelink");
			$dg->column->align( "left" );
			$dg->column->width( 5 );

			 if(!empty($_SESSION ["REDIRECTION"])){
				 $dg->column->imageUrl("public/img/select.png");
				 $dg->column->linkUrl ( $_SESSION ["REDIRECTION"].".php" );
			 } else{
				 $dg->column->imageUrl("public/img/edit.png");
				 $dg->column->linkUrl ( "formAccessPermission.php" );
			 }
		}

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "profile" );
		$dg->column->title( "PROFILE" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "page_desc" );
		$dg->column->title( "PAGE NAME" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "page_name" );
		$dg->column->title( "PAGE" );
		$dg->column->align( "left" );
		$dg->column->width(  );
		
		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "p_create" );
		$dg->column->title( "CREATE" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "p_read" );
		$dg->column->title( "READ" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "p_update" );
		$dg->column->title( "UPDATE" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "p_detele" );
		$dg->column->title( "DELETE" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		//Show columns date insert and date update.
		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "cl_date_insert" );
		$dg->column->title( "CREATE DATE" );
		$dg->column->align( "left" );
		$dg->column->width(  );

		$dg->column->start( );
		$dg->column->refDataBaseTableColumn( "cl_date_update" );
		$dg->column->title( "EDIT. DATE" );
		$dg->column->align( "left" );
		$dg->column->width(  );
		return $dg->render();
	 }

}

$controller = new AccessUserListController();
?>
