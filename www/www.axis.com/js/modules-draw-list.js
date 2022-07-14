var tabIndexValue;
$(document).ready(function() {
  initDrawDataTable();
  initDecimalValue();
  initCurrentAppValue();
  drawAddKeyEventListeners();
  datepicker();
  highlightDrawsTab();
  initReallocationValue();

  // For retention Draws
   initCurrentRetainerValue();
});
  $(document).keydown(
    function(e) {    
      if (e.keyCode == 9) {      
        tabIndexValue = e.target.tabIndex+1;
      }
    }
  );    
  $(".bs-tooltip").tooltip();
  function datepicker(){
    $(".through_datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'mm/dd/yy',
      numberOfMonths: 1
    });
    $('.dateDivSecCalIcon').click(function(){
      var drawId = $('#manage_draw--draw_id').val();
      $('#draw_items--through_date--'+drawId).focus();
    });
    $('.invoicedateDivSecCalIcon').click(function(){
      var drawId = $('#manage_draw--draw_id').val();
      $('#draw_items--invoice_date--'+drawId).focus();
    });
  }
  //to make draws tab active
  function highlightDrawsTab(){
    $('#navBoxModuleGroup .categoryitems2').css('display','none');
    $('#navBoxModuleGroup .arrowlistmenu .menuheader').removeClass('openheader2');
    var pathname = "/modules-draw-list.php";
    var selectHeaderIndex = $("a[href='"+pathname+"']").closest('ul').prev('div');
    var menuTobeHighlight = selectHeaderIndex.next('ul').find("a[href='"+pathname+"']");
    var menuliId = menuTobeHighlight.closest('li').attr('id');
    if(!menuliId){
      pathname = "/modules-create-retention.php";
      selectHeaderIndex = $("a[href='"+pathname+"']").closest('ul').prev('div');
      menuTobeHighlight = selectHeaderIndex.next('ul').find("a[href='"+pathname+"']");
      menuliId = menuTobeHighlight.closest('li').attr('id');
    }

    var menuId = menuliId.split('_')[2];
    var appendImg ="<img id='iselected_'"+menuId+" alt='' src='/images/navigation/left-nav-arrow-green.gif'>";
    menuTobeHighlight.addClass('selectedFunction');
    menuTobeHighlight.append(appendImg);
    selectHeaderIndex.addClass('openheader2');
    $('#navBoxModuleGroup .arrowlistmenu .openheader2').next('ul').css('display','block');
  };
  //allow numbers only in completed percentage,retainer rate
  function initDecimalValue(){
    $('.draw_input_value').on('input',function() {
      var	match = (/(\d{0,})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
      this.value = match[1] + match[2];
      // To restrict - in input field
      this.value = this.value.replace(/-/g, '');

    });
  };
    //allow numbers only in reallocation with - minus
  function initReallocationValue(){
    $('.reloact_input_value').on('input',function() {
      var amount = this.value;

    var formattedAmount = parseInputToCurrency(amount);
    var formattedAmount = formatDollar(amount);
    if(formattedAmount=="$0.00")
    {
      $(element).val('');
    }else{
      $(element).val(formattedAmount);
    }
   });
  };

  //allow negative numbers in current app
  function initCurrentAppValue(){
    $('.current_app_input_value').on('focusout',function() {
      this.value = this.value.replace(/,/g, '');
      this.value = this.value.replace(/\$/g, '');
    }).on('blur',function() {
      if(this.value){
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          minimumFractionDigits: 2,
        });
        var newValue = this.value.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
        newValue = formatter.format(newValue);
        $('#'+this.id).val(newValue);
      }
    });

    $('.current_app_input_value').on('input',function() {
      var match = (/(^[-]?\d{0,})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^-?\d.]/g, ''));
      this.value = match[1] + match[2];
       // To restrict - in input field
      // this.value = this.value.replace(/-/g, '');
    });

  };
  //init draw list data table
  function initDrawDataTable(){
    $("#drawListTabularData").DataTable({
      'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
      'order': [[ 0, 'desc' ]],
      'pageLength': 50,
      'pagingType': 'full_numbers',
      'ordering': false
    });
  };

  // initialize current retainer value for Retetion Draws
   function initCurrentRetainerValue()
   {
    $('.current_retainer_value_input_value').on('focusout',function() {
      this.value = this.value.replace(/,/g, '');
      this.value = this.value.replace(/\$/g, '');
    }).on('blur',function() {
      if(this.value){
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          minimumFractionDigits: 2,
        });
        var newValue = this.value.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
        newValue = formatter.format(newValue);
        $('#'+this.id).val(newValue);
      }
    });

    $('.current_retainer_value_input_value').on('input',function() {
      var match = (/(^[-]?\d{0,})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^-?\d.]/g, ''));
      this.value = match[1] + match[2];
    });
  };

  //filter draws by status
  function filterDraw(element, options){
    try {
      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;
      var selectedStatusId = element.value;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=filterDraw';
      var ajaxQueryString =
      'statusId=' + encodeURIComponent(selectedStatusId) +
      '&responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ arrFilterDrawSuccessCallbacks ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  //filter draw success callback
  function arrFilterDrawSuccessCallbacks(data){
    $('#drawListTable').empty().append(data);
    initDrawDataTable();
  };

  function checkProjectRetainerRate(){
    try {
      $('#divAjaxLoading').show();
      var options = options || {};
      var promiseChain = options.promiseChain;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=getProjectRetainerValue';

      var ajaxQueryString =
      'responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }

      var arrSuccessCallbacks = [ projectRetainerRateSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }
    }catch(error) {
      $('#divAjaxLoading').hide();
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };
  function projectRetainerRateSuccess(data, textStatus, jqXHR){
    try {
      if(data == 1){
        $('#divAjaxLoading').hide();
        $("#retainer-rate-confirm").html("Project retainage rate is not assigned, Please assign and continue");
        // Define the Dialog and its properties.
        $("#retainer-rate-confirm").dialog({
          resizable: false,
          modal: true,
          title: "Confirmation",
          width: "500",
          height: "160",
          buttons: {

            "No": function () {
              $(this).dialog('close');
            },
            "Assign": function () {
              $(this).dialog('close');
              window.location.href="/admin-projects.php";
            },
          }
        });
      }else{
        createDraw();
      }
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }

    }
  };
  /**
  * create a draw
  */
  function createDraw(){
    try {
      var options = options || {};
      var promiseChain = options.promiseChain;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=createDraw';

      var ajaxQueryString =
      'responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }

      var arrSuccessCallbacks = [ createDrawSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }
    }catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  function createDrawSuccess(data, textStatus, jqXHR){
    try {
      $('#divAjaxLoading').hide();
      var dataSplit = data.split('~');
      if(dataSplit.length > 1) {
        var countdraw = dataSplit[0];
        var countret = dataSplit[1];
        $('#drawDraftCount').val(countdraw);
        var drawDraftCount = $('#drawDraftCount').val();
        if((Number(countdraw) > 0) || (Number(countret) > 0)){
          var messageText = 'To create a new Draw either delete (or) post the existing draw in draft';
          messageAlert(messageText, 'errorMessage');
          return;
        }
      }

      var applicationId = data;
      window.location.href="/modules-create-draw.php?drawId="+applicationId;
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };
  //save through date
  function updateDrawDate(element, options){
    try {
      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;
      var throughDate = element.value;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=updateDrawThroughDate';
      var elementId = element.id;
      var elementIdSplit = elementId.split('--');
      var drawId = elementIdSplit[2];
      var ajaxQueryString =
      'throughDate=' + encodeURIComponent(throughDate) +
      '&drawId=' + encodeURIComponent(drawId) +
      '&responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ updateDrawDateSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  //filter draw success callback
  function updateDrawDateSuccess(data, textStatus, jqXHR){
    try {
      messageAlert('Through Date successfully updated.', 'successMessage');
      initDecimalValue();
      initReallocationValue();
      initCurrentAppValue();
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };
  //save invoice date
  function updateInvoiceDate(element, options){
    try {
      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;
      var invoiceDate = element.value;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=updateDrawInvoiceDate';
      var elementId = element.id;
      var elementIdSplit = elementId.split('--');
      var drawId = elementIdSplit[2];
      var ajaxQueryString =
      'invoiceDate=' + encodeURIComponent(invoiceDate) +
      '&drawId=' + encodeURIComponent(drawId) +
      '&responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ updateDrawInvoiceDateSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  function updateDrawInvoiceDateSuccess(data, textStatus, jqXHR){
    try {
      messageAlert('Invoice Date successfully updated.', 'successMessage');
      initDecimalValue();
      initReallocationValue();
      initCurrentAppValue();
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };
  //update draw
  function updateDrawItem(element, drawItemId, lineItemId, drawId, fieldName){
    try {
      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;

      var elementId = element.id;
      var elementIdSplit = element.id.split('--');
      var elementName = elementIdSplit[0];//draw_items
      var attributeType = elementIdSplit[1];//budget or COR
      var attributeSubGroup = elementIdSplit[2];//column
      var budgetLineItemId = elementIdSplit[3];//gc_budget_line_item_id or change_order_id
      var attributeValue = element.value;//given input
      
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=updateDrawItem';
      var ajaxQueryString =
      'attributeType=' + encodeURIComponent(attributeType) +
      '&attributeSubGroup=' + encodeURIComponent(attributeSubGroup) +
      '&attributeValue=' + encodeURIComponent(attributeValue) +
      '&drawItemId=' + encodeURIComponent(drawItemId)+
      '&lineItemId=' + encodeURIComponent(lineItemId)+
      '&drawId=' + encodeURIComponent(drawId) +
      '&responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ updateDrawItemSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: function(data){
          updateDrawItemSuccess(data,fieldName,elementId,drawItemId)
        },
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  function updateDrawItemSuccess(data, fieldName,elementId,drawItemId){
    try {
      messageAlert(fieldName+' Successfully updated.', 'successMessage');
      $('#createDrawForm').empty().append(data);
      initDecimalValue();
      initReallocationValue();
      initCurrentAppValue();
      $('#export_option').fSelect({
                numDisplayed: 1,
                overflowText: '{n} selected'
                });      
      
      var tabIndexValue = parseInt($("#"+elementId).attr('tabindex'))+1;

      if ($('.realocate').css("display") == 'none' && fieldName == 'Narrative') {
         tabIndexValue = tabIndexValue + 2;
      }    
      
      $('[tabindex=' + tabIndexValue + ']').select();
      drawAddKeyEventListeners();
      datepicker();
       // if(fieldName == 'Reallocation'){
       //  $('#draw_items--gc_budget_line_item_id--current_app--'+drawItemId).trigger("change");
       // }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }

    }
  };

  //redirect to edit
  function editDraw(applicationNumber){
    if(applicationNumber){
      window.location.href="/modules-create-draw.php?drawId="+applicationNumber;
    }
  };
  
   //Enable the reallocation field
  function enableReallocation(applicationNumber){
    $('.realocate').css('display','table-cell');
    $("#reallocation-li").attr("onclick","disableReallocation("+applicationNumber+")");
    $("#reallocation-li").val("Hide Reallocations");
  };
     //Enable the reallocation field
  function disableReallocation(applicationNumber){
    $('.realocate').css('display','none');
    $("#reallocation-li").attr("onclick","enableReallocation("+applicationNumber+")");
    $("#reallocation-li").val("Add Reallocations");
  };
  //redirect to Retention edit
  function editRetention(applicationNumber){
    if(applicationNumber){
      window.location.href="/modules-create-retention.php?retentionId="+applicationNumber;
    }
  };
  function validateMaximumPercentage(element, previousCompleted, column){
    $("#completion-percentage-confirm").html(column);
    // Define the Dialog and its properties.
    $("#completion-percentage-confirm").dialog({
      resizable: false,
      modal: true,
      title: "Confirmation",
      width: "500",
      height: "180",
      buttons: {
        "Ok": function () {
          $(this).dialog('close');
        }
      },
      close : function(){
        if(previousCompleted){
          $('#'+element.id).val(previousCompleted);
        }else{
          $('#'+element.id).val('');
          $('#'+element.id).focus();
        }
      }
    });
  };

  function validateWithPreviousCompletion(element, drawItemId, lineItemId, drawId, previousCompleted, fieldName, title){
    $("#completion-percentage-confirm").html(title);
    // Define the Dialog and its properties.
    var completedPercent = previousCompleted.toFixed(2);
    $("#completion-percentage-confirm").dialog({
      resizable: false,
      modal: true,
      title: "Confirmation",
      width: "500",
      height: "200",
      buttons: {
        "No": function () {
          $(this).dialog('close');
        },
        "Yes": function () {
          completedPercent = element.value;
          $(this).dialog('close');
          updateDrawItem(element, drawItemId, lineItemId, drawId, fieldName);
        }
      },
      close : function(){
        $('#'+element.id).val(completedPercent);
      }
    });
  };

  //save draw as draft
  function saveDrawAsDraft(drawId){
    $('#divAjaxLoading').show();
    var budgetItemsRows = $("#createDrawTabularData tr.gc_budget_line_items");
    var trId = '';
    var tempArr = [];
    var tempObj = {};
    var completedPercentageValue = '';
    var currentAppValue = '';
    var drawItemId = '';
    budgetItemsRows.each(function(key,value){
      trId = value.id;
      drawItemId = trId.split('_')[1];
      completedPercentageValue = $('#draw_items--gc_budget_line_item_id--completed_percent--'+drawItemId).val();
      currentAppValue = $('#draw_items--gc_budget_line_item_id--current_app--'+drawItemId).val();
      retainerRateValue = $('#draw_items--gc_budget_line_item_id--retainer_rate--'+drawItemId).text();
      currentRetainerRate = $('#draw_items--gc_budget_line_item_id--current_retention--'+drawItemId).val();
      narrative = $('#draw_items--gc_budget_line_item_id--narrative--'+drawItemId).val();
      tempObj ={
        'completedPercentage':completedPercentageValue
        ,'currentApp':currentAppValue
        ,'retainerRate':retainerRateValue
        ,'drawItemId':drawItemId
        ,'currentRetainerRate':currentRetainerRate
        ,'narrative':narrative
      };
      tempArr.push(tempObj);
    });
    var orderItemsRows = $("#createDrawTabularData tr.change_orders_row");
    var tempOrderArr = [];
    var tempOrderObj = {};
    orderItemsRows.each(function(key,value){
      trId = value.id;
      drawItemId = trId.split('_')[1];
      completedPercentageValue = $('#draw_items--change_order_id--completed_percent--'+drawItemId).val();
      currentAppValue = $('#draw_items--change_order_id--current_app--'+drawItemId).val();
      retainerRateValue = $('#draw_items--change_order_id--retainer_rate--'+drawItemId).text();
      currentRetainerRate = $('#draw_items--change_order_id--current_retention--'+drawItemId).val();
      narrative = $('#draw_items--change_order_id--narrative--'+drawItemId).val();
      tempOrderObj ={
        'completedPercentage':completedPercentageValue
        ,'currentApp':currentAppValue
        ,'retainerRate':retainerRateValue
        ,'drawItemId':drawItemId
        ,'currentRetainerRate':currentRetainerRate
        ,'narrative':narrative
      };
      tempOrderArr.push(tempOrderObj);
    });
    var projectDraw = tempArr.concat(tempOrderArr);
    if(projectDraw.length>0){
      saveAsDraft(projectDraw,drawId);
    }
  };

  function saveAsDraft(projectDraw, drawId){
    try {

      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=saveDrawAsDraft';
      var ajaxUrl = ajaxHandler;
      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ saveDraftSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }
      var jsonString = JSON.stringify(projectDraw);
      var returnedJqXHR = $.ajax({
        type:'POST',
        url: ajaxHandler,
        data: {data:jsonString,drawId:drawId,drawStatus:1},
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  //save draw success callback
  function saveDraftSuccess(data){
    var dataSplit = data.split('~');
    $('#divAjaxLoading').hide();
    if(dataSplit.length > 1) {
      var count = dataSplit[0];
      var drawId = dataSplit[1];
      var appId = dataSplit[2];
      $('#drawDraftCount').val(count);
      var drawDraftCount = $('#drawDraftCount').val();
      if(Number(count) > 0){
        var messageText = 'Proceeding to change the status from \'Posted\' to \'In draft\' will delete any draws that currently exist in draft <span style="color: #3b90ce"> Draw #'+appId+'</span>. Would you like to continue?';
        var checReturn = deleteDrawWithConfirmation(drawId, appId, messageText);
        return;
      }
    }
    // $('#createDrawForm').empty().append(data);
    window.location.href="/modules-draw-list.php";
    setTimeout(function(){
      messageAlert('Successfully saved as draft.', 'successMessage');
    },100);
  };

   /*
  *  Delete Draft Draw With Confirmattion
  */
  function deleteRetWithConfirmation(retId, appId, messageText){
    try {
      if (typeof(messageText) == 'undefined') {
        $("#dialog-confirmation").html("Are you sure to delete Retention Draw # "+appId+" ?");
      } else {
        $("#dialog-confirmation").html(messageText);
      }

      // Define the Dialog and its properties.
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
            // $('#'+element.id).val(previousCompleted.toFixed(2));
          },
          "Yes": function () {
            $(this).dialog('close');
            deleteRetention(retId);
          },
        }
      });

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  function deleteRetention(retId) {
    try {
      var ajaxHandlerScript = 'modules-draw-list-ajax.php?method=DeleteRetention';
      var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
      var ajaxQueryString =
      'ret_id=' + encodeURIComponent(retId);
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: deleteRetentionSuccess,
        error: errorHandler
      });
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }
   function deleteRetentionSuccess(data){
    try {
      var element = $('#draw_status_id');
      element.value = element.val();
      var options = {};
      var pathname = window.location.pathname;
     
        var messageText = 'Retention Draw deleted successfully';
        messageAlert(messageText, 'successMessage');
        filterDraw(element, options);
      
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }
  /**
  * go to draw list
  */
  function gotoDrawList(){
    window.location.href="/modules-draw-list.php";
  };

  /*
  *  Delete Draft Draw With Confirmattion
  */
  function deleteDrawWithConfirmation(drawId, appId, messageText){
    try {
      if (typeof(messageText) == 'undefined') {
        $("#dialog-confirmation").html("Are you sure to delete Draw # "+appId+" ?");
      } else {
        $("#dialog-confirmation").html(messageText);
      }

      // Define the Dialog and its properties.
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
            // $('#'+element.id).val(previousCompleted.toFixed(2));
          },
          "Yes": function () {
            $(this).dialog('close');
            deleteDraw(drawId);
          },
        }
      });

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  function deleteDraw(drawId) {
    try {
      var ajaxHandlerScript = 'modules-draw-list-ajax.php?method=DeleteDraw';
      var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
      var ajaxQueryString =
      'draw_id=' + encodeURIComponent(drawId);
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: deleteDrawSuccess,
        error: errorHandler
      });
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }

  function deleteDrawSuccess(data){
    try {
      var element = $('#draw_status_id');
      element.value = element.val();
      var options = {};
      var pathname = window.location.pathname;
      if(pathname == '/modules-create-draw.php'){
        var draw_id = $('#manage_draw--draw_id').val();
        saveDraftAsFromPostDraw(draw_id);
      } else {
        var messageText = 'Draw deleted successfully';
        messageAlert(messageText, 'successMessage');
        filterDraw(element, options);
      }
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }
  function saveDraftAsFromPostDrawConfirmation(drawId){
    try {
      var messageText = 'Would you like to change the status from \'Posted\' to \'In draft\' ?';
      $("#dialog-confirmation").html(messageText);
      // Define the Dialog and its properties.
      $("#dialog-confirmation").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation",
        width: "500",
        height: "150",
        buttons: {
          "No": function () {
            $(this).dialog('close');
            $("#dialog-confirmation").html("");
            return false;
            // $('#'+element.id).val(previousCompleted.toFixed(2));
          },
          "Yes": function () {
            $(this).dialog('close');
            saveDraftAsFromPostDraw(drawId);
          },
        }
      });

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }
  // Update draw posted to draft
  function saveDraftAsFromPostDraw(drawId) {
    try {
      var ajaxHandlerScript = 'modules-draw-list-ajax.php?method=PostDrawToDraft';
      var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
      var ajaxQueryString =
      'draw_id=' + encodeURIComponent(drawId);
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: saveDraftAsFromPostDrawSuccess,
        error: errorHandler
      });
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }

  function saveDraftAsFromPostDrawSuccess(){
    try {
      // $('#createDrawForm').empty().append(data);
      window.location.href="/modules-draw-list.php";
      setTimeout(function(){
        messageAlert('Successfully saved as draft.', 'successMessage');
      },100);
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  }

  function generateDrawAsExcel(drawId,applicationNumber,is_posted){
    var pathname = window.location.host; // Returns path only
    var http = window.location.protocol;
    var include_path = '/';
    var full_path = http+pathname+include_path;
    var date = new Date();
    var narrative_flag = false;
    var general_condition_flag = false;
    var report_option = $('#export_option').val();
    if (report_option) {
      if(report_option == 'general_condition_summary'){
        general_condition_flag = true;
      }else if(report_option == 'narrative_column'){
        narrative_flag = true;
      }else if(report_option == 'general_condition_summary,narrative_column'){
        general_condition_flag = true;
        narrative_flag = true;
      }
    }  
    
    if(general_condition_flag == true || narrative_flag == true){
      $.get('draw_signature_block-ajax.php',{'method':'checkdrawdownload','narrative_flag':narrative_flag,'general_condition_flag':general_condition_flag,'draw_id':drawId,'type':'excel'},function(data){
        console.log(data);
        if($.trim(data) =='N' && narrative_flag == true){
          messageAlert('No Narrative Column Exists', 'errorMessage');
          return false;   
        }else if($.trim(data) =='N' && general_condition_flag == true){
          messageAlert('Please group all the divisions in the Master Cost Codes list in Budget.', 'errorMessage');
          return false;   
        
        }else{
          var formValues="drawId="+drawId+'&applicationNumber='+applicationNumber+"&is_posted="+is_posted+'&narrative_flag='+narrative_flag+'&general_condition_flag='+general_condition_flag;
          var linktogenerate='draw-print-excel.php?'+formValues;
          document.location = linktogenerate;
        }
      });
    }else{
      var formValues="drawId="+drawId+'&applicationNumber='+applicationNumber+"&is_posted="+is_posted+'&narrative_flag='+narrative_flag+'&general_condition_flag='+general_condition_flag;
      var linktogenerate='draw-print-excel.php?'+formValues;
      document.location = linktogenerate; 
    }
  };
  

  //post draw
  function postDraw(drawId, options){
    
    var applicationNumber = $('#manage_draw--draw_app_id').val();
    var owner_name = $("input[id^='manage_draw--signature_name--Owner']").val();
    var project_customer = $("#project_customer").val();
    var reallocate = $("#reallototal").val();
     if(reallocate =='0.00'){
    
    $.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
        {'applicationId':applicationNumber,'action': 'checkAccountingPortal'}, function(data){
         
          if($.trim(data) === 'Y' && project_customer!=''){ // There is an accounting Portal
             
            $("#dialog-confirm").html("Are you sure to post Draw - "+applicationNumber+" into Quickbooks?");
            
            // Define the Dialog and its properties.
            $("#dialog-confirm").dialog({
              resizable: false,
              modal: true,
              title: "Confirmation",
              open: function() {
                $("#dialog-confirm").parent().addClass("jqueryPopupHead");
                $("body").addClass('noscroll');

              },
              close: function() {
                $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                $("body").removeClass('noscroll');

              },
              buttons: {

                "Cancel": function () {
                  $(this).dialog('close');
                  $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                  $("body").removeClass('noscroll');
                  saveDrawAsDraft(drawId, options);

                },
                "Yes": function () {
                  $(this).dialog('close');
                  $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                  $("body").removeClass('noscroll');

                  // Customer Check
                  if(owner_name){
                    $.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
                      {'action':'getcustomerbyname', 'name':owner_name,
                      'applicationId':applicationNumber,'project_customer':project_customer},function(data){
                      if($.trim(data) === 'customernotexist'){
                        messageAlert('Owner is required to synchronize in Quickbooks.', 'errorMessage');
                      } else if($.trim(data) === 'projectnotexist'){
                        messageAlert('Project Mapped Customer required to synchronize in Quickbooks.', 'errorMessage');
                      }else if($.trim(data) === 'customerprojnotexistinqb'){ 
                      // Create customer & Invoie
                        messageAlert('Make sure the project and customer('+project_customer+') mapped in Quickbooks.', 'errorMessage');
                          //drawtoaccounting(drawId, options,applicationNumber,0);
                      }else if($.trim(data) === 'projectidrequired'){
                        messageAlert('Please enter Project ID in Project Admin page.', 'errorMessage');
                      }else if($.trim(data) ==='Refresh OAuth 2 Access token with Refresh Token failed. Body: [{"error_description":"Incorrect Token type or clientID","error":"invalid_grant"}].'){
                        alert('Quickbooks Token Expired. Please re-connect the Quickbooks'); 
                        window.location.href = "/app/views/accounting-portal-form.php"; 
                        return false;
          
                      } else if(isNaN(data)){
                        messageAlert(data, 'errorMessage');
                      }else { // Get Confirmation and then add 
                        $("#dialog-confirm").html("Are you sure to map this draw to existing customer <b>"+project_customer+"</b> in Quickbooks?");
                        // Define the Dialog and its properties.
                        $("#dialog-confirm").dialog({
                          resizable: false,
                          modal: true,
                          title: "Confirmation",
                          open: function() {
                            $("#dialog-confirm").parent().addClass("jqueryPopupHead");
                            $("body").addClass('noscroll');
                          },
                          close: function() {
                            $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                            $("body").removeClass('noscroll');
                          },
                          buttons: {
                            "Cancel": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              saveDrawAsDraft(drawId);
                            },
                            "Yes": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              drawtoaccounting(drawId, options,applicationNumber,data);
                            }
                          }
                        });
                        //confirmation
                      }
                    });

                  }else{
                    messageAlert('Owner is required to synchronize in Quickbooks.', 'errorMessage');
                  }
                }
              }
            });
          }else{ // There is no active Accounting Portal
            // postDrawOrg(drawId, options);
            
            // Get Confirmation and then add 
            $("#dialog-confirm").html("Please select the correct Quickbooks Project before posting the draw. If you select “Post Anyway” the draws for this project will not be linked to or visible in your Quickbooks company.");
                        // Define the Dialog and its properties.
                        $("#dialog-confirm").dialog({
                          resizable: false,
                          modal: true,
                          title: "Confirmation",
                          open: function() {
                            $("#dialog-confirm").parent().addClass("jqueryPopupHead");
                            $("body").addClass('noscroll');
                          },
                          close: function() {
                            $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                            $("body").removeClass('noscroll');
                          },
                          buttons: {
                            "Post Anyway": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              postDrawOrg(drawId, options);
                            },
                            "Cancel": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              saveDrawAsDraft(drawId);
                            }
                          }
                        });
                        //confirmation
          }

    });
  }else{
    var title = "To post this Draw - "+applicationNumber+" the Reallocations column Overall Total should need to be zero";
    reallocateconfirmation(applicationNumber,title);
  }
  };
// can not post a draw untill reallocation is zero
  function reallocateconfirmation(applicationNumber,title)
  {
    // Define the Dialog and its properties.
    $("#dialog-confirm").html(title);
        $("#dialog-confirm").dialog({
          resizable: false,
          modal: true,
          title: "Confirmation",
          open: function() {
            $("#dialog-confirm").parent().addClass("jqueryPopupHead");
            $("body").addClass('noscroll');
          },
          close: function() {
            $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
            $("body").removeClass('noscroll');
          },
          buttons: {
            "Ok": function () {
              $(this).dialog('close');
              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
              $("body").removeClass('noscroll');
            
            }
          }
        });
  }
  function drawtoaccounting(drawId, options,applicationNumber,custId){
      /*alert(applicationNumber);
      alert(custId);*/
      var owner_name = $("input[id^='manage_draw--signature_name--Owner']").val();
      var project_customer = $("#project_customer").val();
      $.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
            {'applicationId':applicationNumber,'action': 'updateQB','name':owner_name,'customerid':custId,'project_customer':project_customer},
        function(JsonData){
          if($.trim(JsonData.qb_error_id) != ''){
            messageAlert('Error Code :'+JsonData.qb_error_id+'<br/> Please share error code and contact developer for resolution.', 'errorMessage');
          }else if($.trim(JsonData.returnval) ==='refreshtokenexpired'){
            alert('Quickbooks Token Expired. Please re-connect the Quickbooks'); 
            window.location.href = "/app/views/accounting-portal-form.php"; 
            return false;
          }else if($.trim(JsonData.returnval) ==='invoicecreated'){
            messageAlert('Invoice imported in the Quickbooks.', 'successMessage');
            postDrawOrg(drawId, options);
          }else{
            messageAlert('There is a technical issue. Please try after some time (or) contact Admin.', 'errorMessage');
            return false;
          }
      });
  }
  function postDrawOrg(drawId, options){
    try {

    // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=postDraw';
      var ajaxUrl = ajaxHandler;
      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ postDrawSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }
      var returnedJqXHR = $.ajax({
        type:'POST',
        url: ajaxHandler,
        data: {drawId:drawId,drawStatus:2},
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }

  }
  //save draw success callback
  function postDrawSuccess(data){
    try {

      var applicationNumber = $('#manage_draw--draw_app_id').val();
      var drawId = $('#manage_draw--draw_id').val();
      var project_id = $('#currentlySelectedProjectId').val();
      var projectName = $('#currentlySelectedProjectName').val();

      $.get(window.ajaxUrlPrefix+'draw-print-excel.php',
      {
        'drawId':drawId,'applicationNumber':applicationNumber,
        'is_posted':1,'narrative_flag':false,'general_condition_flag': false
      }, function(data){ 
        if (data) { }
      });

      $.get(window.ajaxUrlPrefix+'download-report.php',
      {
        'responseDataType':'json','ReportType':'Vector Report','report_view':'Vector Report',
        'projectName':projectName,'project_id':project_id,
        'grouprowval':true,'groupco':true,'generalco':false,'inotes': false,'subtotal': false,
        'costCodeAlias':false,'drawId':drawId,'applicationNumber':applicationNumber,'is_draw_posted' : true
      }, function(data){ 
          if (data) { 
            window.location.href="/modules-draw-list.php";
            setTimeout(function(){
              messageAlert('Draw posted Successfully.', 'successMessage');
            },100);
          }
      });
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

function formatCurrentApp(currentApp){
  var currentAppValue = currentApp;
  currentAppValue = currentAppValue.replace('$', '');
  currentAppValue = currentAppValue.replace(/,/g, '');
  return currentAppValue;
};


function drawAddKeyEventListeners()
{

  $('textarea').keydown(function(e){
    if (e.keyCode == 40) {
      tabIndexValue = e.target.tabIndex+4;
      $('[tabindex=' + tabIndexValue + ']').select();
    }
    if(e.keyCode == 38) {
      tabIndexValue = e.target.tabIndex-4;
      $('[tabindex=' + tabIndexValue + ']').select();
    }
  });

  $("#createDrawTabularData td input").keydown(function(e) {
    if (e.keyCode == 13) {
      // Get the attribute name of the element with focus. We want to assign focus
      // to the element with this attribute name in the next row (or previous row
      // if the shift key is held down).
      var elementId = e.target.id;
      var arrTemp = elementId.split('--');
      var attributeName = arrTemp[2];

      // When there are multiple subcontractor bids, there are multiple elements
      // with the same attribute name per row. We need to capture the index of the
      // currently focused element.
      var tr = $(this).closest('tr');
      var index = 0;
      var self = this;
      tr.find('.' + attributeName).each(function() {
        if (this == self) {
          return false;
        }
        index++;
      });

      // Move focus up one row if the shift key is held down. Move focus
      // down one row otherwise.
      var nextTr = e.shiftKey ? tr.prev() : tr.next();

      // Assign focus to the element in the next row with the specified attribute name and index.
      var nextInput = nextTr.find('.' + attributeName)[index];
      // Skip the ones that aren't visible.
      while (nextInput && $(nextInput).hasClass('hidden')) {
        nextTr = e.shiftKey ? nextTr.prev() : nextTr.next();
        nextInput = nextTr.find('.' + attributeName)[index];
      }

      if (nextInput) {
        tabIndexValue = e.target.tabIndex+4;
        nextInput.focus();
        nextInput.select();
      }
      return false;
    }

    var rowIndex = 0;
    var tdIndex = 0;
    var inputIndex = 0;
    if ((e.keyCode > 36 && e.keyCode < 41) || e.keyCode == 13) {
      rowIndex = $(this).parent().parent().index("#createDrawTabularData tbody tr");
      tdIndex = $(this).parent().index("#createDrawTabularData tbody tr:eq("+rowIndex+") td");
      inputIndex = $(this).index();
    }
    if (e.keyCode == 38) {      
      rowIndex = parseInt(rowIndex) - 1;
      for ( var i = rowIndex; i >= 0; i-- ) {
        if ($("#createDrawTabularData tbody tr").eq(i).find('td').eq(tdIndex).find('input:not(:disabled):visible').eq(inputIndex).length != 0 ) {
          rowIndex = i;
          break;
        }
      }
      
      $("#createDrawTabularData tbody tr").eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).select();
      tabIndexValue = $("#createDrawTabularData tbody tr").eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).attr('tabindex');
      return false;
    } else if (e.keyCode == 40 || e.keyCode == 13) {
      rowIndex = parseInt(rowIndex) + 1;
      for ( var i = rowIndex; i < $("#createDrawTabularData tbody tr").length; i++ ) {
        if ($("#createDrawTabularData tbody tr").eq(i).find('td').eq(tdIndex).find('input:not(:disabled):visible').eq(inputIndex).length != 0 ) {
          rowIndex = i;
          break;
        }
      }
      if (e.keyCode == 13) {
        tdIndex = 1;
      }
      $("#createDrawTabularData tbody tr").eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).select();
      tabIndexValue = $("#createDrawTabularData tbody tr").eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).attr('tabindex');
      return false;
    } else if (e.keyCode == 37 || e.keyCode == 39) {
      var cPos = doGetCaretPosition(this);
      if ((e.keyCode == 37 && cPos == 0) || (e.keyCode == 39 && cPos == $(this).val().length) ) {
        inputCount = parseInt($(this).parent().parent().find('input:not(:disabled)').length);
        inputIndex = parseInt($(this).parent().parent().find('input:not(:disabled)').index(this));
        if (e.keyCode == 37) {
          if (inputIndex == 0) {
            // It is the first input in the row
            // Set it to the last of the previous row
            rowIndex = parseInt(rowIndex) - 1;
            inputIndex = $("#createDrawTabularData tbody tr").eq(rowIndex).find('input:not(:disabled)').length - 1;
            //inputIndex = parseInt(inputCount) -1; // Count versus zero-based index

            if ($("#createDrawTabularData tbody tr").eq(rowIndex).find('input:not(:disabled)').eq(inputIndex).length == 0 ) {
              // If the row is subtotal try going past it.
              rowIndex = parseInt(rowIndex) - 1;
            }
          } else {
            inputIndex = parseInt(inputIndex) - 1;
          }
        } else if (e.keyCode == 39) {
          if (inputIndex == (inputCount - 1)) {
            // It is the last input in the row
            // Set it to the first of the next row
            inputIndex = 0;
            rowIndex = parseInt(rowIndex) + 1;
            if ($("#createDrawTabularData tbody tr").eq(rowIndex).find('input:not(:disabled)').eq(inputIndex).length == 0 ) {
              // If the row is subtotal try going past it.
              rowIndex = parseInt(rowIndex) + 1;
            }
          } else {
            inputIndex = parseInt(inputIndex) + 1;
          }
        }
        var theInput = $("#createDrawTabularData tbody tr").eq(rowIndex).find('input:not(:disabled)').eq(inputIndex);
        tabIndexValue = theInput.attr('tabindex');
        theInput.focus();
        theInput.select();
        return false;
      }
    }
  });
}

