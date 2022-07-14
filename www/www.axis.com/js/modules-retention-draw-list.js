//post retention draw
  
  function postRetentionDraw(retentionId){
    var applicationNumber = $('#manage_draw--draw_app_id').val();
    var owner_name = $("input[id^='manage_draw--signature_name--Owner']").val();
    var project_customer = $("#project_customer_retention").val();
    $.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
    {'action': 'checkAccountingPortal'}, function(data){
      if($.trim(data) === 'Y' && project_customer!=''){ // There is an accounting Portal
        $("#dialog-confirm").html("Are you sure to post Retention Draw #"+applicationNumber+" into Quickbooks?");
        // Define the Dialog and its properties.
          $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            title: "Confirmation",
            width: "480",
            height: "200",
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
                // postRetentionOrg(retentionId);
                    saveDrawAsDraft(retentionId);
              },
              "Yes": function () {
                $(this).dialog('close');
                $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                $("body").removeClass('noscroll');
                // Customer Check
                if(owner_name){
                  $.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
                    {'action':'getcustomerbyname', 'name':owner_name,
                    'applicationId':applicationNumber,'project_customer':project_customer
                    ,'type':'retention'},function(data){
                      if($.trim(data) === 'customernotexist'){
                        messageAlert('Owner is required to synchronize in Quickbooks.', 'errorMessage');
                      } else if($.trim(data) === 'projectnotexist'){
                        messageAlert('Project Mapped Customer required to synchronize in Quickbooks.', 'errorMessage');
                      }else if($.trim(data) === 'customerprojnotexistinqb'){ 
                      // Create customer & Invoie
                        messageAlert('Make sure the project and customer('+project_customer+') mapped in Quickbooks.', 'errorMessage');
                      }else if($.trim(data) === 'projectidrequired'){
                        messageAlert('Please enter Project ID in Project Admin page.', 'errorMessage');
                      }else if($.trim(data) ==='Refresh OAuth 2 Access token with Refresh Token failed. Body: [{"error_description":"Incorrect Token type or clientID","error":"invalid_grant"}].'){
                        alert('Quickbooks Token Expired. Please re-connect the Quickbooks'); 
                        window.location.href = "/app/views/accounting-portal-form.php"; 
                        return false;
          
                      } else if(isNaN(data)){
                        messageAlert(data, 'errorMessage');
                      }else {
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
                            "No": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                            },
                            "Yes": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              retentionDrawToQB(retentionId, applicationNumber,data);
                            }
                          }
                        });

                      }

                  });

                }else{
                  messageAlert('Owner is required to synchronize in Quickbooks.', 'errorMessage');
                }
              }
            }
          });
      }else{
        

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
                            "No": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              saveDrawAsDraft(retentionId);
                            },
                            "Yes": function () {
                              $(this).dialog('close');
                              $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                              $("body").removeClass('noscroll');
                              postRetentionOrg(retentionId);
                            }
                          }
                        });
                        //confirmation
      }
    });
  }

function retentionDrawToQB(retentionId, applicationNumber,custId){ // To Send invoice to QB and Post draw in fulcrum

  var owner_name = $("input[id^='manage_draw--signature_name--Owner']").val();
  var project_customer = $("#project_customer_retention").val();
  $.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
        {'applicationId':applicationNumber,'action': 'updateretentionQB','name':owner_name,'customerid':custId,'project_customer':project_customer,'retentionId':retentionId},
    function(JsonData){
      if($.trim(JsonData.qb_error_id) != ''){
            messageAlert('Error Code :'+JsonData.qb_error_id+'<br/> Please share error code and contact developer for resolution.', 'errorMessage');
      }else if($.trim(JsonData.returnval) ==='refreshtokenexpired'){ // Token Expired
        alert('Quickbooks Token Expired. Please re-connect the Quickbooks'); 
        window.location.href = "/app/views/accounting-portal-form.php"; 
        return false;
      }else if($.trim(JsonData.returnval) ==='invoicecreated'){ // Succeesfuly Posted invoice
        messageAlert('Retention invoice synchronized to Quickbooks successfully.', 'successMessage');
        postRetentionOrg(retentionId);
      }else{
        messageAlert('There is a technical issue. Please try after some time (or) contact Admin.', 'errorMessage');
        return false;
      }
  });
}

function postRetentionOrg(retentionId){ // Posting Retention Draw
  try {
    var ajaxUrl = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php';
    var arrSuccessCallbacks = [ postRetentionDrawSuccess ];
    $.ajax({
      type:'GET',
      url: ajaxUrl,
      data: {'method':'postRetentionDraw','retentionId':retentionId,'retentionDrawStatus':2},
      success: arrSuccessCallbacks,
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

//save draw success callback
function postRetentionDrawSuccess(data){ // Success of the Retention Draw Post and Redirect to listing.
  try {
    window.location.href="/modules-draw-list.php";
    setTimeout(function(){
      messageAlert('Retention Draw posted Successfully.', 'successMessage');
    },100);
  } catch(error) {
    if (window.showJSExceptions) {
      var errorMessage = error.message;
      alert('Exception Thrown: ' + errorMessage);
      return;
    }
  }
};
