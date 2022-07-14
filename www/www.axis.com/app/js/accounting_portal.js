$(function(){
	$(".show_info_txt").on("click", function(e) {
		$(".dropdown-content-change-order").toggleClass("show_cont_change_order");
  	});
  	$(document).on("click", function(e) {
    	if ($(e.target).is(".show_info_txt") === false) {
    	  	$(".dropdown-content-change-order").removeClass("show_cont_change_order");
    	}
  	});
	$('#general_ledger').load('/app/controllers/ledger_controller.php?action=getGeneralLedgerForm');
	$('#connectW').on('click',function(){ // Connect Quickbooks
		var clientId = $.trim($('#clientID').val());
		var clientSecret = $.trim($('#clientSecret').val());
		if(clientId == '' ) {
			messageAlert('client ID can\'t be empty', 'errorMessage');
			return false;
		}
		if(clientSecret == '' ) {
			messageAlert('Client Secret can\'t be empty', 'errorMessage');
			return false;
		}

		var parameters = "location=1,width=800,height=650";
    	parameters += ",left=" + (screen.width - 800) / 2 + ",top=" + (screen.height - 650) / 2;

        var win = window.open(url, 'connectPopup', parameters);
        var pollOAuth = window.setInterval(function () {
            try {

                /*if (win.document.URL.indexOf("code") != -1) {*/
                	
                if (win.document.URL.indexOf("realmId") != -1) {
                	window.clearInterval(pollOAuth);
                    win.close();
                   	location.reload();
                }
            } catch (e) {
                console.log(e)
            }
        }, 100);
	});

	$('#clientID,#clientSecret,#webhooktoken').on('change',function(){
		var clientId = $.trim($('#clientID').val());
		var clientSecret = $.trim($('#clientSecret').val());
		var userCompanyId = $.trim($('#user_company_id').val());
		var webhooktoken = $.trim($('#webhooktoken').val());
		var contractingEntityId = $.trim($('#contracting_entity').val());
		if(clientId == '' ) {
			messageAlert('client ID can\'t be empty', 'errorMessage');
			return false;
		}
		if(clientSecret == '' ) {
			messageAlert('Client Secret can\'t be empty', 'errorMessage');
			return false;
		}
		if(userCompanyId == '' ){
			messageAlert('Company details are not available', 'errorMessage');
			return false;
		}

		$.get('/app/controllers/accounting_cntrl.php',{'action':'updateQuickbooksKey',
			'clientId':clientId, 'clientSecret': clientSecret, 
			'usercompanyId':  userCompanyId, 'webhooktoken': webhooktoken,
			'contracting_entity': contractingEntityId},
			function(data){
				messageAlert('Quickbooks Credentials updated.', 'successMessage');
				location.reload();
				console.log(data);
		});

	});
	$('#gotosteptwo').on('click',function(){
		$('#qb_connectsteps').addClass('displayNone');
		$('#qb_connectkeys').removeClass('displayNone');
		$('.importSteps').removeClass('active');
		$('#importStepTwo').addClass('active');
	});
	$('#gotostepone').on('click',function(){
		$('#qb_connectsteps').removeClass('displayNone');
		$('#qb_connectkeys').addClass('displayNone');
		$('.importSteps').removeClass('active');
		$('#importStepOne').addClass('active');
	});

	$('#accounting_portal').on('change',function(){
		var accountPortalId = $.trim($(this).val());
		var userCompanyId = $.trim($('#user_company_id').val());
		var contractEntityId = $.trim($('#contracting_entity').val());
		if(accountPortalId !== ''){
			$.get('/app/controllers/accounting_cntrl.php',{'action':'updateAccountingPortal',
			'accountPortal':accountPortalId,'usercompanyId':userCompanyId,
			'contractEntity':contractEntityId},
			function(data){
				messageAlert('Accounting Portal Selected.', 'successMessage');
				location.reload();
			});
		}
	});
	$('#getAccounts').on('click',function(){
		showSpinner();
		$.get('/app/controllers/ledger_controller.php',{'action':'GetAllAccounts'},function(data){
			$('#general_ledger').load('/app/controllers/ledger_controller.php?action=getGeneralLedgerForm');
			hideSpinner();
		});

	});
	$(document).on('change','.gl_account_update',function(){
		var template_id = this.id;
		var template_id_arr = template_id.split('-');
		var gl_account = this.value;
		showSpinner();
		if(template_id_arr['1'] && gl_account){
			$.get('/app/controllers/ledger_controller.php',{'action':'update_template','subcontract_type':template_id_arr['1'],'gl_account_id':gl_account},function(data){
				if($.trim(data)=='statusupdated'){
					messageAlert('Subcontract template mapped to GL account successfully.', 'successMessage');
				}else{
					messageAlert(data, 'errorMessage');
				}
				hideSpinner();
			});
		}else{
			hideSpinner();
		}
	});
});