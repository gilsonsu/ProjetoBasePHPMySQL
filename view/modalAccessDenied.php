<?php 
require_once "../config/config.php";
// Layout.
require_once "headerModal.php";
?>
<div id="content-center">
	<h3>Access Manger / Access Denied</h3>
	<?php require_once "AccessSubmenu.php"; ?>

	<div id="content-form">
        <h4>Access Denied</h4>
        <div style="margin-top:30px;height:300px;">
            <span style="
                float:left;
                width:70px;
                height:70px;
                margin:0;
                margin-left:20px;
                font-weight:bold;
                color:#FFF;
                display: block;
                background: #4682B4;
                border-radius: 50px;
                font-size:64px;
                text-align:center;
                ">&#x00456;</span>
            <div style="margin-left:120px;">    
                <p>
                User don't have pession registed to using list or form!        
                </p>
                <p>
                    Make a solicitation to acesso from System Menager.
                </p>
                <p>
                    Tank you for compriation!
                </p>
            </div>
        </div>
	</div>	
	
</div>
<?php require_once "bottom.php"; ?>