<?php 
require_once "../config/config.php";
// Controller 
require_once "AccessProfileController.php";
// Layout 
require_once "header.php";
?>
<script>
// Fetch php to get json.
async function getJson(ctrl, method, id) {
    let response = null;
    if (id == null) {
        response = await fetch("action.php?ctrl=" + ctrl + "&method=" + method);
    } else {
        response = await fetch("action.php?ctrl=" + ctrl + "&method=" + method + "&id=" + id);
    }
    if (response.ok) {
        return await response.json();
    } else {
        console.log(response.log);
        return null;
    }
}

function confirmDelete() {
    var value = document.getElementById('idCkbDelete').checked;
    if (value == true) {
        document.getElementById('content-delete-check').style.display = "block";
    } else {
        document.getElementById('content-delete-check').style.display = "none";
        document.getElementById('idCkbConfirmDelete').checked = false;
    }
}
</script>

<div id="content-center">
    <h3>Access Manger / Profile / Register</h3>
    <?php require_once "AccessSubmenu.php"; ?>

    <div id="content-form">
        <h4>Profile</h4>
        <?=MSG?>
        <form action="<?=$_SERVER ['SCRIPT_NAME']?>" method="post">
            <table border='0'>
                <tr>
                    <td class="form-label">Name:</td>
                    <td class="form-field"><input type="text" name="txtName" id="idName" value="<?=$controller->fieldValue['cl_name']?>" />
                    </td>
                </tr>
                <tr>
                    <td class="form-label">Description:</td>
                    <td class="form-field"><input type="text" name="txtDescription" id="idDescription"
                            value="<?=$controller->fieldValue['cl_description']?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div id='content-delete'><label><input type='checkbox' id='idCkbDelete' name='ckbDelete'
                                    value='true' onchange='confirmDelete()'> Delete this register!</label></div>
                        <div id='content-delete-check'><label><input type='checkbox' id='idCkbConfirmDelete'
                                    name='ckbConfirmDelete' value='true'> I agree that the record is going to be
                                delected and won't be recovered!</label></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="btnSave" value="Salvar" /></td>
                </tr>
            </table>
        </form>
    </div>

</div>
<?php require_once "bottom.php"; ?>