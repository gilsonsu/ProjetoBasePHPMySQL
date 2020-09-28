<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=APPLICATION_NAME?></title>

<link rel="stylesheet" type="text/css" href="public/css/layout.css" />
<link rel="stylesheet" type="text/css" href="public/css/styleGrid.css" />
<link rel="stylesheet" type="text/css" href="public/css/styleModalDialog.css" />

<script type="text/javascript"
	src="public/js/modalDialog.js">
</script>
</head>
<body>
	
	<!-- MODAL -->
	<div id='modal-dialog'>
		<a id='modal-dialog-button' onclick="hideModalDialog('loading.php')"><img src='public/img/close.png'></a>
		<iframe name='ifrSearchModal' id='ifrSearchModal' src='loading.php' width='100%' height='100%'
			frameBorder='0'></iframe>
	</div>
	<!-- / MODAL -->

	<!-- CONTENT FIRST -->
	<div id="main">

		<!-- USER MENU -->
		<div id="user-menu">
			<span id="user-name">Welcome <?=$ac->getName()?> </span>
			<a href="index.php" id="user-btn-logout">Log Out</a>
		</div>
		<!-- / USER MENU -->

		<!-- SIDEBAR -->
		<div id="sidebar">
			<h2><?=APPLICATION_NAME?></h2>
			<div id="content-logo">
				<div id="logo"></div>
			</div>
			<div id="content-menuleft-scroll">
				<div class="content-menuleft-title">Services</div>
				<ul>
					<li><a href="dashboard.php">Dashboard</a></li>
					
					<?php require_once "menu.php"; ?>

				</ul>
				<div  class="content-menuleft-title">Access Manage</div>
				<ul>
					<li><a href="listAccessPermission.php?action=new">Permissions</a></li>
					<li><a href="listAccessUser.php?action=new">Users</a></li>
					<li><a href="listAccessProfile.php?action=new">Profiles</a></li>
					<li><a href="listAccessPage.php?action=new">Pages</a></li>
				</ul>
			</div>
		</div>
		<!-- / SIDEBAR -->
