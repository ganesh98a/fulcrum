$(document).ready(function() {
	var search=window.location.pathname;
	if(search!='')
	{
		var id = search.split('/');
		var sub_id=id[1];
		if(sub_id !='guest')
		{
			$('body').addClass('budget-contract-pagespace');

		}
	}
	createUploaders();
		$(".tbodySortable").sortable({
			axis: 'y',
			distance: 10,
			helper: sortHelper,
			update: function(event, ui) {
				var trElement = $(ui.item)[0];
				var endIndex = $(ui.item).index();
				endIndex = endIndex.toString();
				var options = { endIndex: endIndex };
				updateSubcontractDocument(trElement, options);
			}
		});
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd', numberOfMonths: 1 });
		initializePopovers();

		$(".allfieldupdate").trigger("change");
	$(".show_info_txt").on("click", function(e) {
		$(".dropdown-content-change-order").toggleClass("show_cont_change_order");
		});
  	$(document).on("click", function(e) {
    	if ($(e.target).is(".show_info_txt") === false) {
    	  	$(".dropdown-content-change-order").removeClass("show_cont_change_order");
    	}
  	});

});

