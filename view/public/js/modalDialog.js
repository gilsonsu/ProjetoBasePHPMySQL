
//
//
// Modal Dialog hide and show.

function showModalDialog(pageName) {
    let modalDialog = document.getElementById("modal-dialog");
    modalDialog.style.display = "block";
    window.document.getElementById('ifrSearchModal').src = pageName;
}

function hideModalDialog(pageName){
    let modalDialog = document.getElementById("modal-dialog");
    modalDialog.style.display = "none";
    window.document.getElementById('ifrSearchModal').src = pageName;
}