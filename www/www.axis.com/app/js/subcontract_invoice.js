$(function(){
	$(".show_info_txt").on("click", function(e) {
    	$(".dropdown-content-change-order").toggleClass("show_cont_change_order");
  	});
  	$(document).on("click", function(e) {
    	if ($(e.target).is(".show_info_txt") === false) {
    	  	$(".dropdown-content-change-order").removeClass("show_cont_change_order");
    	}
  	});

	$(".boxViewUploader").find('.qq-upload-drop-area').hide();
	$('#company_id').on('change',function(){
		var vendor_id = this.value;
		var project_id = $('#invoice_project_id').val();
		var show_all_invoice = $("#show_all_invoice").is(':checked');
		var user_company_id = $("#invoice_company_id").val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var currentlySelectedProjectTypeIndex = $("#currentlySelectedProjectTypeIndex").val();
		var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();

		
		if(vendor_id){
			
			$.post('/app/controllers/subcontract_invoice_cntrl.php',
				{'vendor':vendor_id, 'action':'getContracts','project_id':project_id,
				'user_company_id':user_company_id,'currentlySelectedProjectTypeIndex':currentlySelectedProjectTypeIndex},function(data){
					$('#contract_id').html(data);
					if($('#contract_id').val() === '' || $('#contract_id  option').length == 0){
						
						$(".new_invoice").hide();

					}else{
						var vendor_name = $("#company_id option:selected").text();

						$("#invoice_vendor_id").val(vendor_id);
						$(".new_invoice").show();
						$("#vendor_name").html(vendor_name);

						// To get the suppliers
						// SuppliersList()
						
						// To get the data of the selected subcontractor
						$.post('/app/controllers/subcontract_invoice_cntrl.php',
							{'action':'getSubcontractInvoice','project_id':project_id, 
							'vendor':vendor_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
							$("#invoice_body").html(data);
							createUploaders();
						});

						$.post('/app/controllers/subcontract_invoice_cntrl.php',
							{'action':'getSubcontractInvoiceSecTwo','project_id':project_id, 
							'vendor':vendor_id,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
							$("#invoice_body_SecTwo").html(data);
							createUploaders();
						});
						$('#supplier_id').val('');		
						$('.fs-search').empty();
						$('.fs-no-results').empty();			
						$('.multi-drop').fSelect('reload');
						$('#supplierlist').empty();


					}
			});
		}else{
			$('#contract_id').html('');
			$(".new_invoice").hide();
			$.post('/app/controllers/subcontract_invoice_cntrl.php',{
				'action':'getSubcontractInvoice','project_id':project_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
				$("#invoice_body").html(data);
				createUploaders();
			});
			$.post('/app/controllers/subcontract_invoice_cntrl.php',{
				'action':'getSubcontractInvoiceSecTwo','project_id':project_id,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
				$("#invoice_body_SecTwo").html(data);
				createUploaders();
			});
		}
	});
	$( ".tcomp_date").datepicker({
    	changeMonth: true, 
    	changeYear: true, 
    	dateFormat: 'mm/dd/yy', 
    	numberOfMonths: 1
	});
	// to initiate the supplier popover
	$('[data-toggle="supplierPopover"]').popover({
		html: true,
		title: 'Add New Supplier',
		content: function() {
			
			var content = $("#CreateSupplierdiv").html();
			$("#CreateSupplierdiv").html('');
			$(this).on('hide.bs.popover', function() {
				$("#CreateSupplierdiv").html(content);
			});
			return content;
		}
	});

	$(document).on('click',".delete_invoice",function(){
		var invoice_id = this.id;
		$("#dialog-confirmation").html("Are you sure to delete this Subcontract Invoice?");
		 $("#dialog-confirmation").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation",
        width: "500",
        height: "200",
        buttons: {
          "No": function () {
            $(this).dialog('close');
            $("#dialog-confirmation").html("");
            return false;
          },
          "Yes": function () {
            $(this).dialog('close');
            $.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'delete_invoice','invoice_id':invoice_id},function(data){
            	console.log(data);
            	if($.trim(data) =='Y'){
            		if($('#existinvoice-'+invoice_id).val() != ''){
						var createinvoice_old = $('#existinvoice-'+invoice_id).val();
						var delelementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + createinvoice_old;

						$.get('/file_manager_files-ajax.php',{'method':'deleteFileManagerFile', 
							'recordContainerElementId':delelementId,
							'attributeGroupName':'manage-file_manager_file-record',
							'attributeSubgroupName':'file_manager_files',
							'sortOrderFlag':'N',
							'uniqueId':createinvoice_old,
							'formattedAttributeGroupName':encodeURIComponent('File Manager File'),
							'formattedAttributeSubgroupName':encodeURIComponent('File Manager Files')
						},function(data){
							/*$("#" + delelementId).remove();*/
						});
					}

            		var project_id  = $('#invoice_project_id').val();
					var vendor_id = $('#company_id').val();
					var show_all_invoice = $("#show_all_invoice").is(':checked');
					var user_company_id = $("#invoice_company_id").val();
					var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
					var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();

					messageAlert('SubContract invoice deleted successfully.', 'successMessage');
					$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoice','project_id':project_id, 'vendor':vendor_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id, 'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
						$("#invoice_body").html(data);
						createUploaders();
					});
					$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoiceSecTwo','project_id':project_id, 'vendor':vendor_id,'user_company_id':user_company_id, 'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
						$("#invoice_body_SecTwo").html(data);
						createUploaders();
					});
            	}else{
            		messageAlert('SubContract invoice deletion error.', 'errorMessage');

            	}
            	
            });
            
          },
        }
      });

	});
        //to get the remaining contract amount
	$("#app").on('click',function(){
		loadContractAmount();
	});
	$("#createinvoice").on('click',function(){
		$("#createinvoice").attr('disabled','true');
		var project_id = $('#invoice_project_id').val();
		var show_all_invoice = $("#show_all_invoice").is(':checked');
		var vendor_id = $('#company_id').val();
		var contract_id = $("#contract_id").val();
		var recieved_date = $('#recieved_date').val();
		var application_number = $('#app').val();
		var period_to = $('#period_to_date').val();
		var amount = parseFloat($('#amount').val());
		var retention = parseFloat($('#retention').val());
		var total = $('#total').val();
		var notes = $('#notes').val();
		var file_id = $("#upfileid").val();
		var status_id = $("#subcontract_invoice_status").val();
		var contract_text = $("#contract_id option:selected").text();
		var contract = contract_text.replace("-", "")
		var user_company_id = $("#invoice_company_id").val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();
		var project_mapped_customer = $("#qb_customer").val();
		var totalFloat = parseFloat(total);
		var totalSCAmount = amount - retention;
		var conremaining = parseFloat($('#conremaining-amt').val());
		var totalconremaining = parseFloat($('#total-conremaining-amt').val());

		/* Validation - Start */
		var validation_var = false;
		if(project_mapped_customer == ''){
			$('#qb_customer').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#qb_customer').removeClass('redBorderThick');
		}
		if(recieved_date == ''){
			$('#recieved_date').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#recieved_date').removeClass('redBorderThick');
		}
		if(application_number == ''){
			$('#app').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#app').removeClass('redBorderThick');
		}

		if(period_to == ''){
			$('#period_to_date').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#period_to_date').removeClass('redBorderThick');
		}
		if(amount == ''){
			$('#amount').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#amount').removeClass('redBorderThick');
		}
		// if(retention == ''){
		// 	$('#retention').addClass('redBorderThick');
		// 	validation_var = true;
		// }else{
		// 	$('#retention').removeClass('redBorderThick');
		// }
		if(total == ''){
			$('#total').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#total').removeClass('redBorderThick');
		}
		if(status_id == ''){
			$('#subcontract_invoice_status').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#subcontract_invoice_status').removeClass('redBorderThick');
		}

		if(totalconremaining < total){
			$('#total').addClass('redBorderThick');
			messageAlert('Invoice Total should not exceed the contract remaining', 'errorMessage');
			return false;
			validation_var = true;
		}else{
			$('#total').removeClass('redBorderThick');
		}

		var supids = $("#supplier_id").val();
		var supAmt ="";
		$(".sup-amt").each(function(){
			if(this.value)
    		{  supAmt += this.value+"|";}
    		
    		
    	});

		if(validation_var){
			$("#createinvoice").removeAttr('disabled');
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			return false;
		}else
		{
			$("#createinvoice").attr('disabled','true');
		}

		if (amount >= retention) {
			$('#retention').removeClass('redBorderThick');
		}else{
			$('#retention').addClass('redBorderThick');
			$("#createinvoice").removeAttr('disabled');
			messageAlert('Retention should be less than SC Amount.', 'errorMessage');
			return false;
		}

		if (totalFloat >= totalSCAmount) {
			$('#total').removeClass('redBorderThick');
		}else{
			$('#total').addClass('redBorderThick');
			$("#createinvoice").removeAttr('disabled');
			messageAlert('Invoice Total should be greater than (SC Amount + Retention)', 'errorMessage');
			return false;
		}

        	
		$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'checkinvoice_exist','vendor_id':vendor_id,'contract_id':contract_id,'period_to': period_to,'application_number':application_number},function(JsonData){
			if($.trim(JsonData.return_val) =='Y'){
				$.post('/app/controllers/subcontract_invoice_cntrl.php',
					{'action':'create_invoice','project_id':project_id,
					'vendor_id':vendor_id,'contract_id':contract_id,
					'cost_code_id': JsonData.cost_code_id,
					'recieved_date': recieved_date, 
					'application_number':application_number, 'period_to': period_to, 
					'amount': amount, 'retention': retention, 'total':total, 
					'notes':notes,'file_id':file_id,'status_id':status_id,'contract_remaining':conremaining,
					'contract_text':contract, 'project_mapped_customer':project_mapped_customer,'supplierids':supids,'supplierAmounts':supAmt},
				function(data){
					$("#createinvoice").removeAttr('disabled');

					if($.trim(data) =='Y'){
						$('#supplier_id').val('');		
						$('.fs-search').empty();
						$('.fs-no-results').empty();			
						$('.multi-drop').fSelect('reload');
						$('#supplierlist').empty();
						$('#conremaining-amt').val('');
						$('#total-conremaining-amt').val('');
						messageAlert('SubContract invoice created successfully.', 'successMessage');
						$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoice', 'project_id':project_id, 'vendor':vendor_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id, 'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
							$("#invoice_body").html(data);
							createUploaders();
						});
						$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoiceSecTwo', 'project_id':project_id, 'vendor':vendor_id,'user_company_id':user_company_id, 'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
							$("#invoice_body_SecTwo").html(data);
							createUploaders();
						});
						$('#recieved_date,#app,#period_to_date,#notes,#qb_customer').val('');
						$('#container--request_for_information_attachments--create-request_for_information-record').html('');
						$('#amount,#retention,#total').val('0.00');
						$('#subcontract_invoice_status').val(1);
		
					}else if($.trim(data) =='N'){
						messageAlert('SubContract invoice creation error.', 'errorMessage');
					}else {
						messageAlert(data, 'errorMessage');
					}
				});
			}else{
				messageAlert('Invoice already exist!.', 'errorMessage');
			}

		});
        /* Validation - End */
		
	});
	$("#amount,#retention").on('change',function(data){
		var amount = $("#amount").val();
		var retention = $("#retention").val();
		if(!amount){
			amount = 0.00;
		}else{
			amount = parseFloat(amount).toFixed(2);
		}
		$("#amount").val(amount);
		if(!retention){
			retention = 0.00;
		}else{
			retention = parseFloat(retention).toFixed(2);
		}
		$("#retention").val(retention);
		if(amount || retention){
			var total = parseFloat(amount) - parseFloat(retention);
			total = parseFloat(total).toFixed(2);
			$("#total").val(total);
		}
	});
	$("#qb_customer,#recieved_date,#app,#period_to_date,#amount,#retention,#subcontract_invoice_status").on('change',function(){
		if($(this).val() ==''){
			$(this).addClass('redBorderThick');
		}else{
			$(this).removeClass('redBorderThick');
		}
	});

	$(document).on('change',".subcontractinvoice_status",function(){
		var invoice = this.id;
		var invoice_arr = invoice.split('-');
		var invoice_id = invoice_arr['1'];
		var invoice_status = $(this).val();
        
		$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'updateInvoiceStatus', 'invoice_id':invoice_id, 'status':invoice_status},function(data){
			if($.trim(data) =='Y'){
				var project_id  = $('#invoice_project_id').val();
				var vendor_id = $('#company_id').val();
				var show_all_invoice = $("#show_all_invoice").is(':checked');
				var user_company_id = $("#invoice_company_id").val();
				var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
				var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();
				$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoice','project_id':project_id, 'vendor':vendor_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
					$("#invoice_body").html(data);
					createUploaders();
				});
				$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoiceSecTwo','project_id':project_id, 'vendor':vendor_id,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
					$("#invoice_body_SecTwo").html(data);
					createUploaders();
				});
				messageAlert('SubContract invoice status updated successfully.', 'successMessage');
			}else{
				var error_data = '';
				if($.trim(data) !='N'){
					error_data = data;
				}
				messageAlert('SubContract invoice status updation error.'+error_data, 'errorMessage');
			}

		});

        	
	});
	$(document).on('click','.sync_to_qb',function(){
		var invoice_id_temp = this.id;
		var invoice_id_arr = invoice_id_temp.split('-');
		var invoice_id = invoice_id_arr['1'];

		var arrPrelims = [];
		$(".sup_rel_"+invoice_id+":checked").each(function() {
			var prelim_id = $(this).val();
			if (prelim_id != 0) {
				arrPrelims.push(prelim_id);
			}			
		});
		var csvPrelims = arrPrelims.join(',');
		
		var supAmtvalStatus = true;
		var supplierAmtList = $('.sup_val_'+invoice_id);
		for(var i = 0; i < supplierAmtList.length; i++){
		    var supAmtval = $(supplierAmtList[i]).val();
		    if (supAmtval == '' || supAmtval == '0.00') {
				var supAmtvalStatus = false;
			}
		}

		var allchecked =  checkAllChecked(invoice_id);

		var balance_amt = $('#balance_'+invoice_id).val();
		if (typeof balance_amt === 'undefined' || balance_amt === null) {
			var balance = false;
		}else{
			var balance = true;
			balance_amt = parseFloat(balance_amt.replace(',',''));
		}
		
		if (balance && balance_amt != 0) {
			messageAlert('Balance should be zero', 'errorMessage');
		}else if(allchecked == false){
			messageAlert('Supplier is not released.', 'errorMessage');
		// }else if(supAmtvalStatus == false){
		// 	messageAlert('Supplier Amount cant be zero.', 'errorMessage');
		}else{	
			$.get('/app/controllers/accounting_cntrl.php',
	        {'action': 'checkAccountingPortal'}, function(data){
				if($.trim(data) === 'Y' ){
		        	$("#dialog-confirm").html("Are you sure to sync subcontract invoice with Quickbooks?");
		    		 // Define the Dialog and its properties.
		            $("#dialog-confirm").dialog({
		              	resizable: false,
		             	modal: true,
		              	title: "Confirmation",
		              	width: "500px",
		              	open: function() {
		                	$("#dialog-confirm").parent().addClass("jqueryPopupHead");
		                	$("body").addClass('noscroll');
		              	},
		              	close: function() {
		                	$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
		                	$("body").removeClass('noscroll');
		              	},
		              	buttons: {
			                "No": function () {
								$(this).dialog('close');
								$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
								$("body").removeClass('noscroll');
							},
			                "Yes": function () {
			                  	$(this).dialog('close');
			                  	$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
			                  	$("body").removeClass('noscroll');
			                  	$.post('/app/controllers/subcontract_invoice_cntrl.php',
			                  		{'action':'synctoqb', 'invoice_id':invoice_id, 'prelim_arr':csvPrelims},function(JsonData){
			                  		if($.trim(JsonData.qb_error_id) != ''){
			                  			messageAlert('Error Code :'+JsonData.qb_error_id+'<br/> Please share error code with developer for resolution.', 'errorMessage');
			                  		}else if($.trim(JsonData.return_val) =='Y'){
										var project_id  = $('#invoice_project_id').val();
										var vendor_id = $('#company_id').val();
										var show_all_invoice = $("#show_all_invoice").is(':checked');
										var user_company_id = $("#invoice_company_id").val();
										var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
										var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();
										$.post('/app/controllers/subcontract_invoice_cntrl.php', {'action':'getSubcontractInvoice','project_id':project_id, 'vendor':vendor_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
											$("#invoice_body").html(data);
											createUploaders();
										});
										$.post('/app/controllers/subcontract_invoice_cntrl.php', {'action':'getSubcontractInvoiceSecTwo','project_id':project_id, 'vendor':vendor_id,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
											$("#invoice_body_SecTwo").html(data);
											createUploaders();
										});
										messageAlert('SubContract invoice status updated successfully.', 'successMessage');
									}else{
										var error_data = '';
										if($.trim(JsonData.return_val) != 'N'){
											error_data = JsonData.return_val;
										}
										messageAlert('SubContract invoice status updation error.'+error_data, 'errorMessage');
									}
								});
			                }
		          		}
			        });
		        }else{
					messageAlert('No accounting portal is configured.', 'errorMessage');

		        }
	        });
		}
	});
	$(document).on('click','.preview_invoice',function(){

		var modal = document.getElementById('divModalWindow');
		var modalWindowTitle = 'Invoice';
		var tblHeight = $(window).height() - $("#filePreview").offset().top;
		var isImage = 0;
		var file = $(this).data('fileid');
		$("body").addClass('noscroll');
		$("#model-title").html(modalWindowTitle);
				$('#filePreview').css("height", "600px");

		$("#filePreview").load('/modules-file-manager-file-browser-ajax.php?method=loadPreview&file=' + encodeURIComponent(file) + '&height=' + tblHeight + '&isImage=' + isImage);
		modal.style.display = "block";
	});

	
	$('#show_all_invoice').change(function() {
		var project_id  = $('#invoice_project_id').val();
		var vendor_id = $('#company_id').val();
		var show_all_invoice = $("#show_all_invoice").is(':checked');
		var user_company_id = $("#invoice_company_id").val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();
		$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoice','project_id':project_id, 'vendor':vendor_id,'show_all_invoice':show_all_invoice,
			'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
			$("#invoice_body").html(data);
			createUploaders();
		});
		$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoiceSecTwo','project_id':project_id, 'vendor':vendor_id,
			'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
			$("#invoice_body_SecTwo").html(data);
			createUploaders();
		});
	});
	$(document).on('click','.change_file',function(){
		var change_file_id = this.id;
		var change_file_id_arr = change_file_id.split('-');
		var file_id = change_file_id_arr['1'];
		
		$('#preview_invoice-'+file_id).hide();
		$('#change_file-'+file_id).hide();
		$('#uploader--request_for_information_attachments--create-request_for_information-record-'+file_id).show();
	});

	$(document).on('change keyup paste','.edit_notes',function(){
		var notes = this.value;
		var notes_id = this.id;
		var notes_id_arr = notes_id.split('-');
		notes_id = notes_id_arr[1];

		$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'update_invoice_notes','invoice_id':notes_id,'notes':notes},function(data){
			if($.trim(data) =='Y'){
				messageAlert('SubContract invoice notes updated successfully.', 'successMessage');
			}else{
				messageAlert('SubContract invoice notes updation error.', 'errorMessage');

			}

		});


	});

	$(document).on('click','.view_summary',function(){
		var modal = document.getElementById('divModalWindow');
		var modalWindowTitle = 'Subcontract Summary — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val();
		var project_id = $(this).data('projectid');
		var vendor_id = $(this).data('vendorid');
		$("body").addClass('noscroll');
		$("#model-title").html(modalWindowTitle);
		$('#filePreview').css("height", "400px");
		$('#filePreview').load('/app/controllers/subcontract_invoice_cntrl.php?action=contractsummary&vendor_id='+vendor_id+'&project_id='+project_id);
		modal.style.display = "block";

	});

	$(document).on('change','.qb_customer_edit',function(){
		var cust_id = this.id;
		var cust_arr = cust_id.split('-');
		var subcont_invoiceid = cust_arr['1'];
		var qb_customer = this.value;

		$.get('/app/controllers/subcontract_invoice_cntrl.php',
			{'action':'updateQBCustomerInvoice', 'qb_customer': qb_customer,
			'invoice_id':subcont_invoiceid},function(data){
			if($.trim(data) =='1'){
				messageAlert('SubContract invoice customer updated successfully.', 'successMessage');
			}else{
				messageAlert('SubContract invoice customer updation error.', 'errorMessage');

			}
		});
	});
	
});

	function checkTotal(){
		var amount = $('#amount').val();
		var retention = $('#retention').val();
		var total = $('#total').val();
		var totalFloat = parseFloat(total);
		var totalSCAmount = parseFloat(amount) - parseFloat(retention);
		if (totalFloat >= totalSCAmount) {
			$('#total').removeClass('redBorderThick');
		}else{
			$('#total').addClass('redBorderThick');
			messageAlert('Invoice Total should be greater than (SC Amount + Retention)', 'errorMessage');
		}
		checkContractRemaining();
	}

	// contract remaining
	function checkContractRemaining()
	{
		var total = $('#total').val();
		var totcontract_remaining =$("#total-conremaining-amt").val();

		var remaining = parseFloat(totcontract_remaining) - parseFloat(total);
		var contract_remaining =$("#conremaining-amt").val(remaining);
	}

	function supplierPopoverNew(subcontractorId,invoice_id){
		var content = '';
		$('#btnAddSupplierPopover_'+subcontractorId+'_'+invoice_id).popover({
			html: true,
			title: 'Add New Supplier',
			content: function() {
				var content = '<div>Supplier : <input type="text" id="supplier_name_'+subcontractorId+'" value="" style="width: 96%; float: initial;"></div><div class="textAlignRight" style="margin-top:5px"><input type="submit" value="Create Supplier" onclick="addSupplierNew('+subcontractorId+','+invoice_id+');" style="width: 400px; padding: 4px;"></div>';				
				return content;
			}
		}).click(function (e) {
			$('[data-original-title]').popover('hide');
			$(this).popover('show');
		});
	}

	function updateInvoiceTotal(invoice_id){

		var min_invoice_tot = $('#minInvoiceTot_'+invoice_id).val();
			min_invoice_tot = parseFloat(min_invoice_tot.replace(',',''));
		var max_invoice_tot = $('#maxInvoiceTot_'+invoice_id).val();
			max_invoice_tot = parseFloat(max_invoice_tot.replace(',',''));
		var invoice_total = $('#oldInvoiceTot_'+invoice_id).val();
			invoice_total = parseFloat(invoice_total.replace(',',''));
		var pass_invoice_total = invoice_total.toFixed(2);
		var value = $('#invoiceTotal_'+invoice_id).val();
			value = parseFloat(value.replace(',',''));
		var passValue = value.toFixed(2);

		if (min_invoice_tot > value) {
			$('#invoiceTotal_'+invoice_id).val(pass_invoice_total);
			messageAlert('Invoice Total should be greater than (SC Amount + Retention)', 'errorMessage');
		}else if (value < max_invoice_tot) {
			$('#invoiceTotal_'+invoice_id).val(pass_invoice_total);
			messageAlert('Invoice Total Missmatch', 'errorMessage');
		}else{
			$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'update_invoice_total','invoice_id':invoice_id,'value':passValue},function(data){
				if(data){
					$('#oldInvoiceTot_'+invoice_id).val(passValue);
					$('#invoiceTotal_'+invoice_id).val(passValue);
					$('#balance_'+invoice_id).val(data);
					messageAlert('SubContract invoice total updated successfully.', 'successMessage');
				}else{
					messageAlert('SubContract invoice toal updation error.', 'errorMessage');

				}
			});
		}
	}

	// To get the suppliers
	function SuppliersList()
	{
		var project_id = $('#invoice_project_id').val();
		var user_company_id = $("#invoice_company_id").val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var currentlySelectedProjectTypeIndex = $("#currentlySelectedProjectTypeIndex").val();
		var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();
		var subcontract_id = $("#contract_id").val();
		$.post('/app/controllers/subcontract_invoice_cntrl.php',
			{'action':'getSuppliers','project_id':project_id, 
			'subcontract_id':subcontract_id,'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(sdata){
				
			$("#supitem").empty().append(sdata);
			$('.multi-drop').fSelect();
			$('#supplierlist').empty();
			
		});
	}

	function supplierlineitemAppend(subcontractId,subcontractInvoiceId){
		var supid = $('#supp_list_'+subcontractInvoiceId).val();
	    var project_id = $('#invoice_project_id').val();
		var user_company_id = $("#invoice_company_id").val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var currentlySelectedProjectTypeIndex = $("#currentlySelectedProjectTypeIndex").val();
		if(supid != null)
		{
			$.post('/app/controllers/subcontract_invoice_cntrl.php',
				{
					'action':'SuppliersLineItemAppend',
					'project_id':project_id, 
					'supplierid':encodeURIComponent(supid),
					'user_company_id':user_company_id,
					'currentlyActiveContactId':currentlyActiveContactId,
					'subcontractInvoiceId':subcontractInvoiceId
				},
				function(sdata){
					var dataarr = sdata.split('~');				
					$("#supplier_name_"+subcontractInvoiceId).empty().append(dataarr[0]);
					$("#supplier_value_"+subcontractInvoiceId).empty().append(dataarr[1]);
				}
			);
		}
	}

	function checkAllChecked(invoice_id) {

		var totalChecked = $('.sup_rel_'+invoice_id+':checked');
		var totalChecked = totalChecked.length;
		var totalCnt = $("#tot_arr_"+invoice_id).val();
		var totalCnt = parseInt(totalCnt) + 1;

		if (totalChecked == totalCnt) {
			$("#subcontract_invoice_status-"+invoice_id+" option[value='11']").attr('disabled',false);
			$("#subcontract_invoice_status-"+invoice_id+" option[value='12']").attr('disabled',false);
			return true;
		}else{
			$("#subcontract_invoice_status-"+invoice_id+" option[value='11']").attr('disabled',true);
			$("#subcontract_invoice_status-"+invoice_id+" option[value='12']").attr('disabled',true);
			return false;
		}
		console.log()
	}

	function supCheckToSCLog(invoice_id,prelim_id){
		if ($("#sup_rel_"+invoice_id+"_"+prelim_id).prop('checked') == true) {
			var value = 1;
		}else{
			var value = 0;
		}
		$.post('/app/controllers/subcontract_invoice_cntrl.php',
		{
			'action':'supCheckToSCLog',
			'invoice_id':invoice_id, 
			'prelim_id':prelim_id,
			'is_release':value
		},
		function(sdata){
			if (sdata) {
				checkAllChecked(invoice_id);
				if (value == 1) {
					$("#sup_name_"+invoice_id+"_"+prelim_id).removeClass("rowRed");
				}else{
					$("#sup_name_"+invoice_id+"_"+prelim_id).addClass("rowRed");
				}
				messageAlert('Supplier updated successfully.', 'successMessage');
			}
		});

	}

	function invCheckToInvLog(invoice_id){
		if ($("#inv_chk_"+invoice_id).prop('checked') == true) {
			var value = 1;
		}else{
			var value = 0;
		}
		$.post('/app/controllers/subcontract_invoice_cntrl.php',
		{
			'action':'invCheckToInvLog',
			'invoice_id':invoice_id, 
			'is_release':value
		},
		function(sdata){
			if (sdata) {
				checkAllChecked(invoice_id);
				messageAlert('Invoice updated successfully.', 'successMessage');
			}
		});
	}

	function insertToSCLog(invoice_id,prelim_id,value){

		var balanceVal = $('#balance_'+invoice_id).val();
			balanceVal = parseFloat(balanceVal.replace(',',''));

		if (value == '' || value == null) {
			value = '0.00';
		}
		var valuePass = parseFloat(value).toFixed(2);
		var value = parseFloat(value);	

		var old_sup_value = $('#old_sup_'+invoice_id+'_'+prelim_id).val();
		if (old_sup_value == '' || old_sup_value == null) {
			old_sup_value = '0.00';
		}
		var oldSupValApp = parseFloat(old_sup_value.replace(',',''));

		var balance = balanceVal + oldSupValApp;
		
		if (value > balance) {
			$('#sup_'+invoice_id+'_'+prelim_id).val(old_sup_value);
			messageAlert('Balance is insufficient for the supplier.', 'errorMessage');	
		}else{
			$.post('/app/controllers/subcontract_invoice_cntrl.php',
			{
				'action':'insertValueToSupplierSCLog',
				'invoice_id':invoice_id, 
				'prelim_id':prelim_id,
				'value':valuePass
			},
			function(sdata){
				if (sdata) {
					var dataarr = sdata.split('~');
					$('#balance_'+invoice_id).val(dataarr[0]);
					$('#maxInvoiceTot_'+invoice_id).val(dataarr[1]);
					$('#sup_'+invoice_id+'_'+prelim_id).val(valuePass);
					$('#old_sup_'+invoice_id+'_'+prelim_id).val(valuePass);
				}
				messageAlert('Supplier Added successfully.', 'successMessage');
			});
		}
	}

	// To list the supplier line item
	function supplierlineitem()
	{
		var project_id = $('#invoice_project_id').val();
		var user_company_id = $("#invoice_company_id").val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var currentlySelectedProjectTypeIndex = $("#currentlySelectedProjectTypeIndex").val();
		var supid =$('#supplier_id').val();
		if(supid != null)
		{
			$.post('/app/controllers/subcontract_invoice_cntrl.php',
			{'action':'SuppliersLineItem','project_id':project_id, 
			'supplierid':encodeURIComponent(supid),'user_company_id':user_company_id,'currentlyActiveContactId':currentlyActiveContactId},function(sdata){
				
			$("#supplierlist").empty().append(sdata);
			
		});
		}
		
	}
	// Add new prelim
	function addNewSupplier()
	{
		var project_id = $('#invoice_project_id').val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var supplier_name = $("#supplier_name").val();
		var subcontract_id = $("#contract_id").val();
		if(supplier_name == ''){
			$('#supplier_name').addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#supplier_name').removeClass('redBorderThick');
		}
		$.post('/app/controllers/subcontract_invoice_cntrl.php',
			{'action':'AddPrelim','supplier_name':supplier_name,'subcontract_id':subcontract_id,'project_id':project_id,'currentlyActiveContactId':currentlyActiveContactId},function(sdata){
				if(sdata !='1')
				{
					var dataarr = sdata.split('~');
					$('#supplier_id').append(dataarr[0]);
					// $('#supitem .fs-options').append(dataarr[1]);
	       		    // $("#supplier_id").val(dataarr[2]).trigger('change');
	       		    	//To close the popover
					$(".btnAddSupplierPopover").next( "div" ).css('display',"none");
					$('.fs-search').empty();
					$('.fs-no-results').empty();
					$('.multi-drop').fSelect('reload');
					messageAlert('Supplier Added successfully.', 'successMessage');	
					// setTimeout(function(){ 
					// 	$('#supplierlist').append(dataarr[4]); 
					// }, 500);
				}else
				{
					messageAlert('Error in Adding Supplier.', 'errorMessage');	
				}		
		});
	}

	// Add new prelim
	function addSupplierNew(subcontract_id,invoice_id)
	{
		var project_id = $('#invoice_project_id').val();
		var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
		var supplier_name = $("#supplier_name_"+subcontract_id).val();
		var array_count = $("#tot_arr_"+invoice_id).val();
		var next_count = parseInt(array_count) + 1;
		var validation_var = false;
		if(supplier_name == ''){
			$('#supplier_name_'+subcontract_id).addClass('redBorderThick');
			validation_var = true;
		}else{
			$('#supplier_name_'+subcontract_id).removeClass('redBorderThick');
		}
		if(validation_var){
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			return false;
		}
		$(".supplierPopoverNew").next( "div" ).css('display',"none");
		$.post('/app/controllers/subcontract_invoice_cntrl.php',
			{'action':'AddPrelimNew','invoice_id':invoice_id,'array_count':next_count,'supplier_name':supplier_name,'subcontract_id':subcontract_id,'project_id':project_id,'currentlyActiveContactId':currentlyActiveContactId},function(sdata){
				if(sdata !='1')
				{
					var dataarr = sdata.split('~');
					$('#chk_last_row_'+invoice_id).before(dataarr[0]);
					$('#sup_last_row_'+invoice_id).before(dataarr[1]);
					$('#val_last_row_'+invoice_id).before(dataarr[2]);
					$("#tot_arr_"+invoice_id).val(next_count);
					checkAllChecked(invoice_id);
					messageAlert('Supplier Added successfully.', 'successMessage');	
				}else
				{
					messageAlert('Error in Adding Supplier.', 'errorMessage');	
				}		
		});
	}
	function delLineItem(delItem)
	{
		$("#pline_"+delItem).remove();
	}

	// When the user clicks on <span> (x), close the modal
	function dashboardmodalClose() {
		var modal = document.getElementById('divModalWindow');
		modal.style.display = "none";
		$("body").removeClass('noscroll');
		$('#filePreview').html('');
	}
	// When the user clicks anywhere outside of the modal, close it
	var modal = document.getElementById('divModalWindow');
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			$('#filePreview').html('');
		}
	}
