<div id="form-menu">
<ul>
<?php

require_once "PageReferer.php";

$pr = new PageReferer();
$currentPage = $pr->current();
$subMenu = null;

// Insert your menu code below.


// Show your menu.
echo $subMenu;

?>
</ul>
</div>