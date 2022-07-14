<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	<div class="divflex">
		<input type="hidden" id="invoice_project_id" value="{$project_id}">
		<input type="hidden" id="invoice_company_id" value="{$user_company_id}">
		<input type="hidden" id="invoice_currently_active_contact_id" value="{$currentlyActiveContactId}">
		<input type="hidden" id="invoice_vendor_id" value="">
		<input type="hidden" id="currentlySelectedProjectTypeIndex" value="{$currentlySelectedProjectTypeIndex}">
		<input type="hidden" id="userCanManageSubcontractInvoice" value="{$userCanManageSubcontractInvoice}">
		<div class="inline">
			<p style="font-weight: bold;">Select Vendor</p>
			<h4>{$vendorsel}</h4>
		</div>
		<div class="inline">
			<p style="font-weight: bold;">Select Contract</p>
			<h4>{$contractsel}</h4>
		</div>
	</div>   <!-- manage filter div -->

	<div>
		{if !empty($userCanCreateSubcontractInvoice) || !empty($userCanManageSubcontractInvoice)}
		<div class="panel panel-default new_invoice" style="display:none; width: 115%;">
    		<div class="panel-heading">New Invoice</div>
    		<div class="panel-body">
    			<table class="tableborder table-bordered " cellpadding="5" cellspacing="0" width="100%">
    				<thead>
	    				<tr  class="new_invoice table-headerinner">
							<th>Company</th>
							<th><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB"> Customer:Project</th>
							<th>Invoice Files<br/>(PDF Only)</th>
							<th>Rec'd<br/>(MM/DD/YYYY)</th>
							<th>App #</th>
							<th>Period To <br/>(MM/DD/YYYY)</th>
							<th>SC Amount</th>
							<th>Retention</th>
							<th>Invoice Total</th>
							<th>Contract Remaining</th>
							<!--<th>Suppliers</th>-->
							<th>Notes (Displayed to Sub)</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr  class="new_invoice" style="font-weight: initial;">
							<td id="vendor_name">Company</td>
							<td>{$qb_cust_html}</td>
							<td style="width: 200px;">
								{$fileUploader}{$fileUploaderProgressWindow}
								<ul id="container--request_for_information_attachments--create-request_for_information-record" class="ulUploadedFiles">
								</ul>
								<input type="hidden" id="invoice_create" name="invoice_create" value="">
							</td>
							<td>
								<div class='datepicker_style_custom field-amt' style='display: block;''>
									<input type='text' value='' class='tcomp_date form-control' id='recieved_date'  style='width:95%;'><img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='/images/cal.png' id='dp1562147413179'>
								</div>
								
							</td>
							<td><input type="text" class="field-amt" id="app"></td>
							<td>
								<div class='datepicker_style_custom field-amt' style='display: block;''>
									<input type='text' value='' class='tcomp_date form-control' id='period_to_date'  style='width:95%;'><img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='/images/cal.png' id='dp1562147413179'>
								</div>
							</td>
							<td>
								<input type="text" class="field-amt" value="0.00" onkeypress="return isNumberKey(event)" onclick="checkContractRemaining()" id="amount">
							</td>
							<td>
								<input type="text" class="field-amt" value="0.00" onkeypress="return isNumberKey(event)" onclick="checkContractRemaining()" id="retention">
							</td>
							<td>
								<input type="text" class="field-amt" value="0.00" onkeypress="return isNumberKey(event)" id="total" onchange="checkTotal()">
							</td>
							<td>
								<input type="text" class="conremaining-amt" value=""  id="conremaining-amt" disabled="true" >
								<input type="hidden" class="total-conremaining-amt" value=""  id="total-conremaining-amt" >
							</td>
							<!--<td>
								{$supplierSel}
								<span id="btnAddSupplierPopover" class="btnAddSupplierPopover btn entypo entypo-click entypo-plus-circled popoverButton" data-toggle="supplierPopover" style="margin-left:7px"></span>

								<div id="CreateSupplierdiv" class="hidden">
									<div id="record_creation_form--create-prelim-record">
										<div>
											<label>Supplier:</label> 
											<input type="text" id="supplier_name" value="" style="width: 96%; float: initial;">
										</div>
										<div class="textAlignRight" style="margin-top:5px">
											<input type="submit" value="Create Supplier" onclick="addNewSupplier();" style="width: 400px; padding: 4px;">
										</div>
									</div>
								</div>

							</td>-->
							<td>
								<textarea style="width: 250px;" id="notes"></textarea>
							</td>
							<td>
								{$subcont_status}
							</td>
						</tr>
					</tbody>
					<tbody id="supplierlist">
					</tbody>
					<tbody>
						<tr>
							<td colspan="12">
							<Button href="javaScript:void(0)" class="btn-cmn" id="createinvoice" style="float: right; color: white; text-decoration: none;" >Create Invoice</button>
			    			</td>
						</tr>
					</tbody>
    			</table>
    		</div>
    		{/if}
  		</div>
  		{if !empty($userCanCreateSubcontractInvoice) || !empty($userCanManageSubcontractInvoice) ||
  		 !empty($userCanViewSubcontractInvoice)}
  		<div class="panel panel-default" style="width: 135%;">
  			<div class="panel-body">
	  			<table class="tableborder table-bordered " cellpadding="5" cellspacing="0" width="100%">
					<thead>
						<tr  style="background-color: #e6e6e6;">
			            	<th {if !empty($userCanManageSubcontractInvoice)} colspan="16" {else}  colspan="14" {/if} class="textAlignLeft">
			            		Out Standing Invoices in process 
			            		<span style="margin-left: 53px;"><a href="javaScript:void(0);" onclick="getProjectMappedCust(); return false;" title="Click to Get Project Customer from QB" style="display: inline-block; margin-bottom: 0; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; border: 1px solid transparent; border-radius: 4px; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;"><img src="/images/refresh_icon.png" style="height: 16px; width: 20px; vertical-align: top;"></a> Get Customer:Project <img src="/images/buttons/button-info.png" style="height: 12px;width: 12px;vertical-align: top;" class="show_info_txt"></span>
			            		<div class="dropdown-content-change-order">Sync customers tied to a project within in order to send invoice details to QuickBooks</div>
			            		<span style="margin-left: 53px;"><input type="checkbox" id="show_all_invoice" > Show all invoices?</span>
			            	</th>
			            </tr>
			            <tr class="table-headerinner">
			            			<th>Cost Code</th>
							<th>Company</th>
							<th><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB"> Customer:Project</th>
							<th style="width: 200px;">Invoice Files</th>
							<th>Rec'd</th>
							<th>App #</th>
							<th>Period To</th>
							<th>SC Amount</th>
							<th>Retention</th>
							<th>Invoice Total</th>
							<th>Supplier</th>
							<th>Supplier Amount</th>
							<th>Contract Remaining</th>
							<th>Notes (Displayed to Sub)</th>
							<th>PM Approved</th>
							{if !empty($userCanManageSubcontractInvoice)}
							<!--<th>Sync</th>-->
							{/if}
							<th>Status</th>
							{if !empty($userCanManageSubcontractInvoice)}
							<th></th>
							{/if}
						</tr>
					</thead>
					<tbody id="invoice_body">
						{$get_subcont_invoice}
					</tbody>
				</table>
  			</div>
		</div>
		{/if}

		{if !empty($userCanCreateSubcontractInvoice) || !empty($userCanManageSubcontractInvoice) ||
  		 !empty($userCanViewSubcontractInvoice)}
  		<div class="panel panel-default" style="width: 135%;">
  			<div class="panel-body">
	  			<table class="tableborder table-bordered " cellpadding="5" cellspacing="0" width="100%">
					<thead>
						<tr  style="background-color: #e6e6e6;">
			            	<th {if !empty($userCanManageSubcontractInvoice)} colspan="16" {else}  colspan="14" {/if} class="textAlignLeft">
			            		Pending funding			            		
			            	</th>
			            </tr>
			            <tr class="table-headerinner">
			            			<th>Cost Code</th>
							<th>Company</th>
							<th><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB"> Customer:Project</th>
							<th style="width: 200px;">Invoice Files</th>
							<th>Rec'd</th>
							<th>App #</th>
							<th>Period To</th>
							<th>SC Amount</th>
							<th>Retention</th>
							<th>Invoice Total</th>
							<th>Rel. Recv.</th>
							<th>Supplier</th>
							<th>Supplier Amount</th>
							<th>Contract Remaining</th>
							<th>Notes (Displayed to Sub)</th>
							<th>PM Approved</th>
							{if !empty($userCanManageSubcontractInvoice)}
							<th>Sync</th>
							{/if}
							<th>Status</th>
							{if !empty($userCanManageSubcontractInvoice)}
							<th></th>
							{/if}
						</tr>
					</thead>
					<tbody id="invoice_body_SecTwo">
						{$get_subcont_invoice_SecTwo}
					</tbody>
				</table>
  			</div>
		</div>
		{/if}

	</div>
	<div id="divModalWindow"  class="modal">
		<div class="modal-content" style="width:80%">
    		<div class="modal-header">
      			<span class="close" onclick="dashboardmodalClose();">&times;</span>
      			<h3 id="model-title">invoice</h3>
    		</div>
    		<div class="modal-body" id="filePreview" style="padding:16px; height: 600px; overflow-y: auto;">
    			
    		</div>
		</div>
    </div>
    <div id="dialog-confirmation"></div>
	{/if}
</div> 
