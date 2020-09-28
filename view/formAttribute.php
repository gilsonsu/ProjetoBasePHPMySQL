<?php 
require_once "../config/config.php";
require_once "AttributeController.php";
require_once "header.php";
require_once "menu.php";
?>
<div id="divForm">
	<h3>Attribute / Register</h3>
	<?php require_once "submenu.php"; ?>
	<?=MSG?>
	<fieldset><legend>Register</legend>
		<form action="<?=$_SERVER ['SCRIPT_NAME']?>" method="post">
		<table border='0'>
			<tr> <td></td><td><input type="submit" name="btnSalvar" value="Salvar" /></td> </tr>
		</table>
		</form>
	</fieldset>
</div>
<?php require_once "bottom.php"; ?>