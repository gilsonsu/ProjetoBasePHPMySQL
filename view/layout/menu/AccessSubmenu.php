<div id="form-menu">
<ul>
<?php

require_once "PageReferer.php";

$pr = new PageReferer();
$currentPage = $pr->current();

$subMenu = null;

//
//
// ACCESS MANAGE

// Permisson
if($currentPage == "formAccessPermission" || $currentPage == "listAccessPermission" ){
	 $subMenu .= "<li><a href='listAccessPermission.php?action=new'>List registers</a></li>";
	 $subMenu .= "<li><a href='formAccessPermission.php?action=new'>New register</a></li>";
}

// User
if($currentPage == "formAccessUser" || $currentPage == "listAccessUser" ){
	 $subMenu .= "<li><a href='listAccessUser.php?action=new'>List registers</a></li>";
	 $subMenu .= "<li><a href='formAccessUser.php?action=new'>New register</a></li>";
}

// Profile
if($currentPage == "formAccessProfile" || $currentPage == "listAccessProfile" ){
	 $subMenu .= "<li><a href='listAccessProfile.php?action=new'>List registers</a></li>";
	 $subMenu .= "<li><a href='formAccessProfile.php?action=new'>New register</a></li>";
}

// Pager
if($currentPage == "formAccessPage" || $currentPage == "listAccessPage" ){
	 $subMenu .= "<li><a href='listAccessPage.php?action=new'>List registers</a></li>";
	 $subMenu .= "<li><a href='formAccessPage.php?action=new'>New register</a></li>";
}

echo $subMenu;

?>
</ul>
</div>