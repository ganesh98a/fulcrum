
var globalVariable1 = 0;
var globalVariable2 = '';

if (!jQuery) {
	alert('JQuery is either not loaded or unavailable.');
}

// Document.ready

//$( document ).ready( handler )
//$().ready( handler ) (this is not recommended)
//$( handler )

// Shorthand for $( document ).ready()
// shorthand code: $() for $( document ).ready()
/*
$(function() {
    console.log("ready!");
});
*/

(function($) {
	$(document).ready(function() {
		// Init page js code here...

	});
})(jQuery);


function createCostCodeDatum(datumType)
{
	try {

		(function($) {
		  // Code goes here

			// Debug
			//alert(datumType);

			if (datumType == 'cost_codes') {

				var cost_code_division_id = '';
				if ($("#ddlCostCodeDivisionId").length) {
					cost_code_division_id = $("#ddlCostCodeDivisionId").val();
				}
				//alert(cost_code_division_id);

				var cost_code = $("#cost_code").val();
				var cost_code_description = $("#cost_code_description").val();
				var cost_code_description_abbreviation = $("#cost_code_description_abbreviation").val();

				if (cost_code_division_id == '') {
					alert('Please select a division.');
					return;
				}

				if (cost_code == '') {
					alert('Please enter a numeric cost code value.');
					return;
				}

				var ajaxQueryStringAdditionalValues =
					'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
					'&cost_code=' + encodeURIComponent(cost_code) +
					'&cost_code_description=' + encodeURIComponent(cost_code_description) +
					'&cost_code_description_abbreviation=' + encodeURIComponent(cost_code_description_abbreviation);

			} else if (datumType == 'cost_code_divisions') {

				var cost_code_type_id = -1;
				if ($("#ddlCostCodeTypeId").length) {
					cost_code_type_id = $("#ddlCostCodeTypeId").val();
				}
				//alert(cost_code_type_id);

				var division_number = $("#division_number").val();
				var division_code_heading = $("#division_code_heading").val();
				var division = $("#division").val();
				var division_abbreviation = $("#division_abbreviation").val();

				if (division_number == '') {
					alert('Please enter a numeric division number.');
					return;
				}

				if (division == '') {
					alert('Please enter a division.');
					return;
				}

				var ajaxQueryStringAdditionalValues =
					'&cost_code_type_id=' + encodeURIComponent(cost_code_type_id) +
					'&division_number=' + encodeURIComponent(division_number) +
					'&division_code_heading=' + encodeURIComponent(division_code_heading) +
					'&division=' + encodeURIComponent(division) +
					'&division_abbreviation=' + encodeURIComponent(division_abbreviation);

			} else {
				// Invalid datumType input
				return;

				// @todo Possibly write to error log...
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=createCostCodeDatum';
			var ajaxQueryString =
				'datumType=' + encodeURIComponent(datumType) +
				ajaxQueryStringAdditionalValues;
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: createCostCodeDatumSuccess,
				error: errorHandler
			});

		})(jQuery);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createCostCodeDatumSuccess(response, textStatus, jqXHR)
{
	try {

		(function($) {

			// Debug
			// errorMessage|cost_code|cost_code_id
			//alert(response);
			var arrTemp = response.split('|');
			var errorMessage = arrTemp[0];
			var attributeName = arrTemp[1];
			var attributeId = arrTemp[2];
			var formattedAttributeName = arrTemp[3];

			if (attributeId > 0) {

				var cost_code_type_id = -1;
				if ($("#ddlCostCodeTypeId").length) {
					cost_code_type_id = $("#ddlCostCodeTypeId").val();
				}

				var ajaxHandler2 = '/modules-gc-budget-ajax.php?method=loadGCCostCodes';
				var ajaxQueryString2 = 'cost_code_type_id=' + encodeURIComponent(cost_code_type_id);
				var ajaxUrl2 = ajaxHandler2 + '&' + ajaxQueryString2;

				if (window.ajaxUrlDebugMode) {
					var continueDebug = window.confirm(ajaxUrl2);
					if (continueDebug != true) {
						return;
					}
				}

				$("#tblImportCostCodes").load(ajaxUrl2, function( response, status, xhr ) {

					// row_cost_code_513
					var elementId = 'row_' + attributeName + '_' + attributeId;
					// Debug
					//alert(elementId);

					if ($("#" + elementId).length) {
						var messageText = formattedAttributeName + ' successfully created.';
						messageAlert(messageText, 'successMessage', 'successMessageLabel', elementId);
					} else {
						messageAlert(errorMessage, 'errorMessage');
					}

				});
			} else {
				messageAlert(errorMessage, 'errorMessage');
			}

		})(jQuery);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
