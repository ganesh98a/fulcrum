<?php /* Smarty version Smarty-3.0.8, created on 2022-06-22 08:23:15
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-report-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2773062b2b553b2f3b8-19813333%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46286e1e2e97b2a715f614e0ac8edcfb108b81fd' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-report-form.tpl',
      1 => 1655296556,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2773062b2b553b2f3b8-19813333',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
<?php }else{ ?>
<div class="headerStyle">Manage Reports : Generate and view reports as HTML / PDF</div>

<div class="divflex">


	<input type="hidden" id="projectName" name="projectName" value="<?php echo $_smarty_tpl->getVariable('projectName')->value;?>
">
	<input type="hidden" id="report_name" name="report_name" value="">
	<input type="hidden" id="project_id" name="project_id" value="
	<?php echo $_smarty_tpl->getVariable('project_id')->value;?>
">
	<input type="hidden" id="tilldate" name="tilldate" value="<?php echo $_smarty_tpl->getVariable('tilldate')->value;?>
">
	<input type="hidden" id="projectcreateddate" name="projectcreateddate" value="<?php echo $_smarty_tpl->getVariable('projectcreateddate')->value;?>
">
	<input type="hidden" id="delayFirstProject" name="delayFirstProject" value="<?php echo $_smarty_tpl->getVariable('delayFirstProject')->value;?>
">
				<div class="inline">
					<p>Select a Report</p>
					<h4><?php $_template = new Smarty_Internal_Template("dropdown-report-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?></h4>
					<div class="changechk" style="display: none;padding-top: 5px;padding-bottom:10px;float: left;width: 500px;"><input type="checkbox" name="despco" id="despco"> Description
					<span style="padding: 0 10px;"><input type="checkbox" name="showChangeOrderReject" id="showChangeOrderReject"> Show Rejected</span>
					<span style="padding: 0 10px;" id="showChangeOrderCost"><input type="checkbox" name="showChangeOrderCostCodeAmount" id="showChangeOrderCostCodeAmount"> Show Costcode and Amount</span>
					</div>

					<div class="SCOchk" style="display: none;padding-top: 5px;padding-bottom:10px;float: left;">
					<span><input type="checkbox" name="in_potential" id="in_potential"> Include Potential</span>
					</div>

					<div class="BuyoutLogchk" style="display: none;padding-top: 5px;padding-bottom:10px;float: left;width:500px;">
						<input type="checkbox" name="buyoutlog_sub_amt" id="buyoutlog_sub_amt"> Include Subcontract Amount
						<input type="checkbox" name="buyoutlog_cc_alias" id="buyoutlog_cc_alias" style="margin-left: 10px;"> Cost Code Alias
					</div>

					<div class="BuyoutSummarychk" style="display: none;padding-top: 5px;padding-bottom:10px;float: left;">
						<input type="checkbox" name="buyoutlog_cc_alias" id="buyoutSum_cc_alias"> Cost Code Alias
					</div>

				</div>
	
				<div class="inline particularDate">
					<p>Select a Report Date</p>
					<h4>
						<div class="datepicker_style_particular">
							<input id="date" class="dcrdatepicker cus_date_report particular_date_report" type="text" placeholder="Pick a Date" onchange="hidedate();" value="<?php echo $_smarty_tpl->getVariable('today')->value;?>
"><img class="datepicker datedivseccal_icon_gk" width="13" alt="" src="./images/cal.png">
						</div>

					</h4>
				</div>
				<div class="inline commonDate">
					<p>Select a Report From Date</p>
					<h4>
						<div class="datepicker_style_custom">
							<?php if (($_smarty_tpl->getVariable('delayFirstProject')->value!='')){?>
							<input id="bdate" class="datepicker cus_date_report" type="text" readonly="readonly" placeholder="Pick a Date" onchange="hidedate();" value="<?php echo $_smarty_tpl->getVariable('delayFirstProject')->value;?>
"><img class="datepicker datedivseccal_icon_gk" width="13" alt="" src="./images/cal.png">
							<?php }else{ ?>
							<input id="bdate" class="datepicker cus_date_report" type="text" readonly="readonly" placeholder="Pick a Date" onchange="hidedate();" value="<?php echo $_smarty_tpl->getVariable('tilldate')->value;?>
"><img class="datepicker datedivseccal_icon_gk" width="13" alt="" src="./images/cal.png">
							<?php }?>
						</div>

					</h4>
				</div>
				<div class="crntBgtChkGrp inline" style="margin-top: 60px;  display: none; width: 200px;">
					<input type="checkbox" name="crntBgt_val_only" id="crntBgt_val_only" checked class="vectorcheckbox" style="margin-left: 10px;"> Rows With Values Only <br/>
					<input type="checkbox" name="crntBgtNotes" id="crntBgtNotes" class="vectorcheckbox" style="margin-left: 10px;"> Include Notes  
				</div>
				<div class="crntBgtChkGrp inline" style="margin-top: 60px;  display: none; width: 160px;">
					<input type="checkbox" name="crntBgt_sub_total" id="crntBgt_sub_total" class="vectorcheckbox" style="margin-left: 10px;"> Sub total <br/>
					<input type="checkbox" name="crntBgt_cc_alias" id="crntBgt_cc_alias" class="vectorcheckbox" style="margin-left: 10px;"> Cost Code Alias
				</div>
				<div class="changechkgrp inline" style="margin-top: 45px;  display: none; width: 240px;margin-bottom: 15px;">
					<input type="checkbox" name="grouprowval" id="grouprowval" checked class="vectorcheckbox"> Rows With Values Only <br/>
					<input type="checkbox" name="groupco" id="groupco" checked class="vectorcheckbox"> Include Division Grouping <br/>
					<input type="checkbox" name="generalco" id="generalco" class="vectorcheckbox"> General Conditions Summary Only
				</div>
				<div class="changechkgrp inline" style="margin-top: 45px;  display: none; width: 130px;margin-bottom: 15px;">
					<input type="checkbox" name="inotes" id="inotes" class="vectorcheckbox"> Include Notes <br/>
					<input type="checkbox" name="vector_sub_total" id="vector_sub_total" class="vectorcheckbox"> Sub total <br/>
					<input type="checkbox" name="vector_cc_alias" id="vector_cc_alias" class="vectorcheckbox"> Cost Code Alias
				</div>
				<div class="inline commonDate">
					<p>Select a Report To Date</p>
					<h4>
						<div class="datepicker_style_custom">
							<input id="edate" class="datepicker cus_date_report" type="text"  readonly="readonly" placeholder="Pick a Date" onchange="hidedate();" value="<?php echo $_smarty_tpl->getVariable('today')->value;?>
"><img class="datepicker datedivseccal_icon_gk1" width="13" alt="" src="./images/cal.png">
						</div>
						</h4>
					</div>
					<div class="inline reallocation" style="display:none;">
						<p>Filter On Draw Id</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlreallocationStatus')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline reallocation" style="margin-top:60px;width:160px;display:none;">
						<input type="checkbox" name="cost_code_alias" id="cost_code_alias" class="vectorcheckbox" style="margin-left: 10px;"> Cost Code Alias
					</div>
					<div class="inline bidlist" style="display:none;">
						<p>Filter On Status</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlSubcontractorBidStatuses')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline submittalStatuslist" style="display:none;">
						<p>Filter On Status</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlSubmittalStatuses')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline delayStatuslist" style="display:none;">
						<p>Filter On Status</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlDelayStatuses')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline requestForInformationStatuslist" style="display:none;">
						<p>Filter On Status</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlrequestForInformationStatus')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline subcontract_inv" style="display:block;">
						<p>Filter On Status</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlsubinvStatus')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline bidlist" style="display:none;">
						<p>Sort By</p>
						<h4>
							<div class="">
								<select id="ddlSortBy" class="fullWidth">
									<option value="" selected disabled>Select</option>
									<option value="cost_code_division_id,company,cost_code">Company, Cost Code</option>
									<option value="cost_code_division_id,cost_code,company">Cost Code, Company</option>
									<option value="cost_code_division_id,cost_code,bid_total">Cost Code, Bid Amount</option>
									<option value="cost_code_division_id,cost_code,email">Email</option>
								</select>
							</div>
						</h4>
					</div>
					<div class="inline subcontractor"  style="display: none;">
						<p>Select Company</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('vendorCompany')->value;?>

							</div>
						</h4>
						<input type="hidden" name="qb_customer" id="qb_customer" value="<?php echo $_smarty_tpl->getVariable('qb_customer')->value;?>
">
					</div>
					<div class="inline subcontractor"   style="display: none;">
						<p>Select Costcode Name</p>
						<h4>
							<div class="" id="costCodeHtml">
								<?php echo $_smarty_tpl->getVariable('costCodeDesc')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline co_rt" style="display:none;">
						<p>CO View</p>
						<h4>
							<div class="">
								<select id="view_status"  style="margin-bottom:15px;width:230px;">
									<option value="costcode" selected="">default view</option>
									<option value="subcontractor">costcode view</option>
								</select>							</div>
						</h4>
					</div>
					<div class="inline co_rt" style="display:none;">
						<p>Filter On type</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlCoTypes')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline MT_rt" style="display:none;">
						<p>Meeting Type</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlMeetingTypes')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline MT_rt" style="display:none;">
						<p>Meetings</p>
						<h4>
							<div class="">
								<?php echo $_smarty_tpl->getVariable('ddlMeetings')->value;?>

							</div>
						</h4>
					</div>
					<div class="inline SCO_rt" style="display:none;">
						<p>SCO View</p>
						<h4>
							<div class="">
								<select id="sview_status"  style="margin-bottom:15px;width:230px;">
									<option value="costcode">costcode view</option>
									<option value="subcontractor">subcontractor view</option>
								</select>							</div>
						</h4>
					</div>
					<div class="inline SCO_rt" style="display:none;">
						<p>SCO Filter</p>
						<h4>
							<div class="">
								<select id="sco_filter"  style="margin-bottom:15px;width:230px;">
									<option value="all">All</option>
									<option value="potential">Potential</option>
									<option value="approved">Approved</option>
								</select>
							</div>
						</h4>
					</div>
					<div class="inline">
						<p>Select a Report View</p>
						<h4 class="line-height-30">
							<label class="radio_gp">
								<input type="radio" name="ReportOption" value="Html" checked>&nbsp;HTML &nbsp;</label>
								<label class="radio_gp hidden_pdfradio" <?php echo $_smarty_tpl->getVariable('pdfstyle')->value;?>
>
									<input type="radio" name="ReportOption" value="PDF">&nbsp;PDF</label>
				<!-- <label class="radio_gp hidden_csvradio">
					<input type="radio" name="ReportOption" value="CSV">&nbsp;CSV</label>
				</h4> -->
				<label class="radio_gp hidden_xlsxradio" <?php echo $_smarty_tpl->getVariable('xlsxstyle')->value;?>
>
					<input type="radio" name="ReportOption" value="XLSX">&nbsp;XLSX</label>
					<div class="envelop" style="display: none;padding-top: 5px;float: left;">
					<span id="emailData" class="emailData btn entypo entypo-click entypo-mail popoverButton " data-toggle="popover" data-placement="bottom" data-original-title="" title="" onclick="openpopover()" ></span></div>

					<div id="divemailcontentforbidPopover" class="hidden"></div>
				<div id="emaildataforcopy" class="hidden"></div>

				</h4>
			</div>
			<div class="inline" style="margin:0;">
				<p class="hidden_label">Select a Report View</p>
				<h4><input type="button" value="Generate Report" onclick="GenerateReport('<?php echo $_smarty_tpl->getVariable('project_id')->value;?>
')"></h4>
			</div>
		</div>
	</div>
	<div id="Delays_html" class="custom_delay_padding"></div>
	<?php }?>
