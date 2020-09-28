<?php
require_once "../config/config.php"; 
// Auxiliary Library 
require_once "CnnMySqli.php"; 
require_once "MessageSystem.php"; 
require_once "DataGridQueryV3.php"; 
require_once "AttributeListController.php";
// Layout 
require_once "header.php";
?>
<div id="content-center">
	<h3>Services / Attribute / List</h3>	<?php require_once "submenu.php";?>
		<div id="content-form">
		<h4>Attribute</h4>
		<?=MSG?>
			<form action="<?=$_SERVER ['SCRIPT_NAME']?>" method="get">
				<input type="text" name="search" id="idDescricao" value="<?=$controller->fieldValue['search']?>" style="width:350px;" placeholder="" />
				<input type="submit" name="btnSearch" value="Search" />
			</form>
		<?=DATAGRID?>
		</div>
	</div>
<?php require_once "bottom.php";?>