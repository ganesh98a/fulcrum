
function expandCollapseContent_Arrow(contentElementId, iconElementId)
{

	$("#" + contentElementId).toggle();

	if ($("#" + iconElementId).hasClass("ui-icon ui-icon-triangle-1-e")) {

		$("#" + iconElementId).removeClass("ui-icon ui-icon-triangle-1-e");
		$("#" + iconElementId).addClass("ui-icon ui-icon-triangle-1-s");

	} else {

		$("#" + iconElementId).removeClass("ui-icon ui-icon-triangle-1-s");
		$("#" + iconElementId).addClass("ui-icon ui-icon-triangle-1-e");

	}

}

function expandCollapseContent_Entypo(contentElementId, iconElementId)
{

	$("#" + contentElementId).toggle();

	if ($("#" + iconElementId).hasClass("entypo-plus-squared")) {

		$("#" + iconElementId).removeClass("entypo-plus-squared");
		$("#" + iconElementId).addClass("entypo-minus");

	} else {

		$("#" + iconElementId).removeClass("entypo-minus");
		$("#" + iconElementId).addClass("entypo-plus-squared");

	}

}

function clickPreviousHiddenFileInput(element)
{
	$(element).prev().click();
}
