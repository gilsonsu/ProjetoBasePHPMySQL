<?php
require_once "../config/config.php";
// Controller 
require_once "AccessIndexController.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=APPLICATION_NAME?></title>
<link rel="stylesheet" type="text/css"
	href="public/css/styleLogin.css" />
<script>
    var frame = window.frameElement;
    if (frame) {
       top.window.location='index.php';
    }
</script>
</head>
<body>
	<div id="content">
		<div  id="app-logo"><img src="<?=APPLICATIOIN_LOGO?>"></div>
		<div id="app-name"><?=APPLICATION_NAME?></div>
		<div id="app-access-msg"><?=MSG?></div>
		<div id="app-access-form">
			<form action="<?=$_SERVER ['SCRIPT_NAME'];?>" method="post">
					<input name="txtEmail" type="text" size="15" maxlength="200" placeholder="E-mail" />
					<input name="txtPwd" type="password" size="15" maxlength="200" placeholder="Password" />
					<input type="submit" name="btnSend" value="Access" />
			</form>
		</div>
	</div>
</body>
</html>
