var files;

//Stop default actions
function stopProp(ev) {
    ev.stopPropagation();
    ev.preventDefault();
}

function init() {
    var dropZone = document.getElementById("fileDrop");
    //dropZone.addEventListener("dragenter",  stopProp, false);
    //dropZone.addEventListener("dragleave",  stopProp, false);
    dropZone.addEventListener("dragover",  stopProp, false);
    dropZone.addEventListener("drop",  setFile, false);
    dropZone.addEventListener("drop",  doUpload, false);

    //var upload = document.getElementById("upload");
    //upload.addEventListener("click",  doUpload, false);
}

//Save the dropped files
function setFile(e) {
    e.stopPropagation();
    e.preventDefault();

    files = e.dataTransfer.files;

    //alert(files[0].name);

    return false;
}

function handleResult(xhr) {
	alert(xhr.responseText);
}
function doUpload(e) {
	var ele = e;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
       if (xhr.readyState == 4) {
               handleResult(xhr);
       }
    };
    // hard coded for how
    var queryString = "/unit-test-file-uploader-ajax.php?custom_label=Drop+or+Click+Files&style=vertical-align%3A+middle%3B&drop_text_prefix=&allowed_extensions=pdf&method=gcBudgetLineItemBidInvitations&action=%2Funit-test-file-uploader-ajax.php&post_upload_js_callback=&append_date_to_filename=1&prepend_date_to_filename=0&virtual_file_name=&virtual_file_path=%2FBidding+%26+Purchasing%2F01-000+General+Requirements%2F%5B01-000%5D+Bid+Invitations%2F&project_id=3&folder_id=144&class=boxViewUploader&id=hello_world";
    var file = files[0];
    xhr.open("POST", queryString, true);
    //xhr.open("POST", "unit-test-file-uploader-ajax.php");

    //Set a few headers so we know the file name in the server
    xhr.setRequestHeader("Cache-Control", "no-cache");
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.setRequestHeader("X-File-Name", file.name);
    xhr.setRequestHeader("Content-Type", "application/octet-stream");

    //Initiate upload
    xhr.send(file);

    stopProp(e);
}