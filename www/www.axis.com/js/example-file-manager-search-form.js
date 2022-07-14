
var userCanManageContacts = 0;

(function($) {
	$(document).ready(function() {
		userCanManageContacts = $('#userCanManageContacts').val();
		//userCanManageContacts = 1;

		$('#filenameSearch')

		// Set focus to the search input form element
		.focus()

		// Load the autocomplete input box for the filename
		.autocomplete({
			minLength: 1,
			autoFocus: false,
			select: updateSearchButton,
			focus: listItemFocus,
			source: "modules-file-manager-file-browser-ajax.php?method=searchByFilename"
		})

		// When <enter> is depressed, hide the auto-complete results.
		.keypress(function(event) {
			if (event.keyCode == 13) {
				$(".ui-autocomplete").hide();
				//checkSelection();
				return false;
			}
		})

		//
		.data("autocomplete")._response = function(content) {
			//alert(content);
			$("#btnFilenameSearch").show();
			if (content.length == 0) {
				if (userCanManageContacts == 1) {
					$("#btnFilenameSearch").val("Create New Company");
				}
			} else {
				var currentSearch = $("#filenameSearch").val().toLowerCase();
				var matches = false;
				var buttonLabel = "";
				$.each(content, function(key, value) {
					var itemID = content[key]['value'];
					var itemLabel = content[key]['label'];
					if (itemLabel.toLowerCase() == currentSearch) {
						matches = true;
						buttonLabel = itemLabel;
						$("#filenameSearchID").val(itemID);
						$("#filenameSearch").val(itemLabel);
						return false;
					}
				});

				if (userCanManageContacts == 1) {
					if (matches) {
						$("#btnFilenameSearch").val("Manage " + buttonLabel);
					} else {
						$("#btnFilenameSearch").val("Create New Company");
						$("#filenameSearchID").val(0);
					}
				} else {
					if (matches) {
						$("#btnFilenameSearch").val("View " + buttonLabel);
					}
				}
			}

			if ( !this.options.disabled && content && content.length ) {
				content = this._normalize( content );
				this._suggest( content );
				this._trigger( "open" );
			} else {
				this.close();
			}
			this.pending--;
			if ( !this.pending ) {
				this.element.removeClass( "ui-autocomplete-loading" );
			}
		};

		// Bind the <input type="buttion" id="btnFilenameSearch"> to the showFilePreview() function
		initFilenameSearchButton();
	});
})(jQuery);

function initFilenameSearchInput()
{


}

function initFilenameSearchButton()
{
	//alert('initFilenameSearchButton()');
	// Bind the <input type="buttion" id="btnFilenameSearch"> to the showFilePreview() function
	$("#btnFilenameSearch").click(showFilePreview);
}

// Show a file preview from the file selected in the search results.
function showFilePreview()
{
	var filenameSearchID = $("#filenameSearchID").val();
	var filenameSearchName = $("#filenameSearch").val();

	//alert('File: ' + filenameSearchID + ' Class: ' + filenameSearchName);
	previewFile(filenameSearchID, filenameSearchName);
}

function previewFile(file, theClass)
{
	var isImage = 0;
	if (theClass.indexOf('jpg') > 0 || theClass.indexOf('png') > 0 || theClass.indexOf('gif') > 0 || theClass.indexOf('tif') > 0) {
		isImage = 1;
	}
	//alert('theFile: ' + file + ' theClass: ' + theClass);
	//alert('tblheight:' + $("#tblFileModule").height() + ' tbltop:' + $("#tblFileModule").offset().top + '\n\n' + 'winheight:' + $(window).height());
	var tblHeight = $(window).height() - $("#filePreview").offset().top;
	//$("#tblFileModule").height($(window).height() - $("#tblFileModule").offset().top);
	$("#tblFileModule").show();
	$("#filePreview").load('/modules-file-manager-file-browser-ajax.php?method=loadPreview&file=' + encodeURIComponent(file) + '&height=' + tblHeight + '&isImage=' + isImage);
	//showDetails('li_' + file,'file');
}

function showDetails(id,nodeType) {
	//alert(id);
	//alert('tblheight:' + $("#tblFileModule").height() + ' tbltop:' + $("#tblFileModule").offset().top + '\n\n' + 'winheight:' + $(window).height());

	$("#tblFileModule").show();
	var minHeight = $(window).height() - $("#tblFileModule").offset().top;
	if ($("#tblFileModule").height() < minHeight) {
		//alert('yes');
		$("#tblFileModule").height(minHeight);
	}
	//document.getElementById('tblFileModule').style.minHeight = minHeight + "px";

	var isTrash = "no";
	if ( $("#" + id).hasClass("trash")) {
		isTrash = "yes";
	}

	$(".jqueryFileTree LI A").removeClass("ui-selected");
	lastATagClicked = $("#" + id + " > a");
	$(".contextMenu").hide();
	$("#" + id + " > a").addClass("ui-selected");
	var elementId = id;
	if (nodeType == "folder") {
		$("#filePreview").empty();
		var path = $("#" + id).attr("rel");
		//alert('thePath: ' + path);
		if (path.indexOf("~/") != 0 && path != "/") {
			id = id.replace("liFolder_", "");
		} else {
			id = 1;
		}
	} else {
		id = id.replace("li_","");
	}
	//alert('theID is: ' + id);
	if (id != 1) {
		$("#fileDetails").load(
			'/modules-file-manager-file-browser-ajax.php?method=loadDetails' +
			'&nodeId=' + encodeURIComponent(id) +
			'&nodeType=' + encodeURIComponent(nodeType) +
			'&isTrash=' + encodeURIComponent(isTrash) +
			'&elementId=' + encodeURIComponent(elementId)
		);
		$("#fileDetails").show();
	} else {
		$("#fileDetails").hide();
	}

}

function listItemFocus(event, ui) {
	$("#filenameSearchID").val(ui.item.value);
	$("#filenameSearch").val(ui.item.label);
	return false;
}

function updateSearchButton(event, ui) {
	$("#filenameSearch").val(ui.item.label);
	$("#btnFilenameSearch").show();
	if (userCanManageContacts == 1) {
		$("#btnFilenameSearch").val("Manage " + ui.item.label);
	} else {
		$("#btnFilenameSearch").val("View " + ui.item.label);
	}
	return false;
}