function doGetCaretPosition (oField)
{
  // Initialize
  var iCaretPos = 0;
  if (oField.type == 'checkbox') {
    return iCaretPos;
  }

  // IE Support
  if (document.selection) {
    // Set focus on the element
    oField.focus ();
    // To get cursor position, get empty selection range
    var oSel = document.selection.createRange ();
    // Move selection start to 0 position
    oSel.moveStart ('character', -oField.value.length);
    // The caret position is selection length
    iCaretPos = oSel.text.length;
  } else if (oField.selectionStart || oField.selectionStart == '0') {
    iCaretPos = oField.selectionStart;
  }

  // Return results
  return (iCaretPos);
}
// To create a Retention Draw
function createRetentionDraw()
{
  try {
      var options = options || {};
      var promiseChain = options.promiseChain;
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=createRetentionDraw';
      var ajaxQueryString = 'responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {

          return;
        }
      }

      var arrSuccessCallbacks = [ createRetentionSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: arrSuccessCallbacks,
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }
    }catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
}

 function createRetentionSuccess(data, textStatus, jqXHR){
    try {
      $('#divAjaxLoading').hide();
      var dataSplit = data.split('~');
      if(dataSplit.length > 1) {
        var countret = dataSplit[0];
        var countdraw = dataSplit[1];
        $('#drawRetentionCount').val(countret);
        var drawRetentionCount = $('#drawRetentionCount').val();
        if((Number(countret) > 0 )|| (Number(countdraw) > 0)){
          var messageText = 'To create a new Retention either delete (or) post the existing draw in draft';
          messageAlert(messageText, 'errorMessage');
          return;
        }
      }
      var applicationId = data;
      window.location.href="/modules-create-retention.php?retentionId="+applicationId;
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  //update Retainer value
  function updateRetainerValue(element, retentionItemId, lineItemId, RetentionId, previousAppValue, fieldName){
    try {
      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;

      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=validateCurrentRetainerValue';
      var ajaxQueryString =
      'retentionItemId=' + encodeURIComponent(retentionItemId)+
      '&responseDataType=json';
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
        success: function(data){ 
          var currentRetainageValue = data;
          validateCurrentRetainerValueSuccess(currentRetainageValue, element, retentionItemId, lineItemId, RetentionId, previousAppValue, fieldName)
        },
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };
// Success function after updating Current retainer value
  function validateCurrentRetainerValueSuccess(currentRetainageValue, element, retentionItemId, lineItemId, RetentionId, previousAppValue, fieldName){
    try{
      var currentRetainerval = element.value;
      var currentRetainervalFormatted = formatCurrentApp(currentRetainerval);
      var previousret = formatCurrentApp(previousAppValue);
      var currentRetainerwithheld = formatCurrentApp(currentRetainageValue);
      // var totalRetainerValue = parseFloat(previousret) + parseFloat(currentRetainervalFormatted);
      var totalRetainerValue = parseFloat(currentRetainervalFormatted);
      if(parseFloat(totalRetainerValue) > parseFloat(currentRetainerwithheld)){
        $('#'+element.id).addClass('redBorder');
        $('#'+element.id).val('');
        $("#dialog-confirmation").html("Ret Amount to  Bill  cannot be greater than the corresponding Cur Ret withheld");
        // Define the Dialog and its properties.
        $("#dialog-confirmation").dialog({
          resizable: false,
          modal: true,
          title: "Confirmation",
          width: "500",
          height: "180",
          buttons: {
            "Ok": function () {
              $(this).dialog('close');
            },
          },
          close : function(){
            $('#'+element.id).removeClass('redBorder');
            $('#'+element.id).focus();
          }
        });
      }else{
        updateRetentionItem(element,retentionItemId,lineItemId,RetentionId,previousAppValue,fieldName);
      }
    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  //update draw
  function updateRetentionItem(element, retentionItemId, lineItemId,RetentionId, curRetainage,fieldName){
    try {
      // If the options object was not passed as an argument, create it here.
      var options = options || {};
      var promiseChain = options.promiseChain;

      var elementId = element.id;
      var elementIdSplit = element.id.split('--');
      var attributeType = elementIdSplit[1];//budget or COR
      var attributeSubGroup = elementIdSplit[2];//column
      var budgetLineItemId = elementIdSplit[3];//gc_budget_line_item_id or change_order_id
      var attributeValue = element.value;//given input
      //replace '$' symbol
      if(fieldName == 'Current Retainer Value'){
        var currentRetainerValue = attributeValue;
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          minimumFractionDigits: 2,
        });
        attributeValue = attributeValue.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
        var htmlcurrentRetainerValue = $('#'+element.id).html();
        if(htmlcurrentRetainerValue == null || htmlcurrentRetainerValue == '&nbsp;'){
          attributeValue = formatter.format(attributeValue);
        }
        $('#'+element.id).empty().html(attributeValue);
        attributeValue = currentRetainerValue.replace('$', '');
      }
       if(fieldName == 'Percentage Completion'){
        if(attributeValue > 100)
        {
          percentagecompletionAlert(element.id);
          $('#'+element.id).val('');
           return false;
        }
       }
      var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=updateRetentionItem';
      var ajaxQueryString =
      'attributeType=' + encodeURIComponent(attributeType) +
      '&attributeSubGroup=' + encodeURIComponent(attributeSubGroup) +
      '&attributeValue=' + encodeURIComponent(attributeValue) +
      '&retentionItemId=' + encodeURIComponent(retentionItemId)+
      '&lineItemId=' + encodeURIComponent(lineItemId)+
      '&RetentionId=' + encodeURIComponent(RetentionId) +
      '&curRetainage=' + encodeURIComponent(curRetainage) +
      '&responseDataType=json';
      var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

      if (window.ajaxUrlDebugMode) {
        var continueDebug = window.confirm(ajaxUrl);
        if (continueDebug != true) {
          return;
        }
      }
      var arrSuccessCallbacks = [ updateRetentionItemSuccess ];
      var successCallback = options.successCallback;
      if (successCallback) {
        if (typeof successCallback == 'function') {
          arrSuccessCallbacks.push(successCallback);
        }
      }

      var returnedJqXHR = $.ajax({
        url: ajaxHandler,
        data: ajaxQueryString,
        success: function(data){
          updateRetentionItemSuccess(data,fieldName,elementId)
        },
        error: errorHandler
      });
      if (promiseChain) {
        return returnedJqXHR;
      }

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }
    }
  };

  function updateRetentionItemSuccess(data, fieldName,elementId){
    try {
      messageAlert(fieldName+' Successfully updated.', 'successMessage');
      $('#createDrawForm').empty().append(data);
      initDecimalValue();
      initReallocationValue();
      initCurrentRetainerValue();
      $('#export_option').fSelect({
                numDisplayed: 1,
                overflowText: '{n} selected'
                });      
      
      var tabIndexValue = parseInt($("#"+elementId).attr('tabindex'))+1;

      var nextID = $('input[tabindex='+tabIndexValue+']');
      
      if (fieldName == 'Narrative' && nextID[0].disabled == true) {
        tabIndexValue = tabIndexValue + 1;
      }
      
      $('[tabindex=' + tabIndexValue + ']').select();
      drawAddKeyEventListeners();
      datepicker();

    } catch(error) {
      if (window.showJSExceptions) {
        var errorMessage = error.message;
        alert('Exception Thrown: ' + errorMessage);
        return;
      }

    }
  };

  function percentagecompletionAlert(id)
  {
    $('#'+id).addClass('redBorder');
        $('#'+id).val('');
        $("#dialog-confirmation").html("% To  Bill  cannot be greater than 100");
        // Define the Dialog and its properties.
        $("#dialog-confirmation").dialog({
          resizable: false,
          modal: true,
          title: "Confirmation",
          width: "500",
          height: "180",
          buttons: {
            "Ok": function () {
              $(this).dialog('close');
            },
          },
          close : function(){
            $('#'+id).removeClass('redBorder');
            $('#'+id).focus();
          }
        });
  }

function drawCostCodeValidation(element, drawItemId, lineItemId, drawId, previousCompleted, fieldName){
  try {
    
    var options = options || {};
    var promiseChain = options.promiseChain;

    var elementId = element.id;
    var elementIdSplit = element.id.split('--');
    var elementName = elementIdSplit[0];//draw_items
    var attributeType = elementIdSplit[1];//budget or COR
    var attributeSubGroup = elementIdSplit[2];//column
    var budgetLineItemId = elementIdSplit[3];//gc_budget_line_item_id or change_order_id
    var attributeValue = element.value;//given input

    var scheduled_value = parseFloat($("#"+elementName+'--'+attributeType+'--scheduled_value--'+budgetLineItemId).val());

    var previous_app = parseFloat($("#"+elementName+'--'+attributeType+'--previous_app_val--'+budgetLineItemId).val());

    var completed_percent = parseFloat($("#"+elementName+'--'+attributeType+'--completed_percent--'+budgetLineItemId).val());

    var current_app = parseFloat(formatCurrentApp($("#"+elementName+'--'+attributeType+'--current_app--'+budgetLineItemId).val()));

    var current_retention = parseFloat(formatCurrentApp($("#"+elementName+'--'+attributeType+'--current_retention--'+budgetLineItemId).val()));

    var retainer_rate = parseFloat($("#"+elementName+'--'+attributeType+'--retainer_rate--'+budgetLineItemId).val());

    var previous_app_value = parseFloat($("#"+elementName+'--'+attributeType+'--previous_retainer_value--'+budgetLineItemId).val());

    var min_current_app = previous_app < 0 ? previous_app : -previous_app;
    var max_current_app = (scheduled_value - previous_app).toFixed(2);

    var validationStatus = false;

    if (fieldName == 'Completed Percentage') {
      if(completed_percent > 100){
        validateMaximumPercentage(element, previousCompleted, "Completed Percentage can't be greater than 100");
        return;
      }else if(completed_percent < previousCompleted){
        var title = 'Are you sure you want to update?';
        validateWithPreviousCompletion(element,drawItemId,lineItemId,drawId,previousCompleted,fieldName,title);
        return;
      }else{
        var validationStatus = true;
      }
    }

    if (fieldName == 'Current App') {
      var old_current_app_value = $("#pre-curt-app-value_"+drawItemId).val();
      if (current_app < min_current_app) {
        validateMaximumPercentage(element, old_current_app_value, "This makes Completed Percentage lower than 0, which is not possible.");
        return;
      }else if (current_app > max_current_app) {
        validateMaximumPercentage(element, old_current_app_value, "This makes Completed Percentage greater than 100, which is not possible.");
        return;
      }else{
        var validationStatus = true;
      }
    }

    if (fieldName == 'Retainer Rate'){
      var cal_curnt_retention = 1;
      if (current_app) {
        var cal_curnt_retention = ((current_app / 100) * retainer_rate) + previous_app_value;
      }
      var oldretention = $("#pre-retention-rate_"+drawItemId).val();
      if (retainer_rate > 100) {
        validateMaximumPercentage(element, oldretention, "Retainer Rate can't be greater than 100");
        return;
      }else if (current_app && cal_curnt_retention < 0){
        validateMaximumPercentage(element, oldretention, "Total Retention can't go below zero");
      }else{
        var validationStatus = true;
      }
    }

    if (fieldName == 'Current Retention') {
      var old_current_retention = $("#pre-curt-retention-rate_"+drawItemId).val();
      if (current_app) {
        var cal_curnt_rete = 1;
        if (current_retention) {
          var cal_curnt_rete = current_retention + previous_app_value;
        }
        
        if (current_app < 0){
          var retentionRate = parseFloat((current_retention * 100) / current_app );
          if (true) {
            validateMaximumPercentage(element, old_current_retention, "Retention Rate can't go below zero");
            return;
          }

        }

        if (current_app < 0 && current_retention < 0) {
          var current_retention = -current_retention;
          var current_app = -current_app;
        }else if (current_app < 0 && current_retention > 0){
          var current_app = -current_app;
        }
        if (current_retention > current_app) {
          validateMaximumPercentage(element, old_current_retention, 'Current retention value cannot be greater than the corresponding current app value');
          return;
        }else if (cal_curnt_rete < 0) {
          validateMaximumPercentage(element, old_current_retention, "Total Retention can't go below zero");
        }else{
          var validationStatus = true;
        }
      }else{
        validateMaximumPercentage(element, old_current_retention, "Current Retention can't be updated.Need to update Current App.");
        return;
      }     
    }

    if (fieldName == 'Reallocation') {
      if (previousCompleted == 1) {
        var old_reallocation = parseFloat($("#old_realocation_val_"+drawItemId).val());
        var title = 'The Reallocation is already committed. Are you sure want to update this reallocation?';
        validateWithPreviousCompletion(element,drawItemId,lineItemId,drawId,old_reallocation,fieldName,title);
        return;
      }else{
        var validationStatus = true;
      }
    }

    if (validationStatus) {
      updateDrawItem(element, drawItemId, lineItemId, drawId, fieldName);
    }
    
  } catch(error) {
    if (window.showJSExceptions) {
      var errorMessage = error.message;
      alert('Exception Thrown: ' + errorMessage);
      return;
    }
  }
};

function postReallocation(drawId){
  var applicationNumber = $('#manage_draw--draw_app_id').val();
  var reallocate = $("#reallototal").val();
  if(reallocate =='0.00'){

    $("#completion-percentage-confirm").html("If you click Yes the reallocations will immediately be applied to the Scheduled Value in the current draw and be applied to the Prime Contract Scheduled Value column on the Project Budget Page. Are you sure you want to commit this reallocation?");
    $("#completion-percentage-confirm").dialog({
      resizable: false, modal: true,title: "Confirmation",width: "600",height: "250",
      buttons: {
        "No": function () {
          $(this).dialog('close');
        },
        "Yes": function () {
          $(this).dialog('close');
          commitReallocations(drawId);
        }
      },
      close : function(){
        $(this).dialog('close');
      }
    });
  }else{
    var title = "In order to commit reallocations for [draw number #"+applicationNumber+"] the total for the reallocation column must balance to zero.";
    reallocateconfirmation(applicationNumber,title);
  }
};

function commitReallocations(drawId){
  var options = options || {};
  var promiseChain = options.promiseChain;
  var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=postReallocation';

  var ajaxQueryString =
  'drawId=' + encodeURIComponent(drawId) +
  '&responseDataType=json';

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
    success: function(data){
      updateDrawItemSuccess(data,'Reallocations Commit','','')
    },
    error: errorHandler
  });
  if (promiseChain) {
    return returnedJqXHR;
  }
}
