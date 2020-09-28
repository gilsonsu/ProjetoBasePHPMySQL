<?php 
require_once "../config/config.php";
// Controller 
require_once "AccessUserController.php";
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
    <h3>Access Manger / User / Register</h3>
    <?php require_once "AccessSubmenu.php"; ?>

    <div id="content-form">
        <h4>User</h4>
        <?=MSG?>
        <form action="<?=$_SERVER ['SCRIPT_NAME']?>" method="post">
            <table border='0'>
                <tr>
                    <td class="form-label">Profiles:</td>
                    <td class="form-field"><?=SOPT_ACCESSPROFILE?></td>
                </tr>
                <tr>
                    <td class="form-label">Active:</td>
                    <td class="form-field"><?=SOPT_ATT_ACTIVE?></td>
                </tr>
                <tr>
                    <td class="form-label">Name:</td>
                    <td class="form-field"><input type="text" name="txtName" id="idName" value="<?=$controller->fieldValue['cl_name']?>" />
                    </td>
                </tr>
                <tr>
                    <td class="form-label">E-mail:</td>
                    <td class="form-field"><input type="text" name="txtEmail" id="idEmail"
                            value="<?=$controller->fieldValue['cl_email']?>" /></td>
                </tr>
                <tr>
                    <td class="form-label">Password:</td>
                    <td class="form-field"><input type="text" name="txtPwd" id="idPwd" value="<?=$controller->fieldValue['cl_pwd']?>" />
                    </td>
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