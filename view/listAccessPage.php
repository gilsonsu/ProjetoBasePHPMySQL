<?php
require_once "../config/config.php"; 
// Controller
require_once "AccessPageListController.php";
// Layout 
require_once "header.php";
?>
<div id="content-center">
	<h3>Access Manger / Page / List</h3>	<?php require_once "AccessSubmenu.php";?>
	<div id="content-form">
		<h4>Page</h4>
		<?=MSG?>
		<form action="<?=$_SERVER ['SCRIPT_NAME']?>" method="get">
			<input type="text" name="search" id="idSearch" value="<?=$controller->fieldValue['search']?>" style="width:350px;" placeholder="" />	
			<input type="submit" name="btnSearch" value="Search" />
		</form>
		<?=DATAGRID?>
	</div>
</div>
<?php require_once "bottom.php";?>