// Method for Uploading File through drag option
function fileUploader_DragEnter()
{
	$(".boxViewUploader").find('.qq-upload-drop-area').show();
}
// Method for Uploading File through drag option
function fileUploader_DragLeave()
{
	$(".boxViewUploader").find('.qq-upload-drop-area').hide();
}

createUploaders();

function Sub__rfiDraftAttachmentUploaded(arrFileManagerFiles, containerElementId)
{
	try {

		var createinvoice_old = $("#invoice_create").val();

		
		if(createinvoice_old != '')
		{
			var delelementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + createinvoice_old;

			$.get('/file_manager_files-ajax.php',{'method':'deleteFileManagerFile', 
				'recordContainerElementId':delelementId,
				'attributeGroupName':'manage-file_manager_file-record',
				'attributeSubgroupName':'file_manager_files',
				'sortOrderFlag':'N',
				'uniqueId':createinvoice_old,
				'formattedAttributeGroupName':encodeURIComponent('File Manager File'),
				'formattedAttributeSubgroupName':encodeURIComponent('File Manager Files')
			},function(data){
				$("#" + delelementId).remove();
			});
		}

		//var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		var fileManagerFile = arrFileManagerFiles[0];
		var file_manager_file_id   = fileManagerFile.file_manager_file_id;
		var virtual_file_name      = fileManagerFile.virtual_file_name;
		var fileUrl                = fileManagerFile.fileUrl;
		var elementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + file_manager_file_id;
		
		var htmlRecord = 	'<li id="' + elementId + '">' +
								'<input type="hidden" id="upfileid" value="'+ file_manager_file_id +'" >'+
								'<a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
								'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
							'</li>';
	
		// Append the file manager file element.
		$("#" + containerElementId).append(htmlRecord);
		$(".bs-tooltip").tooltip();

		$("#invoice_create").val(file_manager_file_id);
		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: '+errorMessage);
			return;
		}

	}
}
function Sub__invoiceAttachemntUpload(arrFileManagerFiles,invoice_id){
	var fileManagerFile = arrFileManagerFiles[0];
	var file_manager_file_id   = fileManagerFile.file_manager_file_id;
	
	if(file_manager_file_id){
		
		$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'update_invoice_id','invoice_id':invoice_id,'file_id':file_manager_file_id},function(data){
			if($.trim(data) =='Y'){
				var project_id  = $('#invoice_project_id').val();
				var vendor_id = $('#company_id').val();
				var show_all_invoice = $("#show_all_invoice").is(':checked');
				var user_company_id = $("#invoice_company_id").val();
				var currentlyActiveContactId = $("#invoice_currently_active_contact_id").val();
				var userCanManageSubcontractInvoice = $("#userCanManageSubcontractInvoice").val();

				messageAlert('SubContract invoice uploaded successfully.', 'successMessage');
				$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoice','project_id':project_id, 'vendor':vendor_id,'show_all_invoice':show_all_invoice,'user_company_id':user_company_id, 'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
					$("#invoice_body").html(data);
					createUploaders();
				});
				$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'getSubcontractInvoiceSecTwo','project_id':project_id, 'vendor':vendor_id,'user_company_id':user_company_id, 'currentlyActiveContactId':currentlyActiveContactId,'userCanManageSubcontractInvoice':userCanManageSubcontractInvoice},function(data){
					$("#invoice_body_SecTwo").html(data);
					createUploaders();
				});
			}else{
				messageAlert('SubContract invoice upload error.', 'errorMessage');
			}

		});
	}else{
		messageAlert('SubContract invoice upload error.', 'errorMessage');
	}


}
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}
function getProjectMappedCust(){
	$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
		{'action':'getAllProjectCustomer'},function(data){
			location.reload();
	});
}

function loadContractAmount()
{
	var contract_id =$("#contract_id").val();
	$.post('/app/controllers/subcontract_invoice_cntrl.php',{'action':'contractAmount','contract_id':contract_id},function(data){
						$("#conremaining-amt").val(data);
						$("#total-conremaining-amt").val(data);
	});
}
